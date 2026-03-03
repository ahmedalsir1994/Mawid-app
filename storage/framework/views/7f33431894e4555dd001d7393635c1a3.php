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
                <h1 class="text-3xl font-bold text-gray-900"><?php echo e($user->name); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e(__('app.user_profile')); ?></p>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.super.users.edit', $user)); ?>"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <?php echo e(__('app.edit')); ?>

                </a>
                <a href="<?php echo e(route('admin.super.users.index')); ?>"
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
                <h2 class="text-xl font-bold text-gray-900 mb-6"><?php echo e(__('app.user_information')); ?></h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.full_name')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($user->name); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.email')); ?></label>
                        <p class="text-gray-900 font-semibold"><?php echo e($user->email); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.role')); ?></label>
                        <span
                            class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                            <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.status')); ?></label>
                        <?php if($user->is_active): ?>
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

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.business')); ?></label>
                        <?php if($user->business): ?>
                            <a href="<?php echo e(route('admin.super.businesses.show', $user->business)); ?>"
                                class="text-purple-600 hover:text-purple-700 font-semibold">
                                <?php echo e($user->business->name); ?>

                            </a>
                        <?php else: ?>
                            <p class="text-gray-600"><?php echo e(__('app.no_business_assigned')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Account Timestamps -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4"><?php echo e(__('app.account_info')); ?></h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.created_at')); ?></label>
                        <p class="text-gray-600"><?php echo e($user->created_at->format('M d, Y H:i A')); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.last_updated')); ?></label>
                        <p class="text-gray-600"><?php echo e($user->updated_at->format('M d, Y H:i A')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Profile Avatar -->
            <div class="bg-gradient-to-br from-green-600 to-green-600 rounded-xl shadow-md p-6 text-center text-white">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl font-bold"><?php echo e(substr($user->name, 0, 1)); ?></span>
                </div>
                <h3 class="text-2xl font-bold"><?php echo e($user->name); ?></h3>
                <p class="text-green-100 mt-2"><?php echo e($user->email); ?></p>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <p class="text-sm text-green-100">Role</p>
                    <p class="text-lg font-semibold"><?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?></p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4"><?php echo e(__('app.quick_actions')); ?></h2>
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.super.users.edit', $user)); ?>"
                        class="w-full block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-medium text-sm">
                        <?php echo e(__('app.edit_user')); ?>

                    </a>
                    <?php if($user->business): ?>
                        <a href="<?php echo e(route('admin.super.businesses.show', $user->business)); ?>"
                            class="w-full block px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition text-center font-medium text-sm">
                            <?php echo e(__('app.view_business')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- License Plan Badge -->
            <?php if($user->business?->license): ?>
            <?php
                $uPlan  = $user->business->license->plan ?? 'free';
                $uBadge = match($uPlan) { 'pro'=>'from-blue-500 to-blue-600','plus'=>'from-purple-500 to-purple-700',default=>'from-gray-400 to-gray-500' };
                $uEmoji = match($uPlan) { 'pro'=>'💼','plus'=>'🚀',default=>'🆓' };
                $uCycle = $user->business->license->billing_cycle ?? 'monthly';
            ?>
            <div class="bg-gradient-to-br <?php echo e($uBadge); ?> rounded-xl shadow-md p-6 mt-6 text-white">
                <p class="text-sm font-medium text-white/80 mb-1"><?php echo e(__('app.plan')); ?></p>
                <p class="text-2xl font-bold"><?php echo e($uEmoji); ?> <?php echo e(ucfirst($uPlan)); ?></p>
                <p class="text-sm text-white/80 mt-1 capitalize"><?php echo e($uCycle); ?></p>
                <?php if($user->business->license->expires_at): ?>
                    <p class="text-xs text-white/70 mt-3 pt-3 border-t border-white/20">
                        Expires: <?php echo e($user->business->license->expires_at->format('M d, Y')); ?>

                    </p>
                <?php else: ?>
                    <p class="text-xs text-white/70 mt-3 pt-3 border-t border-white/20">No expiry</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Status Badge -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-3"><?php echo e(__('app.status')); ?></h3>
                <?php if($user->is_active): ?>
                    <div class="flex items-center gap-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                        <span class="text-green-900 font-semibold"><?php echo e(__('app.active_account')); ?></span>
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-2 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                        <span class="text-gray-900 font-semibold"><?php echo e(__('app.inactive_account')); ?></span>
                    </div>
                <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views\admin\super\users\show.blade.php ENDPATH**/ ?>