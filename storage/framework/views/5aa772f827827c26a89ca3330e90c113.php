<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmed - <?php echo e($business->name); ?></title>
    
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        [dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-purple-50 to-pink-50">
    <!-- Language Switcher -->
    <div class="fixed top-4 <?php echo e(app()->getLocale() === 'ar' ? 'left-4' : 'right-4'); ?> z-50">
        <div class="flex gap-2 bg-white rounded-lg shadow-lg border border-gray-200 p-2">
            <a href="<?php echo e(route('lang.switch', 'en')); ?>"
                class="px-3 py-1.5 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'en' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                EN
            </a>
            <a href="<?php echo e(route('lang.switch', 'ar')); ?>"
                class="px-3 py-1.5 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'ar' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                AR
            </a>
        </div>
    </div>
    
    <div class="min-h-screen flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-2xl">
            <!-- Success Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 sm:p-12">
                <!-- Success Icon -->
                <div class="flex justify-center mb-8">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center animate-bounce">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <!-- Confirmation Message -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2"><?php echo e(__('app.booking_confirmed')); ?></h1>
                    <p class="text-lg text-gray-600"><?php echo e(__('app.appointment_scheduled')); ?></p>
                </div>

                <!-- Booking Details -->
                <div
                    class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-100 p-6 space-y-4 mb-8">
                    <div class="flex items-start justify-between pb-4 border-b border-purple-200">
                        <div>
                            <p class="text-sm text-gray-600 mb-1"><?php echo e(__('app.reference_code')); ?></p>
                            <p class="text-2xl font-bold text-green-600 font-mono"><?php echo e($booking->reference_code); ?></p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('<?php echo e($booking->reference_code); ?>')"
                            class="px-3 py-1 bg-white border border-gray-300 rounded text-sm hover:bg-gray-100 transition">
                            <?php echo e(__('app.copy')); ?>

                        </button>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1"><?php echo e(__('app.service')); ?></p>
                            <p class="font-semibold text-gray-900"><?php echo e($booking->service->name); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1"><?php echo e(__('app.duration')); ?></p>
                            <p class="font-semibold text-gray-900"><?php echo e($booking->service->duration_minutes); ?>

                                <?php echo e(__('app.minutes')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1"><?php echo e(__('app.date')); ?></p>
                            <p class="font-semibold text-gray-900">
                                <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y')); ?>

                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1"><?php echo e(__('app.time')); ?></p>
                            <p class="font-semibold text-gray-900"><?php echo e(substr($booking->start_time, 0, 5)); ?></p>
                        </div>
                        <?php if($booking->staff): ?>
                        <div class="col-span-2 sm:col-span-1">
                            <p class="text-sm text-gray-600 mb-1"><?php echo e(__('app.staff') ?? 'Staff'); ?></p>
                            <p class="font-semibold text-gray-900"><?php echo e($booking->staff->name); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Business Info -->
                    <div class="pt-4 border-t border-purple-200">
                        <?php if($booking->branch): ?>
                            <p class="text-sm text-gray-600 mb-1">📍 <?php echo e(__('app.branch') ?? 'Branch'); ?></p>
                            <p class="font-semibold text-gray-900"><?php echo e($booking->branch->name); ?></p>
                            <?php if($booking->branch->address): ?>
                                <p class="text-sm text-gray-600"><?php echo e($booking->branch->address); ?></p>
                            <?php endif; ?>
                            <?php if($booking->branch->phone): ?>
                                <p class="text-xs text-gray-500 mt-1">📞 <?php echo e($booking->branch->phone); ?></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-600 mb-1"><?php echo e(__('app.business')); ?></p>
                            <p class="font-semibold text-gray-900"><?php echo e($business->name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($business->address); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Notification Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-blue-900 mb-1"><?php echo e(__('app.whatsapp_reminder')); ?></p>
                            <p class="text-sm text-blue-800"><?php echo e(__('app.reminder_notification')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?php echo e(route('public.business', $business->slug)); ?>"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition text-center">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <?php echo e(__('app.book_another_service')); ?>

                    </a>
                    <a href="<?php echo e(route('landing')); ?>"
                        class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                        Return to Home
                    </a>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="mt-8 text-center text-gray-600 text-sm">
                <p>Questions? Contact the business directly or check your email for booking details.</p>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH C:\laragon\www\booking-app\resources\views\public\success.blade.php ENDPATH**/ ?>