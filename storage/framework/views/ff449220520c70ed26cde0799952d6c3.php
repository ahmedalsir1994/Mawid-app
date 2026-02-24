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
        <div>
            <h2 class="font-bold text-3xl text-gray-800"><?php echo e(__('app.working_hours')); ?></h2>
            <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.set_business_hours')); ?></p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">

            <?php if(session('success')): ?>
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.working_hours.update')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.day')); ?></th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.closed')); ?></th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.start_time')); ?></th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase"><?php echo e(__('app.end_time')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dow => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $row = $hours[$dow]; 
                                    $isClosed = old("hours.$dow.is_closed", $row->is_closed);
                                ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition" id="day-<?php echo e($dow); ?>">
                                    <td class="px-6 py-4 font-semibold text-gray-800"><?php echo e($label); ?></td>

                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="hours[<?php echo e($dow); ?>][is_closed]"
                                            <?php if($isClosed): echo 'checked'; endif; ?>
                                            onchange="toggleTimeInputs(this)"
                                            class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500 cursor-pointer" />
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if($isClosed): ?>
                                            <span class="text-gray-400"><?php echo e(__('app.closed')); ?></span>
                                        <?php else: ?>
                                            <input type="time" name="hours[<?php echo e($dow); ?>][start_time]"
                                                value="<?php echo e(old("hours.$dow.start_time", $row->start_time ?? '')); ?>"
                                                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500" />
                                        <?php endif; ?>
                                        <?php $__errorArgs = ["hours.$dow.start_time"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if($isClosed): ?>
                                            <span class="text-gray-400"><?php echo e(__('app.closed')); ?></span>
                                        <?php else: ?>
                                            <input type="time" name="hours[<?php echo e($dow); ?>][end_time]"
                                                value="<?php echo e(old("hours.$dow.end_time", $row->end_time ?? '')); ?>"
                                                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500" />
                                        <?php endif; ?>
                                        <?php $__errorArgs = ["hours.$dow.end_time"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 pt-6 flex items-center justify-end space-x-4">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" 
                        class="px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition">
                        <?php echo e(__('app.cancel')); ?>

                    </a>
                    <button type="submit" class="px-8 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span><?php echo e(__('app.save_changes')); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleTimeInputs(checkbox) {
            const row = checkbox.closest('tr');
            const startCell = row.querySelectorAll('td')[2];
            const endCell = row.querySelectorAll('td')[3];
            
            if (checkbox.checked) {
                startCell.innerHTML = '<span class="text-gray-400"><?php echo e(__('app.closed')); ?></span>';
                endCell.innerHTML = '<span class="text-gray-400"><?php echo e(__('app.closed')); ?></span>';
            } else {
                const dow = checkbox.name.match(/hours\[(\d+)\]/)[1];
                const startValue = checkbox.dataset.startTime || '';
                const endValue = checkbox.dataset.endTime || '';
                startCell.innerHTML = `<input type="time" name="hours[${dow}][start_time]" value="${startValue}" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500" />`;
                endCell.innerHTML = `<input type="time" name="hours[${dow}][end_time]" value="${endValue}" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500" />`;
            }
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/working-hours/edit.blade.php ENDPATH**/ ?>