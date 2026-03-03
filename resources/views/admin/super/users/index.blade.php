<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ __('app.manage_users') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('app.create_manage_platform_users') }}</p>
        </div>
        <a href="{{ route('admin.super.users.create') }}"
            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
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
        <div class="overflow-x-auto">
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
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</x-admin-layout>