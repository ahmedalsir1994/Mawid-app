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
            <p class="text-3xl font-bold text-gray-900">$<?php echo e(number_format($totalRevenue, 0)); ?></p>
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
            <p class="text-3xl font-bold text-gray-900">$<?php echo e(number_format($pendingRevenue, 0)); ?></p>
            <p class="text-sm text-orange-600 mt-2"><?php echo e(__('app.awaiting_payment')); ?></p>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.total_users')); ?></h3>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($totalUsers); ?></p>
            <p class="text-sm text-gray-600 mt-2"><?php echo e(__('app.across_all_businesses')); ?></p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Performing Businesses -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.top_performing_businesses')); ?></h2>
                <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
                    class="text-purple-600 hover:text-purple-700 text-sm font-medium"><?php echo e(__('app.view_all')); ?></a>
            </div>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $topBusinesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900"><?php echo e($business->name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($business->address); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-purple-600"><?php echo e($business->bookings_count); ?></p>
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
                    class="text-purple-600 hover:text-purple-700 text-sm font-medium"><?php echo e(__('app.manage')); ?></a>
            </div>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $expiringLicensesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="p-4 <?php echo e($license->isActive() ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200'); ?> rounded-lg border hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-gray-900"><?php echo e($license->business->name); ?></p>
                            <span
                                class="text-xs font-bold text-white <?php echo e($license->isActive() ? 'bg-yellow-600' : 'bg-red-600'); ?> px-2 py-1 rounded">
                                <?php if($license->isActive()): ?>
                                    <?php echo e(__('app.days_left', ['days' => $license->daysUntilExpiry()])); ?>

                                <?php else: ?>
                                    <?php echo e(__('app.expired_days_ago', ['days' => abs($license->daysUntilExpiry())])); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">
                            <?php echo e(__('app.expires')); ?>: <?php echo e($license->expires_at?->format('M d, Y')); ?>

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
                    class="text-purple-600 hover:text-purple-700 text-sm font-medium"><?php echo e(__('app.view_all')); ?></a>
            </div>

            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentBusinesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('admin.super.businesses.show', $business)); ?>"
                        class="block p-4 bg-gray-50 rounded-lg hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition border-l-4 border-purple-600">
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
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-purple-300 transition text-center">
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.manage_licenses')); ?></p>
        </a>

        <a href="<?php echo e(route('admin.super.users.index')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-purple-300 transition text-center">
            <svg class="w-8 h-8 text-purple-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 0 0-5.856-3.487M9 20H4v-2a3 3 0 0 1 5.856-3.487m0 0A5.002 5.002 0 0 1 19 12a5 5 0 1 1-10 0z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.manage_users')); ?></p>
        </a>

        <a href="#"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-purple-300 transition text-center">
            <svg class="w-8 h-8 text-orange-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.platform_analytics')); ?></p>
        </a>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views\admin\super\dashboard.blade.php ENDPATH**/ ?>