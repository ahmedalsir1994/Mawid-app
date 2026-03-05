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
                <h2 class="font-bold text-3xl text-gray-800">New Walk-In Booking</h2>
                <p class="text-gray-500 text-sm mt-1">Manually create a booking for a walk-in customer</p>
            </div>
            <a href="<?php echo e(route($indexRoute)); ?>"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                ← Back to Bookings
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if($errors->any()): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <p class="font-semibold mb-1">Please fix the following:</p>
            <ul class="list-disc list-inside space-y-0.5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST"
          action="<?php echo e(auth()->user()->role === 'staff' ? route('admin.staff.bookings.manual.store') : route('admin.bookings.manual.store')); ?>"
          id="walkInForm">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            
            <div class="space-y-5">

                
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-xs">1</span>
                        Appointment Details
                    </h3>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Service <span class="text-red-500">*</span></label>
                        <select name="service_id" id="serviceSelect" required
                                class="w-full px-4 py-2.5 rounded-xl border <?php echo e($errors->has('service_id') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">— Select a service —</option>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($svc->id); ?>"
                                        data-duration="<?php echo e($svc->duration_minutes); ?>"
                                        data-price="<?php echo e($svc->price); ?>"
                                        <?php echo e(old('service_id') == $svc->id ? 'selected' : ''); ?>>
                                    <?php echo e($svc->name); ?> · <?php echo e($svc->duration_minutes); ?> min
                                    <?php if($svc->price > 0): ?> · <?php echo e(number_format($svc->price, 3)); ?> OMR <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <?php if($branches->isNotEmpty()): ?>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Branch <span class="text-xs font-normal text-gray-400">(optional)</span></label>
                        <select name="branch_id" id="branchSelect"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">— Any branch —</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $br): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($br->id); ?>" <?php echo e(old('branch_id') == $br->id ? 'selected' : ''); ?>>
                                    <?php echo e($br->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php else: ?>
                        <input type="hidden" name="branch_id" value="">
                    <?php endif; ?>

                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="dateInput" required
                               value="<?php echo e(old('date', now()->toDateString())); ?>"
                               class="w-full px-4 py-2.5 rounded-xl border <?php echo e($errors->has('date') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    
                    <button type="button" id="loadSlotsBtn"
                            class="mt-4 w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Check Available Slots
                    </button>
                </div>

                
                <div id="slotsSection" class="hidden bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-xs">2</span>
                        Available Time Slots
                        <span id="slotDateLabel" class="text-sm font-normal text-gray-500 ms-1"></span>
                    </h3>

                    <div id="slotsLoading" class="hidden text-center py-8 text-gray-400 text-sm">
                        <svg class="w-6 h-6 mx-auto mb-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Loading slots...
                    </div>

                    <div id="slotsEmpty" class="hidden text-center py-8 text-gray-400 text-sm">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p id="slotsEmptyMsg">No available slots for this date.</p>
                    </div>

                    <div id="slotsGrid" class="grid grid-cols-3 sm:grid-cols-4 gap-2"></div>

                    
                    <div id="selectedSlotSummary" class="hidden mt-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-800 font-medium"></div>
                </div>

                
                <div id="staffSection" class="hidden bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-xs">3</span>
                        Assign Staff Member
                    </h3>
                    <div id="staffGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
                    <input type="hidden" name="staff_user_id" id="staffInput" value="<?php echo e(old('staff_user_id')); ?>">
                    <?php if($errors->has('staff_user_id')): ?>
                        <p class="text-xs text-red-500 mt-2"><?php echo e($errors->first('staff_user_id')); ?></p>
                    <?php endif; ?>
                </div>

            </div>

            
            <div class="space-y-5">
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-xs">4</span>
                        Customer Information
                    </h3>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" required
                               value="<?php echo e(old('customer_name')); ?>"
                               placeholder="e.g. Ahmed Al-Rashdi"
                               class="w-full px-4 py-2.5 rounded-xl border <?php echo e($errors->has('customer_name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="customer_phone" required
                               value="<?php echo e(old('customer_phone')); ?>"
                               placeholder="e.g. 9123 4567"
                               class="w-full px-4 py-2.5 rounded-xl border <?php echo e($errors->has('customer_phone') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Email Address
                            <span class="text-xs font-normal text-gray-400">(optional — confirmation email will be sent if provided)</span>
                        </label>
                        <input type="email" name="customer_email"
                               value="<?php echo e(old('customer_email')); ?>"
                               placeholder="customer@email.com"
                               class="w-full px-4 py-2.5 rounded-xl border <?php echo e($errors->has('customer_email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Notes
                            <span class="text-xs font-normal text-gray-400">(optional)</span>
                        </label>
                        <textarea name="customer_notes" rows="3"
                                  placeholder="Any special requests or notes..."
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"><?php echo e(old('customer_notes')); ?></textarea>
                    </div>
                </div>

                
                <input type="hidden" name="start_time" id="startTimeInput" value="<?php echo e(old('start_time')); ?>">

                
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div id="bookingSummaryBox" class="hidden mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200 text-sm text-gray-700 space-y-1">
                        <p class="font-semibold text-gray-900 mb-2">Booking Summary</p>
                        <p><span class="text-gray-500">Date:</span> <span id="summaryDate"></span></p>
                        <p><span class="text-gray-500">Time:</span> <span id="summaryTime"></span></p>
                        <p><span class="text-gray-500">Service:</span> <span id="summaryService"></span></p>
                        <p><span class="text-gray-500">Staff:</span> <span id="summaryStaff"></span></p>
                    </div>

                    <button type="submit" id="submitBtn" disabled
                            class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Confirm Walk-In Booking
                    </button>
                    <p id="submitHint" class="text-xs text-gray-400 mt-2 text-center">Select a time slot and staff member to continue</p>
                </div>
            </div>
        </div>
    </form>

    <script>
    (function () {
        const slotsUrl = '<?php echo e(auth()->user()->role === "staff" ? route("admin.staff.bookings.manual-slots") : route("admin.bookings.manual-slots")); ?>';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        let selectedSlot   = null;
        let selectedStaff  = null;
        let isLoading      = false;      // prevents double-requests
        let abortController = null;      // cancels stale in-flight requests

        const serviceSelect = document.getElementById('serviceSelect');
        const branchSelect  = document.getElementById('branchSelect');
        const dateInput     = document.getElementById('dateInput');
        const loadBtn       = document.getElementById('loadSlotsBtn');

        const slotsSection  = document.getElementById('slotsSection');
        const slotsLoading  = document.getElementById('slotsLoading');
        const slotsEmpty    = document.getElementById('slotsEmpty');
        const slotsEmptyMsg = document.getElementById('slotsEmptyMsg');
        const slotsGrid     = document.getElementById('slotsGrid');
        const slotDateLbl   = document.getElementById('slotDateLabel');
        const selectedSlotSummary = document.getElementById('selectedSlotSummary');

        const staffSection  = document.getElementById('staffSection');
        const staffGrid     = document.getElementById('staffGrid');
        const staffInput    = document.getElementById('staffInput');

        const startTimeInput = document.getElementById('startTimeInput');
        const submitBtn      = document.getElementById('submitBtn');
        const submitHint     = document.getElementById('submitHint');
        const bookingSummaryBox = document.getElementById('bookingSummaryBox');

        // Reset slots when inputs change
        [serviceSelect, dateInput, branchSelect].forEach(el => {
            if (el) el.addEventListener('change', resetSlots);
        });

        loadBtn.addEventListener('click', loadSlots);

        function resetSlots() {
            selectedSlot  = null;
            selectedStaff = null;
            startTimeInput.value = '';
            staffInput.value = '';
            slotsGrid.innerHTML = '';
            staffGrid.innerHTML = '';
            slotsSection.classList.add('hidden');
            staffSection.classList.add('hidden');
            selectedSlotSummary.classList.add('hidden');
            bookingSummaryBox.classList.add('hidden');
            updateSubmit();
        }

        function loadSlots() {
            if (!serviceSelect.value) {
                alert('Please select a service first.');
                return;
            }
            if (!dateInput.value) {
                alert('Please select a date first.');
                return;
            }

            // Abort any in-flight request and guard against double-clicks
            if (abortController) abortController.abort();
            abortController = new AbortController();
            isLoading = true;
            loadBtn.disabled = true;

            resetSlots();
            slotsSection.classList.remove('hidden');
            slotsLoading.classList.remove('hidden');
            slotsEmpty.classList.add('hidden');
            slotsGrid.innerHTML = '';

            const params = new URLSearchParams({
                service_id: serviceSelect.value,
                date: dateInput.value,
                branch_id: branchSelect ? branchSelect.value : '',
            });

            fetch(`${slotsUrl}?${params}`, {
                signal: abortController.signal,
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            })
            .then(r => r.json())
            .then(data => {
                slotsLoading.classList.add('hidden');

                const d = new Date(dateInput.value + 'T00:00:00');
                slotDateLbl.textContent = '— ' + d.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });

                if (!data.slots || data.slots.length === 0) {
                    slotsEmpty.classList.remove('hidden');
                    const msgs = {
                        'time_off':  'This date is marked as time off.',
                        'closed':    'The business is closed on this day.',
                        'no_staff':  'No active staff available for this date.',
                    };
                    slotsEmptyMsg.textContent = msgs[data.reason] || 'No available slots for this date.';
                    return;
                }

                renderSlots(data.slots);
            })
            .catch(err => {
                if (err.name === 'AbortError') return; // request was intentionally cancelled
                slotsLoading.classList.add('hidden');
                slotsEmpty.classList.remove('hidden');
                slotsEmptyMsg.textContent = 'Failed to load slots. Please try again.';
            })
            .finally(() => {
                // Always re-enable button and clear loading flag
                isLoading = false;
                loadBtn.disabled = false;
                slotsLoading.classList.add('hidden'); // safety: ensure spinner is never stuck
            });
        }

        function renderSlots(slots) {
            slotsGrid.innerHTML = '';
            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.dataset.slot = JSON.stringify(slot);

                let btnClass, innerHtml;

                if (slot.is_booked) {
                    // Fully booked — show but disable
                    btn.disabled = true;
                    btnClass = 'border-red-200 bg-red-50 text-red-400 cursor-not-allowed opacity-70';
                    innerHtml = `
                        ${slot.start}
                        <span class="block text-xs font-normal mt-0.5">Booked</span>
                    `;
                } else if (slot.is_past) {
                    btnClass = 'border-orange-200 bg-orange-50 text-orange-700 hover:border-orange-400';
                    innerHtml = `
                        ${slot.start}
                        <span class="block text-xs font-normal opacity-75">past</span>
                        <span class="block text-xs font-normal text-orange-400 mt-0.5">${slot.available_staff.length} staff</span>
                    `;
                } else {
                    btnClass = 'border-gray-200 bg-white text-gray-800 hover:border-green-400 hover:bg-green-50';
                    innerHtml = `
                        ${slot.start}
                        <span class="block text-xs font-normal text-gray-400 mt-0.5">${slot.available_staff.length} staff</span>
                    `;
                }

                btn.className = `slot-btn relative px-3 py-2.5 rounded-xl border text-center text-sm font-semibold transition ${slot.is_booked ? '' : 'cursor-pointer'} ${btnClass}`;
                btn.innerHTML = innerHtml;

                if (!slot.is_booked) {
                    btn.addEventListener('click', () => selectSlot(slot, btn));
                }
                slotsGrid.appendChild(btn);
            });
        }

        function selectSlot(slot, btn) {
            // Clear previous selection
            document.querySelectorAll('.slot-btn').forEach(b => {
                b.classList.remove('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-400');
            });

            btn.classList.add('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-400');

            selectedSlot = slot;
            selectedStaff = null;
            staffInput.value = '';
            startTimeInput.value = slot.start;

            selectedSlotSummary.classList.remove('hidden');
            selectedSlotSummary.textContent = `Selected: ${slot.start} – ${slot.end}`;

            renderStaff(slot.available_staff);
            staffSection.classList.remove('hidden');
            staffSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            updateSubmit();
        }

        function renderStaff(staffList) {
            staffGrid.innerHTML = '';
            staffList.forEach(staff => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.dataset.staffId   = staff.id;
                btn.dataset.staffName = staff.name;

                const initials = staff.name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();

                btn.className = 'staff-btn flex flex-col items-center gap-2 p-3 rounded-xl border border-gray-200 bg-white hover:border-green-400 hover:bg-green-50 transition cursor-pointer text-center';
                btn.innerHTML = `
                    <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        ${staff.photo
                            ? `<img src="${staff.photo}" class="w-10 h-10 rounded-full object-cover" alt="${staff.name}">`
                            : initials}
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800 leading-tight">${staff.name}</p>
                        ${staff.title ? `<p class="text-xs text-gray-400 mt-0.5">${staff.title}</p>` : ''}
                    </div>
                `;
                btn.addEventListener('click', () => selectStaff(staff, btn));
                staffGrid.appendChild(btn);
            });
        }

        function selectStaff(staff, btn) {
            document.querySelectorAll('.staff-btn').forEach(b => {
                b.classList.remove('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-400');
            });
            btn.classList.add('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-400');

            selectedStaff = staff;
            staffInput.value = staff.id;
            updateSubmit();
            updateSummary();
        }

        function updateSubmit() {
            const ready = selectedSlot && selectedStaff && startTimeInput.value && staffInput.value;
            submitBtn.disabled = !ready;
            submitHint.textContent = ready
                ? '✓ Ready to create booking'
                : 'Select a time slot and staff member to continue';
            submitHint.className = ready
                ? 'text-xs text-green-600 mt-2 text-center font-medium'
                : 'text-xs text-gray-400 mt-2 text-center';
        }

        function updateSummary() {
            if (!selectedSlot || !selectedStaff) return;
            const d = new Date(dateInput.value + 'T00:00:00');
            const dateStr = d.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            const svcOpt = serviceSelect.options[serviceSelect.selectedIndex];

            document.getElementById('summaryDate').textContent    = dateStr;
            document.getElementById('summaryTime').textContent    = `${selectedSlot.start} – ${selectedSlot.end}`;
            document.getElementById('summaryService').textContent = svcOpt ? svcOpt.text : '';
            document.getElementById('summaryStaff').textContent   = selectedStaff.name;
            bookingSummaryBox.classList.remove('hidden');
        }

        // If old() values are present (after validation failure), try to restore state
        <?php if(old('start_time') && old('service_id')): ?>
        window.addEventListener('DOMContentLoaded', () => {
            // Trigger slot load to restore available slots after validation failure
            setTimeout(loadSlots, 100);
        });
        <?php endif; ?>
    })();
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\booking-app\resources\views\admin\bookings\create.blade.php ENDPATH**/ ?>