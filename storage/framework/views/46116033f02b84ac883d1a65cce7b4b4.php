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
            <div>
                <h1 class="text-3xl font-bold text-gray-900"><?php echo e($business->name); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e(__('app.business_details')); ?></p>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.super.businesses.edit', $business)); ?>"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <?php echo e(__('app.edit')); ?>

                </a>
                <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
                    class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                    <?php echo e(__('app.back')); ?>

                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6"><?php echo e(__('app.business_information')); ?></h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.business_name')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($business->name); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.slug')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($business->slug); ?></p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.address')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($business->address); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.country')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($business->country); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.phone')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($business->phone); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.currency')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($business->currency); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.timezone')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($business->timezone); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.status')); ?></label>
                        <?php if($business->is_active): ?>
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                <?php echo e(__('app.active')); ?>

                            </span>
                        <?php else: ?>
                            <span
                                class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                                <?php echo e(__('app.inactive')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4"><?php echo e(__('app.services')); ?></h2>
                <?php if($business->services && $business->services->count()): ?>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $business->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900"><?php echo e($service->name); ?></span>
                                <span class="text-gray-600 text-sm"><?php echo e($service->duration); ?> <?php echo e(__('app.mins')); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600"><?php echo e(__('app.no_services_created_yet')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- License Info -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4"><?php echo e(__('app.license')); ?></h2>
                <?php if($business->license): ?>
                    <div class="space-y-3">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1"><?php echo e(__('app.license_key')); ?></label>
                            <p class="text-sm text-gray-900 font-mono break-all"><?php echo e($business->license->license_key); ?></p>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1"><?php echo e(__('app.status')); ?></label>
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                <?php echo e(ucfirst($business->license->status)); ?>

                            </span>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1"><?php echo e(__('app.max_users')); ?></label>
                            <p class="text-sm text-gray-900"><?php echo e($business->license->max_users); ?></p>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1"><?php echo e(__('app.expires_at')); ?></label>
                            <p class="text-sm text-gray-900">
                                <?php if($business->license->expires_at): ?>
                                    <?php echo e(\Carbon\Carbon::parse($business->license->expires_at)->format('M d, Y')); ?>

                                <?php else: ?>
                                    <?php echo e(__('app.never')); ?>

                                <?php endif; ?>
                            </p>
                        </div>

                        <a href="<?php echo e(route('admin.super.licenses.edit', $business->license)); ?>"
                            class="w-full mt-3 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-medium text-sm">
                            <?php echo e(__('app.manage_license')); ?>

                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 text-sm mb-4"><?php echo e(__('app.no_license_assigned')); ?></p>
                    <a href="<?php echo e(route('admin.super.licenses.create')); ?>"
                        class="w-full inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-medium text-sm">
                        <?php echo e(__('app.create_license')); ?>

                    </a>
                <?php endif; ?>
            </div>

            <!-- Team Members -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4"><?php echo e(__('app.team_members')); ?></h2>
                <?php if($business->users && $business->users->count()): ?>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $business->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-green-600 to-green-700 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold"><?php echo e(substr($user->name, 0, 1)); ?></span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($user->name); ?></p>
                                    <p class="text-xs text-gray-600"><?php echo e(ucfirst($user->role)); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 text-sm"><?php echo e(__('app.no_team_members')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Stats -->
            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-md p-6 mt-6 text-white">
                <h2 class="text-lg font-bold mb-4"><?php echo e(__('app.quick_stats')); ?></h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-green-100 text-sm"><?php echo e(__('app.total_team')); ?></p>
                        <p class="text-2xl font-bold"><?php echo e($business->users ? $business->users->count() : 0); ?></p>
                    </div>
                    <div>
                        <p class="text-green-100 text-sm"><?php echo e(__('app.services')); ?></p>
                        <p class="text-2xl font-bold"><?php echo e($business->services ? $business->services->count() : 0); ?></p>
                    </div>
                </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/super/businesses/show.blade.php ENDPATH**/ ?>