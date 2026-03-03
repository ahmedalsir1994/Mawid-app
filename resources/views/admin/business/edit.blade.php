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
                            <input lang="en" dir="ltr" type="file" name="logo" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            <p class="text-gray-600 text-xs mt-2">{{ __('app.upload_logo_hint') }}</p>
                            @error('logo') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Business Name -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.business_name') }}</label>
                            <input lang="en" dir="ltr" type="text" name="name" value="{{ old('name', $business->name) }}"
                                placeholder="{{ __('app.your_business_name') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            @error('name') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.business_slug') }}</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-gray-500">mawid.om/</span>
                                <input lang="en" dir="ltr" type="text" name="slug" id="slugInput" value="{{ old('slug', $business->slug) }}"
                                    placeholder="business-slug"
                                    class="w-full pl-28 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            </div>
                            <p class="text-gray-600 text-xs mt-2">{{ __('app.slug_hint') }}</p>
                            @error('slug') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror

                            <!-- Public Booking Link -->
                            <div class="mt-3">
                                <p class="text-xs font-semibold text-gray-600 mb-1">{{ __('app.public_booking_link') ?? 'Public Booking Link' }}</p>
                                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <span id="publicLinkDisplay" class="flex-1 text-sm text-gray-700 truncate select-all">{{ url('/') }}/{{ old('slug', $business->slug) }}</span>
                                    <button type="button" id="copyLinkBtn" onclick="copyBookingLink()"
                                        class="shrink-0 flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 transition">
                                        <svg id="copyIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span id="copyBtnText">Copy</span>
                                    </button>
                                    <a id="openLinkBtn" href="{{ url('/') }}/{{ old('slug', $business->slug) }}" target="_blank"
                                        class="shrink-0 flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Open
                                    </a>
                                </div>
                            </div>
                        </div>

                        <script>
                            (function () {
                                const base = '{{ url('/') }}/';
                                const slugInput = document.getElementById('slugInput');
                                const display = document.getElementById('publicLinkDisplay');
                                const openBtn = document.getElementById('openLinkBtn');

                                slugInput.addEventListener('input', function () {
                                    const full = base + this.value;
                                    display.textContent = full;
                                    openBtn.href = full;
                                });

                                window.copyBookingLink = function () {
                                    const text = document.getElementById('publicLinkDisplay').textContent;
                                    navigator.clipboard.writeText(text).then(() => {
                                        const btn = document.getElementById('copyBtnText');
                                        const icon = document.getElementById('copyIcon');
                                        btn.textContent = 'Copied!';
                                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
                                        setTimeout(() => {
                                            btn.textContent = 'Copy';
                                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>';
                                        }, 2000);
                                    });
                                };
                            })();
                        </script>
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
                            <select lang="en" dir="ltr" name="country"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="OM" @selected(old('country', $business->country) === 'OM')>🇴🇲 Oman (OM)
                                </option>
                             
                            </select>
                            @error('country') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Default Language -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.default_language') }}</label>
                            <select lang="en" dir="ltr" name="default_language"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="en" @selected(old('default_language', $business->default_language) === 'en')>English</option>
                                <option value="ar" @selected(old('default_language', $business->default_language) === 'ar')>العربية</option>
                            </select>
                            @error('default_language') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Timezone -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.timezone') }}</label>
                            <select lang="en" dir="ltr" name="timezone"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="Asia/Muscat" @selected(old('timezone', $business->timezone) === 'Asia/Muscat')>Asia/Muscat (GMT+4)</option>
                            </select>
                            @error('timezone') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Currency -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.currency') }}</label>
                            <select lang="en" dir="ltr" name="currency"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="OMR" @selected(old('currency', $business->currency) === 'OMR')>OMR - Omani
                                    Rial</option>
                                
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
                            <input lang="en" dir="ltr" type="tel" name="phone" value="{{ old('phone', $business->phone) }}"
                                placeholder="+968 XXXX XXXX"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            @error('phone') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.address') }}</label>
                            <textarea lang="en" dir="ltr" name="address" rows="3" placeholder="{{ __('app.your_business_address') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('address', $business->address) }}</textarea>
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
                        class="px-8 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-600 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
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