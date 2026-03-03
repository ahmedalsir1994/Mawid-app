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
                <h1 class="text-3xl font-bold text-gray-900"><?php echo e(__('app.edit_user')); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e(__('app.update_user_permissions')); ?></p>
            </div>
            <a href="<?php echo e(route('admin.super.users.index')); ?>"
                class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                <?php echo e(__('app.back')); ?>

            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form action="<?php echo e(route('admin.super.users.update', $user)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.full_name')); ?>

                        *</label>
                    <input lang="en" dir="ltr" type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Email (Read-only) -->
                <div>
                    <label for="email"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.email')); ?></label>
                    <input lang="en" dir="ltr" type="email" name="email" id="email" value="<?php echo e($user->email); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600" readonly>
                    <p class="text-gray-600 text-sm mt-1"><?php echo e(__('app.email_cannot_change')); ?></p>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.role')); ?>

                        *</label>
                    <select lang="en" dir="ltr" name="role" id="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required
                        onchange="document.getElementById('business_id').disabled = this.value === 'super_admin'">
                        <option value=""><?php echo e(__('app.select_role')); ?></option>
                        <option value="super_admin" <?php if(old('role', $user->role) === 'super_admin'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.super_admin')); ?>

                        </option>
                        <option value="company_admin" <?php if(old('role', $user->role) === 'company_admin'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.company_admin')); ?></option>
                        <option value="staff" <?php if(old('role', $user->role) === 'staff'): echo 'selected'; endif; ?>><?php echo e(__('app.staff')); ?>

                        </option>
                        <option value="customer" <?php if(old('role', $user->role) === 'customer'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.customer')); ?></option>
                    </select>
                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Business -->
                <div>
                    <label for="business_id"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.business')); ?></label>
                    <select lang="en" dir="ltr" name="business_id" id="business_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        <?php if(old('role', $user->role) === 'super_admin'): echo 'disabled'; endif; ?>>
                        <option value=""><?php echo e(__('app.no_business')); ?></option>
                        <?php $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($business->id); ?>" <?php if(old('business_id', $user->business_id) == $business->id): echo 'selected'; endif; ?>>
                                <?php echo e($business->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['business_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="text-gray-600 text-sm mt-1"><?php echo e(__('app.super_admin_no_business')); ?></p>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.status')); ?></label>
                    <select lang="en" dir="ltr" name="is_active" id="is_active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <option value="0" <?php if(!$user->is_active): echo 'selected'; endif; ?>><?php echo e(__('app.inactive')); ?></option>
                        <option value="1" <?php if($user->is_active): echo 'selected'; endif; ?>><?php echo e(__('app.active')); ?></option>
                    </select>
                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Password Section -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4"><?php echo e(__('app.change_password_optional')); ?></h3>
                <p class="text-gray-600 text-sm mb-4"><?php echo e(__('app.leave_blank_keep_password')); ?></p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div>
                        <label for="password"
                            class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.new_password')); ?></label>
                        <input lang="en" dir="ltr" type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                            placeholder="<?php echo e(__('app.enter_new_password_optional')); ?>">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.confirm_password')); ?></label>
                        <input lang="en" dir="ltr" type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                            placeholder="<?php echo e(__('app.confirm_new_password_optional')); ?>">
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="border-t border-gray-200 pt-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm"><?php echo e(__('app.created')); ?></p>
                        <p class="font-semibold text-gray-900"><?php echo e($user->created_at->format('M d, Y')); ?></p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm"><?php echo e(__('app.last_updated')); ?></p>
                        <p class="font-semibold text-gray-900"><?php echo e($user->updated_at->format('M d, Y')); ?></p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm"><?php echo e(__('app.status')); ?></p>
                        <p class="font-semibold">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($user->is_active ? __('app.active') : __('app.inactive')); ?>

                            </span>
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm"><?php echo e(__('app.user_id')); ?></p>
                        <p class="font-semibold text-gray-900 font-mono text-sm">#<?php echo e($user->id); ?></p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <form action="<?php echo e(route('admin.super.users.destroy', $user)); ?>" method="POST" class="inline"
                    onsubmit="return confirm('<?php echo e(__('app.delete_user_undone_confirm')); ?>')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <?php echo e(__('app.delete_user')); ?>

                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="<?php echo e(route('admin.super.users.index')); ?>"
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                        <?php echo e(__('app.cancel')); ?>

                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-600 text-white rounded-lg hover:shadow-lg transition font-medium">
                        <?php echo e(__('app.update_user')); ?>

                    </button>
                </div>
            </div>
        </form>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views\admin\super\users\edit.blade.php ENDPATH**/ ?>