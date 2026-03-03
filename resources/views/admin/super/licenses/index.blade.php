<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ __('app.manage_licenses') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('app.create_manage_licenses') }}</p>
        </div>
        <a href="{{ route('admin.super.licenses.create') }}"
            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            + {{ __('app.create_license') }}
        </a>
    </div>

    <!-- Licenses Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
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
                                    <p class="text-sm text-gray-600">{{ $license->business->slug }}</p>
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
        </div>
    </div>

    <!-- Pagination -->
    @if($licenses->hasPages())
        <div class="mt-6">
            {{ $licenses->links() }}
        </div>
    @endif
</x-admin-layout>