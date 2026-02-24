<x-admin-layout>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $user->id ? __('app.edit_user') : __('app.create_user') }}</h1>
                <p class="text-gray-600 mt-2">
                    {{ $user->id ? __('app.update_user_details') : __('app.add_new_user_platform') }}
                </p>
            </div>
            <a href="{{ route('admin.super.users.index') }}"
                class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                {{ __('app.back') }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form action="{{ $user->id ? route('admin.super.users.update', $user) : route('admin.super.users.store') }}"
            method="POST" class="space-y-6">
            @csrf
            @if ($user->id)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.full_name') }}
                        *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.email') }}
                        *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required @readonly($user->id)>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.role') }}
                        *</label>
                    <select name="role" id="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
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
                    <select name="business_id" id="business_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
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

                <!-- Password -->
                @if (!$user->id)
                    <div>
                        <label for="password"
                            class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.password') }} *</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            required>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.confirm_password') }}
                            *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            required>
                    </div>
                @else
                    <div>
                        <label for="password"
                            class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.password_leave_blank') }}</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    </div>
                @endif

                <!-- Status -->
                <div>
                    <label for="is_active"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.status') }}</label>
                    <select name="is_active" id="is_active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="0" @selected($user->id && !$user->is_active)>{{ __('app.inactive') }}</option>
                        <option value="1" @selected(!$user->id || $user->is_active)>{{ __('app.active') }}</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                @if ($user->id)
                    <form action="{{ route('admin.super.users.destroy', $user) }}" method="POST" class="inline"
                        onsubmit="return confirm('{{ __('app.delete_user_full_confirm') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            {{ __('app.delete_user') }}
                        </button>
                    </form>
                @endif

                <div class="flex gap-3">
                    <a href="{{ route('admin.super.users.index') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                        {{ __('app.cancel') }}
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-medium">
                        {{ $user->id ? __('app.update_user') : __('app.create_user') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>