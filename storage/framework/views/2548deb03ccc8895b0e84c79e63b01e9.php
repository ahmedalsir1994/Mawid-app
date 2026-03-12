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
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Registration Submissions</h1>
            <p class="text-gray-500 mt-1 text-sm">All businesses that have registered on the platform</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-sm font-bold">
                <?php echo e($total); ?> total
            </span>
            <a href="<?php echo e(route('admin.super.registrations.export')); ?>"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Flash -->
    <?php if(session('success')): ?>
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Filters -->
    <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Search</label>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                placeholder="Name, email, business…"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Business Type</label>
            <select name="business_type"
                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Types</option>
                <?php $__currentLoopData = [
                    'beauty_salon'       => 'Beauty Salon',
                    'barbershop'         => 'Barbershop',
                    'spa_wellness'       => 'Spa & Wellness',
                    'medical_clinic'     => 'Medical Clinic',
                    'dental_clinic'      => 'Dental Clinic',
                    'fitness_gym'        => 'Fitness & Gym',
                    'personal_trainer'   => 'Personal Trainer',
                    'photography'        => 'Photography Studio',
                    'cleaning_services'  => 'Cleaning Services',
                    'home_services'      => 'Home Services',
                    'tutoring'           => 'Tutoring & Education',
                    'legal_consulting'   => 'Legal Consulting',
                    'financial_services' => 'Financial Services',
                    'it_services'        => 'IT Services',
                    'other'              => 'Other',
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(request('business_type') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Plan</label>
            <select name="plan"
                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Plans</option>
                <option value="free"  <?php echo e(request('plan') === 'free'  ? 'selected' : ''); ?>>Free</option>
                <option value="pro"   <?php echo e(request('plan') === 'pro'   ? 'selected' : ''); ?>>Pro</option>
                <option value="plus"  <?php echo e(request('plan') === 'plus'  ? 'selected' : ''); ?>>Plus</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">License Status</label>
            <select name="status"
                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Statuses</option>
                <option value="active"    <?php echo e(request('status') === 'active'    ? 'selected' : ''); ?>>Active</option>
                <option value="trial"     <?php echo e(request('status') === 'trial'     ? 'selected' : ''); ?>>Trial</option>
                <option value="expired"   <?php echo e(request('status') === 'expired'   ? 'selected' : ''); ?>>Expired</option>
                <option value="past_due"  <?php echo e(request('status') === 'past_due'  ? 'selected' : ''); ?>>Past Due</option>
                <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit"
            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
            Filter
        </button>
        <?php if(request('search') || request('plan') || request('status') || request('business_type')): ?>
            <a href="<?php echo e(route('admin.super.registrations.index')); ?>"
               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                Clear
            </a>
        <?php endif; ?>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Name</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Email / Mobile</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Business</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Type / Size</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Plan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Registered</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                        <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $license = optional($reg->business)->license; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                        <?php echo e(strtoupper(substr($reg->name, 0, 1))); ?>

                                    </div>
                                    <p class="font-semibold text-gray-900"><?php echo e($reg->name); ?></p>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <a href="mailto:<?php echo e($reg->email); ?>" class="text-blue-700 hover:underline text-xs block"><?php echo e($reg->email); ?></a>
                                <?php if(optional($reg->business)->mobile): ?>
                                    <a href="tel:<?php echo e($reg->business->mobile); ?>" class="text-gray-500 text-xs mt-0.5 block"><?php echo e($reg->business->mobile); ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4 text-gray-700"><?php echo e(optional($reg->business)->name ?? '—'); ?></td>
                            <td class="px-5 py-4">
                                <?php if(optional($reg->business)->business_type): ?>
                                    <p class="text-xs text-gray-700 font-medium"><?php echo e(ucwords(str_replace('_', ' ', $reg->business->business_type))); ?></p>
                                <?php endif; ?>
                                <?php if(optional($reg->business)->company_size): ?>
                                    <p class="text-xs text-gray-400 mt-0.5"><?php echo e($reg->business->company_size); ?> employees</p>
                                <?php endif; ?>
                                <?php if(!optional($reg->business)->business_type && !optional($reg->business)->company_size): ?>
                                    <span class="text-gray-400 text-xs">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <?php if($license): ?>
                                    <?php
                                        $planColors = [
                                            'free'  => 'bg-gray-100 text-gray-600',
                                            'pro'   => 'bg-blue-100 text-blue-700',
                                            'plus'  => 'bg-purple-100 text-purple-700',
                                        ];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?php echo e($planColors[$license->plan] ?? 'bg-gray-100 text-gray-600'); ?>">
                                        <?php echo e(ucfirst($license->plan)); ?>

                                        <?php if($license->billing_cycle): ?>
                                            / <?php echo e(ucfirst($license->billing_cycle)); ?>

                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4">
                                <?php if($license): ?>
                                    <?php
                                        $statusColors = [
                                            'active'    => 'bg-green-100 text-green-700',
                                            'expired'   => 'bg-red-100 text-red-700',
                                            'past_due'  => 'bg-yellow-100 text-yellow-700',
                                            'cancelled' => 'bg-gray-100 text-gray-500',
                                            'trial'     => 'bg-teal-100 text-teal-700',
                                        ];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?php echo e($statusColors[$license->status] ?? 'bg-gray-100 text-gray-600'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $license->status))); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4 text-gray-500 whitespace-nowrap text-xs">
                                <?php echo e($reg->created_at->format('d M Y')); ?><br>
                                <?php echo e($reg->created_at->format('H:i')); ?>

                            </td>
                            <td class="px-5 py-4">
                                <a href="<?php echo e(route('admin.super.registrations.show', $reg)); ?>"
                                   class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">No registrations found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($registrations->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-100">
                <?php echo e($registrations->links()); ?>

            </div>
        <?php endif; ?>
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
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/super/registrations/index.blade.php ENDPATH**/ ?>