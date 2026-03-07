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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('admin.branches.show', $branch)); ?>" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl text-gray-800"><?php echo e(__('app.edit_branch')); ?>: <?php echo e($branch->name); ?></h2>
                <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.edit_branch_desc')); ?></p>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <?php if(session('success')): ?>
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.branches.update', $branch)); ?>" class="space-y-6">
                <?php echo method_field('PUT'); ?>
                <?php echo $__env->make('admin.branches._form', ['branch' => $branch], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-purple-500 text-white font-semibold hover:shadow-lg transition">
                        <?php echo e(__('app.save_changes')); ?>

                    </button>
                    <a href="<?php echo e(route('admin.branches.show', $branch)); ?>"
                       class="flex-1 py-3 rounded-lg bg-gray-100 text-gray-700 font-semibold text-center hover:bg-gray-200 transition">
                        <?php echo e(__('app.cancel')); ?>

                    </a>
                </div>
            </form>
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\booking-app\resources\views/admin/branches/edit.blade.php ENDPATH**/ ?>