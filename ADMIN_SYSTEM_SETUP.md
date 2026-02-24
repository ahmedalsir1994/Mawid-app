# Multi-Level Admin System Setup Guide

## Overview

Your booking app now has a complete multi-tier admin system with:

- **Super Admin Dashboard**: Manage all businesses, licenses, users, and revenue
- **Company Admin Dashboard**: Manage their own business, services, bookings, and staff

## Database Setup

### 1. Run Migrations

```bash
php artisan migrate
```

This will:

- Add `role`, `is_active`, and `business_id` columns to users table
- Create new `licenses` table for subscription management
- Add `is_active` column to businesses table

### 2. Create Super Admin User

After migration, seed a super admin user:

```bash
php artisan tinker
```

Then paste:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@bookingapp.local',
    'password' => bcrypt('password'),
    'role' => 'super_admin',
    'is_active' => true,
]);
```

Exit with `exit;`

## System Architecture

### User Roles

1. **Super Admin** (`super_admin`)
    - Access: `/admin/dashboard`
    - Manage all businesses
    - Create and manage licenses
    - Manage all users
    - View platform analytics

2. **Company Admin** (`company_admin`)
    - Access: `/admin/company/dashboard`
    - Manage their business settings
    - Create and edit services
    - Manage working hours
    - Manage time off
    - View and manage bookings
    - Manage staff members

3. **Staff** (`staff`)
    - Regular employees who help with bookings
    - Can view business calendar and bookings

4. **Customer** (`customer`)
    - Regular users booking services
    - Can view profile and make bookings

### Middleware

- `check_role:{role}` - Verifies user has specific role
- `ensure_user_is_active` - Blocks access if account is deactivated

## Available Routes

### Super Admin Routes

```
GET  /admin/dashboard                    - Super admin dashboard
GET  /admin/super/businesses             - List all businesses
POST /admin/super/businesses             - Create business
GET  /admin/super/businesses/{id}        - View business
PUT  /admin/super/businesses/{id}        - Update business
DELETE /admin/super/businesses/{id}      - Delete business

GET  /admin/super/licenses               - List licenses
POST /admin/super/licenses               - Create license
GET  /admin/super/licenses/{id}          - View license
PUT  /admin/super/licenses/{id}          - Update license
DELETE /admin/super/licenses/{id}        - Delete license

GET  /admin/super/users                  - List users
POST /admin/super/users                  - Create user
GET  /admin/super/users/{id}             - View user
PUT  /admin/super/users/{id}             - Update user
DELETE /admin/super/users/{id}           - Delete user
```

### Company Admin Routes

```
GET  /admin/company/dashboard            - Company dashboard
GET  /admin/business                     - Business settings
POST /admin/business                     - Update business
GET  /admin/services                     - Services list
POST /admin/services                     - Create service
PUT  /admin/services/{id}                - Update service
DELETE /admin/services/{id}              - Delete service
GET  /admin/working-hours                - Working hours
POST /admin/working-hours                - Update working hours
GET  /admin/time-off                     - Time off list
POST /admin/time-off                     - Create time off
DELETE /admin/time-off/{id}              - Delete time off
GET  /admin/bookings                     - Bookings list
GET  /admin/bookings/{id}                - View booking
POST /admin/bookings/{id}/status         - Update booking status
POST /admin/bookings/{id}/whatsapp       - Send WhatsApp reminder
```

## License Management

### License Model Features

- **License Key**: Unique identifier for each business
- **Status**: active, expired, suspended, cancelled
- **Max Users**: Limit number of staff members
- **Max Daily Bookings**: Limit bookings per day
- **Expiration**: Set expiry dates
- **Payment Status**: Track paid/unpaid subscriptions
- **Price**: Store subscription price

### License Methods

```php
$license->isActive()          // Check if license is active
$license->isExpiring()        // Check if expiring within 7 days
$license->daysUntilExpiry()   // Get days until expiry
```

## Creating First Business & License

### Step 1: Login as Super Admin

```
Email: admin@bookingapp.local
Password: password
```

### Step 2: Create Business

1. Go to `/admin/super/businesses`
2. Click "+ Add Business"
3. Fill in business details
4. Click "Create"

### Step 3: Create License

1. Go to `/admin/super/licenses`
2. Click "+ Create License"
3. Select the business
4. Click "Generate" for license key
5. Set expiration date and price
6. Click "Create License"

### Step 4: Create Company Admin User

1. Go to `/admin/super/users`
2. Click "+ Add User"
3. Enter user details
4. Select "Company Admin" role
5. Select the business
6. Click "Create"

## Key Files

### Models

- `app/Models/User.php` - Added role & license support
- `app/Models/Business.php` - Added license relationship
- `app/Models/License.php` - New license model

### Controllers

- `app/Http/Controllers/Admin/SuperAdminDashboardController.php`
- `app/Http/Controllers/Admin/CompanyAdminDashboardController.php`
- `app/Http/Controllers/Admin/SuperAdminBusinessController.php`
- `app/Http/Controllers/Admin/SuperAdminLicenseController.php`
- `app/Http/Controllers/Admin/SuperAdminUserController.php`

### Middleware

- `app/Http/Middleware/CheckRole.php`
- `app/Http/Middleware/EnsureUserIsActive.php`

### Views

```
resources/views/admin/super/
  ├── dashboard.blade.php
  ├── businesses/
  │   ├── index.blade.php
  │   ├── show.blade.php
  │   └── edit.blade.php
  ├── licenses/
  │   ├── index.blade.php
  │   ├── create.blade.php
  │   ├── show.blade.php
  │   └── edit.blade.php
  └── users/
      ├── index.blade.php
      ├── create.blade.php
      ├── show.blade.php
      └── edit.blade.php

resources/views/admin/company/
  └── dashboard.blade.php
```

### Database

- Migration: `database/migrations/2026_02_02_000000_add_roles_and_licenses.php`

## Security Features

1. **Role-Based Access Control**: Middleware enforces role requirements
2. **Account Deactivation**: Users with `is_active = false` are logged out
3. **Business Isolation**: Company admins only see their own business data
4. **License Validation**: System can check if license is valid before allowing operations

## Next Steps

1. Run migrations: `php artisan migrate`
2. Create super admin user (see above)
3. Login and create your first business
4. Create license for that business
5. Create company admin account
6. Company admin can then manage their business

## Support for Additional Features

The system is ready for:

- Invoice generation for licenses
- Automatic license renewal reminders
- Usage tracking (bookings vs. max limits)
- Team member invitation system
- Advanced analytics for super admin
- Payment gateway integration
- API for third-party integrations
