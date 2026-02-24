<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-gray-800">{{ __('app.business_settings') }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ __('app.configure_business') }}</p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">

            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.business.update') }}" class="space-y-8"
                enctype="multipart/form-data">
                @csrf

                <!-- Business Info Section -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('app.business_information') }}</h3>

                    <div class="space-y-6">
                        <!-- Company Logo -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.company_logo') }}</label>
                            @if($business->logo)
                                <div class="mb-4">
                                    <img src="{{ asset($business->logo) }}" alt="{{ __('app.current_logo') }}"
                                        class="h-24 w-auto rounded-lg shadow-md border border-gray-200">
                                </div>
                            @endif
                            <input type="file" name="logo" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                            <p class="text-gray-600 text-xs mt-2">{{ __('app.upload_logo_hint') }}</p>
                            @error('logo') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Business Name -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.business_name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $business->name) }}"
                                placeholder="{{ __('app.your_business_name') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                            @error('name') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.business_slug') }}</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-gray-500">yoursite.com/</span>
                                <input type="text" name="slug" value="{{ old('slug', $business->slug) }}"
                                    placeholder="business-slug"
                                    class="w-full pl-48 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                            </div>
                            <p class="text-gray-600 text-xs mt-2">{{ __('app.slug_hint') }}</p>
                            @error('slug') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Location & Preferences Section -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('app.location_preferences') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Country -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.country') }}</label>
                            <select name="country"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="OM" @selected(old('country', $business->country) === 'OM')>🇴🇲 Oman (OM)
                                </option>
                                <option value="SA" @selected(old('country', $business->country) === 'SA')>🇸🇦 Saudi
                                    Arabia (SA)</option>
                            </select>
                            @error('country') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Default Language -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.default_language') }}</label>
                            <select name="default_language"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="en" @selected(old('default_language', $business->default_language) === 'en')>English</option>
                                <option value="ar" @selected(old('default_language', $business->default_language) === 'ar')>العربية</option>
                            </select>
                            @error('default_language') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Timezone -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.timezone') }}</label>
                            <select name="timezone"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="Asia/Muscat" @selected(old('timezone', $business->timezone) === 'Asia/Muscat')>Asia/Muscat (GMT+4)</option>
                                <option value="Asia/Riyadh" @selected(old('timezone', $business->timezone) === 'Asia/Riyadh')>Asia/Riyadh (GMT+3)</option>
                            </select>
                            @error('timezone') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Currency -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.currency') }}</label>
                            <select name="currency"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="OMR" @selected(old('currency', $business->currency) === 'OMR')>OMR - Omani
                                    Rial</option>
                                <option value="SAR" @selected(old('currency', $business->currency) === 'SAR')>SAR - Saudi
                                    Riyal</option>
                            </select>
                            @error('currency') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('app.contact_information') }}</h3>

                    <div class="space-y-6">
                        <!-- Phone -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.phone_number') }}</label>
                            <input type="tel" name="phone" value="{{ old('phone', $business->phone) }}"
                                placeholder="+968 XXXX XXXX"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                            @error('phone') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.address') }}</label>
                            <textarea name="address" rows="3" placeholder="{{ __('app.your_business_address') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('address', $business->address) }}</textarea>
                            @error('address') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition">
                        {{ __('app.cancel') }}
                    </a>
                    <button type="submit"
                        class="px-8 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ __('app.save_changes') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>