# 🏗️ System Architecture

## User Flow & Access Control

```
┌─────────────────────────────────────────────────────────────────┐
│                        USER LOGIN                               │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
          ┌──────────────────────────────┐
          │  Authenticate User           │
          │  Check is_active = true      │
          └──────────────────────────────┘
                         │
        ┌────────────────┼────────────────┐
        │                │                │
        ▼                ▼                ▼
   ┌─────────┐    ┌─────────┐      ┌──────────┐
   │ SUPER   │    │ COMPANY │      │ CUSTOMER │
   │ ADMIN   │    │  ADMIN  │      │ or STAFF │
   └────┬────┘    └────┬────┘      └──────────┘
        │              │
        ▼              ▼
    /admin/        /admin/company/
    dashboard      dashboard
```

## Dashboard Hierarchy

```
PLATFORM LEVEL (Super Admin)
│
├─ /admin/dashboard
│  ├─ 📊 Global Statistics
│  │  ├─ Total Businesses (20)
│  │  ├─ Active Licenses (18)
│  │  ├─ Total Revenue ($5,400)
│  │  ├─ Pending Revenue ($800)
│  │  └─ Expiring Licenses (3)
│  │
│  ├─ 🏢 Manage Businesses
│  │  ├─ Create new business
│  │  ├─ View all businesses
│  │  ├─ Edit business info
│  │  └─ Deactivate business
│  │
│  ├─ 🔑 Manage Licenses
│  │  ├─ Create license
│  │  ├─ Renew license
│  │  ├─ Suspend license
│  │  └─ Track payments
│  │
│  └─ 👥 Manage Users
│     ├─ Create admin/staff/customer
│     ├─ Assign to businesses
│     ├─ Edit roles
│     └─ Deactivate accounts
│
└─────────────────────────────────────────────────────────────────

BUSINESS LEVEL (Company Admin)
│
└─ /admin/company/dashboard
   ├─ 📊 Business Statistics
   │  ├─ Total Bookings (145)
   │  ├─ Pending (12)
   │  ├─ Confirmed (133)
   │  └─ This Month (47)
   │
   ├─ 📱 Manage Services
   │  ├─ Create service
   │  ├─ Edit service
   │  ├─ Set price & duration
   │  └─ Delete service
   │
   ├─ ⏰ Manage Working Hours
   │  ├─ Set daily hours
   │  ├─ Add closed days
   │  └─ Configure timezone
   │
   ├─ 📅 Manage Time Off
   │  ├─ Add holidays
   │  ├─ Block dates
   │  └─ Set duration
   │
   ├─ 📋 Manage Bookings
   │  ├─ View all bookings
   │  ├─ Confirm/reject
   │  ├─ Send reminders
   │  └─ Track customer info
   │
   ├─ 👨‍💼 Manage Staff
   │  ├─ Invite team members
   │  ├─ Assign roles
   │  ├─ View activity
   │  └─ Remove members
   │
   └─ ⚙️ Business Settings
      ├─ Edit business info
      ├─ Configure timezone
      ├─ Set currency
      └─ View license status
```

## Database Relationships

```
                    ┌─────────────────┐
                    │     USERS       │
                    ├─────────────────┤
                    │ id              │
                    │ name            │
                    │ email           │
                    │ password        │
                    │ role ◄──────────┼─────┐
                    │ is_active       │     │
                    │ business_id ────┼─┐   │
                    │ created_at      │ │   │
                    │ updated_at      │ │   │
                    └─────────────────┘ │   │
                            ▲           │   │
                            │           │   │
                            │ (1:M)     │   │
                            │           │   │
                    ┌─────────────────┐ │   │
                    │   BUSINESSES    │ │   │
                    ├─────────────────┤ │   │
                    │ id              │ │   │
                    │ name            │ │   │
                    │ slug            │ │   │
                    │ address         │ │   │
                    │ is_active       │ │   │
                    │ created_at      │ │   │
                    └─────────────────┘ │   │
                            ▲           │   │
                            │           └───┘
                            │ (1:1)
                            │
                    ┌─────────────────┐     Roles:
                    │    LICENSES     │     • super_admin
                    ├─────────────────┤     • company_admin
                    │ id              │     • staff
                    │ business_id ────┘     • customer
                    │ license_key     │
                    │ status          │
                    │ max_users       │
                    │ max_daily_      │
                    │   bookings      │
                    │ expires_at      │
                    │ payment_status  │
                    │ price           │
                    └─────────────────┘

                    ┌─────────────────┐
                    │   SERVICES      │
                    ├─────────────────┤
                    │ id              │
                    │ business_id ────┼─────→ BUSINESSES
                    │ name            │
                    │ price           │
                    │ duration_mins   │
                    └─────────────────┘
                            ▲
                            │ (1:M)
                            │
                    ┌─────────────────┐
                    │    BOOKINGS     │
                    ├─────────────────┤
                    │ id              │
                    │ service_id ─────┘
                    │ business_id ────┼─────→ BUSINESSES
                    │ booking_date    │
                    │ start_time      │
                    │ status          │
                    │ customer_name   │
                    │ customer_phone  │
                    └─────────────────┘
```

