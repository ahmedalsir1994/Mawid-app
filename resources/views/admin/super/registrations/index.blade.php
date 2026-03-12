<x-admin-layout>
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Registration Submissions</h1>
            <p class="text-gray-500 mt-1 text-sm">All businesses that have registered on the platform</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-sm font-bold">
                {{ $total }} total
            </span>
            <a href="{{ route('admin.super.registrations.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Flash -->
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Name, email, business…"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Business Type</label>
            <select name="business_type"
                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Types</option>
                @foreach([
                    'beauty_salon'       => 'Beauty Salon',
                    'barbershop'         => 'Barbershop',
                    'spa_wellness'       => 'Spa & Wellness',
                    'medical_clinic'     => 'Medical Clinic',
                    'dental_clinic'      => 'Dental Clinic',
                    'fitness_gym'        => 'Fitness & Gym',
                    'personal_trainer'   => 'Personal Trainer',
                    'photography'        => 'Photography Studio',
                    'cleaning_services'  => 'Cleaning Services',
                    'home_services'      => 'Home Services',
                    'tutoring'           => 'Tutoring & Education',
                    'legal_consulting'   => 'Legal Consulting',
                    'financial_services' => 'Financial Services',
                    'it_services'        => 'IT Services',
                    'other'              => 'Other',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ request('business_type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Plan</label>
            <select name="plan"
                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Plans</option>
                <option value="free"  {{ request('plan') === 'free'  ? 'selected' : '' }}>Free</option>
                <option value="pro"   {{ request('plan') === 'pro'   ? 'selected' : '' }}>Pro</option>
                <option value="plus"  {{ request('plan') === 'plus'  ? 'selected' : '' }}>Plus</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">License Status</label>
            <select name="status"
                class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Statuses</option>
                <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Active</option>
                <option value="trial"     {{ request('status') === 'trial'     ? 'selected' : '' }}>Trial</option>
                <option value="expired"   {{ request('status') === 'expired'   ? 'selected' : '' }}>Expired</option>
                <option value="past_due"  {{ request('status') === 'past_due'  ? 'selected' : '' }}>Past Due</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit"
            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
            Filter
        </button>
        @if(request('search') || request('plan') || request('status') || request('business_type'))
            <a href="{{ route('admin.super.registrations.index') }}"
               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                Clear
            </a>
        @endif
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Name</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Email / Phone</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Business</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Type / Size</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Plan</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Registered</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                        @forelse($registrations as $reg)
                        @php $license = optional($reg->business)->license; @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($reg->name, 0, 1)) }}
                                    </div>
                                    <p class="font-semibold text-gray-900">{{ $reg->name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <a href="mailto:{{ $reg->email }}" class="text-blue-700 hover:underline text-xs block">{{ $reg->email }}</a>
                                @if(optional($reg->business)->phone)
                                    <a href="tel:{{ $reg->business->phone }}" class="text-gray-500 text-xs mt-0.5 block">{{ $reg->business->phone }}</a>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-gray-700">{{ optional($reg->business)->name ?? '—' }}</td>
                            <td class="px-5 py-4">
                                @if(optional($reg->business)->business_type)
                                    <p class="text-xs text-gray-700 font-medium">{{ ucwords(str_replace('_', ' ', $reg->business->business_type)) }}</p>
                                @endif
                                @if(optional($reg->business)->company_size)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $reg->business->company_size }} employees</p>
                                @endif
                                @if(!optional($reg->business)->business_type && !optional($reg->business)->company_size)
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($license)
                                    @php
                                        $planColors = [
                                            'free'  => 'bg-gray-100 text-gray-600',
                                            'pro'   => 'bg-blue-100 text-blue-700',
                                            'plus'  => 'bg-purple-100 text-purple-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $planColors[$license->plan] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($license->plan) }}
                                        @if($license->billing_cycle)
                                            / {{ ucfirst($license->billing_cycle) }}
                                        @endif
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($license)
                                    @php
                                        $statusColors = [
                                            'active'    => 'bg-green-100 text-green-700',
                                            'expired'   => 'bg-red-100 text-red-700',
                                            'past_due'  => 'bg-yellow-100 text-yellow-700',
                                            'cancelled' => 'bg-gray-100 text-gray-500',
                                            'trial'     => 'bg-teal-100 text-teal-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$license->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst(str_replace('_', ' ', $license->status)) }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-gray-500 whitespace-nowrap text-xs">
                                {{ $reg->created_at->format('d M Y') }}<br>
                                {{ $reg->created_at->format('H:i') }}
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.super.registrations.show', $reg) }}"
                                   class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">No registrations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
