<?php if (isset($component)) { $__componentOriginal951024bfcf58033c82ac11d797616473 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal951024bfcf58033c82ac11d797616473 = $attributes; } ?>
<?php $component = App\View\Components\UserLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\UserLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- Back Button -->
    <div class="mb-6">
        <a href="<?php echo e(route('admin.dashboard')); ?>"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <?php echo e(__('app.back_to_dashboard')); ?>

        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900"><?php echo e(__('app.profile_settings')); ?></h1>
        <p class="text-gray-600 mt-2"><?php echo e(__('app.manage_account_preferences')); ?></p>
    </div>

    <!-- Settings Sections -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Profile Information Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900"><?php echo e(__('app.personal_information')); ?></h2>
                <p class="text-gray-600 text-sm mt-1"><?php echo e(__('app.update_profile_details')); ?></p>
            </div>

            <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Update Password Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900"><?php echo e(__('app.change_password')); ?></h2>
                <p class="text-gray-600 text-sm mt-1"><?php echo e(__('app.update_password_secure')); ?></p>
            </div>

            <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white rounded-xl shadow-md border border-red-100 p-8">
            <div class="mb-6 pb-6 border-b border-red-200">
                <h2 class="text-2xl font-bold text-red-900"><?php echo e(__('app.danger_zone')); ?></h2>
                <p class="text-red-700 text-sm mt-1"><?php echo e(__('app.irreversible_actions')); ?></p>
            </div>

            <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal951024bfcf58033c82ac11d797616473)): ?>
<?php $attributes = $__attributesOriginal951024bfcf58033c82ac11d797616473; ?>
<?php unset($__attributesOriginal951024bfcf58033c82ac11d797616473); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal951024bfcf58033c82ac11d797616473)): ?>
<?php $component = $__componentOriginal951024bfcf58033c82ac11d797616473; ?>
<?php unset($__componentOriginal951024bfcf58033c82ac11d797616473); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/profile/edit.blade.php ENDPATH**/ ?>