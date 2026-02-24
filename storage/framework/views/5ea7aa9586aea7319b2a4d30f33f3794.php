<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($business->name); ?> - Book Your Appointment</title>
    
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        .slot-btn.selected {
            @apply bg-gradient-to-r from-purple-600 to-pink-600 text-white border-purple-600;
        }
        
        [dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Language Switcher -->
    <div class="fixed top-4 <?php echo e(app()->getLocale() === 'ar' ? 'left-4' : 'right-4'); ?> z-50">
        <div class="flex gap-2 bg-white rounded-lg shadow-lg border border-gray-200 p-2">
            <a href="<?php echo e(route('lang.switch', 'en')); ?>"
                class="px-3 py-1.5 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'en' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                EN
            </a>
            <a href="<?php echo e(route('lang.switch', 'ar')); ?>"
                class="px-3 py-1.5 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'ar' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                AR
            </a>
        </div>
    </div>
    
    <div class="min-h-screen flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-2xl">
            <!-- Header -->
            <div class="mb-8 text-center">
                <?php if($business->logo): ?>
                    <div class="flex justify-center mb-4">
                        <img src="<?php echo e(asset($business->logo)); ?>" alt="<?php echo e($business->name); ?>"
                            class="h-20 w-auto rounded-lg shadow-md">
                    </div>
                <?php endif; ?>
                <h1
                    class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                    <?php echo e($business->name); ?>

                </h1>
                <?php if($business->address): ?>
                    <p class="text-gray-600 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <?php echo e($business->address); ?>

                    </p>
                <?php endif; ?>
            </div>

            <!-- Booking Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                <!-- Error Messages -->
                <?php if($errors->any()): ?>
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-red-800 mb-1"><?php echo e(__('app.error')); ?></h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="space-y-6">
                    <!-- Service Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <svg class="w-5 h-5 inline mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <?php echo e(__('app.select_service')); ?>

                        </label>

                        <!-- Service Cards with Images -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="service-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-purple-500 transition"
                                    data-service-id="<?php echo e($s->id); ?>" data-duration="<?php echo e($s->duration_minutes); ?>">
                                    <?php if($s->image): ?>
                                        <img src="<?php echo e(asset($s->image)); ?>" alt="<?php echo e($s->name); ?>"
                                            class="w-full h-32 object-cover rounded-lg mb-3">
                                    <?php else: ?>
                                        <div
                                            class="w-full h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg mb-3 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="font-bold text-gray-800"><?php echo e($s->name); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo e($s->duration_minutes); ?> <?php echo e(__('app.minutes')); ?></p>
                                    <?php if($s->description): ?>
                                        <p class="text-xs text-gray-500 mt-2"><?php echo e(Str::limit($s->description, 80)); ?></p>
                                    <?php endif; ?>
                                    <?php if($s->price): ?>
                                        <p class="text-sm font-semibold text-purple-600 mt-2"><?php echo e(number_format($s->price, 2)); ?>

                                            <?php echo e($business->currency); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <select id="service" class="hidden">
                            <option value=""><?php echo e(__('app.choose_a_service')); ?></option>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>" data-duration="<?php echo e($s->duration_minutes); ?>">
                                    <?php echo e($s->name); ?> - <?php echo e($s->duration_minutes); ?> <?php echo e(__('app.minutes')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Staff Selection (Optional Filter) -->
                    <div id="staffSection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <svg class="w-5 h-5 inline mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <?php echo e(__('app.select_staff_optional')); ?>

                        </label>
                        <div id="staffFilter" class="flex flex-wrap gap-2 mb-2">
                            <button type="button" data-staff-id="all"
                                class="staff-filter-btn px-4 py-2 rounded-lg border-2 border-purple-500 bg-purple-50 text-purple-700 font-medium transition">
                                <?php echo e(__('app.all_staff')); ?>

                            </button>
                        </div>
                        <p class="text-xs text-gray-500"><?php echo e(__('app.filter_slots_by_staff')); ?></p>
                    </div>

                    <!-- Date Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <svg class="w-5 h-5 inline mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <?php echo e(__('app.select_date')); ?>

                        </label>
                        <input type="date" id="date"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" />
                    </div>

                    <!-- Time Slots -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <svg class="w-5 h-5 inline mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <?php echo e(__('app.available_times')); ?>

                        </label>
                        <div id="slots" class="grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                        <p id="noSlots" class="text-center text-gray-600 mt-4 hidden">
                            <svg class="w-6 h-6 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <?php echo e(__('app.no_available_slots')); ?>

                        </p>
                    </div>

                    <!-- Booking Form (Hidden until slot selected) -->
                    <form id="bookingForm" method="POST" action="<?php echo e(route('public.book', $business->slug)); ?>"
                        class="space-y-6 hidden border-t pt-6">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="service_id" id="service_id">
                        <input type="hidden" name="staff_user_id" id="staff_user_id">
                        <input type="hidden" name="date" id="date_value">
                        <input type="hidden" name="start_time" id="start_time">

                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <p class="text-sm text-purple-900">
                                <strong id="confirmService"></strong><br>
                                <strong id="confirmStaff" class="text-purple-700"></strong><br>
                                <strong id="confirmDateTime"></strong>
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.full_name')); ?>

                                    *</label>
                                <input type="text" name="customer_name" value="<?php echo e(old('customer_name')); ?>"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                    placeholder="<?php echo e(__('app.full_name')); ?>" required />
                            </div>

                            <!-- Country -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.country')); ?>

                                    *</label>
                                <select name="customer_country"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                    required>
                                    <option value=""><?php echo e(__('app.select_a_country')); ?></option>
                                    <option value="OM" <?php echo e(old('customer_country') == 'OM' ? 'selected' : ''); ?>>Oman
                                    </option>
                                    <option value="SA" <?php echo e(old('customer_country') == 'SA' ? 'selected' : ''); ?>>Saudi
                                        Arabia</option>
                                    <option value="AE" <?php echo e(old('customer_country') == 'AE' ? 'selected' : ''); ?>>United Arab
                                        Emirates</option>
                                    <option value="KW" <?php echo e(old('customer_country') == 'KW' ? 'selected' : ''); ?>>Kuwait
                                    </option>
                                    <option value="QA" <?php echo e(old('customer_country') == 'QA' ? 'selected' : ''); ?>>Qatar
                                    </option>
                                    <option value="BH" <?php echo e(old('customer_country') == 'BH' ? 'selected' : ''); ?>>Bahrain
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19.114 5.636l4.736-4.737L21.05.052 16.314 4.79c-1.036-.935-2.722-1.85-4.597-1.85-4.566 0-8.281 3.715-8.281 8.281s3.715 8.281 8.281 8.281c4.566 0 8.281-3.715 8.281-8.281 0-1.875-.915-3.561-1.85-4.597l4.737-4.736-1.847 1.847zm-4.313 12.195c-3.516 0-6.376-2.86-6.376-6.376s2.86-6.376 6.376-6.376 6.376 2.86 6.376 6.376-2.86 6.376-6.376 6.376z" />
                                </svg>
                                <?php echo e(__('app.phone_whatsapp')); ?> *
                            </label>
                            <div class="flex gap-2">
                                <select name="customer_country_code"
                                    class="px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition bg-white min-w-fit">
                                    <option value="+968" <?php echo e(old('customer_country_code', '+968') == '+968' ? 'selected' : ''); ?>>🇴🇲 +968</option>
                                    <option value="+966" <?php echo e(old('customer_country_code') == '+966' ? 'selected' : ''); ?>>
                                        🇸🇦 +966</option>
                                    <option value="+971" <?php echo e(old('customer_country_code') == '+971' ? 'selected' : ''); ?>>
                                        🇦🇪 +971</option>
                                    <option value="+965" <?php echo e(old('customer_country_code') == '+965' ? 'selected' : ''); ?>>
                                        🇰🇼 +965</option>
                                    <option value="+974" <?php echo e(old('customer_country_code') == '+974' ? 'selected' : ''); ?>>
                                        🇶🇦 +974</option>
                                    <option value="+973" <?php echo e(old('customer_country_code') == '+973' ? 'selected' : ''); ?>>
                                        🇧🇭 +973</option>
                                </select>
                                <input type="tel" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>"
                                    class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                    placeholder="9xxxxxxxx" required />
                            </div>
                        </div>

                        <!-- Notes (Optional) -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.notes_optional')); ?></label>
                            <textarea name="customer_notes" rows="3"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                placeholder="<?php echo e(__('app.special_requests')); ?>"><?php echo e(old('customer_notes')); ?></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <?php echo e(__('app.confirm_booking')); ?>

                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Footer -->
            <div class="mt-8 text-center text-gray-600 text-sm">
                <p>✓ <?php echo e(__('app.secure_booking')); ?> • ✓ <?php echo e(__('app.instant_confirmation')); ?> • ✓
                    <?php echo e(__('app.whatsapp_reminder')); ?></p>
            </div>
        </div>
    </div>

    <script>
        const businessSlug = <?php echo json_encode($business->slug, 15, 512) ?>;
        const serviceSelect = document.getElementById('service');
        const dateInput = document.getElementById('date');
        const staffSection = document.getElementById('staffSection');
        const staffFilter = document.getElementById('staffFilter');
        const slotsDiv = document.getElementById('slots');
        const noSlots = document.getElementById('noSlots');
        const bookingForm = document.getElementById('bookingForm');
        const serviceIdInput = document.getElementById('service_id');
        const staffUserIdInput = document.getElementById('staff_user_id');
        const dateValueInput = document.getElementById('date_value');
        const startTimeInput = document.getElementById('start_time');

        let allStaff = [];
        let currentSlots = [];
        let selectedStaffFilter = 'all';

        // Set minimum date to today
        dateInput.min = new Date().toISOString().split('T')[0];

        // Restore form state if there were validation errors
        <?php if(old('service_id') && old('date')): ?>
            const oldServiceId = <?php echo json_encode(old('service_id'), 15, 512) ?>;
            const oldDate = <?php echo json_encode(old('date'), 15, 512) ?>;

            const serviceCard = document.querySelector(`.service-card[data-service-id="${oldServiceId}"]`);
            if (serviceCard) {
                serviceCard.click();
            }

            dateInput.value = oldDate;

            setTimeout(() => {
                if (dateInput.value) {
                    loadSlots();
                }
            }, 100);
        <?php endif; ?>

        // Handle service card selection
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function () {
                document.querySelectorAll('.service-card').forEach(c => {
                    c.classList.remove('border-purple-500', 'bg-purple-50');
                    c.classList.add('border-gray-200');
                });

                this.classList.remove('border-gray-200');
                this.classList.add('border-purple-500', 'bg-purple-50');

                const serviceId = this.dataset.serviceId;
                serviceSelect.value = serviceId;

                if (dateInput.value) {
                    loadSlots();
                }
            });
        });

        function clearSlots() {
            slotsDiv.innerHTML = '';
            bookingForm.classList.add('hidden');
            noSlots.classList.add('hidden');
        }

        function renderStaffFilter() {
            const filterContainer = document.getElementById('staffFilter');
            filterContainer.innerHTML = `
                <button type="button" data-staff-id="all"
                    class="staff-filter-btn px-4 py-2 rounded-lg border-2 ${selectedStaffFilter === 'all' ? 'border-purple-500 bg-purple-50 text-purple-700' : 'border-gray-300 bg-white text-gray-700'} font-medium transition hover:border-purple-400">
                    All Staff (${currentSlots.length} slots)
                </button>
            `;

            allStaff.forEach(staff => {
                const staffSlots = currentSlots.filter(slot =>
                    slot.available_staff && slot.available_staff.some(s => s.id === staff.id)
                );
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.dataset.staffId = staff.id;
                btn.className = `staff-filter-btn px-4 py-2 rounded-lg border-2 ${selectedStaffFilter === staff.id ? 'border-purple-500 bg-purple-50 text-purple-700' : 'border-gray-300 bg-white text-gray-700'} font-medium transition hover:border-purple-400`;
                btn.innerHTML = `
                    <span class="inline-flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center mr-2">
                            ${staff.name.charAt(0)}
                        </span>
                        ${staff.name} (${staffSlots.length})
                    </span>
                `;
                btn.onclick = () => {
                    selectedStaffFilter = staff.id;
                    renderStaffFilter();
                    renderSlots();
                };
                filterContainer.appendChild(btn);
            });

            // All staff button click handler
            const allBtn = filterContainer.querySelector('[data-staff-id="all"]');
            allBtn.onclick = () => {
                selectedStaffFilter = 'all';
                renderStaffFilter();
                renderSlots();
            };
        }

        function renderSlots() {
            clearSlots();

            let filteredSlots = currentSlots;
            if (selectedStaffFilter !== 'all') {
                filteredSlots = currentSlots.filter(slot =>
                    slot.available_staff && slot.available_staff.some(s => s.id === parseInt(selectedStaffFilter))
                );
            }

            if (filteredSlots.length === 0) {
                noSlots.classList.remove('hidden');
                return;
            }

            filteredSlots.forEach(s => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'slot-btn px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-800 font-medium hover:border-purple-400 hover:bg-purple-50 transition relative';

                // Show staff count badge
                btn.innerHTML = `
                    <span>${s.label}</span>
                    ${selectedStaffFilter === 'all' && s.available_staff ? `<span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ${s.available_staff.length} staff
                    </span>` : ''}
                `;

                btn.onclick = (e) => {
                    e.preventDefault();
                    selectSlot(s);
                };
                slotsDiv.appendChild(btn);
            });
        }

        function selectSlot(slot) {
            // Remove previous selection
            document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
            event.target.closest('.slot-btn').classList.add('selected');

            // Determine which staff to assign
            let assignedStaff;
            if (!slot.available_staff || slot.available_staff.length === 0) {
                alert('No staff available for this slot. Please select another time.');
                return;
            }

            if (selectedStaffFilter !== 'all') {
                assignedStaff = slot.available_staff.find(s => s.id === parseInt(selectedStaffFilter));
            } else {
                assignedStaff = slot.available_staff[0]; // First available
            }

            if (!assignedStaff) {
                alert('Selected staff is not available for this slot. Please try again.');
                return;
            }

            serviceIdInput.value = serviceSelect.value;
            staffUserIdInput.value = assignedStaff.id;
            dateValueInput.value = dateInput.value;
            startTimeInput.value = slot.start;

            const serviceName = serviceSelect.options[serviceSelect.selectedIndex].text;
            const dateObj = new Date(dateInput.value);
            const dateStr = dateObj.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

            document.getElementById('confirmService').textContent = serviceName;
            document.getElementById('confirmStaff').textContent = `With ${assignedStaff.name}`;
            document.getElementById('confirmDateTime').textContent = `${dateStr} at ${slot.label}`;

            bookingForm.classList.remove('hidden');
            bookingForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        async function loadSlots() {
            clearSlots();
            staffSection.classList.add('hidden');
            const serviceId = serviceSelect.value;
            const date = dateInput.value;

            if (!serviceId || !date) return;

            try {
                const url = `/${businessSlug}/services/${serviceId}/slots?date=${encodeURIComponent(date)}`;
                const res = await fetch(url);
                const data = await res.json();

                if (!data.slots || data.slots.length === 0) {
                    noSlots.classList.remove('hidden');
                    return;
                }

                allStaff = data.staff || [];
                currentSlots = data.slots;
                selectedStaffFilter = 'all';

                // Show staff filter if there are multiple staff
                if (allStaff.length > 1) {
                    staffSection.classList.remove('hidden');
                    renderStaffFilter();
                }

                renderSlots();
            } catch (error) {
                console.error('Error loading slots:', error);
                noSlots.classList.remove('hidden');
            }
        }

        serviceSelect.addEventListener('change', loadSlots);
        dateInput.addEventListener('change', loadSlots);
    </script>
</body>

</html><?php /**PATH C:\laragon\www\booking-app\resources\views/public/business.blade.php ENDPATH**/ ?>