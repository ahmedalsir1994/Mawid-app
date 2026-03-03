<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Unavailable</title>
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">Service Unavailable</h1>
                <p class="text-gray-600 mb-8">
                    {{ $exception->getMessage() ?: 'This business is currently unavailable for bookings.' }}
                </p>

                <a href="{{ route('landing') }}"
                    class="inline-block px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-semibold rounded-lg hover:shadow-lg transition">
                    Return Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>