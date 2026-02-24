<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.full_name') }}</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus
            autocomplete="name"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="{{ __('app.enter_full_name') }}" />
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.email_address') }}</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
            autocomplete="username"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="{{ __('app.enter_email_address') }}" />
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <!-- Email Verification Alert -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    {{ __('app.email_not_verified') }}
                    <button type="submit" form="send-verification"
                        class="font-semibold text-yellow-900 hover:text-yellow-700 underline">
                        {{ __('app.resend_verification_email') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-600">
                        {{ __('app.verification_link_sent') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Success Message -->
    @if (session('status') === 'profile-updated')
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-700 font-medium">{{ __('app.profile_updated_successfully') }}</p>
        </div>
    @endif

    <!-- Submit Button -->
    <div class="flex items-center justify-end space-x-4">
        <button type="submit"
            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            {{ __('app.save_changes') }}
        </button>
    </div>
</form>