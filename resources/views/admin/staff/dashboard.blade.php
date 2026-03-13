<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-wrap items-start justify-between gap-y-3">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">👋 {{ __('app.welcome', ['name' => Auth::user()->name]) }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('app.staff_dashboard_title', ['business' => $business->name]) }}</p>
            </div>
            <div class="text-right">
                @if($license && $license->isActive())
                    <span class="inline-block px-3 py-1.5 sm:px-4 sm:py-2 bg-green-100 text-green-800 font-medium rounded-lg text-sm">
                        ✓ {{ __('app.system_active') }}
                    </span>
                @endif
                <p class="text-sm text-gray-600 mt-1">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <!-- Today's Bookings -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 rounded-xl shadow-md p-6 text-white">
            <h3 class="font-medium mb-2 opacity-90">{{ __('app.today_bookings') }}</h3>
            <p class="text-3xl sm:text-4xl font-bold">{{ $todayBookings }}</p>
            <p class="text-sm mt-2 opacity-90">{{ now()->format('l') }}</p>
        </div>

        <!-- Upcoming Bookings -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2">{{ __('app.upcoming_bookings') }}</h3>
            <p class="text-3xl sm:text-4xl font-bold text-gray-900">{{ $upcomingBookings->count() }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ __('app.next_7_days') }}</p>
        </div>

        <!-- Total Services -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-gray-600 font-medium mb-2">{{ __('app.available_services') }}</h3>
            <p class="text-3xl sm:text-4xl font-bold text-gray-900">{{ $services->count() }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ __('app.offered_by_business') }}</p>
        </div>
    </div>

    <!-- Today's Schedule -->
    @if($todayBookingsList->count() > 0)
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-y-1 mb-4 sm:mb-6">
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900">🗓️ {{ __('app.today_schedule') }}</h2>
                <span class="text-sm text-gray-600">{{ now()->format('l, M j') }}</span>
            </div>

            <div class="space-y-3">
                @foreach($todayBookingsList as $booking)
                    <div class="flex items-center gap-4 p-4 rounded-lg border-l-4 
                                @if($booking->status === 'confirmed') border-green-500 bg-green-50
                                @elseif($booking->status === 'pending') border-yellow-500 bg-yellow-50
                                @elseif($booking->status === 'completed') border-blue-500 bg-blue-50
                                @else border-gray-300 bg-gray-50
                                @endif">

                        <div class="flex-shrink-0 text-center">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</div>
                            <div class="text-xs text-gray-600">{{ $booking->total_duration }}min</div>
                        </div>

                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">{{ $booking->services_label }}</h3>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">{{ $booking->customer_name }}</span>
                                @if($booking->customer_phone)
                                    • {{ $booking->customer_phone }}
                                @endif
                            </p>
                        </div>

                        <div class="flex-shrink-0">
                            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8 mb-8 text-center">
            <div class="text-6xl mb-4">🎉</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('app.no_bookings_today') }}</h3>
            <p class="text-gray-600">{{ __('app.enjoy_free_time') }}</p>
        </div>
    @endif

    <!-- Live Calendar View -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
        <!-- Calendar Header -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-6 gap-4">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900">📅 {{ __('app.calendar_view') }}</h2>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full lg:w-auto">
                <!-- View Switcher -->
                <div class="flex bg-gray-100 rounded-lg p-1 gap-1">
                    <a href="{{ route('admin.staff.dashboard', ['view' => 'day', 'date' => $currentDate->format('Y-m-d')]) }}"
                        class="px-4 py-2 rounded-md text-sm font-medium transition {{ $view === 'day' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        {{ __('app.day') }}
                    </a>
                    <a href="{{ route('admin.staff.dashboard', ['view' => 'week', 'date' => $currentDate->format('Y-m-d')]) }}"
                        class="px-4 py-2 rounded-md text-sm font-medium transition {{ $view === 'week' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        {{ __('app.week') }}
                    </a>
                    <a href="{{ route('admin.staff.dashboard', ['view' => 'month', 'date' => $currentDate->format('Y-m-d')]) }}"
                        class="px-4 py-2 rounded-md text-sm font-medium transition {{ $view === 'month' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        {{ __('app.month') }}
                    </a>
                </div>

                <!-- Date Navigation -->
                <div class="flex items-center gap-2">
                    @php
                        $prevDate = $view === 'day' ? $currentDate->copy()->subDay() :
                                    ($view === 'week' ? $currentDate->copy()->subWeek() : $currentDate->copy()->subMonth());
                        $nextDate = $view === 'day' ? $currentDate->copy()->addDay() :
                                    ($view === 'week' ? $currentDate->copy()->addWeek() : $currentDate->copy()->addMonth());
                    @endphp

                    <a href="{{ route('admin.staff.dashboard', ['view' => $view, 'date' => $prevDate->format('Y-m-d')]) }}"
                        class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>

                    <span class="text-sm font-medium text-gray-700 min-w-[140px] text-center">
                        @if($view === 'day')
                            {{ $currentDate->format('M d, Y') }}
                        @elseif($view === 'week')
                            {{ $startDate->format('M d') }} - {{ $endDate->format('M d, Y') }}
                        @else
                            {{ $currentDate->format('F Y') }}
                        @endif
                    </span>

                    <a href="{{ route('admin.staff.dashboard', ['view' => $view, 'date' => $nextDate->format('Y-m-d')]) }}"
                        class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('admin.staff.dashboard', ['view' => $view, 'date' => now()->format('Y-m-d')]) }}"
                        class="ml-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        {{ __('app.today') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Day View -->
        @if($view === 'day')
            @php
                $dayBookings = $calendarBookings->get($currentDate->format('Y-m-d'), collect());
            @endphp

            <div class="border rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-500 text-white p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $currentDate->format('l') }}</h3>
                            <p class="text-sm opacity-90">{{ $currentDate->format('F j, Y') }}</p>
                        </div>
                        <div class="text-3xl">
                            @if($dayBookings->count() > 0)
                                📅
                            @else
                                🎉
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    @forelse($dayBookings as $booking)
                        <div class="flex items-start gap-4 p-4 mb-3 rounded-lg border-l-4 
                                    @if($booking->status === 'confirmed') border-green-500 bg-green-50
                                    @elseif($booking->status === 'pending') border-yellow-500 bg-yellow-50
                                    @elseif($booking->status === 'completed') border-blue-500 bg-blue-50
                                    @else border-gray-300 bg-gray-50
                                    @endif">

                            <div class="flex-shrink-0 text-center bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</div>
                                <div class="text-xs text-gray-600 mt-1">{{ $booking->total_duration }} min</div>
                            </div>

                            <div class="flex-1">
                                <h4 class="font-bold text-lg text-gray-900 mb-1">{{ $booking->services_label }}</h4>
                                <p class="text-sm text-gray-600 mb-2">
                                    <span class="font-medium">{{ $booking->customer_name }}</span>
                                    @if($booking->customer_phone)
                                        • {{ $booking->customer_phone }}
                                    @endif
                                </p>
                                @if($booking->customer_email)
                                    <p class="text-xs text-gray-500">✉️ {{ $booking->customer_email }}</p>
                                @endif
                            </div>

                            <div class="flex-shrink-0">
                                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                            @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-500">
                            <div class="text-6xl mb-4">🎉</div>
                            <p class="text-lg font-medium">{{ __('app.no_bookings_for_day') }}</p>
                            <p class="text-sm">{{ __('app.enjoy_free_time_short') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

        <!-- Week View -->
        @elseif($view === 'week')
            @php
                $weekDays = [];
                $current = $startDate->copy();
                while ($current <= $endDate) {
                    $weekDays[] = $current->copy();
                    $current->addDay();
                }
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-2">
                @foreach($weekDays as $day)
                    @php
                        $dayBookings = $calendarBookings->get($day->format('Y-m-d'), collect());
                        $isToday = $day->isToday();
                    @endphp

                    <div class="min-h-[150px] border rounded-lg p-3 
                                @if($isToday) bg-green-50 border-green-400 border-2
                                @else bg-white border-gray-200 @endif transition hover:shadow-md">

                        <div class="text-center mb-3 pb-2 border-b {{ $isToday ? 'border-green-300' : 'border-gray-200' }}">
                            <div class="text-xs font-medium text-gray-600">{{ $day->format('D') }}</div>
                            <div class="text-xl font-bold 
                                        @if($isToday) text-green-600 
                                        @else text-gray-900 @endif">
                                {{ $day->format('j') }}
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            @forelse($dayBookings as $booking)
                                <div class="text-xs p-2 rounded-md shadow-sm
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800 border border-green-200
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                            @elseif($booking->status === 'completed') bg-blue-100 text-blue-800 border border-blue-200
                                            @else bg-gray-100 text-gray-700 border border-gray-200
                                            @endif">
                                    <div class="font-bold mb-0.5">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                    </div>
                                    <div class="truncate font-medium">{{ $booking->services_label }}</div>
                                    <div class="truncate text-[10px] opacity-75 mt-0.5">
                                        {{ $booking->customer_name }}</div>
                                </div>
                            @empty
                                <div class="text-xs text-gray-400 text-center py-3">
                                    <div class="text-2xl mb-1">·</div>
                                    <div>{{ __('app.no_bookings') }}</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>

        <!-- Month View -->
        @elseif($view === 'month')
            @php
                $monthStart = $startDate->copy()->startOfMonth()->startOfWeek();
                $monthEnd = $endDate->copy()->endOfMonth()->endOfWeek();
                $weeks = [];
                $currentWeek = [];
                $current = $monthStart->copy();

                while ($current <= $monthEnd) {
                    $currentWeek[] = $current->copy();
                    if (count($currentWeek) === 7) {
                        $weeks[] = $currentWeek;
                        $currentWeek = [];
                    }
                    $current->addDay();
                }
            @endphp

            <div class="border rounded-lg overflow-hidden">
                <!-- Day Headers -->
                <div class="grid grid-cols-7 bg-gray-50 border-b">
                    @foreach(['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'] as $dayName)
                        <div class="p-3 text-center text-sm font-bold text-gray-700 border-r last:border-r-0">
                            {{ __('app.' . $dayName) }}
                        </div>
                    @endforeach
                </div>

                <!-- Calendar Grid -->
                @foreach($weeks as $week)
                    <div class="grid grid-cols-7 border-b last:border-b-0">
                        @foreach($week as $day)
                            @php
                                $dayBookings = $calendarBookings->get($day->format('Y-m-d'), collect());
                                $isToday = $day->isToday();
                                $isCurrentMonth = $day->month === $currentDate->month;
                            @endphp

                            <div class="min-h-[100px] p-2 border-r last:border-r-0 
                                        @if(!$isCurrentMonth) bg-gray-50 
                                        @elseif($isToday) bg-green-50 
                                        @else bg-white @endif hover:bg-gray-50 transition">

                                <div class="text-sm font-medium mb-1 
                                            @if($isToday) text-green-600 font-bold
                                            @elseif(!$isCurrentMonth) text-gray-400
                                            @else text-gray-900 @endif">
                                    {{ $day->format('j') }}
                                </div>

                                <div class="space-y-1">
                                    @foreach($dayBookings->take(3) as $booking)
                                        <div class="text-[10px] p-1 rounded truncate
                                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-700
                                                    @endif">
                                            <span class="font-semibold">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                            </span>
                                            {{ $booking->services_label }}
                                        </div>
                                    @endforeach

                                    @if($dayBookings->count() > 3)
                                        <div class="text-[10px] text-green-600 font-semibold">
                                            +{{ $dayBookings->count() - 3 }} {{ __('app.more') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Upcoming Bookings -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
        <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">📋 {{ __('app.upcoming_bookings') }}</h2>

        @if($upcomingBookings->count() > 0)
            <div class="space-y-3">
                @foreach($upcomingBookings as $booking)
                    <div
                        class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:shadow-md transition">
                        <div class="flex-shrink-0 text-center bg-green-100 rounded-lg p-3">
                            <div class="text-xs font-medium text-green-600">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M') }}</div>
                            <div class="text-2xl font-bold text-green-600">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d') }}</div>
                        </div>

                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">{{ $booking->services_label }}</h3>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">{{ $booking->customer_name }}</span>
                                • {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                                • {{ $booking->total_duration }} min
                            </p>
                        </div>

                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.staff.bookings.show', $booking) }}"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                {{ __('app.view_details') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <p>{{ __('app.no_upcoming_bookings') }}</p>
            </div>
        @endif
    </div>
</x-admin-layout>