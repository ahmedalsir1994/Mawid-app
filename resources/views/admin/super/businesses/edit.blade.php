<x-admin-layout>
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-start justify-between gap-y-4">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">{{ __('app.edit_business') }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('app.update_business_details', ['name' => $business->name]) }}</p>
            </div>
            <a href="{{ route('admin.super.businesses.index') }}"
                class="shrink-0 px-4 py-2 sm:px-6 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium text-sm sm:text-base">
                {{ __('app.back') }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form action="{{ route('admin.super.businesses.update', $business) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Business Name -->
                <div>
                    <label for="name"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.business_name_required') }}</label>
                    <input lang="en" dir="ltr" type="text" name="name" id="name" value="{{ old('name', $business->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.slug_required') }}</label>
                    <input lang="en" dir="ltr" type="text" name="slug" id="slug" value="{{ old('slug', $business->slug) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    @error('slug')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.address_required') }}</label>
                    <input lang="en" dir="ltr" type="text" name="address" id="address" value="{{ old('address', $business->address) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div>
                    <label for="country"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.country_required') }}</label>
                    <input lang="en" dir="ltr" type="text" name="country" id="country" value="{{ old('country', $business->country) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    @error('country')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.phone_required') }}</label>
                    <input lang="en" dir="ltr" type="tel" name="phone" id="phone" value="{{ old('phone', $business->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.currency_required') }}</label>
                    <select lang="en" dir="ltr" name="currency" id="currency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                        <option value="">{{ __('app.select_currency') }}</option>
                        <option value="USD" @selected(old('currency', $business->currency) === 'USD')>
                            {{ __('app.usd_us_dollar') }}
                        </option>
                        <option value="EUR" @selected(old('currency', $business->currency) === 'EUR')>
                            {{ __('app.eur_euro') }}</option>
                        <option value="GBP" @selected(old('currency', $business->currency) === 'GBP')>
                            {{ __('app.gbp_british_pound') }}
                        </option>
                        <option value="AED" @selected(old('currency', $business->currency) === 'AED')>
                            {{ __('app.aed_uae_dirham') }}
                        </option>
                        <option value="CAD" @selected(old('currency', $business->currency) === 'CAD')>
                            {{ __('app.cad_canadian_dollar') }}</option>
                        <option value="AUD" @selected(old('currency', $business->currency) === 'AUD')>
                            {{ __('app.aud_australian_dollar') }}</option>
                    </select>
                    @error('currency')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Timezone -->
                <div>
                    <label for="timezone"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.timezone_required') }}</label>
                    <select lang="en" dir="ltr" name="timezone" id="timezone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                        <option value="">{{ __('app.select_timezone') }}</option>
                        @foreach(\DateTimeZone::listIdentifiers() as $tz)
                            <option value="{{ $tz }}" @selected(old('timezone', $business->timezone) === $tz)>{{ $tz }}</option>
                        @endforeach
                    </select>
                    @error('timezone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.status') }}</label>
                    <select lang="en" dir="ltr" name="is_active" id="is_active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <option value="0" @selected(!$business->is_active)>{{ __('app.inactive') }}</option>
                        <option value="1" @selected($business->is_active)>{{ __('app.active') }}</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap items-center justify-between gap-3 pt-6 border-t border-gray-200">
                <form action="{{ route('admin.super.businesses.destroy', $business) }}" method="POST" class="inline"
                    onsubmit="return confirm('{{ __('app.delete_business_full_confirm') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        {{ __('app.delete_business') }}
                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="{{ route('admin.super.businesses.show', $business) }}"
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                        {{ __('app.cancel') }}
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:shadow-lg transition font-medium">
                        {{ __('app.update_business') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>