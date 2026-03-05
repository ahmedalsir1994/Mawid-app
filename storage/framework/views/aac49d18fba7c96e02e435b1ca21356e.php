<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900"><?php echo e(__('app.super_admin_dashboard')); ?></h1>
        <p class="text-gray-600 mt-2"><?php echo e(__('app.manage_platform')); ?></p>
    </div>

    <!-- Key Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Businesses -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium"><?php echo e(__('app.total_businesses')); ?></h3>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($totalBusinesses); ?></p>
        </div>

        <!-- Active Licenses -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium"><?php echo e(__('app.active_licenses')); ?></h3>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($activeLicenses); ?></p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium"><?php echo e(__('app.total_revenue')); ?></h3>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($totalRevenue, 3)); ?> <?php echo e(__('app.revenue_omr')); ?></p>
        </div>

        <!-- Expiring Licenses -->
        <div class="bg-white rounded-xl shadow-md border border-yellow-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium"><?php echo e(__('app.expiring_soon')); ?></h3>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4v.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($expiringLicenses); ?></p>
            <p class="text-sm text-gray-600 mt-2"><?php echo e(__('app.within_days', ['days' => 7])); ?></p>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pending Revenue -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.pending_revenue')); ?></h3>
            <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($pendingRevenue, 3)); ?> <?php echo e(__('app.revenue_omr')); ?></p>
            <p class="text-sm text-orange-600 mt-2"><?php echo e(__('app.awaiting_payment')); ?></p>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.total_users')); ?></h3>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($totalUsers); ?></p>
            <p class="text-sm text-gray-600 mt-2"><?php echo e(__('app.across_all_businesses')); ?></p>
        </div>

        <!-- Bookings This Month -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2">Bookings This Month</h3>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($bookingsThisMonth); ?></p>
            <p class="text-sm text-gray-600 mt-2"><?php echo e(now()->format('F Y')); ?></p>
        </div>
    </div>

    <!-- Revenue Breakdown by Plan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Plan Distribution -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4"><?php echo e(__('app.plan_distribution')); ?></h2>
            <div class="space-y-3">
                <?php
                    $planColors = ['free' => 'bg-gray-400', 'pro' => 'bg-blue-500', 'plus' => 'bg-purple-600'];
                    $planLabels = ['free' => __('app.free_plan'), 'pro' => __('app.pro_plan'), 'plus' => __('app.plus_plan')];
                    $grandTotal  = $planDistribution->sum() ?: 1;
                ?>
                <?php $__currentLoopData = ['free','pro','plus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $cnt = $planDistribution[$p] ?? 0; $pct = round($cnt / $grandTotal * 100); ?>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700"><?php echo e($planLabels[$p]); ?></span>
                            <span class="text-gray-500"><?php echo e($cnt); ?> (<?php echo e($pct); ?>%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="<?php echo e($planColors[$p]); ?> h-2 rounded-full" style="width: <?php echo e($pct); ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Pro Plan Revenue -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-900"><?php echo e(__('app.pro_plan')); ?></h2>
                <span class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </span>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <div>
                        <p class="text-xs text-blue-600 font-medium uppercase tracking-wide"><?php echo e(__('app.monthly')); ?></p>
                        <p class="text-lg font-bold text-gray-900"><?php echo e(number_format($revenueByPlan['pro_monthly']->total ?? 0, 3)); ?> <?php echo e(__('app.revenue_omr')); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-blue-600"><?php echo e($revenueByPlan['pro_monthly']->count ?? 0); ?></p>
                        <p class="text-xs text-gray-500">payments</p>
                    </div>
                </div>
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <div>
                        <p class="text-xs text-blue-600 font-medium uppercase tracking-wide"><?php echo e(__('app.yearly')); ?></p>
                        <p class="text-lg font-bold text-gray-900"><?php echo e(number_format($revenueByPlan['pro_yearly']->total ?? 0, 3)); ?> <?php echo e(__('app.revenue_omr')); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-blue-600"><?php echo e($revenueByPlan['pro_yearly']->count ?? 0); ?></p>
                        <p class="text-xs text-gray-500">payments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plus Plan Revenue -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-900"><?php echo e(__('app.plus_plan')); ?></h2>
                <span class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </span>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                    <div>
                        <p class="text-xs text-purple-600 font-medium uppercase tracking-wide"><?php echo e(__('app.monthly')); ?></p>
                        <p class="text-lg font-bold text-gray-900"><?php echo e(number_format($revenueByPlan['plus_monthly']->total ?? 0, 3)); ?> <?php echo e(__('app.revenue_omr')); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-purple-600"><?php echo e($revenueByPlan['plus_monthly']->count ?? 0); ?></p>
                        <p class="text-xs text-gray-500">payments</p>
                    </div>
                </div>
                <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                    <div>
                        <p class="text-xs text-purple-600 font-medium uppercase tracking-wide"><?php echo e(__('app.yearly')); ?></p>
                        <p class="text-lg font-bold text-gray-900"><?php echo e(number_format($revenueByPlan['plus_yearly']->total ?? 0, 3)); ?> <?php echo e(__('app.revenue_omr')); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-purple-600"><?php echo e($revenueByPlan['plus_yearly']->count ?? 0); ?></p>
                        <p class="text-xs text-gray-500">payments</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Trend -->
    <?php if($monthlyRevenue->isNotEmpty()): ?>
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6"><?php echo e(__('app.monthly_revenue_trend')); ?></h2>
        <?php
            $maxMonthlyTotal = $monthlyRevenue->max('total') ?: 1;
            // Fill last 12 months
            $months = [];
            for ($i = 11; $i >= 0; $i--) {
                $key = now()->subMonths($i)->format('Y-m');
                $months[$key] = $monthlyRevenue[$key] ?? null;
            }
        ?>
        <div class="flex items-end gap-2 h-32">
            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $val   = $data->total ?? 0;
                    $cnt   = $data->count ?? 0;
                    $pct   = $maxMonthlyTotal > 0 ? round($val / $maxMonthlyTotal * 100) : 0;
                    $label = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M');
                ?>
                <div class="flex-1 flex flex-col items-center gap-1" title="<?php echo e($label); ?>: <?php echo e(number_format($val,3)); ?> OMR (<?php echo e($cnt); ?> subs)">
                    <div class="w-full rounded-t-sm <?php echo e($val > 0 ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-100'); ?> transition" style="height: <?php echo e(max($pct, 2)); ?>%"></div>
                    <p class="text-xs text-gray-400 text-center" style="font-size:10px"><?php echo e($label); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Performing Businesses -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.top_performing_businesses')); ?></h2>
                <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
                    class="text-green-600 hover:text-green-700 text-sm font-medium"><?php echo e(__('app.view_all')); ?></a>
            </div>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $topBusinesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900"><?php echo e($business->name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($business->address); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-green-600"><?php echo e($business->bookings_count); ?></p>
                            <p class="text-xs text-gray-600"><?php echo e(__('app.bookings')); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8"><?php echo e(__('app.no_businesses_yet')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Expiring Licenses Alert -->
        <div class="bg-white rounded-xl shadow-md border border-yellow-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.licenses_expiring_soon')); ?></h2>
                <a href="<?php echo e(route('admin.super.licenses.index')); ?>"
                    class="text-green-600 hover:text-green-700 text-sm font-medium"><?php echo e(__('app.manage')); ?></a>
            </div>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $expiringLicensesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isPastDue = $license->status === 'past_due';
                        $cardBg    = $isPastDue ? 'bg-red-50 border-red-300' : 'bg-yellow-50 border-yellow-200';
                        $badgeBg   = $isPastDue ? 'bg-red-600' : 'bg-yellow-600';
                        if ($isPastDue) {
                            $badgeText = $license->graceDaysRemaining() . 'd grace left';
                        } else {
                            $badgeText = __('app.days_left', ['days' => $license->daysUntilExpiry()]);
                        }
                    ?>
                    <div class="p-4 <?php echo e($cardBg); ?> rounded-lg border hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-gray-900"><?php echo e($license->business->name ?? '—'); ?></p>
                            <span class="text-xs font-bold text-white <?php echo e($badgeBg); ?> px-2 py-1 rounded">
                                <?php echo e($badgeText); ?>

                            </span>
                        </div>
                        <p class="text-sm text-gray-600">
                            <?php if($isPastDue): ?>
                                Grace ends: <?php echo e($license->grace_period_ends_at?->format('M d, Y')); ?>

                            <?php else: ?>
                                <?php echo e(__('app.expires')); ?>: <?php echo e($license->expires_at?->format('M d, Y')); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8"><?php echo e(__('app.all_licenses_up_to_date')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Businesses -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.recent_businesses')); ?></h2>
                <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
                    class="text-green-600 hover:text-green-700 text-sm font-medium"><?php echo e(__('app.view_all')); ?></a>
            </div>

            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentBusinesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('admin.super.businesses.show', $business)); ?>"
                        class="block p-4 bg-gray-50 rounded-lg hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 transition border-l-4 border-green-600">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900"><?php echo e($business->name); ?></p>
                                <p class="text-sm text-gray-600">
                                    <?php echo e($business->users->count()); ?>

                                    <?php echo e($business->users->count() !== 1 ? __('app.users_count') : __('app.user')); ?>

                                </p>
                            </div>
                            <div class="text-right">
                                <?php if($business->license && $business->license->isActive()): ?>
                                    <span
                                        class="text-xs font-bold text-white bg-green-600 px-2 py-1 rounded"><?php echo e(__('app.active')); ?></span>
                                <?php else: ?>
                                    <span
                                        class="text-xs font-bold text-white bg-red-600 px-2 py-1 rounded"><?php echo e(__('app.inactive')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8"><?php echo e(__('app.no_businesses_created')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Paid Subscriptions -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.recent_paid_subscriptions')); ?></h2>
                <a href="<?php echo e(route('admin.super.licenses.index')); ?>"
                    class="text-green-600 hover:text-green-700 text-sm font-medium"><?php echo e(__('app.view_all')); ?></a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $planBadge = ($payment->plan ?? '') === 'plus' ? 'bg-purple-600' : 'bg-blue-600';
                        $borderColor = ($payment->plan ?? '') === 'plus' ? 'border-purple-500' : 'border-blue-500';
                    ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border-l-4 <?php echo e($borderColor); ?>">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate"><?php echo e($payment->business->name ?? '—'); ?></p>
                            <p class="text-xs text-gray-500 mt-0.5">Paid: <?php echo e($payment->paid_at?->format('M d, Y')); ?></p>
                        </div>
                        <div class="text-right ml-3 shrink-0">
                            <div class="flex items-center gap-2 justify-end mb-1">
                                <span class="text-xs font-bold text-white <?php echo e($planBadge); ?> px-2 py-0.5 rounded capitalize"><?php echo e(ucfirst($payment->plan ?? '—')); ?></span>
                                <span class="text-xs text-gray-500 capitalize"><?php echo e($payment->billing_cycle); ?></span>
                            </div>
                            <p class="text-sm font-bold text-green-600"><?php echo e(number_format($payment->amount, 3)); ?> OMR</p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8"><?php echo e(__('app.no_paid_subscriptions')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-purple-300 transition text-center">
            <svg class="w-8 h-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.manage_businesses')); ?></p>
        </a>

        <a href="<?php echo e(route('admin.super.licenses.index')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-green-300 transition text-center">
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.manage_licenses')); ?></p>
        </a>

        <a href="<?php echo e(route('admin.super.users.index')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-green-300 transition text-center">
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 0 0-5.856-3.487M9 20H4v-2a3 3 0 0 1 5.856-3.487m0 0A5.002 5.002 0 0 1 19 12a5 5 0 1 1-10 0z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.manage_users')); ?></p>
        </a>

        <a href="<?php echo e(route('admin.contact-submissions.index')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-green-300 transition text-center relative">
            <?php if($unreadContactSubmissions > 0): ?>
                <span class="absolute top-3 right-3 min-w-[20px] h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold px-1"><?php echo e($unreadContactSubmissions); ?></span>
            <?php endif; ?>
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <p class="font-semibold text-gray-900">Contact Submissions</p>
        </a>
    </div>

    <!-- Recent Contact Submissions -->
    <div class="mt-8 bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-gray-900">Recent Contact Submissions</h2>
                <?php if($unreadContactSubmissions > 0): ?>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span>
                        <?php echo e($unreadContactSubmissions); ?> unread
                    </span>
                <?php endif; ?>
            </div>
            <a href="<?php echo e(route('admin.contact-submissions.index')); ?>"
               class="text-sm text-green-600 hover:text-green-700 font-semibold transition">View all &rarr;</a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $recentContactSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-start gap-4 px-6 py-4 border-b border-gray-50 hover:bg-gray-50 transition <?php echo e($submission->is_read ? '' : 'bg-green-50/30'); ?>">
            <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold flex-shrink-0 text-sm">
                <?php echo e(strtoupper(substr($submission->name, 0, 1))); ?>

            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <p class="font-semibold text-gray-900 text-sm">
                        <?php echo e($submission->name); ?>

                        <?php if (! ($submission->is_read)): ?>
                            <span class="ms-1 inline-block w-2 h-2 rounded-full bg-green-500 align-middle"></span>
                        <?php endif; ?>
                    </p>
                    <span class="text-xs text-gray-400 whitespace-nowrap"><?php echo e($submission->created_at->diffForHumans()); ?></span>
                </div>
                <p class="text-xs text-gray-500 mt-0.5"><?php echo e($submission->email); ?> &middot; <?php echo e($submission->phone); ?></p>
                <?php if($submission->subject): ?>
                    <p class="text-xs font-medium text-gray-700 mt-1"><?php echo e($submission->subject); ?></p>
                <?php endif; ?>
                <p class="text-xs text-gray-400 mt-0.5"><?php echo e(\Illuminate\Support\Str::limit($submission->message, 90)); ?></p>
            </div>
            <a href="<?php echo e(route('admin.contact-submissions.show', $submission)); ?>"
               class="flex-shrink-0 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition">
                View
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="px-6 py-10 text-center text-gray-400 text-sm">No contact submissions yet.</div>
        <?php endif; ?>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/super/dashboard.blade.php ENDPATH**/ ?>