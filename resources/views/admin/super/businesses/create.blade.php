<x-admin-layout>
    <div class="mb-6 sm:mb-8">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">{{ __('app.create_business') }}</h1>
        <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('app.add_new_business') }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form action="{{ route('admin.super.businesses.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name"
                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.business_name') }}</label>
                <input lang="en" dir="ltr" type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="e.g., Acme Beauty Salon">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.url_slug') }}</label>
                <input lang="en" dir="ltr" type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="e.g., acme-beauty-salon">
                <p class="text-gray-500 text-xs mt-1">{{ __('app.url_slug_hint') }}</p>
                @error('slug')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address"
                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.address') }}</label>
                <input lang="en" dir="ltr" type="text" id="address" name="address" value="{{ old('address') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="e.g., 123 Main Street">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Country -->
            <div>
                <label for="country"
                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.country') }}</label>
                <select lang="en" dir="ltr" id="country" name="country" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">{{ __('app.select_country') }}</option>
                    <option value="OM" {{ old('country') == 'OM' ? 'selected' : '' }}>{{ __('app.oman_om') }}</option>
                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>{{ __('app.saudi_arabia_sa') }}
                    </option>
                </select>
                @error('country')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.phone') }}</label>
                <input lang="en" dir="ltr" type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="e.g., +1 555-1234">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Currency -->
            <div>
                <label for="currency"
                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.currency') }}</label>
                <select lang="en" dir="ltr" id="currency" name="currency" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">{{ __('app.select_currency') }}</option>
                    <option value="OMR" {{ old('currency') == 'OMR' ? 'selected' : '' }}>{{ __('app.omr_oman_rial') }}
                    </option>
                    <option value="SAR" {{ old('currency') == 'SAR' ? 'selected' : '' }}>{{ __('app.sar_saudi_riyal') }}
                    </option>
                </select>
                @error('currency')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Timezone -->
            <div>
                <label for="timezone"
                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.timezone') }}</label>
                <select lang="en" dir="ltr" id="timezone" name="timezone" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">{{ __('app.select_timezone') }}</option>
                    @foreach(\DateTimeZone::listIdentifiers() as $tz)
                        <option value="{{ $tz }}" {{ old('timezone', 'Asia/Muscat') === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                    @endforeach
                </select>
                @error('timezone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:shadow-lg transition font-medium">
                    {{ __('app.create_business') }}
                </button>
                <a href="{{ route('admin.super.businesses.index') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    {{ __('app.cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>