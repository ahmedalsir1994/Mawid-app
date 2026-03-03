<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use App\Models\User;
use App\Mail\BookingConfirmationMail;
use App\Mail\StaffBookingNotificationMail;
use App\Notifications\NewBookingNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PublicBookingController extends Controller
{
    public function show(Request $request, $businessSlug)
    {
        $business = Business::where('slug', $businessSlug)->firstOrFail();
        
        // Check if business has an active license
        $license = $business->license;
        if (!$license || !$license->isActive()) {
            abort(403, 'This business is currently unavailable for bookings.');
        }

        $bookingLimitReached = !$license->canAcceptBookingThisMonth();

        $services = $business->services()->where('is_active', true)->orderBy('name')->with('images')->get();

        abort_if($services->isEmpty(), 404);

        $branches = $business->branches()->where('is_active', true)->with('services')->get();

        $teamMembers = User::where('business_id', $business->id)
            ->whereIn('role', ['staff', 'company_admin'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'title', 'photo']);

        return view('public.business', compact('business', 'services', 'branches', 'teamMembers', 'bookingLimitReached'));
    }

    public function slots(Request $request, $businessSlug, $serviceId)
    {
        $business = Business::where('slug', $businessSlug)->firstOrFail();
        
        // Check if business has an active license
        $license = $business->license;
        if (!$license || !$license->isActive()) {
            return response()->json(['error' => 'This business is currently unavailable for bookings.'], 403);
        }

        // Monthly booking limit check (free plan: 25/month)
        if (!$license->canAcceptBookingThisMonth()) {
            return response()->json(['slots' => [], 'reason' => 'limit_reached']);
        }

        $service = Service::where('id', $serviceId)
            ->where('business_id', $business->id)
            ->firstOrFail();

        return $this->getSlots($request, $business, $service);
    }

    public function businessPage(Business $business)
    {
        $services = $business->services()->where('is_active', true)->orderBy('name')->with('images')->get();

        abort_if($services->isEmpty(), 404);

        $branches = $business->branches()->where('is_active', true)->with('services')->get();

        $teamMembers = User::where('business_id', $business->id)
            ->whereIn('role', ['staff', 'company_admin'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'title', 'photo']);

        return view('public.business', compact('business', 'services', 'branches', 'teamMembers'));
    }

    public function getSlots(Request $request, Business $business, Service $service)
    {
        abort_if($service->business_id !== $business->id, 404);

        $data = $request->validate([
            'date' => ['required', 'date'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
        ]);

        $date = Carbon::parse($data['date'], $business->timezone)->startOfDay();

        // 1) Reject if date is in the past
        if ($date->lt(Carbon::now($business->timezone)->startOfDay())) {
            return response()->json(['slots' => []]);
        }

        // 2) Reject if in time off range
        $isTimeOff = $business->timeOff()
            ->whereDate('start_date', '<=', $date->toDateString())
            ->whereDate('end_date', '>=', $date->toDateString())
            ->exists();

        if ($isTimeOff) {
            return response()->json(['slots' => []]);
        }

        // 3) Get working hours for day of week
        $dow = (int) $date->dayOfWeek; // 0=Sun..6=Sat
        $wh = $business->workingHours()->where('day_of_week', $dow)->first();

        if (!$wh || $wh->is_closed || !$wh->first_shift_start || !$wh->first_shift_end) {
            return response()->json(['slots' => []]);
        }

        $duration = (int) $service->duration_minutes;
        $interval = 15; // 15-minute grid — all durations must be multiples of 15

        // Build shift windows: first shift always present, second shift optional
        $shifts = [
            [
                Carbon::parse($date->toDateString().' '.$wh->first_shift_start, $business->timezone),
                Carbon::parse($date->toDateString().' '.$wh->first_shift_end,   $business->timezone),
            ],
        ];
        if ($wh->second_shift_start && $wh->second_shift_end) {
            $shifts[] = [
                Carbon::parse($date->toDateString().' '.$wh->second_shift_start, $business->timezone),
                Carbon::parse($date->toDateString().' '.$wh->second_shift_end,   $business->timezone),
            ];
        }

        // Get all staff members for this business (optionally filtered by branch)
        $staffQuery = User::where('business_id', $business->id)
            ->whereIn('role', ['staff', 'company_admin'])
            ->where('is_active', true);

        if (!empty($data['branch_id'])) {
            $staffQuery->where(function ($q) use ($data) {
                $q->where('branch_id', $data['branch_id'])
                  ->orWhereNull('branch_id');
            });
        }

        $staffMembers = $staffQuery->get(['id', 'name', 'title', 'photo']);

        if ($staffMembers->isEmpty()) {
            return response()->json(['slots' => [], 'staff' => []]);
        }

        // Get existing bookings for the day — pre-parse times once to avoid
        // repeated Carbon::parse() inside the O(slots × staff × bookings) loop.
        $rawBookings = Booking::whereIn('staff_user_id', $staffMembers->pluck('id'))
            ->where('booking_date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['staff_user_id', 'start_time', 'end_time']);

        $parsedBookings = $rawBookings->map(fn ($b) => [
            'staff_user_id' => $b->staff_user_id,
            'start'         => Carbon::parse($b->start_time)->startOfMinute(),
            'end'           => Carbon::parse($b->end_time)->startOfMinute(),
        ]);

        $slotsWithStaff = [];

        foreach ($shifts as [$shiftStart, $shiftEnd]) {
        for ($t = $shiftStart->copy(); $t->copy()->addMinutes($duration)->lte($shiftEnd); $t->addMinutes($interval)) {
            $slotStart = $t->format('H:i');
            $slotEnd = $t->copy()->addMinutes($duration)->format('H:i');

            // If booking is today, don’t allow past time slots
            if ($date->isSameDay(Carbon::now($business->timezone))) {
                if ($t->lt(Carbon::now($business->timezone)->addMinutes(10))) {
                    continue;
                }
            }

            $slotS = Carbon::createFromFormat('H:i', $slotStart)->startOfMinute();
            $slotE = Carbon::createFromFormat('H:i', $slotEnd)->startOfMinute();

            $availableStaff = [];
            foreach ($staffMembers as $staff) {
                // Check if this staff member has overlap
                $hasOverlap = $parsedBookings->where('staff_user_id', $staff->id)->first(function ($b) use ($slotS, $slotE) {
                    return !($slotE->lte($b['start']) || $slotS->gte($b['end']));
                });

                if (!$hasOverlap) {
                    $availableStaff[] = [
                        'id'    => $staff->id,
                        'name'  => $staff->name,
                        'photo' => $staff->photo ? asset($staff->photo) : null,
                        'title' => $staff->title,
                    ];
                }
            }

            // Only include slots that have at least one available staff
            if (!empty($availableStaff)) {
                $slotsWithStaff[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                    'label' => $slotStart,
                    'available_staff' => $availableStaff,
                ];
            }
        }
        } // end foreach shifts

        return response()->json([
            'slots' => $slotsWithStaff,
            'staff' => $staffMembers->map(fn($s) => [
                'id'    => $s->id,
                'name'  => $s->name,
                'photo' => $s->photo ? asset($s->photo) : null,
                'title' => $s->title,
            ])->values()
        ]);
    }

    public function store(Request $request, $businessSlug)
    {
        $business = Business::where('slug', $businessSlug)->firstOrFail();
        
        // Check if business has an active license
        $license = $business->license;
        if (!$license || !$license->isActive()) {
            return back()->withErrors(['error' => 'This business is currently unavailable for bookings.']);
        }

        // Monthly booking limit check (free plan: 25/month)
        if (!$license->canAcceptBookingThisMonth()) {
            return back()->withErrors(['error' => 'This business has reached its online booking limit for this month. Please contact the business directly to schedule an appointment.']);
        }

        $data = $request->validate([
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'service_id' => ['required', 'integer'],
            'staff_user_id' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_country' => ['nullable', 'in:OM,SA'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['required', 'email', 'max:180'],
            'customer_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $service = Service::where('id', $data['service_id'])
            ->where('business_id', $business->id)
            ->where('is_active', true)
            ->firstOrFail();

        $date = Carbon::parse($data['date'], $business->timezone)->toDateString();

        $start = Carbon::parse($date.' '.$data['start_time'], $business->timezone);
        $end = $start->copy()->addMinutes((int)$service->duration_minutes);

        // Prevent booking on time off
        $isTimeOff = $business->timeOff()
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->exists();
        abort_if($isTimeOff, 422);

        // Prevent booking outside working hours / closed
        $dow = (int) Carbon::parse($date, $business->timezone)->dayOfWeek;
        $wh = $business->workingHours()->where('day_of_week', $dow)->first();
        abort_if(!$wh || $wh->is_closed || !$wh->first_shift_start || !$wh->first_shift_end, 422);

        // Check that the slot falls within at least one defined shift
        $withinShift = false;
        $shifts = [
            [$wh->first_shift_start, $wh->first_shift_end],
        ];
        if ($wh->second_shift_start && $wh->second_shift_end) {
            $shifts[] = [$wh->second_shift_start, $wh->second_shift_end];
        }
        foreach ($shifts as [$shiftStartTime, $shiftEndTime]) {
            $shiftStart = Carbon::parse($date.' '.$shiftStartTime, $business->timezone);
            $shiftEnd   = Carbon::parse($date.' '.$shiftEndTime,   $business->timezone);
            if ($start->gte($shiftStart) && $end->lte($shiftEnd)) {
                $withinShift = true;
                break;
            }
        }
        abort_if(!$withinShift, 422);

        // Verify selected staff is valid and available
        $selectedStaff = User::where('id', $data['staff_user_id'])
            ->where('business_id', $business->id)
            ->whereIn('role', ['staff', 'company_admin'])
            ->where('is_active', true)
            ->first();

        if (!$selectedStaff) {
            return back()->withErrors([
                'staff_user_id' => 'Selected staff member is not available.'
            ])->withInput();
        }

        // Check if selected staff is available for this time slot
        $hasOverlap = Booking::where('staff_user_id', $selectedStaff->id)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<=', $start->format('H:i:s'))
                      ->where('end_time', '>', $start->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '<', $end->format('H:i:s'))
                      ->where('end_time', '>=', $end->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '>=', $start->format('H:i:s'))
                      ->where('end_time', '<=', $end->format('H:i:s'));
                });
            })
            ->exists();

        if ($hasOverlap) {
            return back()->withErrors([
                'start_time' => 'Selected staff member is no longer available for this time. Please choose another staff or time.'
            ])->withInput();
        }

        // DB-level protection from double booking
        $reference = strtoupper(Str::random(8));

        try {
            $booking = Booking::create([
                'business_id' => $business->id,
                'branch_id' => $data['branch_id'] ?? null,
                'service_id' => $service->id,
                'staff_user_id' => $selectedStaff->id,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'customer_country' => $data['customer_country'] ?? null,
                'customer_notes' => $data['customer_notes'] ?? null,
                'booking_date' => $date,
                'start_time' => $start->format('H:i'),
                'end_time' => $end->format('H:i'),
                'status' => 'pending',
                'reference_code' => $reference,
            ]);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withErrors([
                'start_time' => 'This time slot is no longer available. Please select a different time.'
            ])->withInput();
        }

        // Load the service relationship for notification
        $booking->load('service', 'staff', 'branch');

        // Send booking confirmation email to customer
        if (!empty($data['customer_email'])) {
            try {
                Mail::to($data['customer_email'])->send(new BookingConfirmationMail($booking, $business));
            } catch (\Exception $e) {
                // Don't fail the booking if email fails — log it silently
                \Log::warning('Booking confirmation email failed: ' . $e->getMessage());
            }
        }

        // Notify the assigned staff member (database + email)
        $selectedStaff->notify(new NewBookingNotification($booking));
        try {
            Mail::to($selectedStaff->email)->send(new StaffBookingNotificationMail($booking, $business, $selectedStaff));
        } catch (\Exception $e) {
            \Log::warning('Staff booking notification email failed: ' . $e->getMessage());
        }

        // Also notify company admins (database + email)
        $companyAdmins = User::where('business_id', $business->id)
            ->where('role', 'company_admin')
            ->where('is_active', true)
            ->where('id', '!=', $selectedStaff->id) // Don't notify twice if staff is also admin
            ->get();

        foreach ($companyAdmins as $admin) {
            $admin->notify(new NewBookingNotification($booking));
            try {
                Mail::to($admin->email)->send(new StaffBookingNotificationMail($booking, $business, $admin));
            } catch (\Exception $e) {
                \Log::warning('Admin booking notification email failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('public.success', [$business->slug, $booking->id]);
    }

    public function success($businessSlug, $bookingId)
    {
        $business = Business::where('slug', $businessSlug)->firstOrFail();
        $booking = Booking::where('business_id', $business->id)
            ->where('id', $bookingId)
            ->with(['service', 'branch', 'staff'])
            ->firstOrFail();

        return view('public.success', compact('business', 'booking'));
    }
}
