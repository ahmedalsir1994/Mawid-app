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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-800"><?php echo e(__('app.services')); ?></h2>
                <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.manage_business_services')); ?></p>
            </div>
            <a href="<?php echo e(route('admin.services.create')); ?>"
                class="px-6 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold hover:shadow-lg transition">
                <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                <?php echo e(__('app.add_service')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if($services->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4m0 0L4 7m16 0l-8 4m0 0l8 4m-8-4v10l-8-4m0 0l8-4m0 4v10"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e(__('app.no_services_yet')); ?></h3>
            <p class="text-gray-600 mb-6"><?php echo e(__('app.create_first_service')); ?></p>
            <a href="<?php echo e(route('admin.services.create')); ?>"
                class="inline-block px-6 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold hover:shadow-lg transition">
                <?php echo e(__('app.create_your_first_service')); ?>

            </a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.service_table_name')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.duration')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.price')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.status')); ?></th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-800"><?php echo e($service->name); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.414 1.414L8 13.414V6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span><?php echo e($service->duration_minutes); ?> <?php echo e(__('app.min')); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-800">
                                        <?php if($service->price !== null): ?>
                                            <?php echo e(number_format($service->price, 2)); ?>

                                        <?php else: ?>
                                            <span class="text-gray-400"><?php echo e(__('app.not_set')); ?></span>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($service->is_active): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                            <?php echo e(__('app.active')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <span class="w-2 h-2 bg-gray-600 rounded-full mr-2"></span>
                                            <?php echo e(__('app.inactive')); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="<?php echo e(route('admin.services.edit', $service)); ?>"
                                            class="px-4 py-2 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </a>

                                        <form method="POST" action="<?php echo e(route('admin.services.destroy', $service)); ?>"
                                            class="inline" onsubmit="return confirm('<?php echo e(__('app.delete_service_confirm')); ?>');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <p class="text-sm text-gray-600"><?php echo e(__('app.showing_services', ['count' => $services->count()])); ?></p>
            </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/services/index.blade.php ENDPATH**/ ?>