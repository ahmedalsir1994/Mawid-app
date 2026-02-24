<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%23667eea' width='100' height='100'/><text x='50' y='65' font-size='70' font-weight='bold' fill='white' text-anchor='middle' font-family='Arial'>M</text></svg>">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BookingApp') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
        }
        
        .nav-active {
            @apply border-b-4 border-purple-600 text-purple-700;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">BA</span>
                            </div>
                            <span
                                class="font-bold text-lg text-gray-800 hidden sm:block">{{ config('app.name') }}</span>
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Language Switcher -->
                        <div class="flex gap-1 bg-gray-100 rounded-lg p-1">
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="px-2 py-1 text-xs font-medium rounded transition {{ app()->getLocale() === 'en' ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                                EN
                            </a>
                            <a href="{{ route('lang.switch', 'ar') }}"
                                class="px-2 py-1 text-xs font-medium rounded transition {{ app()->getLocale() === 'ar' ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                                AR
                            </a>
                        </div>
                        
                        <div class="relative">
                            <button onclick="document.getElementById('userMenu').classList.toggle('hidden')"
                                class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg transition">
                                <div class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-purple-700 font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <span
                                    class="hidden sm:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="userMenu"
                                class="hidden absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg z-50 border border-gray-200">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Profile Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Page Header -->
                @isset($header)
                    <div class="mb-8">
                        {{ $header }}
                    </div>
                @endisset

                <!-- Content -->
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-600 text-sm">
                <p>&copy; 2026 {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        // Close user dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const userMenu = document.getElementById('userMenu');
            if (!event.target.closest('[onclick*="userMenu"]')) {
                userMenu?.classList.add('hidden');
            }
        });
    </script>
</body>

</html>