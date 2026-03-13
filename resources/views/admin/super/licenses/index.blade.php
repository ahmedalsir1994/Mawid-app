<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-start justify-between gap-y-4">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">{{ __('app.manage_licenses') }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('app.create_manage_licenses') }}</p>
            </div>
            <a href="{{ route('admin.super.licenses.create') }}"
                class="shrink-0 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transition text-sm sm:text-base">
                + {{ __('app.create_license') }}
            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('admin.super.licenses.index') }}" class="mb-6 flex flex-wrap gap-3 items-center">
        {{-- Search input --}}
        <div class="relative flex-1 min-w-[220px]">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by business name or license key..."
                class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white"
            />
        </div>

        {{-- Plan filter --}}
        <div class="relative">
            <select name="plan" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Plans</option>
                <option value="free"  @selected(request('plan') === 'free')>🆓 Free</option>
                <option value="pro"   @selected(request('plan') === 'pro')>💼 Pro</option>
                <option value="plus"  @selected(request('plan') === 'plus')>🚀 Plus</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        {{-- Status filter --}}
        <div class="relative">
            <select name="status" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Statuses</option>
                <option value="active"    @selected(request('status') === 'active')>Active</option>
                <option value="expired"   @selected(request('status') === 'expired')>Expired</option>
                <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        {{-- Payment filter --}}
        <div class="relative">
            <select name="payment" class="appearance-none pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-300 bg-white text-gray-700 cursor-pointer">
                <option value="">All Payments</option>
                <option value="paid"   @selected(request('payment') === 'paid')>Paid</option>
                <option value="unpaid" @selected(request('payment') === 'unpaid')>Unpaid</option>
            </select>
            <svg class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            Search
        </button>
        @if(request('search') || request('plan') || request('status') || request('payment'))
            <a href="{{ route('admin.super.licenses.index') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Clear
            </a>
        @endif
    </form>

    <!-- Licenses Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($licenses as $license)
                @php
                    $planBadge = match($license->plan ?? 'free') {
                        'pro'  => 'bg-blue-100 text-blue-800',
                        'plus' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-100 text-gray-700',
                    };
                    $planEmoji = match($license->plan ?? 'free') {
                        'pro'  => '💼',
                        'plus' => '🚀',
                        default => '🆓',
                    };
                @endphp
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $license->business->name }}</p>
                            <a href="{{ route('public.business', $license->business->slug) }}" target="_blank"
                               class="text-xs text-green-600 hover:underline">{{ $license->business->slug }}</a>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold {{ $planBadge }} shrink-0">
                            {{ $planEmoji }} {{ ucfirst($license->plan ?? 'free') }}
                            @if(($license->plan ?? 'free') !== 'free')
                                / {{ ucfirst($license->billing_cycle) }}
                            @endif
                        </span>
                    </div>
                    <div class="mb-2">
                        <code class="text-xs bg-gray-100 px-2 py-0.5 rounded">{{ $license->license_key }}</code>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 mb-3 text-xs">
                        @if($license->expires_at)
                            <span class="text-gray-500">{{ $license->expires_at->format('M d, Y') }}</span>
                            @if($license->isExpiring())
                                <span class="font-bold text-orange-600">{{ $license->daysUntilExpiry() }}{{ __('app.days_left') }}</span>
                            @elseif(!$license->isActive() && $license->expires_at->isPast())
                                <span class="font-bold text-red-600">{{ $license->daysUntilExpiry() }}{{ __('app.days_ago') }}</span>
                            @endif
                        @else
                            <span class="text-gray-500">{{ __('app.no_expiry') }}</span>
                        @endif
                        <span class="px-2 py-0.5 rounded-full font-bold
                            @if($license->isActive()) bg-green-100 text-green-800
                            @elseif($license->status === 'expired') bg-red-100 text-red-800
                            @elseif($license->status === 'suspended') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($license->status) }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full font-bold
                            @if($license->payment_status === 'paid') bg-green-100 text-green-800
                            @else bg-orange-100 text-orange-800 @endif">
                            {{ ucfirst($license->payment_status) }}
                        </span>
                        <span class="font-semibold text-gray-900">${{ number_format($license->price, 2) }}</span>
                    </div>
                    <div class="flex gap-3 text-xs">
                        <a href="{{ route('admin.super.licenses.show', $license) }}" class="text-green-600 hover:text-green-700 font-medium">{{ __('app.view') }}</a>
                        <a href="{{ route('admin.super.licenses.edit', $license) }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('app.edit') }}</a>
                        <form method="POST" action="{{ route('admin.super.licenses.destroy', $license) }}" class="inline" onsubmit="return confirm('{{ __('app.delete_license_confirm') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-700 font-medium">{{ __('app.delete') }}</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    <p class="text-lg mb-2">{{ __('app.no_licenses_yet') }}</p>
                    <a href="{{ route('admin.super.licenses.create') }}" class="text-green-600 hover:text-green-700 font-medium">{{ __('app.create_first_license') }}</a>
                </div>
            @endforelse
        </div>
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.business') }}
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.plan') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.license_key') }}
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.expires') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.status') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.payment') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.price') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($licenses as $license)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $license->business->name }}</p>
                                    <a href="{{ route('public.business', $license->business->slug) }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-sm text-green-600 hover:text-green-800 hover:underline transition">
                                        {{ $license->business->slug }}
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $planBadge = match($license->plan ?? 'free') {
                                        'pro'  => 'bg-blue-100 text-blue-800',
                                        'plus' => 'bg-purple-100 text-purple-800',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                    $planEmoji = match($license->plan ?? 'free') {
                                        'pro'  => '💼',
                                        'plus' => '🚀',
                                        default => '🆓',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold {{ $planBadge }}">
                                    {{ $planEmoji }} {{ ucfirst($license->plan ?? 'free') }}
                                </span>
                                @if(($license->plan ?? 'free') !== 'free')
                                    <p class="text-xs text-gray-400 mt-1 capitalize">{{ $license->billing_cycle }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $license->license_key }}</code>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($license->expires_at)
                                    {{ $license->expires_at->format('M d, Y') }}
                                    @if($license->isExpiring())
                                        <span
                                            class="ml-2 text-xs font-bold text-orange-600">{{ $license->daysUntilExpiry() }}{{ __('app.days_left') }}</span>
                                    @elseif(!$license->isActive() && $license->expires_at->isPast())
                                        <span class="ml-2 text-xs font-bold text-red-600">{{ __('app.expired_days_ago') }}
                                            {{ $license->daysUntilExpiry() }}{{ __('app.days_ago') }}</span>
                                    @endif
                                @else
                                    {{ __('app.no_expiry') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                @if($license->isActive()) 
                                                    bg-green-100 text-green-800
                                                @elseif($license->status === 'expired')
                                                    bg-red-100 text-red-800
                                                @elseif($license->status === 'suspended')
                                                    bg-yellow-100 text-yellow-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                    {{ ucfirst($license->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                @if($license->payment_status === 'paid') 
                                                    bg-green-100 text-green-800
                                                @else
                                                    bg-orange-100 text-orange-800
                                                @endif
                                            ">
                                    {{ ucfirst($license->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                ${{ number_format($license->price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.super.licenses.show', $license) }}"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    {{ __('app.view') }}
                                </a>
                                <a href="{{ route('admin.super.licenses.edit', $license) }}"
                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                    {{ __('app.edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.super.licenses.destroy', $license) }}"
                                    class="inline" onsubmit="return confirm('{{ __('app.delete_license_confirm') }}')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="text-red-600 hover:text-red-700 font-medium">{{ __('app.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg mb-2">{{ __('app.no_licenses_yet') }}</p>
                                <a href="{{ route('admin.super.licenses.create') }}"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    {{ __('app.create_first_license') }}
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- end desktop table -->
    </div>

    <!-- Pagination -->
    @if($licenses->hasPages())
        <div class="mt-6">
            {{ $licenses->links() }}
        </div>
    @endif
</x-admin-layout>