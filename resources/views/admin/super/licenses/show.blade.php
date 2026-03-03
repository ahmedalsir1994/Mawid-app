<x-admin-layout>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('app.license_details') }}</h1>
                <p class="text-gray-600 mt-2">{{ $license->business->name }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.super.licenses.edit', $license) }}"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    {{ __('app.edit') }}
                </a>
                <form method="POST" action="{{ route('admin.super.licenses.destroy', $license) }}"
                      class="inline" onsubmit="return confirm('{{ __('app.delete_license_confirm') }}')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        {{ __('app.delete') }}
                    </button>
                </form>
                <a href="{{ route('admin.super.licenses.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                    {{ __('app.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('app.license_information') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.business') }}</label>
                        <a href="{{ route('admin.super.businesses.show', $license->business) }}"
                            class="text-green-600 hover:text-green-700 font-semibold">
                            {{ $license->business->name }}
                        </a>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.plan') }}</label>
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
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-bold {{ $planBadge }}">
                            {{ $planEmoji }} {{ ucfirst($license->plan ?? 'free') }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.billing_cycle') }}</label>
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold capitalize">
                            {{ $license->billing_cycle ?? 'monthly' }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.status') }}</label>
                        <span
                            class="inline-block px-3 py-1 bg-{{ $license->isActive() ? 'green' : 'red' }}-100 text-{{ $license->isActive() ? 'green' : 'red' }}-700 rounded-full text-sm font-semibold">
                            {{ ucfirst($license->status) }}
                        </span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.license_key') }}</label>
                        <div class="flex items-center gap-2">
                            <code
                                class="flex-1 px-4 py-2 bg-gray-50 rounded border border-gray-300 text-gray-900 font-mono text-sm">
                                {{ $license->license_key }}
                            </code>
                            <button onclick="navigator.clipboard.writeText('{{ $license->license_key }}')"
                                class="px-3 py-2 text-gray-600 hover:text-gray-900">
                                {{ __('app.copy') }}
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.max_users') }}</label>
                        <p class="text-gray-900 font-semibold text-lg">{{ $license->max_users }}</p>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.max_daily_bookings') }}</label>
                        <p class="text-gray-900 font-semibold text-lg">{{ $license->max_daily_bookings }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.price') }}</label>
                        <p class="text-gray-900 font-semibold text-lg">{{ $license->currency ?? 'USD' }}
                            {{ number_format($license->price, 2) }}
                        </p>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.payment_status') }}</label>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded text-sm font-semibold">
                            {{ ucfirst($license->payment_status) }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.expires_at') }}</label>
                        <p class="text-gray-900 font-semibold">
                            @if ($license->expires_at)
                                {{ \Carbon\Carbon::parse($license->expires_at)->format('M d, Y') }}
                                <small class="text-gray-600">
                                    @if(!$license->isActive() && $license->expires_at->isPast())
                                        <span class="text-red-600">({{ __('app.expired_days') }}
                                            {{ $license->daysUntilExpiry() }} {{ __('app.days_ago_full') }})</span>
                                    @elseif($license->isExpiring())
                                        <span class="text-yellow-600">({{ $license->daysUntilExpiry() }} {{ __('app.days_left_full') }})</span>
                                    @elseif($license->isActive())
                                        <span class="text-green-600">({{ $license->daysUntilExpiry() }} {{ __('app.days_left_full') }})</span>
                                    @endif
                                </small>
                            @else
                                {{ __('app.never') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Quick Stats -->
            <div class="bg-gradient-to-br from-green-600 to-green-600 rounded-xl shadow-md p-6 text-white">
                <h2 class="text-lg font-bold mb-4">{{ __('app.license_status') }}</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-green-100">{{ __('app.plan') }}</span>
                        <span class="font-bold capitalize">{{ $planEmoji }} {{ ucfirst($license->plan ?? 'free') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-green-100">{{ __('app.status') }}</span>
                        <span class="font-bold">{{ ucfirst($license->status) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-green-100">{{ __('app.users_used') }}</span>
                        <span class="font-bold">{{ $license->business->users->count() }} /
                            {{ $license->max_users }}</span>
                    </div>
                    @if ($license->expires_at)
                        <div class="flex items-center justify-between">
                            <span class="text-green-100">
                                @if(!$license->isActive() && $license->expires_at->isPast())
                                    {{ __('app.days_expired') }}
                                @else
                                    {{ __('app.days_remaining') }}
                                @endif
                            </span>
                            <span class="font-bold">{{ $license->daysUntilExpiry() }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ __('app.quick_actions') }}</h2>
                <div class="space-y-2">
                    <a href="{{ route('admin.super.licenses.edit', $license) }}"
                        class="w-full block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-medium text-sm">
                        {{ __('app.edit_license_action') }}
                    </a>
                    @if(!$license->isActive())
                        <form method="POST" action="{{ route('admin.super.licenses.reactivate', $license) }}"
                            class="w-full">
                            @csrf
                            <button type="submit" onclick="return confirm('{{ __('app.reactivate_license_confirm') }}')"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-medium text-sm">
                                ✓ {{ __('app.reactivate_license') }}
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.super.businesses.show', $license->business) }}"
                        class="w-full block px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition text-center font-medium text-sm">
                        {{ __('app.view_business') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>