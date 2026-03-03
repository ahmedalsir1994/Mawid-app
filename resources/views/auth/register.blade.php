<x-guest-layout>
    @php
        $selectedPlan  = old('plan',          request('plan',  'free'));
        $selectedCycle = old('billing_cycle',  request('cycle', 'monthly'));
        $planLabels    = ['pro' => 'Pro', 'plus' => 'Plus'];
        $planColors    = ['pro' => 'bg-blue-600', 'plus' => 'bg-green-600'];
        $planPrices    = ['pro' => ['monthly' => '5 OMR/mo', 'yearly' => '57 OMR/yr'],
                          'plus' => ['monthly' => '9 OMR/mo', 'yearly' => '102.60 OMR/yr']];
        $isPaid        = in_array($selectedPlan, ['pro', 'plus']);
    @endphp

    {{-- Plan banner shown when registering from a paid plan CTA --}}
    @if($isPaid)
        <div class="mb-6 p-4 rounded-xl {{ $planColors[$selectedPlan] }} text-white text-center">
            <p class="font-bold text-lg">{{ $planLabels[$selectedPlan] }} Plan — {{ $planPrices[$selectedPlan][$selectedCycle] }}</p>
            <p class="text-sm opacity-90 mt-1">Create your account, then complete payment to activate.</p>
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
