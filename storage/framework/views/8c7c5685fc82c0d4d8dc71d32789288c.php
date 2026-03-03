<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/Mawidly-fav.png')); ?>">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'BookingApp')); ?> - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        [dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
        }
        
        .nav-active {
            @apply border-b-4 border-green-600 text-green-700;
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
                    <a href="<?php echo e(route('landing')); ?>">
                        <img src="/images/Mawid.png" alt="Mawid App" class="h-10 w-auto"></div>

                    </a>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Home Button -->
                        <a href="<?php echo e(route('landing')); ?>"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="hidden sm:inline"><?php echo e(__('app.home')); ?></span>
                        </a>

                        <!-- Language Switcher -->
                        <div class="flex gap-1 bg-gray-100 rounded-lg p-1">
                            <a href="<?php echo e(route('lang.switch', 'en')); ?>"
                                class="px-2 py-1 text-xs font-medium rounded transition <?php echo e(app()->getLocale() === 'en' ? 'bg-green-600 text-white' : 'text-gray-700 hover:bg-gray-200'); ?>">
                                EN
                            </a>
                            <a href="<?php echo e(route('lang.switch', 'ar')); ?>"
                                class="px-2 py-1 text-xs font-medium rounded transition <?php echo e(app()->getLocale() === 'ar' ? 'bg-green-600 text-white' : 'text-gray-700 hover:bg-gray-200'); ?>">
                                AR
                            </a>
                        </div>
                        
                        <div class="relative">
                            <button onclick="document.getElementById('userMenu').classList.toggle('hidden')"
                                class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg transition">
                                <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-green-700 font-bold text-sm"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                                </div>
                                <span
                                    class="hidden sm:block text-sm font-medium text-gray-700"><?php echo e(auth()->user()->name); ?></span>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="userMenu"
                                class="hidden absolute <?php echo e(app()->getLocale() === 'ar' ? 'left-0' : 'right-0'); ?> mt-2 w-48 bg-white rounded-lg shadow-lg z-50 border border-gray-200">
                                <a href="<?php echo e(route('profile.edit')); ?>"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                    Profile Settings
                                </a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                                    <?php echo csrf_field(); ?>
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
                <?php if(isset($header)): ?>
                    <div class="mb-8">
                        <?php echo e($header); ?>

                    </div>
                <?php endif; ?>

                <!-- Content -->
                <?php echo e($slot); ?>

            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-600 text-sm">
                <p>&copy; 2026 <?php echo e(config('app.name')); ?>. All rights reserved.</p>
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

</html><?php /**PATH C:\laragon\www\booking-app\resources\views/layouts/user.blade.php ENDPATH**/ ?>