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
            <h1 class="text-4xl font-bold text-gray-900"><?php echo e(__('app.manage_businesses')); ?></h1>
            <p class="text-gray-600 mt-2"><?php echo e(__('app.view_manage_all_businesses')); ?></p>
        </div>
        <a href="<?php echo e(route('admin.super.businesses.create')); ?>"
            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            + <?php echo e(__('app.add_business')); ?>

        </a>
    </div>

    <!-- Businesses Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                            <?php echo e(__('app.business_name')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.location')); ?>

                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.users_count')); ?>

                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.license')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.status')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo e($business->name); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo e($business->slug); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($business->address); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="font-bold text-purple-600"><?php echo e($business->users->count()); ?></span>
                                <span class="text-gray-600"><?php echo e(__('app.users')); ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <?php if($business->license): ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                        <?php if($business->license->isActive()): ?> 
                                                            bg-green-100 text-green-800
                                                        <?php else: ?>
                                                            bg-red-100 text-red-800
                                                        <?php endif; ?>
                                                    ">
                                        <?php echo e(ucfirst($business->license->status)); ?>

                                    </span>
                                <?php else: ?>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800"><?php echo e(__('app.no_license')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            <?php if($business->is_active): ?> 
                                                bg-blue-100 text-blue-800
                                            <?php else: ?>
                                                bg-gray-100 text-gray-800
                                            <?php endif; ?>
                                        ">
                                    <?php if($business->is_active): ?> <?php echo e(__('app.active')); ?> <?php else: ?> <?php echo e(__('app.inactive')); ?> <?php endif; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="<?php echo e(route('admin.super.businesses.show', $business)); ?>"
                                    class="text-purple-600 hover:text-purple-700 font-medium">
                                    <?php echo e(__('app.view')); ?>

                                </a>
                                <a href="<?php echo e(route('admin.super.businesses.edit', $business)); ?>"
                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                    <?php echo e(__('app.edit')); ?>

                                </a>
                                <form method="POST" action="<?php echo e(route('admin.super.businesses.destroy', $business)); ?>"
                                    class="inline" onsubmit="return confirm('<?php echo e(__('app.delete_business_confirm')); ?>')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button
                                        class="text-red-600 hover:text-red-700 font-medium"><?php echo e(__('app.delete')); ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg mb-2"><?php echo e(__('app.no_businesses_yet')); ?></p>
                                <a href="<?php echo e(route('admin.super.businesses.create')); ?>"
                                    class="text-purple-600 hover:text-purple-700 font-medium">
                                    <?php echo e(__('app.create_first_business')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($businesses->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($businesses->links()); ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views\admin\super\businesses\index.blade.php ENDPATH**/ ?>