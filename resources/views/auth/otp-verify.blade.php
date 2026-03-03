<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Check your email</h2>
        <p class="text-sm text-gray-500 mt-1">
            We sent a 6-digit code to verify your account.
        </p>
    </div>

    @if(session('info'))
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700">
            {{ session('info') }}
        </div>
    @endif

    @if(session('resent'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
            {{ session('resent') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- OTP Input -->
        <div class="mb-5">
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                Verification Code
            </label>
            <input lang="en" dir="ltr"
                type="text"
                id="otp"
                name="otp"
                maxlength="6"
                inputmode="numeric"
                autocomplete="one-time-code"
                autofocus
                placeholder="000000"
                value="{{ old('otp') }}"
                class="w-full px-4 py-4 text-center text-3xl font-bold tracking-[0.5em] rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('otp') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-2 text-center">
                The code expires in <span class="font-semibold">10 minutes</span>
            </p>
        </div>

        <button type="submit"
            class="w-full py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl hover:shadow-lg transition">
            Verify Email →
        </button>
    </form>

    <!-- Resend -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500 mb-2">Didn't receive the code?</p>
        <form method="POST" action="{{ route('otp.resend') }}" class="inline">
            @csrf
            <button type="submit"
                class="text-sm font-semibold text-green-600 hover:text-green-700 hover:underline transition">
                Resend verification code
            </button>
        </form>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('register') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">
            ← Back to registration
        </a>
    </div>
</x-guest-layout>
