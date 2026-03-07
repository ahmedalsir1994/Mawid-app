<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/Mawidly-fav.png">

    <title>Mawid App</title>
    
    <!-- Arabic Font -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [dir="rtl"] body {
            font-family: 'Montserrat', sans-serif;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #000000 0%, #0ba83a     %);
        }

        .feature-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -5px rgba(33, 173, 115, 0.3);
        }

        .cta-button {
            background: black;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .cta-button:hover::before {
            width: 300px;
            height: 300px;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(17, 107, 80, 0.5);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
            }

            50% {
                box-shadow: 0 0 40px rgba(102, 126, 234, 0.8);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .booking-mockup {
            background: linear-gradient(135deg, #ffffff 0%, #f2f2f3 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .stat-counter {
            font-weight: 600;
            background: linear-gradient(135deg, #000000 0%, #0ba83a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-border {
            position: relative;
            background: white;
            border-radius: 1rem;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 1rem;
            padding: 2px;
            background: linear-gradient(135deg, #000000 0%, #0ba83a 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
    </style>
</head>

<body class="antialiased">

@include('layouts.navbar')
@yield('navbar')
    


    <!-- Hero Section -->
    <section class="hero-gradient text-black-600 pt-32 pb-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse">
        </div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"
            style="animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div
                        class="inline-block mb-4 px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-sm font-semibold">
                        {{ __('landing.hero_badge') }}
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl  mb-6 leading-tight">
                        {{ __('landing.hero_title_1') }}
                        <span class="block bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-green-600">
                            {{ __('landing.hero_title_2') }}
                        </span>
                    </h1>
                    <p class="text-md md:text-xl  mb-8 text-black-600 leading-relaxed">
                        {{ __('landing.hero_subtitle') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        @auth
                            <a href="{{ route('admin.dashboard') }}"
                                class="cta-button px-8 py-4 text-white font-bold rounded-xl text-center text-lg relative z-10">
                                {{ __('landing.hero_cta_dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="cta-button px-8 py-4 text-white font-bold rounded-xl text-center text-lg relative z-10">
                                {{ __('landing.hero_cta_trial') }}
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-8 py-4 border-2 border-green-600 text-green-600 font-bold rounded-xl hover:bg-white hover:text-green-300 transition text-center text-lg backdrop-blur-sm bg-white bg-opacity-10">
                                {{ __('landing.hero_cta_signin') }}
                            </a>
                        @endauth
                    </div>
                    <div class="flex items-center gap-6 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('landing.hero_no_card') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('landing.hero_setup') }}</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="booking-mockup float-animation">
                        <!-- Calendar mockup -->
                        <div class="bg-white rounded-xl p-6 shadow-2xl">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold text-gray-800 text-lg">{{ __('landing.hero_schedule_title') }}</h3>
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                            </div>
                            <!-- Time slots -->
                            <div class="space-y-3">
                                <div
                                    class="flex items-center gap-3 p-3 bg-green-50 border-l-4 border-green-600 rounded-lg">
                                    <div class="text-sm font-semibold text-gray-600">09:00</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-800 text-sm">Hair Styling</div>
                                        <div class="text-xs text-gray-500">Sarah Johnson</div>
                                    </div>
                                    <div class="w-2 h-2 bg-green-500 rounded-full pulse-glow"></div>
                                </div>
                                <div
                                    class="flex items-center gap-3 p-3 bg-blue-50 border-l-4 border-blue-600 rounded-lg">
                                    <div class="text-sm font-semibold text-gray-600">11:00</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-800 text-sm">Consultation</div>
                                        <div class="text-xs text-gray-500">Mike Wilson</div>
                                    </div>
                                    <div class="w-2 h-2 bg-green-500 rounded-full pulse-glow"></div>
                                </div>
                                <div
                                    class="flex items-center gap-3 p-3 bg-pink-50 border-l-4 border-pink-600 rounded-lg">
                                    <div class="text-sm font-semibold text-gray-600">14:00</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-800 text-sm">Spa Treatment</div>
                                        <div class="text-xs text-gray-500">Emma Davis</div>
                                    </div>
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full pulse-glow"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold stat-counter mb-2">50+</div>
                    <div class="text-gray-600 font-medium">{{ __('landing.stats_businesses') }}</div>
                </div>
                <div>
                    <div class="text-5xl font-bold stat-counter mb-2">200K+</div>
                    <div class="text-gray-600 font-medium">{{ __('landing.stats_bookings') }}</div>
                </div>
                <div>
                    <div class="text-5xl font-bold stat-counter mb-2">98%</div>
                    <div class="text-gray-600 font-medium">{{ __('landing.stats_satisfaction') }}</div>
                </div>
                <div>
                    <div class="text-5xl font-bold stat-counter mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">{{ __('landing.stats_availability') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div
                    class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-semibold mb-4">
                    {{ __('landing.features_badge') }}
                </div>
                <h2 class="text-4xl md:text-5xl font-semibold mb-4">{{ __('landing.features_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('landing.features_subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card border rounded-[10px] p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">{{ __('landing.feature_1_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('landing.feature_1_desc') }}</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card border rounded-[10px] p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">{{ __('landing.feature_2_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('landing.feature_2_desc') }}</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card border rounded-[10px] p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">{{ __('landing.feature_3_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('landing.feature_3_desc') }}</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card border rounded-[10px] p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">{{ __('landing.feature_4_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('landing.feature_4_desc') }}</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card border rounded-[10px] p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">{{ __('landing.feature_5_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('landing.feature_5_desc') }}</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card border rounded-[10px] p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">{{ __('landing.feature_6_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('landing.feature_6_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-24 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-semibold mb-4">
                    {{ __('landing.hiw_badge') }}
                </div>
                <h2 class="text-4xl md:text-5xl font-semibold mb-4">{{ __('landing.hiw_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('landing.hiw_subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Connection lines for desktop -->
                <div class="hidden md:block absolute top-8 left-0 right-0 h-1 bg-gradient-to-r from-green-600 via-green-600 to-green-600 opacity-20"
                    style="margin: 0 12%;"></div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        1
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">{{ __('landing.hiw_step1_title') }}</h3>
                        <p class="text-gray-600">{{ __('landing.hiw_step1_desc') }}</p>
                    </div>
                </div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        2
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">{{ __('landing.hiw_step2_title') }}</h3>
                        <p class="text-gray-600">{{ __('landing.hiw_step2_desc') }}</p>
                    </div>
                </div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        3
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">{{ __('landing.hiw_step3_title') }}</h3>
                        <p class="text-gray-600">{{ __('landing.hiw_step3_desc') }}</p>
                    </div>
                </div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        4
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">{{ __('landing.hiw_step4_title') }}</h3>
                        <p class="text-gray-600">{{ __('landing.hiw_step4_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div
                    class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">
                    {{ __('landing.testimonials_badge') }}
                </div>
                <h2 class="text-4xl md:text-5xl font-semibold mb-4">{{ __('landing.testimonials_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('landing.testimonials_subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed italic">{{ __('landing.t1_text') }}</p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            SJ
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ __('landing.t1_name') }}</p>
                            <p class="text-gray-600 text-sm">{{ __('landing.t1_role') }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed italic">{{ __('landing.t2_text') }}</p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            MW
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ __('landing.t2_name') }}</p>
                            <p class="text-gray-600 text-sm">{{ __('landing.t2_role') }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed italic">{{ __('landing.t3_text') }}</p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            EC
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ __('landing.t3_name') }}</p>
                            <p class="text-gray-600 text-sm">{{ __('landing.t3_role') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-semibold mb-4">
                    {{ __('landing.pricing_badge') }}
                </div>
                <h2 class="text-4xl md:text-5xl font-semibold mb-4">{{ __('landing.pricing_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('landing.pricing_subtitle') }}
                </p>
            </div>

            <!-- Monthly / Yearly Toggle -->
            <div class="flex flex-col items-center mb-10 gap-3">
                <div class="inline-flex items-center bg-gray-100 rounded-xl p-1 gap-1">
                    <button id="lp-btn-monthly" onclick="lpSetCycle('monthly')"
                        class="px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900">
                        {{ __('landing.billing_monthly') }}
                    </button>
                    <button id="lp-btn-yearly" onclick="lpSetCycle('yearly')"
                        class="px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500">
                        {{ __('landing.billing_yearly') }}
                    </button>
                </div>
            </div>

            <!-- Plan Cards -->
            <div class="grid md:grid-cols-3 gap-8 items-start">

                <!-- Free Plan -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🆓</div>
                    <h3 class="text-xl font-bold text-gray-900">{{ __('landing.plan_free_name') }}</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-5">{{ __('landing.plan_free_tagline') }}</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-800">{{ __('landing.plan_free_price') }}</span>
                        <span class="text-gray-500 text-sm ml-1">{{ __('landing.plan_free_period') }}</span>
                    </div>
                    <ul class="space-y-2 mb-8">
                        @foreach(['plan_free_f1','plan_free_f2','plan_free_f3','plan_free_f4'] as $fkey)
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="w-5 h-5 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                                {{ __("landing.{$fkey}") }}
                            </li>
                        @endforeach
                    </ul>
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="block w-full py-3 rounded-xl border-2 border-gray-300 text-gray-700 text-center font-semibold hover:bg-gray-50 transition">
                            {{ __('landing.cta_btn_dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="block w-full py-3 rounded-xl border-2 border-gray-300 text-gray-700 text-center font-semibold hover:bg-gray-50 transition">
                            {{ __('landing.plan_free_cta') }}
                        </a>
                    @endauth
                </div>

                <!-- Pro Plan (highlighted) -->
                <div class="relative bg-white rounded-2xl border-2 border-blue-500 p-8 shadow-xl">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded-full">
                        {{ __('landing.plan_popular') }}
                    </div>
                    <div class="text-3xl mb-3">💼</div>
                    <h3 class="text-xl font-bold text-gray-900">{{ __('landing.plan_pro_name') }}</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-5">{{ __('landing.plan_pro_tagline') }}</p>
                    <div class="mb-6">
                        {{-- Monthly --}}
                        <div class="lp-cycle-monthly">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm line-through text-gray-400">10 OMR</span>
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 35%</span>
                            </div>
                            <span class="text-4xl font-bold text-gray-900">6.5</span>
                            <span class="text-lg font-semibold text-gray-500 ml-1">OMR</span>
                            <span class="text-sm text-gray-500"> / {{ __('landing.per_month') }}</span>
                        </div>
                        {{-- Yearly --}}
                        <div class="lp-cycle-yearly" style="display:none">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm line-through text-gray-400">10 OMR/mo</span>
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 45%</span>
                            </div>
                            <div class="flex items-end gap-2">
                                <span class="text-4xl font-bold text-gray-900">5.5</span>
                                <span class="text-lg font-semibold text-gray-500 mb-0.5">OMR / {{ __('landing.per_month') }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-sm text-gray-500">66 OMR {{ __('landing.per_year') }}</span>
                            </div>
                        </div>
                    </div>
                    <ul class="space-y-2 mb-8">
                        @foreach(['plan_pro_f1','plan_pro_f2','plan_pro_f3','plan_pro_f4','plan_pro_f5'] as $fkey)
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                                {{ __("landing.{$fkey}") }}
                            </li>
                        @endforeach
                    </ul>
                    @auth
                        <a href="{{ route('admin.upgrade.index') }}?plan=pro"
                            class="block w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center font-semibold hover:shadow-lg transition">
                            {{ __('landing.plan_pro_cta') }}
                        </a>
                    @else
                        <a id="lp-cta-pro"
                           href="{{ route('register') }}?plan=pro&cycle=monthly"
                            class="block w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center font-semibold hover:shadow-lg transition">
                            {{ __('landing.plan_pro_cta') }}
                        </a>
                    @endauth
                </div>

                <!-- Plus Plan -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🚀</div>
                    <h3 class="text-xl font-bold text-gray-900">{{ __('landing.plan_plus_name') }}</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-5">{{ __('landing.plan_plus_tagline') }}</p>
                    <div class="mb-6">
                        {{-- Monthly --}}
                        <div class="lp-cycle-monthly">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm line-through text-gray-400">14 OMR</span>
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 30%</span>
                            </div>
                            <span class="text-4xl font-bold text-gray-900">9.8</span>
                            <span class="text-lg font-semibold text-gray-500 ml-1">OMR</span>
                            <span class="text-sm text-gray-500"> / {{ __('landing.per_month') }}</span>
                        </div>
                        {{-- Yearly --}}
                        <div class="lp-cycle-yearly" style="display:none">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm line-through text-gray-400">14 OMR/mo</span>
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 35%</span>
                            </div>
                            <div class="flex items-end gap-2">
                                <span class="text-4xl font-bold text-gray-900">9.1</span>
                                <span class="text-lg font-semibold text-gray-500 mb-0.5">OMR / {{ __('landing.per_month') }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-sm text-gray-500">109.2 OMR {{ __('landing.per_year') }}</span>
                            </div>
                        </div>
                    </div>
                    <ul class="space-y-2 mb-8">
                        @foreach(['plan_plus_f1','plan_plus_f2','plan_plus_f3','plan_plus_f4','plan_plus_f5'] as $fkey)
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                                {{ __("landing.{$fkey}") }}
                            </li>
                        @endforeach
                    </ul>
                    @auth
                        <a href="{{ route('admin.upgrade.index') }}?plan=plus"
                            class="block w-full py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white text-center font-semibold hover:shadow-lg transition">
                            {{ __('landing.plan_plus_cta') }}
                        </a>
                    @else
                        <a id="lp-cta-plus"
                           href="{{ route('register') }}?plan=plus&cycle=monthly"
                            class="block w-full py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white text-center font-semibold hover:shadow-lg transition">
                            {{ __('landing.plan_plus_cta') }}
                        </a>
                    @endauth
                </div>

            </div>

            <p class="text-center text-sm text-gray-500 mt-8">
                {{ __('landing.plan_no_card') }}
            </p>
        </div>

        <script>
        function lpSetCycle(cycle) {
            const isYearly = cycle === 'yearly';
            const mBtn = document.getElementById('lp-btn-monthly');
            const yBtn = document.getElementById('lp-btn-yearly');
            mBtn.className = isYearly
                ? 'px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500'
                : 'px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900';
            yBtn.className = isYearly
                ? 'px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900'
                : 'px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500';
            document.querySelectorAll('.lp-cycle-monthly').forEach(el => el.style.display = isYearly ? 'none' : 'block');
            document.querySelectorAll('.lp-cycle-yearly').forEach(el => el.style.display = isYearly ? 'block' : 'none');
            document.querySelectorAll('.lp-yearly-caption').forEach(el => el.style.display = isYearly ? 'block' : 'none');
            // Update plan CTA register links so cycle is carried over
            const selectedCycle = isYearly ? 'yearly' : 'monthly';
            const proBtn = document.getElementById('lp-cta-pro');
            const plusBtn = document.getElementById('lp-cta-plus');
            if (proBtn)  proBtn.href  = proBtn.href.replace(/cycle=[^&]+/, 'cycle=' + selectedCycle);
            if (plusBtn) plusBtn.href = plusBtn.href.replace(/cycle=[^&]+/, 'cycle=' + selectedCycle);
        }
        </script>
    </section>

    <!-- CTA Section -->
    <section class="hero-gradient text-black py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div
            class="absolute top-0 left-0 w-96 h-96 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold mb-6 leading-tight">
                {{ __('landing.cta_title') }}
            </h2>
            <p class="text-xl md:text-2xl mb-10 text-black-100 leading-relaxed max-w-2xl mx-auto">
                {{ __('landing.cta_subtitle', ['name' => config('app.name')]) }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="cta-button px-10 py-5 text-white font-semibold rounded-xl inline-block text-lg shadow-2xl relative z-10">
                        {{ __('landing.cta_btn_dashboard') }}
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="cta-button px-10 py-5 text-white font-semibold rounded-xl inline-block text-lg shadow-2xl relative z-10">
                        {{ __('landing.cta_btn_trial') }}
                    </a>
                @endauth
            </div>
            <div class="flex flex-wrap justify-center gap-6 text-sm text-black-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ __('landing.cta_trial') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ __('landing.cta_no_card') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ __('landing.cta_cancel') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
   @include('layouts.footer')
   @yield('footer')
</body>

</html>