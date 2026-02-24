<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $businessId = $request->user()->business_id;
        abort_if(!$businessId, 403);

        $timezone = $request->user()->business->timezone ?? 'Asia/Muscat';
        $today = Carbon::now($timezone)->toDateString();

        $filter = $request->get('filter', 'upcoming'); // today|upcoming|all

        $q = Booking::where('business_id', $businessId)->with(['service', 'staff']);

        // Staff members can only see bookings assigned to them
        if ($request->user()->role === 'staff') {
            $q->where('staff_user_id', $request->user()->id);
        }

        if ($filter === 'today') {
            $q->where('booking_date', $today);
        } elseif ($filter === 'upcoming') {
            $q->where('booking_date', '>=', $today)
              ->whereIn('status', ['pending', 'confirmed']);
        }

        $bookings = $q->orderBy('booking_date')
            ->orderBy('start_time')
            ->paginate(30)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'filter', 'today'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        abort_if($booking->business_id !== $request->user()->business_id, 403);

        // Staff members can only update bookings assigned to them
        if ($request->user()->role === 'staff') {
            abort_if($booking->staff_user_id !== $request->user()->id, 403, 'You can only update bookings assigned to you.');
        }

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
        ]);

        $booking->update($data);

        return back()->with('success', 'Booking status updated.');
    }

    public function show(Request $request, Booking $booking)
    {
        abort_if($booking->business_id !== $request->user()->business_id, 403);

        // Staff members can only view bookings assigned to them
        if ($request->user()->role === 'staff') {
            abort_if($booking->staff_user_id !== $request->user()->id, 403, 'You can only view bookings assigned to you.');
        }

        $booking->load('service', 'business', 'staff');

        // Mark notification as read if coming from notification
        if ($request->has('notification')) {
            $notification = $request->user()->notifications()->find($request->get('notification'));
            if ($notification && !$notification->read_at) {
                $notification->markAsRead();
            }
        }

        return view('admin.bookings.show', compact('booking'));
    }

    public function markReminderSent(Request $request, Booking $booking)
    {
        abort_if($booking->business_id !== $request->user()->business_id, 403);

        // Staff members can only mark reminders for bookings assigned to them
        if ($request->user()->role === 'staff') {
            abort_if($booking->staff_user_id !== $request->user()->id, 403, 'You can only manage bookings assigned to you.');
        }

        $booking->update([
            'reminder_sent_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reminder marked as sent',
            'sent_at' => $booking->reminder_sent_at->diffForHumans(),
        ]);
    }
}
