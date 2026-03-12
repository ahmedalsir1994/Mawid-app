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
                            <label for="logoFileInput" class="flex items-center gap-3 cursor-pointer group mt-1">
                                <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg border-2 border-dashed border-gray-300 group-hover:border-green-400 group-hover:bg-green-50 transition-all bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-600 group-hover:text-green-700 transition-colors">{{ $business->logo ? 'Change logo' : 'Upload logo' }}</span>
                                </div>
                                <span id="logoFileName" class="text-sm text-gray-400 italic truncate max-w-xs">No file chosen</span>
                            </label>
                            <input lang="en" dir="ltr" type="file" name="logo" id="logoFileInput" accept="image/*"
                                class="sr-only" onchange="logoFileSelected(this)" />
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

                <!-- Gallery Images Section -->
                @php
                    $gallery = $business->gallery_images ?? [null, null, null];
                    while (count($gallery) < 3) $gallery[] = null;
                @endphp
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Gallery Images</h3>
                    <p class="text-sm text-gray-500 mb-4">Upload 3 photos to showcase your business. All 3 are required before saving.</p>

                    @error('gallery')
                        <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <div id="galleryError" class="hidden mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span id="galleryErrorMsg">Please upload all 3 gallery photos before saving.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach([1, 2, 3] as $slot)
                            @php $img = $gallery[$slot - 1] ?? null; @endphp
                            <div>
                                <p class="text-xs font-semibold text-gray-600 mb-2">Photo {{ $slot }}</p>

                                {{-- Card: single element, toggled by JS between empty/filled states --}}
                                <div id="galleryCard{{ $slot }}"
                                     class="relative w-full h-40 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 bg-gray-50 cursor-pointer transition-colors hover:border-green-400 hover:bg-green-50"
                                     onclick="document.getElementById('galleryInput{{ $slot }}').click()"
                                     ondragover="event.preventDefault(); this.classList.add('!border-green-500','!bg-green-100')"
                                     ondragleave="this.classList.remove('!border-green-500','!bg-green-100')"
                                     ondrop="galleryDrop(event, {{ $slot }})">

                                    {{-- Empty placeholder --}}
                                    <div id="galleryEmpty{{ $slot }}" class="absolute inset-0 flex flex-col items-center justify-center gap-1 pointer-events-none {{ $img ? 'hidden' : '' }}">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <span class="text-xs text-gray-500 font-medium">Click or drag photo</span>
                                        <span class="text-[11px] text-gray-400">JPG · PNG · WebP · max 2 MB</span>
                                    </div>

                                    {{-- Preview image (hidden until a file is picked or already saved) --}}
                                    <img id="galleryPreview{{ $slot }}"
                                         src="{{ $img ? asset($img) : '' }}"
                                         alt="Photo {{ $slot }}"
                                         class="absolute inset-0 w-full h-full object-cover {{ $img ? '' : 'hidden' }}">

                                    {{-- Remove button (only visible when a photo is present) --}}
                                    <button type="button" id="galleryRemoveBtn{{ $slot }}"
                                        class="absolute top-2 right-2 w-7 h-7 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow transition {{ $img ? '' : 'hidden' }}"
                                        onclick="event.stopPropagation(); galleryRemove({{ $slot }}, '{{ route('admin.business.gallery.remove', $slot) }}', {{ $img ? 'true' : 'false' }})"
                                        title="Remove">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Filename shown after picking a new file --}}
                                <p id="galleryName{{ $slot }}" class="hidden mt-1.5 text-xs text-gray-500 truncate px-0.5"></p>

                                <input type="file" id="galleryInput{{ $slot }}" name="gallery_image_{{ $slot }}"
                                       accept="image/jpeg,image/jpg,image/png,image/webp"
                                       class="hidden" onchange="galleryPick({{ $slot }}, this)">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Services & Images Section -->
                @php
                    $bizServices = \App\Models\Service::where('business_id', $business->id)
                        ->with('images')
                        ->orderBy('name')->get();
                @endphp
                @if($bizServices->isNotEmpty())
                <div class="border-b border-gray-200 pb-8">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-lg font-bold text-gray-800">Services &amp; Photos</h3>
                        <a href="{{ route('admin.services.index') }}" class="text-xs font-semibold text-green-700 hover:underline">Manage services →</a>
                    </div>
                    <p class="text-sm text-gray-500 mb-5">Each service displays its own photos on the public page. Click a service to add or change its photos.</p>
                    <div class="space-y-3">
                        @foreach($bizServices as $svc)
                            @php
                                $svcImages = $svc->images;
                                $firstImg  = $svcImages->first();
                            @endphp
                            <div class="flex items-center gap-4 p-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white transition">
                                {{-- Thumbnail --}}
                                <div class="shrink-0 w-16 h-16 rounded-lg overflow-hidden border border-gray-200 bg-white">
                                    @if($firstImg)
                                        <img src="{{ asset($firstImg->path) }}" alt="{{ $svc->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $svc->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $svcImages->count() }} photo{{ $svcImages->count() !== 1 ? 's' : '' }}
                                        &middot; {{ $svc->duration_minutes }} min
                                        @if($svc->price !== null) &middot; {{ number_format($svc->price, 2) }} {{ $business->currency }} @endif
                                    </p>
                                    {{-- Mini strip of images --}}
                                    @if($svcImages->count() > 1)
                                        <div class="mt-2 flex gap-1.5">
                                            @foreach($svcImages->take(5) as $si)
                                                <img src="{{ asset($si->path) }}" class="w-8 h-8 rounded object-cover border border-gray-100">
                                            @endforeach
                                            @if($svcImages->count() > 5)
                                                <div class="w-8 h-8 rounded bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                                    +{{ $svcImages->count() - 5 }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                {{-- Edit link --}}
                                <a href="{{ route('admin.services.edit', $svc) }}"
                                   class="shrink-0 px-3 py-1.5 rounded-lg border border-gray-300 text-xs font-semibold text-gray-700 hover:bg-gray-100 transition">
                                    Edit photos
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

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

            <script>
            /* ── Gallery: pick file from input ── */
            function galleryPick(slot, input) {
                if (!input.files || !input.files[0]) return;
                const file      = input.files[0];

                if (file.size > 2 * 1024 * 1024) {
                    alert('Photo ' + slot + ' exceeds the 2 MB size limit. Please choose a smaller image.');
                    input.value = '';
                    return;
                }

                const preview   = document.getElementById('galleryPreview'   + slot);
                const empty     = document.getElementById('galleryEmpty'     + slot);
                const removeBtn = document.getElementById('galleryRemoveBtn' + slot);
                const nameEl    = document.getElementById('galleryName'      + slot);

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    empty.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);

                if (nameEl) {
                    nameEl.textContent = file.name;
                    nameEl.classList.remove('hidden');
                }

                checkGalleryError();
            }

            /* ── Gallery: remove a slot (saved = AJAX, unsaved = local reset) ── */
            function galleryRemove(slot, url, isSaved) {
                if (isSaved) {
                    if (!confirm('Remove this photo?')) return;
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(r) { return r.json(); })
                    .then(function(data) { if (data.ok) galleryReset(slot); })
                    .catch(function() { alert('Could not remove the photo. Please try again.'); });
                } else {
                    galleryReset(slot);
                }
            }

            function galleryReset(slot) {
                const preview   = document.getElementById('galleryPreview'   + slot);
                const empty     = document.getElementById('galleryEmpty'     + slot);
                const removeBtn = document.getElementById('galleryRemoveBtn' + slot);
                const nameEl    = document.getElementById('galleryName'      + slot);
                const inputEl   = document.getElementById('galleryInput'     + slot);
                preview.classList.add('hidden');
                preview.src = '';
                empty.classList.remove('hidden');
                removeBtn.classList.add('hidden');
                if (nameEl)  { nameEl.classList.add('hidden'); nameEl.textContent = ''; }
                if (inputEl) inputEl.value = '';
            }

            /* ── Gallery: drag-and-drop ── */
            function galleryDrop(event, slot) {
                event.preventDefault();
                const card = document.getElementById('galleryCard' + slot);
                if (card) card.classList.remove('!border-green-500', '!bg-green-50');
                const input = document.getElementById('galleryInput' + slot);
                if (event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files[0]) {
                    const dt = new DataTransfer();
                    dt.items.add(event.dataTransfer.files[0]);
                    input.files = dt.files;
                    galleryPick(slot, input);
                }
            }

            /* ── Gallery: show/hide error banner ── */
            function checkGalleryError() {
                var allFilled = [1, 2, 3].every(function(s) {
                    var p = document.getElementById('galleryPreview' + s);
                    return p && !p.classList.contains('hidden') && p.src && p.src !== window.location.href;
                });
                if (allFilled) {
                    var err = document.getElementById('galleryError');
                    if (err) err.classList.add('hidden');
                }
            }

            /* ── Logo file-picker display ── */
            function logoFileSelected(input) {
                var nameEl = document.getElementById('logoFileName');
                if (nameEl && input.files && input.files[0]) {
                    nameEl.textContent = input.files[0].name;
                    nameEl.classList.remove('text-gray-400', 'italic');
                    nameEl.classList.add('text-green-700', 'font-medium');
                }
            }

            /* ── Form submit: validate all 3 gallery slots filled ── */
            (function () {
                var form = document.querySelector('form[action="{{ route('admin.business.update') }}"]');
                if (!form) return;
                form.addEventListener('submit', function(e) {
                    var emptySlots = [1, 2, 3].filter(function(s) {
                        var p = document.getElementById('galleryPreview' + s);
                        return !p || p.classList.contains('hidden') || !p.src || p.src === window.location.href;
                    });
                    if (emptySlots.length > 0) {
                        e.preventDefault();
                        var err = document.getElementById('galleryError');
                        var msg = document.getElementById('galleryErrorMsg');
                        if (err && msg) {
                            msg.textContent = 'Please upload a photo for slot ' + emptySlots.join(', ') + ' before saving.';
                            err.classList.remove('hidden');
                            err.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
            })();
            </script>
        </div>
    </div>
</x-admin-layout>