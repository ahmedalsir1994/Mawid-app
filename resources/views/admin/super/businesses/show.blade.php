<x-admin-layout>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $business->name }}</h1>
                <p class="text-gray-600 mt-2">{{ __('app.business_details') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.super.businesses.edit', $business) }}"
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                    {{ __('app.edit') }}
                </a>
                <a href="{{ route('admin.super.businesses.index') }}"
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
                <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('app.business_information') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.business_name') }}</label>
                        <p class="text-gray-900 font-semibold">{{ $business->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.slug') }}</label>
                        <p class="text-gray-900 font-semibold">{{ $business->slug }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.address') }}</label>
                        <p class="text-gray-900 font-semibold">{{ $business->address }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.country') }}</label>
                        <p class="text-gray-900 font-semibold">{{ $business->country }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.phone') }}</label>
                        <p class="text-gray-900 font-semibold">{{ $business->phone }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.currency') }}</label>
                        <p class="text-gray-900 font-semibold">{{ $business->currency }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.timezone') }}</label>
                        <p class="text-gray-900 font-semibold">{{ $business->timezone }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.status') }}</label>
                        @if ($business->is_active)
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                {{ __('app.active') }}
                            </span>
                        @else
                            <span
                                class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                                {{ __('app.inactive') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('app.services') }}</h2>
                @if ($business->services && $business->services->count())
                    <div class="space-y-2">
                        @foreach ($business->services as $service)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900">{{ $service->name }}</span>
                                <span class="text-gray-600 text-sm">{{ $service->duration }} {{ __('app.mins') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">{{ __('app.no_services_created_yet') }}</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- License Info -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('app.license') }}</h2>
                @if ($business->license)
                    <div class="space-y-3">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1">{{ __('app.license_key') }}</label>
                            <p class="text-sm text-gray-900 font-mono break-all">{{ $business->license->license_key }}</p>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1">{{ __('app.status') }}</label>
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                {{ ucfirst($business->license->status) }}
                            </span>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1">{{ __('app.max_users') }}</label>
                            <p class="text-sm text-gray-900">{{ $business->license->max_users }}</p>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase mb-1">{{ __('app.expires_at') }}</label>
                            <p class="text-sm text-gray-900">
                                @if ($business->license->expires_at)
                                    {{ \Carbon\Carbon::parse($business->license->expires_at)->format('M d, Y') }}
                                @else
                                    {{ __('app.never') }}
                                @endif
                            </p>
                        </div>

                        <a href="{{ route('admin.super.licenses.edit', $business->license) }}"
                            class="w-full mt-3 inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-center font-medium text-sm">
                            {{ __('app.manage_license') }}
                        </a>
                    </div>
                @else
                    <p class="text-gray-600 text-sm mb-4">{{ __('app.no_license_assigned') }}</p>
                    <a href="{{ route('admin.super.licenses.create') }}"
                        class="w-full inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-center font-medium text-sm">
                        {{ __('app.create_license') }}
                    </a>
                @endif
            </div>

            <!-- Team Members -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mt-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ __('app.team_members') }}</h2>
                @if ($business->users && $business->users->count())
                    <div class="space-y-2">
                        @foreach ($business->users as $user)
                            <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-600">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-sm">{{ __('app.no_team_members') }}</p>
                @endif
            </div>

            <!-- Stats -->
            <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl shadow-md p-6 mt-6 text-white">
                <h2 class="text-lg font-bold mb-4">{{ __('app.quick_stats') }}</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-purple-100 text-sm">{{ __('app.total_team') }}</p>
                        <p class="text-2xl font-bold">{{ $business->users ? $business->users->count() : 0 }}</p>
                    </div>
                    <div>
                        <p class="text-purple-100 text-sm">{{ __('app.services') }}</p>
                        <p class="text-2xl font-bold">{{ $business->services ? $business->services->count() : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>