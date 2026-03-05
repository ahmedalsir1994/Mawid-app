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
        <h1 class="text-4xl font-bold text-gray-900"><?php echo e(__('app.edit_license')); ?></h1>
        <p class="text-gray-600 mt-2"><?php echo e(__('app.update_license_details')); ?></p>
    </div>

    <!-- Edit Form -->
    <div class="max-w-2xl">
        <form method="POST" action="<?php echo e(route('admin.super.licenses.update', $license)); ?>"
            class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Business Info (Read-only) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.business')); ?></label>
                <p class="text-lg font-semibold text-gray-900"><?php echo e($license->business->name); ?></p>
                <p class="text-sm text-gray-600 mt-1"><?php echo e(__('app.license_id')); ?>: <?php echo e($license->id); ?></p>
            </div>

            <!-- License Key (Read-only) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.license_key')); ?></label>
                <div class="flex items-center gap-2">
                    <input lang="en" dir="ltr" type="text" value="<?php echo e($license->license_key); ?>" disabled
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-900 font-mono">
                    <button type="button" onclick="copyToClipboard('<?php echo e($license->license_key); ?>')"
                        class="px-4 py-3 bg-blue-100 text-blue-700 font-medium rounded-lg hover:bg-blue-200 transition">
                        <?php echo e(__('app.copy')); ?>

                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.status')); ?> *</label>
                    <select lang="en" dir="ltr" name="status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="active" <?php if(old('status', $license->status) === 'active'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.active')); ?></option>
                        <option value="expired" <?php if(old('status', $license->status) === 'expired'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.expired')); ?></option>
                        
                        <option value="cancelled" <?php if(old('status', $license->status) === 'cancelled'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.cancelled')); ?>

                        </option>
                    </select>
                    <?php $__errorArgs = ['status'];
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

                <!-- Payment Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.payment_status')); ?> *</label>
                    <select lang="en" dir="ltr" name="payment_status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="unpaid" <?php if(old('payment_status', $license->payment_status) === 'unpaid'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.unpaid')); ?>

                        </option>
                        <option value="paid" <?php if(old('payment_status', $license->payment_status) === 'paid'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.paid')); ?>

                        </option>
                    </select>
                    <?php $__errorArgs = ['payment_status'];
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
            </div>

            <!-- Plan & Billing Cycle -->
            <div class="mb-6 p-5 bg-gray-50 rounded-xl border border-gray-200">
                <p class="text-sm font-semibold text-gray-700 mb-3">Plan &amp; Billing</p>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="plan" value="<?php echo e($key); ?>" class="sr-only peer"
                                <?php if(old('plan', $license->plan ?? 'free') === $key): echo 'checked'; endif; ?>
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
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Billing Cycle</label>
                    <select lang="en" dir="ltr" name="billing_cycle" id="billing_cycle"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="monthly" <?php if(old('billing_cycle', $license->billing_cycle ?? 'monthly') === 'monthly'): echo 'selected'; endif; ?>>Monthly</option>
                        <option value="yearly" <?php if(old('billing_cycle', $license->billing_cycle ?? 'monthly') === 'yearly'): echo 'selected'; endif; ?>>Yearly (5% off)</option>
                    </select>
                </div>
            </div>

            <!-- Plan Limits -->
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">Plan Limits</p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Branches</label>
                        <input lang="en" dir="ltr" type="number" name="max_branches" id="max_branches"
                            required min="1" value="<?php echo e(old('max_branches', $license->max_branches ?? 1)); ?>"
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
                            required min="1" value="<?php echo e(old('max_staff', $license->max_staff ?? 1)); ?>"
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
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Services <span class="text-gray-400">(0=∞)</span></label>
                        <input lang="en" dir="ltr" type="number" name="max_services" id="max_services"
                            required min="0" value="<?php echo e(old('max_services', $license->max_services ?? 3)); ?>"
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
                <div class="mt-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input lang="en" dir="ltr" type="checkbox" name="whatsapp_reminders" id="whatsapp_reminders"
                            value="1" <?php if(old('whatsapp_reminders', $license->whatsapp_reminders)): echo 'checked'; endif; ?>
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="text-sm text-gray-700">WhatsApp Reminders enabled</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Expires At -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.expiration_date')); ?></label>
                    <input lang="en" dir="ltr" type="date" name="expires_at"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        value="<?php echo e(old('expires_at', $license->expires_at ? $license->expires_at->format('Y-m-d') : '')); ?>">
                    <?php $__errorArgs = ['expires_at'];
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

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (OMR) *</label>
                    <input lang="en" dir="ltr" type="number" name="price" id="price" required min="0" step="0.01"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="0.00" value="<?php echo e(old('price', $license->price)); ?>">
                    <?php $__errorArgs = ['price'];
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
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.notes')); ?></label>
                <textarea lang="en" dir="ltr" name="notes" rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                    placeholder="<?php echo e(__('app.add_notes_license')); ?>"><?php echo e(old('notes', $license->notes)); ?></textarea>
                <?php $__errorArgs = ['notes'];
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

            <!-- License Info -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600"><?php echo e(__('app.activated')); ?></p>
                        <p class="font-semibold text-gray-900"><?php echo e($license->activated_at?->format('M d, Y') ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600"><?php echo e(__('app.expires')); ?></p>
                        <p class="font-semibold text-gray-900"><?php echo e($license->expires_at?->format('M d, Y') ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600"><?php echo e(__('app.days_remaining')); ?></p>
                        <p class="font-semibold text-gray-900"><?php echo e($license->expires_at ? now()->diffInDays($license->expires_at, false) : '—'); ?></p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <?php if(!$license->isActive()): ?>
                    <form method="POST" action="<?php echo e(route('admin.super.licenses.reactivate', $license)); ?>" style="flex: 1;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" onclick="return confirm('<?php echo e(__('app.reactivate_license_confirm')); ?>')"
                            class="w-full px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                            ✓ <?php echo e(__('app.reactivate_license')); ?>

                        </button>
                    </form>
                <?php endif; ?>

                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                    <?php echo e(__('app.save_changes')); ?>

                </button>
                <a href="<?php echo e(route('admin.super.licenses.show', $license)); ?>"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                    <?php echo e(__('app.cancel')); ?>

                </a>
            </div>
        </form>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('<?php echo e(__('app.license_key_copied')); ?>');
            });
        }

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
        const PLANS = <?php echo json_encode(json_decode($planData), 15, 512) ?>;

        function applyPlan(planKey) {
            const p = PLANS[planKey];
            if (!p) return;
            document.getElementById('max_branches').value        = p.max_branches;
            document.getElementById('max_staff').value           = p.max_staff;
            document.getElementById('max_services').value        = p.max_services;
            document.getElementById('whatsapp_reminders').checked = p.whatsapp_reminders;
            const cycle = document.getElementById('billing_cycle').value;
            if (document.getElementById('price')) {
                document.getElementById('price').value = cycle === 'yearly' ? p.price_yearly : p.price_monthly;
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/super/licenses/edit.blade.php ENDPATH**/ ?>