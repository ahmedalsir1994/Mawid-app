<form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>">
    <?php echo csrf_field(); ?>
</form>

<form method="post" action="<?php echo e(route('profile.update')); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('patch'); ?>

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.full_name')); ?></label>
        <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required autofocus
            autocomplete="name"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="<?php echo e(__('app.enter_full_name')); ?>" />
        <?php $__errorArgs = ['name'];
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

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.email_address')); ?></label>
        <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
            autocomplete="username"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="<?php echo e(__('app.enter_email_address')); ?>" />
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- Email Verification Alert -->
        <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail()): ?>
            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <?php echo e(__('app.email_not_verified')); ?>

                    <button type="submit" form="send-verification"
                        class="font-semibold text-yellow-900 hover:text-yellow-700 underline">
                        <?php echo e(__('app.resend_verification_email')); ?>

                    </button>
                </p>

                <?php if(session('status') === 'verification-link-sent'): ?>
                    <p class="mt-2 text-sm font-medium text-green-600">
                        <?php echo e(__('app.verification_link_sent')); ?>

                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Success Message -->
    <?php if(session('status') === 'profile-updated'): ?>
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-700 font-medium"><?php echo e(__('app.profile_updated_successfully')); ?></p>
        </div>
    <?php endif; ?>

    <!-- Submit Button -->
    <div class="flex items-center justify-end space-x-4">
        <button type="submit"
            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            <?php echo e(__('app.save_changes')); ?>

        </button>
    </div>
</form><?php /**PATH C:\laragon\www\booking-app\resources\views\profile\partials\update-profile-information-form.blade.php ENDPATH**/ ?>