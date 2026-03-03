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
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('admin.staff.index')); ?>" class="text-gray-600 hover:text-gray-900 transition">
                ← <?php echo e(__('app.back_to_staff')); ?>

            </a>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mt-4"><?php echo e(__('app.add_new_staff_member')); ?></h1>
        <p class="text-gray-600 mt-2"><?php echo e(__('app.create_staff_account')); ?></p>
    </div>

    <?php if(isset($canAdd) && !$canAdd): ?>
        <?php if (isset($component)) { $__componentOriginal6f6c36906fa9dd4916b6ca3018689147 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f6c36906fa9dd4916b6ca3018689147 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.upgrade-modal','data' => ['license' => $license,'plan' => $plan,'limitType' => 'staff']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upgrade-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['license' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($license),'plan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($plan),'limitType' => 'staff']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6f6c36906fa9dd4916b6ca3018689147)): ?>
<?php $attributes = $__attributesOriginal6f6c36906fa9dd4916b6ca3018689147; ?>
<?php unset($__attributesOriginal6f6c36906fa9dd4916b6ca3018689147); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6f6c36906fa9dd4916b6ca3018689147)): ?>
<?php $component = $__componentOriginal6f6c36906fa9dd4916b6ca3018689147; ?>
<?php unset($__componentOriginal6f6c36906fa9dd4916b6ca3018689147); ?>
<?php endif; ?>
    <?php else: ?>
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form method="POST" action="<?php echo e(route('admin.staff.store')); ?>" class="space-y-6" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('app.full_name')); ?> <span class="text-red-500">*</span>
                </label>
                <input lang="en" dir="ltr" type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('app.email_address')); ?> <span class="text-red-500">*</span>
                </label>
                <input lang="en" dir="ltr" type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('app.password')); ?> <span class="text-red-500">*</span>
                </label>
                <input lang="en" dir="ltr" type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="mt-1 text-xs text-gray-500"><?php echo e(__('app.minimum_8_characters')); ?></p>
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('app.confirm_password')); ?> <span class="text-red-500">*</span>
                </label>
                <input lang="en" dir="ltr" type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center">
                    <input lang="en" dir="ltr" type="checkbox" name="is_active" value="1" checked
                        class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700"><?php echo e(__('app.active_staff_can_login')); ?></span>
                </label>
            </div>

            <!-- Title / Role Label -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title <span class="text-gray-400 font-normal">(optional)</span></label>
                <input lang="en" dir="ltr" type="text" name="title" id="title" value="<?php echo e(old('title')); ?>"
                    placeholder="e.g. Barber, Stylist, Therapist"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            <?php if(isset($branches) && $branches->isNotEmpty()): ?>
            <!-- Branch Assignment -->
            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('app.branch')); ?> <span class="text-gray-400 font-normal">(<?php echo e(__('app.optional') ?? 'optional'); ?>)</span>
                </label>
                <select name="branch_id" id="branch_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                    <option value="">— <?php echo e(__('app.no_branch_assigned') ?? 'No specific branch'); ?> —</option>
                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?>>
                            <?php echo e($branch->name); ?><?php echo e($branch->address ? ' · ' . $branch->address : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="mt-1 text-xs text-gray-500"><?php echo e(__('app.branch_assignment_hint') ?? 'Assign this staff member to a specific branch location.'); ?></p>
                <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <?php endif; ?>

            <!-- Photo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo <span class="text-gray-400 font-normal">(optional)</span></label>
                <label for="photoInput" class="flex flex-col items-center justify-center w-full h-28 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 cursor-pointer transition">
                    <svg class="w-8 h-8 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-600">Click to upload photo</span>
                    <span class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP · max 3 MB</span>
                </label>
                <input lang="en" dir="ltr" id="photoInput" type="file" name="photo" accept="image/jpeg,image/jpg,image/png,image/webp"
                    class="sr-only" onchange="previewStaffPhoto(this)">
                <div id="photoPreview" class="mt-3 hidden">
                    <img id="photoPreviewImg" src="" class="w-20 h-20 rounded-full object-cover border-2 border-green-500">
                </div>
                <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    <?php echo e(__('app.create_staff_member')); ?>

                </button>
                <a href="<?php echo e(route('admin.staff.index')); ?>"
                    class="text-gray-600 hover:text-gray-900 font-medium px-6 py-3 rounded-lg transition">
                    <?php echo e(__('app.cancel')); ?>

                </a>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <script>
    function previewStaffPhoto(input) {
        const preview = document.getElementById('photoPreview');
        const img = document.getElementById('photoPreviewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; preview.classList.remove('hidden'); };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views\admin\staff\create.blade.php ENDPATH**/ ?>