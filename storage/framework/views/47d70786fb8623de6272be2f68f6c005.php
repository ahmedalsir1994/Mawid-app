<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/Mawidly-fav.png')); ?>">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600|cairo:400,500,600&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        .sidebar-active {
            @apply bg-green-100 text-green-700 border-green-600;
        }

        [dir="ltr"] .sidebar-active {
            @apply border-l-4;
        }

        [dir="rtl"] .sidebar-active {
            @apply border-r-4;
        }

        .sidebar-hover {
            @apply hover:bg-gray-100 transition;
        }

        body.sidebar-open .sidebar-overlay {
            @apply fixed inset-0 bg-black bg-opacity-50 z-30;
        }

        /* RTL Support */
        [dir="rtl"] {
            text-align: right;
            font-family: 'Cairo', 'Figtree', sans-serif;
        }

        [dir="rtl"] .space-x-2>*+* {
            margin-left: 0;
            margin-right: 0.5rem;
        }

        [dir="rtl"] .space-x-3>*+* {
            margin-left: 0;
            margin-right: 0.75rem;
        }

        /* Compact mobile sidebar nav items */
        #mobileSidebar nav a {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-col md:w-64 md:bg-white md:shadow-lg">
            <!-- Logo Section -->
            <div class="flex items-center justify-center h-16 px-6 border-b border-gray-200">
                <img src="/images/Mawid.png" alt="Mawid App" class="h-10 w-auto pr-[90px]">
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="<?php echo e(auth()->user()->role === 'super_admin' ? route('admin.super.dashboard') : (auth()->user()->role === 'staff' ? route('admin.staff.dashboard') : route('admin.company.dashboard'))); ?>"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.dashboard', 'admin.company.dashboard', 'admin.staff.dashboard') ? 'sidebar-active' : ''); ?>">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span class="font-medium"><?php echo e(__('app.dashboard')); ?></span>
                </a>

                <?php if(auth()->user()->role === 'super_admin'): ?>
                    <!-- Super Admin Only: Businesses -->
                    <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.businesses.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.businesses')); ?></span>
                    </a>

                    <!-- Super Admin Only: Licenses -->
                    <a href="<?php echo e(route('admin.super.licenses.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.licenses.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.licenses')); ?></span>
                    </a>

                    <!-- Super Admin Only: Users -->
                    <a href="<?php echo e(route('admin.super.users.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.users.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm12 0a3 3 0 11-6 0 3 3 0 016 0zm0 0a3 3 0 11-6 0 3 3 0 016 0zM9 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.users')); ?></span>
                    </a>

                    <!-- Super Admin Only: Contact Submissions -->
                    <?php $_unreadContacts = \App\Models\ContactSubmission::where('is_read', false)->count(); ?>
                    <a href="<?php echo e(route('admin.contact-submissions.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.contact-submissions.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium flex-1">Contact Submissions</span>
                        <?php if($_unreadContacts > 0): ?>
                            <span class="min-w-[20px] h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold px-1"><?php echo e($_unreadContacts); ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Super Admin Only: Billing History -->
                    <a href="<?php echo e(route('admin.super.billing.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.billing.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                        <span class="font-medium">Billing History</span>
                    </a>
                <?php elseif(auth()->user()->role === 'company_admin'): ?>
                    <!-- Company Admin Only: Business Settings -->
                    <a href="<?php echo e(route('admin.business.edit')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.business.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.business')); ?></span>
                    </a>

                    <!-- Branches -->
                    <?php $sidebarLicense = auth()->user()->business?->license; ?>
                    <a href="<?php echo e(route('admin.branches.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.branches.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.branches')); ?></span>
                        <?php if($sidebarLicense && $sidebarLicense->isPlus()): ?>
                            <span class="ml-auto text-xs px-1.5 py-0.5 rounded bg-purple-100 text-purple-700 font-bold">🚀</span>
                        <?php endif; ?>
                    </a>

                    <!-- Services -->
                    <a href="<?php echo e(route('admin.services.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.services.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm0-6h.01M3 10h.01M3 16h.01M7 4h.01M7 10h.01M7 16h.01M11 4h.01M11 10h.01M11 16h.01M15 4h.01M15 10h.01M15 16h.01" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.services')); ?></span>
                    </a>

                    <!-- Staff -->
                    <a href="<?php echo e(route('admin.staff.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.staff.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.staff')); ?></span>
                    </a>

                    <!-- Bookings -->
                    <a href="<?php echo e(route('admin.bookings.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.bookings.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.bookings')); ?></span>
                    </a>

                    <!-- Company Admin: Billing -->
                    <a href="<?php echo e(route('admin.billing.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.billing.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                        <span class="font-medium">Billing</span>
                    </a>
                <?php elseif(auth()->user()->role === 'staff'): ?>
                    <!-- Staff Only: Bookings -->
                    <a href="<?php echo e(route('admin.staff.bookings.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.staff.bookings.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.bookings')); ?></span>
                    </a>
                <?php endif; ?>

                <!-- Working Hours (Company Admin Only) -->
                <?php if(auth()->user()->role === 'company_admin' && auth()->user()->business_id): ?>
                    <a href="<?php echo e(route('admin.working_hours.edit')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.working_hours.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.414 1.414L8 13.414V6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.working_hours')); ?></span>
                    </a>
                <?php endif; ?>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-4"></div>

                <!-- Settings -->
                <a href="<?php echo e(route('profile.edit')); ?>"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('profile.*') ? 'sidebar-active' : ''); ?>">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium"><?php echo e(__('app.profile')); ?></span>
                </a>
            </nav>

            <!-- User Profile Section -->
            <div class="border-t border-gray-200 px-4 py-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center">
                        <span
                            class="text-green-700 font-bold"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-800 truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-gray-500 truncate"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                </div>

                <?php if(auth()->user()->role === 'company_admin' && auth()->user()->business_id): ?>
                    <?php
                        $sidebarLicense   = auth()->user()->business?->license;
                        $sidebarPlan      = $sidebarLicense?->plan ?? 'free';
                        $sidebarPlanBadge = match($sidebarPlan) {
                            'pro'  => 'bg-blue-100 text-blue-800 hover:bg-blue-200',
                            'plus' => 'bg-purple-100 text-purple-800 hover:bg-purple-200',
                            default => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
                        };
                        $sidebarPlanEmoji = match($sidebarPlan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                    ?>
                    <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                       class="flex items-center justify-between w-full px-3 py-2 rounded-lg <?php echo e($sidebarPlanBadge); ?> text-sm font-semibold transition mb-2">
                        <span><?php echo e($sidebarPlanEmoji); ?> <?php echo e(ucfirst($sidebarPlan)); ?> <?php echo e(__('app.plan')); ?></span>
                        <?php if($sidebarPlan === 'free'): ?>
                            <span class="text-xs opacity-75">↑ <?php echo e(__('app.upgrade')); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if($sidebarPlan === 'free' && $sidebarLicense): ?>
                        <?php
                            $__sbUsed    = $sidebarLicense->monthlyBookingsUsed();
                            $__sbMax     = $sidebarLicense->maxMonthlyBookings();
                            $__sbPct     = $__sbMax > 0 ? min(100, (int) round($__sbUsed / $__sbMax * 100)) : 0;
                            $__sbColor   = $__sbPct >= 100 ? 'bg-red-500' : ($__sbPct >= 80 ? 'bg-amber-500' : 'bg-green-500');
                        ?>
                        <div class="mb-3 px-1">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Bookings this month</span>
                                <span class="<?php echo e($__sbPct >= 100 ? 'text-red-600 font-bold' : ''); ?>"><?php echo e($__sbUsed); ?>/<?php echo e($__sbMax); ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="<?php echo e($__sbColor); ?> h-1.5 rounded-full transition-all" style="width: <?php echo e($__sbPct); ?>%"></div>
                            </div>
                            <?php if($__sbPct >= 100): ?>
                                <a href="<?php echo e(route('admin.upgrade.index')); ?>" class="mt-1.5 block text-xs text-center text-red-600 font-semibold hover:underline">
                                    ⚠️ Limit reached — Upgrade now
                                </a>
                            <?php elseif($__sbPct >= 80): ?>
                                <a href="<?php echo e(route('admin.upgrade.index')); ?>" class="mt-1.5 block text-xs text-center text-amber-600 hover:underline">
                                    Approaching limit — Upgrade
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="px-4 py-2 border-t border-gray-200">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('app.language')); ?></span>
                        <div class="flex gap-1">
                            <a href="<?php echo e(route('lang.switch', 'en')); ?>"
                                class="px-2 py-1 text-xs font-medium rounded transition <?php echo e(app()->getLocale() === 'en' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                                EN
                            </a>
                            <a href="<?php echo e(route('lang.switch', 'ar')); ?>"
                                class="px-2 py-1 text-xs font-medium rounded transition <?php echo e(app()->getLocale() === 'ar' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                                AR
                            </a>
                        </div>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full flex items-center space-x-2 px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.logout')); ?></span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6">
                    <!-- Mobile Menu Button -->
                    <button onclick="document.getElementById('mobileSidebar').classList.toggle('hidden')"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1"></div>

                    <!-- Right Side Navigation -->
                    <div class="flex items-center space-x-4">
                        <!-- Home Button -->
                        <a href="<?php echo e(route('landing')); ?>"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition"
                           title="<?php echo e(__('app.back_to_home')); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="hidden sm:inline"><?php echo e(__('app.home')); ?></span>
                        </a>

                        <!-- Notifications -->
                        <div class="relative">
                            <button onclick="document.getElementById('notificationDropdown').classList.toggle('hidden')"
                                class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                                    <span
                                        class="absolute top-1 <?php echo e(app()->getLocale() === 'ar' ? 'left-1' : 'right-1'); ?> w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold">
                                        <?php echo e(auth()->user()->unreadNotifications->count()); ?>

                                    </span>
                                <?php endif; ?>
                            </button>

                            <!-- Notification Dropdown -->
                            <div id="notificationDropdown"
                                class="hidden absolute <?php echo e(app()->getLocale() === 'ar' ? 'left-0' : 'right-0'); ?> mt-2 w-96 bg-white rounded-lg shadow-lg z-50 border border-gray-200 max-h-96 overflow-y-auto">
                                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                                    <h3 class="text-sm font-bold text-gray-800"><?php echo e(__('app.notifications')); ?></h3>
                                    <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                                        <form method="POST" action="<?php echo e(route('admin.notifications.mark-all-read')); ?>"
                                            class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                class="text-xs text-green-600 hover:text-green-700 font-medium">
                                                <?php echo e(__('app.mark_all_read')); ?>

                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $notifType = $notification->data['type'] ?? 'booking';
                                        if ($notifType === 'contact_submission') {
                                            $notifUrl = route('admin.contact-submissions.show', $notification->data['id']);
                                            $notifIcon = 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z';
                                            $notifIconBg = 'bg-green-100';
                                            $notifIconColor = 'text-green-600';
                                            $notifSub = ($notification->data['email'] ?? '') . ' · ' . ($notification->data['phone'] ?? '');
                                        } elseif ($notifType === 'new_user') {
                                            $notifUrl = route('admin.super.users.show', $notification->data['user_id'] ?? 0);
                                            $notifIcon = 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z';
                                            $notifIconBg = 'bg-blue-100';
                                            $notifIconColor = 'text-blue-600';
                                            $notifSub = ($notification->data['user_email'] ?? '') . ' · ' . ($notification->data['business_name'] ?? '');
                                        } elseif ($notifType === 'new_license') {
                                            $notifUrl = route('admin.super.licenses.show', $notification->data['license_id'] ?? 0);
                                            $notifIcon = 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z';
                                            $notifIconBg = 'bg-purple-100';
                                            $notifIconColor = 'text-purple-600';
                                            $notifSub = ucfirst($notification->data['plan'] ?? '') . ' · ' . ($notification->data['business_name'] ?? '');
                                        } elseif ($notifType === 'auto_renew_failed') {
                                            $notifUrl = $notification->data['url'] ?? route('admin.billing.index');
                                            $notifIcon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                                            $notifIconBg = 'bg-red-100';
                                            $notifIconColor = 'text-red-600';
                                            $notifSub = ($notification->data['reason'] ?? '') . ' · Attempt ' . ($notification->data['attempt'] ?? 1);
                                        } else {
                                            $notifUrl = (auth()->user()->role === 'staff'
                                                ? route('admin.staff.bookings.show', $notification->data['booking_id'] ?? 0)
                                                : route('admin.bookings.show', $notification->data['booking_id'] ?? 0)) . '?notification=' . $notification->id;
                                            $notifIcon = 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z';
                                            $notifIconBg = 'bg-green-100';
                                            $notifIconColor = 'text-green-600';
                                            $notifSub = isset($notification->data['booking_date'])
                                                ? \Carbon\Carbon::parse($notification->data['booking_date'])->format('M d, Y') . (isset($notification->data['start_time']) ? ' at ' . substr($notification->data['start_time'], 0, 5) : '')
                                                : '';
                                        }
                                    ?>
                                    <a href="<?php echo e($notifUrl); ?>"
                                        class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 <?php echo e($notification->read_at ? 'bg-white' : 'bg-blue-50'); ?>">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 <?php echo e($notifIconBg); ?> rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 <?php echo e($notifIconColor); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($notifIcon); ?>" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">
                                                    <?php echo e($notification->data['message'] ?? ''); ?>

                                                </p>
                                                <?php if($notifSub): ?>
                                                <p class="text-xs text-gray-500 mt-1"><?php echo e($notifSub); ?></p>
                                                <?php endif; ?>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                                </p>
                                            </div>
                                            <?php if(!$notification->read_at): ?>
                                                <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="px-4 py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-sm"><?php echo e(__('app.no_notifications')); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')"
                                class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-green-700 font-bold text-sm"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="userDropdown"
                                class="hidden absolute <?php echo e(app()->getLocale() === 'ar' ? 'left-0' : 'right-0'); ?> mt-2 w-48 bg-white rounded-lg shadow-lg z-50 border border-gray-200">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-800"><?php echo e(auth()->user()->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(auth()->user()->email); ?></p>
                                </div>
                                <a href="<?php echo e(route('profile.edit')); ?>"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><?php echo e(__('app.profile')); ?></a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><?php echo e(__('app.sign_out')); ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            
            <?php
                $__license = auth()->user()->business?->license;
            ?>
            <?php if(auth()->user()->role !== 'super_admin' && $__license): ?>

                
                <?php if($__license->isExpired()): ?>
                <div class="bg-red-50 border-b border-red-200 px-6 py-3 flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-3 text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <span class="font-semibold">Your subscription has expired.</span>
                            <span class="text-sm ms-2 text-red-700">
                                Your data is safe — you're now on the Free plan (1 branch, 1 staff, 3 services, 25 bookings/month).
                                Upgrade to restore full access.
                            </span>
                        </div>
                    </div>
                    <?php if(auth()->user()->role === 'company_admin'): ?>
                    <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                       class="inline-flex items-center gap-1 px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition shrink-0">
                        Upgrade to Restore
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>

                
                <?php elseif($__license->isPastDue() && $__license->isInGracePeriod()): ?>
                <div class="bg-amber-50 border-b border-amber-300 px-6 py-3 flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-3 text-amber-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <span class="font-semibold">Payment failed — grace period active.</span>
                            <span class="text-sm ms-2 text-amber-800">
                                <?php $graceDays = $__license->graceDaysRemaining(); ?>
                                Your account remains fully active for
                                <strong><?php echo e($graceDays); ?> <?php echo e(Str::plural('day', $graceDays)); ?></strong>.
                                Please update your payment method to avoid a service interruption.
                            </span>
                        </div>
                    </div>
                    <?php if(auth()->user()->role === 'company_admin'): ?>
                    <a href="<?php echo e(route('admin.billing.index')); ?>"
                       class="inline-flex items-center gap-1 px-4 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg transition shrink-0">
                        Update Payment
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>

                
                <?php elseif(in_array($__license->status, ['suspended', 'cancelled'])): ?>
                <div class="bg-red-50 border-b border-red-200 px-6 py-3 flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-3 text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <span class="font-semibold"><?php echo e(__('app.license_inactive_title')); ?></span>
                            <span class="text-sm ms-2 text-red-700"><?php echo e(__('app.license_inactive_desc')); ?></span>
                        </div>
                    </div>
                    <?php if(auth()->user()->role === 'company_admin'): ?>
                    <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                       class="inline-flex items-center gap-1 px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition shrink-0">
                        <?php echo e(__('app.reactivate_now')); ?>

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            <?php elseif(auth()->user()->role !== 'super_admin' && !$__license): ?>
            
            <div class="bg-red-50 border-b border-red-200 px-6 py-3 flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-3 text-red-800">
                    <span class="font-semibold"><?php echo e(__('app.license_inactive_title')); ?></span>
                    <span class="text-sm ms-2 text-red-700"><?php echo e(__('app.license_inactive_desc')); ?></span>
                </div>
                <?php if(auth()->user()->role === 'company_admin'): ?>
                <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                   class="inline-flex items-center gap-1 px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition shrink-0">
                    <?php echo e(__('app.reactivate_now')); ?>

                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <?php if(auth()->user()->role !== 'super_admin' && (!$__license || (!$__license->isFree() && !$__license->isActive()))): ?>
            <div id="licenseBlockModal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
                     onclick="document.getElementById('licenseBlockModal').classList.add('hidden')"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 text-center">
                    <div class="mx-auto mb-5 w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <?php if($__license && $__license->isExpired()): ?>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Subscription Expired</h2>
                    <p class="text-gray-600 text-sm mb-2 leading-relaxed">
                        Your subscription has expired. Your data is <strong class="text-green-700">completely safe</strong> — you're now on the Free plan.
                    </p>
                    <p class="text-gray-500 text-xs mb-6">Limits: 1 branch · 1 staff · 3 services · 25 bookings/month</p>
                    <?php else: ?>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Action Not Allowed</h2>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                        Your license is
                        <strong class="text-red-600">
                            <?php if(!$__license): ?> missing
                            <?php elseif($__license->status !== 'active'): ?> <?php echo e($__license->status); ?>

                            <?php else: ?> expired
                            <?php endif; ?>
                        </strong>.
                        Adding or editing content has been disabled until you reactivate your plan.
                    </p>
                    <?php endif; ?>
                    <?php if(auth()->user()->role === 'company_admin'): ?>
                    <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                       class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition text-sm mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Upgrade to Restore Full Access
                    </a>
                    <?php else: ?>
                    <p class="text-xs text-gray-500 mb-3">Please ask your account owner to reactivate the plan.</p>
                    <?php endif; ?>
                    <button type="button"
                        onclick="document.getElementById('licenseBlockModal').classList.add('hidden')"
                        class="text-sm text-gray-400 hover:text-gray-600 underline underline-offset-2 transition">
                        Dismiss
                    </button>
                </div>
            </div>
            <script>window.licenseInactive = true;</script>
            <?php endif; ?>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto">
                <div class="px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Page Header -->
                    <?php if(isset($header)): ?>
                        <div class="mb-8">
                            <?php echo e($header); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Content -->
                    <?php echo e($slot); ?>

                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="hidden fixed inset-0 z-40 md:hidden">
        <!-- Overlay -->
        <div onclick="document.getElementById('mobileSidebar').classList.add('hidden')"
            class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Sidebar Panel -->
        <div
            class="absolute <?php echo e(app()->getLocale() === 'ar' ? 'right-0' : 'left-0'); ?> top-0 w-72 h-screen bg-white shadow-lg flex flex-col">
            <!-- Logo Section -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <div class="flex items-center space-x-2">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-green-600 to-green-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">BA</span>
                    </div>
                    <span class="font-bold text-lg text-gray-800">Admin</span>
                </div>
                <button onclick="document.getElementById('mobileSidebar').classList.add('hidden')"
                    class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-3 space-y-1 overflow-y-auto">
                <a href="<?php echo e(auth()->user()->role === 'super_admin' ? route('admin.super.dashboard') : (auth()->user()->role === 'staff' ? route('admin.staff.dashboard') : route('admin.company.dashboard'))); ?>"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.dashboard', 'admin.company.dashboard', 'admin.staff.dashboard') ? 'sidebar-active' : ''); ?>">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span class="font-medium"><?php echo e(__('app.dashboard')); ?></span>
                </a>

                <?php if(auth()->user()->role === 'super_admin'): ?>
                    <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.businesses.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.businesses')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.super.licenses.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.licenses.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.licenses')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.super.users.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.users.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm12 0a3 3 0 11-6 0 3 3 0 016 0zm0 0a3 3 0 11-6 0 3 3 0 016 0zM9 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.users')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.contact-submissions.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.contact-submissions.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium flex-1">Contact Submissions</span>
                        <?php if($_unreadContacts > 0): ?>
                            <span class="min-w-[20px] h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold px-1"><?php echo e($_unreadContacts); ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Super Admin Only: Billing History -->
                    <a href="<?php echo e(route('admin.super.billing.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.super.billing.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                        <span class="font-medium">Billing History</span>
                    </a>
                <?php elseif(auth()->user()->role === 'company_admin'): ?>
                    <a href="<?php echo e(route('admin.business.edit')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.business.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.business')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.branches.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.branches.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.branches')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.services.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.services.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm0-6h.01M3 10h.01M3 16h.01M7 4h.01M7 10h.01M7 16h.01M11 4h.01M11 10h.01M11 16h.01M15 4h.01M15 10h.01M15 16h.01" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.services')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.staff.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.staff.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.staff')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.bookings.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.bookings.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.bookings')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.working_hours.edit')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.working_hours.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.414 1.414L8 13.414V6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.working_hours')); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.time_off.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.time_off.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.time_off')); ?></span>
                    </a>

                    <!-- Company Admin: Billing -->
                    <a href="<?php echo e(route('admin.billing.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.billing.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                        <span class="font-medium">Billing</span>
                    </a>
                <?php elseif(auth()->user()->role === 'staff'): ?>
                    <!-- Staff Only: Bookings -->
                    <a href="<?php echo e(route('admin.staff.bookings.index')); ?>"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 sidebar-hover <?php echo e(request()->routeIs('admin.staff.bookings.*') ? 'sidebar-active' : ''); ?>">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.bookings')); ?></span>
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Mobile User Profile & Language Switcher -->
            <div class="flex-shrink-0 bg-white border-t border-gray-200 p-4 space-y-2">
                <?php if(auth()->user()->role === 'company_admin' && auth()->user()->business_id): ?>
                    <?php
                        $mobileSidebarLicense   = auth()->user()->business?->license;
                        $mobileSidebarPlan      = $mobileSidebarLicense?->plan ?? 'free';
                        $mobileSidebarPlanBadge = match($mobileSidebarPlan) {
                            'pro'  => 'bg-blue-100 text-blue-800',
                            'plus' => 'bg-purple-100 text-purple-800',
                            default => 'bg-gray-100 text-gray-700',
                        };
                        $mobileSidebarPlanEmoji = match($mobileSidebarPlan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                    ?>
                    <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                       class="flex items-center justify-between w-full px-3 py-2 rounded-lg <?php echo e($mobileSidebarPlanBadge); ?> text-sm font-semibold transition mb-1">
                        <span><?php echo e($mobileSidebarPlanEmoji); ?> <?php echo e(ucfirst($mobileSidebarPlan)); ?> <?php echo e(__('app.plan')); ?></span>
                        <?php if($mobileSidebarPlan === 'free'): ?>
                            <span class="text-xs opacity-75">↑ <?php echo e(__('app.upgrade')); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if($mobileSidebarPlan === 'free' && $mobileSidebarLicense): ?>
                        <?php
                            $__mbUsed    = $mobileSidebarLicense->monthlyBookingsUsed();
                            $__mbMax     = $mobileSidebarLicense->maxMonthlyBookings();
                            $__mbPct     = $__mbMax > 0 ? min(100, (int) round($__mbUsed / $__mbMax * 100)) : 0;
                            $__mbColor   = $__mbPct >= 100 ? 'bg-red-500' : ($__mbPct >= 80 ? 'bg-amber-500' : 'bg-green-500');
                        ?>
                        <div class="mb-1 px-1">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Bookings this month</span>
                                <span class="<?php echo e($__mbPct >= 100 ? 'text-red-600 font-bold' : ''); ?>"><?php echo e($__mbUsed); ?>/<?php echo e($__mbMax); ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="<?php echo e($__mbColor); ?> h-1.5 rounded-full transition-all" style="width: <?php echo e($__mbPct); ?>%"></div>
                            </div>
                            <?php if($__mbPct >= 100): ?>
                                <a href="<?php echo e(route('admin.upgrade.index')); ?>" class="mt-1.5 block text-xs text-center text-red-600 font-semibold hover:underline">
                                    ⚠️ Limit reached — Upgrade now
                                </a>
                            <?php elseif($__mbPct >= 80): ?>
                                <a href="<?php echo e(route('admin.upgrade.index')); ?>" class="mt-1.5 block text-xs text-center text-amber-600 hover:underline">
                                    Approaching limit — Upgrade
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Language Switcher -->
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('app.language')); ?></span>
                    <div class="flex gap-1">
                        <a href="<?php echo e(route('lang.switch', 'en')); ?>"
                            class="px-2 py-1 text-xs font-medium rounded transition <?php echo e(app()->getLocale() === 'en' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                            EN
                        </a>
                        <a href="<?php echo e(route('lang.switch', 'ar')); ?>"
                            class="px-2 py-1 text-xs font-medium rounded transition <?php echo e(app()->getLocale() === 'ar' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                            AR
                        </a>
                    </div>
                </div>

                <!-- Logout -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full flex items-center space-x-2 px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium"><?php echo e(__('app.logout')); ?></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Close dropdowns when clicking outside
        document.addEventListener('click', function (event) {
            const userDropdown = document.getElementById('userDropdown');
            const notificationDropdown = document.getElementById('notificationDropdown');

            // Close user dropdown if clicking outside
            if (!event.target.closest('[onclick*="userDropdown"]') && userDropdown) {
                userDropdown.classList.add('hidden');
            }

            // Close notification dropdown if clicking outside
            if (!event.target.closest('[onclick*="notificationDropdown"]') && notificationDropdown) {
                notificationDropdown.classList.add('hidden');
            }
        });

        // ── License inactive: intercept all mutating actions ──
        if (window.licenseInactive) {
            function showLicenseBlockModal() {
                document.getElementById('licenseBlockModal').classList.remove('hidden');
            }

            // Block all non-GET form submissions
            document.addEventListener('submit', function (e) {
                var form = e.target;
                var method = (form.getAttribute('method') || 'GET').toUpperCase();
                var methodField = form.querySelector('input[name="_method"]');
                var effective = methodField ? methodField.value.toUpperCase() : method;
                if (effective === 'GET') return; // allow search / filter forms
                var action = form.action || '';
                if (action.includes('/logout') || action.includes('/lang/') || action.includes('/upgrade') || action.includes('/billing')) return;
                e.preventDefault();
                e.stopImmediatePropagation();
                showLicenseBlockModal();
            }, true);

            // Block clicks on add / edit / delete links
            document.addEventListener('click', function (e) {
                var link = e.target.closest('a[href]');
                if (!link) return;
                var href = link.getAttribute('href') || '';
                if (!href || href === '#' || href.startsWith('tel:') || href.startsWith('mailto:') || href.startsWith('javascript:')) return;
                if (href.includes('/logout') || href.includes('/upgrade') || href.includes('/lang/') || href.includes('/profile')) return;
                if (link.target === '_blank') return;
                // Block navigation to create / edit admin pages
                if (/\/(create|edit)(\/|\?|$)/.test(href)) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    showLicenseBlockModal();
                }
            }, true);
        }
    </script>

    
    <script>
    (function () {
        const _fetch = window.fetch;
        window.fetch = function (...args) {
            return _fetch.apply(this, args).then(function (response) {
                if (response.status === 401) {
                    window.location.href = '<?php echo e(route('login')); ?>';
                }
                return response;
            });
        };

        // Also handle XMLHttpRequest (used by some legacy code)
        const _open = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function (...args) {
            this.addEventListener('load', function () {
                if (this.status === 401) {
                    window.location.href = '<?php echo e(route('login')); ?>';
                }
            });
            return _open.apply(this, args);
        };
    })();
    </script>

    
    <script>
    (function () {
        const ARABIC = /[؀-ۿݐ-ݿࢠ-ࣿﭐ-﷿ﹰ-﻿]/g;

        function stripArabic(el) {
            const before = el.value;
            const after  = before.replace(ARABIC, '');
            if (before !== after) {
                const pos = el.selectionStart - (before.length - after.length);
                el.value = after;
                el.setSelectionRange(pos, pos);
            }
        }

        // Block keydown for Arabic characters (handles keyboard typing)
        document.addEventListener('keydown', function (e) {
            if (e.key && ARABIC.test(e.key)) {
                e.preventDefault();
            }
            ARABIC.lastIndex = 0; // reset stateful regex
        }, true);

        // Strip Arabic on input event (handles paste, autocomplete, IME)
        document.addEventListener('input', function (e) {
            const el = e.target;
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                stripArabic(el);
            }
        }, true);
    })();
    </script>
</body>

</html><?php /**PATH C:\laragon\www\booking-app\resources\views/layouts/admin.blade.php ENDPATH**/ ?>