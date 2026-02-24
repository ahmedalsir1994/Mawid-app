<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.license_suspended') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="h-screen bg-gray-100 flex items-center justify-center px-3 overflow-hidden">
        <div class="w-full max-w-lg h-fit">
            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 mx-auto">
                <!-- Header -->
                <div class="bg-red-500 px-4 sm:px-6 py-3">
                    <div class="text-center">
                        <div class="flex justify-center mb-1">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.license_inactive') }}</h1>
                        <p class="text-red-100 text-xs sm:text-sm mt-1">{{ __('app.access_suspended') }}</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-3 sm:px-5 py-2 sm:py-3">
                    @if($license)
                        <!-- License Status -->
                        <div class="mb-2 p-2 bg-gray-50 rounded border border-gray-200">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-1">
                                {{ __('app.license_information') }}</h3>
                            <div class="space-y-1.5 text-xs sm:text-sm">
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <span class="text-gray-600 font-medium">{{ __('app.status') }}:</span>
                                    <span
                                        class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-semibold uppercase w-fit">
                                        {{ $license->status }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-medium">{{ __('app.business_name') }}:</span>
                                    <p class="text-gray-900 text-xs sm:text-sm">{{ $business->name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-medium">{{ __('app.license_key') }}:</span>
                                    <div class="mt-1 flex flex-col sm:flex-row gap-1 sm:gap-2">
                                        <code
                                            class="bg-gray-200 px-2 py-1 rounded text-xs font-mono text-gray-900 break-all">{{ $license->license_key }}</code>
                                        <button onclick="navigator.clipboard.writeText('{{ $license->license_key }}')"
                                            class="px-2 py-1 bg-gray-400 text-white rounded text-xs hover:bg-gray-500 whitespace-nowrap">
                                            {{ __('app.copy') }}
                                        </button>
                                    </div>
                                </div>
                                @if($license->expires_at)
                                    <div>
                                        <span class="text-gray-600 font-medium">{{ __('app.expires') }}:</span>
                                        <p class="text-gray-900">{{ $license->expires_at->format('F d, Y') }}</p>
                                    </div>
                                @endif
                                @if($license->status === 'expired')
                                    <div class="mt-2 p-2 bg-red-50 rounded border border-red-200">
                                        <p class="text-red-700 font-semibold text-xs">
                                            {{ __('app.expired') }} {{ $license->expires_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Restrictions -->
                        <div class="mb-2 p-2 bg-gray-50 rounded border border-gray-200">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-1">{{ __('app.restricted') }}</h3>
                            <ul class="space-y-1 text-gray-700 text-xs sm:text-sm">
                                <li class="flex items-start gap-1.5">
                                    <span class="text-red-600 font-bold flex-shrink-0">✕</span>
                                    <span>{{ __('app.cannot_access_dashboard') }}</span>
                                </li>
                                <li class="flex items-start gap-1.5">
                                    <span class="text-red-600 font-bold flex-shrink-0">✕</span>
                                    <span>{{ __('app.cannot_manage_services') }}</span>
                                </li>
                                <li class="flex items-start gap-1.5">
                                    <span class="text-red-600 font-bold flex-shrink-0">✕</span>
                                    <span>{{ __('app.booking_page_disabled') }}</span>
                                </li>
                                <li class="flex items-start gap-1.5">
                                    <span class="text-red-600 font-bold flex-shrink-0">✕</span>
                                    <span>{{ __('app.no_new_bookings') }}</span>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- No License -->
                        <div class="mb-3 sm:mb-4 p-3 bg-gray-50 rounded border border-gray-200">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-1">{{ __('app.no_license') }}</h3>
                            <p class="text-gray-700 text-xs sm:text-sm">{{ __('app.no_active_license_assigned') }}</p>
                        </div>
                    @endif

                    <!-- Contact Support -->
                    <div class="p-2 bg-blue-50 rounded border border-blue-200">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-1">{{ __('app.need_help') }}</h3>
                        <p class="text-gray-700 text-xs sm:text-sm mb-2">
                            {{ __('app.contact_support_reactivate') }}
                        </p>
                        <div class="flex flex-col gap-1">
                            <a href="mailto:support@bookingapp.com"
                                class="block text-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs sm:text-sm font-semibold">
                                {{ __('app.contact_support') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full px-3 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-xs sm:text-sm font-semibold">
                                    {{ __('app.sign_out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-3 sm:px-5 py-1 sm:py-2 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-600">
                        {{ __('app.reactivate_license') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>