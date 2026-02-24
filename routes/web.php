<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SuperAdminDashboardController;
use App\Http\Controllers\Admin\CompanyAdminDashboardController;
use App\Http\Controllers\Admin\SuperAdminBusinessController;
use App\Http\Controllers\Admin\SuperAdminLicenseController;
use App\Http\Controllers\Admin\SuperAdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\WorkingHoursController;
use App\Http\Controllers\Admin\TimeOffController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\StaffDashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\LanguageController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Language Switcher Route (accessible by all authenticated users)
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Auth Routes (must come before the catch-all public routes)
require __DIR__.'/auth.php';

// License Suspended Page (must be accessible without license check)
Route::middleware('auth')->get('/admin/license/suspended', [LicenseController::class, 'suspended'])
    ->name('admin.license.suspended');

// Dynamic dashboard route that redirects based on user role
Route::middleware('auth')->get('/admin/dashboard', DashboardController::class)->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin Routes
Route::middleware(['auth', 'check_role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/super-dashboard', [SuperAdminDashboardController::class, 'index'])
        ->name('super.dashboard');
    
    // Manage Businesses
    Route::resource('super/businesses', SuperAdminBusinessController::class)
        ->names('super.businesses');
    
    // Manage Licenses
    Route::resource('super/licenses', SuperAdminLicenseController::class)
        ->names('super.licenses');
    Route::post('/super/licenses/{license}/reactivate', [SuperAdminLicenseController::class, 'reactivate'])
        ->name('super.licenses.reactivate');
    
    // Manage Users
    Route::resource('super/users', SuperAdminUserController::class)
        ->names('super.users');
});

// Staff Routes
Route::middleware(['auth', 'check_role:staff', 'check_license'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])
        ->name('staff.dashboard');
    
    // Staff can view bookings
    Route::get('/staff/bookings', [BookingController::class, 'index'])->name('staff.bookings.index');
    Route::get('/staff/bookings/{booking}', [BookingController::class, 'show'])->name('staff.bookings.show');
    Route::post('/staff/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('staff.bookings.status');
    Route::post('/staff/bookings/{booking}/reminder', [BookingController::class, 'markReminderSent'])->name('staff.bookings.reminder');
    
    // Notifications
    Route::post('/notifications/mark-all-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.mark-all-read');
});

// Company Admin Routes
Route::middleware(['auth', 'check_role:company_admin', 'check_license'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/company/dashboard', [CompanyAdminDashboardController::class, 'index'])
        ->name('company.dashboard');

    Route::get('/business', [BusinessSettingsController::class, 'edit'])->name('business.edit');
    Route::post('/business', [BusinessSettingsController::class, 'update'])->name('business.update');
    
    Route::resource('services', ServiceController::class)->except(['show']);
    
    // Manage Staff
    Route::resource('staff', StaffController::class);

    Route::get('/working-hours', [WorkingHoursController::class, 'edit'])->name('working_hours.edit');
    Route::post('/working-hours', [WorkingHoursController::class, 'update'])->name('working_hours.update');
    
    Route::get('/time-off', [TimeOffController::class, 'index'])->name('time_off.index');
    Route::delete('/time-off/{timeOff}', [TimeOffController::class, 'destroy'])->name('time_off.destroy');
    Route::post('/time-off', [TimeOffController::class, 'store'])->name('time_off.store');
    
    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::post('/bookings/{booking}/reminder', [BookingController::class, 'markReminderSent'])->name('bookings.reminder');
    
    // Notifications
    Route::post('/notifications/mark-all-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.mark-all-read');
});

// Public Booking Routes (must be last as it has catch-all {businessSlug})
// Constraint: businessSlug cannot contain file extensions
// IMPORTANT: More specific routes MUST come before catch-all routes
Route::get('/{businessSlug}/services/{serviceId}/slots', [PublicBookingController::class, 'slots'])
    ->where('businessSlug', '[^\.]+')
    ->name('public.slots');
Route::get('/{businessSlug}/success/{bookingId}', [PublicBookingController::class, 'success'])
    ->where('businessSlug', '[^\.]+')
    ->name('public.success');
Route::post('/{businessSlug}/book', [PublicBookingController::class, 'store'])
    ->where('businessSlug', '[^\.]+')
    ->name('public.book');
Route::get('/{businessSlug}', [PublicBookingController::class, 'show'])
    ->where('businessSlug', '[^\.]+')
    ->name('public.business');