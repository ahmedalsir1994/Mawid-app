<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ __('app.manage_businesses') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('app.view_manage_all_businesses') }}</p>
        </div>
        <a href="{{ route('admin.super.businesses.create') }}"
            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
            + {{ __('app.add_business') }}
        </a>
    </div>

    <!-- Businesses Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
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
                                    <p class="text-sm text-gray-600">{{ $business->slug }}</p>
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
        </div>
    </div>

    <!-- Pagination -->
    @if($businesses->hasPages())
        <div class="mt-6">
            {{ $businesses->links() }}
        </div>
    @endif
</x-admin-layout>