## Middleware Flow

```
REQUEST COMES IN
      │
      ▼
┌──────────────────┐
│  Authentication  │  ◄─── Checks if user is logged in
└────────┬─────────┘
         │
         ▼
┌──────────────────────┐
│  EnsureUserIsActive  │  ◄─── Checks if user.is_active = true
└────────┬─────────────┘      If false: logs out & redirects to login
         │
         ▼
┌──────────────────────┐
│   CheckRole Middleware   │  ◄─── Checks if user.role matches route
└────────┬─────────────┘      If not: returns 403 Forbidden
         │
         ▼
    ALLOW REQUEST
        │
        ▼
    CONTROLLER PROCESSES
        │
        ▼
    RETURNS RESPONSE
```

## License Lifecycle

```
┌──────────────┐
│  CREATED     │
│  status:     │
│  'active'    │  ◄─── Initial state when license is created
└────┬─────────┘
     │
     │ Admin updates or time passes
     │
     ├──────────────────────┬──────────────────────┐
     │                      │                      │
     ▼                      ▼                      ▼
┌──────────────┐  ┌──────────────┐  ┌──────────────┐
│   ACTIVE     │  │   SUSPENDED  │  │   CANCELLED  │
│  ✓ Working   │  │  ⚠️ Blocked  │  │  ✗ Ended     │
│  ✓ Can book  │  │  ✗ No bookings│ │  ✗ No access │
└────┬─────────┘  └──────────────┘  └──────────────┘
     │
     │ Time passes until expires_at
     │
     ▼
┌──────────────┐
│  EXPIRED     │
│  ✗ Blocked   │  ◄─── Auto-set when expires_at < now()
└──────────────┘
     │
     │ Admin renews
     │
     ▼
┌──────────────┐
│  RENEWED     │
│  ✓ Working   │  ◄─── Status back to 'active'
└──────────────┘
```

## Feature Access Matrix

```
┌────────────────┬────────────┬──────────────┬───────────┬──────────┐
│ FEATURE        │ SUPER ADMIN│ COMPANY ADMIN│   STAFF   │ CUSTOMER │
├────────────────┼────────────┼──────────────┼───────────┼──────────┤
│ View Dashboard │     ✓      │      ✓       │     ✗     │    ✗     │
│ Manage Biz     │     ✓      │      ✓*      │     ✗     │    ✗     │
│ Manage License │     ✓      │      ✗       │     ✗     │    ✗     │
│ Manage Users   │     ✓      │      ✓*      │     ✗     │    ✗     │
│ Manage Services│     ✓**    │      ✓       │     ✗     │    ✗     │
│ View Bookings  │     ✓      │      ✓       │     ✓*    │    ✓*    │
│ Manage Bookings│     ✓      │      ✓       │     ✓*    │    ✗     │
│ Make Booking   │     ✗      │      ✗       │     ✗     │    ✓     │
│ View Profile   │     ✓      │      ✓       │     ✓     │    ✓     │
│ Edit Profile   │     ✓      │      ✓       │     ✓     │    ✓     │
│ Manage Payments│     ✓      │      ✗       │     ✗     │    ✗     │
├────────────────┼────────────┼──────────────┼───────────┼──────────┤
│ ✓ = Full access                                                     │
│ ✓* = Limited to own business or assigned tasks                      │
│ ✓** = Super admin can view across all businesses                    │
│ ✗ = No access                                                       │
└────────────────┴────────────┴──────────────┴───────────┴──────────┘
```

## Data Isolation

```
SUPER ADMIN
├─ Can view ALL businesses
├─ Can see ALL bookings
├─ Can manage ALL licenses
└─ Can manage ALL users

COMPANY ADMIN (for Business X)
├─ Can ONLY view Business X
├─ Can ONLY see Business X bookings
├─ Can ONLY manage Business X services
├─ Can ONLY manage Business X staff
└─ Cannot access Business Y data

STAFF MEMBER (for Business X)
├─ Can ONLY view Business X bookings
├─ Can ONLY see Business X calendar
└─ Cannot access Business Y data

CUSTOMER
├─ Can ONLY view their own bookings
├─ Can ONLY make bookings (public)
└─ Cannot see other customers' data
```

---

This architecture ensures:

- ✅ Scalability (manage many businesses)
- ✅ Security (role-based access)
- ✅ Data Isolation (businesses can't see each other's data)
- ✅ License Control (limit features per subscription)
- ✅ Easy Administration (centralized super admin controls)
