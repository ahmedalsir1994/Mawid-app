# 🎯 Quick Start - 5 Minute Setup Guide

## Start Here

### Step 1: Ensure Server is Running

```bash
cd c:\laragon\www\booking-app
php artisan serve
# Server should be at http://127.0.0.1:8000
```

### Step 2: Open Browser & Visit

```
http://127.0.0.1:8000
```

You should see a landing page.

### Step 3: Login

1. Click "Login" button
2. Enter credentials:
    - Email: `admin@bookingapp.local`
    - Password: `password`
3. Click "Log in"
4. **Auto-redirects to**: `/admin/dashboard`

---

## 📊 What You'll See

### Super Admin Dashboard Shows:

- **Statistics Cards**
    - Total Businesses
    - Active Licenses
    - Total Revenue
    - Expiring Licenses Soon
- **Action Sections**
    - Top Performing Businesses
    - Licenses Expiring Soon
    - Recent Activity

### Left Sidebar Navigation:

- 🏠 Dashboard
- 🏢 Businesses
- 📜 Licenses
- 👥 Users
- Logout

---

## 🔧 Key Operations

### Create a Business

1. Click **Businesses** in sidebar
2. Click **Create Business** button
3. Fill in:
    - Name: "My Business"
    - Slug: "my-business"
    - Address: "123 Main St"
    - Country: "USA"
    - Phone: "555-1234"
    - Currency: "USD"
    - Timezone: "UTC"
4. Click **Save**

### Create a License

1. Click **Licenses** in sidebar
2. Click **Create License** button
3. Select business from dropdown
4. Fill in license details
5. Click **Save**

### Add a User

1. Click **Users** in sidebar
2. Click **Create User** button
3. Fill in:
    - Name
    - Email
    - Password
    - Role (super_admin, company_admin, staff, customer)
4. Click **Save**

---

## 🧪 Test Scenarios

### Test 1: Login Flow (2 min)

✅ Visit login page
✅ Enter admin credentials
✅ Dashboard loads
✅ Sidebar shows navigation

### Test 2: View Lists (2 min)

✅ Click Businesses → view list
✅ Click Licenses → view list
✅ Click Users → view list

### Test 3: Create Business (3 min)

✅ Go to Businesses
✅ Click Create
✅ Fill form
✅ Business appears in list

### Test 4: Navigation (2 min)

✅ Click sidebar items
✅ Dashboard link works
✅ Mobile menu works (if on phone/tablet)

### Test 5: Logout (1 min)

✅ Click profile icon (top right)
✅ Click Logout
✅ Redirects to login page

---

## 📱 URLs Quick Reference

```
Landing:        http://127.0.0.1:8000/
Login:          http://127.0.0.1:8000/login
Register:       http://127.0.0.1:8000/register
Profile:        http://127.0.0.1:8000/profile

Admin (Super):
Dashboard:      http://127.0.0.1:8000/admin/dashboard
Businesses:     http://127.0.0.1:8000/admin/super/businesses
Licenses:       http://127.0.0.1:8000/admin/super/licenses
Users:          http://127.0.0.1:8000/admin/super/users

Admin (Company):
Dashboard:      http://127.0.0.1:8000/admin/company/dashboard
Services:       http://127.0.0.1:8000/admin/services
Bookings:       http://127.0.0.1:8000/admin/bookings
Business:       http://127.0.0.1:8000/admin/business
```

---

## 🐛 Troubleshooting

### Dashboard won't load?

```bash
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Database issues?

```bash
php artisan migrate:refresh
php artisan db:seed
```

### Can't login?

- Check email is exactly: `admin@bookingapp.local`
- Password is: `password`
- Check browser console for CSRF errors

### 404 on routes?

```bash
php artisan route:clear
php artisan route:cache
```

---

## 💾 Database Check

View database users:

```bash
php artisan tinker
>>> User::all()
>>> User::where('role', 'super_admin')->first()
```

---

## 🎨 Design Features

✨ Purple to Pink gradient theme
✨ Modern card-based layouts
✨ Smooth hover transitions
✨ Responsive mobile design
✨ Dark sidebar with white cards
✨ Active state indicators
✨ Consistent spacing & shadows

---

## ✅ All Features Implemented

- [x] Login/Logout
- [x] Role-based access control
- [x] Super admin dashboard
- [x] Business management
- [x] License management
- [x] User management
- [x] Modern UI/UX
- [x] Mobile responsive
- [x] CSRF protection
- [x] Session management

---

## 📞 Need Help?

Check these files:

- `TEST_CHECKLIST.md` - Detailed test scenarios
- `IMPLEMENTATION_COMPLETE.md` - Full implementation details
- `ADMIN_SYSTEM_SETUP.md` - Admin system documentation
- `SYSTEM_ARCHITECTURE.md` - Architecture diagrams

---

**Status**: ✅ Ready to Use
**Last Updated**: February 2, 2026
