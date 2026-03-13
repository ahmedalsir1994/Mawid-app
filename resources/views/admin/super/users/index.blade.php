<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8 flex flex-wrap items-start justify-between gap-y-4">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">{{ __('app.manage_users') }}</h1>
            <p class="text-gray-600 mt-1 sm:mt-2 text-sm sm:text-base">{{ __('app.create_manage_platform_users') }}</p>
        </div>
        <a href="{{ route('admin.super.users.create') }}"
            class="shrink-0 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transition text-sm sm:text-base">
            + {{ __('app.add_user') }}
        </a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('admin.super.users.index') }}" class="mb-6 flex flex-wrap gap-3">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by name or email..."
            class="flex-1 min-w-[200px] px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-300"
        />
        <select name="role" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <option value="">All Roles</option>
            <option value="super_admin" @selected(request('role') === 'super_admin')>Super Admin</option>
            <option value="company_admin" @selected(request('role') === 'company_admin')>Company Admin</option>
            <option value="staff" @selected(request('role') === 'staff')>Staff</option>
            <option value="customer" @selected(request('role') === 'customer')>Customer</option>
        </select>
        <button type="submit" class="px-5 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition">Search</button>
        @if(request('search') || request('role'))
            <a href="{{ route('admin.super.users.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">Clear</a>
        @endif
    </form>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($users as $user)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-purple-700 font-bold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 text-sm truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                @if($user->is_active) {{ __('app.active') }} @else {{ __('app.inactive') }} @endif
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 text-xs mb-3">
                        @php
                            $roleBadge = match($user->role) {
                                'super_admin' => 'bg-red-100 text-red-800',
                                'company_admin' => 'bg-blue-100 text-blue-800',
                                'staff' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $roleBadge }}">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                        @if($user->business)
                            @php
                                $userPlan = $user->business?->license?->plan ?? 'free';
                                $userBadge = match($userPlan) { 'pro' => 'bg-blue-100 text-blue-800', 'plus' => 'bg-purple-100 text-purple-800', default => 'bg-gray-100 text-gray-600' };
                                $userEmoji = match($userPlan) { 'pro'=>'💼','plus'=>'🚀',default=>'🆓' };
                            @endphp
                            <span class="text-gray-500">{{ $user->business->name }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $userBadge }}">{{ $userEmoji }} {{ ucfirst($userPlan) }}</span>
                        @endif
                        <span class="text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.super.users.show', $user) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">{{ __('app.view') }}</a>
                        <a href="{{ route('admin.super.users.edit', $user) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">{{ __('app.edit') }}</a>
                        <form method="POST" action="{{ route('admin.super.users.destroy', $user) }}" class="inline" onsubmit="return confirm('{{ __('app.delete_user_confirm') }}')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-700 font-medium text-sm">{{ __('app.delete') }}</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    <p class="text-base mb-2">{{ __('app.no_users_yet') }}</p>
                    <a href="{{ route('admin.super.users.create') }}" class="text-green-600 hover:text-green-700 font-medium text-sm">{{ __('app.create_first_user') }}</a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.user') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.email') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.role') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.business') }}
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.plan') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.status') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.joined') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span
                                            class="text-purple-700 font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            @if($user->role === 'super_admin') 
                                                bg-red-100 text-red-800
                                            @elseif($user->role === 'company_admin')
                                                bg-blue-100 text-blue-800
                                            @elseif($user->role === 'staff')
                                                bg-green-100 text-green-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->business?->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $userPlan = $user->business?->license?->plan ?? 'free';
                                    $userBadge = match($userPlan) {
                                        'pro'  => 'bg-blue-100 text-blue-800',
                                        'plus' => 'bg-purple-100 text-purple-800',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                    $userEmoji = match($userPlan) { 'pro'=>'💼','plus'=>'🚀',default=>'🆓' };
                                @endphp
                                @if($user->business)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $userBadge }}">
                                        {{ $userEmoji }} {{ ucfirst($userPlan) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            @if($user->is_active) 
                                                bg-green-100 text-green-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                    @if($user->is_active) {{ __('app.active') }} @else {{ __('app.inactive') }} @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.super.users.show', $user) }}"
                                    class="text-purple-600 hover:text-purple-700 font-medium">
                                    {{ __('app.view') }}
                                </a>
                                <a href="{{ route('admin.super.users.edit', $user) }}"
                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                    {{ __('app.edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.super.users.destroy', $user) }}" class="inline"
                                    onsubmit="return confirm('{{ __('app.delete_user_confirm') }}')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="text-red-600 hover:text-red-700 font-medium">{{ __('app.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg mb-2">{{ __('app.no_users_yet') }}</p>
                                <a href="{{ route('admin.super.users.create') }}"
                                    class="text-green-600 hover:text-green-700 font-medium">
                                    {{ __('app.create_first_user') }}
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- end desktop table -->
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</x-admin-layout>