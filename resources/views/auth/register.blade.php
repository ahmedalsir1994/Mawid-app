<x-guest-layout>
    {{-- Faint green blobs inside the card --}}
    <div class="absolute -top-6 -right-6 w-32 h-32 bg-green-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 pointer-events-none"></div>
    <div class="absolute -bottom-6 -left-6 w-28 h-28 bg-emerald-300 rounded-full mix-blend-multiply filter blur-2xl opacity-25 pointer-events-none"></div>
    <div class="absolute top-1/2 -right-4 w-20 h-20 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 pointer-events-none"></div>

    @php
        $selectedPlan  = old('plan',          request('plan',  'free'));
        $selectedCycle = old('billing_cycle',  request('cycle', 'monthly'));
        $planLabels    = ['pro' => 'Pro', 'plus' => 'Plus'];
        $planColors    = ['pro' => 'bg-blue-600', 'plus' => 'bg-green-600'];
        $isPaid        = in_array($selectedPlan, ['pro', 'plus']);

        if ($isPaid) {
            $planData    = \App\Services\PlanService::get($selectedPlan);
            $discountPct = $selectedCycle === 'yearly'
                ? $planData['discount_yearly']
                : $planData['discount_monthly'];
            $oldPrice = $selectedCycle === 'yearly'
                ? $planData['old_price_yearly'] . ' OMR/yr'
                : $planData['old_price_monthly'] . ' OMR/mo';
            $newPrice = $selectedCycle === 'yearly'
                ? number_format($planData['price_yearly_display'], 1) . ' OMR/mo · ' . number_format($planData['price_yearly'], 2) . ' OMR/yr'
                : number_format($planData['price_monthly'], 1) . ' OMR/mo';
        }

        $businessTypes = [
            'beauty_salon'      => 'Beauty Salon',
            'barbershop'        => 'Barbershop',
            'spa_wellness'      => 'Spa & Wellness',
            'medical_clinic'    => 'Medical Clinic',
            'dental_clinic'     => 'Dental Clinic',
            'fitness_gym'       => 'Fitness & Gym',
            'personal_trainer'  => 'Personal Trainer',
            'photography'       => 'Photography Studio',
            'cleaning_services' => 'Cleaning Services',
            'home_services'     => 'Home Services',
            'tutoring'          => 'Tutoring & Education',
            'legal_consulting'  => 'Legal Consulting',
            'financial_services'=> 'Financial Services',
            'it_services'       => 'IT Services',
            'other'             => 'Other',
        ];

        $companySizes = [
            '1-5'    => '1 – 5 employees',
            '6-20'   => '6 – 20 employees',
            '21-50'  => '21 – 50 employees',
            '51-200' => '51 – 200 employees',
            '200+'   => '200+ employees',
        ];
    @endphp

    {{-- Plan banner shown when registering from a paid plan CTA --}}
    @if($isPaid)
        <div class="mb-6 p-4 rounded-xl {{ $planColors[$selectedPlan] }} text-white text-center">
            <p class="font-bold text-lg">{{ $planLabels[$selectedPlan] }} Plan</p>
            <div class="flex items-center justify-center gap-2 mt-1">
                <span class="text-sm line-through opacity-70">{{ $oldPrice }}</span>
                <span class="text-lg font-bold">{{ $newPrice }}</span>
                <span class="text-xs font-bold bg-white text-green-700 px-2 py-0.5 rounded-full">Save {{ $discountPct }}%</span>
            </div>
            <p class="text-sm opacity-90 mt-2">Create your account, then complete payment to activate.</p>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="plan"          value="{{ $selectedPlan }}">
        <input type="hidden" name="billing_cycle" value="{{ $selectedCycle }}">

        {{-- ── Section: Personal Info ──────────────────────────────── --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Your Information</p>
            <div class="space-y-4">

                {{-- Full Name --}}
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name"
                        placeholder="Ahmed Al-Harthi" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                </div>

                {{-- Email + Phone (side by side on md+) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username"
                            placeholder="you@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>
                    <div>
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                            :value="old('phone')" required autocomplete="tel"
                            placeholder="+968 9X XXX XXX" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Divider ─────────────────────────────────────────────── --}}
        <div class="border-t border-gray-100"></div>

        {{-- ── Section: Business Info ──────────────────────────────── --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Business Information</p>
            <div class="space-y-4">

                {{-- Business Name --}}
                <div>
                    <x-input-label for="business_name" :value="__('Business Name')" />
                    <x-text-input id="business_name" class="block mt-1 w-full" type="text" name="business_name"
                        :value="old('business_name')" required
                        placeholder="My Awesome Business" />
                    <x-input-error :messages="$errors->get('business_name')" class="mt-1.5" />
                </div>

                {{-- Business Type + Company Size (side by side on md+) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="business_type" :value="__('Business Type')" />
                        <select id="business_type" name="business_type" required
                            class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm text-sm">
                            <option value="" disabled {{ old('business_type') ? '' : 'selected' }}>Select type…</option>
                            @foreach($businessTypes as $value => $label)
                                <option value="{{ $value }}" {{ old('business_type') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('business_type')" class="mt-1.5" />
                    </div>
                    <div>
                        <x-input-label for="company_size" :value="__('Company Size')" />
                        <select id="company_size" name="company_size" required
                            class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm text-sm">
                            <option value="" disabled {{ old('company_size') ? '' : 'selected' }}>Select size…</option>
                            @foreach($companySizes as $value => $label)
                                <option value="{{ $value }}" {{ old('company_size') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('company_size')" class="mt-1.5" />
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Divider ─────────────────────────────────────────────── --}}
        <div class="border-t border-gray-100"></div>

        {{-- ── Section: Password ───────────────────────────────────── --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Security</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password"
                        name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                </div>
            </div>
        </div>

        {{-- ── Submit ───────────────────────────────────────────────── --}}
        <div class="flex items-center justify-between pt-1 gap-3 flex-wrap">
            @error('plan')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
            <a class="text-sm text-gray-500 hover:text-gray-800 transition underline" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button>
                {{ $isPaid ? __('Register & Proceed to Payment') : __('Create Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
