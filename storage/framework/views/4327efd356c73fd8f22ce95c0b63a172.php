<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/Mawidly-fav.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <title><?php echo e(__('blog.meta_title')); ?></title>
    <meta name="description" content="<?php echo e(__('blog.meta_description')); ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Mawid">
    <link rel="canonical" href="<?php echo e(url('/blog')); ?>">

    
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?php echo e(url('/blog')); ?>">
    <meta property="og:title"       content="<?php echo e(__('blog.meta_og_title')); ?>">
    <meta property="og:description" content="<?php echo e(__('blog.meta_og_desc')); ?>">
    <meta property="og:image"       content="<?php echo e(asset('/images/Mawid.png')); ?>">
    <meta property="og:locale"      content="<?php echo e(str_replace('-', '_', app()->getLocale() === 'ar' ? 'ar_OM' : 'en_US')); ?>">
    <meta property="og:site_name"   content="<?php echo e(config('app.name')); ?>">

    
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?php echo e(__('blog.meta_og_title')); ?>">
    <meta name="twitter:description" content="<?php echo e(__('blog.meta_og_desc')); ?>">
    <meta name="twitter:image"       content="<?php echo e(asset('/images/Mawid.png')); ?>">

    
    <?php
    $jsonLd = [
        '@context'  => 'https://schema.org',
        '@type'     => 'Blog',
        'name'      => config('app.name') . ' Blog',
        'description' => __('blog.meta_description'),
        'url'       => url('/blog'),
        'publisher' => [
            '@type' => 'Organization',
            'name'  => config('app.name'),
            'logo'  => ['@type' => 'ImageObject', 'url' => asset('/images/Mawid.png')],
        ],
        'blogPost' => [
            [
                '@type'          => 'BlogPosting',
                'headline'       => __('blog.featured_title'),
                'description'    => __('blog.featured_excerpt'),
                'datePublished'  => '2026-03-01',
                'author'         => ['@type' => 'Person', 'name' => __('blog.featured_author')],
                'url'            => url('/blog'),
            ],
            [
                '@type'          => 'BlogPosting',
                'headline'       => __('blog.p1_title'),
                'description'    => __('blog.p1_excerpt'),
                'datePublished'  => '2026-02-25',
                'author'         => ['@type' => 'Person', 'name' => __('blog.p1_author')],
                'url'            => url('/blog'),
            ],
            [
                '@type'          => 'BlogPosting',
                'headline'       => __('blog.p3_title'),
                'description'    => __('blog.p3_excerpt'),
                'datePublished'  => '2026-02-15',
                'author'         => ['@type' => 'Person', 'name' => __('blog.p3_author')],
                'url'            => url('/blog'),
            ],
        ],
    ];
    ?>
    <script type="application/ld+json"><?php echo json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #000000 0%, #0ba83a 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #000000 0%, #0ba83a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(11, 168, 58, 0.13);
        }
        .category-pill.active {
            background: #16a34a;
            color: #ffffff;
        }
        .featured-gradient {
            background: linear-gradient(135deg, #022c22 0%, #14532d 60%, #166534 100%);
        }
        .cat-badge {
            font-size: 0.65rem;
            letter-spacing: 0.08em;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">

    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('navbar'); ?>

    <main>

        
        <header class="hero-bg relative overflow-hidden pt-32 pb-20">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-green-400 opacity-10 rounded-full blur-3xl -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-green-300 opacity-10 rounded-full blur-3xl translate-y-1/2"></div>
            </div>

            <div class="relative max-w-4xl mx-auto px-6 text-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-green-600/20 border border-green-400/30 text-green-300 text-xs font-semibold uppercase tracking-widest mb-5">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <?php echo e(__('blog.hero_badge')); ?>

                </span>
                <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight mb-5">
                    <?php echo e(__('blog.hero_title')); ?>

                </h1>
                <p class="text-lg text-green-100 max-w-xl mx-auto mb-8">
                    <?php echo e(__('blog.hero_subtitle')); ?>

                </p>

                
            </div>
        </header>

        

        
        <section class="bg-white py-14">
            <div class="max-w-6xl mx-auto px-6">

                <div class="flex items-center gap-2 mb-7">
                    <span class="w-7 h-0.5 bg-green-600 rounded-full"></span>
                    <span class="text-xs font-bold uppercase tracking-widest text-green-600"><?php echo e(__('blog.featured_label')); ?></span>
                </div>

                <article class="featured-gradient rounded-3xl overflow-hidden shadow-xl grid md:grid-cols-5" aria-label="<?php echo e(__('blog.featured_title')); ?>">

                    
                    <div class="hidden md:flex md:col-span-2 items-center justify-center p-12 relative">
                        <div class="absolute inset-0 opacity-10">
                            <svg viewBox="0 0 400 400" class="w-full h-full" fill="none">
                                <circle cx="200" cy="200" r="200" fill="white"/>
                                <circle cx="200" cy="200" r="150" stroke="white" stroke-width="0.5"/>
                                <circle cx="200" cy="200" r="100" stroke="white" stroke-width="0.5"/>
                                <circle cx="200" cy="200" r="50"  stroke="white" stroke-width="0.5"/>
                            </svg>
                        </div>
                        <div class="relative text-center">
                            <div class="w-24 h-24 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-4 border border-white/20">
                                <svg class="w-12 h-12 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <p class="text-green-300 text-sm font-semibold"><?php echo e(__('blog.featured_category')); ?></p>
                        </div>
                    </div>

                    
                    <div class="md:col-span-3 p-10 md:p-12 flex flex-col justify-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-500/20 text-green-300 cat-badge font-bold uppercase tracking-wider mb-5 w-fit">
                            <?php echo e(__('blog.featured_category')); ?>

                        </span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-white leading-snug mb-4">
                            <?php echo e(__('blog.featured_title')); ?>

                        </h2>
                        <p class="text-green-100 leading-relaxed mb-7 text-sm md:text-base">
                            <?php echo e(__('blog.featured_excerpt')); ?>

                        </p>
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-3 text-sm text-green-300">
                                <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white text-xs font-bold">
                                    <?php echo e(mb_strtoupper(mb_substr(__('blog.featured_author'), 0, 1))); ?>

                                </div>
                                <span><?php echo e(__('blog.by')); ?> <strong class="text-white"><?php echo e(__('blog.featured_author')); ?></strong></span>
                                <span>·</span>
                                <time datetime="2026-03-01"><?php echo e(__('blog.featured_date')); ?></time>
                                <span>·</span>
                                <span><?php echo e(__('blog.featured_read_time')); ?></span>
                            </div>
                            <a href="#" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-500 hover:bg-green-400 text-white text-sm font-semibold rounded-xl transition shadow">
                                <?php echo e(__('blog.featured_read')); ?>

                            </a>
                        </div>
                    </div>

                </article>
            </div>
        </section>

        
        <section class="bg-gray-50 py-14">
            <div class="max-w-6xl mx-auto px-6">

                <div class="flex items-center gap-2 mb-9">
                    <span class="w-7 h-0.5 bg-green-600 rounded-full"></span>
                    <span class="text-xs font-bold uppercase tracking-widest text-green-600"><?php echo e(__('blog.latest_posts')); ?></span>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">

                    
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 cat-badge font-bold uppercase tracking-wider mb-3 w-fit"><?php echo e(__('blog.p1_category')); ?></span>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                                <a href="#" class="hover:text-green-700 transition"><?php echo e(__('blog.p1_title')); ?></a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-5"><?php echo e(__('blog.p1_excerpt')); ?></p>
                            <footer class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center text-white font-bold" style="font-size:10px">
                                        <?php echo e(mb_strtoupper(mb_substr(__('blog.p1_author'), 0, 1))); ?>

                                    </div>
                                    <span><?php echo e(__('blog.p1_author')); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <time datetime="2026-02-25"><?php echo e(__('blog.p1_date')); ?></time>
                                    <span>·</span>
                                    <span><?php echo e(__('blog.p1_read_time')); ?></span>
                                </div>
                            </footer>
                        </div>
                    </article>

                    
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 cat-badge font-bold uppercase tracking-wider mb-3 w-fit"><?php echo e(__('blog.p2_category')); ?></span>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                                <a href="#" class="hover:text-green-700 transition"><?php echo e(__('blog.p2_title')); ?></a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-5"><?php echo e(__('blog.p2_excerpt')); ?></p>
                            <footer class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-700 flex items-center justify-center text-white font-bold" style="font-size:10px">
                                        <?php echo e(mb_strtoupper(mb_substr(__('blog.p2_author'), 0, 1))); ?>

                                    </div>
                                    <span><?php echo e(__('blog.p2_author')); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <time datetime="2026-02-20"><?php echo e(__('blog.p2_date')); ?></time>
                                    <span>·</span>
                                    <span><?php echo e(__('blog.p2_read_time')); ?></span>
                                </div>
                            </footer>
                        </div>
                    </article>

                    
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-emerald-50 to-green-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 cat-badge font-bold uppercase tracking-wider mb-3 w-fit"><?php echo e(__('blog.p3_category')); ?></span>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                                <a href="#" class="hover:text-green-700 transition"><?php echo e(__('blog.p3_title')); ?></a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-5"><?php echo e(__('blog.p3_excerpt')); ?></p>
                            <footer class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center text-white font-bold" style="font-size:10px">
                                        <?php echo e(mb_strtoupper(mb_substr(__('blog.p3_author'), 0, 1))); ?>

                                    </div>
                                    <span><?php echo e(__('blog.p3_author')); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <time datetime="2026-02-15"><?php echo e(__('blog.p3_date')); ?></time>
                                    <span>·</span>
                                    <span><?php echo e(__('blog.p3_read_time')); ?></span>
                                </div>
                            </footer>
                        </div>
                    </article>

                    
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-green-700 to-green-900 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 cat-badge font-bold uppercase tracking-wider mb-3 w-fit"><?php echo e(__('blog.p4_category')); ?></span>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                                <a href="#" class="hover:text-green-700 transition"><?php echo e(__('blog.p4_title')); ?></a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-5"><?php echo e(__('blog.p4_excerpt')); ?></p>
                            <footer class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center text-white font-bold" style="font-size:10px">
                                        <?php echo e(mb_strtoupper(mb_substr(__('blog.p4_author'), 0, 1))); ?>

                                    </div>
                                    <span><?php echo e(__('blog.p4_author')); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <time datetime="2026-02-10"><?php echo e(__('blog.p4_date')); ?></time>
                                    <span>·</span>
                                    <span><?php echo e(__('blog.p4_read_time')); ?></span>
                                </div>
                            </footer>
                        </div>
                    </article>

                    
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-green-50 to-teal-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 cat-badge font-bold uppercase tracking-wider mb-3 w-fit"><?php echo e(__('blog.p5_category')); ?></span>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                                <a href="#" class="hover:text-green-700 transition"><?php echo e(__('blog.p5_title')); ?></a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-5"><?php echo e(__('blog.p5_excerpt')); ?></p>
                            <footer class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-700 flex items-center justify-center text-white font-bold" style="font-size:10px">
                                        <?php echo e(mb_strtoupper(mb_substr(__('blog.p5_author'), 0, 1))); ?>

                                    </div>
                                    <span><?php echo e(__('blog.p5_author')); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <time datetime="2026-02-05"><?php echo e(__('blog.p5_date')); ?></time>
                                    <span>·</span>
                                    <span><?php echo e(__('blog.p5_read_time')); ?></span>
                                </div>
                            </footer>
                        </div>
                    </article>

                    
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-green-800 to-green-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 cat-badge font-bold uppercase tracking-wider mb-3 w-fit"><?php echo e(__('blog.p6_category')); ?></span>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                                <a href="#" class="hover:text-green-700 transition"><?php echo e(__('blog.p6_title')); ?></a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-5"><?php echo e(__('blog.p6_excerpt')); ?></p>
                            <footer class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center text-white font-bold" style="font-size:10px">
                                        <?php echo e(mb_strtoupper(mb_substr(__('blog.p6_author'), 0, 1))); ?>

                                    </div>
                                    <span><?php echo e(__('blog.p6_author')); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <time datetime="2026-01-28"><?php echo e(__('blog.p6_date')); ?></time>
                                    <span>·</span>
                                    <span><?php echo e(__('blog.p6_read_time')); ?></span>
                                </div>
                            </footer>
                        </div>
                    </article>

                </div>

                
                <p class="text-center text-sm text-gray-400 mt-10 italic"><?php echo e(__('blog.coming_soon')); ?></p>

            </div>
        </section>

       

        
        <section class="hero-bg relative overflow-hidden py-20">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 right-1/3 w-80 h-80 bg-green-400 opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-green-300 opacity-10 rounded-full blur-3xl"></div>
            </div>
            <div class="relative max-w-2xl mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 leading-snug"><?php echo e(__('blog.cta_title')); ?></h2>
                <p class="text-green-100 mb-8 leading-relaxed"><?php echo e(__('blog.cta_subtitle')); ?></p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="<?php echo e(route('register')); ?>"
                       class="w-full sm:w-auto px-7 py-3.5 bg-white text-green-700 font-bold rounded-xl shadow hover:shadow-md transition text-center text-sm">
                        <?php echo e(__('blog.cta_btn_primary')); ?>

                    </a>
                    <a href="<?php echo e(route('landing')); ?>#features"
                       class="w-full sm:w-auto px-7 py-3.5 bg-white/10 hover:bg-white/20 border border-white/25 text-white font-semibold rounded-xl transition text-center text-sm">
                        <?php echo e(__('blog.cta_btn_secondary')); ?>

                    </a>
                </div>
            </div>
        </section>

    </main>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('footer'); ?>

    
    <script>
        document.querySelectorAll('.category-pill').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-pill').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>

</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views\blog.blade.php ENDPATH**/ ?>