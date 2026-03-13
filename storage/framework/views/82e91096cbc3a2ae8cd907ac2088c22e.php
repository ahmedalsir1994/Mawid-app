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
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">📋 Manage Plans</h1>
                <p class="text-gray-600 mt-1 text-sm">Create and manage subscription plans available to businesses.</p>
            </div>
            <a href="<?php echo e(route('admin.super.plans.create')); ?>"
                class="shrink-0 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:shadow-lg transition text-sm sm:text-base">
                + New Plan
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Plan</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Monthly</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Yearly</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Branches</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Staff</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Services</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Daily Bookings</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">WhatsApp</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Licenses</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition <?php echo e($plan->is_active ? '' : 'opacity-60'); ?>">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xl"><?php echo e($plan->emoji); ?></span>
                                <div>
                                    <p class="font-semibold text-gray-800"><?php echo e($plan->name); ?></p>
                                    <p class="text-xs text-gray-400 font-mono"><?php echo e($plan->slug); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <?php if($plan->price_monthly > 0): ?>
                                <span class="font-medium text-gray-800"><?php echo e(number_format($plan->price_monthly, 3)); ?></span>
                                <span class="text-xs text-gray-400"> OMR</span>
                            <?php else: ?>
                                <span class="text-green-600 font-medium">Free</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <?php if($plan->price_yearly > 0): ?>
                                <span class="font-medium text-gray-800"><?php echo e(number_format($plan->price_yearly, 3)); ?></span>
                                <span class="text-xs text-gray-400"> OMR</span>
                            <?php else: ?>
                                <span class="text-gray-400">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-700"><?php echo e($plan->max_branches); ?></td>
                        <td class="px-4 py-3 text-center text-gray-700"><?php echo e($plan->max_staff); ?></td>
                        <td class="px-4 py-3 text-center text-gray-700">
                            <?php echo e($plan->max_services === 0 || $plan->max_services >= 999 ? '∞' : $plan->max_services); ?>

                        </td>
                        <td class="px-4 py-3 text-center text-gray-700">
                            <?php echo e($plan->max_daily_bookings === 0 || $plan->max_daily_bookings >= 999 ? '∞' : $plan->max_daily_bookings); ?>

                        </td>
                        <td class="px-4 py-3 text-center">
                            <?php if($plan->whatsapp_reminders): ?>
                                <span class="text-green-500 text-base">✓</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-base">✗</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm text-gray-600"><?php echo e($plan->licenses()->count()); ?></span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <?php if($plan->is_active): ?>
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">Disabled</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.super.plans.edit', $plan)); ?>"
                                    class="px-3 py-1.5 text-xs bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.super.plans.toggle', $plan)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs rounded-lg transition font-medium
                                            <?php echo e($plan->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-green-50 text-green-700 hover:bg-green-100'); ?>">
                                        <?php echo e($plan->is_active ? 'Disable' : 'Enable'); ?>

                                    </button>
                                </form>
                                <form method="POST" action="<?php echo e(route('admin.super.plans.destroy', $plan)); ?>"
                                    onsubmit="return confirm('Delete plan \'<?php echo e($plan->name); ?>\'? This cannot be undone.')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="11" class="px-4 py-10 text-center text-gray-400">
                            No plans found. <a href="<?php echo e(route('admin.super.plans.create')); ?>" class="text-green-600 hover:underline">Create your first plan</a>.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl border border-gray-200 p-4 <?php echo e($plan->is_active ? '' : 'opacity-60'); ?>">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl"><?php echo e($plan->emoji); ?></span>
                        <div>
                            <p class="font-bold text-gray-900"><?php echo e($plan->name); ?></p>
                            <p class="text-xs text-gray-400 font-mono"><?php echo e($plan->slug); ?></p>
                        </div>
                    </div>
                    <?php if($plan->is_active): ?>
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                    <?php else: ?>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">Disabled</span>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Monthly</p>
                        <p class="font-semibold"><?php echo e($plan->price_monthly > 0 ? number_format($plan->price_monthly, 3) . ' OMR' : 'Free'); ?></p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Yearly</p>
                        <p class="font-semibold"><?php echo e($plan->price_yearly > 0 ? number_format($plan->price_yearly, 3) . ' OMR' : '—'); ?></p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Branches / Staff</p>
                        <p class="font-semibold"><?php echo e($plan->max_branches); ?> / <?php echo e($plan->max_staff); ?></p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Services / Daily</p>
                        <p class="font-semibold">
                            <?php echo e($plan->max_services === 0 || $plan->max_services >= 999 ? '∞' : $plan->max_services); ?>

                            /
                            <?php echo e($plan->max_daily_bookings === 0 || $plan->max_daily_bookings >= 999 ? '∞' : $plan->max_daily_bookings); ?>

                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('admin.super.plans.edit', $plan)); ?>"
                        class="flex-1 py-2 text-center text-sm bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                        Edit
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.super.plans.toggle', $plan)); ?>" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit"
                            class="w-full py-2 text-sm rounded-lg transition font-medium
                                <?php echo e($plan->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-green-50 text-green-700 hover:bg-green-100'); ?>">
                            <?php echo e($plan->is_active ? 'Disable' : 'Enable'); ?>

                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('admin.super.plans.destroy', $plan)); ?>" class="flex-1"
                        onsubmit="return confirm('Delete plan \'<?php echo e($plan->name); ?>\'?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full py-2 text-sm bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-10 text-gray-400">
                No plans found. <a href="<?php echo e(route('admin.super.plans.create')); ?>" class="text-green-600 hover:underline">Create one</a>.
            </div>
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/super/plans/index.blade.php ENDPATH**/ ?>