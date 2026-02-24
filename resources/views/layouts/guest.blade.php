<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%23667eea' width='100' height='100'/><text x='50' y='65' font-size='70' font-weight='bold' fill='white' text-anchor='middle' font-family='Arial'>M</text></svg>">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mawid App</title>

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
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Language Switcher -->
    <div class="fixed top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} z-50">
        <div class="flex gap-2 bg-white rounded-lg shadow-lg border border-gray-200 p-2">
            <a href="{{ route('lang.switch', 'en') }}"
                class="px-3 py-1.5 text-sm font-medium rounded transition {{ app()->getLocale() === 'en' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                EN
            </a>
            <a href="{{ route('lang.switch', 'ar') }}"
                class="px-3 py-1.5 text-sm font-medium rounded transition {{ app()->getLocale() === 'ar' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                AR
            </a>
        </div>
    </div>
    
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 via-white to-gray-100">
        <!-- Logo Section -->
        <div class="w-full sm:max-w-md px-6 py-4 bg-white rounded-lg shadow-lg">
            <div class="flex justify-center mb-6">
                <a href="/"
                    class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Mawid App
                </a>
            </div>

            {{ $slot }}
        </div>

        <!-- Decorative Elements -->
        <div
            class="absolute top-0 right-0 -z-10 w-96 h-96 bg-gradient-to-bl from-purple-200 to-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute bottom-0 left-0 -z-10 w-96 h-96 bg-gradient-to-tr from-pink-200 to-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
    </div>

    <style>
        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>

</html>