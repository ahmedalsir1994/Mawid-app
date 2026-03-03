<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">{{ __('app.edit_license') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('app.update_license_details') }}</p>
    </div>

    <!-- Edit Form -->
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.super.licenses.update', $license) }}"
            class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            @csrf
            @method('PUT')

            <!-- Business Info (Read-only) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.business') }}</label>
                <p class="text-lg font-semibold text-gray-900">{{ $license->business->name }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ __('app.license_id') }}: {{ $license->id }}</p>
            </div>

            <!-- License Key (Read-only) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.license_key') }}</label>
                <div class="flex items-center gap-2">
                    <input lang="en" dir="ltr" type="text" value="{{ $license->license_key }}" disabled
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-900 font-mono">
                    <button type="button" onclick="copyToClipboard('{{ $license->license_key }}')"
                        class="px-4 py-3 bg-blue-100 text-blue-700 font-medium rounded-lg hover:bg-blue-200 transition">
                        {{ __('app.copy') }}
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.status') }} *</label>
                    <select lang="en" dir="ltr" name="status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="active" @selected(old('status', $license->status) === 'active')>
                            {{ __('app.active') }}</option>
                        <option value="expired" @selected(old('status', $license->status) === 'expired')>
                            {{ __('app.expired') }}</option>
                        
                        <option value="cancelled" @selected(old('status', $license->status) === 'cancelled')>
                            {{ __('app.cancelled') }}
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.payment_status') }} *</label>
                    <select lang="en" dir="ltr" name="payment_status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="unpaid" @selected(old('payment_status', $license->payment_status) === 'unpaid')>
                            {{ __('app.unpaid') }}
                        </option>
                        <option value="paid" @selected(old('payment_status', $license->payment_status) === 'paid')>
                            {{ __('app.paid') }}
                        </option>
                    </select>
                    @error('payment_status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Plan & Billing Cycle -->
            <div class="mb-6 p-5 bg-gray-50 rounded-xl border border-gray-200">
                <p class="text-sm font-semibold text-gray-700 mb-3">Plan &amp; Billing</p>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    @foreach($plans as $key => $p)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="plan" value="{{ $key }}" class="sr-only peer"
                                @checked(old('plan', $license->plan ?? 'free') === $key)
                                onchange="applyPlan('{{ $key }}')">
                            <div class="peer-checked:border-green-500 peer-checked:bg-green-50 border-2 border-gray-200 rounded-xl p-3 text-center transition hover:border-green-300">
                                <div class="text-2xl mb-1">{{ $p['emoji'] }}</div>
                                <div class="font-bold text-sm text-gray-800">{{ $p['name'] }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    @if($p['price_monthly'] === 0) Free
                                    @else {{ $p['price_monthly'] }} OMR/mo
                                    @endif
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Billing Cycle</label>
                    <select lang="en" dir="ltr" name="billing_cycle" id="billing_cycle"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="monthly" @selected(old('billing_cycle', $license->billing_cycle ?? 'monthly') === 'monthly')>Monthly</option>
                        <option value="yearly" @selected(old('billing_cycle', $license->billing_cycle ?? 'monthly') === 'yearly')>Yearly (5% off)</option>
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
                            required min="1" value="{{ old('max_branches', $license->max_branches ?? 1) }}"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_branches')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Staff</label>
                        <input lang="en" dir="ltr" type="number" name="max_staff" id="max_staff"
                            required min="1" value="{{ old('max_staff', $license->max_staff ?? 1) }}"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_staff')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Services <span class="text-gray-400">(0=∞)</span></label>
                        <input lang="en" dir="ltr" type="number" name="max_services" id="max_services"
                            required min="0" value="{{ old('max_services', $license->max_services ?? 3) }}"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_services')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mt-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input lang="en" dir="ltr" type="checkbox" name="whatsapp_reminders" id="whatsapp_reminders"
                            value="1" @checked(old('whatsapp_reminders', $license->whatsapp_reminders))
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="text-sm text-gray-700">WhatsApp Reminders enabled</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Expires At -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.expiration_date') }}</label>
                    <input lang="en" dir="ltr" type="date" name="expires_at"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        value="{{ old('expires_at', $license->expires_at ? $license->expires_at->format('Y-m-d') : '') }}">
                    @error('expires_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (OMR) *</label>
                    <input lang="en" dir="ltr" type="number" name="price" id="price" required min="0" step="0.01"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="0.00" value="{{ old('price', $license->price) }}">
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.notes') }}</label>
                <textarea lang="en" dir="ltr" name="notes" rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                    placeholder="{{ __('app.add_notes_license') }}">{{ old('notes', $license->notes) }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- License Info -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">{{ __('app.activated') }}</p>
                        <p class="font-semibold text-gray-900">{{ $license->activated_at?->format('M d, Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">{{ __('app.expires') }}</p>
                        <p class="font-semibold text-gray-900">{{ $license->expires_at?->format('M d, Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">{{ __('app.days_remaining') }}</p>
                        <p class="font-semibold text-gray-900">{{ $license->expires_at ? now()->diffInDays($license->expires_at, false) : '—' }}</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                @if(!$license->isActive())
                    <form method="POST" action="{{ route('admin.super.licenses.reactivate', $license) }}" style="flex: 1;">
                        @csrf
                        <button type="submit" onclick="return confirm('{{ __('app.reactivate_license_confirm') }}')"
                            class="w-full px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                            ✓ {{ __('app.reactivate_license') }}
                        </button>
                    </form>
                @endif

                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                    {{ __('app.save_changes') }}
                </button>
                <a href="{{ route('admin.super.licenses.show', $license) }}"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                    {{ __('app.cancel') }}
                </a>
            </div>
        </form>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('{{ __('app.license_key_copied') }}');
            });
        }

        @php
        $planData = collect($plans)->map(fn($p, $k) => [
            'max_branches'       => $p['max_branches'],
            'max_staff'          => $p['max_staff'],
            'max_services'       => $p['max_services'],
            'whatsapp_reminders' => $p['whatsapp_reminders'],
            'price_monthly'      => $p['price_monthly'],
            'price_yearly'       => $p['price_yearly'] ?? $p['price_monthly'],
        ])->toJson()
        @endphp
        const PLANS = @json(json_decode($planData));

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
</x-admin-layout>