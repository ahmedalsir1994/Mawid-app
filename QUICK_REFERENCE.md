# Quick Reference - Multi-Level Admin Commands

## 🗄️ Database Setup

```bash
# Run the migration that adds roles and licenses
php artisan migrate

# Refresh migrations (if needed)
php artisan migrate:refresh

# Rollback migrations (if needed)
php artisan migrate:rollback
```

## 👤 Create Super Admin User

Open Laravel Tinker:

```bash
php artisan tinker
```

Create super admin:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@bookingapp.local',
    'password' => bcrypt('password'),
    'role' => 'super_admin',
    'is_active' => true,
]);

// Exit tinker
exit;
```

## 🎯 User Role Assignments

```php
// In tinker or code:

// Create super admin
$user->update(['role' => 'super_admin']);

// Create company admin for a business
$user->update([
    'role' => 'company_admin',
    'business_id' => $business->id
]);

// Create staff member
$user->update([
    'role' => 'staff',
    'business_id' => $business->id
]);

// Deactivate account
$user->update(['is_active' => false]);

// Activate account
$user->update(['is_active' => true]);
```

## 📜 Check User Information

```php
// In tinker:

// Find user by email
$user = \App\Models\User::where('email', 'admin@bookingapp.local')->first();

// Check role
$user->role;                    // 'super_admin'
$user->isSuperAdmin();          // true
$user->isCompanyAdmin();        // false
$user->isStaff();               // false
$user->isCustomer();            // false

// Check if active
$user->is_active;               // true

// Get user's business
$user->business;                // Business model

// Get user's license
$user->license();               // License model
```

## 🏢 Business Management

```php
// In tinker:

// Create business
$business = \App\Models\Business::create([
    'name' => 'My Salon',
    'slug' => 'my-salon',
    'address' => '123 Main St',
    'country' => 'OM',
    'phone' => '+968 9xxx xxxx',
    'is_active' => true,
]);

// Get business users
$business->users;               // All users for this business
$business->admin();             // Company admin user
$business->staff();             // All staff members

// Check license
$business->license;             // License model
```

## 🔑 License Management

```php
// In tinker:

// Create license
$license = \App\Models\License::create([
    'business_id' => $business->id,
    'license_key' => 'LIC-' . strtoupper(\Illuminate\Support\Str::random(20)),
    'status' => 'active',
    'max_users' => 5,
    'max_daily_bookings' => 100,
    'activated_at' => now(),
    'expires_at' => now()->addYear(),
    'price' => 99.99,
    'payment_status' => 'paid',
    'notes' => 'Initial setup'
]);

// Check license status
$license->isActive();           // true/false
$license->isExpiring();         // true if expires within 7 days
$license->daysUntilExpiry();    // number of days

// Update license
$license->update(['status' => 'suspended']);

// Mark as expired
$license->update(['status' => 'expired']);
```

## 🔐 Middleware & Routes

```php
// In routes/web.php:

// Protected route (checks role)
Route::middleware(['auth', 'check_role:super_admin'])->group(function() {
    // Super admin only routes
});

Route::middleware(['auth', 'check_role:company_admin'])->group(function() {
    // Company admin only routes
});

// Check active status (automatic, global)
// No inactive users can access anything (handled by EnsureUserIsActive middleware)
```

## 🧪 Testing Routes

### As Super Admin

```
Login: admin@bookingapp.local / password

Routes:
- /admin/dashboard                    (Super Admin Dashboard)
- /admin/super/businesses             (Manage Businesses)
- /admin/super/licenses               (Manage Licenses)
- /admin/super/users                  (Manage Users)
```

### As Company Admin

```
Create via Super Admin > Users

Routes:
- /admin/company/dashboard            (Company Dashboard)
- /admin/business                     (Business Settings)
- /admin/services                     (Services)
- /admin/working-hours                (Working Hours)
- /admin/time-off                     (Time Off)
- /admin/bookings                     (Bookings)
```

## 📊 Query Examples

```php
// Get all active businesses
$active = \App\Models\Business::where('is_active', true)->get();

// Get active licenses
$active_licenses = \App\Models\License::where('status', 'active')->get();

// Get expiring licenses
$expiring = \App\Models\License::where('status', 'active')
    ->whereDate('expires_at', '<=', now()->addDays(7))
    ->whereDate('expires_at', '>', now())
    ->get();

// Get super admins
$admins = \App\Models\User::where('role', 'super_admin')->get();

// Get company admins for a business
$admins = \App\Models\Business::find($id)->users()
    ->where('role', 'company_admin')
    ->get();

// Get total revenue
$revenue = \App\Models\License::where('payment_status', 'paid')->sum('price');

// Get pending revenue
$pending = \App\Models\License::where('payment_status', 'unpaid')->sum('price');

// Count active licenses
$count = \App\Models\License::where('status', 'active')->count();
```

## 🛠️ Common Tasks

### Activate/Deactivate User

```php
// Deactivate
$user->update(['is_active' => false]);

// Activate
$user->update(['is_active' => true]);
```

### Change User Role

```php
$user->update(['role' => 'company_admin']);
```

### Transfer Business to Different Admin

```php
// Old admin
$old_admin->update(['role' => 'staff']);

// New admin
$new_admin->update([
    'role' => 'company_admin',
    'business_id' => $business->id
]);
```

### Renew License

```php
$license->update([
    'status' => 'active',
    'expires_at' => now()->addYear(),
    'payment_status' => 'paid',
]);
```

### Suspend License

```php
$license->update(['status' => 'suspended']);
```

## 📱 Reset Password

```bash
# Generate password reset link
php artisan tinker
```

```php
\Illuminate\Support\Facades\Password::sendResetLink([
    'email' => 'user@example.com'
]);
```

## 🐛 Debugging

```php
// Check user's role and permissions
$user = auth()->user();
dd($user->role, $user->is_active, $user->business_id);

// Check if license is valid
$business = $user->business;
$license = $business->license;
dd($license->isActive(), $license->daysUntilExpiry());

// Verify middleware is working
// Try accessing /admin/dashboard without super_admin role
// Should see 403 Forbidden error
```

---

**Note**: Use `php artisan tinker` for quick database operations and testing.
