<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/Mawidly-fav.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <title><?php echo e(__('contact.meta_title')); ?></title>
    <meta name="description" content="<?php echo e(__('contact.meta_description')); ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Mawid">
    <link rel="canonical" href="<?php echo e(url('/contact')); ?>">

    
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?php echo e(url('/contact')); ?>">
    <meta property="og:title"       content="<?php echo e(__('contact.meta_og_title')); ?>">
    <meta property="og:description" content="<?php echo e(__('contact.meta_og_desc')); ?>">
    <meta property="og:image"       content="<?php echo e(asset('/images/Mawid.png')); ?>">
    <meta property="og:site_name"   content="<?php echo e(config('app.name')); ?>">

    
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?php echo e(__('contact.meta_og_title')); ?>">
    <meta name="twitter:description" content="<?php echo e(__('contact.meta_og_desc')); ?>">
    <meta name="twitter:image"       content="<?php echo e(asset('/images/Mawid.png')); ?>">

    
    <?php
        $contactJsonLd = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => config('app.name'),
            'url'      => url('/'),
            'logo'     => asset('/images/Mawid.png'),
            'email'    => 'mawid.om@gmail.com',
            'address'  => [
                '@type'           => 'PostalAddress',
                'addressLocality' => 'Muscat',
                'addressCountry'  => 'OM',
            ],
            'contactPoint' => [
                [
                    '@type'       => 'ContactPoint',
                    'telephone'   => '+96899822690',
                    'contactType' => 'customer service',
                    'areaServed'  => 'OM',
                ],
                [
                    '@type'       => 'ContactPoint',
                    'telephone'   => '+96897844656',
                    'contactType' => 'technical support',
                    'areaServed'  => 'OM',
                ],
            ],
        ];
    ?>
    <script type="application/ld+json"><?php echo json_encode($contactJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>

    
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
        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(11, 168, 58, 0.13);
        }
        .founder-card {
            background: linear-gradient(145deg, #ffffff 0%, #f0fdf4 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #000000 0%, #0ba83a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .input-field {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .input-field:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
            outline: none;
        }
        .whatsapp-btn {
            background: #25D366;
            transition: background 0.2s ease, transform 0.15s ease;
        }
        .whatsapp-btn:hover {
            background: #1ebe5b;
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">

    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('navbar'); ?>

    <?php
        $isRtl = in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']);
        $iconStart = $isRtl ? 'right-3' : 'left-3';
        $inputPadStart = $isRtl ? 'pr-10 pl-4' : 'pl-10 pr-4';
    ?>

    <main>

        
        <?php if(session('success')): ?>
        <div id="flash-success" class="fixed top-4 inset-x-0 z-50 flex justify-center pointer-events-none">
            <div class="pointer-events-auto max-w-lg w-full mx-4 bg-green-600 text-white rounded-2xl shadow-xl px-6 py-4 flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-semibold flex-1"><?php echo e(session('success')); ?></p>
                <button onclick="document.getElementById('flash-success').remove()" class="flex-shrink-0 text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <script>setTimeout(()=>{const el=document.getElementById('flash-success');if(el)el.remove();},6000);</script>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="fixed top-4 inset-x-0 z-50 flex justify-center pointer-events-none">
            <div class="pointer-events-auto max-w-lg w-full mx-4 bg-red-600 text-white rounded-2xl shadow-xl px-6 py-4">
                <p class="text-sm font-semibold mb-1"><?php echo e(__('contact.validation_error_heading') ?? 'Please fix the errors below:'); ?></p>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        
        <header class="hero-bg relative overflow-hidden pt-32 pb-24">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-green-400 opacity-10 rounded-full blur-3xl -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-green-300 opacity-10 rounded-full blur-3xl translate-y-1/2"></div>
            </div>

            <div class="relative max-w-3xl mx-auto px-6 text-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-green-600/20 border border-green-400/30 text-green-300 text-xs font-semibold uppercase tracking-widest mb-5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <?php echo e(__('contact.hero_badge')); ?>

                </span>
                <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight mb-5">
                    <?php echo e(__('contact.hero_title')); ?>

                </h1>
                <p class="text-lg text-green-100 max-w-xl mx-auto leading-relaxed">
                    <?php echo e(__('contact.hero_subtitle')); ?>

                </p>
            </div>
        </header>

        
        <section class="bg-white py-16">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid sm:grid-cols-3 gap-6">

                    
                    <div class="card-hover rounded-2xl border border-gray-100 bg-white p-7 text-center shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1"><?php echo e(__('contact.card_phone_title')); ?></h3>
                        <p class="text-xs text-gray-400 mb-3"><?php echo e(__('contact.card_phone_subtitle')); ?></p>
                        <a href="tel:+96899822690" class="block text-sm font-semibold text-green-700 hover:text-green-600 transition">+968 99822690</a>
                        <a href="tel:+96897844656" class="block text-sm font-semibold text-green-700 hover:text-green-600 transition mt-1">+968 97844656</a>
                    </div>

                    
                    <div class="card-hover rounded-2xl border border-gray-100 bg-white p-7 text-center shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1"><?php echo e(__('contact.card_email_title')); ?></h3>
                        <p class="text-xs text-gray-400 mb-3"><?php echo e(__('contact.card_email_subtitle')); ?></p>
                        <a href="mailto:mawid.om@gmail.com" class="block text-sm font-semibold text-green-700 hover:text-green-600 transition break-all">mawid.om@gmail.com</a>
                    </div>

                    
                    <div class="card-hover rounded-2xl border border-gray-100 bg-white p-7 text-center shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1"><?php echo e(__('contact.card_location_title')); ?></h3>
                        <p class="text-xs text-gray-400 mb-3"><?php echo e(__('contact.card_location_subtitle')); ?></p>
                        <p class="text-sm font-semibold text-green-700"><?php echo e(__('contact.card_location_value')); ?></p>
                    </div>

                </div>
            </div>
        </section>

        

        
        <section class="bg-white py-16">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 items-start">

                    
                    <div>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-7 h-0.5 bg-green-600 rounded-full"></span>
                            <span class="text-xs font-bold uppercase tracking-widest text-green-600"><?php echo e(__('contact.form_heading')); ?></span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2"><?php echo e(__('contact.form_heading')); ?></h2>
                        <p class="text-gray-400 text-sm mb-8"><?php echo e(__('contact.form_subtitle')); ?></p>

                        <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="space-y-5">
                            <?php echo csrf_field(); ?>

                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5"><?php echo e(__('contact.form_name_label')); ?></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 <?php echo e($iconStart); ?> flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="name" required
                                        value="<?php echo e(old('name')); ?>"
                                        placeholder="<?php echo e(__('contact.form_name_placeholder')); ?>"
                                        class="input-field w-full <?php echo e($inputPadStart); ?> py-3 rounded-xl border <?php echo e($errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm placeholder-gray-400">
                                </div>
                            </div>

                            
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5"><?php echo e(__('contact.form_email_label')); ?></label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 <?php echo e($iconStart); ?> flex items-center text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </span>
                                        <input type="email" name="email" required
                                            value="<?php echo e(old('email')); ?>"
                                            placeholder="<?php echo e(__('contact.form_email_placeholder')); ?>"
                                            class="input-field w-full <?php echo e($inputPadStart); ?> py-3 rounded-xl border <?php echo e($errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm placeholder-gray-400">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        <?php echo e(__('contact.form_phone_label')); ?>

                                        <span class="text-red-500 ms-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 <?php echo e($iconStart); ?> flex items-center text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </span>
                                        <input type="tel" name="phone" required
                                            value="<?php echo e(old('phone')); ?>"
                                            placeholder="<?php echo e(__('contact.form_phone_placeholder')); ?>"
                                            class="input-field w-full <?php echo e($inputPadStart); ?> py-3 rounded-xl border <?php echo e($errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm placeholder-gray-400">
                                    </div>
                                </div>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5"><?php echo e(__('contact.form_subject_label')); ?></label>
                                <input type="text" name="subject"
                                    value="<?php echo e(old('subject')); ?>"
                                    placeholder="<?php echo e(__('contact.form_subject_placeholder')); ?>"
                                    class="input-field w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-gray-50 placeholder-gray-400">
                            </div>

                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5"><?php echo e(__('contact.form_message_label')); ?></label>
                                <textarea name="message" rows="5" required
                                    placeholder="<?php echo e(__('contact.form_message_placeholder')); ?>"
                                    class="input-field w-full px-4 py-3 rounded-xl border <?php echo e($errors->has('message') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'); ?> text-sm placeholder-gray-400 resize-none"><?php echo e(old('message')); ?></textarea>
                            </div>

                            <button type="submit"
                                class="w-full py-3.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <?php echo e(__('contact.form_btn')); ?>

                            </button>

                            <p class="text-xs text-gray-400 text-center flex items-center justify-center gap-1">
                                <svg class="w-3 h-3 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('contact.form_note')); ?>

                            </p>
                        </form>
                    </div>

                    
                    <div class="flex flex-col gap-7">

                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-7 h-0.5 bg-green-600 rounded-full"></span>
                                <span class="text-xs font-bold uppercase tracking-widest text-green-600"><?php echo e(__('contact.map_heading')); ?></span>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2"><?php echo e(__('contact.map_heading')); ?></h2>
                            <p class="text-gray-400 text-sm mb-5"><?php echo e(__('contact.map_subtitle')); ?></p>
                        </div>

                        
                        <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100 h-72">
                            <iframe
                                title="Muscat, Oman"
                                width="100%"
                                height="100%"
                                frameborder="0"
                                style="border:0"
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117900.21932882604!2d58.4893!3d23.5880!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e91ff0000000001%3A0x3edda3f34f3f7c9!2sMuscat%2C%20Oman!5e0!3m2!1sen!2som!4v1" >
                            </iframe>
                        </div>

                        
                        <div class="rounded-2xl border border-green-100 bg-green-50 p-6 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-0.5"><?php echo e(__('contact.map_address_line1')); ?></p>
                                <p class="text-xs text-gray-500 mb-3"><?php echo e(__('contact.card_location_subtitle')); ?></p>
                                <a href="https://maps.google.com/?q=Muscat,Oman" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-700 hover:text-green-600 transition">
                                    <?php echo e(__('contact.map_open_maps')); ?>

                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        
                        <div class="grid grid-cols-2 gap-3">
                            <a href="mailto:mawid.om@gmail.com"
                               class="flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-100 bg-white hover:bg-green-50 hover:border-green-200 transition group shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-700 group-hover:text-green-700 transition truncate">mawid.om@gmail.com</span>
                            </a>
                            <a href="https://wa.me/96899822690" target="_blank" rel="noopener noreferrer"
                               class="whatsapp-btn flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white text-xs font-semibold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                WhatsApp
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        
        <section class="hero-bg relative overflow-hidden py-20">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 right-1/3 w-80 h-80 bg-green-400 opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-green-300 opacity-10 rounded-full blur-3xl"></div>
            </div>
            <div class="relative max-w-2xl mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 leading-snug"><?php echo e(__('contact.cta_title')); ?></h2>
                <p class="text-green-100 mb-8 leading-relaxed"><?php echo e(__('contact.cta_subtitle')); ?></p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="<?php echo e(route('register')); ?>"
                       class="w-full sm:w-auto px-7 py-3.5 bg-white text-green-700 font-bold rounded-xl shadow hover:shadow-md transition text-center text-sm">
                        <?php echo e(__('contact.cta_btn_primary')); ?>

                    </a>
                    <a href="<?php echo e(route('landing')); ?>#features"
                       class="w-full sm:w-auto px-7 py-3.5 bg-white/10 hover:bg-white/20 border border-white/25 text-white font-semibold rounded-xl transition text-center text-sm">
                        <?php echo e(__('contact.cta_btn_secondary')); ?>

                    </a>
                </div>
            </div>
        </section>

    </main>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('footer'); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views\contact.blade.php ENDPATH**/ ?>