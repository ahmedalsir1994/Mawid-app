
<?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $notifType = $notification->data['type'] ?? 'booking';
        if ($notifType === 'contact_submission') {
            $notifUrl      = route('admin.contact-submissions.show', $notification->data['id']);
            $notifIcon     = 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z';
            $notifIconBg   = 'bg-green-100';
            $notifIconColor = 'text-green-600';
            $notifSub      = ($notification->data['email'] ?? '') . ' · ' . ($notification->data['phone'] ?? '');
        } elseif ($notifType === 'new_user') {
            $notifUrl      = route('admin.super.users.show', $notification->data['user_id'] ?? 0);
            $notifIcon     = 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z';
            $notifIconBg   = 'bg-blue-100';
            $notifIconColor = 'text-blue-600';
            $notifSub      = ($notification->data['user_email'] ?? '') . ' · ' . ($notification->data['business_name'] ?? '');
        } elseif ($notifType === 'new_license') {
            $notifUrl      = route('admin.super.licenses.show', $notification->data['license_id'] ?? 0);
            $notifIcon     = 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z';
            $notifIconBg   = 'bg-purple-100';
            $notifIconColor = 'text-purple-600';
            $notifSub      = ucfirst($notification->data['plan'] ?? '') . ' · ' . ($notification->data['business_name'] ?? '');
        } elseif ($notifType === 'auto_renew_failed') {
            $notifUrl      = $notification->data['url'] ?? route('admin.billing.index');
            $notifIcon     = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
            $notifIconBg   = 'bg-red-100';
            $notifIconColor = 'text-red-600';
            $notifSub      = ($notification->data['reason'] ?? '') . ' · Attempt ' . ($notification->data['attempt'] ?? 1);
        } else {
            $notifUrl      = ($notifUserRole === 'staff'
                ? route('admin.staff.bookings.show', $notification->data['booking_id'] ?? 0)
                : route('admin.bookings.show', $notification->data['booking_id'] ?? 0))
                . '?notification=' . $notification->id;
            $notifIcon     = 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z';
            $notifIconBg   = 'bg-green-100';
            $notifIconColor = 'text-green-600';
            $notifSub      = isset($notification->data['booking_date'])
                ? \Carbon\Carbon::parse($notification->data['booking_date'])->format('M d, Y')
                    . (isset($notification->data['start_time']) ? ' at ' . substr($notification->data['start_time'], 0, 5) : '')
                : '';
        }
    ?>
    <a href="<?php echo e($notifUrl); ?>"
        class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 <?php echo e($notification->read_at ? 'bg-white' : 'bg-blue-50'); ?>">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0 w-10 h-10 <?php echo e($notifIconBg); ?> rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 <?php echo e($notifIconColor); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($notifIcon); ?>" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">
                    <?php echo e($notification->data['message'] ?? ''); ?>

                </p>
                <?php if($notifSub): ?>
                    <p class="text-xs text-gray-500 mt-1"><?php echo e($notifSub); ?></p>
                <?php endif; ?>
                <p class="text-xs text-gray-400 mt-1">
                    <?php echo e($notification->created_at->diffForHumans()); ?>

                </p>
            </div>
            <?php if(!$notification->read_at): ?>
                <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-1"></div>
            <?php endif; ?>
        </div>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="px-4 py-8 text-center text-gray-500">
        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <p class="text-sm"><?php echo e(__('app.no_notifications')); ?></p>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/layouts/partials/notification-items.blade.php ENDPATH**/ ?>