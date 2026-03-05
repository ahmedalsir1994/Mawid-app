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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Carry selected plan through to the POST handler --}}
        <input type="hidden" name="plan"          value="{{ $selectedPlan }}">
        <input type="hidden" name="billing_cycle" value="{{ $selectedCycle }}">

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @error('plan')
                <p class="text-sm text-red-600 me-auto">{{ $message }}</p>
            @enderror
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ $isPaid ? __('Register & Proceed to Payment') : __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
