<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8 flex flex-wrap items-start justify-between gap-y-4">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">{{ __('app.manage_businesses') }}</h1>
            <p class="text-gray-600 mt-1 sm:mt-2 text-sm sm:text-base">{{ __('app.view_manage_all_businesses') }}</p>
        </div>
        <a href="{{ route('admin.super.businesses.create') }}"
            class="shrink-0 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:shadow-lg transition text-sm sm:text-base">
            + {{ __('app.add_business') }}
        </a>
    </div>

    <!-- Businesses Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($businesses as $business)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $business->name }}</p>
                            <a href="{{ route('public.business', $business->slug) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-xs text-indigo-500 hover:text-indigo-700 mt-0.5">
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                {{ $business->slug }}
                            </a>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $business->is_active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                @if($business->is_active) {{ __('app.active') }} @else {{ __('app.inactive') }} @endif
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-3">
                        @if($business->address)
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ Str::limit($business->address, 35) }}
                            </span>
                        @endif
                        <span class="text-green-600 font-semibold">{{ $business->users->count() }} {{ __('app.users') }}</span>
                        @if($business->license)
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $business->license->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($business->license->status) }}</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800">{{ __('app.no_license') }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.super.businesses.show', $business) }}" class="text-green-600 hover:text-green-700 font-medium text-sm">{{ __('app.view') }}</a>
                        <a href="{{ route('admin.super.businesses.edit', $business) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">{{ __('app.edit') }}</a>
                        <form method="POST" action="{{ route('admin.super.businesses.destroy', $business) }}" class="inline" onsubmit="return confirm('{{ __('app.delete_business_confirm') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-700 font-medium text-sm">{{ __('app.delete') }}</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    <p class="text-base mb-2">{{ __('app.no_businesses_yet') }}</p>
                    <a href="{{ route('admin.super.businesses.create') }}" class="text-green-600 hover:text-green-700 font-medium text-sm">{{ __('app.create_first_business') }}</a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                            {{ __('app.business_name') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.location') }}
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.users_count') }}
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.license') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.status') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($businesses as $business)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $business->name }}</p>
                                    <a href="{{ route('public.business', $business->slug) }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-xs text-indigo-500 hover:text-indigo-700 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        {{ $business->slug }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $business->address }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="font-bold text-green-600">{{ $business->users->count() }}</span>
                                <span class="text-gray-600">{{ __('app.users') }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($business->license)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                        @if($business->license->isActive()) 
                                                            bg-green-100 text-green-800
                                                        @else
                                                            bg-red-100 text-red-800
                                                        @endif
                                                    ">
                                        {{ ucfirst($business->license->status) }}
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">{{ __('app.no_license') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            @if($business->is_active) 
                                                bg-blue-100 text-blue-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                    @if($business->is_active) {{ __('app.active') }} @else {{ __('app.inactive') }} @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.super.businesses.show', $business) }}"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    {{ __('app.view') }}
                                </a>
                                <a href="{{ route('admin.super.businesses.edit', $business) }}"
                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                    {{ __('app.edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.super.businesses.destroy', $business) }}"
                                    class="inline" onsubmit="return confirm('{{ __('app.delete_business_confirm') }}')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="text-red-600 hover:text-red-700 font-medium">{{ __('app.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg mb-2">{{ __('app.no_businesses_yet') }}</p>
                                <a href="{{ route('admin.super.businesses.create') }}"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    {{ __('app.create_first_business') }}
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- end desktop table -->
    </div>

    <!-- Pagination -->
    @if($businesses->hasPages())
        <div class="mt-6">
            {{ $businesses->links() }}
        </div>
    @endif
</x-admin-layout>