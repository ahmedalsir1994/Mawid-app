<x-admin-layout>

    {{-- ── Page Header ────────────────────────────────────────────────────── --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Billing & Subscription</h1>
        <p class="text-gray-500 mt-1 text-sm">Manage your plan, payment method, and billing history.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            <svg class="w-4 h-4 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
            <svg class="w-4 h-4 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Past Due Urgent Banner ───────────────────────────────────────────── --}}
    @if($license && $license->isPastDue())
        @php $graceDays = $license->graceDaysRemaining(); @endphp
        <div class="mb-6 rounded-xl border border-red-300 bg-red-50 p-4">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-red-800">Your payment could not be processed.</p>
                    <p class="text-sm text-red-700 mt-0.5">
                        Please update your payment method to keep your subscription active.
                        @if($graceDays > 0)
                            Your account will be restricted in <strong>{{ $graceDays }} day(s)</strong>
                            @if($license->grace_period_ends_at)
                                ({{ $license->grace_period_ends_at->format('d M Y') }}).
                            @endif
                        @else
                            Your grace period has ended.
                        @endif
                    </p>
                    <div class="mt-3 flex gap-2 flex-wrap">
                        <button type="button" onclick="document.getElementById('update-card-modal').classList.remove('hidden')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition">
                            Update Payment Method
                        </button>
                        @if($paymentMethod)
                            <form method="POST" action="{{ route('admin.billing.retry-payment') }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-red-700 border border-red-300 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                                    ↺ Retry Payment Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Card-updated → prompt retry ────────────────────────────────────── --}}
    @if(session('card_updated_retry') && $license && $license->isPastDue())
        <div class="mb-6 rounded-xl border border-blue-300 bg-blue-50 p-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium text-blue-800">Card saved! Complete your payment to restore your subscription.</p>
            </div>
            <form method="POST" action="{{ route('admin.billing.retry-payment') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
                    Pay Now →
                </button>
            </form>
        </div>
    @endif

    {{-- ── Pending Payment Banner ──────────────────────────────────────────── --}}
    @php $pendingPaymentPlan = auth()->user()->pending_plan; @endphp
    @if($pendingPaymentPlan && $license && $license->isFree())
        @php $pendingPaymentCycle = auth()->user()->pending_cycle ?? 'monthly'; @endphp
        <div class="mb-6 rounded-2xl border border-amber-300 bg-gradient-to-r from-amber-50 to-orange-50 p-5 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <p class="text-sm font-bold text-amber-900">Subscription: Pending</p>
                        <span class="px-2 py-0.5 bg-amber-200 text-amber-800 text-xs font-bold rounded-full">
                            {{ ucfirst($pendingPaymentPlan) }} Plan
                        </span>
                    </div>
                    <p class="text-xs text-amber-700 mb-3">
                        You selected the <strong>{{ ucfirst($pendingPaymentPlan) }}</strong> plan ({{ ucfirst($pendingPaymentCycle) }}) but haven't completed payment.
                        Complete your subscription to unlock all features.
                    </p>
                    <a href="{{ route('admin.upgrade.autopay', ['plan' => $pendingPaymentPlan, 'cycle' => $pendingPaymentCycle]) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Retry Payment
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Main Grid ───────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- ── Subscription Card ──────────────────────────────────────────── --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-semibold text-gray-900">Current Plan</h2>
                @if($license)
                    @php
                        $statusBadge = match($license->status) {
                            'trial'     => 'bg-cyan-100 text-cyan-800',
                            'active'    => 'bg-green-100 text-green-800',
                            'past_due'  => 'bg-red-100 text-red-700',
                            'expired'   => 'bg-red-100 text-red-800',
                            'cancelled' => 'bg-gray-100 text-gray-600',
                            'suspended' => 'bg-yellow-100 text-yellow-800',
                            default     => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusBadge }}">
                        {{ ucfirst(str_replace('_', ' ', $license->status)) }}
                    </span>
                @endif
            </div>

            @if($license)
                @php
                    $plan      = $license->plan ?? 'free';
                    $planEmoji = match($plan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                    $planBg    = match($plan) { 'pro' => 'bg-blue-50 border-blue-200', 'plus' => 'bg-purple-50 border-purple-200', default => 'bg-gray-50 border-gray-200' };
                    $planText  = match($plan) { 'pro' => 'text-blue-800', 'plus' => 'text-purple-800', default => 'text-gray-700' };
                    $prices    = ['pro' => ['monthly' => 6.500, 'yearly' => 65.000], 'plus' => ['monthly' => 12.500, 'yearly' => 125.000]];
                    $price     = $prices[$plan][$license->billing_cycle ?? 'monthly'] ?? null;
                @endphp

                {{-- Plan strip --}}
                <div class="flex items-center justify-between p-4 rounded-xl border {{ $planBg }} mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl {{ str_replace('border-', 'bg-', explode(' ', $planBg)[1]) ?? 'bg-gray-200' }} flex items-center justify-center text-xl">
                            {{ $planEmoji }}
                        </div>
                        <div>
                            <p class="font-bold {{ $planText }}">{{ ucfirst($plan) }} Plan</p>
                            @if($license->billing_cycle)
                                <p class="text-xs text-gray-500">{{ ucfirst($license->billing_cycle) }} billing</p>
                            @endif
                        </div>
                    </div>
                    @if($price)
                        <div class="text-right">
                            <p class="text-xl font-bold {{ $planText }}">{{ number_format($price, 3) }} OMR</p>
                            <p class="text-xs text-gray-400">/ {{ $license->billing_cycle ?? 'month' }}</p>
                        </div>
                    @endif
                </div>

                {{-- Key metrics grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5 text-sm">
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <p class="text-gray-400 text-xs mb-1 uppercase tracking-wider">Next Billing</p>
                        <p class="font-semibold text-gray-800 text-xs">
                            {{ $license->next_billing_date ? $license->next_billing_date->format('d M Y') : '—' }}
                        </p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <p class="text-gray-400 text-xs mb-1 uppercase tracking-wider">Expires On</p>
                        <p class="font-semibold text-gray-800 text-xs">
                            {{ $license->expires_at ? $license->expires_at->format('d M Y') : '—' }}
                        </p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <p class="text-gray-400 text-xs mb-1 uppercase tracking-wider">Auto-Renewal</p>
                        <p class="font-semibold text-xs text-green-700">
                            ✓ On
                        </p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl overflow-hidden">
                        <p class="text-gray-400 text-xs mb-1 uppercase tracking-wider">License Key</p>
                        <p class="font-mono font-semibold text-gray-700 text-xs truncate">{{ $license->license_key }}</p>
                    </div>
                </div>

                @if($plan === 'free')
                    <a href="{{ route('admin.upgrade.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition">
                        ↑ Upgrade Plan
                    </a>
                @else
                    <div class="flex gap-3 flex-wrap">
                        <a href="{{ route('admin.upgrade.index') }}"
                           class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                            Change Plan
                        </a>
                        <button type="button" onclick="document.getElementById('cancel-sub-modal').classList.remove('hidden')"
                            class="px-4 py-2 text-sm font-medium rounded-xl border border-red-200 text-red-600 bg-white hover:bg-red-50 transition">
                            Cancel Subscription
                        </button>
                    </div>
                @endif
            @else
                <p class="text-gray-500 text-sm mb-4">No active subscription found.</p>
                <a href="{{ route('admin.upgrade.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition">
                    ↑ Get Started
                </a>
            @endif
        </div>

        {{-- ── Payment Method Card ─────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Payment Method</h2>

            @if($paymentMethod)
                @php
                    $brand      = strtolower($paymentMethod->card_brand ?? '');
                    $brandLabel = strtoupper($paymentMethod->card_brand ?? 'CARD');
                    $brandChipBg = match(true) {
                        str_contains($brand, 'visa')   => 'bg-blue-700 text-white',
                        str_contains($brand, 'master') => 'bg-red-600 text-white',
                        str_contains($brand, 'mada')   => 'bg-green-700 text-white',
                        str_contains($brand, 'amex')   => 'bg-gray-700 text-white',
                        default                        => 'bg-gray-800 text-white',
                    };
                @endphp

                {{-- Flat card display --}}
                <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-200 mb-3">
                    <span class="text-xs font-bold px-2 py-1 rounded-md {{ $brandChipBg }} flex-shrink-0">
                        {{ $brandLabel }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">
                            •••• {{ $paymentMethod->last_four }}
                            @if($paymentMethod->cardholder_name)
                                <span class="font-normal text-gray-500">/ {{ $paymentMethod->cardholder_name }}</span>
                            @endif
                        </p>
                        @if($paymentMethod->expiry)
                            <p class="text-xs text-gray-400 mt-0.5">Expires {{ $paymentMethod->expiry }}</p>
                        @endif
                    </div>
                </div>

                {{-- Next charge info --}}
                @if($license && $license->auto_renew && $license->next_billing_date && isset($price))
                    <div class="flex items-center gap-2 px-3 py-2 bg-green-50 border border-green-100 rounded-lg text-xs text-green-700 mb-4">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Next charge <strong class="mx-1">{{ number_format($price, 3) }} OMR</strong> on {{ $license->next_billing_date->format('d M Y') }}
                    </div>
                @endif

                <p class="text-xs text-gray-400 mb-4">We never store your full card number. Used for auto-renewal only.</p>

                <div class="mt-auto flex flex-col gap-2">
                    <button type="button" onclick="document.getElementById('update-card-modal').classList.remove('hidden')"
                        class="w-full px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                        ↻ Update Card
                    </button>
                    <button type="button" onclick="document.getElementById('remove-card-modal').classList.remove('hidden')"
                        class="w-full px-4 py-2.5 border border-red-200 text-red-600 text-sm font-medium rounded-xl hover:bg-red-50 transition">
                        Remove Card
                    </button>
                </div>

            @else
                <div class="flex-1 flex flex-col items-center justify-center py-6 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-700 mb-1">No card saved</p>
                    <p class="text-xs text-gray-400 mb-4">Add a card to enable automatic renewal.</p>

                    @if($license && $license->plan !== 'free' && $license->expires_at)
                        <div class="w-full p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-700 flex items-start gap-2 mb-4 text-left">
                            <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Add a card to enable automatic renewal before {{ $license->expires_at->format('d M Y') }}.
                        </div>
                    @endif
                </div>

                @if($license && in_array($license->plan, ['pro', 'plus']))
                    <button type="button" onclick="document.getElementById('update-card-modal').classList.remove('hidden')"
                        class="w-full mt-auto px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                        + Add Payment Card
                    </button>
                @endif
            @endif
        </div>
    </div>

    {{-- ── Billing History ─────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Billing History</h2>
        </div>

        @if($invoices->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3 text-left">Invoice</th>
                            <th class="px-5 py-3 text-left">Plan</th>
                            <th class="px-5 py-3 text-left">Period</th>
                            <th class="px-5 py-3 text-left">Amount</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Date</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($invoices as $invoice)
                            @php
                                $statusClass = match($invoice->status) {
                                    'paid'    => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'failed'  => 'bg-red-100 text-red-800',
                                    default   => 'bg-gray-100 text-gray-700',
                                };
                                $planEmoji = match($invoice->plan ?? '') { 'pro' => '💼', 'plus' => '🚀', default => '🆓' };
                            @endphp
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="px-5 py-3.5">
                                    <span class="font-mono font-semibold text-gray-800 text-xs">{{ $invoice->invoice_number }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-gray-700">
                                    {{ $planEmoji }} {{ ucfirst($invoice->plan ?? '—') }}
                                    @if($invoice->billing_cycle)
                                        <span class="text-xs text-gray-400">({{ ucfirst($invoice->billing_cycle) }})</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-gray-500 text-xs">
                                    @if($invoice->billing_period_start && $invoice->billing_period_end)
                                        {{ $invoice->billing_period_start->format('d M Y') }} → {{ $invoice->billing_period_end->format('d M Y') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 font-semibold text-gray-800">
                                    {{ number_format($invoice->amount, 3) }} {{ $invoice->currency ?? 'OMR' }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-gray-500 text-xs">
                                    {{ $invoice->paid_at?->format('d M Y') ?? $invoice->created_at->format('d M Y') }}
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.billing.invoice', $invoice) }}"
                                           class="text-xs px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition" target="_blank">
                                            View
                                        </a>
                                        <a href="{{ route('admin.billing.invoice', $invoice) }}?download=1"
                                           class="text-xs px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition" target="_blank">
                                            ↓ PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $invoices->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-14 text-center">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-400 text-sm">No invoices yet.</p>
            </div>
        @endif
    </div>

    {{-- ─────────────────────────────────────────────────────────────────────
         MODALS
    ──────────────────────────────────────────────────────────────────────── --}}

    {{-- Update / Add Card Modal --}}
    <div id="update-card-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">{{ $paymentMethod ? 'Update' : 'Add' }} Payment Card</h3>
                    <p class="text-xs text-gray-500">Securely saved for auto-renewal</p>
                </div>
            </div>

            {{-- How it works --}}
            <div class="space-y-2.5 mb-4">
                <div class="flex items-start gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                    <p class="text-xs text-gray-600">You'll be redirected to our secure payment partner (Paymob).</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                    <p class="text-xs text-gray-600">Enter your card details on their encrypted page.</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                    <p class="text-xs text-gray-600">Your card is saved. You'll be returned here automatically.</p>
                </div>
            </div>

            {{-- 1-fil notice --}}
            <div class="flex items-start gap-2 p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 mb-5">
                <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                A <strong class="mx-1">0.001 OMR</strong> card-verification charge will appear on your statement. It is immediately refunded.
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('update-card-modal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.billing.update-card') }}" class="flex-1"
                      onsubmit="this.querySelector('button').disabled=true;this.querySelector('button').textContent='Redirecting…'">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                        Continue →
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Remove Card Modal --}}
    <div id="remove-card-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Remove Payment Card?</h3>
                    <p class="text-xs text-gray-500">This cannot be undone.</p>
                </div>
            </div>
            @if($license && $license->plan !== 'free')
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 mb-4">
                    ⚠ Your subscription auto-renews automatically. Without a saved card, it will <strong>not renew</strong> on {{ $license->next_billing_date?->format('d M Y') ?? 'the next billing date' }}.
                </div>
            @endif
            <p class="text-sm text-gray-600 mb-5">Your saved card will be permanently removed from this account.</p>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('remove-card-modal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                    Keep Card
                </button>
                <form method="POST" action="{{ route('admin.billing.remove-payment-method') }}" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 transition">
                        Yes, Remove
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Cancel Subscription Modal --}}
    @if($license && ($license->plan ?? 'free') !== 'free')
        @php $plan = $license->plan ?? 'free'; @endphp
        <div id="cancel-sub-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Cancel Subscription?</h3>
                        <p class="text-sm text-gray-500">This action cannot be undone.</p>
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2">
                    Your <span class="font-semibold">{{ ucfirst($plan) }} plan</span> will be cancelled immediately and your account will be downgraded to the <span class="font-semibold">Free plan</span>.
                </p>
                <ul class="text-xs text-gray-500 space-y-1 mb-5 list-disc list-inside">
                    <li>Limited to 1 branch, 1 staff, 5 services</li>
                    <li>No WhatsApp reminders</li>
                    <li>You can re-subscribe at any time</li>
                </ul>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('cancel-sub-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                        Keep My Plan
                    </button>
                    <form method="POST" action="{{ route('admin.billing.cancel') }}" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 transition">
                            Yes, Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

</x-admin-layout>
