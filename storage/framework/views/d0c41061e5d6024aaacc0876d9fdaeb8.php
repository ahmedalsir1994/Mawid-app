<div class="space-y-6">
    <p class="text-sm text-gray-600">
        <?php echo e(__('app.delete_account_warning')); ?>

    </p>

    <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')"
        class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
        <?php echo e(__('app.delete_account')); ?>

    </button>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4 p-8">
        <h3 class="text-xl font-bold text-red-900 mb-2"><?php echo e(__('app.delete_account_confirm_title')); ?></h3>
        <p class="text-gray-600 text-sm mb-6">
            <?php echo e(__('app.delete_account_confirm_text')); ?>

        </p>

        <form method="post" action="<?php echo e(route('profile.destroy')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>

            <!-- Password Field -->
            <div>
                <label for="delete_password"
                    class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.confirm_password_label')); ?></label>
                <input type="password" id="delete_password" name="password"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    placeholder="<?php echo e(__('app.enter_your_password')); ?>" required />
                <?php $__errorArgs = ['password', 'userDeletion'];
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

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition">
                    <?php echo e(__('app.cancel')); ?>

                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                    <?php echo e(__('app.delete_account')); ?>

                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\laragon\www\booking-app\resources\views\profile\partials\delete-user-form.blade.php ENDPATH**/ ?>