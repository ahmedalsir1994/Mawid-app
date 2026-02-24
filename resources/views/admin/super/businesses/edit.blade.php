<x-admin-layout>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('app.edit_business') }}</h1>
                <p class="text-gray-600 mt-2">{{ __('app.update_business_details', ['name' => $business->name]) }}</p>
            </div>
            <a href="{{ route('admin.super.businesses.index') }}"
                class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
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
                    <input type="text" name="name" id="name" value="{{ old('name', $business->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.slug_required') }}</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $business->slug) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                    @error('slug')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.address_required') }}</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $business->address) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div>
                    <label for="country"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.country_required') }}</label>
                    <input type="text" name="country" id="country" value="{{ old('country', $business->country) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                    @error('country')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.phone_required') }}</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $business->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.currency_required') }}</label>
                    <select name="currency" id="currency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
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
                    <select name="timezone" id="timezone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                        <option value="">{{ __('app.select_timezone') }}</option>
                        <option value="UTC" @selected(old('timezone', $business->timezone) === 'UTC')>{{ __('app.utc') }}
                        </option>
                        <option value="America/New_York" @selected(old('timezone', $business->timezone) === 'America/New_York')>{{ __('app.est_eastern_time') }}</option>
                        <option value="America/Chicago" @selected(old('timezone', $business->timezone) === 'America/Chicago')>{{ __('app.cst_central_time') }}</option>
                        <option value="America/Los_Angeles" @selected(old('timezone', $business->timezone) === 'America/Los_Angeles')>{{ __('app.pst_pacific_time') }}</option>
                        <option value="Europe/London" @selected(old('timezone', $business->timezone) === 'Europe/London')>
                            {{ __('app.gmt_london') }}
                        </option>
                        <option value="Europe/Paris" @selected(old('timezone', $business->timezone) === 'Europe/Paris')>
                            {{ __('app.cet_paris') }}
                        </option>
                        <option value="Asia/Dubai" @selected(old('timezone', $business->timezone) === 'Asia/Dubai')>
                            {{ __('app.gst_dubai') }}</option>
                        <option value="Asia/Singapore" @selected(old('timezone', $business->timezone) === 'Asia/Singapore')>{{ __('app.sgt_singapore') }}</option>
                    </select>
                    @error('timezone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active"
                        class="block text-sm font-semibold text-gray-900 mb-2">{{ __('app.status') }}</label>
                    <select name="is_active" id="is_active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="0" @selected(!$business->is_active)>{{ __('app.inactive') }}</option>
                        <option value="1" @selected($business->is_active)>{{ __('app.active') }}</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
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
                        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-medium">
                        {{ __('app.update_business') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>