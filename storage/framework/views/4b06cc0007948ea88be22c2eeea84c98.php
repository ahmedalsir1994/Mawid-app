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
            <div>
                <h2 class="font-bold text-3xl text-gray-800"><?php echo e(__('app.branches')); ?></h2>
                <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.manage_branches_desc')); ?></p>
            </div>
            <?php if($license && $license->canAddBranch()): ?>
                <a href="<?php echo e(route('admin.branches.create')); ?>"
                   class="px-6 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-purple-500 text-white font-semibold hover:shadow-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo e(__('app.add_branch')); ?>

                </a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                   class="px-5 py-3 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition flex items-center gap-2">
                    🚀 <?php echo e(__('app.upgrade_for_more_branches')); ?>

                </a>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <!-- Plan usage bar -->
    <?php
        $branchMax   = $license?->max_branches ?? 1;
        $branchUsed  = $license ? $license->branchesUsed() : 0;
        $atLimit     = $license ? !$license->canAddBranch() : true;
        $isPlusOrAbove = $license && $license->isPlus();
    ?>
    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-2xl">🏢</span>
            <div>
                <p class="font-semibold text-gray-800"><?php echo e(__('app.branches_plan_desc', ['used' => $branchUsed, 'max' => $branchMax])); ?></p>
                <?php if(!$isPlusOrAbove): ?>
                    <p class="text-sm text-purple-600">
                        <?php echo e(__('app.upgrade_for_more_branches')); ?>

                        <a href="<?php echo e(route('admin.upgrade.index')); ?>" class="font-semibold underline hover:text-purple-800"><?php echo e(__('app.upgrade_plan')); ?></a>
                    </p>
                <?php else: ?>
                    <p class="text-sm text-gray-500"><?php echo e(__('app.plus_branches_hint')); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="w-48">
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-2 <?php echo e($atLimit ? 'bg-red-500' : 'bg-green-500'); ?> rounded-full transition-all"
                     style="width: <?php echo e(min(100, ($branchUsed / max(1, $branchMax)) * 100)); ?>%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1 text-right"><?php echo e($branchUsed); ?>/<?php echo e($branchMax); ?></p>
        </div>
    </div>

    <?php if($branches->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e(__('app.no_branches_yet')); ?></h3>
            <p class="text-gray-500 mb-6"><?php echo e(__('app.create_first_branch')); ?></p>
            <a href="<?php echo e(route('admin.branches.create')); ?>"
               class="inline-block px-6 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-purple-500 text-white font-semibold hover:shadow-lg transition">
                <?php echo e(__('app.create_your_first_branch')); ?>

            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-md border <?php echo e($branch->is_main ? 'border-purple-300' : 'border-gray-100'); ?> overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-lg <?php echo e($branch->is_main ? 'bg-purple-100' : 'bg-gray-100'); ?> flex items-center justify-center">
                                    <svg class="w-5 h-5 <?php echo e($branch->is_main ? 'text-purple-600' : 'text-gray-500'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900"><?php echo e($branch->name); ?></h3>
                                    <?php if($branch->is_main): ?>
                                        <span class="text-xs font-semibold text-purple-600"><?php echo e(__('app.main_branch')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold <?php echo e($branch->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                <?php echo e($branch->is_active ? __('app.active') : __('app.inactive')); ?>

                            </span>
                        </div>

                        <?php if($branch->address): ?>
                            <p class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <?php echo e($branch->address); ?>

                            </p>
                        <?php endif; ?>
                        <?php if($branch->phone): ?>
                            <p class="text-sm text-gray-500 mb-3 flex items-center gap-1">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <?php echo e($branch->phone); ?>

                            </p>
                        <?php endif; ?>

                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><?php echo e($branch->services_count); ?> <?php echo e(__('app.services')); ?></span>
                            <span>·</span>
                            <span><?php echo e($branch->staff_count); ?> <?php echo e(__('app.staff')); ?></span>
                        </div>

                        <div class="flex gap-2">
                            <a href="<?php echo e(route('admin.branches.show', $branch)); ?>"
                               class="flex-1 text-center px-3 py-2 rounded-lg bg-purple-50 text-purple-700 text-sm font-medium hover:bg-purple-100 transition">
                                <?php echo e(__('app.manage')); ?>

                            </a>
                            <a href="<?php echo e(route('admin.branches.edit', $branch)); ?>"
                               class="flex-1 text-center px-3 py-2 rounded-lg bg-gray-50 text-gray-700 text-sm font-medium hover:bg-gray-100 transition">
                                <?php echo e(__('app.edit')); ?>

                            </a>
                            <?php if(!$branch->is_main): ?>
                                <form method="POST" action="<?php echo e(route('admin.branches.destroy', $branch)); ?>" onsubmit="return confirm('<?php echo e(__('app.confirm_delete_branch')); ?>')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="px-3 py-2 rounded-lg bg-red-50 text-red-600 text-sm font-medium hover:bg-red-100 transition">
                                        <?php echo e(__('app.delete')); ?>

                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\booking-app\resources\views\admin\branches\index.blade.php ENDPATH**/ ?>