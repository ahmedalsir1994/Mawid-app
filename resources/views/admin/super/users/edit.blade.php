<x-admin-layout>
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-start justify-between gap-y-4">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">{{ __('app.edit_user') }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('app.update_user_permissions') }}</p>
            </div>
            <a href="{{ route('admin.super.users.index') }}"
                class="shrink-0 px-4 py-2 sm:px-6 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                {{ __('app.back') }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form id="update-user-form" action="{{ route('admin.super.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.full_name') }}
                        *</label>
                    <input lang="en" dir="ltr" type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.email') }} *</label>
                    <input lang="en" dir="ltr" type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    <p class="text-gray-400 text-xs mt-1">Changing the email will update the login address for this user.</p>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.role') }}
                        *</label>
                    <select lang="en" dir="ltr" name="role" id="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required
                        onchange="document.getElementById('business_id').disabled = this.value === 'super_admin'">
                        <option value="">{{ __('app.select_role') }}</option>
                        <option value="super_admin" @selected(old('role', $user->role) === 'super_admin')>
                            {{ __('app.super_admin') }}
                        </option>
                        <option value="company_admin" @selected(old('role', $user->role) === 'company_admin')>
                            {{ __('app.company_admin') }}</option>
                        <option value="staff" @selected(old('role', $user->role) === 'staff')>{{ __('app.staff') }}
                        </option>
                        <option value="customer" @selected(old('role', $user->role) === 'customer')>
                            {{ __('app.customer') }}</option>
                    </select>
                    @error('role')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Business -->
                <div>
                    <label for="business_id"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.business') }}</label>
                    <select lang="en" dir="ltr" name="business_id" id="business_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        @disabled(old('role', $user->role) === 'super_admin')>
                        <option value="">{{ __('app.no_business') }}</option>
                        @foreach ($businesses as $business)
                            <option value="{{ $business->id }}" @selected(old('business_id', $user->business_id) == $business->id)>
                                {{ $business->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('business_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-600 text-sm mt-1">{{ __('app.super_admin_no_business') }}</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.status') }}</label>
                    <select lang="en" dir="ltr" name="is_active" id="is_active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <option value="0" @selected(!$user->is_active)>{{ __('app.inactive') }}</option>
                        <option value="1" @selected($user->is_active)>{{ __('app.active') }}</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password Section -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('app.change_password_optional') }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ __('app.leave_blank_keep_password') }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div>
                        <label for="password"
                            class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.new_password') }}</label>
                        <input lang="en" dir="ltr" type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                            placeholder="{{ __('app.enter_new_password_optional') }}">
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.confirm_password') }}</label>
                        <input lang="en" dir="ltr" type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                            placeholder="{{ __('app.confirm_new_password_optional') }}">
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="border-t border-gray-200 pt-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">{{ __('app.created') }}</p>
                        <p class="font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">{{ __('app.last_updated') }}</p>
                        <p class="font-semibold text-gray-900">{{ $user->updated_at->format('M d, Y') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">{{ __('app.status') }}</p>
                        <p class="font-semibold">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? __('app.active') : __('app.inactive') }}
                            </span>
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">{{ __('app.user_id') }}</p>
                        <p class="font-semibold text-gray-900 font-mono text-sm">#{{ $user->id }}</p>
                    </div>
                </div>
            </div>

        </form>{{-- END update form — must close before the delete form below --}}

        <!-- Actions (outside the update form to prevent nesting) -->
        <div class="flex flex-wrap items-center justify-between gap-3 pt-6 border-t border-gray-200 mt-6">
            <form action="{{ route('admin.super.users.destroy', $user) }}" method="POST" class="inline"
                onsubmit="return confirm('{{ __('app.delete_user_undone_confirm') }}')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                    {{ __('app.delete_user') }}
                </button>
            </form>

            <div class="flex gap-3">
                <a href="{{ route('admin.super.users.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                    {{ __('app.cancel') }}
                </a>
                <button type="submit" form="update-user-form"
                    class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-600 text-white rounded-lg hover:shadow-lg transition font-medium">
                    {{ __('app.update_user') }}
                </button>
            </div>
        </div>
    </div>
</x-admin-layout>