@section('footer')
<footer class="bg-white-900 text-black-300 py-12 px-4 sm:px-6 lg:px-8  border-gray-700 ">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <a href="http://mawid.om" target="_blank" rel="noopener noreferrer">
                        <img src="/images/Mawid.png" alt="Mawid Logo" class="h-10 mb-4">
                    </a>
                    <p class="text-sm">{{ __('landing.footer_desc') }}</p>
                </div>
                <div>
                    <h5 class="font-bold text-black mb-4">{{ __('landing.footer_product') }}</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/#features" class="hover:text-black transition">{{ __('landing.footer_features') }}</a></li>
                        <li><a href="/#pricing" class="hover:text-black transition">{{ __('landing.footer_pricing') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-black mb-4">{{ __('landing.footer_company') }}</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-black transition">{{ __('landing.footer_about') }}</a></li>
                        <li><a href="{{ route('blog') }}" class="hover:text-black transition">{{ __('landing.footer_blog') }}</a></li>
                        <li><a href="#" class="hover:text-black transition">{{ __('landing.footer_careers') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-black mb-4">{{ __('landing.footer_legal') }}</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('privacy') }}" class="hover:text-black transition">{{ __('landing.footer_privacy') }}</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-black transition">{{ __('landing.footer_terms') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-black transition">{{ __('landing.footer_contact') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-sm">
                <p>{{ __('landing.footer_copyright', ['name' => config('app.name')]) }}</p>
            </div>
        </div>
    </footer>
@endsection