<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/Mawidly-fav.png')); ?>">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Mawid App</title>

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
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
   
    
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 via-white to-gray-100">
        <!-- Logo Section -->
        <div class="w-full sm:max-w-md px-6 py-4 bg-white rounded-lg shadow-lg">
            <div class="flex justify-center mb-6">
                <img src="/images/Mawid.png" alt="Mawid App" class="h-10 w-auto">
            </div>

            <?php echo e($slot); ?>

        </div>

        <!-- Decorative Elements -->
        <div
            class="absolute top-0 right-0 -z-10 w-96 h-96 bg-gradient-to-bl from-green-200 to-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute bottom-0 left-0 -z-10 w-96 h-96 bg-gradient-to-tr from-green-200 to-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
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

</html><?php /**PATH C:\laragon\www\booking-app\resources\views\layouts\guest.blade.php ENDPATH**/ ?>