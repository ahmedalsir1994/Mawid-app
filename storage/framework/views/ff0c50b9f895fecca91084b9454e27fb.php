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
                <h2 class="font-bold text-3xl text-gray-800"><?php echo e(__('app.booking_details')); ?></h2>
                <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.reference')); ?>: <?php echo e($booking->reference_code); ?>

                    <?php if($booking->is_walk_in): ?>
                        <span class="ms-2 inline-flex items-center px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">🚶 Walk-in</span>
                    <?php endif; ?>
                </p>
            </div>
            <a href="<?php echo e(auth()->user()->role === 'staff' ? route('admin.staff.bookings.index') : route('admin.bookings.index')); ?>"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                ← <?php echo e(__('app.back_to_bookings')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto">
        <?php if(session('success')): ?>
            <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-medium">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e(__('app.booking_status')); ?></h3>
                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full
                        <?php if($booking->status === 'confirmed'): ?> bg-green-100 text-green-800
                        <?php elseif($booking->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                        <?php elseif($booking->status === 'cancelled'): ?> bg-red-100 text-red-800
                        <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                        <?php echo e(ucfirst($booking->status)); ?>

                    </span>
                </div>
                <div>
                    <form method="POST"
                        action="<?php echo e(auth()->user()->role === 'staff' ? route('admin.staff.bookings.status', $booking) : route('admin.bookings.status', $booking)); ?>"
                        class="inline">
                        <?php echo csrf_field(); ?>
                        <select lang="en" dir="ltr" name="status"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500"
                            onchange="this.form.submit()">
                            <?php $__currentLoopData = ['pending' => __('app.pending'), 'confirmed' => __('app.confirmed'), 'cancelled' => __('app.cancelled'), 'completed' => __('app.completed')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($st); ?>" <?php if($booking->status === $st): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <?php echo e(__('app.customer_information')); ?>

            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 font-medium"><?php echo e(__('app.name')); ?></p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($booking->customer_name); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Phone</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($booking->customer_phone); ?></p>
                </div>
                <?php if($booking->customer_email): ?>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Email</p>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($booking->customer_email); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Appointment Details
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="<?php echo e($booking->allServices()->count() > 1 ? 'md:col-span-2' : ''); ?>">
                    <p class="text-sm text-gray-600 font-medium">Service</p>
                    <?php if($booking->allServices()->count() > 1): ?>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <?php $__currentLoopData = $booking->allServices(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-50 border border-green-200 text-sm font-medium text-green-800">
                                    <span><?php echo e($svc->name); ?></span>
                                    <span class="text-green-500 text-xs">· <?php echo e($svc->duration_minutes); ?> min</span>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-lg font-semibold text-green-600"><?php echo e($booking->services_label); ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Duration</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($booking->total_duration); ?> minutes</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Date</p>
                    <p class="text-lg font-semibold text-gray-900">
                        <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y')); ?>

                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Time</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e(substr($booking->start_time, 0, 5)); ?> -
                        <?php echo e(substr($booking->end_time, 0, 5)); ?>

                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Assigned Staff</p>
                    <?php if(auth()->user()->role === 'company_admin' && count($staffMembers)): ?>
                        <form method="POST" action="<?php echo e(route('admin.bookings.reassign', $booking)); ?>" class="mt-2 flex items-center gap-2">
                            <?php echo csrf_field(); ?>
                            <select name="staff_user_id"
                                class="flex-1 px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                <option value="">— Unassigned —</option>
                                <?php $__currentLoopData = $staffMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sm->id); ?>" <?php if($booking->staff_user_id == $sm->id): echo 'selected'; endif; ?>>
                                        <?php echo e($sm->name); ?><?php echo e($sm->title ? ' · '.$sm->title : ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition whitespace-nowrap">
                                Reassign
                            </button>
                        </form>
                    <?php else: ?>
                        <?php if($booking->staff): ?>
                            <div class="flex items-center space-x-2 mt-1">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-700 font-bold text-sm"><?php echo e(strtoupper(substr($booking->staff->name, 0, 1))); ?></span>
                                </div>
                                <p class="text-lg font-semibold text-gray-900"><?php echo e($booking->staff->name); ?></p>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-400 italic mt-1">Not assigned</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if($booking->branch): ?>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Branch</p>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            📍 <?php echo e($booking->branch->name); ?>

                        </span>
                        <?php if($booking->branch->address): ?>
                            <p class="text-sm text-gray-500 mt-1"><?php echo e($booking->branch->address); ?></p>
                        <?php endif; ?>
                        <?php if($booking->branch->phone): ?>
                            <p class="text-xs text-gray-400 mt-0.5">📞 <?php echo e($booking->branch->phone); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($booking->customer_notes): ?>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600 font-medium">Notes</p>
                        <p class="text-gray-900"><?php echo e($booking->customer_notes); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Reminder Status -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Reminder Status
            </h3>
            <div class="flex items-center justify-between">
                <div>
                    <?php if($booking->reminder_sent_at): ?>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            ✓ Reminder Sent
                        </span>
                        <p class="text-sm text-gray-600 mt-2">Sent <?php echo e($booking->reminder_sent_at->diffForHumans()); ?></p>
                    <?php else: ?>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Not Sent
                        </span>
                    <?php endif; ?>
                </div>
                <div>
                    <?php
                        // Clean and format phone number
                        $phone = preg_replace('/[^0-9+]/', '', $booking->customer_phone);
                        $phone = ltrim($phone, '+');

                        // Add country code if not present
                        if (!preg_match('/^(968|966|971|965|973|974)/', $phone)) {
                            $phone = '968' . $phone;
                        }

                        // Format date and create message
                        $date = \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y');
                        $time = substr($booking->start_time, 0, 5);

                        $message = "Hello {$booking->customer_name}! 👋\n\n";
                        $message .= "This is a reminder from *" . $booking->business->name . "*\n\n";
                        $message .= "📅 *Appointment Details:*\n";
                        $message .= "Service: {$booking->services_label}\n";
                        $message .= "Date: {$date}\n";
                        $message .= "Time: {$time}\n";

                        if ($booking->branch) {
                            $message .= "Branch: " . $booking->branch->name . "\n";
                            if ($booking->branch->address) {
                                $message .= "Location: " . $booking->branch->address . "\n";
                            }
                        } elseif ($booking->business->address) {
                            $message .= "Location: " . $booking->business->address . "\n";
                        }

                        $message .= "\nWe look forward to seeing you! 😊\n";
                        $message .= "Reply here if you need to reschedule or have any questions.";

                        $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . urlencode($message);
                    ?>
                    <button type="button" onclick="sendReminder(<?php echo e($booking->id); ?>)"
                        class="inline-flex px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        <span>Send Reminder</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Booking Timeline -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Booking Timeline
            </h3>
            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-600">Created:</span>
                    <span
                        class="ml-2 font-semibold text-gray-900"><?php echo e($booking->created_at->format('M d, Y h:i A')); ?></span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="text-gray-600">Last Updated:</span>
                    <span
                        class="ml-2 font-semibold text-gray-900"><?php echo e($booking->updated_at->format('M d, Y h:i A')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sendReminder(bookingId) {
            // Open WhatsApp
            const whatsappUrl = '<?php echo e($whatsappUrl); ?>';
            window.open(whatsappUrl, '_blank');

            // Mark reminder as sent via AJAX
            <?php if(auth()->user()->role === 'staff'): ?>
                const url = '<?php echo e(route('admin.staff.bookings.reminder', $booking->id)); ?>';
            <?php else: ?>
                const url = '<?php echo e(route('admin.bookings.reminder', $booking->id)); ?>';
            <?php endif; ?>

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated reminder status
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
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
<?php endif; ?><?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/bookings/show.blade.php ENDPATH**/ ?>