<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('/images/Mawidly-fav.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('terms.terms_title') }}</title>
    <!-- Fonts -->  
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    @include('layouts.navbar')
    @yield('navbar')

    {{-- Terms content goes here --}}
    <div class="bg-gray-50 min-h-screen py-20 ">
    <div class="max-w-4xl mx-auto px-6 bg-white shadow-sm rounded-2xl p-8">

        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            {{ __('terms.b_title') }}
        </h1>
        <p class="text-sm text-gray-500 mb-8">
            {{ __('terms.b_subtitle') }}<br>
            {{ __('terms.last_updated') }} {{ __('terms.b_last_updated') }}
        </p>

        <div class="space-y-10 text-gray-700 leading-relaxed">

            <!-- 1 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s1_title') }}</h2>
                <p>{{ __('terms.b_s1_p1') }}</p>
                <p class="mt-3"><strong>{{ __('terms.b_s1_p2_strong') }}</strong>{{ __('terms.b_s1_p2_rest') }}</p>
                <p class="mt-3">{{ __('terms.b_s1_and') }}</p>
                <p class="mt-3">{{ __('terms.b_s1_p3') }}</p>
                <p class="mt-3">{{ __('terms.b_s1_p4') }}</p>
            </section>

            <!-- 2 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s2_title') }}</h2>
                <p>{{ __('terms.b_s2_p1') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.b_s2_li1') }}</li>
                    <li>{{ __('terms.b_s2_li2') }}</li>
                    <li>{{ __('terms.b_s2_li3') }}</li>
                </ul>
                <p class="mt-4">{{ __('terms.b_s2_p2') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.b_s2_li4') }}</li>
                    <li>{{ __('terms.b_s2_li5') }}</li>
                    <li>{{ __('terms.b_s2_li6') }}</li>
                    <li>{{ __('terms.b_s2_li7') }}</li>
                </ul>
                <p class="mt-3 font-medium">{{ __('terms.b_s2_p3') }}</p>
            </section>

            <!-- 3 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s3_title') }}</h2>
                <h3 class="font-semibold mt-4">{{ __('terms.b_s3_sub1') }}</h3>
                <p class="mt-2">{{ __('terms.b_s3_p1') }}</p>
                <h3 class="font-semibold mt-6">{{ __('terms.b_s3_sub2') }}</h3>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.b_s3_li1') }}</li>
                    <li>{{ __('terms.b_s3_li2') }}</li>
                    <li>{{ __('terms.b_s3_li3') }}</li>
                </ul>
                <h3 class="font-semibold mt-6">{{ __('terms.b_s3_sub3') }}</h3>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.b_s3_li4') }}</li>
                    <li>{{ __('terms.b_s3_li5') }}</li>
                    <li>{{ __('terms.b_s3_li6') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.b_s3_p2') }}</p>
            </section>

            <!-- 4 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s4_title') }}</h2>
                <p>{{ __('terms.b_s4_p1') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.b_s4_li1') }}</li>
                    <li>{{ __('terms.b_s4_li2') }}</li>
                    <li>{{ __('terms.b_s4_li3') }}</li>
                    <li>{{ __('terms.b_s4_li4') }}</li>
                    <li>{{ __('terms.b_s4_li5') }}</li>
                    <li>{{ __('terms.b_s4_li6') }}</li>
                    <li>{{ __('terms.b_s4_li7') }}</li>
                </ul>
                <p class="mt-4">{{ __('terms.b_s4_p2') }}</p>
                <p class="mt-2">{{ __('terms.b_s4_p3') }}</p>
            </section>

            <!-- 5 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s5_title') }}</h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li>{{ __('terms.b_s5_li1') }}</li>
                    <li>{{ __('terms.b_s5_li2') }}</li>
                    <li>{{ __('terms.b_s5_li3') }}</li>
                </ul>
                <p class="mt-4">{{ __('terms.b_s5_p1') }}</p>
            </section>

            <!-- 6 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s6_title') }}</h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li>{{ __('terms.b_s6_li1') }}</li>
                    <li>{{ __('terms.b_s6_li2') }}</li>
                    <li>{{ __('terms.b_s6_li3') }}</li>
                </ul>
                <p class="mt-4">{{ __('terms.b_s6_p1') }}</p>
            </section>

            <!-- 7 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s7_title') }}</h2>
                <p>{{ __('terms.b_s7_p1') }}</p>
                <p class="mt-3">{{ __('terms.b_s7_p2') }}</p>
                <p class="mt-3 font-medium">{{ __('terms.b_s7_p3') }}</p>
            </section>

            <!-- 8 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s8_title') }}</h2>
                <p>{{ __('terms.b_s8_p1') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.b_s8_li1') }}</li>
                    <li>{{ __('terms.b_s8_li2') }}</li>
                    <li>{{ __('terms.b_s8_li3') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.b_s8_p2') }}</p>
            </section>

            <!-- 9 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s9_title') }}</h2>
                <p>{{ __('terms.b_s9_p1') }}</p>
                <p class="mt-3">{{ __('terms.b_s9_p2') }}</p>
                <p class="mt-3">{{ __('terms.b_s9_p3') }}</p>
            </section>

            <!-- 10 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s10_title') }}</h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li>{{ __('terms.b_s10_li1') }}</li>
                    <li>{{ __('terms.b_s10_li2') }}</li>
                    <li>{{ __('terms.b_s10_li3') }}</li>
                    <li>{{ __('terms.b_s10_li4') }}</li>
                    <li>{{ __('terms.b_s10_li5') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.b_s10_p1') }}</p>
            </section>

            <!-- 11 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s11_title') }}</h2>
                <p>{{ __('terms.b_s11_p1') }}</p>
                <p class="mt-3">{{ __('terms.b_s11_p2') }}</p>
            </section>

            <!-- 12 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s12_title') }}</h2>
                <p>{{ __('terms.b_s12_p1') }}</p>
            </section>

            <!-- 13 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s13_title') }}</h2>
                <p>{{ __('terms.b_s13_p1') }}</p>
                <p class="mt-3">{{ __('terms.b_s13_p2') }}</p>
            </section>

            <!-- 14 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s14_title') }}</h2>
                <p>{{ __('terms.b_s14_p1') }}</p>
                <p class="mt-3 font-medium">{{ __('terms.b_s14_p2') }}</p>
            </section>

            <!-- 15 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s15_title') }}</h2>
                <p>{{ __('terms.b_s15_p1') }}</p>
                <p class="mt-3">{{ __('terms.b_s15_p2') }}</p>
            </section>

            <!-- 16 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s16_title') }}</h2>
                <p>{{ __('terms.b_s16_p1') }}</p>
                <p class="mt-3">{{ __('terms.b_s16_p2') }}</p>
            </section>

            <!-- 17 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.b_s17_title') }}</h2>
                <p>{{ __('terms.b_s17_p1') }}</p>
            </section>

        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-6 bg-white shadow-sm rounded-2xl p-8">

        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            {{ __('terms.c_title') }}
        </h1>
        <p class="text-sm text-gray-500 mb-8">
            {{ __('terms.last_updated') }} {{ __('terms.c_last_updated') }}
        </p>

        <div class="space-y-10 text-gray-700 leading-relaxed">

            <!-- 1 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s1_title') }}</h2>
                <p>{{ __('terms.c_s1_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s1_p2') }}</p>
            </section>

            <!-- 2 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s2_title') }}</h2>
                <p>{{ __('terms.c_s2_p1') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.c_s2_li1') }}</li>
                    <li>{{ __('terms.c_s2_li2') }}</li>
                    <li>{{ __('terms.c_s2_li3') }}</li>
                </ul>
                <p class="mt-4">{{ __('terms.c_s2_p2') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.c_s2_li4') }}</li>
                    <li>{{ __('terms.c_s2_li5') }}</li>
                    <li>{{ __('terms.c_s2_li6') }}</li>
                </ul>
                <p class="mt-3 font-medium">{{ __('terms.c_s2_p3') }}</p>
            </section>

            <!-- 3 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s3_title') }}</h2>
                <p>{{ __('terms.c_s3_p1') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.c_s3_li1') }}</li>
                    <li>{{ __('terms.c_s3_li2') }}</li>
                    <li>{{ __('terms.c_s3_li3') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.c_s3_p2') }}</p>
            </section>

            <!-- 4 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s4_title') }}</h2>
                <p>{{ __('terms.c_s4_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s4_p2') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.c_s4_li1') }}</li>
                    <li>{{ __('terms.c_s4_li2') }}</li>
                    <li>{{ __('terms.c_s4_li3') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.c_s4_p3') }}</p>
            </section>

            <!-- 5 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s5_title') }}</h2>
                <p>{{ __('terms.c_s5_p1') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.c_s5_li1') }}</li>
                    <li>{{ __('terms.c_s5_li2') }}</li>
                    <li>{{ __('terms.c_s5_li3') }}</li>
                </ul>
                <p class="mt-4">{{ __('terms.c_s5_p2') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.c_s5_li4') }}</li>
                    <li>{{ __('terms.c_s5_li5') }}</li>
                    <li>{{ __('terms.c_s5_li6') }}</li>
                    <li>{{ __('terms.c_s5_li7') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.c_s5_p3') }}</p>
            </section>

            <!-- 6 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s6_title') }}</h2>
                <p>{{ __('terms.c_s6_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s6_p2') }}</p>
                <p class="mt-3 font-medium">{{ __('terms.c_s6_p3') }}</p>
            </section>

            <!-- 7 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s7_title') }}</h2>
                <p>{{ __('terms.c_s7_p1') }}</p>
                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>{{ __('terms.c_s7_li1') }}</li>
                    <li>{{ __('terms.c_s7_li2') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.c_s7_p2') }}</p>
            </section>

            <!-- 8 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s8_title') }}</h2>
                <p>{{ __('terms.c_s8_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s8_p2') }}</p>
                <p class="mt-3 font-medium">{{ __('terms.c_s8_p3') }}</p>
            </section>

            <!-- 9 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s9_title') }}</h2>
                <p>{{ __('terms.c_s9_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s9_p2') }}</p>
            </section>

            <!-- 10 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s10_title') }}</h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li>{{ __('terms.c_s10_li1') }}</li>
                    <li>{{ __('terms.c_s10_li2') }}</li>
                    <li>{{ __('terms.c_s10_li3') }}</li>
                    <li>{{ __('terms.c_s10_li4') }}</li>
                    <li>{{ __('terms.c_s10_li5') }}</li>
                </ul>
                <p class="mt-3">{{ __('terms.c_s10_p1') }}</p>
            </section>

            <!-- 11 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s11_title') }}</h2>
                <p>{{ __('terms.c_s11_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s11_p2') }}</p>
                <p class="mt-3">{{ __('terms.c_s11_p3') }}</p>
            </section>

            <!-- 12 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s12_title') }}</h2>
                <p>{{ __('terms.c_s12_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s12_p2') }}</p>
                <p class="mt-2 font-medium">📧 Mawid.om@gmail.com</p>
                <p class="mt-3">{{ __('terms.c_s12_p3') }}</p>
            </section>

            <!-- 13 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s13_title') }}</h2>
                <p>{{ __('terms.c_s13_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s13_p2') }}</p>
            </section>

            <!-- 14 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s14_title') }}</h2>
                <p>{{ __('terms.c_s14_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s14_p2') }}</p>
            </section>

            <!-- 15 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s15_title') }}</h2>
                <p>{{ __('terms.c_s15_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s15_p2') }}</p>
            </section>

            <!-- 16 -->
            <section>
                <h2 class="text-xl font-semibold mb-3">{{ __('terms.c_s16_title') }}</h2>
                <p>{{ __('terms.c_s16_p1') }}</p>
                <p class="mt-3">{{ __('terms.c_s16_p2') }}</p>
            </section>

        </div>
    </div>
</div>

    @include('layouts.footer')
    @yield('footer')
</body>
</html>
   