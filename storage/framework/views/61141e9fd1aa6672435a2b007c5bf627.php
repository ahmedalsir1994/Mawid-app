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
    
    <?php $pendingPaymentPlan = auth()->user()->pending_plan; ?>
    <?php if($pendingPaymentPlan && ($license && $license->isFree())): ?>
        <?php $pendingPaymentCycle = auth()->user()->pending_cycle ?? 'monthly'; ?>
        <div class="mb-6 rounded-2xl border border-amber-300 bg-gradient-to-r from-amber-50 to-orange-50 p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-amber-900 text-sm">
                            Complete your <?php echo e(ucfirst($pendingPaymentPlan)); ?> subscription to unlock all features.
                        </p>
                        <p class="text-amber-700 text-xs mt-0.5">
                            You selected the <strong><?php echo e(ucfirst($pendingPaymentPlan)); ?></strong> plan but haven't completed your payment yet.
                            Your account is currently on the Free plan.
                        </p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.upgrade.autopay', ['plan' => $pendingPaymentPlan, 'cycle' => $pendingPaymentCycle])); ?>"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Continue Payment
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-start justify-between gap-y-4">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900"><?php echo e($business->name); ?></h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base"><?php echo e(__('app.dashboard_for')); ?> <?php echo e($business->address); ?></p>
            </div>
            <div class="text-right">
                <?php
                    $dashPlan      = $license->plan ?? 'free';
                    $dashPlanBadge = match($dashPlan) {
                        'pro'  => 'bg-blue-100 text-blue-800',
                        'plus' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-100 text-gray-700',
                    };
                    $dashPlanEmoji = match($dashPlan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                ?>
                <div class="flex items-center justify-end gap-2 mb-2">
                    <?php if($license && $license->isActive()): ?>
                        <span class="inline-block px-4 py-2 bg-green-100 text-green-800 font-bold rounded-lg">
                            ✓ <?php echo e(__('app.license_active')); ?>

                        </span>
                    <?php else: ?>
                        <span class="inline-block px-4 py-2 bg-red-100 text-red-800 font-bold rounded-lg">
                            ⚠ <?php echo e(__('app.license_inactive')); ?>

                        </span>
                    <?php endif; ?>
                    <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                       class="inline-block px-4 py-2 <?php echo e($dashPlanBadge); ?> font-bold rounded-lg hover:opacity-80 transition">
                        <?php echo e($dashPlanEmoji); ?> <?php echo e(ucfirst($dashPlan)); ?> <?php echo e(__('app.plan')); ?>

                    </a>
                </div>
                <?php if($license && $license->isExpiring()): ?>
                    <p class="text-sm text-orange-600 font-semibold">
                        <?php echo e(__('app.expires_in_days', ['days' => $license->daysUntilExpiry()])); ?>

                    </p>
                <?php elseif($license && !$license->isActive() && $license->expires_at && $license->expires_at->isPast()): ?>
                    <p class="text-sm text-red-600 font-semibold">
                        <?php echo e(__('app.expired_days_ago', ['days' => abs($license->daysUntilExpiry())])); ?>

                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <!-- Total Bookings -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.total_bookings')); ?></h3>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900"><?php echo e($totalBookings); ?></p>
            <a href="<?php echo e(route('admin.bookings.index')); ?>"
                class="text-sm text-green-600 hover:text-green-700 font-medium mt-3 inline-block">
                <?php echo e(__('app.view_all')); ?> →
            </a>
        </div>

        <!-- Public Booking Link -->
        <div class="bg-white rounded-xl shadow-md border border-blue-100 p-3 sm:p-6">
            <h3 class="text-gray-600 font-medium text-xs sm:text-sm mb-2 leading-snug"><?php echo e(__('app.public_booking_link') ?? 'Public Booking Link'); ?></h3>
            <div class="flex flex-col gap-1.5 bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 sm:px-3 sm:py-2.5">
                <div class="flex items-center gap-1.5 min-w-0">
                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <span class="text-xs text-gray-600 truncate select-all min-w-0"><?php echo e(url('/')); ?>/<?php echo e($business->slug); ?></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="navigator.clipboard.writeText('<?php echo e(url('/')); ?>/<?php echo e($business->slug); ?>')"
                        class="flex-1 flex items-center justify-center gap-1 py-1.5 text-xs font-semibold rounded-md bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 transition">
                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span><?php echo e(__('app.copy') ?? 'Copy'); ?></span>
                    </button>
                    <a href="<?php echo e(url('/')); ?>/<?php echo e($business->slug); ?>" target="_blank"
                        class="flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span class="hidden sm:inline ml-4"><?php echo e(__('app.open') ?? 'Open'); ?></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white rounded-xl shadow-md border border-yellow-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.pending')); ?></h3>
            <p class="text-2xl sm:text-3xl font-bold text-yellow-600"><?php echo e($pendingBookings); ?></p>
            <a href="<?php echo e(route('admin.bookings.index', ['filter' => 'today'])); ?>"
                class="text-sm text-yellow-600 hover:text-yellow-700 font-medium mt-3 inline-block">
                <?php echo e(__('app.review')); ?> →
            </a>
        </div>

        <!-- Services -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.services')); ?></h3>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900"><?php echo e($totalServices); ?></p>
            <a href="<?php echo e(route('admin.services.index')); ?>"
                class="text-sm text-green-600 hover:text-green-700 font-medium mt-3 inline-block">
                <?php echo e(__('app.manage_services')); ?> →
            </a>
        </div>

        <!-- Team Members -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.team_members')); ?></h3>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900"><?php echo e($userCount); ?></p>
            <p class="text-sm text-gray-600 mt-2"><?php echo e($totalStaff); ?> <?php echo e(__('app.staff_members')); ?></p>
        </div>

        <!-- License Status -->
        <div
            class="bg-white rounded-xl shadow-md border <?php if($license && $license->isActive()): ?> border-green-100 <?php else: ?> border-red-100 <?php endif; ?> p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.license')); ?></h3>
            <?php if($license): ?>
                <?php
                    $cardPlan      = $license->plan ?? 'free';
                    $cardPlanBadge = match($cardPlan) {
                        'pro'  => 'bg-blue-100 text-blue-800',
                        'plus' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-100 text-gray-700',
                    };
                    $cardPlanEmoji = match($cardPlan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                ?>
                <div class="flex items-center justify-between mb-2">
                    <p class="text-2xl font-bold <?php if($license->isActive()): ?> text-green-600 <?php else: ?> text-red-600 <?php endif; ?>">
                        <?php if($license->isActive()): ?>
                            <?php echo e(__('app.active')); ?>

                        <?php else: ?>
                            <?php echo e(ucfirst($license->status)); ?>

                        <?php endif; ?>
                    </p>
                    <span class="inline-block px-2 py-1 text-xs font-bold rounded-full <?php echo e($cardPlanBadge); ?>">
                        <?php echo e($cardPlanEmoji); ?> <?php echo e(ucfirst($cardPlan)); ?>

                    </span>
                </div>
                <p class="text-sm text-gray-600 mt-2">
                    <?php echo e(__('app.expires')); ?>: <?php echo e($license->expires_at?->format('M d, Y') ?? __('app.no_expiry')); ?>

                </p>
                <?php if($cardPlan === 'free'): ?>
                    <a href="<?php echo e(route('admin.upgrade.index')); ?>" class="text-xs text-blue-600 hover:text-blue-700 font-medium mt-2 inline-block">
                        ↑ <?php echo e(__('app.upgrade_plan')); ?>

                    </a>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-red-600 font-bold"><?php echo e(__('app.no_active_license')); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Live Calendar View -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
        <!-- Calendar Controls -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-900">📅 <?php echo e(__('app.booking_calendar')); ?></h2>

            <!-- View Switcher -->
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('admin.company.dashboard', ['view' => 'week', 'date' => $currentDate->format('Y-m-d')])); ?>"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($view === 'week' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <?php echo e(__('app.week')); ?>

                </a>
                <a href="<?php echo e(route('admin.company.dashboard', ['view' => 'month', 'date' => $currentDate->format('Y-m-d')])); ?>"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($view === 'month' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <?php echo e(__('app.month')); ?>

                </a>
                <a href="<?php echo e(route('admin.company.dashboard', ['view' => 'year', 'date' => $currentDate->format('Y-m-d')])); ?>"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($view === 'year' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <?php echo e(__('app.year')); ?>

                </a>
            </div>

            <!-- Navigation -->
            <div class="flex items-center gap-4">
                <?php
                    $prevDate = $view === 'week' ? $currentDate->copy()->subWeek()
                        : ($view === 'month' ? $currentDate->copy()->subMonth()
                            : $currentDate->copy()->subYear());
                    $nextDate = $view === 'week' ? $currentDate->copy()->addWeek()
                        : ($view === 'month' ? $currentDate->copy()->addMonth()
                            : $currentDate->copy()->addYear());
                ?>
                <a href="<?php echo e(route('admin.company.dashboard', ['view' => $view, 'date' => $prevDate->format('Y-m-d')])); ?>"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <span class="text-lg font-semibold text-gray-900 min-w-[200px] text-center">
                    <?php if($view === 'week'): ?>
                        <?php echo e($startDate->format('M d')); ?> - <?php echo e($endDate->format('M d, Y')); ?>

                    <?php elseif($view === 'month'): ?>
                        <?php echo e($currentDate->format('F Y')); ?>

                    <?php else: ?>
                        <?php echo e($currentDate->format('Y')); ?>

                    <?php endif; ?>
                </span>
                <a href="<?php echo e(route('admin.company.dashboard', ['view' => $view, 'date' => $nextDate->format('Y-m-d')])); ?>"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="<?php echo e(route('admin.company.dashboard', ['view' => $view, 'date' => now()->format('Y-m-d')])); ?>"
                    class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition">
                    <?php echo e(__('app.today')); ?>

                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <?php
                $today = now()->format('Y-m-d');
            ?>

            <?php if($view === 'year'): ?>
                <!-- Year View - 12 Months Grid -->
                <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $monthDate = $currentDate->copy()->month($month)->startOfMonth();
                            $monthBookings = $business->bookings()
                                ->whereMonth('booking_date', $month)
                                ->whereYear('booking_date', $currentDate->year)
                                ->count();
                        ?>
                        <a href="<?php echo e(route('admin.company.dashboard', ['view' => 'month', 'date' => $monthDate->format('Y-m-d')])); ?>"
                            class="p-4 border rounded-lg hover:shadow-md transition <?php echo e($monthDate->month === now()->month && $monthDate->year === now()->year ? 'ring-2 ring-purple-500' : ''); ?>">
                            <div class="text-center">
                                <div class="font-bold text-gray-900 mb-2"><?php echo e($monthDate->format('F')); ?></div>
                                <div class="text-2xl font-bold text-green-600"><?php echo e($monthBookings); ?></div>
                                <div class="text-xs text-gray-600"><?php echo e(__('app.bookings')); ?></div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <!-- Week/Month View - Calendar Grid -->
                <div class="grid grid-cols-7 gap-2 mb-4">
                    <?php $__currentLoopData = [__('app.sun'), __('app.mon'), __('app.tue'), __('app.wed'), __('app.thu'), __('app.fri'), __('app.sat')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="text-center font-bold text-gray-700 py-2"><?php echo e($day); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="grid grid-cols-7 gap-2">
                    <?php
                        $calStartDate = $view === 'week' ? $startDate->copy() : $startDate->copy()->startOfWeek();
                        $calEndDate = $view === 'week' ? $endDate->copy() : $endDate->copy()->endOfWeek();
                        $loopDate = $calStartDate->copy();
                    ?>
                    <?php while($loopDate <= $calEndDate): ?>
                        <?php
                            $dateStr = $loopDate->format('Y-m-d');
                            $isInRange = $loopDate->between($startDate, $endDate);
                            $isToday = $dateStr === $today;
                            $dayBookings = $calendarBookings->get($dateStr, collect());
                            $bookingCount = $dayBookings->count();
                        ?>
                        <div
                            class="min-h-[120px] border rounded-lg p-2 <?php if($isInRange): ?> bg-white <?php else: ?> bg-gray-50 <?php endif; ?> <?php if($isToday): ?> ring-2 ring-purple-500 <?php endif; ?>">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-semibold <?php if(!$isInRange): ?> text-gray-400 <?php else: ?> text-gray-900 <?php endif; ?>">
                                    <?php echo e($loopDate->format('j')); ?>

                                </span>
                                <?php if($bookingCount > 0): ?>
                                    <span class="text-xs font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                        <?php echo e($bookingCount); ?>

                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php if($bookingCount > 0 && $isInRange): ?>
                                <div class="space-y-1 mt-2 max-h-[80px] overflow-y-auto">
                                    <?php $__currentLoopData = $dayBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <button onclick="showBookingDetails(<?php echo e(json_encode([
                                            'id' => $booking->id,
                                            'customer_name' => $booking->customer_name,
                                            'customer_email' => $booking->customer_email,
                                            'customer_phone' => $booking->customer_phone,
                                            'service' => $booking->services_label,
                                            'date' => \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y'),
                                            'time' => substr($booking->start_time, 0, 5) . ' - ' . substr($booking->end_time, 0, 5),
                                            'status' => $booking->status,
                                            'reference_code' => $booking->reference_code
                                        ])); ?>)" type="button"
                                                    class="w-full text-left text-xs p-1 rounded cursor-pointer hover:opacity-80 transition
                                                                                                                                            <?php if($booking->status === 'confirmed'): ?> bg-green-100 text-green-800 border border-green-200
                                                                                                                                            <?php elseif($booking->status === 'pending'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                                                                                                                                            <?php elseif($booking->status === 'cancelled'): ?> bg-red-100 text-red-800 border border-red-200
                                                                                                                                            <?php else: ?> bg-blue-100 text-blue-800 border border-blue-200
                                                                                                                                            <?php endif; ?>">
                                                    <div class="font-semibold truncate"><?php echo e(substr($booking->start_time, 0, 5)); ?></div>
                                                    <div class="truncate"><?php echo e($booking->customer_name); ?></div>
                                                </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                            $loopDate->addDay();
                        ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Calendar Legend -->
        <div class="mt-6 flex flex-wrap items-center gap-4 text-xs">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-green-100 border border-green-200 rounded"></div>
                <span class="text-gray-600"><?php echo e(__('app.confirmed')); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-yellow-100 border border-yellow-200 rounded"></div>
                <span class="text-gray-600"><?php echo e(__('app.pending')); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-red-100 border border-red-200 rounded"></div>
                <span class="text-gray-600"><?php echo e(__('app.cancelled')); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-blue-100 border border-blue-200 rounded"></div>
                <span class="text-gray-600"><?php echo e(__('app.completed')); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 ring-2 ring-green-500 rounded"></div>
                <span class="text-gray-600"><?php echo e(__('app.today')); ?></span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Upcoming Bookings -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.upcoming_bookings')); ?></h2>
                <a href="<?php echo e(route('admin.bookings.index')); ?>"
                    class="text-green-600 hover:text-green-700 text-sm font-medium"><?php echo e(__('app.view_all')); ?></a>
            </div>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900"><?php echo e($booking->customer_name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($booking->services_label); ?></p>
                            <p class="text-xs text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('M d, Y')); ?> at
                                <?php echo e(substr($booking->start_time, 0, 5)); ?>

                            </p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                            <?php if($booking->status === 'confirmed'): ?> bg-green-100 text-green-800
                                                            <?php elseif($booking->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                                            <?php elseif($booking->status === 'cancelled'): ?> bg-red-100 text-red-800
                                                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php echo e(ucfirst($booking->status)); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8"><?php echo e(__('app.no_upcoming_bookings')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Services -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.top_services')); ?></h2>
                <a href="<?php echo e(route('admin.services.index')); ?>"
                    class="text-green-600 hover:text-green-700 text-sm font-medium"><?php echo e(__('app.view_all')); ?></a>
            </div>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $topServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900"><?php echo e($service->name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($service->duration_minutes); ?> <?php echo e(__('app.minutes')); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-green-600"><?php echo e($service->bookings_count); ?></p>
                            <p class="text-xs text-gray-600"><?php echo e(__('app.bookings')); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8"><?php echo e(__('app.no_services_yet')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Staff Workload Analytics -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">
                    <svg class="w-6 h-6 inline mr-2 text-green-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <?php echo e(__('app.staff_workload')); ?>

                </h2>
                <a href="<?php echo e(route('admin.staff.index')); ?>"
                    class="text-green-600 hover:text-green-700 text-sm font-medium"><?php echo e(__('app.manage_staff')); ?></a>
            </div>

            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $staffWorkload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-lg border border-blue-100 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-lg">
                                    <?php echo e(strtoupper(substr($staff['name'], 0, 1))); ?>

                                </div>
                                <div>
                                    <p class="font-bold text-gray-900"><?php echo e($staff['name']); ?></p>
                                    <p class="text-xs text-gray-600">
                                        <span class="capitalize"><?php echo e(str_replace('_', ' ', $staff['role'])); ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-600"><?php echo e($staff['total_bookings']); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e(__('app.total_bookings')); ?></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-2 pt-3 border-t border-blue-200">
                            <div class="text-center">
                                <p class="text-lg font-semibold text-blue-600"><?php echo e($staff['pending_bookings']); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e(__('app.pending')); ?></p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-semibold text-green-600"><?php echo e($staff['upcoming_bookings']); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e(__('app.upcoming')); ?></p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-semibold text-indigo-600"><?php echo e($staff['completed_bookings']); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e(__('app.completed')); ?></p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-semibold text-green-600"><?php echo e($staff['bookings_this_month']); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e(__('app.this_month')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8"><?php echo e(__('app.no_staff_yet')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <a href="<?php echo e(route('admin.bookings.index')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-green-300 transition text-center">
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.view_bookings')); ?></p>
        </a>

        <a href="<?php echo e(route('admin.services.create')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-green-300 transition text-center">
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.add_service')); ?></p>
        </a>

        <a href="<?php echo e(route('admin.business.edit')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-green-300 transition text-center">
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.settings')); ?></p>
        </a>

        <a href="<?php echo e(route('admin.working_hours.edit')); ?>"
            class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-green-300 transition text-center">
            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-semibold text-gray-900"><?php echo e(__('app.working_hours')); ?></p>
        </a>
    </div>

    <!-- Booking Details Modal -->
    <div id="bookingModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 relative">
            <button onclick="closeBookingModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="text-2xl font-bold text-gray-900 mb-4">📋 <?php echo e(__('app.booking_details')); ?></h3>

            <div class="space-y-4">
                <div class="pb-4 border-b">
                    <span id="modal-status" class="inline-block px-3 py-1 text-sm font-semibold rounded-full"></span>
                    <p class="text-sm text-gray-500 mt-2"><?php echo e(__('app.reference')); ?>: <span id="modal-reference"
                            class="font-mono"></span></p>
                </div>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 font-medium"><?php echo e(__('app.customer')); ?></p>
                        <p id="modal-customer-name" class="text-lg font-bold text-gray-900"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium"><?php echo e(__('app.email')); ?></p>
                            <p id="modal-customer-email" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium"><?php echo e(__('app.phone')); ?></p>
                            <p id="modal-customer-phone" class="text-sm text-gray-900"></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 font-medium"><?php echo e(__('app.service')); ?></p>
                        <p id="modal-service" class="text-lg font-semibold text-purple-600"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium"><?php echo e(__('app.date')); ?></p>
                            <p id="modal-date" class="text-sm font-semibold text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium"><?php echo e(__('app.time')); ?></p>
                            <p id="modal-time" class="text-sm font-semibold text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <a id="modal-view-booking" href="#"
                        class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-medium">
                        <?php echo e(__('app.view_details')); ?>

                    </a>
                    <button onclick="closeBookingModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        <?php echo e(__('app.close')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showBookingDetails(booking) {
            // Set status with color
            const statusEl = document.getElementById('modal-status');
            statusEl.textContent = booking.status.charAt(0).toUpperCase() + booking.status.slice(1);
            statusEl.className = 'inline-block px-3 py-1 text-sm font-semibold rounded-full ';

            if (booking.status === 'confirmed') {
                statusEl.className += 'bg-green-100 text-green-800';
            } else if (booking.status === 'pending') {
                statusEl.className += 'bg-yellow-100 text-yellow-800';
            } else if (booking.status === 'cancelled') {
                statusEl.className += 'bg-red-100 text-red-800';
            } else {
                statusEl.className += 'bg-blue-100 text-blue-800';
            }

            // Set booking details
            document.getElementById('modal-reference').textContent = booking.reference_code;
            document.getElementById('modal-customer-name').textContent = booking.customer_name;
            document.getElementById('modal-customer-email').textContent = booking.customer_email || 'N/A';
            document.getElementById('modal-customer-phone').textContent = booking.customer_phone;
            document.getElementById('modal-service').textContent = booking.service;
            document.getElementById('modal-date').textContent = booking.date;
            document.getElementById('modal-time').textContent = booking.time;
            document.getElementById('modal-view-booking').href = '/admin/bookings/' + booking.id;

            // Show modal
            document.getElementById('bookingModal').classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeBookingModal();
            }
        });

        // Close modal on background click
        document.getElementById('bookingModal')?.addEventListener('click', function (e) {
            if (e.target.id === 'bookingModal') {
                closeBookingModal();
            }
        });
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
<?php endif; ?><?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/company/dashboard.blade.php ENDPATH**/ ?>