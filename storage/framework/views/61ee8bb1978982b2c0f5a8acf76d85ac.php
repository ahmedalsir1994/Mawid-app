<form method="post" action="<?php echo e(route('password.update')); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('put'); ?>

    <!-- Current Password Field -->
    <div>
        <label for="update_password_current_password"
            class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.current_password')); ?></label>
        <input lang="en" dir="ltr" type="password" id="update_password_current_password" name="current_password"
            autocomplete="current-password"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="<?php echo e(__('app.enter_current_password')); ?>" />
        <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- New Password Field -->
    <div>
        <label for="update_password_password"
            class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.new_password')); ?></label>
        <input lang="en" dir="ltr" type="password" id="update_password_password" name="password" autocomplete="new-password"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="<?php echo e(__('app.enter_new_password')); ?>" />
        <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <p class="mt-2 text-xs text-gray-500"><?php echo e(__('app.password_min_length')); ?></p>
    </div>

    <!-- Confirm Password Field -->
    <div>
        <label for="update_password_password_confirmation"
            class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.confirm_password')); ?></label>
        <input lang="en" dir="ltr" type="password" id="update_password_password_confirmation" name="password_confirmation"
            autocomplete="new-password"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
            placeholder="<?php echo e(__('app.confirm_new_password')); ?>" />
        <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Success Message -->
    <?php if(session('status') === 'password-updated'): ?>
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-700 font-medium"><?php echo e(__('app.password_updated_successfully')); ?></p>
        </div>
    <?php endif; ?>

    <!-- Submit Button -->
    <div class="flex items-center justify-end">
        <button type="submit"
            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            <?php echo e(__('app.update_password')); ?>

        </button>
    </div>
</form><?php /**PATH C:\laragon\www\Mawid-app\resources\views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>