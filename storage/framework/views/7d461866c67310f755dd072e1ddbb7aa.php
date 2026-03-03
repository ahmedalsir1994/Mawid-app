<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/Mawidly-fav.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__('privacy.privacy_title')); ?></title>
    <!-- Fonts -->  
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans text-gray-900 antialiased">
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('navbar'); ?>

    

    <div class="bg-gray-50 min-h-screen py-20 ">
    <div class="max-w-4xl mx-auto px-6 bg-white shadow-sm rounded-2xl p-8">

        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <?php echo e(__('privacy.privacy_title')); ?>

        </h1>
        <p class="text-sm text-gray-500 mb-8">
            <?php echo e(__('privacy.last_updated')); ?> 03/03/2026
        </p>

        <!-- Section -->
        <div class="space-y-10 text-gray-700 leading-relaxed">

            <!-- 1 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s1_title')); ?></h2>
                <p><?php echo e(__('privacy.s1_p1')); ?></p>
                <p class="mt-3"><?php echo e(__('privacy.s1_p2')); ?></p>
                <p class="mt-3"><?php echo e(__('privacy.s1_p3')); ?></p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li><?php echo e(__('privacy.s1_li1')); ?></li>
                    <li><?php echo e(__('privacy.s1_li2')); ?></li>
                    <li><?php echo e(__('privacy.s1_li3')); ?></li>
                    <li><?php echo e(__('privacy.s1_li4')); ?></li>
                </ul>
                <p class="mt-3"><?php echo e(__('privacy.s1_p4')); ?></p>
            </section>

            <!-- 2 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s2_title')); ?></h2>

                <h3 class="font-semibold mt-4"><?php echo e(__('privacy.s2_sub1')); ?></h3>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li><?php echo e(__('privacy.s2_1_li1')); ?></li>
                    <li><?php echo e(__('privacy.s2_1_li2')); ?></li>
                    <li><?php echo e(__('privacy.s2_1_li3')); ?></li>
                    <li><?php echo e(__('privacy.s2_1_li4')); ?></li>
                    <li><?php echo e(__('privacy.s2_1_li5')); ?></li>
                </ul>

                <h3 class="font-semibold mt-6"><?php echo e(__('privacy.s2_sub2')); ?></h3>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li><?php echo e(__('privacy.s2_2_li1')); ?></li>
                    <li><?php echo e(__('privacy.s2_2_li2')); ?></li>
                    <li><?php echo e(__('privacy.s2_2_li3')); ?></li>
                    <li><?php echo e(__('privacy.s2_2_li4')); ?></li>
                    <li><?php echo e(__('privacy.s2_2_li5')); ?></li>
                </ul>

                <h3 class="font-semibold mt-6"><?php echo e(__('privacy.s2_sub3')); ?></h3>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li><?php echo e(__('privacy.s2_3_li1')); ?></li>
                    <li><?php echo e(__('privacy.s2_3_li2')); ?></li>
                    <li><?php echo e(__('privacy.s2_3_li3')); ?></li>
                </ul>
            </section>

            <!-- 3 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s3_title')); ?></h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li><?php echo e(__('privacy.s3_li1')); ?></li>
                    <li><?php echo e(__('privacy.s3_li2')); ?></li>
                    <li><?php echo e(__('privacy.s3_li3')); ?></li>
                    <li><?php echo e(__('privacy.s3_li4')); ?></li>
                    <li><?php echo e(__('privacy.s3_li5')); ?></li>
                    <li><?php echo e(__('privacy.s3_li6')); ?></li>
                    <li><?php echo e(__('privacy.s3_li7')); ?></li>
                </ul>
                <p class="mt-4 font-medium"><?php echo e(__('privacy.s3_no_sell')); ?></p>
            </section>

            <!-- 4 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s4_title')); ?></h2>

                <h3 class="font-semibold mt-4"><?php echo e(__('privacy.s4_sub1')); ?></h3>
                <p><?php echo e(__('privacy.s4_p1')); ?></p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li><?php echo e(__('privacy.s4_1_li1')); ?></li>
                    <li><?php echo e(__('privacy.s4_1_li2')); ?></li>
                    <li><?php echo e(__('privacy.s4_1_li3')); ?></li>
                </ul>
                <p class="mt-2"><?php echo e(__('privacy.s4_p2')); ?></p>

                <h3 class="font-semibold mt-6"><?php echo e(__('privacy.s4_sub2')); ?></h3>
                <p><?php echo e(__('privacy.s4_p3')); ?></p>

                <h3 class="font-semibold mt-6"><?php echo e(__('privacy.s4_sub3')); ?></h3>
                <p><?php echo e(__('privacy.s4_p4')); ?></p>
            </section>

            <!-- 5 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s5_title')); ?></h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li><?php echo e(__('privacy.s5_li1')); ?></li>
                    <li><?php echo e(__('privacy.s5_li2')); ?></li>
                    <li><?php echo e(__('privacy.s5_li3')); ?></li>
                </ul>
                <p class="mt-3"><?php echo e(__('privacy.s5_p1')); ?></p>
            </section>

            <!-- 6 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s6_title')); ?></h2>
                <p><?php echo e(__('privacy.s6_p1')); ?></p>
                <p class="mt-3"><?php echo e(__('privacy.s6_p2')); ?></p>
            </section>

            <!-- 7 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s7_title')); ?></h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li><?php echo e(__('privacy.s7_li1')); ?></li>
                    <li><?php echo e(__('privacy.s7_li2')); ?></li>
                    <li><?php echo e(__('privacy.s7_li3')); ?></li>
                    <li><?php echo e(__('privacy.s7_li4')); ?></li>
                </ul>
                <p class="mt-4"><?php echo e(__('privacy.s7_p1')); ?></p>
                <p class="mt-2 font-medium">📧 mawid.om@gmail.com</p>
                <p class="mt-2"><?php echo e(__('privacy.s7_p2')); ?></p>
            </section>

            <!-- 8 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s8_title')); ?></h2>
                <p><?php echo e(__('privacy.s8_p1')); ?></p>
                <p class="mt-3"><?php echo e(__('privacy.s8_p2')); ?></p>
            </section>

            <!-- 9 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s9_title')); ?></h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li><?php echo e(__('privacy.s9_li1')); ?></li>
                    <li><?php echo e(__('privacy.s9_li2')); ?></li>
                    <li><?php echo e(__('privacy.s9_li3')); ?></li>
                </ul>
                <p class="mt-3"><?php echo e(__('privacy.s9_p1')); ?></p>
            </section>

            <!-- 10 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s10_title')); ?></h2>
                <p><?php echo e(__('privacy.s10_p1')); ?></p>
                <p class="mt-3"><?php echo e(__('privacy.s10_p2')); ?></p>
            </section>

            <!-- 11 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s11_title')); ?></h2>
                <p><?php echo e(__('privacy.s11_p1')); ?></p>
                <p class="mt-3"><?php echo e(__('privacy.s11_p2')); ?></p>
                <p class="mt-3"><?php echo e(__('privacy.s11_p3')); ?></p>
            </section>

            <!-- 12 -->
            <section>
                <h2 class="text-xl font-semibold mb-3"><?php echo e(__('privacy.s12_title')); ?></h2>
                <p><?php echo e(__('privacy.s12_p1')); ?></p>
                <p class="mt-3 font-medium">
                    Mawid.om@gmail.com<br>
                    <?php echo e(__('privacy.s12_address')); ?>

                </p>
            </section>

        </div>
    </div>
</div>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('footer'); ?>
</body>
</html>
   <?php /**PATH C:\laragon\www\booking-app\resources\views\privacy.blade.php ENDPATH**/ ?>