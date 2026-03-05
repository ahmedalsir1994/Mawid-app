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
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">👋 <?php echo e(__('app.welcome', ['name' => Auth::user()->name])); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e(__('app.staff_dashboard_title', ['business' => $business->name])); ?></p>
            </div>
            <div class="text-right">
                <?php if($license && $license->isActive()): ?>
                    <span class="inline-block px-4 py-2 bg-green-100 text-green-800 font-medium rounded-lg">
                        ✓ <?php echo e(__('app.system_active')); ?>

                    </span>
                <?php endif; ?>
                <p class="text-sm text-gray-600 mt-2"><?php echo e(now()->format('l, F j, Y')); ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Today's Bookings -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 rounded-xl shadow-md p-6 text-white">
            <h3 class="font-medium mb-2 opacity-90"><?php echo e(__('app.today_bookings')); ?></h3>
            <p class="text-4xl font-bold"><?php echo e($todayBookings); ?></p>
            <p class="text-sm mt-2 opacity-90"><?php echo e(now()->format('l')); ?></p>
        </div>

        <!-- Upcoming Bookings -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.upcoming_bookings')); ?></h3>
            <p class="text-4xl font-bold text-gray-900"><?php echo e($upcomingBookings->count()); ?></p>
            <p class="text-sm text-gray-600 mt-2"><?php echo e(__('app.next_7_days')); ?></p>
        </div>

        <!-- Total Services -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2"><?php echo e(__('app.available_services')); ?></h3>
            <p class="text-4xl font-bold text-gray-900"><?php echo e($services->count()); ?></p>
            <p class="text-sm text-gray-600 mt-2"><?php echo e(__('app.offered_by_business')); ?></p>
        </div>
    </div>

    <!-- Today's Schedule -->
    <?php if($todayBookingsList->count() > 0): ?>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">🗓️ <?php echo e(__('app.today_schedule')); ?></h2>
                <span class="text-sm text-gray-600"><?php echo e(now()->format('l, M j')); ?></span>
            </div>

            <div class="space-y-3">
                <?php $__currentLoopData = $todayBookingsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-4 p-4 rounded-lg border-l-4 
                                <?php if($booking->status === 'confirmed'): ?> border-green-500 bg-green-50
                                <?php elseif($booking->status === 'pending'): ?> border-yellow-500 bg-yellow-50
                                <?php elseif($booking->status === 'completed'): ?> border-blue-500 bg-blue-50
                                <?php else: ?> border-gray-300 bg-gray-50
                                <?php endif; ?>">

                        <div class="flex-shrink-0 text-center">
                            <div class="text-2xl font-bold text-gray-900">
                                <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?></div>
                            <div class="text-xs text-gray-600"><?php echo e($booking->service->duration); ?>min</div>
                        </div>

                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900"><?php echo e($booking->service->name); ?></h3>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium"><?php echo e($booking->customer_name); ?></span>
                                <?php if($booking->customer_phone): ?>
                                    • <?php echo e($booking->customer_phone); ?>

                                <?php endif; ?>
                            </p>
                        </div>

                        <div class="flex-shrink-0">
                            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full
                                        <?php if($booking->status === 'confirmed'): ?> bg-green-100 text-green-800
                                        <?php elseif($booking->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($booking->status === 'completed'): ?> bg-blue-100 text-blue-800
                                        <?php elseif($booking->status === 'cancelled'): ?> bg-red-100 text-red-800
                                        <?php endif; ?>">
                                <?php echo e(ucfirst($booking->status)); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8 mb-8 text-center">
            <div class="text-6xl mb-4">🎉</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e(__('app.no_bookings_today')); ?></h3>
            <p class="text-gray-600"><?php echo e(__('app.enjoy_free_time')); ?></p>
        </div>
    <?php endif; ?>

    <!-- Live Calendar View -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
        <!-- Calendar Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-900">📅 <?php echo e(__('app.calendar_view')); ?></h2>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full lg:w-auto">
                <!-- View Switcher -->
                <div class="flex bg-gray-100 rounded-lg p-1 gap-1">
                    <a href="<?php echo e(route('admin.staff.dashboard', ['view' => 'day', 'date' => $currentDate->format('Y-m-d')])); ?>"
                        class="px-4 py-2 rounded-md text-sm font-medium transition <?php echo e($view === 'day' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                        <?php echo e(__('app.day')); ?>

                    </a>
                    <a href="<?php echo e(route('admin.staff.dashboard', ['view' => 'week', 'date' => $currentDate->format('Y-m-d')])); ?>"
                        class="px-4 py-2 rounded-md text-sm font-medium transition <?php echo e($view === 'week' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                        <?php echo e(__('app.week')); ?>

                    </a>
                    <a href="<?php echo e(route('admin.staff.dashboard', ['view' => 'month', 'date' => $currentDate->format('Y-m-d')])); ?>"
                        class="px-4 py-2 rounded-md text-sm font-medium transition <?php echo e($view === 'month' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                        <?php echo e(__('app.month')); ?>

                    </a>
                </div>

                <!-- Date Navigation -->
                <div class="flex items-center gap-2">
                    <?php
                        $prevDate = $view === 'day' ? $currentDate->copy()->subDay() :
                                    ($view === 'week' ? $currentDate->copy()->subWeek() : $currentDate->copy()->subMonth());
                        $nextDate = $view === 'day' ? $currentDate->copy()->addDay() :
                                    ($view === 'week' ? $currentDate->copy()->addWeek() : $currentDate->copy()->addMonth());
                    ?>

                    <a href="<?php echo e(route('admin.staff.dashboard', ['view' => $view, 'date' => $prevDate->format('Y-m-d')])); ?>"
                        class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>

                    <span class="text-sm font-medium text-gray-700 min-w-[140px] text-center">
                        <?php if($view === 'day'): ?>
                            <?php echo e($currentDate->format('M d, Y')); ?>

                        <?php elseif($view === 'week'): ?>
                            <?php echo e($startDate->format('M d')); ?> - <?php echo e($endDate->format('M d, Y')); ?>

                        <?php else: ?>
                            <?php echo e($currentDate->format('F Y')); ?>

                        <?php endif; ?>
                    </span>

                    <a href="<?php echo e(route('admin.staff.dashboard', ['view' => $view, 'date' => $nextDate->format('Y-m-d')])); ?>"
                        class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="<?php echo e(route('admin.staff.dashboard', ['view' => $view, 'date' => now()->format('Y-m-d')])); ?>"
                        class="ml-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <?php echo e(__('app.today')); ?>

                    </a>
                </div>
            </div>
        </div>

        <!-- Day View -->
        <?php if($view === 'day'): ?>
            <?php
                $dayBookings = $calendarBookings->get($currentDate->format('Y-m-d'), collect());
            ?>

            <div class="border rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-500 text-white p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold"><?php echo e($currentDate->format('l')); ?></h3>
                            <p class="text-sm opacity-90"><?php echo e($currentDate->format('F j, Y')); ?></p>
                        </div>
                        <div class="text-3xl">
                            <?php if($dayBookings->count() > 0): ?>
                                📅
                            <?php else: ?>
                                🎉
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <?php $__empty_1 = true; $__currentLoopData = $dayBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-start gap-4 p-4 mb-3 rounded-lg border-l-4 
                                    <?php if($booking->status === 'confirmed'): ?> border-green-500 bg-green-50
                                    <?php elseif($booking->status === 'pending'): ?> border-yellow-500 bg-yellow-50
                                    <?php elseif($booking->status === 'completed'): ?> border-blue-500 bg-blue-50
                                    <?php else: ?> border-gray-300 bg-gray-50
                                    <?php endif; ?>">

                            <div class="flex-shrink-0 text-center bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-gray-900">
                                    <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?></div>
                                <div class="text-xs text-gray-600 mt-1"><?php echo e($booking->service->duration); ?> min</div>
                            </div>

                            <div class="flex-1">
                                <h4 class="font-bold text-lg text-gray-900 mb-1"><?php echo e($booking->service->name); ?></h4>
                                <p class="text-sm text-gray-600 mb-2">
                                    <span class="font-medium"><?php echo e($booking->customer_name); ?></span>
                                    <?php if($booking->customer_phone): ?>
                                        • <?php echo e($booking->customer_phone); ?>

                                    <?php endif; ?>
                                </p>
                                <?php if($booking->customer_email): ?>
                                    <p class="text-xs text-gray-500">✉️ <?php echo e($booking->customer_email); ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="flex-shrink-0">
                                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full
                                            <?php if($booking->status === 'confirmed'): ?> bg-green-100 text-green-800
                                            <?php elseif($booking->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                            <?php elseif($booking->status === 'completed'): ?> bg-blue-100 text-blue-800
                                            <?php elseif($booking->status === 'cancelled'): ?> bg-red-100 text-red-800
                                            <?php endif; ?>">
                                    <?php echo e(ucfirst($booking->status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-12 text-gray-500">
                            <div class="text-6xl mb-4">🎉</div>
                            <p class="text-lg font-medium"><?php echo e(__('app.no_bookings_for_day')); ?></p>
                            <p class="text-sm"><?php echo e(__('app.enjoy_free_time_short')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <!-- Week View -->
        <?php elseif($view === 'week'): ?>
            <?php
                $weekDays = [];
                $current = $startDate->copy();
                while ($current <= $endDate) {
                    $weekDays[] = $current->copy();
                    $current->addDay();
                }
            ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-2">
                <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $dayBookings = $calendarBookings->get($day->format('Y-m-d'), collect());
                        $isToday = $day->isToday();
                    ?>

                    <div class="min-h-[150px] border rounded-lg p-3 
                                <?php if($isToday): ?> bg-green-50 border-green-400 border-2
                                <?php else: ?> bg-white border-gray-200 <?php endif; ?> transition hover:shadow-md">

                        <div class="text-center mb-3 pb-2 border-b <?php echo e($isToday ? 'border-green-300' : 'border-gray-200'); ?>">
                            <div class="text-xs font-medium text-gray-600"><?php echo e($day->format('D')); ?></div>
                            <div class="text-xl font-bold 
                                        <?php if($isToday): ?> text-green-600 
                                        <?php else: ?> text-gray-900 <?php endif; ?>">
                                <?php echo e($day->format('j')); ?>

                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <?php $__empty_1 = true; $__currentLoopData = $dayBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="text-xs p-2 rounded-md shadow-sm
                                            <?php if($booking->status === 'confirmed'): ?> bg-green-100 text-green-800 border border-green-200
                                            <?php elseif($booking->status === 'pending'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                                            <?php elseif($booking->status === 'completed'): ?> bg-blue-100 text-blue-800 border border-blue-200
                                            <?php else: ?> bg-gray-100 text-gray-700 border border-gray-200
                                            <?php endif; ?>">
                                    <div class="font-bold mb-0.5">
                                        <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?>

                                    </div>
                                    <div class="truncate font-medium"><?php echo e($booking->service->name); ?></div>
                                    <div class="truncate text-[10px] opacity-75 mt-0.5">
                                        <?php echo e($booking->customer_name); ?></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-xs text-gray-400 text-center py-3">
                                    <div class="text-2xl mb-1">·</div>
                                    <div><?php echo e(__('app.no_bookings')); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        <!-- Month View -->
        <?php elseif($view === 'month'): ?>
            <?php
                $monthStart = $startDate->copy()->startOfMonth()->startOfWeek();
                $monthEnd = $endDate->copy()->endOfMonth()->endOfWeek();
                $weeks = [];
                $currentWeek = [];
                $current = $monthStart->copy();

                while ($current <= $monthEnd) {
                    $currentWeek[] = $current->copy();
                    if (count($currentWeek) === 7) {
                        $weeks[] = $currentWeek;
                        $currentWeek = [];
                    }
                    $current->addDay();
                }
            ?>

            <div class="border rounded-lg overflow-hidden">
                <!-- Day Headers -->
                <div class="grid grid-cols-7 bg-gray-50 border-b">
                    <?php $__currentLoopData = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-3 text-center text-sm font-bold text-gray-700 border-r last:border-r-0">
                            <?php echo e(__('app.' . $dayName)); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Calendar Grid -->
                <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="grid grid-cols-7 border-b last:border-b-0">
                        <?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $dayBookings = $calendarBookings->get($day->format('Y-m-d'), collect());
                                $isToday = $day->isToday();
                                $isCurrentMonth = $day->month === $currentDate->month;
                            ?>

                            <div class="min-h-[100px] p-2 border-r last:border-r-0 
                                        <?php if(!$isCurrentMonth): ?> bg-gray-50 
                                        <?php elseif($isToday): ?> bg-green-50 
                                        <?php else: ?> bg-white <?php endif; ?> hover:bg-gray-50 transition">

                                <div class="text-sm font-medium mb-1 
                                            <?php if($isToday): ?> text-green-600 font-bold
                                            <?php elseif(!$isCurrentMonth): ?> text-gray-400
                                            <?php else: ?> text-gray-900 <?php endif; ?>">
                                    <?php echo e($day->format('j')); ?>

                                </div>

                                <div class="space-y-1">
                                    <?php $__currentLoopData = $dayBookings->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="text-[10px] p-1 rounded truncate
                                                    <?php if($booking->status === 'confirmed'): ?> bg-green-100 text-green-800
                                                    <?php elseif($booking->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                                    <?php elseif($booking->status === 'completed'): ?> bg-blue-100 text-blue-800
                                                    <?php else: ?> bg-gray-100 text-gray-700
                                                    <?php endif; ?>">
                                            <span class="font-semibold">
                                                <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?>

                                            </span>
                                            <?php echo e($booking->service->name); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($dayBookings->count() > 3): ?>
                                        <div class="text-[10px] text-green-600 font-semibold">
                                            +<?php echo e($dayBookings->count() - 3); ?> <?php echo e(__('app.more')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Upcoming Bookings -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">📋 <?php echo e(__('app.upcoming_bookings')); ?></h2>

        <?php if($upcomingBookings->count() > 0): ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $upcomingBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:shadow-md transition">
                        <div class="flex-shrink-0 text-center bg-green-100 rounded-lg p-3">
                            <div class="text-xs font-medium text-green-600">
                                <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('M')); ?></div>
                            <div class="text-2xl font-bold text-green-600">
                                <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('d')); ?></div>
                        </div>

                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900"><?php echo e($booking->service->name); ?></h3>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium"><?php echo e($booking->customer_name); ?></span>
                                • <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('h:i A')); ?>

                                • <?php echo e($booking->service->duration); ?> min
                            </p>
                        </div>

                        <div class="flex-shrink-0">
                            <a href="<?php echo e(route('admin.staff.bookings.show', $booking)); ?>"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                <?php echo e(__('app.view_details')); ?>

                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">
                <p><?php echo e(__('app.no_upcoming_bookings')); ?></p>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views\admin\staff\dashboard.blade.php ENDPATH**/ ?>