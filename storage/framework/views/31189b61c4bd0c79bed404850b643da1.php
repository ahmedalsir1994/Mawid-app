<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['license', 'plan', 'limitType' => 'feature']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['license', 'plan', 'limitType' => 'feature']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $currentPlan = $license->plan ?? 'free';
    $nextPlan = $currentPlan === 'free' ? 'pro' : 'plus';
    $messages = [
        'services' => [
            'free' => "You've reached the limit of {$license->max_services} services on the Free plan.",
            'pro'  => "You've reached the limit of {$license->max_services} services on the Pro plan.",
        ],
        'staff' => [
            'free' => "You've reached the limit of {$license->max_staff} staff on the Free plan.",
            'pro'  => "You've reached the limit of {$license->max_staff} staff on the Pro plan.",
        ],
    ];
    $msg = $messages[$limitType][$currentPlan] ?? "You've reached your plan limit.";
?>

<div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-6">
    <div class="flex items-start gap-4">
        <div class="text-3xl">🔒</div>
        <div class="flex-1">
            <h3 class="text-lg font-bold text-amber-900">Plan Limit Reached</h3>
            <p class="text-amber-800 mt-1 text-sm"><?php echo e($msg); ?></p>

            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div class="rounded-xl bg-white border border-amber-200 p-3">
                    <p class="text-xs text-gray-400 mb-1">Current Plan</p>
                    <p class="font-bold text-gray-800"><?php echo e(ucfirst($currentPlan)); ?></p>
                    <p class="text-xs text-gray-500 mt-1">
                        <?php echo e($license->max_services); ?> services · <?php echo e($license->max_staff); ?> staff
                    </p>
                </div>
                <div class="rounded-xl bg-gradient-to-br from-green-50 to-blue-50 border border-green-200 p-3">
                    <p class="text-xs text-gray-400 mb-1">Upgrade to</p>
                    <p class="font-bold text-gray-800"><?php echo e(ucfirst($nextPlan)); ?></p>
                    <?php if($nextPlan === 'pro'): ?>
                        <p class="text-xs text-gray-500 mt-1">15 services · 3 staff</p>
                    <?php else: ?>
                        <p class="text-xs text-gray-500 mt-1">Unlimited services · 5 staff/branch</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4 flex gap-3">
                <a href="<?php echo e(route('admin.upgrade.index')); ?>"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition">
                    ✨ View Plans &amp; Upgrade
                </a>
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\booking-app\resources\views\components\upgrade-modal.blade.php ENDPATH**/ ?>