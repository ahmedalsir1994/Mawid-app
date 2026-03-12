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
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-3xl text-gray-800"><?php echo e(__('app.bookings')); ?></h2>
                <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.manage_track_appointments')); ?></p>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <?php
                    $bookingsIndexRoute = auth()->user()->role === 'staff' ? 'admin.staff.bookings.index' : 'admin.bookings.index';
                ?>
                <a href="<?php echo e(route($bookingsIndexRoute, ['filter' => 'today'])); ?>"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($filter === 'today' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <?php echo e(__('app.today')); ?> (<?php echo e($today); ?>)
                </a>
                <a href="<?php echo e(route($bookingsIndexRoute, ['filter' => 'upcoming'])); ?>"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($filter === 'upcoming' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <?php echo e(__('app.upcoming')); ?>

                </a>
                <a href="<?php echo e(route($bookingsIndexRoute, ['filter' => 'all'])); ?>"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($filter === 'all' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                    <?php echo e(__('app.all')); ?>

                </a>
                <?php if(auth()->user()->role === 'company_admin'): ?>
                <a href="<?php echo e(route('admin.bookings.export', ['filter' => $filter])); ?>"
                   class="px-4 py-2 rounded-lg text-sm font-medium bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export CSV
                </a>
                <?php endif; ?>
                <?php $createRoute = auth()->user()->role === 'staff' ? 'admin.staff.bookings.create' : 'admin.bookings.create'; ?>
                <a href="<?php echo e(route($createRoute)); ?>"
                   class="px-4 py-2 rounded-lg text-sm font-medium bg-emerald-600 text-white hover:bg-emerald-700 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Walk-In
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <?php if(session('success')): ?>
            <div class="p-4 m-6 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center space-x-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if($bookings->isEmpty()): ?>
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo e(__('app.no_bookings')); ?></h3>
                <p class="text-gray-600"><?php echo e(__('app.no_bookings_message')); ?></p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.date')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.time')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.service')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.branch')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.customer')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.staff')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.phone')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.status')); ?></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.reminder')); ?></th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase">
                                <?php echo e(__('app.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($b->booking_date); ?></td>
                                <td class="px-6 py-4 text-gray-600"><?php echo e(substr($b->start_time, 0, 5)); ?></td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?php echo e($b->services_label); ?>

                                    <?php if($b->services->count() > 1): ?>
                                        <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-green-100 text-green-700">×<?php echo e($b->services->count()); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($b->branch): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            📍 <?php echo e($b->branch->name); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                                            <span
                                                class="text-green-700 font-bold text-xs"><?php echo e(strtoupper(substr($b->customer_name, 0, 1))); ?></span>
                                        </div>
                                        <span class="font-medium text-gray-800"><?php echo e($b->customer_name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($b->staff): ?>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span
                                                    class="text-blue-700 font-semibold text-xs"><?php echo e(strtoupper(substr($b->staff->name, 0, 1))); ?></span>
                                            </div>
                                            <span class="text-sm text-gray-700"><?php echo e($b->staff->name); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400 italic"><?php echo e(__('app.not_assigned')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?php echo e($b->customer_phone); ?></td>

                                <td class="px-6 py-4">
                                    <?php
                                        $statusRoute = auth()->user()->role === 'staff' ? 'admin.staff.bookings.status' : 'admin.bookings.status';
                                    ?>
                                    <form method="POST" action="<?php echo e(route($statusRoute, $b)); ?>" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <select lang="en" dir="ltr" name="status"
                                            class="px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-purple-500"
                                            onchange="this.form.submit()">
                                            <?php $__currentLoopData = ['pending' => __('app.pending'), 'confirmed' => __('app.confirmed'), 'cancelled' => __('app.cancelled'), 'completed' => __('app.completed')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($st); ?>" <?php if($b->status === $st): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </form>
                                </td>

                                <td class="px-6 py-4" id="reminder-status-<?php echo e($b->id); ?>">
                                    <?php if($b->reminder_sent_at): ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?php echo e(__('app.sent')); ?> <?php echo e($b->reminder_sent_at->diffForHumans()); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-xs"><?php echo e(__('app.not_sent')); ?></span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <?php
                                        $showRoute = auth()->user()->role === 'staff' ? 'admin.staff.bookings.show' : 'admin.bookings.show';
                                    ?>
                                    <a href="<?php echo e(route($showRoute, $b)); ?>"
                                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition mr-2"
                                       title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <?php echo e(__('app.view_details')); ?>

                                    </a>
                                    <?php
                                        // Clean and format phone number
                                        $phone = preg_replace('/[^0-9+]/', '', $b->customer_phone);
                                        $phone = ltrim($phone, '+');

                                        // Add country code if not present
                                        if (!preg_match('/^(968|966|971|965|973|974)/', $phone)) {
                                            $phone = '968' . $phone;
                                        }

                                        // Format date and create message
                                        $date = \Carbon\Carbon::parse($b->booking_date)->format('l, F j, Y');
                                        $time = substr($b->start_time, 0, 5);

                                        $message = "Hello {$b->customer_name}! 👋\n\n";
                                        $message .= "This is a reminder from *" . auth()->user()->business->name . "*\n\n";
                                        $message .= "📅 *Appointment Details:*\n";
                                        $message .= "Service: {$b->services_label}\n";
                                        $message .= "Date: {$date}\n";
                                        $message .= "Time: {$time}\n";

                                        if ($b->branch) {
                                            $message .= "Branch: " . $b->branch->name . "\n";
                                            if ($b->branch->address) {
                                                $message .= "Location: " . $b->branch->address . "\n";
                                            }
                                        } elseif (auth()->user()->business->address) {
                                            $message .= "Location: " . auth()->user()->business->address . "\n";
                                        }

                                        $message .= "\nWe look forward to seeing you! 😊\n";
                                        $message .= "Reply here if you need to reschedule or have any questions.";

                                        $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . urlencode($message);
                                        $reminderRoute = auth()->user()->role === 'staff' ? route('admin.staff.bookings.reminder', $b) : route('admin.bookings.reminder', $b);
                                    ?>
                                    <button type="button"
                                        onclick="sendReminder('<?php echo e($whatsappUrl); ?>', '<?php echo e($reminderRoute); ?>', <?php echo e($b->id); ?>)"
                                        id="reminder-btn-<?php echo e($b->id); ?>"
                                        class="inline-flex px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition items-center space-x-2"
                                        title="Send reminder via WhatsApp">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                        </svg>
                                        <span><?php echo e(__('app.send_reminder')); ?></span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($bookings->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <?php echo e($bookings->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    <script>
        function sendReminder(whatsappUrl, reminderRoute, bookingId) {
            // Open WhatsApp
            window.open(whatsappUrl, '_blank');

            // Mark reminder as sent
            fetch(reminderRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the reminder status display
                        const statusCell = document.getElementById('reminder-status-' + bookingId);
                        if (statusCell) {
                            statusCell.innerHTML = `
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Sent ${data.sent_at}
                            </span>
                        `;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking reminder as sent:', error);
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
<?php endif; ?><?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>