<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyAdminDashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $business = $user->business;

        if (!$business) {
            return redirect()->route('admin.super.dashboard')
                ->with('error', 'No business associated with this account.');
        }

        // Calendar view parameters
        $view = $request->get('view', 'month'); // week, month, year
        $date = $request->get('date', now()->format('Y-m-d'));
        $currentDate = \Carbon\Carbon::parse($date);

        // Business statistics
        $totalServices = $business->services()->count();
        $totalBookings = $business->bookings()->count();
        $pendingBookings = $business->bookings()->where('status', 'pending')->count();
        $confirmedBookings = $business->bookings()->where('status', 'confirmed')->count();

        // Staff statistics
        $totalStaff = $business->users()->where('role', 'staff')->count();
        $totalAdmins = $business->users()->where('role', 'company_admin')->count();

        // Recent data
        $recentBookings = $business->bookings()
            ->with(['service', 'services', 'staff'])
            ->latest()
            ->take(10)
            ->get();

        $upcomingBookings = $business->bookings()
            ->with(['service', 'services', 'staff'])
            ->where('status', 'confirmed')
            ->whereDate('booking_date', '>=', now())
            ->orderBy('booking_date')
            ->take(8)
            ->get();

        $topServices = $business->services()
            ->withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        // Staff workload analytics
        $staffWorkload = $business->users()
            ->whereIn('role', ['staff', 'company_admin'])
            ->where('is_active', true)
            ->withCount([
                'staffBookings as total_bookings' => function($query) {
                    $query->whereIn('status', ['pending', 'confirmed', 'completed']);
                },
                'staffBookings as pending_bookings' => function($query) {
                    $query->where('status', 'pending');
                },
                'staffBookings as completed_bookings' => function($query) {
                    $query->where('status', 'completed');
                },
                'staffBookings as upcoming_bookings' => function($query) {
                    $query->whereIn('status', ['pending', 'confirmed'])
                          ->whereDate('booking_date', '>=', now());
                },
                'staffBookings as bookings_this_month' => function($query) {
                    $query->whereMonth('booking_date', now()->month)
                          ->whereYear('booking_date', now()->year);
                }
            ])
            ->get()
            ->map(function($staff) {
                return [
                    'id' => $staff->id,
                    'name' => $staff->name,
                    'email' => $staff->email,
                    'role' => $staff->role,
                    'total_bookings' => $staff->total_bookings,
                    'pending_bookings' => $staff->pending_bookings,
                    'completed_bookings' => $staff->completed_bookings,
                    'upcoming_bookings' => $staff->upcoming_bookings,
                    'bookings_this_month' => $staff->bookings_this_month,
                ];
            })
            ->sortByDesc('total_bookings');

        $license = $business->license;
        $userCount = $business->users->count();
        $totalBookingsThisMonth = $business->bookings()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

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
        } elseif ($view === 'year') {
            $startDate = $currentDate->copy()->startOfYear();
            $endDate = $currentDate->copy()->endOfYear();
        }

        $calendarBookings = $business->bookings()
            ->with(['service', 'services', 'business', 'staff'])
            ->whereBetween('booking_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($booking) {
                return \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d');
            });

        return view('admin.company.dashboard', compact(
            'business',
            'totalServices',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'totalStaff',
            'totalAdmins',
            'recentBookings',
            'upcomingBookings',
            'topServices',
            'staffWorkload',
            'license',
            'userCount',
            'totalBookingsThisMonth',
            'calendarBookings',
            'currentDate',
            'view',
            'startDate',
            'endDate'
        ));
    }
}
