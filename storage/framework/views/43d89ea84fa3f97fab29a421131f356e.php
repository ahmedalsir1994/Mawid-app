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
        <h1 class="text-4xl font-bold text-gray-900"><?php echo e(__('app.create_license')); ?></h1>
        <p class="text-gray-600 mt-2"><?php echo e(__('app.create_new_license')); ?></p>
    </div>

    <!-- Create Form -->
    <div class="max-w-2xl">
        <form method="POST" action="<?php echo e(route('admin.super.licenses.store')); ?>"
            class="bg-white rounded-xl shadow-md border border-gray-100 p-8 space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Business Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.business')); ?> *</label>
                <select lang="en" dir="ltr" name="business_id" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value=""><?php echo e(__('app.select_business')); ?></option>
                    <?php $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($business->id); ?>" <?php if(old('business_id') == $business->id): echo 'selected'; endif; ?>>
                            <?php echo e($business->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['business_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- License Key -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.license_key')); ?> *</label>
                <div class="flex gap-2">
                    <input lang="en" dir="ltr" type="text" name="license_key" required
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="LIC-XXX..." value="<?php echo e(old('license_key')); ?>">
                    <button type="button" onclick="generateKey()"
                        class="px-4 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition">
                        <?php echo e(__('app.generate')); ?>

                    </button>
                </div>
                <?php $__errorArgs = ['license_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Plan Selector -->
            <div class="p-5 bg-gray-50 rounded-xl border border-gray-200">
                <p class="text-sm font-semibold text-gray-700 mb-3">Plan &amp; Billing</p>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="plan-card relative cursor-pointer">
                            <input type="radio" name="plan" value="<?php echo e($key); ?>" class="sr-only peer"
                                <?php if(old('plan', 'free') === $key): echo 'checked'; endif; ?>
                                onchange="applyPlan('<?php echo e($key); ?>')">
                            <div class="peer-checked:border-green-500 peer-checked:bg-green-50 border-2 border-gray-200 rounded-xl p-3 text-center transition hover:border-green-300">
                                <div class="text-2xl mb-1"><?php echo e($p['emoji']); ?></div>
                                <div class="font-bold text-sm text-gray-800"><?php echo e($p['name']); ?></div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    <?php if($p['price_monthly'] === 0): ?> Free
                                    <?php else: ?> <?php echo e($p['price_monthly']); ?> OMR/mo
                                    <?php endif; ?>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Billing Cycle -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Billing Cycle</label>
                    <select lang="en" dir="ltr" name="billing_cycle" id="billing_cycle"
                        onchange="updateExpiry()"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="monthly" <?php if(old('billing_cycle', 'monthly') === 'monthly'): echo 'selected'; endif; ?>>Monthly</option>
                        <option value="yearly" <?php if(old('billing_cycle', 'yearly') === 'yearly'): echo 'selected'; endif; ?>>Yearly (5% off)</option>
                    </select>
                </div>
            </div>

            <!-- Plan Limits (auto-filled, editable override) -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Plan Limits <span class="text-gray-400 font-normal">(auto-filled from plan, editable)</span></p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Branches</label>
                        <input lang="en" dir="ltr" type="number" name="max_branches" id="max_branches"
                            required min="1" value="<?php echo e(old('max_branches', 1)); ?>"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        <?php $__errorArgs = ['max_branches'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Staff</label>
                        <input lang="en" dir="ltr" type="number" name="max_staff" id="max_staff"
                            required min="1" value="<?php echo e(old('max_staff', 1)); ?>"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        <?php $__errorArgs = ['max_staff'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Services <span class="text-gray-400">(0=8)</span></label>
                        <input lang="en" dir="ltr" type="number" name="max_services" id="max_services"
                            required min="0" value="<?php echo e(old('max_services', 3)); ?>"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        <?php $__errorArgs = ['max_services'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <!-- WhatsApp Reminders -->
                <div class="mt-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input lang="en" dir="ltr" type="checkbox" name="whatsapp_reminders" id="whatsapp_reminders"
                            value="1" <?php if(old('whatsapp_reminders')): echo 'checked'; endif; ?>
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="text-sm text-gray-700">WhatsApp Reminders enabled</span>
                    </label>
                </div>
            </div>

            <!-- Status & Payment -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.status')); ?> *</label>
                    <select lang="en" dir="ltr" name="status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="active" <?php if(old('status', 'active') === 'active'): echo 'selected'; endif; ?>><?php echo e(__('app.active')); ?></option>
                        <option value="expired" <?php if(old('status') === 'expired'): echo 'selected'; endif; ?>><?php echo e(__('app.expired')); ?></option>
                        <option value="cancelled" <?php if(old('status') === 'cancelled'): echo 'selected'; endif; ?>><?php echo e(__('app.cancelled')); ?></option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.payment_status')); ?> *</label>
                    <select lang="en" dir="ltr" name="payment_status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="paid" <?php if(old('payment_status', 'paid') === 'paid'): echo 'selected'; endif; ?>><?php echo e(__('app.paid')); ?></option>
                        <option value="unpaid" <?php if(old('payment_status') === 'unpaid'): echo 'selected'; endif; ?>><?php echo e(__('app.unpaid')); ?></option>
                    </select>
                    <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Price & Expiry -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (OMR) *</label>
                    <input lang="en" dir="ltr" type="number" name="price" id="price"
                        required min="0" step="0.01"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="0.00" value="<?php echo e(old('price', 0)); ?>">
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Expiry Date <span class="text-gray-400 font-normal">(leave blank = auto)</span>
                    </label>
                    <input lang="en" dir="ltr" type="date" name="expires_at" id="expires_at"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        value="<?php echo e(old('expires_at')); ?>">
                    <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.notes')); ?></label>
                <textarea lang="en" dir="ltr" name="notes" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                    placeholder="<?php echo e(__('app.add_notes_license')); ?>"><?php echo e(old('notes')); ?></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:shadow-lg transition">
                    <?php echo e(__('app.create_license')); ?>

                </button>
                <a href="<?php echo e(route('admin.super.licenses.index')); ?>"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                    <?php echo e(__('app.cancel')); ?>

                </a>
            </div>
        </form>
    </div>

    <?php
    $planData = collect($plans)->map(fn($p, $k) => [
        'max_branches'       => $p['max_branches'],
        'max_staff'          => $p['max_staff'],
        'max_services'       => $p['max_services'],
        'whatsapp_reminders' => $p['whatsapp_reminders'],
        'price_monthly'      => $p['price_monthly'],
        'price_yearly'       => $p['price_yearly'] ?? $p['price_monthly'],
    ])->toJson()
    ?>

    <script>
        const PLANS = <?php echo json_encode(json_decode($planData), 15, 512) ?>;

        function applyPlan(planKey) {
            const p = PLANS[planKey];
            if (!p) return;
            document.getElementById('max_branches').value       = p.max_branches;
            document.getElementById('max_staff').value          = p.max_staff;
            document.getElementById('max_services').value       = p.max_services;
            document.getElementById('whatsapp_reminders').checked = p.whatsapp_reminders;
            updatePrice(planKey);
            updateExpiry(planKey);
        }

        function updatePrice(planKey) {
            planKey = planKey || document.querySelector('input[name="plan"]:checked')?.value;
            const cycle = document.getElementById('billing_cycle').value;
            const p = PLANS[planKey];
            if (!p) return;
            document.getElementById('price').value = cycle === 'yearly' ? p.price_yearly : p.price_monthly;
        }

        function updateExpiry(planKey) {
            planKey = planKey || document.querySelector('input[name="plan"]:checked')?.value;
            const cycle = document.getElementById('billing_cycle').value;
            const d = new Date();
            if (planKey === 'free') {
                d.setFullYear(d.getFullYear() + 100);
            } else if (cycle === 'yearly') {
                d.setFullYear(d.getFullYear() + 1);
            } else {
                d.setMonth(d.getMonth() + 1);
            }
            document.getElementById('expires_at').value = d.toISOString().split('T')[0];
            updatePrice(planKey);
        }

        function generateKey() {
            const key = 'LIC-' + Math.random().toString(36).substring(2, 22).toUpperCase();
            document.querySelector('input[name="license_key"]').value = key;
        }

        // Init on load
        document.addEventListener('DOMContentLoaded', () => {
            const checked = document.querySelector('input[name="plan"]:checked');
            if (checked) applyPlan(checked.value);
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/super/licenses/create.blade.php ENDPATH**/ ?>