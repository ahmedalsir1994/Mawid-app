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
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('admin.staff.index')); ?>" class="text-gray-600 hover:text-gray-900 transition">
                    ← <?php echo e(__('app.back_to_staff')); ?>

                </a>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.staff.edit', $staff)); ?>"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition">
                    ✏️ <?php echo e(__('app.edit')); ?>

                </a>
                <form action="<?php echo e(route('admin.staff.destroy', $staff)); ?>" method="POST"
                    onsubmit="return confirm('<?php echo e(__('app.delete_staff_confirm')); ?>')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2 rounded-lg transition">
                        🗑️ <?php echo e(__('app.delete')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="text-center">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span
                            class="text-4xl font-bold text-green-600"><?php echo e(strtoupper(substr($staff->name, 0, 1))); ?></span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900"><?php echo e($staff->name); ?></h2>
                    <p class="text-gray-600 mt-1"><?php echo e($staff->email); ?></p>

                    <div class="mt-4">
                        <?php if($staff->is_active): ?>
                            <span
                                class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                ✓ <?php echo e(__('app.active')); ?>

                            </span>
                        <?php else: ?>
                            <span
                                class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                ✗ <?php echo e(__('app.inactive')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600"><?php echo e(__('app.role')); ?>:</span>
                        <span class="ml-2 font-medium text-gray-900"><?php echo e(__('app.staff')); ?></span>
                    </div>

                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600"><?php echo e(__('app.joined')); ?>:</span>
                        <span class="ml-2 font-medium text-gray-900"><?php echo e($staff->created_at->format('M d, Y')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6"><?php echo e(__('app.staff_information')); ?></h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 mb-1"><?php echo e(__('app.full_name')); ?></label>
                            <p class="text-base text-gray-900"><?php echo e($staff->name); ?></p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 mb-1"><?php echo e(__('app.email_address')); ?></label>
                            <p class="text-base text-gray-900"><?php echo e($staff->email); ?></p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 mb-1"><?php echo e(__('app.account_status')); ?></label>
                            <p class="text-base text-gray-900">
                                <?php if($staff->is_active): ?>
                                    <span class="text-green-600 font-medium"><?php echo e(__('app.active')); ?></span>
                                <?php else: ?>
                                    <span class="text-red-600 font-medium"><?php echo e(__('app.inactive')); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1"><?php echo e(__('app.role')); ?></label>
                            <p class="text-base text-gray-900"><?php echo e(__('app.staff')); ?></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1"><?php echo e(__('app.branch')); ?></label>
                            <?php if($staff->branch): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    📍 <?php echo e($staff->branch->name); ?>

                                </span>
                            <?php else: ?>
                                <p class="text-sm text-gray-400 italic"><?php echo e(__('app.no_branch_assigned') ?? 'No specific branch'); ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 mb-1"><?php echo e(__('app.member_since')); ?></label>
                            <p class="text-base text-gray-900"><?php echo e($staff->created_at->format('F d, Y')); ?></p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 mb-1"><?php echo e(__('app.last_updated')); ?></label>
                            <p class="text-base text-gray-900"><?php echo e($staff->updated_at->format('F d, Y')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Info -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mt-6">
                <h4 class="font-bold text-blue-900 mb-3">📋 <?php echo e(__('app.staff_permissions')); ?></h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <?php echo e(__('app.view_manage_bookings')); ?>

                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <?php echo e(__('app.access_staff_dashboard')); ?>

                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <?php echo e(__('app.receive_booking_notifications')); ?>

                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <?php echo e(__('app.view_calendar_schedules')); ?>

                    </li>
                </ul>
            </div>
        </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/staff/show.blade.php ENDPATH**/ ?>