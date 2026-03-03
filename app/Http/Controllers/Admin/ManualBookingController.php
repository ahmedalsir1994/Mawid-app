<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationMail;
use App\Mail\StaffBookingNotificationMail;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewBookingNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManualBookingController extends Controller
{
    /**
     * Show the walk-in booking creation form.
     */
    public function create(Request $request)
    {
        $user     = $request->user();
        $business = $user->business;
        abort_if(!$business, 403);

        $services = $business->services()->where('is_active', true)->orderBy('name')->get();
        $branches = $business->branches()->where('is_active', true)->orderBy('name')->get();

        // Staff members can only assign themselves
        if ($user->role === 'staff') {
            $staffMembers = User::where('id', $user->id)->get(['id', 'name', 'title', 'photo']);
        } else {
            $staffMembers = User::where('business_id', $business->id)
                ->whereIn('role', ['staff', 'company_admin'])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'title', 'photo']);
        }

        $indexRoute = $user->role === 'staff' ? 'admin.staff.bookings.index' : 'admin.bookings.index';

        return view('admin.bookings.create', compact('business', 'services', 'branches', 'staffMembers', 'indexRoute'));
    }

    /**
     * Return available slots as JSON (used by AJAX on the create form).
     * Unlike the public endpoint, past slots are still shown (admins can book walk-ins now).
     */
    public function slots(Request $request)
    {
        $user     = $request->user();
        $business = $user->business;
        abort_if(!$business, 403);

        $data = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'date'       => ['required', 'date'],
            'branch_id'  => ['nullable', 'integer', 'exists:branches,id'],
        ]);

        $service = Service::where('id', $data['service_id'])
            ->where('business_id', $business->id)
            ->firstOrFail();

        $date = Carbon::parse($data['date'], $business->timezone)->startOfDay();

        // Time off check
        $isTimeOff = $business->timeOff()
            ->whereDate('start_date', '<=', $date->toDateString())
            ->whereDate('end_date', '>=', $date->toDateString())
            ->exists();

        if ($isTimeOff) {
            return response()->json(['slots' => [], 'reason' => 'time_off']);
        }

        // Working hours check
        $dow = (int) $date->dayOfWeek;
        $wh  = $business->workingHours()->where('day_of_week', $dow)->first();

        if (!$wh || $wh->is_closed || !$wh->first_shift_start || !$wh->first_shift_end) {
            return response()->json(['slots' => [], 'reason' => 'closed']);
        }

        $duration = (int) $service->duration_minutes;
        $interval = 15; // 15-minute grid — all durations must be multiples of 15

        $shifts = [[
            Carbon::parse($date->toDateString().' '.$wh->first_shift_start, $business->timezone),
            Carbon::parse($date->toDateString().' '.$wh->first_shift_end,   $business->timezone),
        ]];

        if ($wh->second_shift_start && $wh->second_shift_end) {
            $shifts[] = [
                Carbon::parse($date->toDateString().' '.$wh->second_shift_start, $business->timezone),
                Carbon::parse($date->toDateString().' '.$wh->second_shift_end,   $business->timezone),
            ];
        }

        // Build staff query
        if ($user->role === 'staff') {
            $staffMembers = User::where('id', $user->id)->get(['id', 'name', 'title', 'photo']);
        } else {
            $staffQuery = User::where('business_id', $business->id)
                ->whereIn('role', ['staff', 'company_admin'])
                ->where('is_active', true);

            if (!empty($data['branch_id'])) {
                $staffQuery->where(function ($q) use ($data) {
                    $q->where('branch_id', $data['branch_id'])->orWhereNull('branch_id');
                });
            }

            $staffMembers = $staffQuery->get(['id', 'name', 'title', 'photo']);
        }

        if ($staffMembers->isEmpty()) {
            return response()->json(['slots' => [], 'reason' => 'no_staff']);
        }

        // Existing bookings for the day — pre-parse times once to avoid
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

        $now          = Carbon::now($business->timezone);
        $slotsResult  = [];

        foreach ($shifts as [$shiftStart, $shiftEnd]) {
            for ($t = $shiftStart->copy(); $t->copy()->addMinutes($duration)->lte($shiftEnd); $t->addMinutes($interval)) {
                $slotStart = $t->format('H:i');
                $slotEnd   = $t->copy()->addMinutes($duration)->format('H:i');
                $isPast    = $t->lt($now);

                $slotS = Carbon::createFromFormat('H:i', $slotStart)->startOfMinute();
                $slotE = Carbon::createFromFormat('H:i', $slotEnd)->startOfMinute();

                $availableStaff = [];

                foreach ($staffMembers as $staff) {
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

                if (!empty($availableStaff)) {
                    $slotsResult[] = [
                        'start'           => $slotStart,
                        'end'             => $slotEnd,
                        'is_past'         => $isPast,
                        'is_booked'       => false,
                        'available_staff' => $availableStaff,
                    ];
                } else {
                    // All staff are booked — still include the slot so admin can see it's taken
                    $slotsResult[] = [
                        'start'           => $slotStart,
                        'end'             => $slotEnd,
                        'is_past'         => $isPast,
                        'is_booked'       => true,
                        'available_staff' => [],
                    ];
                }
            }
        }

        return response()->json(['slots' => $slotsResult]);
    }

    /**
     * Save the walk-in booking.
     */
    public function store(Request $request)
    {
        $user     = $request->user();
        $business = $user->business;
        abort_if(!$business, 403);

        $data = $request->validate([
            'service_id'     => ['required', 'integer', 'exists:services,id'],
            'staff_user_id'  => ['required', 'integer', 'exists:users,id'],
            'branch_id'      => ['nullable', 'integer', 'exists:branches,id'],
            'date'           => ['required', 'date'],
            'start_time'     => ['required', 'date_format:H:i'],
            'customer_name'  => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:180'],
            'customer_notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Verify service belongs to this business
        $service = Service::where('id', $data['service_id'])
            ->where('business_id', $business->id)
            ->firstOrFail();

        // Staff can only create bookings assigned to themselves
        if ($user->role === 'staff' && (int) $data['staff_user_id'] !== $user->id) {
            return back()->withErrors(['staff_user_id' => 'You can only create bookings assigned to yourself.'])->withInput();
        }

        $selectedStaff = User::where('id', $data['staff_user_id'])
            ->where('business_id', $business->id)
            ->firstOrFail();

        $date  = Carbon::parse($data['date'], $business->timezone)->toDateString();
        $start = Carbon::parse($date.' '.$data['start_time'], $business->timezone);
        $end   = $start->copy()->addMinutes((int) $service->duration_minutes);

        // Overlap check — prevents double-booking same as public flow
        $hasOverlap = Booking::where('staff_user_id', $selectedStaff->id)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<=', $start->format('H:i:s'))
                      ->where('end_time',   '>',  $start->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '<',  $end->format('H:i:s'))
                      ->where('end_time',   '>=', $end->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '>=', $start->format('H:i:s'))
                      ->where('end_time',   '<=', $end->format('H:i:s'));
                });
            })
            ->exists();

        if ($hasOverlap) {
            return back()->withErrors([
                'start_time' => 'This staff member already has a booking in this time slot. Please choose a different time.',
            ])->withInput();
        }

        $reference = 'WI-'.strtoupper(Str::random(7));

        $booking = Booking::create([
            'business_id'    => $business->id,
            'branch_id'      => $data['branch_id'] ?? null,
            'service_id'     => $service->id,
            'staff_user_id'  => $selectedStaff->id,
            'customer_name'  => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $data['customer_email'] ?? null,
            'customer_notes' => $data['customer_notes'] ?? null,
            'booking_date'   => $date,
            'start_time'     => $start->format('H:i'),
            'end_time'       => $end->format('H:i'),
            'status'         => 'confirmed', // walk-ins are auto-confirmed
            'reference_code' => $reference,
            'is_walk_in'     => true,
        ]);

        $booking->load('service', 'staff', 'branch');

        // Send confirmation to customer if email provided
        if (!empty($data['customer_email'])) {
            try {
                Mail::to($data['customer_email'])->send(new BookingConfirmationMail($booking, $business));
            } catch (\Exception $e) {
                \Log::warning('Walk-in confirmation email failed: '.$e->getMessage());
            }
        }

        // Notify the assigned staff member (only if someone else created the booking)
        if ($selectedStaff->id !== $user->id) {
            $selectedStaff->notify(new NewBookingNotification($booking));
            try {
                Mail::to($selectedStaff->email)->send(new StaffBookingNotificationMail($booking, $business, $selectedStaff));
            } catch (\Exception $e) {
                \Log::warning('Walk-in staff notification email failed: '.$e->getMessage());
            }
        }

        $indexRoute = $user->role === 'staff' ? 'admin.staff.bookings.index' : 'admin.bookings.index';

        return redirect()
            ->route($indexRoute)
            ->with('success', "Walk-in booking created — {$booking->customer_name} · {$booking->reference_code}");
    }
}
