<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')

    <!-- Current Password Field -->
    <div>
        <label for="update_password_current_password"
            class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.current_password') }}</label>
        <input lang="en" dir="ltr" type="password" id="update_password_current_password" name="current_password"
            autocomplete="current-password"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="{{ __('app.enter_current_password') }}" />
        @error('current_password', 'updatePassword')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- New Password Field -->
    <div>
        <label for="update_password_password"
            class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.new_password') }}</label>
        <input lang="en" dir="ltr" type="password" id="update_password_password" name="password" autocomplete="new-password"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
            placeholder="{{ __('app.enter_new_password') }}" />
        @error('password', 'updatePassword')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-2 text-xs text-gray-500">{{ __('app.password_min_length') }}</p>
    </div>

    <!-- Confirm Password Field -->
    <div>
        <label for="update_password_password_confirmation"
            class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.confirm_password') }}</label>
        <input lang="en" dir="ltr" type="password" id="update_password_password_confirmation" name="password_confirmation"
            autocomplete="new-password"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
            placeholder="{{ __('app.confirm_new_password') }}" />
        @error('password_confirmation', 'updatePassword')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Success Message -->
    @if (session('status') === 'password-updated')
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-700 font-medium">{{ __('app.password_updated_successfully') }}</p>
        </div>
    @endif

    <!-- Submit Button -->
    <div class="flex items-center justify-end">
        <button type="submit"
            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            {{ __('app.update_password') }}
        </button>
    </div>
</form>