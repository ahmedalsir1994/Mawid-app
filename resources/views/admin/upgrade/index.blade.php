<x-admin-layout>
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">{{ __('app.dashboard') }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">{{ __('app.upgrade_plan') }}</span>
        </nav>
    </div>

    @if(session('limit_message'))
        <div class="mb-6 p-4 bg-amber-50 border border-amber-300 rounded-xl flex items-start gap-3">
            <span class="text-2xl">⚠️</span>
            <div>
                <p class="font-semibold text-amber-800">{{ __('app.plan_limit_reached') }}</p>
                <p class="text-amber-700 text-sm mt-1">{{ session('limit_message') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-300 rounded-xl text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- Pricing Section — matches landing page structure --}}
    <div class="py-4 px-0">
        <div class="text-center mb-10">
            <div class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-semibold mb-4">
                {{ __('landing.pricing_badge') }}
            </div>
            <h2 class="text-4xl font-bold mb-3">{{ __('landing.pricing_title') }}</h2>
            <p class="text-gray-500 max-w-xl mx-auto">{{ __('landing.pricing_subtitle') }}</p>

            {{-- Current plan badge --}}
            @php $currentPlan = $license?->plan ?? 'free'; @endphp
            <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full text-sm text-gray-600">
                <span>{{ __('app.current_plan') }}:</span>
                <span class="font-bold text-gray-900">{{ ucfirst($currentPlan) }}</span>
                @if($license?->expires_at)
                    <span class="text-gray-400">·</span>
                    <span class="text-gray-500">{{ __('app.renews') }} {{ $license->expires_at->format('M d, Y') }}</span>
                @endif
            </div>
        </div>

        {{-- Monthly / Yearly Toggle --}}
        <div class="flex flex-col items-center mb-10 gap-3">
            <div class="inline-flex items-center bg-gray-100 rounded-xl p-1 gap-1">
                <button id="btn-monthly" onclick="setCycle('monthly')"
                    class="px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900">
                    {{ __('landing.billing_monthly') }}
                </button>
                <button id="btn-yearly" onclick="setCycle('yearly')"
                    class="px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500">
                    {{ __('landing.billing_yearly') }}
                </button>
            </div>
        </div>

        {{-- Plan Cards --}}
        <div class="grid md:grid-cols-3 gap-8 items-start">

            {{-- Free Plan --}}
            @php $isCurrent = $currentPlan === 'free'; @endphp
            <div id="plan-card-free" class="relative bg-white rounded-2xl border {{ $isCurrent ? 'border-2 border-green-400 shadow-lg' : 'border-gray-200' }} p-8 hover:shadow-lg transition">
                @if($isCurrent)
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        {{ __('app.current_plan') }}
                    </div>
                @endif
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
                @if($isCurrent)
                    <button disabled class="w-full py-3 rounded-xl bg-gray-100 text-gray-500 font-semibold cursor-default">
                        {{ __('app.current_plan') }}
                    </button>
                @else
                    <div class="w-full py-3 px-4 rounded-xl border border-gray-200 bg-gray-50 text-center">
                        <p class="text-sm text-gray-500">Your plan reverts to Free automatically when your subscription expires.</p>
                    </div>
                @endif
            </div>

            {{-- Pro Plan --}}
            @php $isCurrent = $currentPlan === 'pro'; @endphp
            <div id="plan-card-pro" class="relative bg-white rounded-2xl border-2 {{ $isCurrent ? 'border-green-400 shadow-lg' : 'border-blue-500 shadow-xl' }} p-8 transition">
                @if($isCurrent)
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        {{ __('app.current_plan') }}
                    </div>
                @else
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        {{ __('landing.plan_popular') }}
                    </div>
                @endif
                <div class="text-3xl mb-3">💼</div>
                <h3 class="text-xl font-bold text-gray-900">{{ __('landing.plan_pro_name') }}</h3>
                <p class="text-sm text-gray-500 mt-1 mb-5">{{ __('landing.plan_pro_tagline') }}</p>
                <div class="mb-6">
                    <div class="cycle-monthly">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm line-through text-gray-400">10 OMR</span>
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 35%</span>
                        </div>
                        <span class="text-4xl font-bold text-gray-900">6.5</span>
                        <span class="text-lg font-semibold text-gray-500 ml-1">OMR</span>
                        <span class="text-sm text-gray-500"> / {{ __('landing.per_month') }}</span>
                    </div>
                    <div class="cycle-yearly" style="display:none">
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
                @if($isCurrent)
                    <button disabled class="w-full py-3 rounded-xl bg-gray-100 text-gray-500 font-semibold cursor-default">
                        {{ __('app.current_plan') }}
                    </button>
                @else
                    <form method="POST" action="{{ route('admin.upgrade.initiate') }}">
                        @csrf
                        <input type="hidden" name="plan" value="pro">
                        <input type="hidden" name="billing_cycle" class="cycle-input" value="monthly">
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold hover:shadow-lg transition">
                            {{ __('landing.plan_pro_cta') }}
                        </button>
                    </form>
                @endif
            </div>

            {{-- Plus Plan --}}
            @php $isCurrent = $currentPlan === 'plus'; @endphp
            <div id="plan-card-plus" class="relative bg-white rounded-2xl border {{ $isCurrent ? 'border-2 border-green-400 shadow-lg' : 'border-gray-200' }} p-8 hover:shadow-lg transition">
                @if($isCurrent)
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        {{ __('app.current_plan') }}
                    </div>
                @endif
                <div class="text-3xl mb-3">🚀</div>
                <h3 class="text-xl font-bold text-gray-900">{{ __('landing.plan_plus_name') }}</h3>
                <p class="text-sm text-gray-500 mt-1 mb-5">{{ __('landing.plan_plus_tagline') }}</p>
                <div class="mb-6">
                    <div class="cycle-monthly">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm line-through text-gray-400">14 OMR</span>
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 30%</span>
                        </div>
                        <span class="text-4xl font-bold text-gray-900">9.8</span>
                        <span class="text-lg font-semibold text-gray-500 ml-1">OMR</span>
                        <span class="text-sm text-gray-500"> / {{ __('landing.per_month') }}</span>
                    </div>
                    <div class="cycle-yearly" style="display:none">
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
                @if($isCurrent)
                    <button disabled class="w-full py-3 rounded-xl bg-gray-100 text-gray-500 font-semibold cursor-default">
                        {{ __('app.current_plan') }}
                    </button>
                @else
                    <form method="POST" action="{{ route('admin.upgrade.initiate') }}">
                        @csrf
                        <input type="hidden" name="plan" value="plus">
                        <input type="hidden" name="billing_cycle" class="cycle-input" value="monthly">
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold hover:shadow-lg transition">
                            {{ __('landing.plan_plus_cta') }}
                        </button>
                    </form>
                @endif
            </div>

        </div>

        <p class="text-center text-sm text-gray-500 mt-8">{{ __('landing.plan_no_card') }}</p>
    </div>

    <script>
        let currentCycle = 'monthly';

        function setCycle(cycle) {
            currentCycle = cycle;
            const isYearly = cycle === 'yearly';

            document.getElementById('btn-monthly').className = isYearly
                ? 'px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500'
                : 'px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900';
            document.getElementById('btn-yearly').className = isYearly
                ? 'px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900'
                : 'px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500';

            document.querySelectorAll('.cycle-monthly').forEach(el => el.style.display = isYearly ? 'none' : 'block');
            document.querySelectorAll('.cycle-yearly').forEach(el => el.style.display = isYearly ? 'block' : 'none');
            document.getElementById('yearly-caption').style.display = isYearly ? 'block' : 'none';
            document.querySelectorAll('.cycle-input').forEach(el => el.value = cycle);
        }

        @if(!empty($preselectedPlan) && in_array($preselectedPlan, ['pro', 'plus']))
        document.addEventListener('DOMContentLoaded', function () {
            const card = document.getElementById('plan-card-{{ $preselectedPlan }}');
            if (card) {
                card.classList.add('ring-2', 'ring-blue-400');
                setTimeout(() => card.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
            }
        });
        @endif
    </script>
</x-admin-layout>
