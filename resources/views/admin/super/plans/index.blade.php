<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-start justify-between gap-y-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">📋 Manage Plans</h1>
                <p class="text-gray-600 mt-1 text-sm">Create and manage subscription plans available to businesses.</p>
            </div>
            <a href="{{ route('admin.super.plans.create') }}"
                class="shrink-0 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:shadow-lg transition text-sm sm:text-base">
                + New Plan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Plan</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Monthly</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Yearly</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Branches</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Staff</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Services</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Daily Bookings</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">WhatsApp</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Licenses</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($plans as $plan)
                    <tr class="hover:bg-gray-50 transition {{ $plan->is_active ? '' : 'opacity-60' }}">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xl">{{ $plan->emoji }}</span>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $plan->name }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $plan->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($plan->price_monthly > 0)
                                <span class="font-medium text-gray-800">{{ number_format($plan->price_monthly, 3) }}</span>
                                <span class="text-xs text-gray-400"> OMR</span>
                            @else
                                <span class="text-green-600 font-medium">Free</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($plan->price_yearly > 0)
                                <span class="font-medium text-gray-800">{{ number_format($plan->price_yearly, 3) }}</span>
                                <span class="text-xs text-gray-400"> OMR</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-gray-700">{{ $plan->max_branches }}</td>
                        <td class="px-4 py-3 text-center text-gray-700">{{ $plan->max_staff }}</td>
                        <td class="px-4 py-3 text-center text-gray-700">
                            {{ $plan->max_services === 0 || $plan->max_services >= 999 ? '∞' : $plan->max_services }}
                        </td>
                        <td class="px-4 py-3 text-center text-gray-700">
                            {{ $plan->max_daily_bookings === 0 || $plan->max_daily_bookings >= 999 ? '∞' : $plan->max_daily_bookings }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($plan->whatsapp_reminders)
                                <span class="text-green-500 text-base">✓</span>
                            @else
                                <span class="text-gray-300 text-base">✗</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm text-gray-600">{{ $plan->licenses()->count() }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($plan->is_active)
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                            @else
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">Disabled</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.super.plans.edit', $plan) }}"
                                    class="px-3 py-1.5 text-xs bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.super.plans.toggle', $plan) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs rounded-lg transition font-medium
                                            {{ $plan->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                                        {{ $plan->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.super.plans.destroy', $plan) }}"
                                    onsubmit="return confirm('Delete plan \'{{ $plan->name }}\'? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-4 py-10 text-center text-gray-400">
                            No plans found. <a href="{{ route('admin.super.plans.create') }}" class="text-green-600 hover:underline">Create your first plan</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-4">
        @forelse($plans as $plan)
            <div class="bg-white rounded-2xl border border-gray-200 p-4 {{ $plan->is_active ? '' : 'opacity-60' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">{{ $plan->emoji }}</span>
                        <div>
                            <p class="font-bold text-gray-900">{{ $plan->name }}</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $plan->slug }}</p>
                        </div>
                    </div>
                    @if($plan->is_active)
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Active</span>
                    @else
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">Disabled</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Monthly</p>
                        <p class="font-semibold">{{ $plan->price_monthly > 0 ? number_format($plan->price_monthly, 3) . ' OMR' : 'Free' }}</p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Yearly</p>
                        <p class="font-semibold">{{ $plan->price_yearly > 0 ? number_format($plan->price_yearly, 3) . ' OMR' : '—' }}</p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Branches / Staff</p>
                        <p class="font-semibold">{{ $plan->max_branches }} / {{ $plan->max_staff }}</p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded-lg">
                        <p class="text-xs text-gray-500">Services / Daily</p>
                        <p class="font-semibold">
                            {{ $plan->max_services === 0 || $plan->max_services >= 999 ? '∞' : $plan->max_services }}
                            /
                            {{ $plan->max_daily_bookings === 0 || $plan->max_daily_bookings >= 999 ? '∞' : $plan->max_daily_bookings }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.super.plans.edit', $plan) }}"
                        class="flex-1 py-2 text-center text-sm bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.super.plans.toggle', $plan) }}" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full py-2 text-sm rounded-lg transition font-medium
                                {{ $plan->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                            {{ $plan->is_active ? 'Disable' : 'Enable' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.super.plans.destroy', $plan) }}" class="flex-1"
                        onsubmit="return confirm('Delete plan \'{{ $plan->name }}\'?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 text-sm bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400">
                No plans found. <a href="{{ route('admin.super.plans.create') }}" class="text-green-600 hover:underline">Create one</a>.
            </div>
        @endforelse
    </div>
</x-admin-layout>
