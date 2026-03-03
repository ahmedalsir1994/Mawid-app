<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/Mawidly-fav.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__('about.page_title')); ?></title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #000000 0%, #0ba83a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-bg {
            background: linear-gradient(135deg, #000000 0%, #0ba83a 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(11, 168, 58, 0.15);
        }
        .founder-card {
            background: linear-gradient(145deg, #ffffff 0%, #f0fdf4 100%);
        }
        .value-icon-bg {
            background: linear-gradient(135deg, #16a34a 0%, #166534 100%);
        }
        .story-line {
            background: linear-gradient(180deg, #16a34a 0%, #0ba83a 100%);
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">

    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('navbar'); ?>

    
    <section class="hero-bg relative overflow-hidden pt-32 pb-24">
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-green-500 opacity-10 rounded-full blur-3xl -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-green-400 opacity-10 rounded-full blur-3xl translate-y-1/2"></div>

        <div class="relative max-w-5xl mx-auto px-6 text-center">
            <!-- Badge -->
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-green-600/20 border border-green-500/30 text-green-300 text-sm font-medium mb-6 uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <?php echo e(__('about.hero_badge')); ?>

            </span>

            <!-- Headline -->
            <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6">
                <?php echo e(__('about.hero_title_1')); ?>

                <br>
                <span class="gradient-text"><?php echo e(__('about.hero_title_2')); ?></span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                <?php echo e(__('about.hero_subtitle')); ?>

            </p>
        </div>
    </section>

    
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-5xl mx-auto px-6 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1"><?php echo e(__('about.stat_founded')); ?></p>
                    <p class="text-2xl font-extrabold text-green-600"><?php echo e(__('about.stat_founded_val')); ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1"><?php echo e(__('about.stat_country')); ?></p>
                    <p class="text-2xl font-extrabold text-green-600"><?php echo e(__('about.stat_country_val')); ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1"><?php echo e(__('about.stat_focus')); ?></p>
                    <p class="text-2xl font-extrabold text-green-600"><?php echo e(__('about.stat_focus_val')); ?></p>
                </div>
                
            </div>
        </div>
    </div>

    
    <section class="bg-gray-50 py-24">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10">

            <!-- Mission -->
            <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100 card-hover">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 text-green-600 text-xs font-semibold uppercase tracking-widest mb-5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <?php echo e(__('about.mission_badge')); ?>

                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php echo e(__('about.mission_title')); ?></h2>
                <p class="text-gray-600 leading-relaxed"><?php echo e(__('about.mission_body')); ?></p>
            </div>

            <!-- Vision -->
            <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-3xl p-10 shadow-lg card-hover">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold uppercase tracking-widest mb-5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <?php echo e(__('about.vision_badge')); ?>

                </div>
                <h2 class="text-2xl font-bold text-white mb-4"><?php echo e(__('about.vision_title')); ?></h2>
                <p class="text-green-100 leading-relaxed"><?php echo e(__('about.vision_body')); ?></p>
            </div>

        </div>
    </section>

    
    <section class="bg-white py-24">
        <div class="max-w-5xl mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-green-50 text-green-600 text-xs font-semibold uppercase tracking-widest mb-4">
                    <?php echo e(__('about.story_badge')); ?>

                </span>
                <h2 class="text-4xl font-extrabold text-gray-900"><?php echo e(__('about.story_title')); ?></h2>
            </div>

            <!-- Timeline -->
            <div class="relative">
                <!-- Vertical line -->
                <div class="absolute <?php echo e(app()->getLocale() === 'ar' ? 'right-6 md:right-1/2' : 'left-6 md:left-1/2'); ?> top-0 bottom-0 w-0.5 story-line opacity-20 transform md:-translate-x-px"></div>

                <!-- Paragraph 1 -->
                <div class="relative flex flex-col md:flex-row items-start md:items-center gap-8 mb-14">
                    <div class="hidden md:flex flex-1 justify-end pe-12">
                        <p class="text-gray-600 leading-relaxed text-right max-w-sm <?php echo e(app()->getLocale() === 'ar' ? '' : 'rtl:text-left ltr:text-right'); ?>">
                            <?php echo e(__('about.story_p1')); ?>

                        </p>
                    </div>
                    <div class="relative z-10 flex-shrink-0 w-12 h-12 rounded-full bg-green-600 flex items-center justify-center shadow-md shadow-green-200 text-white font-bold text-lg">
                        1
                    </div>
                    <div class="flex-1 ps-0 md:ps-12 md:hidden">
                        <p class="text-gray-600 leading-relaxed"><?php echo e(__('about.story_p1')); ?></p>
                    </div>
                    <div class="hidden md:block flex-1 ps-12">
                        <!-- empty right column for p1 -->
                    </div>
                </div>

                <!-- Paragraph 2 -->
                <div class="relative flex flex-col md:flex-row items-start md:items-center gap-8 mb-14">
                    <div class="hidden md:flex flex-1 justify-end pe-12">
                        <!-- empty left column for p2 -->
                    </div>
                    <div class="relative z-10 flex-shrink-0 w-12 h-12 rounded-full bg-green-700 flex items-center justify-center shadow-md shadow-green-200 text-white font-bold text-lg">
                        2
                    </div>
                    <div class="flex-1 ps-0 md:ps-12">
                        <p class="text-gray-600 leading-relaxed max-w-sm"><?php echo e(__('about.story_p2')); ?></p>
                    </div>
                </div>

                <!-- Paragraph 3 -->
                <div class="relative flex flex-col md:flex-row items-start md:items-center gap-8">
                    <div class="hidden md:flex flex-1 justify-end pe-12">
                        <p class="text-gray-600 leading-relaxed text-right max-w-sm <?php echo e(app()->getLocale() === 'ar' ? '' : ''); ?>">
                            <?php echo e(__('about.story_p3')); ?>

                        </p>
                    </div>
                    <div class="relative z-10 flex-shrink-0 w-12 h-12 rounded-full bg-green-600 flex items-center justify-center shadow-md shadow-green-200 text-white font-bold text-lg">
                        3
                    </div>
                    <div class="flex-1 ps-0 md:ps-12 md:hidden">
                        <p class="text-gray-600 leading-relaxed"><?php echo e(__('about.story_p3')); ?></p>
                    </div>
                    <div class="hidden md:block flex-1 ps-12">
                        <!-- empty right column for p3 -->
                    </div>
                </div>
            </div>

        </div>
    </section>

    
    <section class="bg-gray-50 py-24">
        <div class="max-w-5xl mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-14">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-green-50 text-green-600 text-xs font-semibold uppercase tracking-widest mb-4">
                    <?php echo e(__('about.founders_badge')); ?>

                </span>
                <h2 class="text-4xl font-extrabold text-gray-900 mb-3"><?php echo e(__('about.founders_title')); ?></h2>
                <p class="text-gray-500 max-w-xl mx-auto"><?php echo e(__('about.founders_subtitle')); ?></p>
            </div>

            <!-- Founder Cards -->
            <div class="grid md:grid-cols-2 gap-8">

                <!-- Founder 1 : Ahmed -->
                <div class="founder-card rounded-3xl p-8 shadow-sm border border-gray-100 card-hover">
                    <!-- Avatar placeholder -->
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-3xl font-extrabold mb-6 shadow-md">
                        <img src="/images/mawidly-fav.png" alt="">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1"><?php echo e(__('about.founder1_name')); ?></h3>
                    <p class="text-green-600 text-sm font-semibold mb-4"><?php echo e(__('about.founder1_role')); ?></p>
                    <p class="text-gray-600 leading-relaxed text-sm"><?php echo e(__('about.founder1_bio')); ?></p>
                    
                </div>

                <!-- Founder 2 : Warith -->
                <div class="founder-card rounded-3xl p-8 shadow-sm border border-gray-100 card-hover">
                    <!-- Avatar placeholder -->
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-3xl font-extrabold mb-6 shadow-md">
                        <img src="/images/mawidly-fav.png" alt="">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1"><?php echo e(__('about.founder2_name')); ?></h3>
                    <p class="text-green-700 text-sm font-semibold mb-4"><?php echo e(__('about.founder2_role')); ?></p>
                    <p class="text-gray-600 leading-relaxed text-sm"><?php echo e(__('about.founder2_bio')); ?></p>
                    
                </div>

            </div>
        </div>
    </section>

    
    <section class="bg-white py-24">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-14">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-green-50 text-green-600 text-xs font-semibold uppercase tracking-widest mb-4">
                    <?php echo e(__('about.values_badge')); ?>

                </span>
                <h2 class="text-4xl font-extrabold text-gray-900"><?php echo e(__('about.values_title')); ?></h2>
            </div>

            <!-- Values Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">

                <!-- Value 1 -->
                <div class="rounded-2xl border border-gray-100 p-7 shadow-sm card-hover">
                    <div class="value-icon-bg w-11 h-11 rounded-xl flex items-center justify-center text-white mb-5 shadow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e(__('about.value1_title')); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo e(__('about.value1_desc')); ?></p>
                </div>

                <!-- Value 2 -->
                <div class="rounded-2xl border border-gray-100 p-7 shadow-sm card-hover">
                    <div class="value-icon-bg w-11 h-11 rounded-xl flex items-center justify-center text-white mb-5 shadow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e(__('about.value2_title')); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo e(__('about.value2_desc')); ?></p>
                </div>

                <!-- Value 3 -->
                <div class="rounded-2xl border border-gray-100 p-7 shadow-sm card-hover">
                    <div class="value-icon-bg w-11 h-11 rounded-xl flex items-center justify-center text-white mb-5 shadow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e(__('about.value3_title')); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo e(__('about.value3_desc')); ?></p>
                </div>

                <!-- Value 4 -->
                <div class="rounded-2xl border border-gray-100 p-7 shadow-sm card-hover">
                    <div class="value-icon-bg w-11 h-11 rounded-xl flex items-center justify-center text-white mb-5 shadow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e(__('about.value4_title')); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo e(__('about.value4_desc')); ?></p>
                </div>

                <!-- Value 5 -->
                <div class="rounded-2xl border border-gray-100 p-7 shadow-sm card-hover">
                    <div class="value-icon-bg w-11 h-11 rounded-xl flex items-center justify-center text-white mb-5 shadow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e(__('about.value5_title')); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo e(__('about.value5_desc')); ?></p>
                </div>

                <!-- Value 6 -->
                <div class="rounded-2xl border border-gray-100 p-7 shadow-sm card-hover">
                    <div class="value-icon-bg w-11 h-11 rounded-xl flex items-center justify-center text-white mb-5 shadow">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e(__('about.value6_title')); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo e(__('about.value6_desc')); ?></p>
                </div>

            </div>
        </div>
    </section>

    
    <section class="hero-bg py-24 relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-1/3 w-80 h-80 bg-green-500 opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-green-400 opacity-10 rounded-full blur-3xl"></div>

        <div class="relative max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-5 leading-tight">
                <?php echo e(__('about.cta_title')); ?>

            </h2>
            <p class="text-lg text-gray-300 mb-10">
                <?php echo e(__('about.cta_subtitle')); ?>

            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?php echo e(route('register')); ?>"
                   class="w-full sm:w-auto px-8 py-4 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 text-center">
                    <?php echo e(__('about.cta_btn_primary')); ?>

                </a>
                <a href="mailto:hello@mawid.app"
                   class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold rounded-xl transition-all duration-200 text-center">
                    <?php echo e(__('about.cta_btn_secondary')); ?>

                </a>
            </div>
        </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('footer'); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views\about.blade.php ENDPATH**/ ?>