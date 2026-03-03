<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\License;
use App\Models\User;
use App\Models\Booking;
use App\Models\ContactSubmission;
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

        // Revenue breakdown by plan & cycle
        $revenueByPlan = License::where('payment_status', 'paid')
            ->whereIn('plan', ['pro', 'plus'])
            ->selectRaw('plan, billing_cycle, COUNT(*) as count, SUM(price) as total')
            ->groupBy('plan', 'billing_cycle')
            ->get()
            ->keyBy(fn ($r) => $r->plan . '_' . $r->billing_cycle);

        // Plan distribution (all licenses)
        $planDistribution = License::selectRaw('plan, COUNT(*) as count')
            ->groupBy('plan')
            ->pluck('count', 'plan');

        // Recent paid subscriptions
        $recentPayments = License::with('business')
            ->where('payment_status', 'paid')
            ->whereIn('plan', ['pro', 'plus'])
            ->orderByDesc('activated_at')
            ->take(10)
            ->get();

        // Monthly revenue trend – last 12 months
        $monthlyRevenue = License::where('payment_status', 'paid')
            ->whereIn('plan', ['pro', 'plus'])
            ->whereNotNull('activated_at')
            ->where('activated_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw('DATE_FORMAT(activated_at, "%Y-%m") as month, SUM(price) as total, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

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

        // Contact Submissions
        $totalContactSubmissions = ContactSubmission::count();
        $unreadContactSubmissions = ContactSubmission::where('is_read', false)->count();
        $recentContactSubmissions = ContactSubmission::latest()->take(5)->get();

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
            'revenueByPlan',
            'planDistribution',
            'recentPayments',
            'monthlyRevenue',
            'recentBusinesses',
            'recentBookings',
            'expiringLicensesList',
            'bookingsThisMonth',
            'topBusinesses',
            'totalContactSubmissions',
            'unreadContactSubmissions',
            'recentContactSubmissions'
        ));
    }
}
