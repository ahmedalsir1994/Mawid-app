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
        <h2 class="font-bold text-2xl text-gray-800"><?php echo e(__('app.service_categories')); ?></h2>
        <a href="<?php echo e(route('admin.service_categories.create')); ?>" class="mt-2 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"><?php echo e(__('app.add_category')); ?></a>
     <?php $__env->endSlot(); ?>
    <div class="max-w-xl mt-6">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center justify-between bg-white rounded shadow p-4 mb-2">
                <span><?php echo e($category->name); ?></span>
                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('admin.service_categories.edit', $category)); ?>" class="text-blue-600 hover:text-blue-800"><?php echo e(__('app.edit_category') ?? 'Edit'); ?></a>
                    <form method="POST" action="<?php echo e(route('admin.service_categories.destroy', $category)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="text-red-600 hover:text-red-800"><?php echo e(__('app.delete_category')); ?></button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/service_categories/index.blade.php ENDPATH**/ ?>