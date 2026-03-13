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
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Billing History</h1>
        <p class="text-gray-600 mt-1 text-sm sm:text-base">All invoices across all businesses.</p>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($totalRevenue, 3)); ?> <span class="text-sm font-normal text-gray-500">OMR</span></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">This Month</p>
            <p class="text-2xl font-bold text-green-700"><?php echo e(number_format($monthRevenue, 3)); ?> <span class="text-sm font-normal text-gray-500">OMR</span></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Invoices</p>
            <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($totalInvoices)); ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Pending</p>
            <p class="text-2xl font-bold text-yellow-600"><?php echo e(number_format($pendingInvoices)); ?></p>
        </div>
    </div>

    <!-- Search & Filters -->
    <form method="GET" action="<?php echo e(route('admin.super.billing.index')); ?>" class="mb-6 flex flex-wrap gap-3 items-center">
        <div class="relative flex-1 min-w-[220px]">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                placeholder="Search invoice #, business name or email..."
                class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white" />
        </div>

        <div class="relative">
            <select name="plan" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Plans</option>
                <option value="pro"  <?php if(request('plan') === 'pro'): echo 'selected'; endif; ?>>💼 Pro</option>
                <option value="plus" <?php if(request('plan') === 'plus'): echo 'selected'; endif; ?>>🚀 Plus</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <div class="relative">
            <select name="cycle" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Cycles</option>
                <option value="monthly" <?php if(request('cycle') === 'monthly'): echo 'selected'; endif; ?>>Monthly</option>
                <option value="yearly"  <?php if(request('cycle') === 'yearly'): echo 'selected'; endif; ?>>Yearly</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <div class="relative">
            <select name="status" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Statuses</option>
                <option value="paid"    <?php if(request('status') === 'paid'): echo 'selected'; endif; ?>>Paid</option>
                <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                <option value="failed"  <?php if(request('status') === 'failed'): echo 'selected'; endif; ?>>Failed</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <button type="submit" class="px-5 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
            Search
        </button>
        <?php if(request()->hasAny(['search', 'plan', 'cycle', 'status'])): ?>
            <a href="<?php echo e(route('admin.super.billing.index')); ?>" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                Clear
            </a>
        <?php endif; ?>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <?php if($invoices->count()): ?>
            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-100">
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $statusClass = match($invoice->status) {
                            'paid'    => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'failed'  => 'bg-red-100 text-red-800',
                            default   => 'bg-gray-100 text-gray-700',
                        };
                        $planEmoji = match($invoice->plan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                    ?>
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <div>
                                <p class="font-semibold text-gray-800 text-sm"><?php echo e($invoice->business_name); ?></p>
                                <?php if($invoice->business_email): ?>
                                    <p class="text-xs text-gray-400"><?php echo e($invoice->business_email); ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold <?php echo e($statusClass); ?> shrink-0">
                                <?php echo e(ucfirst($invoice->status)); ?>

                            </span>
                        </div>
                        <p class="text-xs font-mono text-gray-500 mb-2"><?php echo e($invoice->invoice_number); ?></p>
                        <div class="flex flex-wrap items-center gap-2 mb-2 text-xs text-gray-600">
                            <span><?php echo e($planEmoji); ?> <?php echo e(ucfirst($invoice->plan)); ?></span>
                            <?php if($invoice->billing_cycle): ?>
                                <span class="text-gray-400">&middot;</span>
                                <span><?php echo e(ucfirst($invoice->billing_cycle)); ?></span>
                            <?php endif; ?>
                            <span class="text-gray-400">&middot;</span>
                            <span class="font-semibold text-gray-800"><?php echo e(number_format($invoice->amount, 3)); ?> <?php echo e($invoice->currency ?? 'OMR'); ?></span>
                            <span class="text-gray-400">&middot;</span>
                            <span><?php echo e($invoice->paid_at?->format('d M Y') ?? $invoice->created_at->format('d M Y')); ?></span>
                        </div>
                        <a href="<?php echo e(route('admin.super.billing.show', $invoice)); ?>"
                           class="inline-block text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                           target="_blank">View</a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Business</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cycle</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $statusClass = match($invoice->status) {
                                    'paid'    => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'failed'  => 'bg-red-100 text-red-800',
                                    default   => 'bg-gray-100 text-gray-700',
                                };
                                $planEmoji = match($invoice->plan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-4 font-mono font-semibold text-gray-800 text-xs"><?php echo e($invoice->invoice_number); ?></td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-gray-800"><?php echo e($invoice->business_name); ?></p>
                                    <?php if($invoice->business_email): ?>
                                        <p class="text-xs text-gray-400"><?php echo e($invoice->business_email); ?></p>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-4 text-gray-700"><?php echo e($planEmoji); ?> <?php echo e(ucfirst($invoice->plan)); ?></td>
                                <td class="px-5 py-4 text-gray-500"><?php echo e(ucfirst($invoice->billing_cycle ?? '—')); ?></td>
                                <td class="px-5 py-4 font-semibold text-gray-800">
                                    <?php echo e(number_format($invoice->amount, 3)); ?> <?php echo e($invoice->currency ?? 'OMR'); ?>

                                </td>
                                <td class="px-5 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold <?php echo e($statusClass); ?>">
                                        <?php echo e(ucfirst($invoice->status)); ?>

                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-500 text-xs">
                                    <?php echo e($invoice->paid_at?->format('d M Y') ?? $invoice->created_at->format('d M Y')); ?>

                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="<?php echo e(route('admin.super.billing.show', $invoice)); ?>"
                                       class="text-xs px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                                       target="_blank">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div><!-- end desktop table -->

            <?php if($invoices->hasPages()): ?>
                <div class="px-5 py-4 border-t border-gray-100">
                    <?php echo e($invoices->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 text-sm">No invoices found.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if($invoices->hasPages()): ?>
        <div class="mt-4"><?php echo e($invoices->links()); ?></div>
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
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/super/billing/index.blade.php ENDPATH**/ ?>