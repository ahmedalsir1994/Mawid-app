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
                <h1 class="text-3xl font-bold text-gray-900"><?php echo e(__('app.license_details')); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e($license->business->name); ?></p>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.super.licenses.edit', $license)); ?>"
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                    <?php echo e(__('app.edit')); ?>

                </a>
                <a href="<?php echo e(route('admin.super.licenses.index')); ?>"
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
                <h2 class="text-xl font-bold text-gray-900 mb-6"><?php echo e(__('app.license_information')); ?></h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.business')); ?></label>
                        <a href="<?php echo e(route('admin.super.businesses.show', $license->business)); ?>"
                            class="text-purple-600 hover:text-purple-700 font-semibold">
                            <?php echo e($license->business->name); ?>

                        </a>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.status')); ?></label>
                        <span
                            class="inline-block px-3 py-1 bg-<?php echo e($license->isActive() ? 'green' : 'red'); ?>-100 text-<?php echo e($license->isActive() ? 'green' : 'red'); ?>-700 rounded-full text-sm font-semibold">
                            <?php echo e(ucfirst($license->status)); ?>

                        </span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.license_key')); ?></label>
                        <div class="flex items-center gap-2">
                            <code
                                class="flex-1 px-4 py-2 bg-gray-50 rounded border border-gray-300 text-gray-900 font-mono text-sm">
                                <?php echo e($license->license_key); ?>

                            </code>
                            <button onclick="navigator.clipboard.writeText('<?php echo e($license->license_key); ?>')"
                                class="px-3 py-2 text-gray-600 hover:text-gray-900">
                                <?php echo e(__('app.copy')); ?>

                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.max_users')); ?></label>
                        <p class="text-gray-900 font-semibold text-lg"><?php echo e($license->max_users); ?></p>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.max_daily_bookings')); ?></label>
                        <p class="text-gray-900 font-semibold text-lg"><?php echo e($license->max_daily_bookings); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.price')); ?></label>
                        <p class="text-gray-900 font-semibold text-lg"><?php echo e($license->currency ?? 'USD'); ?>

                            <?php echo e(number_format($license->price, 2)); ?>

                        </p>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.payment_status')); ?></label>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm font-semibold">
                            <?php echo e(ucfirst($license->payment_status)); ?>

                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.expires_at')); ?></label>
                        <p class="text-gray-900 font-semibold">
                            <?php if($license->expires_at): ?>
                                <?php echo e(\Carbon\Carbon::parse($license->expires_at)->format('M d, Y')); ?>

                                <small class="text-gray-600">
                                    <?php if(!$license->isActive() && $license->expires_at->isPast()): ?>
                                        <span class="text-red-600">(<?php echo e(__('app.expired_days')); ?>

                                            <?php echo e($license->daysUntilExpiry()); ?> <?php echo e(__('app.days_ago_full')); ?>)</span>
                                    <?php elseif($license->isExpiring()): ?>
                                        (<?php echo e($license->daysUntilExpiry()); ?> <?php echo e(__('app.days_left_full')); ?>)
                                    <?php elseif($license->isActive()): ?>
                                        (<?php echo e($license->daysUntilExpiry()); ?> <?php echo e(__('app.days_left_full')); ?>)
                                    <?php endif; ?>
                                </small>
                            <?php else: ?>
                                <?php echo e(__('app.never')); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Quick Stats -->
            <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl shadow-md p-6 text-white">
                <h2 class="text-lg font-bold mb-4"><?php echo e(__('app.license_status')); ?></h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-purple-100"><?php echo e(__('app.status')); ?></span>
                        <span class="font-bold"><?php echo e(ucfirst($license->status)); ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-100"><?php echo e(__('app.users_used')); ?></span>
                        <span class="font-bold"><?php echo e($license->business->users->count()); ?> /
                            <?php echo e($license->max_users); ?></span>
                    </div>
                    <?php if($license->expires_at): ?>
                        <div class="flex items-center justify-between">
                            <span class="text-purple-100">
                                <?php if(!$license->isActive() && $license->expires_at->isPast()): ?>
                                    <?php echo e(__('app.days_expired')); ?>

                                <?php else: ?>
                                    <?php echo e(__('app.days_remaining')); ?>

                                <?php endif; ?>
                            </span>
                            <span class="font-bold"><?php echo e($license->daysUntilExpiry()); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4"><?php echo e(__('app.quick_actions')); ?></h2>
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.super.licenses.edit', $license)); ?>"
                        class="w-full block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-center font-medium text-sm">
                        <?php echo e(__('app.edit_license_action')); ?>

                    </a>
                    <?php if(!$license->isActive()): ?>
                        <form method="POST" action="<?php echo e(route('admin.super.licenses.reactivate', $license)); ?>"
                            class="w-full">
                            <?php echo csrf_field(); ?>
                            <button type="submit" onclick="return confirm('<?php echo e(__('app.reactivate_license_confirm')); ?>')"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-medium text-sm">
                                ✓ <?php echo e(__('app.reactivate_license')); ?>

                            </button>
                        </form>
                    <?php endif; ?>
                    <a href="<?php echo e(route('admin.super.businesses.show', $license->business)); ?>"
                        class="w-full block px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition text-center font-medium text-sm">
                        <?php echo e(__('app.view_business')); ?>

                    </a>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/super/licenses/show.blade.php ENDPATH**/ ?>