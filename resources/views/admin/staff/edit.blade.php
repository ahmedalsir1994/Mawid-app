<x-admin-layout>
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.staff.index') }}"
                class="text-gray-600 hover:text-gray-900 transition">
                ← {{ __('app.back_to_staff') }}
            </a>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mt-4">{{ __('app.edit_staff_member') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('app.update_staff_information', ['name' => $staff->name]) }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.staff.update', $staff) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.full_name') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.email_address') }} <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $staff->email) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.new_password_leave_blank') }}
                </label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">{{ __('app.minimum_8_if_changing') }}</p>
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.confirm_new_password') }}
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                        {{ old('is_active', $staff->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="ml-2 text-sm text-gray-700">{{ __('app.active_staff_can_login') }}</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    {{ __('app.update_staff_member') }}
                </button>
                <a href="{{ route('admin.staff.show', $staff) }}"
                    class="text-gray-600 hover:text-gray-900 font-medium px-6 py-3 rounded-lg transition">
                    {{ __('app.cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
