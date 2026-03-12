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

        $q = Booking::where('business_id', $businessId)->with(['service', 'services', 'staff', 'branch']);

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

        $booking->load('service', 'services', 'business', 'staff', 'branch');

        // Mark notification as read if coming from notification
        if ($request->has('notification')) {
            $notification = $request->user()->notifications()->find($request->get('notification'));
            if ($notification && !$notification->read_at) {
                $notification->markAsRead();
            }
        }

        $staffMembers = [];
        if ($request->user()->role === 'company_admin') {
            $staffMembers = \App\Models\User::where('business_id', $request->user()->business_id)
                ->whereIn('role', ['staff', 'company_admin'])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'title']);
        }

        return view('admin.bookings.show', compact('booking', 'staffMembers'));
    }

    public function reassignStaff(Request $request, Booking $booking)
    {
        abort_if($booking->business_id !== $request->user()->business_id, 403);
        abort_if($request->user()->role !== 'company_admin', 403);

        $data = $request->validate([
            'staff_user_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        // Ensure the chosen staff belongs to this business
        if (!empty($data['staff_user_id'])) {
            $belongs = \App\Models\User::where('id', $data['staff_user_id'])
                ->where('business_id', $booking->business_id)
                ->exists();
            abort_if(!$belongs, 422, 'Invalid staff member.');
        }

        $booking->update(['staff_user_id' => $data['staff_user_id'] ?? null]);

        return back()->with('success', 'Staff reassigned successfully.');
    }

    public function export(Request $request)
    {
        $user       = $request->user();
        $businessId = $user->business_id;
        abort_if(!$businessId, 403);
        abort_if($user->role !== 'company_admin', 403);

        $filter   = $request->get('filter', 'all');
        $timezone = $user->business->timezone ?? 'Asia/Muscat';
        $today    = Carbon::now($timezone)->toDateString();

        $q = Booking::where('business_id', $businessId)
            ->with(['services', 'staff', 'branch']);

        if ($filter === 'today') {
            $q->where('booking_date', $today);
        } elseif ($filter === 'upcoming') {
            $q->where('booking_date', '>=', $today)
              ->whereIn('status', ['pending', 'confirmed']);
        }

        $bookings = $q->orderBy('booking_date')->orderBy('start_time')->get();

        $filename = 'bookings-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($bookings) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8 compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Reference', 'Date', 'Start Time', 'End Time',
                'Services', 'Duration (min)', 'Branch',
                'Customer Name', 'Customer Phone', 'Customer Email',
                'Staff', 'Status', 'Walk-In', 'Notes', 'Created At',
            ]);

            foreach ($bookings as $b) {
                fputcsv($handle, [
                    $b->reference_code,
                    $b->booking_date,
                    substr($b->start_time, 0, 5),
                    substr($b->end_time, 0, 5),
                    $b->services_label,
                    $b->total_duration,
                    $b->branch?->name ?? '',
                    $b->customer_name,
                    $b->customer_phone,
                    $b->customer_email ?? '',
                    $b->staff?->name ?? '',
                    $b->status,
                    $b->is_walk_in ? 'Yes' : 'No',
                    $b->customer_notes ?? '',
                    $b->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
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
