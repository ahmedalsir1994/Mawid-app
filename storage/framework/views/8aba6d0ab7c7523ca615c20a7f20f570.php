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
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('admin.branches.index')); ?>" class="p-2 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-bold text-3xl text-gray-800"><?php echo e($branch->name); ?></h2>
                        <?php if($branch->is_main): ?>
                            <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-bold"><?php echo e(__('app.main_branch')); ?></span>
                        <?php endif; ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo e($branch->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                            <?php echo e($branch->is_active ? __('app.active') : __('app.inactive')); ?>

                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mt-1"><?php echo e($branch->address); ?></p>
                </div>
            </div>
            <a href="<?php echo e(route('admin.branches.edit', $branch)); ?>"
               class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition">
                <?php echo e(__('app.edit')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left column: details + staff -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Branch Info Card -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4"><?php echo e(__('app.branch_details')); ?></h3>
                <dl class="space-y-3 text-sm">
                    <?php if($branch->phone): ?>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <?php echo e($branch->phone); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($branch->address): ?>
                        <div class="flex items-start gap-2 text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <?php echo e($branch->address); ?>

                        </div>
                    <?php endif; ?>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                        <?php echo e(__('app.created')); ?>: <?php echo e($branch->created_at->format('M d, Y')); ?>

                    </div>
                </dl>
            </div>

            <!-- Staff assigned to this branch -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800"><?php echo e(__('app.assigned_staff')); ?></h3>
                    <a href="<?php echo e(route('admin.staff.index')); ?>"
                       class="text-xs text-purple-600 hover:text-purple-800 font-medium"><?php echo e(__('app.manage_staff')); ?> →</a>
                </div>
                <?php if($branch->staff->isEmpty()): ?>
                    <p class="text-gray-400 text-sm"><?php echo e(__('app.no_staff_assigned')); ?></p>
                <?php else: ?>
                    <ul class="space-y-2">
                        <?php $__currentLoopData = $branch->staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-sm">
                                    <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800"><?php echo e($member->name); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo e($member->title ?? $member->email); ?></p>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right column: services management -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg"><?php echo e(__('app.branch_services')); ?></h3>
                        <p class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.branch_services_desc')); ?></p>
                    </div>
                    <span class="text-sm font-semibold text-purple-700 bg-purple-50 px-3 py-1 rounded-full">
                        <?php echo e($branch->services->count()); ?> / <?php echo e($allServices->count()); ?> <?php echo e(__('app.selected')); ?>

                    </span>
                </div>

                <?php if($allServices->isEmpty()): ?>
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p><?php echo e(__('app.no_services_to_assign')); ?></p>
                        <a href="<?php echo e(route('admin.services.create')); ?>" class="mt-2 inline-block text-sm text-purple-600 hover:underline">
                            <?php echo e(__('app.add_service')); ?> →
                        </a>
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('admin.branches.services.sync', $branch)); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                            <?php $__currentLoopData = $allServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $assigned = $branch->services->contains($service->id); ?>
                                <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition
                                    <?php echo e($assigned ? 'border-purple-400 bg-purple-50' : 'border-gray-200 hover:border-gray-300'); ?>">
                                    <input type="checkbox" name="services[]" value="<?php echo e($service->id); ?>"
                                           <?php echo e($assigned ? 'checked' : ''); ?>

                                           class="w-5 h-5 rounded text-purple-600 focus:ring-purple-400">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate"><?php echo e($service->name); ?></p>
                                        <p class="text-xs text-gray-500">
                                            <?php echo e($service->duration_minutes); ?> <?php echo e(__('app.min')); ?>

                                            <?php if($service->price): ?>
                                                · <?php echo e(number_format($service->price, 2)); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <?php if($assigned): ?>
                                        <svg class="w-4 h-4 text-purple-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <button type="submit"
                                class="w-full py-3 rounded-lg bg-gradient-to-r from-purple-600 to-purple-500 text-white font-semibold hover:shadow-lg transition">
                            <?php echo e(__('app.save_branch_services')); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>
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
<?php /**PATH C:\laragon\www\booking-app\resources\views\admin\branches\show.blade.php ENDPATH**/ ?>