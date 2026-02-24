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
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900"><?php echo e(__('app.manage_licenses')); ?></h1>
            <p class="text-gray-600 mt-2"><?php echo e(__('app.create_manage_licenses')); ?></p>
        </div>
        <a href="<?php echo e(route('admin.super.licenses.create')); ?>"
            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            + <?php echo e(__('app.create_license')); ?>

        </a>
    </div>

    <!-- Licenses Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.business')); ?>

                        </th>
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
                                    <p class="text-sm text-gray-600"><?php echo e($license->business->slug); ?></p>
                                </div>
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
                                    class="text-purple-600 hover:text-purple-700 font-medium">
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
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg mb-2"><?php echo e(__('app.no_licenses_yet')); ?></p>
                                <a href="<?php echo e(route('admin.super.licenses.create')); ?>"
                                    class="text-purple-600 hover:text-purple-700 font-medium">
                                    <?php echo e(__('app.create_first_license')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/super/licenses/index.blade.php ENDPATH**/ ?>