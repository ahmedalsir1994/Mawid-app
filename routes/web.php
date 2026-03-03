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
use App\Http\Controllers\Admin\StaffDashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\UpgradeController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\PaymobController;
use App\Http\Controllers\Admin\ManualBookingController;

use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::view('/privacy', 'privacy')->name('privacy');    
Route::view('/terms', 'terms')->name('terms');
Route::view('/about', 'about')->name('about');
Route::view('/blog', 'blog')->name('blog');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Language Switcher Route (accessible by all authenticated users)
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Auth Routes (must come before the catch-all public routes)
require __DIR__.'/auth.php';

// Dynamic dashboard route that redirects based on user role
Route::middleware('auth')->get('/admin/dashboard', DashboardController::class)->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Shared notification route — accessible by all authenticated roles
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.mark-all-read');
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

    // Contact Submissions
    Route::get('/contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
    Route::get('/contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
    Route::patch('/contact-submissions/{contactSubmission}/mark-read', [ContactSubmissionController::class, 'markRead'])->name('contact-submissions.mark-read');
    Route::patch('/contact-submissions/{contactSubmission}/mark-unread', [ContactSubmissionController::class, 'markUnread'])->name('contact-submissions.mark-unread');
    Route::delete('/contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');

});

// Staff Routes
Route::middleware(['auth', 'check_role:staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])
        ->name('staff.dashboard');
    
    // Walk-in / Manual Bookings
    Route::get('/staff/bookings/create', [ManualBookingController::class, 'create'])->name('staff.bookings.create');
    Route::get('/staff/bookings/manual-slots', [ManualBookingController::class, 'slots'])->name('staff.bookings.manual-slots');
    Route::post('/staff/bookings/manual', [ManualBookingController::class, 'store'])->name('staff.bookings.manual.store');

    // Staff can view bookings
    Route::get('/staff/bookings', [BookingController::class, 'index'])->name('staff.bookings.index');
    Route::get('/staff/bookings/{booking}', [BookingController::class, 'show'])->name('staff.bookings.show');
    Route::post('/staff/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('staff.bookings.status');
    Route::post('/staff/bookings/{booking}/reminder', [BookingController::class, 'markReminderSent'])->name('staff.bookings.reminder');
    
});

// Paymob Payment Routes (callback is CSRF-exempt - added in bootstrap/app.php)
Route::post('/paymob/callback', [PaymobController::class, 'callback'])->name('paymob.callback');
Route::get('/paymob/return',    [PaymobController::class, 'return'])->name('paymob.return');

// Company Admin Routes
Route::middleware(['auth', 'check_role:company_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/company/dashboard', [CompanyAdminDashboardController::class, 'index'])
        ->name('company.dashboard');

    // Plan upgrade
    Route::get('/upgrade',          [UpgradeController::class, 'index'])->name('upgrade.index');
    Route::post('/upgrade',         [UpgradeController::class, 'initiate'])->name('upgrade.initiate');
    Route::get('/upgrade/autopay',  [UpgradeController::class, 'autoPay'])->name('upgrade.autopay');

    Route::get('/business', [BusinessSettingsController::class, 'edit'])->name('business.edit');
    Route::post('/business', [BusinessSettingsController::class, 'update'])->name('business.update');
    
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::delete('/services/{service}/images/{serviceImage}', [ServiceController::class, 'destroyImage'])
        ->name('services.images.destroy');

    
    // Branches (Plus plan)
    Route::resource('branches', BranchController::class);
    Route::post('/branches/{branch}/services', [BranchController::class, 'syncServices'])
        ->name('branches.services.sync');

    // Manage Staff
    Route::resource('staff', StaffController::class);

    Route::get('/working-hours', [WorkingHoursController::class, 'edit'])->name('working_hours.edit');
    Route::post('/working-hours', [WorkingHoursController::class, 'update'])->name('working_hours.update');
    
    Route::get('/time-off', [TimeOffController::class, 'index'])->name('time_off.index');
    Route::delete('/time-off/{timeOff}', [TimeOffController::class, 'destroy'])->name('time_off.destroy');
    Route::post('/time-off', [TimeOffController::class, 'store'])->name('time_off.store');
    
    // Walk-in / Manual Bookings
    Route::get('/bookings/create', [ManualBookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/manual-slots', [ManualBookingController::class, 'slots'])->name('bookings.manual-slots');
    Route::post('/bookings/manual', [ManualBookingController::class, 'store'])->name('bookings.manual.store');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::post('/bookings/{booking}/reminder', [BookingController::class, 'markReminderSent'])->name('bookings.reminder');
    
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