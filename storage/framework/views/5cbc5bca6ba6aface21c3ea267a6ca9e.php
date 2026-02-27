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
                <h1 class="text-3xl font-bold text-gray-900">
                    <?php echo e($user->id ? __('app.edit_user') : __('app.create_user')); ?></h1>
                <p class="text-gray-600 mt-2">
                    <?php echo e($user->id ? __('app.update_user_details') : __('app.add_new_user_platform')); ?>

                </p>
            </div>
            <a href="<?php echo e(route('admin.super.users.index')); ?>"
                class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                <?php echo e(__('app.back')); ?>

            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form action="<?php echo e($user->id ? route('admin.super.users.update', $user) : route('admin.super.users.store')); ?>"
            method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php if($user->id): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.full_name')); ?>

                        *</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
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

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.email')); ?>

                        *</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required <?php if($user->id): echo 'readonly'; endif; ?>>
                    <?php $__errorArgs = ['email'];
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

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.role')); ?>

                        *</label>
                    <select name="role" id="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
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
                    <select name="business_id" id="business_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
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

                <!-- Password -->
                <?php if(!$user->id): ?>
                    <div>
                        <label for="password"
                            class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.password')); ?> *</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            required>
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

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.confirm_password')); ?>

                            *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            required>
                    </div>
                <?php else: ?>
                    <div>
                        <label for="password"
                            class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.password_leave_blank')); ?></label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
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

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.confirm_password')); ?></label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    </div>
                <?php endif; ?>

                <!-- Status -->
                <div>
                    <label for="is_active"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.status')); ?></label>
                    <select name="is_active" id="is_active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="0" <?php if($user->id && !$user->is_active): echo 'selected'; endif; ?>><?php echo e(__('app.inactive')); ?></option>
                        <option value="1" <?php if(!$user->id || $user->is_active): echo 'selected'; endif; ?>><?php echo e(__('app.active')); ?></option>
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

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <?php if($user->id): ?>
                    <form action="<?php echo e(route('admin.super.users.destroy', $user)); ?>" method="POST" class="inline"
                        onsubmit="return confirm('<?php echo e(__('app.delete_user_full_confirm')); ?>')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            <?php echo e(__('app.delete_user')); ?>

                        </button>
                    </form>
                <?php endif; ?>

                <div class="flex gap-3">
                    <a href="<?php echo e(route('admin.super.users.index')); ?>"
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                        <?php echo e(__('app.cancel')); ?>

                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-medium">
                        <?php echo e($user->id ? __('app.update_user') : __('app.create_user')); ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views\admin\super\users\create.blade.php ENDPATH**/ ?>