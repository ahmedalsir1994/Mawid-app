@props(['license', 'plan', 'limitType' => 'feature'])

@php
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
@endphp

<div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-6">
    <div class="flex items-start gap-4">
        <div class="text-3xl">🔒</div>
        <div class="flex-1">
            <h3 class="text-lg font-bold text-amber-900">Plan Limit Reached</h3>
            <p class="text-amber-800 mt-1 text-sm">{{ $msg }}</p>

            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div class="rounded-xl bg-white border border-amber-200 p-3">
                    <p class="text-xs text-gray-400 mb-1">Current Plan</p>
                    <p class="font-bold text-gray-800">{{ ucfirst($currentPlan) }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $license->max_services }} services · {{ $license->max_staff }} staff
                    </p>
                </div>
                <div class="rounded-xl bg-gradient-to-br from-green-50 to-blue-50 border border-green-200 p-3">
                    <p class="text-xs text-gray-400 mb-1">Upgrade to</p>
                    <p class="font-bold text-gray-800">{{ ucfirst($nextPlan) }}</p>
                    @if($nextPlan === 'pro')
                        <p class="text-xs text-gray-500 mt-1">15 services · 3 staff</p>
                    @else
                        <p class="text-xs text-gray-500 mt-1">Unlimited services · 5 staff/branch</p>
                    @endif
                </div>
            </div>

            <div class="mt-4 flex gap-3">
                <a href="{{ route('admin.upgrade.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition">
                    ✨ View Plans &amp; Upgrade
                </a>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
