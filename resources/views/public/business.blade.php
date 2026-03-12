<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $business->name }}</title>
    <link rel="icon" href="{{ asset('/images/Mawidly-fav.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [dir="rtl"] body { font-family: 'Cairo', sans-serif; }
        .slot-btn { transition: all .15s ease; }
        .slot-btn.selected { background: #16a34a; color: #fff; border-color: #16a34a; }
        .slot-btn:not(.selected):hover { border-color: #16a34a; background:#f0fdf4; }
        .service-row { transition: background .15s ease; }
        .service-row:hover { background: #f9fafb; }
        #bookingModal { transition: opacity .25s ease; }
        #bookingModal.hidden { display:none; }
        #bookingDrawer { transition: transform .3s cubic-bezier(.4,0,.2,1); }
        @media (min-width: 1024px) { .sidebar-sticky { position: sticky; top: 1.5rem; } }
        .cover-gradient { background: linear-gradient(135deg, #14532d 0%, #166534 50%, #15803d 100%); }

        /* Gallery */
        .gallery-img { transition: transform .3s ease, filter .3s ease; }
        .gallery-img:hover { transform: scale(1.03); filter: brightness(.9); }

        /* Lightbox */
        #lightbox { transition: opacity .2s ease; }
        #lightbox.hidden { display:none; }
        #lightboxImg { transition: opacity .2s ease; }

        /* Service detail modal */
        #svcDetailModal { transition: opacity .2s ease; }
        #svcDetailModal.hidden { display:none; }
    </style>
</head>

<body class="bg-gray-100 antialiased">

    {{-- NAVBAR --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between gap-4 relative">
            {{-- LEFT: business logo + name --}}
            <div class="flex items-center gap-3 shrink-0">
                @if($business->logo)
                    <img src="{{ asset($business->logo) }}" alt="{{ $business->name }}" class="h-8 w-auto rounded">
                @else
                    <div class="h-8 w-8 rounded bg-green-700 flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ strtoupper(substr($business->name,0,1)) }}</span>
                    </div>
                @endif
                <span class="font-semibold text-gray-900 text-sm hidden sm:block">{{ $business->name }}</span>
            </div>

            {{-- CENTER: Mawid platform branding --}}
            <a href="{{ route('landing') }}"
               class="absolute left-1/2 -translate-x-1/2 flex items-center gap-1.5 opacity-80 hover:opacity-100 transition-opacity"
               title="Powered by Mawid">
                <img src="/images/Mawid.png" alt="Mawid" class="h-7 w-auto">
            </a>

            {{-- RIGHT: home + language --}}
            <div class="flex items-center gap-2">
                {{-- Home button --}}
                <a href="{{ route('landing') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-green-600 bg-white text-xs font-semibold text-green-700 hover:bg-green-600 hover:text-white transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="hidden sm:inline">{{ __('app.home') }}</span>
                </a>

                {{-- Language toggle --}}
                <div class="flex rounded-lg border border-gray-200 overflow-hidden text-xs font-semibold shadow-sm">
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="px-3 py-1.5 transition-colors {{ app()->getLocale() === 'en' ? 'bg-gray-900 text-white' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">EN</a>
                    <span class="w-px bg-gray-200 self-stretch"></span>
                    <a href="{{ route('lang.switch', 'ar') }}"
                       class="px-3 py-1.5 transition-colors {{ app()->getLocale() === 'ar' ? 'bg-gray-900 text-white' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">AR</a>
                </div>
            </div>
        </div>
    </header>

    {{-- HERO --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Photo gallery: business gallery images first, then service images as fallback --}}
            @php
                // 1. Use business-level gallery images if any are set
                $bizGallery = array_filter($business->gallery_images ?? []);
                if (!empty($bizGallery)) {
                    $galleryImages = collect(array_values($bizGallery))
                        ->map(fn($p) => (object)['path' => $p, 'alt' => $business->name]);
                } else {
                    // Fallback: service images
                    $galleryImages = $services->flatMap(fn($s) => $s->images)->values();
                    if ($galleryImages->isEmpty()) {
                        $galleryImages = $services
                            ->filter(fn($s) => $s->image)
                            ->map(fn($s) => (object)['path' => $s->image, 'alt' => $s->name])
                            ->values();
                    }
                }
                $hasGallery = $galleryImages->count() > 0;
            @endphp

            @if($hasGallery)
                <div class="relative w-full h-FULL rounded-b-xl overflow-hidden bg-gray-100">
                    <div class="h-full grid {{ $galleryImages->count() >= 3 ? 'grid-cols-3' : ($galleryImages->count() === 2 ? 'grid-cols-2' : 'grid-cols-1') }} gap-1 ">

                        {{-- Big left image --}}
                        <div class="{{ $galleryImages->count() >= 2 ? 'col-span-2' : 'col-span-1' }} relative overflow-hidden cursor-pointer"
                            onclick="openLightbox(0)">
                            <img src="{{ asset($galleryImages[0]->path) }}"
                                alt=""
                                class="gallery-img w-full h-full object-cover">
                        </div>

                        {{-- Right column: up to 2 stacked images --}}
                        @if($galleryImages->count() >= 2)
                            <div class="col-span-1 flex flex-col gap-1 h-full">
                                <div class="flex-1 relative overflow-hidden cursor-pointer" onclick="openLightbox(1)">
                                    <img src="{{ asset($galleryImages[1]->path) }}"
                                        alt=""
                                        class="gallery-img w-full h-full object-cover">
                                </div>
                                @if($galleryImages->count() >= 3)
                                    <div class="flex-1 relative overflow-hidden cursor-pointer" onclick="openLightbox(2)">
                                        <img src="{{ asset($galleryImages[2]->path) }}"
                                            alt=""
                                            class="gallery-img w-full h-full object-cover">
                                        @if($galleryImages->count() > 3)
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center"
                                                onclick="event.stopPropagation(); openLightbox(2)">
                                                <span class="text-white text-sm font-semibold">+{{ $galleryImages->count() - 3 }} {{ __('app.more_photos') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- See all button --}}
                    @if($galleryImages->count() > 1)
                        <button type="button" onclick="openLightbox(0)"
                            class="absolute bottom-3 right-3 flex items-center gap-1.5 bg-white/90 backdrop-blur-sm border border-white/60 shadow-md px-3 py-1.5 rounded-lg text-xs font-semibold text-gray-800 hover:bg-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ __('app.see_all_images') }}
                        </button>
                    @endif
                </div>
            @else
                {{-- Fallback gradient if no service images yet --}}
                <div class="relative h-52 sm:h-64 w-full rounded-b-xl overflow-hidden cover-gradient">
                    @if($business->logo)
                        <img src="{{ asset($business->logo) }}" alt="{{ $business->name }}"
                            class="absolute inset-0 h-full w-full object-cover opacity-20">
                    @endif
                </div>
            @endif
            <div class="py-5">
                <h1 class="text-2xl font-bold text-gray-900">{{ $business->name }}</h1>
                <div class="mt-1.5 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500">
                    @if($business->address)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($business->address) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-1 text-green-700 underline underline-offset-2 hover:text-green-900 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $business->address }}
                        </a>
                    @endif
                    @if($business->phone)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $business->phone }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- LEFT --}}
            <div class="flex-1 min-w-0 space-y-8">

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <p class="text-sm font-semibold text-red-800 mb-1">{{ __("app.error") }}</p>
                        <ul class="text-sm text-red-700 list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($bookingLimitReached))
                    <div class="bg-amber-50 border border-amber-300 rounded-xl p-5 flex items-start gap-4">
                        <div class="shrink-0 w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-amber-900 text-sm">{{ __('app.booking_limit_title') }}</p>
                            <p class="text-amber-800 text-sm mt-0.5">{{ __('app.booking_limit_message') }}</p>
                            @if($business->phone)
                                <a href="tel:{{ $business->phone }}" class="inline-flex items-center gap-1.5 mt-3 text-sm font-semibold text-amber-900 underline underline-offset-2 hover:text-amber-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ __('app.call') }} {{ $business->phone }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- CATEGORY TABS --}}
                @php
                    $categories = $business->serviceCategories()->orderBy('name')->get();
                @endphp
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 pt-4 pb-2 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">{{ __("app.select_service") }}</h2>
                        <div class="mt-3 flex flex-wrap gap-2" id="categoryTabs">
                            <button type="button" onclick="filterCategory('featured')"
                                data-cat="featured"
                                class="cat-tab px-4 py-2 rounded-full text-sm font-semibold border transition {{ $selectedCategory === 'featured' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-green-700 border-green-600 hover:bg-green-50' }}">{{ __('app.featured') }}</button>
                            @foreach($categories as $cat)
                                <button type="button" onclick="filterCategory('{{ $cat->id }}')"
                                    data-cat="{{ $cat->id }}"
                                    class="cat-tab px-4 py-2 rounded-full text-sm font-semibold border transition {{ $selectedCategory == $cat->id ? 'bg-green-600 text-white border-green-600' : 'bg-white text-green-700 border-green-600 hover:bg-green-50' }}">{{ $cat->name }}</button>
                            @endforeach
                        </div>
                    </div>
                    @if($services->isEmpty() && $categories->isEmpty())
                        <div id="svcEmptyState" class="px-6 py-14 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            @php
                                $isOwner = auth()->check()
                                    && auth()->user()->business_id === $business->id
                                    && in_array(auth()->user()->role, ['company_admin', 'super_admin']);
                            @endphp
                            @if($isOwner)
                                <p class="font-semibold text-gray-800 text-base">No services added yet.</p>
                                <p class="text-sm text-gray-500 mt-1 mb-5">Add your first service so customers can start booking.</p>
                                <a href="{{ route('admin.services.create') }}"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Your First Service
                                </a>
                            @else
                                <p class="font-medium text-gray-600">{{ __("app.no_services_available") ?? "No services available yet." }}</p>
                                <p class="text-sm text-gray-400 mt-1">{{ __("app.please_check_back_later") ?? "Please check back later." }}</p>
                            @endif
                        </div>
                    @else
                        <ul id="svcList" class="divide-y divide-gray-100">
                            @foreach($services as $s)
                                <li class="service-row px-6 py-4 flex items-start gap-4 cursor-pointer"
                                    id="svcRow{{ $s->id }}"
                                    data-svc-id="{{ $s->id }}"
                                    data-svc-name="{{ $s->name }}"
                                    data-svc-duration="{{ $s->duration_minutes }}"
                                    data-svc-price="{{ $s->price ?? 0 }}"
                                    data-category-id="{{ $s->service_category_id ?? '' }}"
                                    data-svc-images='@json($s->images->map(fn($img) => asset($img->path))->values())'
                                    data-svc-desc="{{ $s->description ?? '' }}"
                                    onclick="openSvcDetail({{ $s->id }}, event)">
                                    <div class="shrink-0">
                                        @if($s->primaryImage)
                                            <img src="{{ asset($s->primaryImage) }}" alt="{{ $s->name }}"
                                                class="w-14 h-14 rounded-lg object-cover border border-gray-100">
                                        @else
                                            <div class="w-14 h-14 rounded-lg bg-green-50 border border-green-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900">{{ $s->name }}</p>
                                        <p class="text-sm text-gray-500 mt-0.5">
                                            {{ $s->duration_minutes }} {{ __("app.minutes") ?? "min" }}
                                            @if($s->price)
                                                &nbsp;&middot;&nbsp;
                                                <span class="font-medium text-gray-700">{{ number_format($s->price, 2) }} {{ $business->currency }}</span>
                                            @endif
                                        </p>
                                        @if($s->description)
                                            <p id="svcDesc{{ $s->id }}" class="text-xs text-gray-400 mt-1 line-clamp-3">{{ $s->description }}</p>
                                            <button type="button" id="svcDescBtn{{ $s->id }}"
                                                onclick="event.stopPropagation(); toggleSvcDesc({{ $s->id }})"
                                                class="text-xs text-green-600 font-medium mt-0.5 hover:underline leading-none">
                                                {{ __('app.read_more') ?? 'Read more' }}
                                            </button>
                                        @endif
                                    </div>
                                    @if(!empty($bookingLimitReached))
                                        <span class="shrink-0 px-5 py-2 rounded-full border border-gray-200 text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed select-none">
                                            {{ __('app.unavailable') }}
                                        </span>
                                    @else
                                        <button type="button"
                                            id="svcSelectBtn{{ $s->id }}"
                                            class="svc-select-btn shrink-0 px-4 py-2 rounded-full border border-gray-300 text-sm font-semibold text-gray-700 hover:border-green-600 hover:text-green-700 hover:bg-green-50 transition whitespace-nowrap"
                                            onclick="event.stopPropagation(); toggleMainSvc({{ $s->id }}, this)">
                                            + {{ __('app.select') ?? 'Select' }}
                                        </button>
                                    @endif
                                </li>
                            @endforeach
                            <li id="svcNoResults" class="hidden px-6 py-10 text-center text-gray-500 text-sm">
                                {{ __('app.no_services_available') }}
                            </li>
                        </ul>
                    @endif
                </div>

              

                {{-- TEAM SECTION --}}
                @if(isset($teamMembers) && $teamMembers->isNotEmpty())
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">{{ __('app.team') ?? 'Team' }}</h2>
                    </div>
                    <div class="px-6 py-5 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-5">
                        @foreach($teamMembers as $member)
                        <div class="flex flex-col items-center text-center">
                            @if($member->photo)
                                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}"
                                    class="w-16 h-16 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                            @else
                                <div class="w-16 h-16 rounded-full bg-emerald-100 border-2 border-emerald-200 flex items-center justify-center shadow-sm">
                                    <span class="text-emerald-700 font-bold text-xl leading-none">{{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <p class="mt-2 text-sm font-semibold text-gray-900 leading-tight line-clamp-2">{{ $member->name }}</p>
                            @if($member->title)
                                <p class="text-xs text-gray-500 mt-0.5">{{ $member->title }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>


            

            {{-- RIGHT SIDEBAR --}}
            <div class="w-full lg:w-80 shrink-0 sidebar-sticky">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5">
                        <h3 class="text-lg font-bold text-gray-900">{{ $business->name }}</h3>
                        @if($business->address)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($business->address) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="mt-3 flex items-start gap-2 text-sm text-green-700 underline underline-offset-2 hover:text-green-900 transition">
                                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $business->address }}
                            </a>
                        @endif
                        @if($business->phone)
                            <p class="mt-2 flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $business->phone }}
                            </p>
                        @endif
                    </div>
                    @if(!$services->isEmpty())
                        <div class="px-6 pb-5">
                            @if(!empty($bookingLimitReached))
                                <div class="w-full py-3 rounded-xl bg-gray-100 text-gray-400 text-center font-semibold text-sm cursor-not-allowed select-none">
                                    {{ __("app.bookings_unavailable") }}
                                </div>
                            @else
                                <button type="button" onclick="openBookingModal(null)"
                                    class="w-full py-3 rounded-xl bg-gray-900 text-white font-semibold text-sm hover:bg-gray-800 active:scale-95 transition">
                                    {{ __("app.book_now") ?? "Book now" }}
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            

        </div>
        
        <div class="flex py-4 items-center justify-center">
                    <p class="text-center text-xs text-gray-400">
                    &check; {{ __("app.secure_booking") ?? "Secure booking" }} &nbsp;&middot;&nbsp;
                    &check; {{ __("app.instant_confirmation") ?? "Instant confirmation" }} &nbsp;&middot;&nbsp;
                    &check; {{ __("app.whatsapp_reminder") ?? "WhatsApp reminder" }}
                </p>
        </div>
    </div>

    {{-- SERVICE SELECTION BAR --}}
    <div id="svcSelBar" class="hidden fixed bottom-0 inset-x-0 z-40 bg-white border-t border-gray-200 shadow-[0_-4px_20px_rgba(0,0,0,0.08)]">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="font-semibold text-gray-900 text-sm" id="selBarCount"></p>
                <p class="text-xs text-gray-500 mt-0.5" id="selBarDetails"></p>
            </div>
            <button type="button" onclick="proceedWithSelected()"
                class="shrink-0 px-6 py-2.5 bg-gray-900 text-white font-semibold text-sm rounded-xl hover:bg-gray-800 active:scale-95 transition">
                {{ __('app.book_now') ?? 'Book Now' }} &rarr;
            </button>
        </div>
    </div>

    {{-- BOOKING MODAL --}}
    <div id="bookingModal" class="hidden fixed inset-0 z-50 flex justify-end" aria-modal="true">
        <div id="modalBackdrop" class="absolute inset-0 bg-black/50" onclick="closeBookingModal()"></div>
        <div id="bookingDrawer"
            class="relative w-full max-w-lg h-full bg-white shadow-2xl flex flex-col overflow-hidden translate-x-full">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
                <h2 class="text-lg font-bold text-gray-900">{{ __("app.book_appointment") }}</h2>
                <button type="button" onclick="closeBookingModal()"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-6 py-5 space-y-6">

                {{-- Branch selector (only shown when business has multiple branches) --}}
                @if(isset($branches) && $branches->count() > 1)
                <div id="branchSection">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">{{ __("app.select_branch") ?? "Select Branch" }}</p>
                    <div class="space-y-2" id="modalBranchList">
                        @foreach($branches as $br)
                            <label class="flex items-start gap-3 p-3 rounded-lg border-2 border-gray-200 cursor-pointer has-[:checked]:border-green-600 has-[:checked]:bg-green-50 transition">
                                <input type="radio" name="modal_branch" class="modal-branch-radio mt-1"
                                    value="{{ $br->id }}"
                                    data-services='@json($br->services->pluck("id"))'>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900">{{ $br->name }}</p>
                                    @if($br->address)
                                        <p class="text-xs text-gray-500 mt-0.5">📍 {{ $br->address }}</p>
                                    @endif
                                    @if($br->phone)
                                        <p class="text-xs text-gray-400 mt-0.5">📞 {{ $br->phone }}</p>
                                    @endif
                                </div>
                                <svg class="branch-check w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20" style="opacity:0">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Service --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">{{ __("app.select_service") }}</p>
                    <div id="modalServiceList" class="space-y-2">
                        @foreach($services as $s)
                            <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-gray-200 cursor-pointer has-[:checked]:border-green-600 has-[:checked]:bg-green-50 transition">
                                <input type="checkbox" name="modal_service" class="modal-service-checkbox w-4 h-4 rounded accent-green-600"
                                    value="{{ $s->id }}" data-name="{{ $s->name }}" data-duration="{{ $s->duration_minutes }}" data-price="{{ $s->price ?? 0 }}">
                                @if($s->primaryImage)
                                    <img src="{{ asset($s->primaryImage) }}" class="w-10 h-10 rounded-md object-cover shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-md bg-green-50 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900">{{ $s->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $s->duration_minutes }} {{ __("app.minutes") ?? "min" }}
                                        @if($s->price) &middot; {{ number_format($s->price,2) }} {{ $business->currency }} @endif
                                    </p>
                                    @if($s->description)
                                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">{{ $s->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    {{-- Multi-service total --}}
                    <div id="serviceTotalBar" class="hidden mt-3 bg-green-50 border border-green-200 rounded-lg px-4 py-2 text-sm text-green-800 flex items-center justify-between">
                        <span id="serviceTotalLabel" class="font-medium"></span>
                        <button type="button" onclick="clearServiceSelection()" class="text-xs text-gray-400 hover:text-red-500 transition ml-3">✕ {{ __('app.clear') }}</button>
                    </div>
                </div>

                {{-- Date --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">{{ __("app.select_date") }}</p>
                    <input type="date" id="modalDate"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"/>
                </div>

                {{-- Staff --}}
                <div id="modalStaffSection" class="hidden">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">{{ __("app.select_staff_optional") ?? "Staff (optional)" }}</p>
                    <div id="modalStaffFilter" class="flex flex-wrap gap-3"></div>
                </div>

                {{-- Slots --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">{{ __("app.available_times") }}</p>
                    <div id="modalSlotsLoading" class="hidden text-center py-4">
                        <svg class="w-5 h-5 text-green-600 mx-auto animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                    </div>
                    <div id="modalSlots" class="grid grid-cols-3 sm:grid-cols-4 gap-2"></div>
                    <p id="modalNoSlots" class="text-sm text-center text-gray-500 py-4 hidden">
                        {{ __("app.no_available_slots") ?? "No available slots for this date." }}
                    </p>
                    <div id="modalTimeOffNotice" class="hidden rounded-xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-900">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                            </svg>
                            <div>
                                <p class="font-semibold">{{ __("app.day_off") ?? "Day Off" }}</p>
                                <p id="timeOffNoteText" class="mt-0.5 text-amber-800"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div id="modalSummary" class="hidden bg-green-50 border border-green-200 rounded-lg p-4 text-sm text-green-900">
                    <p class="font-semibold" id="sumService"></p>
                    <p class="text-green-700 text-xs mt-0.5 flex items-center gap-1" id="sumStaff"></p>
                    <p class="font-medium mt-1" id="sumDateTime"></p>
                    <p class="text-xs text-green-700 mt-0.5" id="sumBranch" style="display:none"></p>
                </div>

                {{-- Customer form --}}
                <form id="bookingForm" method="POST" action="{{ route('public.book', $business->slug) }}"
                    class="hidden space-y-4">
                    @csrf
                    <input type="hidden" name="branch_id" id="hidden_branch_id">
                    <div id="hidden_service_ids_container"></div>
                    <input type="hidden" name="staff_user_id" id="hidden_staff_user_id">
                    <input type="hidden" name="date" id="hidden_date">
                    <input type="hidden" name="start_time" id="hidden_start_time">

                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ __("app.your_details") ?? "Your details" }}</p>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __("app.full_name") }} *</label>
                        <input type="text" name="customer_name" value="{{ old("customer_name") }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="{{ __("app.full_name") }}" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __("app.country") }} *</label>
                        <select name="customer_country"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white" required>
                            <option value="">{{ __("app.select_a_country") }}</option>
                            @php
                                $countries = [
                                    'AF' => 'Afghanistan',
                                    'AL' => 'Albania',
                                    'DZ' => 'Algeria',
                                    'AD' => 'Andorra',
                                    'AO' => 'Angola',
                                    'AG' => 'Antigua and Barbuda',
                                    'AR' => 'Argentina',
                                    'AM' => 'Armenia',
                                    'AU' => 'Australia',
                                    'AT' => 'Austria',
                                    'AZ' => 'Azerbaijan',
                                    'BS' => 'Bahamas',
                                    'BH' => 'Bahrain',
                                    'BD' => 'Bangladesh',
                                    'BB' => 'Barbados',
                                    'BY' => 'Belarus',
                                    'BE' => 'Belgium',
                                    'BZ' => 'Belize',
                                    'BJ' => 'Benin',
                                    'BT' => 'Bhutan',
                                    'BO' => 'Bolivia',
                                    'BA' => 'Bosnia and Herzegovina',
                                    'BW' => 'Botswana',
                                    'BR' => 'Brazil',
                                    'BN' => 'Brunei',
                                    'BG' => 'Bulgaria',
                                    'BF' => 'Burkina Faso',
                                    'BI' => 'Burundi',
                                    'CV' => 'Cabo Verde',
                                    'KH' => 'Cambodia',
                                    'CM' => 'Cameroon',
                                    'CA' => 'Canada',
                                    'CF' => 'Central African Republic',
                                    'TD' => 'Chad',
                                    'CL' => 'Chile',
                                    'CN' => 'China',
                                    'CO' => 'Colombia',
                                    'KM' => 'Comoros',
                                    'CG' => 'Congo',
                                    'CD' => 'Congo (DRC)',
                                    'CR' => 'Costa Rica',
                                    'HR' => 'Croatia',
                                    'CU' => 'Cuba',
                                    'CY' => 'Cyprus',
                                    'CZ' => 'Czech Republic',
                                    'DK' => 'Denmark',
                                    'DJ' => 'Djibouti',
                                    'DM' => 'Dominica',
                                    'DO' => 'Dominican Republic',
                                    'EC' => 'Ecuador',
                                    'EG' => 'Egypt',
                                    'SV' => 'El Salvador',
                                    'GQ' => 'Equatorial Guinea',
                                    'ER' => 'Eritrea',
                                    'EE' => 'Estonia',
                                    'SZ' => 'Eswatini',
                                    'ET' => 'Ethiopia',
                                    'FJ' => 'Fiji',
                                    'FI' => 'Finland',
                                    'FR' => 'France',
                                    'GA' => 'Gabon',
                                    'GM' => 'Gambia',
                                    'GE' => 'Georgia',
                                    'DE' => 'Germany',
                                    'GH' => 'Ghana',
                                    'GR' => 'Greece',
                                    'GD' => 'Grenada',
                                    'GT' => 'Guatemala',
                                    'GN' => 'Guinea',
                                    'GW' => 'Guinea-Bissau',
                                    'GY' => 'Guyana',
                                    'HT' => 'Haiti',
                                    'HN' => 'Honduras',
                                    'HU' => 'Hungary',
                                    'IS' => 'Iceland',
                                    'IN' => 'India',
                                    'ID' => 'Indonesia',
                                    'IR' => 'Iran',
                                    'IQ' => 'Iraq',
                                    'IE' => 'Ireland',
                                    'IT' => 'Italy',
                                    'JM' => 'Jamaica',
                                    'JP' => 'Japan',
                                    'JO' => 'Jordan',
                                    'KZ' => 'Kazakhstan',
                                    'KE' => 'Kenya',
                                    'KI' => 'Kiribati',
                                    'KW' => 'Kuwait',
                                    'KG' => 'Kyrgyzstan',
                                    'LA' => 'Laos',
                                    'LV' => 'Latvia',
                                    'LB' => 'Lebanon',
                                    'LS' => 'Lesotho',
                                    'LR' => 'Liberia',
                                    'LY' => 'Libya',
                                    'LI' => 'Liechtenstein',
                                    'LT' => 'Lithuania',
                                    'LU' => 'Luxembourg',
                                    'MG' => 'Madagascar',
                                    'MW' => 'Malawi',
                                    'MY' => 'Malaysia',
                                    'MV' => 'Maldives',
                                    'ML' => 'Mali',
                                    'MT' => 'Malta',
                                    'MH' => 'Marshall Islands',
                                    'MR' => 'Mauritania',
                                    'MU' => 'Mauritius',
                                    'MX' => 'Mexico',
                                    'FM' => 'Micronesia',
                                    'MD' => 'Moldova',
                                    'MC' => 'Monaco',
                                    'MN' => 'Mongolia',
                                    'ME' => 'Montenegro',
                                    'MA' => 'Morocco',
                                    'MZ' => 'Mozambique',
                                    'MM' => 'Myanmar',
                                    'NA' => 'Namibia',
                                    'NR' => 'Nauru',
                                    'NP' => 'Nepal',
                                    'NL' => 'Netherlands',
                                    'NZ' => 'New Zealand',
                                    'NI' => 'Nicaragua',
                                    'NE' => 'Niger',
                                    'NG' => 'Nigeria',
                                    'KP' => 'North Korea',
                                    'MK' => 'North Macedonia',
                                    'NO' => 'Norway',
                                    'OM' => 'Oman',
                                    'PK' => 'Pakistan',
                                    'PW' => 'Palau',
                                    'PS' => 'Palestine',
                                    'PA' => 'Panama',
                                    'PG' => 'Papua New Guinea',
                                    'PY' => 'Paraguay',
                                    'PE' => 'Peru',
                                    'PH' => 'Philippines',
                                    'PL' => 'Poland',
                                    'PT' => 'Portugal',
                                    'QA' => 'Qatar',
                                    'RO' => 'Romania',
                                    'RU' => 'Russia',
                                    'RW' => 'Rwanda',
                                    'KN' => 'Saint Kitts and Nevis',
                                    'LC' => 'Saint Lucia',
                                    'VC' => 'Saint Vincent and the Grenadines',
                                    'WS' => 'Samoa',
                                    'SM' => 'San Marino',
                                    'ST' => 'Sao Tome and Principe',
                                    'SA' => 'Saudi Arabia',
                                    'SN' => 'Senegal',
                                    'RS' => 'Serbia',
                                    'SC' => 'Seychelles',
                                    'SL' => 'Sierra Leone',
                                    'SG' => 'Singapore',
                                    'SK' => 'Slovakia',
                                    'SI' => 'Slovenia',
                                    'SB' => 'Solomon Islands',
                                    'SO' => 'Somalia',
                                    'ZA' => 'South Africa',
                                    'SS' => 'South Sudan',
                                    'ES' => 'Spain',
                                    'LK' => 'Sri Lanka',
                                    'SD' => 'Sudan',
                                    'SR' => 'Suriname',
                                    'SE' => 'Sweden',
                                    'CH' => 'Switzerland',
                                    'SY' => 'Syria',
                                    'TW' => 'Taiwan',
                                    'TJ' => 'Tajikistan',
                                    'TZ' => 'Tanzania',
                                    'TH' => 'Thailand',
                                    'TL' => 'Timor-Leste',
                                    'TG' => 'Togo',
                                    'TO' => 'Tonga',
                                    'TT' => 'Trinidad and Tobago',
                                    'TN' => 'Tunisia',
                                    'TR' => 'Turkey',
                                    'TM' => 'Turkmenistan',
                                    'TV' => 'Tuvalu',
                                    'UG' => 'Uganda',
                                    'UA' => 'Ukraine',
                                    'AE' => 'United Arab Emirates',
                                    'GB' => 'United Kingdom',
                                    'US' => 'United States',
                                    'UY' => 'Uruguay',
                                    'UZ' => 'Uzbekistan',
                                    'VU' => 'Vanuatu',
                                    'VE' => 'Venezuela',
                                    'VN' => 'Vietnam',
                                    'YE' => 'Yemen',
                                    'ZM' => 'Zambia',
                                    'ZW' => 'Zimbabwe',
                                ];
                            @endphp
                            @foreach($countries as $code => $name)
                                <option value="{{ $code }}" {{ old('customer_country') == $code ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __("app.phone_whatsapp") }} *</label>
                        <div class="flex gap-2">
                            @php
                                $dialCodes = [
                                    '+93'  => '🇦🇫 +93',   // Afghanistan
                                    '+355' => '🇦🇱 +355',  // Albania
                                    '+213' => '🇩🇿 +213',  // Algeria
                                    '+376' => '🇦🇩 +376',  // Andorra
                                    '+244' => '🇦🇴 +244',  // Angola
                                    '+1'   => '🇺🇸 +1',    // US/Canada
                                    '+374' => '🇦🇲 +374',  // Armenia
                                    '+61'  => '🇦🇺 +61',   // Australia
                                    '+43'  => '🇦🇹 +43',   // Austria
                                    '+994' => '🇦🇿 +994',  // Azerbaijan
                                    '+1242'=> '🇧🇸 +1242', // Bahamas
                                    '+973' => '🇧🇭 +973',  // Bahrain
                                    '+880' => '🇧🇩 +880',  // Bangladesh
                                    '+1246'=> '🇧🇧 +1246', // Barbados
                                    '+375' => '🇧🇾 +375',  // Belarus
                                    '+32'  => '🇧🇪 +32',   // Belgium
                                    '+501' => '🇧🇿 +501',  // Belize
                                    '+229' => '🇧🇯 +229',  // Benin
                                    '+975' => '🇧🇹 +975',  // Bhutan
                                    '+591' => '🇧🇴 +591',  // Bolivia
                                    '+387' => '🇧🇦 +387',  // Bosnia and Herzegovina
                                    '+267' => '🇧🇼 +267',  // Botswana
                                    '+55'  => '🇧🇷 +55',   // Brazil
                                    '+673' => '🇧🇳 +673',  // Brunei
                                    '+359' => '🇧🇬 +359',  // Bulgaria
                                    '+226' => '🇧🇫 +226',  // Burkina Faso
                                    '+257' => '🇧🇮 +257',  // Burundi
                                    '+238' => '🇨🇻 +238',  // Cabo Verde
                                    '+855' => '🇰🇭 +855',  // Cambodia
                                    '+237' => '🇨🇲 +237',  // Cameroon
                                    '+236' => '🇨🇫 +236',  // Central African Republic
                                    '+235' => '🇹🇩 +235',  // Chad
                                    '+56'  => '🇨🇱 +56',   // Chile
                                    '+86'  => '🇨🇳 +86',   // China
                                    '+57'  => '🇨🇴 +57',   // Colombia
                                    '+269' => '🇰🇲 +269',  // Comoros
                                    '+242' => '🇨🇬 +242',  // Congo
                                    '+243' => '🇨🇩 +243',  // Congo DRC
                                    '+506' => '🇨🇷 +506',  // Costa Rica
                                    '+385' => '🇭🇷 +385',  // Croatia
                                    '+53'  => '🇨🇺 +53',   // Cuba
                                    '+357' => '🇨🇾 +357',  // Cyprus
                                    '+420' => '🇨🇿 +420',  // Czech Republic
                                    '+45'  => '🇩🇰 +45',   // Denmark
                                    '+253' => '🇩🇯 +253',  // Djibouti
                                    '+1767'=> '🇩🇲 +1767', // Dominica
                                    '+1809'=> '🇩🇴 +1809', // Dominican Republic
                                    '+593' => '🇪🇨 +593',  // Ecuador
                                    '+20'  => '🇪🇬 +20',   // Egypt
                                    '+503' => '🇸🇻 +503',  // El Salvador
                                    '+240' => '🇬🇶 +240',  // Equatorial Guinea
                                    '+291' => '🇪🇷 +291',  // Eritrea
                                    '+372' => '🇪🇪 +372',  // Estonia
                                    '+268' => '🇸🇿 +268',  // Eswatini
                                    '+251' => '🇪🇹 +251',  // Ethiopia
                                    '+679' => '🇫🇯 +679',  // Fiji
                                    '+358' => '🇫🇮 +358',  // Finland
                                    '+33'  => '🇫🇷 +33',   // France
                                    '+241' => '🇬🇦 +241',  // Gabon
                                    '+220' => '🇬🇲 +220',  // Gambia
                                    '+995' => '🇬🇪 +995',  // Georgia
                                    '+49'  => '🇩🇪 +49',   // Germany
                                    '+233' => '🇬🇭 +233',  // Ghana
                                    '+30'  => '🇬🇷 +30',   // Greece
                                    '+1473'=> '🇬🇩 +1473', // Grenada
                                    '+502' => '🇬🇹 +502',  // Guatemala
                                    '+224' => '🇬🇳 +224',  // Guinea
                                    '+245' => '🇬🇼 +245',  // Guinea-Bissau
                                    '+592' => '🇬🇾 +592',  // Guyana
                                    '+509' => '🇭🇹 +509',  // Haiti
                                    '+504' => '🇭🇳 +504',  // Honduras
                                    '+36'  => '🇭🇺 +36',   // Hungary
                                    '+354' => '🇮🇸 +354',  // Iceland
                                    '+91'  => '🇮🇳 +91',   // India
                                    '+62'  => '🇮🇩 +62',   // Indonesia
                                    '+98'  => '🇮🇷 +98',   // Iran
                                    '+964' => '🇮🇶 +964',  // Iraq
                                    '+353' => '🇮🇪 +353',  // Ireland
                                    '+39'  => '🇮🇹 +39',   // Italy
                                    '+1876'=> '🇯🇲 +1876', // Jamaica
                                    '+81'  => '🇯🇵 +81',   // Japan
                                    '+962' => '🇯🇴 +962',  // Jordan
                                    '+7'   => '🇰🇿 +7',    // Kazakhstan/Russia
                                    '+254' => '🇰🇪 +254',  // Kenya
                                    '+686' => '🇰🇮 +686',  // Kiribati
                                    '+965' => '🇰🇼 +965',  // Kuwait
                                    '+996' => '🇰🇬 +996',  // Kyrgyzstan
                                    '+856' => '🇱🇦 +856',  // Laos
                                    '+371' => '🇱🇻 +371',  // Latvia
                                    '+961' => '🇱🇧 +961',  // Lebanon
                                    '+266' => '🇱🇸 +266',  // Lesotho
                                    '+231' => '🇱🇷 +231',  // Liberia
                                    '+218' => '🇱🇾 +218',  // Libya
                                    '+423' => '🇱🇮 +423',  // Liechtenstein
                                    '+370' => '🇱🇹 +370',  // Lithuania
                                    '+352' => '🇱🇺 +352',  // Luxembourg
                                    '+261' => '🇲🇬 +261',  // Madagascar
                                    '+265' => '🇲🇼 +265',  // Malawi
                                    '+60'  => '🇲🇾 +60',   // Malaysia
                                    '+960' => '🇲🇻 +960',  // Maldives
                                    '+223' => '🇲🇱 +223',  // Mali
                                    '+356' => '🇲🇹 +356',  // Malta
                                    '+692' => '🇲🇭 +692',  // Marshall Islands
                                    '+222' => '🇲🇷 +222',  // Mauritania
                                    '+230' => '🇲🇺 +230',  // Mauritius
                                    '+52'  => '🇲🇽 +52',   // Mexico
                                    '+691' => '🇫🇲 +691',  // Micronesia
                                    '+373' => '🇲🇩 +373',  // Moldova
                                    '+377' => '🇲🇨 +377',  // Monaco
                                    '+976' => '🇲🇳 +976',  // Mongolia
                                    '+382' => '🇲🇪 +382',  // Montenegro
                                    '+212' => '🇲🇦 +212',  // Morocco
                                    '+258' => '🇲🇿 +258',  // Mozambique
                                    '+95'  => '🇲🇲 +95',   // Myanmar
                                    '+264' => '🇳🇦 +264',  // Namibia
                                    '+674' => '🇳🇷 +674',  // Nauru
                                    '+977' => '🇳🇵 +977',  // Nepal
                                    '+31'  => '🇳🇱 +31',   // Netherlands
                                    '+64'  => '🇳🇿 +64',   // New Zealand
                                    '+505' => '🇳🇮 +505',  // Nicaragua
                                    '+227' => '🇳🇪 +227',  // Niger
                                    '+234' => '🇳🇬 +234',  // Nigeria
                                    '+850' => '🇰🇵 +850',  // North Korea
                                    '+389' => '🇲🇰 +389',  // North Macedonia
                                    '+47'  => '🇳🇴 +47',   // Norway
                                    '+968' => '🇴🇲 +968',  // Oman
                                    '+92'  => '🇵🇰 +92',   // Pakistan
                                    '+680' => '🇵🇼 +680',  // Palau
                                    '+970' => '🇵🇸 +970',  // Palestine
                                    '+507' => '🇵🇦 +507',  // Panama
                                    '+675' => '🇵🇬 +675',  // Papua New Guinea
                                    '+595' => '🇵🇾 +595',  // Paraguay
                                    '+51'  => '🇵🇪 +51',   // Peru
                                    '+63'  => '🇵🇭 +63',   // Philippines
                                    '+48'  => '🇵🇱 +48',   // Poland
                                    '+351' => '🇵🇹 +351',  // Portugal
                                    '+974' => '🇶🇦 +974',  // Qatar
                                    '+40'  => '🇷🇴 +40',   // Romania
                                    '+250' => '🇷🇼 +250',  // Rwanda
                                    '+1869'=> '🇰🇳 +1869', // Saint Kitts and Nevis
                                    '+1758'=> '🇱🇨 +1758', // Saint Lucia
                                    '+1784'=> '🇻🇨 +1784', // Saint Vincent
                                    '+685' => '🇼🇸 +685',  // Samoa
                                    '+378' => '🇸🇲 +378',  // San Marino
                                    '+239' => '🇸🇹 +239',  // Sao Tome and Principe
                                    '+966' => '🇸🇦 +966',  // Saudi Arabia
                                    '+221' => '🇸🇳 +221',  // Senegal
                                    '+381' => '🇷🇸 +381',  // Serbia
                                    '+248' => '🇸🇨 +248',  // Seychelles
                                    '+232' => '🇸🇱 +232',  // Sierra Leone
                                    '+65'  => '🇸🇬 +65',   // Singapore
                                    '+421' => '🇸🇰 +421',  // Slovakia
                                    '+386' => '🇸🇮 +386',  // Slovenia
                                    '+677' => '🇸🇧 +677',  // Solomon Islands
                                    '+252' => '🇸🇴 +252',  // Somalia
                                    '+27'  => '🇿🇦 +27',   // South Africa
                                    '+211' => '🇸🇸 +211',  // South Sudan
                                    '+34'  => '🇪🇸 +34',   // Spain
                                    '+94'  => '🇱🇰 +94',   // Sri Lanka
                                    '+249' => '🇸🇩 +249',  // Sudan
                                    '+597' => '🇸🇷 +597',  // Suriname
                                    '+46'  => '🇸🇪 +46',   // Sweden
                                    '+41'  => '🇨🇭 +41',   // Switzerland
                                    '+963' => '🇸🇾 +963',  // Syria
                                    '+886' => '🇹🇼 +886',  // Taiwan
                                    '+992' => '🇹🇯 +992',  // Tajikistan
                                    '+255' => '🇹🇿 +255',  // Tanzania
                                    '+66'  => '🇹🇭 +66',   // Thailand
                                    '+670' => '🇹🇱 +670',  // Timor-Leste
                                    '+228' => '🇹🇬 +228',  // Togo
                                    '+676' => '🇹🇴 +676',  // Tonga
                                    '+1868'=> '🇹🇹 +1868', // Trinidad and Tobago
                                    '+216' => '🇹🇳 +216',  // Tunisia
                                    '+90'  => '🇹🇷 +90',   // Turkey
                                    '+993' => '🇹🇲 +993',  // Turkmenistan
                                    '+688' => '🇹🇻 +688',  // Tuvalu
                                    '+256' => '🇺🇬 +256',  // Uganda
                                    '+380' => '🇺🇦 +380',  // Ukraine
                                    '+971' => '🇦🇪 +971',  // UAE
                                    '+44'  => '🇬🇧 +44',   // United Kingdom
                                    '+598' => '🇺🇾 +598',  // Uruguay
                                    '+998' => '🇺🇿 +998',  // Uzbekistan
                                    '+678' => '🇻🇺 +678',  // Vanuatu
                                    '+58'  => '🇻🇪 +58',   // Venezuela
                                    '+84'  => '🇻🇳 +84',   // Vietnam
                                    '+967' => '🇾🇪 +967',  // Yemen
                                    '+260' => '🇿🇲 +260',  // Zambia
                                    '+263' => '🇿🇼 +263',  // Zimbabwe
                                ];
                                $defaultCode = old('customer_country_code', '+968');
                            @endphp
                            <select name="customer_country_code"
                                class="px-3 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white shrink-0">
                                @foreach($dialCodes as $code => $label)
                                    <option value="{{ $code }}" {{ $defaultCode == $code ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <input type="tel" name="customer_phone" value="{{ old("customer_phone") }}"
                                class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="9xxxxxxxx" required />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __("app.notes_optional") }}</label>
                        <textarea name="customer_notes" rows="2"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"
                            placeholder="{{ __("app.special_requests") ?? "Any special requests..." }}">{{ old("customer_notes") }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __("app.email_address") }} *</label>
                        <input type="email" name="customer_email" value="{{ old("customer_email") }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="{{ __("app.enter_email_confirmation") ?? "email@example.com" }}" required />
                        <p class="text-xs text-gray-400 mt-1">{{ __("app.email_confirmation_hint") ?? "We'll send a booking confirmation to this address." }}</p>
                    </div>
                </form>

            </div>

            <div class="shrink-0 px-6 py-4 border-t border-gray-100 bg-white">
                <button type="button" id="confirmBtn" onclick="submitBooking()"
                    class="hidden w-full py-3 rounded-xl bg-gray-900 text-white font-semibold text-sm hover:bg-gray-800 active:scale-95 transition">
                    {{ __("app.confirm_booking") }}
                </button>
                <p id="drawerHint" class="text-center text-sm text-gray-400">
                    {{ __("app.select_service_hint") }}
                </p>
            </div>
        </div>
    </div>

    <script>
    (() => {
        const businessSlug  = @json($business->slug);
        const allBranches   = @json(isset($branches) ? $branches->map(fn($b) => ['id' => $b->id, 'name' => $b->name, 'service_ids' => $b->services->pluck('id')]) : collect());
        const singleBranchId = allBranches.length === 1 ? allBranches[0].id : null;
        const modalDate     = document.getElementById("modalDate");
        const modalSlotsDiv = document.getElementById("modalSlots");
        const modalNoSlots       = document.getElementById("modalNoSlots");
        const modalTimeOffNotice = document.getElementById("modalTimeOffNotice");
        const timeOffNoteText    = document.getElementById("timeOffNoteText");
        const modalLoading       = document.getElementById("modalSlotsLoading");
        const staffSection  = document.getElementById("modalStaffSection");
        const staffFilter   = document.getElementById("modalStaffFilter");
        const bookingForm   = document.getElementById("bookingForm");
        const confirmBtn    = document.getElementById("confirmBtn");
        const drawerHint    = document.getElementById("drawerHint");
        const modalSummary  = document.getElementById("modalSummary");

        let allStaff = [], currentSlots = [], selectedStaffFilter = "all";
        let selectedBranchId = singleBranchId;
        let selectedServiceIds = []; // array of selected service ID strings

        // Set single branch silently
        if (singleBranchId) {
            const hiddenBranch = document.getElementById("hidden_branch_id");
            if (hiddenBranch) hiddenBranch.value = singleBranchId;
        }

        modalDate.min = new Date().toISOString().split("T")[0];

        // ── Helper: get checked service objects ────────────────────────────────
        function getSelectedServices() {
            return Array.from(document.querySelectorAll('.modal-service-checkbox:checked'))
                .map(cb => ({
                    id:       cb.value,
                    name:     cb.dataset.name,
                    duration: parseInt(cb.dataset.duration),
                    price:    parseFloat(cb.dataset.price || 0)
                }));
        }

        function updateServiceTotal() {
            const selected = getSelectedServices();
            const bar  = document.getElementById('serviceTotalBar');
            const lbl  = document.getElementById('serviceTotalLabel');
            if (selected.length === 0) { bar.classList.add('hidden'); return; }
            const totalDur   = selected.reduce((s, x) => s + x.duration, 0);
            const totalPrice = selected.reduce((s, x) => s + x.price, 0);
            let text = selected.length === 1
                ? selected[0].name
                : selected.length + ' {{ __("app.services") }}: ' + selected.map(s => s.name).join(', ');
            text += ' · ' + totalDur + ' {{ __("app.minutes") }}';
            if (totalPrice > 0) text += ' · ' + totalPrice.toFixed(2) + ' {{ $business->currency }}';
            lbl.textContent = text;
            bar.classList.remove('hidden');
        }

        window.clearServiceSelection = function () {
            document.querySelectorAll('.modal-service-checkbox').forEach(cb => { cb.checked = false; });
            selectedServiceIds = [];
            document.getElementById('serviceTotalBar').classList.add('hidden');
            clearSlots();
        };

        // ── Branch radio handler ───────────────────────────────────────────────
        document.querySelectorAll(".modal-branch-radio").forEach(r => {
            r.addEventListener("change", function () {
                document.querySelectorAll(".branch-check").forEach(i => i.style.opacity = "0");
                this.closest("label").querySelector(".branch-check").style.opacity = "1";
                selectedBranchId = parseInt(this.value);
                document.getElementById("hidden_branch_id").value = selectedBranchId;
                filterServicesByBranch(JSON.parse(this.dataset.services || "[]"));
                clearSlots();
                if (selectedServiceIds.length > 0 && modalDate.value) loadSlots();
            });
        });

        function filterServicesByBranch(serviceIds) {
            if (!serviceIds || serviceIds.length === 0) {
                document.querySelectorAll(".modal-service-checkbox").forEach(cb => {
                    cb.closest("label").style.display = "";
                });
                return;
            }
            const ids = serviceIds.map(id => parseInt(id));
            document.querySelectorAll(".modal-service-checkbox").forEach(cb => {
                const sId  = parseInt(cb.value);
                const label = cb.closest("label");
                if (ids.includes(sId)) {
                    label.style.display = "";
                } else {
                    label.style.display = "none";
                    if (cb.checked) {
                        cb.checked = false;
                    }
                }
            });
            // Re-sync after hiding
            selectedServiceIds = Array.from(document.querySelectorAll('.modal-service-checkbox:checked')).map(c => c.value);
            updateServiceTotal();
            clearSlots();
        }

        // ── Service checkbox handler ───────────────────────────────────────────
        document.querySelectorAll(".modal-service-checkbox").forEach(cb => {
            cb.addEventListener("change", function () {
                selectedServiceIds = Array.from(document.querySelectorAll('.modal-service-checkbox:checked')).map(c => c.value);
                updateServiceTotal();
                clearSlots();
                if (selectedServiceIds.length > 0 && modalDate.value) loadSlots();
            });
        });

        // ── Date change handler ────────────────────────────────────────────────
        modalDate.addEventListener("change", () => { if (selectedServiceIds.length > 0) loadSlots(); });

        function clearSlots() {
            modalSlotsDiv.innerHTML = "";
            modalNoSlots.classList.add("hidden");
            modalNoSlots.textContent = '{{ __("app.no_available_slots") ?? "No available slots for this date." }}';
            modalTimeOffNotice.classList.add("hidden");
            timeOffNoteText.textContent = "";
            bookingForm.classList.add("hidden");
            confirmBtn.classList.add("hidden");
            drawerHint.classList.remove("hidden");
            modalSummary.classList.add("hidden");
        }

        async function loadSlots() {
            clearSlots();
            staffSection.classList.add("hidden");
            if (selectedServiceIds.length === 0 || !modalDate.value) return;
            modalLoading.classList.remove("hidden");
            try {
                const params = new URLSearchParams({ date: modalDate.value });
                selectedServiceIds.forEach(id => params.append('service_ids[]', id));
                if (selectedBranchId) params.append('branch_id', selectedBranchId);
                const res  = await fetch(`/${businessSlug}/slots?${params}`);
                const data = await res.json();
                modalLoading.classList.add("hidden");
                if (!data.slots || data.slots.length === 0) {
                    if (data.reason === 'time_off') {
                        timeOffNoteText.textContent = data.note || '{{ __("app.business_closed_day") }}';
                        modalTimeOffNotice.classList.remove("hidden");
                    } else if (data.reason === 'limit_reached') {
                        modalNoSlots.textContent = '{{ __("app.booking_limit_contact") }}';
                        modalNoSlots.classList.remove("hidden");
                    } else {
                        modalNoSlots.textContent = '{{ __("app.no_available_slots") ?? "No available slots for this date." }}';
                        modalNoSlots.classList.remove("hidden");
                    }
                    return;
                }
                allStaff = data.staff || [];
                currentSlots = data.slots;
                selectedStaffFilter = "all";
                if (allStaff.length > 1) { staffSection.classList.remove("hidden"); renderStaffFilter(); }
                renderSlots();
            } catch (e) {
                modalLoading.classList.add("hidden");
                modalNoSlots.classList.remove("hidden");
            }
        }

        function renderStaffFilter() {
            staffFilter.innerHTML = "";
            const makeCard = (id, name, photo) => {
                const a = selectedStaffFilter == id;
                const btn = document.createElement("button");
                btn.type = "button"; btn.dataset.staffId = id;
                btn.className = "flex flex-col items-center gap-1 p-2 rounded-xl border-2 transition text-center flex-shrink-0 " +
                    (a ? "border-green-600 bg-green-50" : "border-gray-200 bg-white hover:border-green-400");
                btn.style.width = "72px";

                let avatarHtml;
                if (photo) {
                    avatarHtml = `<img src="${photo}" alt="${name}" class="w-12 h-12 rounded-full object-cover mx-auto">`;
                } else if (id === "all") {
                    avatarHtml = `<div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto"><svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>`;
                } else {
                    const initial = name.charAt(0).toUpperCase();
                    avatarHtml = `<div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mx-auto"><span class="text-emerald-700 font-bold text-lg">${initial}</span></div>`;
                }

                const nameEl = document.createElement("span");
                nameEl.className = "text-xs font-medium leading-tight " + (a ? "text-green-700" : "text-gray-700");
                nameEl.style.cssText = "display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden";
                nameEl.textContent = id === "all" ? "{{ __('app.any') ?? 'Any' }}" : name;

                btn.innerHTML = avatarHtml;
                btn.appendChild(nameEl);
                btn.onclick = () => { selectedStaffFilter = id; renderStaffFilter(); renderSlots(); };
                staffFilter.appendChild(btn);
            };
            makeCard("all", "", null);
            allStaff.forEach(s => makeCard(s.id, s.name, s.photo));
        }

        function renderSlots() {
            modalSlotsDiv.innerHTML = "";
            let slots = currentSlots;
            if (selectedStaffFilter !== "all")
                slots = currentSlots.filter(s => s.available_staff && s.available_staff.some(x => x.id === parseInt(selectedStaffFilter)));
            if (slots.length === 0) { modalNoSlots.classList.remove("hidden"); return; }
            slots.forEach(s => {
                const b = document.createElement("button");
                b.type = "button";
                b.className = "slot-btn px-2 py-2 rounded-lg border border-gray-200 bg-white text-xs font-semibold text-gray-800 text-center transition";
                b.textContent = s.label;
                b.onclick = () => selectSlot(s, b);
                modalSlotsDiv.appendChild(b);
            });
        }

        function selectSlot(slot, btnEl) {
            document.querySelectorAll(".slot-btn").forEach(b => b.classList.remove("selected"));
            btnEl.classList.add("selected");
            if (!slot.available_staff || slot.available_staff.length === 0) { alert('{{ __("app.no_staff_slot") }}'); return; }
            const staff = selectedStaffFilter !== "all"
                ? slot.available_staff.find(s => s.id === parseInt(selectedStaffFilter))
                : slot.available_staff[0];
            if (!staff) { alert('{{ __("app.staff_not_available") }}'); return; }

            // Populate service_ids[] hidden inputs
            const container = document.getElementById("hidden_service_ids_container");
            container.innerHTML = '';
            selectedServiceIds.forEach(id => {
                const inp = document.createElement('input');
                inp.type = 'hidden'; inp.name = 'service_ids[]'; inp.value = id;
                container.appendChild(inp);
            });

            document.getElementById("hidden_staff_user_id").value = staff.id;
            document.getElementById("hidden_date").value          = modalDate.value;
            document.getElementById("hidden_start_time").value    = slot.start;
            document.getElementById("hidden_branch_id").value     = selectedBranchId || '';

            const selected = getSelectedServices();
            const svcText  = selected.map(s => s.name).join(', ');
            const dateStr  = new Date(modalDate.value).toLocaleDateString('{{ app()->getLocale() === "ar" ? "ar-SA" : "en-US" }}', { weekday:"long", year:"numeric", month:"long", day:"numeric" });
            document.getElementById("sumService").textContent = svcText;
            const photoHtml = staff.photo
                ? `<img src="${staff.photo}" class="w-5 h-5 rounded-full object-cover flex-shrink-0" alt="${staff.name}">`
                : `<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px] flex-shrink-0">${staff.name.charAt(0).toUpperCase()}</span>`;
            document.getElementById("sumStaff").innerHTML    = photoHtml + `<span>{{ __("app.with") }} ${staff.name}</span>`;
            document.getElementById("sumDateTime").textContent = `${dateStr} at ${slot.label}`;

            const sumBranchEl = document.getElementById("sumBranch");
            if (selectedBranchId && allBranches.length > 1) {
                const br = allBranches.find(b => b.id === selectedBranchId);
                if (br) { sumBranchEl.textContent = `📍 ${br.name}`; sumBranchEl.style.display = ""; }
            } else {
                sumBranchEl.style.display = "none";
            }
            modalSummary.classList.remove("hidden");
            bookingForm.classList.remove("hidden");
            confirmBtn.classList.remove("hidden");
            drawerHint.classList.add("hidden");
            bookingForm.scrollIntoView({ behavior:"smooth", block:"nearest" });
        }

        // ── Description expand (main page) ────────────────────────────────────
        window.toggleSvcDesc = function(id) {
            const desc = document.getElementById('svcDesc' + id);
            const btn  = document.getElementById('svcDescBtn' + id);
            if (!desc) return;
            if (desc.classList.contains('line-clamp-3')) {
                desc.classList.remove('line-clamp-3');
                if (btn) btn.textContent = '{{ __("app.show_less") ?? "Show less" }}';
            } else {
                desc.classList.add('line-clamp-3');
                if (btn) btn.textContent = '{{ __("app.read_more") ?? "Read more" }}';
            }
        };

        // ── Main page multi-service selection ─────────────────────────────────
        const mainSelectedServices = new Map();

        window.toggleMainSvc = function(id, btn) {
            const key = String(id);
            const row = document.getElementById('svcRow' + id);
            if (mainSelectedServices.has(key)) {
                mainSelectedServices.delete(key);
                btn.textContent = '+ {{ __("app.select") ?? "Select" }}';
                btn.classList.remove('bg-green-600', 'text-white', 'border-green-600');
                btn.classList.add('border-gray-300', 'text-gray-700');
            } else {
                if (row) {
                    mainSelectedServices.set(key, {
                        id: key,
                        name: row.dataset.svcName,
                        duration: parseInt(row.dataset.svcDuration),
                        price: parseFloat(row.dataset.svcPrice)
                    });
                }
                btn.textContent = '✓ {{ __("app.selected") ?? "Selected" }}';
                btn.classList.add('bg-green-600', 'text-white', 'border-green-600');
                btn.classList.remove('border-gray-300', 'text-gray-700');
            }
            updateSelBar();
        };

        function updateSelBar() {
            const bar = document.getElementById('svcSelBar');
            if (!bar) return;
            const count = mainSelectedServices.size;
            if (count === 0) { bar.classList.add('hidden'); return; }
            bar.classList.remove('hidden');
            const svcs = Array.from(mainSelectedServices.values());
            const totalDur   = svcs.reduce((a, x) => a + x.duration, 0);
            const totalPrice = svcs.reduce((a, x) => a + x.price, 0);
            const svcLabel = count === 1
                ? '{{ __("app.service") ?? "service" }}'
                : '{{ __("app.services") ?? "services" }}';
            document.getElementById('selBarCount').textContent =
                count + ' ' + svcLabel + ' {{ __("app.selected") ?? "selected" }}';
            let detail = totalDur + ' {{ __("app.minutes") ?? "min" }}';
            if (totalPrice > 0) detail += ' · ' + totalPrice.toFixed(2) + ' {{ $business->currency }}';
            document.getElementById('selBarDetails').textContent = detail;
        }

        window.proceedWithSelected = function() {
            const ids = Array.from(mainSelectedServices.keys());
            if (ids.length > 0) openBookingModal(ids);
        };

        window.submitBooking = function () { bookingForm.submit(); };

        window.openBookingModal = function (btn) {
            const modal  = document.getElementById("bookingModal");
            const drawer = document.getElementById("bookingDrawer");
            modal.classList.remove("hidden");
            document.body.style.overflow = "hidden";
            requestAnimationFrame(() => drawer.classList.remove("translate-x-full"));
            if (Array.isArray(btn)) {
                // Pre-select multiple services passed as array of ID strings
                document.querySelectorAll('.modal-service-checkbox').forEach(cb => {
                    cb.checked = btn.includes(cb.value);
                });
                selectedServiceIds = [...btn];
                updateServiceTotal();
                if (modalDate.value && selectedServiceIds.length > 0) loadSlots();
            } else if (btn && btn.dataset) {
                const sid = btn.dataset.serviceId;
                const cb  = document.querySelector(`.modal-service-checkbox[value="${sid}"]`);
                if (cb) {
                    cb.checked = true;
                    selectedServiceIds = [sid];
                    updateServiceTotal();
                    if (modalDate.value) loadSlots();
                }
            }
        };

        window.closeBookingModal = function () {
            const drawer = document.getElementById("bookingDrawer");
            drawer.classList.add("translate-x-full");
            setTimeout(() => {
                document.getElementById("bookingModal").classList.add("hidden");
                document.body.style.overflow = "";
            }, 300);
        };

        @if(old('date'))
        window.addEventListener("DOMContentLoaded", () => {
            openBookingModal(null);
            @foreach(old('service_ids', []) as $oldSid)
            (function(){
                const cb = document.querySelector(`.modal-service-checkbox[value="{{ $oldSid }}"]`);
                if (cb) { cb.checked = true; }
            })();
            @endforeach
            selectedServiceIds = @json(array_map('strval', old('service_ids', [])));
            updateServiceTotal();
            modalDate.value = "{{ old('date') }}";
            if (selectedServiceIds.length > 0) loadSlots();
        });
        @endif

        document.addEventListener("keydown", e => {
            if (e.key === "Escape") {
                closeBookingModal();
                closeLightbox();
            }
        });

        // ── Category filtering (no page reload) ───────────────────────────────
        window.filterCategory = function(catId) {
            // Update tab styles
            document.querySelectorAll('.cat-tab').forEach(btn => {
                const active = btn.dataset.cat == catId;
                btn.classList.toggle('bg-green-600', active);
                btn.classList.toggle('text-white',   active);
                btn.classList.toggle('border-green-600', active);
                btn.classList.toggle('bg-white',     !active);
                btn.classList.toggle('text-green-700', !active);
            });

            // Show/hide service rows
            const rows = document.querySelectorAll('.service-row');
            let visibleCount = 0;
            rows.forEach(row => {
                const match = catId === 'featured' || row.dataset.categoryId == catId;
                row.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            // Show empty-state or the list
            const emptyEl = document.getElementById('svcEmptyState');
            const listEl  = document.getElementById('svcList');
            const noResultsEl = document.getElementById('svcNoResults');
            if (emptyEl)      emptyEl.style.display      = visibleCount === 0 && rows.length === 0 ? '' : 'none';
            if (listEl)       listEl.style.display       = '';
            if (noResultsEl)  noResultsEl.style.display  = visibleCount === 0 && rows.length > 0 ? '' : 'none';

            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('category', catId);
            history.replaceState(null, '', url);
        };

        // Apply initial category on page load
        filterCategory('{{ $selectedCategory }}');
    })();
    </script>

    {{-- ─────────────────────── LIGHTBOX ─────────────────────── --}}
    @php
        $bizGallery2 = array_filter($business->gallery_images ?? []);
        if (!empty($bizGallery2)) {
            $galleryImages = collect(array_values($bizGallery2))
                ->map(fn($p) => (object)['path' => $p, 'alt' => $business->name]);
        } else {
            $galleryImages = $services->flatMap(fn($s) => $s->images)->values();
            if ($galleryImages->isEmpty()) {
                $galleryImages = $services->filter(fn($s) => $s->image)
                    ->map(fn($s) => (object)['path' => $s->image, 'alt' => $s->name])->values();
            }
        }
    @endphp
    @if($galleryImages->count() > 0)
    <div id="lightbox" class="hidden fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4">
        {{-- Close --}}
        <button onclick="closeLightbox()"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Prev --}}
        <button onclick="lightboxPrev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Image --}}
        <img id="lightboxImg" src="" alt=""
            class="max-h-[85vh] max-w-full rounded-xl shadow-2xl object-contain">

        {{-- Next --}}
        <button onclick="lightboxNext()"
            class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Counter --}}
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/70 text-sm font-medium" id="lightboxCounter"></div>

        {{-- Thumbnails --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex gap-2 max-w-full overflow-x-auto px-4">
            @foreach($galleryImages as $i => $gs)
                <img src="{{ asset($gs->path) }}" alt=""
                    class="lightbox-thumb w-12 h-12 rounded-lg object-cover cursor-pointer border-2 border-transparent hover:border-white transition opacity-60 hover:opacity-100 shrink-0"
                    onclick="lightboxGo({{ $i }})">
            @endforeach
        </div>
    </div>

    <script>
    (() => {
        const images = @json($galleryImages->map(fn($img) => ['src' => asset($img->path), 'alt' => ''])->values());
        let current = 0;

        window.openLightbox = function (idx) {
            current = idx;
            render();
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };
        window.closeLightbox = function () {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = '';
        };
        window.lightboxPrev = function () { current = (current - 1 + images.length) % images.length; render(); };
        window.lightboxNext = function () { current = (current + 1) % images.length; render(); };
        window.lightboxGo   = function (i) { current = i; render(); };

        function render() {
            const img = document.getElementById('lightboxImg');
            img.style.opacity = '0';
            setTimeout(() => {
                img.src = images[current].src;
                img.alt = images[current].alt;
                img.style.opacity = '1';
            }, 100);
            document.getElementById('lightboxCounter').textContent = `${current + 1} / ${images.length}`;
            document.querySelectorAll('.lightbox-thumb').forEach((t, i) => {
                t.classList.toggle('border-white', i === current);
                t.classList.toggle('opacity-100', i === current);
                t.classList.toggle('opacity-60', i !== current);
            });
        }
    })();
    </script>
    @endif

    {{-- Service Detail Modal --}}
    <div id="svcDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60" onclick="closeSvcDetail()"></div>
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl max-h-[90vh] flex flex-col overflow-hidden">
            {{-- Close --}}
            <button type="button" onclick="closeSvcDetail()"
                class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/90 shadow flex items-center justify-center text-gray-600 hover:bg-gray-100 transition text-lg leading-none">
                &times;
            </button>
            {{-- Image carousel (populated by JS) --}}
            <div id="svcDetailCarousel" class="flex-shrink-0 bg-gray-100"></div>
            {{-- Info --}}
            <div class="overflow-y-auto p-5 flex-1">
                <h3 id="svcDetailName" class="text-xl font-bold text-gray-900 pr-6"></h3>
                <p id="svcDetailMeta" class="text-sm text-gray-500 mt-1"></p>
                <p id="svcDetailDesc" class="text-sm text-gray-700 mt-3 leading-relaxed whitespace-pre-line"></p>
            </div>
            {{-- Select button --}}
            <div class="p-4 border-t border-gray-100 flex-shrink-0">
                <button id="svcDetailSelectBtn" type="button"
                    onclick="svcDetailSelectCurrent()"
                    class="w-full py-3 rounded-xl bg-green-600 text-white font-semibold text-sm hover:bg-green-700 transition">
                    + {{ __('app.select') ?? 'Select' }} {{ __('app.service') ?? 'service' }}
                </button>
            </div>
        </div>
    </div>

    <script>
    (function () {
        let svcDetailCurrentId = null;
        let svcDetailImages    = [];
        let svcDetailImgIndex  = 0;

        window.openSvcDetail = function (id, event) {
            if (event) event.stopPropagation();
            const row = document.getElementById('svcRow' + id);
            if (!row) return;
            svcDetailCurrentId = id;

            const name     = row.dataset.svcName;
            const duration = parseInt(row.dataset.svcDuration);
            const price    = parseFloat(row.dataset.svcPrice);
            const desc     = row.dataset.svcDesc || '';
            const images   = JSON.parse(row.dataset.svcImages || '[]');

            document.getElementById('svcDetailName').textContent = name;

            let meta = duration + ' {{ __('app.minutes') ?? 'min' }}';
            if (price > 0) meta += ' \u00b7 ' + price.toFixed(2) + ' {{ $business->currency }}';
            document.getElementById('svcDetailMeta').textContent = meta;

            const descEl = document.getElementById('svcDetailDesc');
            descEl.textContent = desc;
            descEl.style.display = desc ? '' : 'none';

            buildSvcCarousel(images);
            syncSvcDetailBtn();

            document.getElementById('svcDetailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        window.closeSvcDetail = function () {
            document.getElementById('svcDetailModal').classList.add('hidden');
            document.body.style.overflow = '';
            svcDetailCurrentId = null;
        };

        function buildSvcCarousel(images) {
            svcDetailImages   = images;
            svcDetailImgIndex = 0;
            renderSvcCarouselSlide();
        }

        function renderSvcCarouselSlide() {
            const container = document.getElementById('svcDetailCarousel');
            const total     = svcDetailImages.length;

            if (total === 0) {
                container.innerHTML = '<div class="h-48 flex items-center justify-center"><svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>';
                return;
            }

            const dots = total > 1
                ? svcDetailImages.map((_, i) =>
                    `<span class="inline-block w-1.5 h-1.5 rounded-full transition ${
                        i === svcDetailImgIndex ? 'bg-white scale-125' : 'bg-white/50'
                    }"></span>`).join('')
                : '';

            const nav = total > 1 ? `
                <button type="button" onclick="svcCarouselPrev()" class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/60 transition text-xl leading-none">&lsaquo;</button>
                <button type="button" onclick="svcCarouselNext()" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/60 transition text-xl leading-none">&rsaquo;</button>
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5">${dots}</div>` : '';

            container.innerHTML = `
                <div class="relative">
                    <img src="${svcDetailImages[svcDetailImgIndex]}" alt="" class="w-full h-64 object-cover">
                    ${nav}
                </div>`;
        }

        window.svcCarouselPrev = function () {
            svcDetailImgIndex = (svcDetailImgIndex - 1 + svcDetailImages.length) % svcDetailImages.length;
            renderSvcCarouselSlide();
        };

        window.svcCarouselNext = function () {
            svcDetailImgIndex = (svcDetailImgIndex + 1) % svcDetailImages.length;
            renderSvcCarouselSlide();
        };

        function syncSvcDetailBtn() {
            const btn = document.getElementById('svcDetailSelectBtn');
            if (!btn || !svcDetailCurrentId) return;
            const selected = typeof mainSelectedServices !== 'undefined' && mainSelectedServices.has(String(svcDetailCurrentId));
            if (selected) {
                btn.textContent = '\u2713 {{ __('app.selected') ?? 'Selected' }}';
                btn.className = 'w-full py-3 rounded-xl bg-gray-200 text-gray-700 font-semibold text-sm transition';
            } else {
                btn.textContent = '+ {{ __('app.select') ?? 'Select' }} {{ __('app.service') ?? 'service' }}';
                btn.className = 'w-full py-3 rounded-xl bg-green-600 text-white font-semibold text-sm hover:bg-green-700 transition';
            }
        }

        window.svcDetailSelectCurrent = function () {
            if (!svcDetailCurrentId) return;
            const rowBtn = document.getElementById('svcSelectBtn' + svcDetailCurrentId);
            if (rowBtn) toggleMainSvc(svcDetailCurrentId, rowBtn);
            syncSvcDetailBtn();
        };

        // Close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeSvcDetail();
        });
    })();
    </script>

    {{-- Block Arabic input across all text fields --}}
    <script>
    (function () {
        const ARABIC = /[؀-ۿݐ-ݿࢠ-ࣿﭐ-﷿ﹰ-﻿]/g;

        function stripArabic(el) {
            const before = el.value;
            const after  = before.replace(ARABIC, '');
            if (before !== after) {
                const pos = el.selectionStart - (before.length - after.length);
                el.value = after;
                el.setSelectionRange(pos, pos);
            }
        }

        document.addEventListener('keydown', function (e) {
            if (e.key && ARABIC.test(e.key)) {
                e.preventDefault();
            }
            ARABIC.lastIndex = 0;
        }, true);

        document.addEventListener('input', function (e) {
            const el = e.target;
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                stripArabic(el);
            }
        }, true);
    })();
    </script>
</body>
</html>
