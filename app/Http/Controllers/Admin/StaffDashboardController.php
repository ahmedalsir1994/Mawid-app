<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $business = $user->business;

        if (!$business) {
            return redirect()->route('landing')
                ->with('error', 'No business associated with this account.');
        }

        // Calendar view parameters
        $view = $request->get('view', 'week'); // Staff primarily needs week view
        $date = $request->get('date', now()->format('Y-m-d'));
        $currentDate = Carbon::parse($date);

        // Staff's personal statistics
        $totalBookings = $business->bookings()->where('staff_user_id', $user->id)->count();
        $todayBookings = $business->bookings()
            ->where('staff_user_id', $user->id)
            ->whereDate('booking_date', today())
            ->count();
        
        $upcomingBookings = $business->bookings()
            ->with(['service', 'services', 'staff'])
            ->where('staff_user_id', $user->id)
            ->where('status', 'confirmed')
            ->whereDate('booking_date', '>=', now())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(10)
            ->get();

        $todayBookingsList = $business->bookings()
            ->with(['service', 'services', 'staff'])
            ->where('staff_user_id', $user->id)
            ->whereDate('booking_date', today())
            ->orderBy('start_time')
            ->get();

        // Calendar data based on view
        $calendarBookings = collect();
        $startDate = null;
        $endDate = null;

        if ($view === 'week') {
            $startDate = $currentDate->copy()->startOfWeek();
            $endDate = $currentDate->copy()->endOfWeek();
        } elseif ($view === 'month') {
            $startDate = $currentDate->copy()->startOfMonth();
            $endDate = $currentDate->copy()->endOfMonth();
        } elseif ($view === 'day') {
            $startDate = $currentDate->copy()->startOfDay();
            $endDate = $currentDate->copy()->endOfDay();
        }

        $calendarBookings = $business->bookings()
            ->with(['service', 'services', 'business'])
            ->where('staff_user_id', $user->id)
            ->whereBetween('booking_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($booking) {
                return Carbon::parse($booking->booking_date)->format('Y-m-d');
            });

        // Services offered by this business
        $services = $business->services;

        // License info
        $license = $business->license;

        return view('admin.staff.dashboard', compact(
            'business',
            'totalBookings',
            'todayBookings',
            'upcomingBookings',
            'todayBookingsList',
            'calendarBookings',
            'services',
            'license',
            'view',
            'currentDate',
            'startDate',
            'endDate'
        ));
    }
}
