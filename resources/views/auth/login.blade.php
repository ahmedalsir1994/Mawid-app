<x-guest-layout>
    {{-- Faint green blobs inside the card --}}
    <div class="absolute -top-6 -right-6 w-32 h-32 bg-green-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 pointer-events-none"></div>
    <div class="absolute -bottom-6 -left-6 w-28 h-28 bg-emerald-300 rounded-full mix-blend-multiply filter blur-2xl opacity-25 pointer-events-none"></div>
    <div class="absolute top-1/2 -right-4 w-20 h-20 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 pointer-events-none"></div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if(request('expired'))
        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
            {{ __('Your session expired. Please sign in again to continue.') }}
        </div>
    @endif


    <form method="POST" action="{{ route('login') }}">

        @csrf
        @if(request('intended'))
            <input type="hidden" name="intended" value="{{ request('intended') }}">
        @endif

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input lang="en" dir="ltr" id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>