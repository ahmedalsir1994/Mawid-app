<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\License;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalBusinesses = Business::count();
        $activeLicenses = License::where('status', 'active')->count();
        $totalUsers = User::count();
        $expiringLicenses = License::where('status', 'active')
            ->whereDate('expires_at', '<=', now()->addDays(7))
            ->whereDate('expires_at', '>', now())
            ->count();

        // Revenue statistics
        $totalRevenue = License::where('payment_status', 'paid')->sum('price');
        $pendingRevenue = License::where('payment_status', 'unpaid')->sum('price');

        // Recent businesses
        $recentBusinesses = Business::with('license', 'users')
            ->latest()
            ->take(5)
            ->get();

        // Recent bookings across all businesses
        $recentBookings = Booking::with('service', 'business')
            ->latest()
            ->take(10)
            ->get();

        // Licenses needing attention
        $expiringLicensesList = License::with('business')
            ->where('status', 'active')
            ->whereDate('expires_at', '<=', now()->addDays(30))
            ->whereDate('expires_at', '>', now())
            ->orderBy('expires_at')
            ->take(8)
            ->get();

        // Bookings this month
        $bookingsThisMonth = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Top performing businesses
        $topBusinesses = Business::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        return view('admin.super.dashboard', compact(
            'totalBusinesses',
            'activeLicenses',
            'totalUsers',
            'expiringLicenses',
            'totalRevenue',
            'pendingRevenue',
            'recentBusinesses',
            'recentBookings',
            'expiringLicensesList',
            'bookingsThisMonth',
            'topBusinesses'
        ));
    }
}
