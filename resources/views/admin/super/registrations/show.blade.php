<x-admin-layout>
    @php
        $business = $user->business;
        $license  = optional($business)->license;
        $planColors = [
            'free'  => 'bg-gray-100 text-gray-600',
            'pro'   => 'bg-blue-100 text-blue-700',
            'plus'  => 'bg-purple-100 text-purple-700',
        ];
        $statusColors = [
            'active'    => 'bg-green-100 text-green-700',
            'expired'   => 'bg-red-100 text-red-700',
            'past_due'  => 'bg-yellow-100 text-yellow-700',
            'cancelled' => 'bg-gray-100 text-gray-500',
            'trial'     => 'bg-teal-100 text-teal-700',
        ];
    @endphp

    <!-- Back + Header -->
    <div class="mb-8 flex items-start justify-between flex-wrap gap-4">
        <div>
            <a href="{{ route('admin.super.registrations.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-3 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to registrations
            </a>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
            <p class="text-gray-500 mt-1 text-sm">Registered {{ $user->created_at->format('D, d M Y \a\t H:i') }}</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('admin.super.users.show', $user) }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                View Full Profile
            </a>
            @if($business)
                <a href="{{ route('admin.super.businesses.show', $business) }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                    View Business
                </a>
            @endif
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- Left: Registration Details -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Business Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Business Information</h3>
                @if($business)
                    <div class="flex items-center gap-4 mb-5">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}"
                                 alt="{{ $business->name }}" class="w-14 h-14 rounded-xl object-cover border border-gray-100">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr($business->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-gray-900 text-lg">{{ $business->name }}</p>
                            @if($business->slug)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $business->slug }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4 text-sm">
                        @if($business->phone)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Phone</p>
                            <a href="tel:{{ $business->phone }}" class="text-gray-700 hover:text-blue-600 transition">{{ $business->phone }}</a>
                        </div>
                        @endif
                        @if($business->business_type)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Business Type</p>
                            <p class="text-gray-700">{{ ucwords(str_replace('_', ' ', $business->business_type)) }}</p>
                        </div>
                        @endif
                        @if($business->company_size)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Company Size</p>
                            <p class="text-gray-700">{{ $business->company_size }} employees</p>
                        </div>
                        @endif
                        @if($business->country)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Country</p>
                            <p class="text-gray-700">{{ $business->country }}</p>
                        </div>
                        @endif
                        @if($business->address)
                        <div class="sm:col-span-2">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Address</p>
                            <p class="text-gray-700">{{ $business->address }}</p>
                        </div>
                        @endif
                        @if($business->timezone)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Timezone</p>
                            <p class="text-gray-700">{{ $business->timezone }}</p>
                        </div>
                        @endif
                        @if($business->currency)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Currency</p>
                            <p class="text-gray-700">{{ $business->currency }}</p>
                        </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-400 text-sm">No business linked to this user.</p>
                @endif
            </div>

            <!-- License / Subscription -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Subscription / License</h3>
                @if($license)
                    <div class="grid sm:grid-cols-2 gap-5 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Plan</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $planColors[$license->plan] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($license->plan) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$license->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst(str_replace('_', ' ', $license->status)) }}
                            </span>
                        </div>
                        @if($license->billing_cycle)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Billing Cycle</p>
                            <p class="text-gray-700">{{ ucfirst($license->billing_cycle) }}</p>
                        </div>
                        @endif
                        @if($license->expires_at)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Expires At</p>
                            <p class="text-gray-700">{{ $license->expires_at->format('d M Y') }}</p>
                        </div>
                        @endif
                        @if($license->grace_period_ends_at)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Grace Period Ends</p>
                            <p class="text-gray-700">{{ $license->grace_period_ends_at->format('d M Y') }}</p>
                        </div>
                        @endif
                        @if($license->started_at)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Started At</p>
                            <p class="text-gray-700">{{ $license->started_at->format('d M Y') }}</p>
                        </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-400 text-sm">No license found.</p>
                @endif
            </div>

            <!-- Activity Stats -->
            @if($business)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Activity</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-center">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $business->bookings->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Bookings</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $business->users->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Team Members</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-2xl font-bold text-gray-900">{{ optional($business->branches)->count() ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">Branches</p>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Right: Account Info -->
        <div class="space-y-5">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Account</h3>

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <a href="mailto:{{ $user->email }}" class="text-blue-700 hover:underline text-xs break-all">{{ $user->email }}</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs {{ $user->is_active ? 'text-green-700 font-semibold' : 'text-red-600 font-semibold' }}">
                            {{ $user->is_active ? 'Active Account' : 'Inactive Account' }}
                        </span>
                    </div>
                    @if($user->email_verified_at)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-600">Email verified</span>
                    </div>
                    @endif
                    @if($user->pending_plan)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs text-yellow-700 font-semibold">Pending: {{ ucfirst($user->pending_plan) }} / {{ ucfirst($user->pending_cycle ?? '') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Quick Actions</h3>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('admin.super.users.show', $user) }}"
                       class="flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        View User Profile
                    </a>
                    @if($business)
                        <a href="{{ route('admin.super.businesses.show', $business) }}"
                           class="flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            View Business
                        </a>
                        @if($license)
                            <a href="{{ route('admin.super.licenses.show', $license) }}"
                               class="flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Manage License
                            </a>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
