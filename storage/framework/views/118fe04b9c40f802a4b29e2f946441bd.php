<?php echo csrf_field(); ?>

<!-- Name -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.branch_name')); ?> <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="<?php echo e(old('name', $branch->name ?? '')); ?>"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-500 outline-none transition"
           placeholder="<?php echo e(__('app.branch_name_placeholder')); ?>" required>
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<!-- Address -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.address')); ?></label>
    <input type="text" name="address" value="<?php echo e(old('address', $branch->address ?? '')); ?>"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-500 outline-none transition"
           placeholder="<?php echo e(__('app.address_placeholder')); ?>">
    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<!-- Phone -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.phone')); ?></label>
    <input type="text" name="phone" value="<?php echo e(old('phone', $branch->phone ?? '')); ?>"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-500 outline-none transition"
           placeholder="+968 99999999">
    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<!-- Active toggle -->
<div class="flex items-center gap-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" id="is_active"
           <?php echo e(old('is_active', ($branch->is_active ?? true) ? '1' : '0') == '1' ? 'checked' : ''); ?>

           class="w-5 h-5 rounded text-purple-600 focus:ring-purple-400">
    <label for="is_active" class="text-sm font-medium text-gray-700"><?php echo e(__('app.branch_is_active')); ?></label>
</div>
<?php /**PATH C:\laragon\www\booking-app\resources\views/admin/branches/_form.blade.php ENDPATH**/ ?>