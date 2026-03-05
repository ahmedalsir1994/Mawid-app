<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Invoice;
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

        // Active = status 'active' OR past_due still within grace period
        $activeLicenses = License::where(function ($q) {
            $q->where('status', 'active')
              ->orWhere(function ($q2) {
                  $q2->where('status', 'past_due')
                     ->whereDate('grace_period_ends_at', '>=', now()->toDateString());
              });
        })->count();

        $totalUsers = User::count();

        // Expiring soon: active licenses expiring within 7 days
        $expiringLicenses = License::where('status', 'active')
            ->whereDate('expires_at', '<=', now()->addDays(7))
            ->whereDate('expires_at', '>', now())
            ->count();

        // Revenue statistics — sourced from invoices for accuracy (captures renewals)
        $totalRevenue   = Invoice::where('status', 'paid')->sum('amount');
        $pendingRevenue = Invoice::where('status', 'pending')->sum('amount');

        // Revenue breakdown by plan & cycle (all paid invoices)
        $revenueByPlan = Invoice::where('status', 'paid')
            ->whereIn('plan', ['pro', 'plus'])
            ->selectRaw('plan, billing_cycle, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('plan', 'billing_cycle')
            ->get()
            ->keyBy(fn ($r) => $r->plan . '_' . $r->billing_cycle);

        // Plan distribution (all licenses)
        $planDistribution = License::selectRaw('plan, COUNT(*) as count')
            ->groupBy('plan')
            ->pluck('count', 'plan');

        // Recent paid subscriptions — from invoices for accurate amounts
        $recentPayments = Invoice::with('business')
            ->where('status', 'paid')
            ->latest('paid_at')
            ->take(10)
            ->get();

        // Monthly revenue trend – last 12 months (from paid invoices)
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->whereIn('plan', ['pro', 'plus'])
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw('DATE_FORMAT(paid_at, "%Y-%m") as month, SUM(amount) as total, COUNT(*) as count')
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

        // Licenses needing attention: active expiring within 30 days + past_due in grace period
        $expiringLicensesList = License::with('business')
            ->where(function ($q) {
                $q->where(function ($q2) {
                    // Active licenses expiring within 30 days
                    $q2->where('status', 'active')
                       ->whereDate('expires_at', '<=', now()->addDays(30))
                       ->whereDate('expires_at', '>', now());
                })->orWhere(function ($q2) {
                    // Past-due licenses still in grace period
                    $q2->where('status', 'past_due')
                       ->whereDate('grace_period_ends_at', '>=', now()->toDateString());
                });
            })
            ->orderByRaw("FIELD(status,'past_due','active')")
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
