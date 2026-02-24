<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%23667eea' width='100' height='100'/><text x='50' y='65' font-size='70' font-weight='bold' fill='white' text-anchor='middle' font-family='Arial'>M</text></svg>">

    <title>Mawid App</title>
    
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .feature-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -5px rgba(102, 126, 234, 0.3);
        }

        .cta-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .stat-counter {
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
    </style>
</head>

<body class="antialiased">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white bg-opacity-95 backdrop-blur-md shadow-md z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div
                        class="w-32 sm:w-40 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-base sm:text-lg">Mawid App</span>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-purple-600 transition">Features</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-purple-600 transition">How It Works</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-purple-600 transition">Testimonials</a>
                    <a href="#pricing" class="text-gray-600 hover:text-purple-600 transition">Pricing</a>
                </div>

                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex space-x-4 items-center">
                    <!-- Language Switcher -->
                    <div class="flex gap-1 bg-gray-100 rounded-lg p-1">
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="px-3 py-1 text-sm font-medium rounded transition {{ app()->getLocale() === 'en' ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                            EN
                        </a>
                        <a href="{{ route('lang.switch', 'ar') }}"
                            class="px-3 py-1 text-sm font-medium rounded transition {{ app()->getLocale() === 'ar' ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                            AR
                        </a>
                    </div>
                    
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 text-purple-600 font-semibold hover:bg-purple-50 rounded-lg transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-purple-600 transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition">
                            Get Started
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button"
                        class="text-gray-600 hover:text-purple-600 focus:outline-none focus:text-purple-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-open-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                            <path id="menu-close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <!-- Language Switcher for Mobile -->
                <div class="flex gap-2 justify-center py-2">
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="px-4 py-2 text-sm font-medium rounded transition {{ app()->getLocale() === 'en' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                        EN
                    </a>
                    <a href="{{ route('lang.switch', 'ar') }}"
                        class="px-4 py-2 text-sm font-medium rounded transition {{ app()->getLocale() === 'ar' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                        AR
                    </a>
                </div>
                
                <a href="#features"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-600 transition">
                    Features
                </a>
                <a href="#how-it-works"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-600 transition">
                    How It Works
                </a>
                <a href="#testimonials"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-600 transition">
                    Testimonials
                </a>
                <a href="#pricing"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-600 transition">
                    Pricing
                </a>
                <div class="pt-3 space-y-2 border-t border-gray-200">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-3 py-2 rounded-lg text-purple-600 font-semibold bg-purple-50">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                            class="block px-3 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center font-semibold rounded-lg">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOpenIcon = document.getElementById('menu-open-icon');
            const menuCloseIcon = document.getElementById('menu-close-icon');

            mobileMenuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
                menuOpenIcon.classList.toggle('hidden');
                menuCloseIcon.classList.toggle('hidden');
            });

            // Close mobile menu when clicking on a link
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function () {
                    mobileMenu.classList.add('hidden');
                    menuOpenIcon.classList.remove('hidden');
                    menuCloseIcon.classList.add('hidden');
                });
            });
        });
    </script>

    <!-- Hero Section -->
    <section class="hero-gradient text-white pt-32 pb-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse">
        </div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"
            style="animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div
                        class="inline-block mb-4 px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-sm font-semibold">
                        🎉 Get 14 days free trial
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                        Booking Made
                        <span class="block bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-pink-300">
                            Simple & Smart
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-purple-100 leading-relaxed">
                        Transform your business with powerful appointment scheduling. Accept bookings 24/7, reduce
                        no-shows, and delight your customers.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        @auth
                            <a href="{{ route('admin.dashboard') }}"
                                class="cta-button px-8 py-4 text-white font-bold rounded-xl text-center text-lg relative z-10">
                                Go to Dashboard →
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="cta-button px-8 py-4 text-white font-bold rounded-xl text-center text-lg relative z-10">
                                Start Free Trial →
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-8 py-4 border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-purple-600 transition text-center text-lg backdrop-blur-sm bg-white bg-opacity-10">
                                Sign In
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
                            <span>No credit card required</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Setup in 5 minutes</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="booking-mockup float-animation">
                        <!-- Calendar mockup -->
                        <div class="bg-white rounded-xl p-6 shadow-2xl">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold text-gray-800 text-lg">Today's Schedule</h3>
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                            </div>
                            <!-- Time slots -->
                            <div class="space-y-3">
                                <div
                                    class="flex items-center gap-3 p-3 bg-purple-50 border-l-4 border-purple-600 rounded-lg">
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
                    <div class="text-gray-600 font-medium">Active Businesses</div>
                </div>
                <div>
                    <div class="text-5xl font-bold stat-counter mb-2">200K+</div>
                    <div class="text-gray-600 font-medium">Monthly Bookings</div>
                </div>
                <div>
                    <div class="text-5xl font-bold stat-counter mb-2">98%</div>
                    <div class="text-gray-600 font-medium">Customer Satisfaction</div>
                </div>
                <div>
                    <div class="text-5xl font-bold stat-counter mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">Booking Availability</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div
                    class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-4">
                    POWERFUL FEATURES
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Everything You Need to Succeed</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Built for service businesses who want to streamline operations and grow faster
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card gradient-border p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Online Booking 24/7</h3>
                    <p class="text-gray-600 leading-relaxed">Let customers book appointments anytime, anywhere with
                        real-time availability and instant confirmations.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card gradient-border p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Team Management</h3>
                    <p class="text-gray-600 leading-relaxed">Coordinate multiple staff members with individual
                        schedules, services, and performance tracking.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card gradient-border p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Smart Reminders</h3>
                    <p class="text-gray-600 leading-relaxed">Automated email and SMS notifications reduce no-shows and
                        keep everyone informed.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card gradient-border p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Analytics Dashboard</h3>
                    <p class="text-gray-600 leading-relaxed">Track revenue, popular services, peak times, and customer
                        trends with beautiful reports.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card gradient-border p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Flexible Scheduling</h3>
                    <p class="text-gray-600 leading-relaxed">Set custom working hours, break times, and time-off periods
                        with automatic conflict detection.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card gradient-border p-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Customer Database</h3>
                    <p class="text-gray-600 leading-relaxed">Store customer details, booking history, and preferences
                        for personalized service.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-24 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-4">
                    HOW IT WORKS
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Get Started in Minutes</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Simple setup process to get your booking system up and running
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Connection lines for desktop -->
                <div class="hidden md:block absolute top-8 left-0 right-0 h-1 bg-gradient-to-r from-purple-600 via-blue-600 to-green-600 opacity-20"
                    style="margin: 0 12%;"></div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        1
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Sign Up Free</h3>
                        <p class="text-gray-600">Create your account in under 2 minutes. No credit card needed for the
                            14-day trial.</p>
                    </div>
                </div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        2
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Configure Services</h3>
                        <p class="text-gray-600">Add your services, set prices, duration, and assign staff members in
                            minutes.</p>
                    </div>
                </div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        3
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Share Your Link</h3>
                        <p class="text-gray-600">Get your unique booking page and share it with customers via website,
                            email, or social media.</p>
                    </div>
                </div>

                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-pink-600 to-pink-700 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-xl relative z-10">
                        4
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Accept Bookings</h3>
                        <p class="text-gray-600">Watch bookings roll in 24/7 while you focus on delivering great
                            service.</p>
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
                    class="inline-block px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold mb-4">
                    TESTIMONIALS
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Loved by Thousands</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    See what business owners are saying about our platform
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
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed italic">"This booking system has completely
                        transformed how we operate. We've seen a 40% increase in bookings and our no-show rate dropped
                        to nearly zero!"</p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            SJ
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Sarah Johnson</p>
                            <p class="text-gray-600 text-sm">Beauty Salon Owner</p>
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
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed italic">"The customer management features are
                        outstanding. I can track all my clients' histories and preferences effortlessly. Saves me hours
                        every week!"</p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            MW
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Marcus Williams</p>
                            <p class="text-gray-600 text-sm">Fitness Coach</p>
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
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed italic">"Perfect for our consulting firm. The
                        automated reminders have significantly reduced no-shows, and the interface is incredibly
                        intuitive."</p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-400 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            EC
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Emily Chen</p>
                            <p class="text-gray-600 text-sm">Business Consultant</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div
                    class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-4">
                    SIMPLE PRICING
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">One Plan, Everything Included</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    No hidden fees, no complicated tiers. Just powerful booking tools for your business.
                </p>
            </div>

            <div class="max-w-md mx-auto">
                <!-- Starter Plan -->
                <div class="relative">
                    <!-- Decorative gradient border effect -->
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-25">
                    </div>

                    <div
                        class="relative bg-white rounded-2xl shadow-2xl p-6 border border-gray-100 hover:shadow-3xl transition-shadow duration-300">
                        <div class="text-center mb-5">
                            <div
                                class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl mb-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-1 text-gray-900">Starter Plan</h3>
                            <p class="text-gray-600 mb-4">Perfect for all businesses</p>
                            <div class="mb-3">
                                <span
                                    class="text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">9</span>
                                <span
                                    class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">OMR</span>
                                <span class="text-xl text-gray-600">/month</span>
                            </div>
                            <p class="text-xs text-gray-500">Billed monthly, cancel anytime</p>
                        </div>

                        <div class="space-y-2.5 mb-5">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-gray-800 font-semibold text-sm">Unlimited Services</p>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-gray-800 font-semibold text-sm">24/7 Online Booking</p>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-gray-800 font-semibold text-sm">WhatsApp Reminders</p>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-gray-800 font-semibold text-sm">Analytics Dashboard</p>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-gray-800 font-semibold text-sm">Customer Database</p>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-gray-800 font-semibold text-sm">Priority Support</p>
                            </div>
                        </div>

                        @auth
                            <a href="{{ route('admin.dashboard') }}"
                                class="block w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center font-bold rounded-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                                Go to Dashboard →
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="block w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center font-bold rounded-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                                Start Your 14-Day Free Trial →
                            </a>
                        @endauth

                        <p class="text-center text-xs text-gray-500 mt-4">
                            No credit card required • Cancel anytime
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="hero-gradient text-white py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div
            class="absolute top-0 left-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Ready to Transform Your Business?
            </h2>
            <p class="text-xl md:text-2xl mb-10 text-purple-100 leading-relaxed max-w-2xl mx-auto">
                Join thousands of businesses already using {{ config('app.name') }} to streamline their booking process
                and grow faster.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="cta-button px-10 py-5 text-white font-bold rounded-xl inline-block text-lg shadow-2xl relative z-10">
                        Go to Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="cta-button px-10 py-5 text-white font-bold rounded-xl inline-block text-lg shadow-2xl relative z-10">
                        Start Your 14-Day Free Trial →
                    </a>
                @endauth
            </div>
            <div class="flex flex-wrap justify-center gap-6 text-sm text-purple-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>14-day free trial</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>No credit card needed</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Cancel anytime</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="font-bold text-white mb-4">{{ config('app.name') }}</h4>
                    <p class="text-sm">Professional appointment scheduling for service-based businesses.</p>
                </div>
                <div>
                    <h5 class="font-bold text-white mb-4">Product</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-white mb-4">Company</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-white mb-4">Legal</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-sm">
                <p>&copy; 2026 {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>