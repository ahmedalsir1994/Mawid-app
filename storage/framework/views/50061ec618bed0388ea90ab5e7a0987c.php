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
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-start justify-between gap-y-4">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900"><?php echo e(__('app.manage_licenses')); ?></h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base"><?php echo e(__('app.create_manage_licenses')); ?></p>
            </div>
            <a href="<?php echo e(route('admin.super.licenses.create')); ?>"
                class="shrink-0 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transition text-sm sm:text-base">
                + <?php echo e(__('app.create_license')); ?>

            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="<?php echo e(route('admin.super.licenses.index')); ?>" class="mb-6 flex flex-wrap gap-3 items-center">
        
        <div class="relative flex-1 min-w-[220px]">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input
                type="text"
                name="search"
                value="<?php echo e(request('search')); ?>"
                placeholder="Search by business name or license key..."
                class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white"
            />
        </div>

        
        <div class="relative">
            <select name="plan" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Plans</option>
                <option value="free"  <?php if(request('plan') === 'free'): echo 'selected'; endif; ?>>🆓 Free</option>
                <option value="pro"   <?php if(request('plan') === 'pro'): echo 'selected'; endif; ?>>💼 Pro</option>
                <option value="plus"  <?php if(request('plan') === 'plus'): echo 'selected'; endif; ?>>🚀 Plus</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        
        <div class="relative">
            <select name="status" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Statuses</option>
                <option value="active"    <?php if(request('status') === 'active'): echo 'selected'; endif; ?>>Active</option>
                <option value="expired"   <?php if(request('status') === 'expired'): echo 'selected'; endif; ?>>Expired</option>
                <option value="suspended" <?php if(request('status') === 'suspended'): echo 'selected'; endif; ?>>Suspended</option>
                <option value="cancelled" <?php if(request('status') === 'cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        
        <div class="relative">
            <select name="payment" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Payments</option>
                <option value="paid"   <?php if(request('payment') === 'paid'): echo 'selected'; endif; ?>>Paid</option>
                <option value="unpaid" <?php if(request('payment') === 'unpaid'): echo 'selected'; endif; ?>>Unpaid</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            Search
        </button>
        <?php if(request('search') || request('plan') || request('status') || request('payment')): ?>
            <a href="<?php echo e(route('admin.super.licenses.index')); ?>" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Clear
            </a>
        <?php endif; ?>
    </form>

    <!-- Licenses Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $planBadge = match($license->plan ?? 'free') {
                        'pro'  => 'bg-blue-100 text-blue-800',
                        'plus' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-100 text-gray-700',
                    };
                    $planEmoji = match($license->plan ?? 'free') {
                        'pro'  => '💼',
                        'plus' => '🚀',
                        default => '🆓',
                    };
                ?>
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm"><?php echo e($license->business->name); ?></p>
                            <a href="<?php echo e(route('public.business', $license->business->slug)); ?>" target="_blank"
                               class="text-xs text-green-600 hover:underline"><?php echo e($license->business->slug); ?></a>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold <?php echo e($planBadge); ?> shrink-0">
                            <?php echo e($planEmoji); ?> <?php echo e(ucfirst($license->plan ?? 'free')); ?>

                            <?php if(($license->plan ?? 'free') !== 'free'): ?>
                                / <?php echo e(ucfirst($license->billing_cycle)); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="mb-2">
                        <code class="text-xs bg-gray-100 px-2 py-0.5 rounded"><?php echo e($license->license_key); ?></code>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 mb-3 text-xs">
                        <?php if($license->expires_at): ?>
                            <span class="text-gray-500"><?php echo e($license->expires_at->format('M d, Y')); ?></span>
                            <?php if($license->isExpiring()): ?>
                                <span class="font-bold text-orange-600"><?php echo e($license->daysUntilExpiry()); ?><?php echo e(__('app.days_left')); ?></span>
                            <?php elseif(!$license->isActive() && $license->expires_at->isPast()): ?>
                                <span class="font-bold text-red-600"><?php echo e($license->daysUntilExpiry()); ?><?php echo e(__('app.days_ago')); ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-gray-500"><?php echo e(__('app.no_expiry')); ?></span>
                        <?php endif; ?>
                        <span class="px-2 py-0.5 rounded-full font-bold
                            <?php if($license->isActive()): ?> bg-green-100 text-green-800
                            <?php elseif($license->status === 'expired'): ?> bg-red-100 text-red-800
                            <?php elseif($license->status === 'suspended'): ?> bg-yellow-100 text-yellow-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                            <?php echo e(ucfirst($license->status)); ?>

                        </span>
                        <span class="px-2 py-0.5 rounded-full font-bold
                            <?php if($license->payment_status === 'paid'): ?> bg-green-100 text-green-800
                            <?php else: ?> bg-orange-100 text-orange-800 <?php endif; ?>">
                            <?php echo e(ucfirst($license->payment_status)); ?>

                        </span>
                        <span class="font-semibold text-gray-900">$<?php echo e(number_format($license->price, 2)); ?></span>
                    </div>
                    <div class="flex gap-3 text-xs">
                        <a href="<?php echo e(route('admin.super.licenses.show', $license)); ?>" class="text-green-600 hover:text-green-700 font-medium"><?php echo e(__('app.view')); ?></a>
                        <a href="<?php echo e(route('admin.super.licenses.edit', $license)); ?>" class="text-blue-600 hover:text-blue-700 font-medium"><?php echo e(__('app.edit')); ?></a>
                        <form method="POST" action="<?php echo e(route('admin.super.licenses.destroy', $license)); ?>" class="inline" onsubmit="return confirm('<?php echo e(__('app.delete_license_confirm')); ?>')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-red-600 hover:text-red-700 font-medium"><?php echo e(__('app.delete')); ?></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-12 text-center text-gray-500">
                    <p class="text-lg mb-2"><?php echo e(__('app.no_licenses_yet')); ?></p>
                    <a href="<?php echo e(route('admin.super.licenses.create')); ?>" class="text-green-600 hover:text-green-700 font-medium"><?php echo e(__('app.create_first_license')); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.business')); ?>

                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.plan')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.license_key')); ?>

                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.expires')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.status')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.payment')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.price')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo e($license->business->name); ?></p>
                                    <a href="<?php echo e(route('public.business', $license->business->slug)); ?>" target="_blank"
                                       class="inline-flex items-center gap-1 text-sm text-green-600 hover:text-green-800 hover:underline transition">
                                        <?php echo e($license->business->slug); ?>

                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                    $planBadge = match($license->plan ?? 'free') {
                                        'pro'  => 'bg-blue-100 text-blue-800',
                                        'plus' => 'bg-purple-100 text-purple-800',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                    $planEmoji = match($license->plan ?? 'free') {
                                        'pro'  => '💼',
                                        'plus' => '🚀',
                                        default => '🆓',
                                    };
                                ?>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold <?php echo e($planBadge); ?>">
                                    <?php echo e($planEmoji); ?> <?php echo e(ucfirst($license->plan ?? 'free')); ?>

                                </span>
                                <?php if(($license->plan ?? 'free') !== 'free'): ?>
                                    <p class="text-xs text-gray-400 mt-1 capitalize"><?php echo e($license->billing_cycle); ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded"><?php echo e($license->license_key); ?></code>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php if($license->expires_at): ?>
                                    <?php echo e($license->expires_at->format('M d, Y')); ?>

                                    <?php if($license->isExpiring()): ?>
                                        <span
                                            class="ml-2 text-xs font-bold text-orange-600"><?php echo e($license->daysUntilExpiry()); ?><?php echo e(__('app.days_left')); ?></span>
                                    <?php elseif(!$license->isActive() && $license->expires_at->isPast()): ?>
                                        <span class="ml-2 text-xs font-bold text-red-600"><?php echo e(__('app.expired_days_ago')); ?>

                                            <?php echo e($license->daysUntilExpiry()); ?><?php echo e(__('app.days_ago')); ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo e(__('app.no_expiry')); ?>

                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                <?php if($license->isActive()): ?> 
                                                    bg-green-100 text-green-800
                                                <?php elseif($license->status === 'expired'): ?>
                                                    bg-red-100 text-red-800
                                                <?php elseif($license->status === 'suspended'): ?>
                                                    bg-yellow-100 text-yellow-800
                                                <?php else: ?>
                                                    bg-gray-100 text-gray-800
                                                <?php endif; ?>
                                            ">
                                    <?php echo e(ucfirst($license->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                <?php if($license->payment_status === 'paid'): ?> 
                                                    bg-green-100 text-green-800
                                                <?php else: ?>
                                                    bg-orange-100 text-orange-800
                                                <?php endif; ?>
                                            ">
                                    <?php echo e(ucfirst($license->payment_status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                $<?php echo e(number_format($license->price, 2)); ?>

                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="<?php echo e(route('admin.super.licenses.show', $license)); ?>"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    <?php echo e(__('app.view')); ?>

                                </a>
                                <a href="<?php echo e(route('admin.super.licenses.edit', $license)); ?>"
                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                    <?php echo e(__('app.edit')); ?>

                                </a>
                                <form method="POST" action="<?php echo e(route('admin.super.licenses.destroy', $license)); ?>"
                                    class="inline" onsubmit="return confirm('<?php echo e(__('app.delete_license_confirm')); ?>')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button
                                        class="text-red-600 hover:text-red-700 font-medium"><?php echo e(__('app.delete')); ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg mb-2"><?php echo e(__('app.no_licenses_yet')); ?></p>
                                <a href="<?php echo e(route('admin.super.licenses.create')); ?>"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    <?php echo e(__('app.create_first_license')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div><!-- end desktop table -->
    </div>

    <!-- Pagination -->
    <?php if($licenses->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($licenses->links()); ?>

        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/super/licenses/index.blade.php ENDPATH**/ ?>