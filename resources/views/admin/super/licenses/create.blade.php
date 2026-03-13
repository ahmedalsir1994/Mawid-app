<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">{{ __('app.create_license') }}</h1>
        <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('app.create_new_license') }}</p>
    </div>

    <!-- Create Form -->
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.super.licenses.store') }}"
            class="bg-white rounded-xl shadow-md border border-gray-100 p-8 space-y-6">
            @csrf

            <!-- Business Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.business') }} *</label>
                <select lang="en" dir="ltr" name="business_id" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">{{ __('app.select_business') }}</option>
                    @foreach($businesses as $business)
                        <option value="{{ $business->id }}" @selected(old('business_id') == $business->id)>
                            {{ $business->name }}
                        </option>
                    @endforeach
                </select>
                @error('business_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- License Key -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.license_key') }} *</label>
                <div class="flex gap-2">
                    <input lang="en" dir="ltr" type="text" name="license_key" required
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="LIC-XXX..." value="{{ old('license_key') }}">
                    <button type="button" onclick="generateKey()"
                        class="px-4 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition">
                        {{ __('app.generate') }}
                    </button>
                </div>
                @error('license_key')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- License Type -->
            <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                <p class="text-sm font-semibold text-gray-700 mb-3">License Type</p>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="license_type" value="plan" class="sr-only peer"
                            @checked(old('license_type', 'plan') === 'plan')
                            onchange="toggleLicenseType('plan')">
                        <div class="peer-checked:border-green-500 peer-checked:bg-green-50 border-2 border-gray-200 rounded-xl p-3 text-center transition hover:border-green-300">
                            <div class="text-xl mb-1">📋</div>
                            <div class="font-bold text-sm text-gray-800">Plan License</div>
                            <div class="text-xs text-gray-500 mt-0.5">Limits auto-filled from plan</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="license_type" value="custom" class="sr-only peer"
                            @checked(old('license_type') === 'custom')
                            onchange="toggleLicenseType('custom')">
                        <div class="peer-checked:border-purple-500 peer-checked:bg-purple-50 border-2 border-gray-200 rounded-xl p-3 text-center transition hover:border-purple-300">
                            <div class="text-xl mb-1">⚙️</div>
                            <div class="font-bold text-sm text-gray-800">Custom License</div>
                            <div class="text-xs text-gray-500 mt-0.5">Manually define all limits</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Plan & Billing (hidden for custom licenses) -->
            <div id="plan-section">
                <div class="p-5 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Plan &amp; Billing</p>
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        @foreach($plans as $key => $p)
                            <label class="plan-card relative cursor-pointer">
                                <input type="radio" name="plan" value="{{ $key }}" class="sr-only peer"
                                    @checked(old('plan', 'free') === $key)
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

                    <!-- Billing Cycle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Billing Cycle</label>
                        <select lang="en" dir="ltr" name="billing_cycle" id="billing_cycle"
                            onchange="updateExpiry()"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            <option value="monthly" @selected(old('billing_cycle', 'monthly') === 'monthly')>Monthly</option>
                            <option value="yearly" @selected(old('billing_cycle', 'yearly') === 'yearly')>Yearly (5% off)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Limits -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">
                    <span id="limits-label-plan">Plan Limits <span class="text-gray-400 font-normal">(auto-filled from plan, editable)</span></span>
                    <span id="limits-label-custom" class="hidden">Custom Limits <span class="text-purple-600 font-normal">(override everything)</span></span>
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Branches</label>
                        <input lang="en" dir="ltr" type="number" name="max_branches" id="max_branches"
                            required min="1" value="{{ old('max_branches', 1) }}"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_branches')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Staff</label>
                        <input lang="en" dir="ltr" type="number" name="max_staff" id="max_staff"
                            required min="1" value="{{ old('max_staff', 1) }}"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_staff')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Services <span class="text-gray-400">(0=∞)</span></label>
                        <input lang="en" dir="ltr" type="number" name="max_services" id="max_services"
                            required min="0" value="{{ old('max_services', 3) }}"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_services')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Daily Bookings <span class="text-gray-400">(0=∞)</span></label>
                        <input lang="en" dir="ltr" type="number" name="max_daily_bookings" id="max_daily_bookings"
                            min="0" value="{{ old('max_daily_bookings', 50) }}"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                </div>
                <!-- WhatsApp Reminders -->
                <div class="mt-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input lang="en" dir="ltr" type="checkbox" name="whatsapp_reminders" id="whatsapp_reminders"
                            value="1" @checked(old('whatsapp_reminders'))
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="text-sm text-gray-700">WhatsApp Reminders enabled</span>
                    </label>
                </div>
            </div>

            <!-- Status & Payment -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.status') }} *</label>
                    <select lang="en" dir="ltr" name="status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="active" @selected(old('status', 'active') === 'active')>{{ __('app.active') }}</option>
                        <option value="expired" @selected(old('status') === 'expired')>{{ __('app.expired') }}</option>
                        <option value="cancelled" @selected(old('status') === 'cancelled')>{{ __('app.cancelled') }}</option>
                    </select>
                    @error('status')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.payment_status') }} *</label>
                    <select lang="en" dir="ltr" name="payment_status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <option value="paid" @selected(old('payment_status', 'paid') === 'paid')>{{ __('app.paid') }}</option>
                        <option value="unpaid" @selected(old('payment_status') === 'unpaid')>{{ __('app.unpaid') }}</option>
                    </select>
                    @error('payment_status')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Price & Expiry -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (OMR) *</label>
                    <input lang="en" dir="ltr" type="number" name="price" id="price"
                        required min="0" step="0.01"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="0.00" value="{{ old('price', 0) }}">
                    @error('price')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Expiry Date <span class="text-gray-400 font-normal">(leave blank = auto)</span>
                    </label>
                    <input lang="en" dir="ltr" type="date" name="expires_at" id="expires_at"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        value="{{ old('expires_at') }}">
                    @error('expires_at')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.notes') }}</label>
                <textarea lang="en" dir="ltr" name="notes" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                    placeholder="{{ __('app.add_notes_license') }}">{{ old('notes') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:shadow-lg transition">
                    {{ __('app.create_license') }}
                </button>
                <a href="{{ route('admin.super.licenses.index') }}"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                    {{ __('app.cancel') }}
                </a>
            </div>
        </form>
    </div>

    @php
    $planData = collect($plans)->map(fn($p, $k) => [
        'max_branches'       => $p['max_branches'],
        'max_staff'          => $p['max_staff'],
        'max_services'       => $p['max_services'],
        'max_daily_bookings' => $p['max_daily_bookings'],
        'whatsapp_reminders' => $p['whatsapp_reminders'],
        'price_monthly'      => $p['price_monthly'],
        'price_yearly'       => $p['price_yearly'] ?? $p['price_monthly'],
    ])->toJson()
    @endphp

    <script>
        const PLANS = @json(json_decode($planData));

        function toggleLicenseType(type) {
            const planSection = document.getElementById('plan-section');
            const labelPlan   = document.getElementById('limits-label-plan');
            const labelCustom = document.getElementById('limits-label-custom');

            if (type === 'custom') {
                planSection.classList.add('hidden');
                labelPlan.classList.add('hidden');
                labelCustom.classList.remove('hidden');
                // Highlight limit inputs for custom
                document.querySelectorAll('#max_branches, #max_staff, #max_services, #max_daily_bookings')
                    .forEach(el => el.classList.add('border-purple-400', 'bg-purple-50'));
            } else {
                planSection.classList.remove('hidden');
                labelPlan.classList.remove('hidden');
                labelCustom.classList.add('hidden');
                document.querySelectorAll('#max_branches, #max_staff, #max_services, #max_daily_bookings')
                    .forEach(el => el.classList.remove('border-purple-400', 'bg-purple-50'));
                // Re-apply the currently selected plan
                const checked = document.querySelector('input[name="plan"]:checked');
                if (checked) applyPlan(checked.value);
            }
        }

        function applyPlan(planKey) {
            const p = PLANS[planKey];
            if (!p) return;
            document.getElementById('max_branches').value          = p.max_branches;
            document.getElementById('max_staff').value             = p.max_staff;
            document.getElementById('max_services').value          = p.max_services;
            document.getElementById('max_daily_bookings').value    = p.max_daily_bookings;
            document.getElementById('whatsapp_reminders').checked  = p.whatsapp_reminders;
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
            const licenseType = document.querySelector('input[name="license_type"]:checked')?.value || 'plan';
            toggleLicenseType(licenseType);
        });
    </script>
</x-admin-layout>