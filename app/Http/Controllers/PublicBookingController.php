<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewBookingNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        
        $services = $business->services()->where('is_active', true)->orderBy('name')->get();

        abort_if($services->isEmpty(), 404);

        return view('public.business', compact('business', 'services'));
    }

    public function slots(Request $request, $businessSlug, $serviceId)
    {
        $business = Business::where('slug', $businessSlug)->firstOrFail();
        
        // Check if business has an active license
        $license = $business->license;
        if (!$license || !$license->isActive()) {
            return response()->json(['error' => 'This business is currently unavailable for bookings.'], 403);
        }
        
        $service = Service::where('id', $serviceId)
            ->where('business_id', $business->id)
            ->firstOrFail();

        return $this->getSlots($request, $business, $service);
    }

    public function businessPage(Business $business)
    {
        $services = $business->services()->where('is_active', true)->orderBy('name')->get();

        abort_if($services->isEmpty(), 404);

        return view('public.business', compact('business', 'services'));
    }

    public function getSlots(Request $request, Business $business, Service $service)
    {
        abort_if($service->business_id !== $business->id, 404);

        $data = $request->validate([
            'date' => ['required', 'date'],
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

        if (!$wh || $wh->is_closed || !$wh->start_time || !$wh->end_time) {
            return response()->json(['slots' => []]);
        }

        $duration = (int) $service->duration_minutes;
        $interval = 30; // MVP slot interval

        $start = Carbon::parse($date->toDateString().' '.$wh->start_time, $business->timezone);
        $end   = Carbon::parse($date->toDateString().' '.$wh->end_time, $business->timezone);

        // Get all staff members for this business
        $staffMembers = User::where('business_id', $business->id)
            ->whereIn('role', ['staff', 'company_admin'])
            ->where('is_active', true)
            ->get(['id', 'name']);

        if ($staffMembers->isEmpty()) {
            return response()->json(['slots' => [], 'staff' => []]);
        }

        // Get existing bookings for the day for these staff members
        $existing = Booking::whereIn('staff_user_id', $staffMembers->pluck('id'))
            ->where('booking_date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['staff_user_id', 'start_time', 'end_time']);

        $slotsWithStaff = [];

        for ($t = $start->copy(); $t->copy()->addMinutes($duration)->lte($end); $t->addMinutes($interval)) {
            $slotStart = $t->format('H:i');
            $slotEnd = $t->copy()->addMinutes($duration)->format('H:i');

            // If booking is today, don’t allow past time slots
            if ($date->isSameDay(Carbon::now($business->timezone))) {
                if ($t->lt(Carbon::now($business->timezone)->addMinutes(10))) {
                    continue;
                }
            }

            // Find available staff for this slot
            $availableStaff = [];
            foreach ($staffMembers as $staff) {
                $staffBookings = $existing->where('staff_user_id', $staff->id);
                
                // Check if this staff member has overlap
                $hasOverlap = $staffBookings->first(function ($b) use ($slotStart, $slotEnd) {
                    return !($slotEnd <= $b->start_time || $slotStart >= $b->end_time);
                });

                if (!$hasOverlap) {
                    $availableStaff[] = [
                        'id' => $staff->id,
                        'name' => $staff->name,
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

        return response()->json([
            'slots' => $slotsWithStaff,
            'staff' => $staffMembers->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values()
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
        
        // Check if business has an active license
        $license = $business->license;
        if (!$license || !$license->isActive()) {
            return back()->withErrors(['error' => 'This business is currently unavailable for bookings.']);
        }

        $data = $request->validate([
            'service_id' => ['required', 'integer'],
            'staff_user_id' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_country' => ['nullable', 'in:OM,SA'],
            'customer_phone' => ['required', 'string', 'max:30'],
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
        abort_if(!$wh || $wh->is_closed, 422);

        $whStart = Carbon::parse($date.' '.$wh->start_time, $business->timezone);
        $whEnd   = Carbon::parse($date.' '.$wh->end_time, $business->timezone);

        abort_if($start->lt($whStart) || $end->gt($whEnd), 422);

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
                'service_id' => $service->id,
                'staff_user_id' => $selectedStaff->id,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_country' => $data['customer_country'] ?? null,
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
        $booking->load('service', 'staff');

        // Notify the assigned staff member
        $selectedStaff->notify(new NewBookingNotification($booking));

        // Also notify company admins
        $companyAdmins = User::where('business_id', $business->id)
            ->where('role', 'company_admin')
            ->where('is_active', true)
            ->where('id', '!=', $selectedStaff->id) // Don't notify twice if staff is also admin
            ->get();

        foreach ($companyAdmins as $admin) {
            $admin->notify(new NewBookingNotification($booking));
        }

        return redirect()->route('public.success', [$business->slug, $booking->id]);
    }

    public function success($businessSlug, $bookingId)
    {
        $business = Business::where('slug', $businessSlug)->firstOrFail();
        $booking = Booking::where('business_id', $business->id)
            ->where('id', $bookingId)
            ->with('service')
            ->firstOrFail();

        return view('public.success', compact('business', 'booking'));
    }
}