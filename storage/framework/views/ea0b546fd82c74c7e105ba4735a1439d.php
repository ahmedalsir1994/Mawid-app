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
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8 flex flex-wrap items-start justify-between gap-y-4">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900"><?php echo e(__('app.manage_users')); ?></h1>
            <p class="text-gray-600 mt-1 sm:mt-2 text-sm sm:text-base"><?php echo e(__('app.create_manage_platform_users')); ?></p>
        </div>
        <a href="<?php echo e(route('admin.super.users.create')); ?>"
            class="shrink-0 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transition text-sm sm:text-base">
            + <?php echo e(__('app.add_user')); ?>

        </a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="<?php echo e(route('admin.super.users.index')); ?>" class="mb-6 flex flex-wrap gap-3">
        <input
            type="text"
            name="search"
            value="<?php echo e(request('search')); ?>"
            placeholder="Search by name or email..."
            class="flex-1 min-w-[200px] px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-300"
        />
        <select name="role" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <option value="">All Roles</option>
            <option value="super_admin" <?php if(request('role') === 'super_admin'): echo 'selected'; endif; ?>>Super Admin</option>
            <option value="company_admin" <?php if(request('role') === 'company_admin'): echo 'selected'; endif; ?>>Company Admin</option>
            <option value="staff" <?php if(request('role') === 'staff'): echo 'selected'; endif; ?>>Staff</option>
            <option value="customer" <?php if(request('role') === 'customer'): echo 'selected'; endif; ?>>Customer</option>
        </select>
        <button type="submit" class="px-5 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition">Search</button>
        <?php if(request('search') || request('role')): ?>
            <a href="<?php echo e(route('admin.super.users.index')); ?>" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">Clear</a>
        <?php endif; ?>
    </form>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-purple-700 font-bold text-sm"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 text-sm truncate"><?php echo e($user->name); ?></p>
                                <p class="text-xs text-gray-500 truncate"><?php echo e($user->email); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                <?php if($user->is_active): ?> <?php echo e(__('app.active')); ?> <?php else: ?> <?php echo e(__('app.inactive')); ?> <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 text-xs mb-3">
                        <?php
                            $roleBadge = match($user->role) {
                                'super_admin' => 'bg-red-100 text-red-800',
                                'company_admin' => 'bg-blue-100 text-blue-800',
                                'staff' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        ?>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold <?php echo e($roleBadge); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?></span>
                        <?php if($user->business): ?>
                            <?php
                                $userPlan = $user->business?->license?->plan ?? 'free';
                                $userBadge = match($userPlan) { 'pro' => 'bg-blue-100 text-blue-800', 'plus' => 'bg-purple-100 text-purple-800', default => 'bg-gray-100 text-gray-600' };
                                $userEmoji = match($userPlan) { 'pro'=>'💼','plus'=>'🚀',default=>'🆓' };
                            ?>
                            <span class="text-gray-500"><?php echo e($user->business->name); ?></span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold <?php echo e($userBadge); ?>"><?php echo e($userEmoji); ?> <?php echo e(ucfirst($userPlan)); ?></span>
                        <?php endif; ?>
                        <span class="text-gray-400"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('admin.super.users.show', $user)); ?>" class="text-purple-600 hover:text-purple-700 font-medium text-sm"><?php echo e(__('app.view')); ?></a>
                        <a href="<?php echo e(route('admin.super.users.edit', $user)); ?>" class="text-blue-600 hover:text-blue-700 font-medium text-sm"><?php echo e(__('app.edit')); ?></a>
                        <form method="POST" action="<?php echo e(route('admin.super.users.destroy', $user)); ?>" class="inline" onsubmit="return confirm('<?php echo e(__('app.delete_user_confirm')); ?>')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-red-600 hover:text-red-700 font-medium text-sm"><?php echo e(__('app.delete')); ?></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-12 text-center text-gray-500">
                    <p class="text-base mb-2"><?php echo e(__('app.no_users_yet')); ?></p>
                    <a href="<?php echo e(route('admin.super.users.create')); ?>" class="text-green-600 hover:text-green-700 font-medium text-sm"><?php echo e(__('app.create_first_user')); ?></a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.user')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.email')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.role')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.business')); ?>

                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.plan')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.status')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.joined')); ?></th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"><?php echo e(__('app.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span
                                            class="text-purple-700 font-bold"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></span>
                                    </div>
                                    <p class="font-semibold text-gray-900"><?php echo e($user->name); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            <?php if($user->role === 'super_admin'): ?> 
                                                bg-red-100 text-red-800
                                            <?php elseif($user->role === 'company_admin'): ?>
                                                bg-blue-100 text-blue-800
                                            <?php elseif($user->role === 'staff'): ?>
                                                bg-green-100 text-green-800
                                            <?php else: ?>
                                                bg-gray-100 text-gray-800
                                            <?php endif; ?>
                                        ">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php echo e($user->business?->name ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 text-sm">
                                <?php
                                    $userPlan = $user->business?->license?->plan ?? 'free';
                                    $userBadge = match($userPlan) {
                                        'pro'  => 'bg-blue-100 text-blue-800',
                                        'plus' => 'bg-purple-100 text-purple-800',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                    $userEmoji = match($userPlan) { 'pro'=>'💼','plus'=>'🚀',default=>'🆓' };
                                ?>
                                <?php if($user->business): ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold <?php echo e($userBadge); ?>">
                                        <?php echo e($userEmoji); ?> <?php echo e(ucfirst($userPlan)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            <?php if($user->is_active): ?> 
                                                bg-green-100 text-green-800
                                            <?php else: ?>
                                                bg-gray-100 text-gray-800
                                            <?php endif; ?>
                                        ">
                                    <?php if($user->is_active): ?> <?php echo e(__('app.active')); ?> <?php else: ?> <?php echo e(__('app.inactive')); ?> <?php endif; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php echo e($user->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="<?php echo e(route('admin.super.users.show', $user)); ?>"
                                    class="text-purple-600 hover:text-purple-700 font-medium">
                                    <?php echo e(__('app.view')); ?>

                                </a>
                                <a href="<?php echo e(route('admin.super.users.edit', $user)); ?>"
                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                    <?php echo e(__('app.edit')); ?>

                                </a>
                                <form method="POST" action="<?php echo e(route('admin.super.users.destroy', $user)); ?>" class="inline"
                                    onsubmit="return confirm('<?php echo e(__('app.delete_user_confirm')); ?>')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button
                                        class="text-red-600 hover:text-red-700 font-medium"><?php echo e(__('app.delete')); ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg mb-2"><?php echo e(__('app.no_users_yet')); ?></p>
                                <a href="<?php echo e(route('admin.super.users.create')); ?>"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    <?php echo e(__('app.create_first_user')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div><!-- end desktop table -->
    </div>

    <!-- Pagination -->
    <?php if($users->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($users->links()); ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/super/users/index.blade.php ENDPATH**/ ?>