<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-800">{{ __('app.dashboard') }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ __('app.welcome_back') }}, {{ auth()->user()->name }}!</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Bookings -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">{{ __('app.total_bookings') }}</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
                    <p class="text-green-600 text-xs mt-2">↑ 0% {{ __('app.from_last_month') }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z" />
                        <path fill-rule="evenodd" d="M3 11v5a2 2 0 002 2h10a2 2 0 002-2v-5H3zm11 1H9v3h5v-3z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">{{ __('app.pending_bookings') }}</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
                    <p class="text-yellow-600 text-xs mt-2">{{ __('app.action_needed') }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Confirmed Bookings -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">{{ __('app.confirmed_bookings') }}</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
                    <p class="text-green-600 text-xs mt-2">{{ __('app.this_week') }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">{{ __('app.revenue') }}</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">$0</p>
                    <p class="text-green-600 text-xs mt-2">↑ 0% {{ __('app.from_last_month') }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M8.16 2.75a.75.75 0 00-.328 1.385A10.998 10.998 0 0010 3c3.537 0 6.837 1.595 8.977 4.1a.75.75 0 01-1.194.912A9.499 9.499 0 0010 4.5c-2.999 0-5.795 1.26-7.728 3.276a.75.75 0 01-1.194-.912A10.998 10.998 0 018.16 2.75z" />
                        <path fill-rule="evenodd"
                            d="M4.5 7a.5.5 0 01.5.5v2a1.5 1.5 0 103 0v-2a.5.5 0 011 0v2a2.5 2.5 0 11-5 0v-2a.5.5 0 01.5-.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Weekly Bookings Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">{{ __('app.weekly_bookings') }}</h3>
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none">
                    <option>{{ __('app.this_week') }}</option>
                    <option>{{ __('app.last_week') }}</option>
                    <option>{{ __('app.this_month') }}</option>
                </select>
            </div>

            <!-- Simple Bar Chart -->
            <div class="flex items-end justify-between h-64 gap-2">
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-blue-200 rounded-t-lg" style="height: 30%"></div>
                    <p class="text-xs text-gray-600 mt-2">{{ __('app.mon') }}</p>
                </div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-blue-300 rounded-t-lg" style="height: 50%"></div>
                    <p class="text-xs text-gray-600 mt-2">{{ __('app.tue') }}</p>
                </div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-blue-400 rounded-t-lg" style="height: 70%"></div>
                    <p class="text-xs text-gray-600 mt-2">{{ __('app.wed') }}</p>
                </div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-blue-500 rounded-t-lg" style="height: 60%"></div>
                    <p class="text-xs text-gray-600 mt-2">{{ __('app.thu') }}</p>
                </div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-blue-400 rounded-t-lg" style="height: 55%"></div>
                    <p class="text-xs text-gray-600 mt-2">{{ __('app.fri') }}</p>
                </div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-blue-300 rounded-t-lg" style="height: 40%"></div>
                    <p class="text-xs text-gray-600 mt-2">{{ __('app.sat') }}</p>
                </div>
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-blue-200 rounded-t-lg" style="height: 20%"></div>
                    <p class="text-xs text-gray-600 mt-2">{{ __('app.sun') }}</p>
                </div>
            </div>
        </div>

        <!-- Top Services -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('app.top_services') }}</h3>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Haircut</p>
                        <p class="text-xs text-gray-500 mt-1">15 {{ __('app.bookings') }}</p>
                    </div>
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Color Treatment</p>
                        <p class="text-xs text-gray-500 mt-1">12 {{ __('app.bookings') }}</p>
                    </div>
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 68%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Styling</p>
                        <p class="text-xs text-gray-500 mt-1">8 {{ __('app.bookings') }}</p>
                    </div>
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Treatment</p>
                        <p class="text-xs text-gray-500 mt-1">5 {{ __('app.bookings') }}</p>
                    </div>
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        <div class="bg-pink-600 h-2 rounded-full" style="width: 28%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800">{{ __('app.booking_calendar') }}</h3>
                <div class="flex items-center space-x-2">
                    <button id="prevMonth" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <span id="currentMonth"
                        class="text-lg font-semibold text-gray-800 min-w-[150px] text-center"></span>
                    <button id="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button id="todayBtn"
                        class="ml-4 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                        {{ __('app.today') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-2 mb-2">
                <div class="text-center text-xs font-semibold text-gray-600 py-2">{{ __('app.sun') }}</div>
                <div class="text-center text-xs font-semibold text-gray-600 py-2">{{ __('app.mon') }}</div>
                <div class="text-center text-xs font-semibold text-gray-600 py-2">{{ __('app.tue') }}</div>
                <div class="text-center text-xs font-semibold text-gray-600 py-2">{{ __('app.wed') }}</div>
                <div class="text-center text-xs font-semibold text-gray-600 py-2">{{ __('app.thu') }}</div>
                <div class="text-center text-xs font-semibold text-gray-600 py-2">{{ __('app.fri') }}</div>
                <div class="text-center text-xs font-semibold text-gray-600 py-2">{{ __('app.sat') }}</div>
            </div>

            <div id="calendarDays" class="grid grid-cols-7 gap-2">
                <!-- Calendar days will be populated by JavaScript -->
            </div>
        </div>

        <!-- Legend -->
        <div class="px-6 pb-6 flex items-center space-x-6 text-sm">
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                <span class="text-gray-600">{{ __('app.confirmed') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                <span class="text-gray-600">{{ __('app.pending') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <span class="text-gray-600">{{ __('app.completed') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <span class="text-gray-600">{{ __('app.cancelled') }}</span>
            </div>
        </div>
    </div>

    <script>
        let currentDate = new Date();

        // Sample bookings data - In production, this would come from the backend
        const sampleBookings = [
            { date: new Date(2026, 1, 3), status: 'confirmed', count: 3 },
            { date: new Date(2026, 1, 5), status: 'confirmed', count: 2 },
            { date: new Date(2026, 1, 6), status: 'pending', count: 1 },
            { date: new Date(2026, 1, 8), status: 'confirmed', count: 4 },
            { date: new Date(2026, 1, 10), status: 'completed', count: 2 },
            { date: new Date(2026, 1, 12), status: 'pending', count: 2 },
            { date: new Date(2026, 1, 15), status: 'confirmed', count: 3 },
        ];

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            // Update month display
            const monthNames = [
                '{{ __('app.january') }}', '{{ __('app.february') }}', '{{ __('app.march') }}',
                '{{ __('app.april') }}', '{{ __('app.may') }}', '{{ __('app.june') }}',
                '{{ __('app.july') }}', '{{ __('app.august') }}', '{{ __('app.september') }}',
                '{{ __('app.october') }}', '{{ __('app.november') }}', '{{ __('app.december') }}'
            ];
            document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();

            // Clear calendar
            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';

            // Add empty cells for days before month starts
            for (let i = 0; i < firstDay; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'aspect-square p-2';
                calendarDays.appendChild(emptyDiv);
            }

            // Add days of month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                const currentDay = new Date(year, month, day);
                const isToday = currentDay.toDateString() === today.toDateString();

                // Find bookings for this day
                const dayBookings = sampleBookings.filter(b =>
                    b.date.getDate() === day &&
                    b.date.getMonth() === month &&
                    b.date.getFullYear() === year
                );

                dayDiv.className = `aspect-square p-2 rounded-lg border transition cursor-pointer hover:shadow-md ${isToday ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300'
                    }`;

                let bookingIndicators = '';
                if (dayBookings.length > 0) {
                    const statusColors = {
                        'confirmed': 'bg-green-500',
                        'pending': 'bg-yellow-500',
                        'completed': 'bg-blue-500',
                        'cancelled': 'bg-red-500'
                    };

                    dayBookings.forEach(booking => {
                        bookingIndicators += `
                            <div class="flex items-center space-x-1 mt-1">
                                <div class="w-2 h-2 ${statusColors[booking.status]} rounded-full"></div>
                                <span class="text-xs text-gray-600">${booking.count}</span>
                            </div>
                        `;
                    });
                }

                dayDiv.innerHTML = `
                    <div class="font-semibold text-sm ${isToday ? 'text-purple-600' : 'text-gray-800'}">${day}</div>
                    ${bookingIndicators}
                `;

                calendarDays.appendChild(dayDiv);
            }
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        document.getElementById('todayBtn').addEventListener('click', () => {
            currentDate = new Date();
            renderCalendar();
        });

        // Initial render
        renderCalendar();
    </script>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">{{ __('app.recent_bookings') }}</h3>
            <a href="{{ route('admin.bookings.index') }}"
                class="text-purple-600 hover:text-purple-800 text-sm font-medium">{{ __('app.view_all') }}</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            {{ __('app.customer') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            {{ __('app.service') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            {{ __('app.date_time') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            {{ __('app.status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                            {{ __('app.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                    <span class="text-blue-700 font-bold text-xs">JD</span>
                                </div>
                                <span class="font-medium text-gray-800">John Doe</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Haircut</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Feb 5, 2026 - 10:00 AM</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">{{ __('app.confirmed') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button
                                class="text-purple-600 hover:text-purple-800 font-medium">{{ __('app.view') }}</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-pink-200 rounded-full flex items-center justify-center">
                                    <span class="text-pink-700 font-bold text-xs">SM</span>
                                </div>
                                <span class="font-medium text-gray-800">Sarah Miller</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Color Treatment</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Feb 6, 2026 - 2:30 PM</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">{{ __('app.pending') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button
                                class="text-purple-600 hover:text-purple-800 font-medium">{{ __('app.view') }}</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                                    <span class="text-green-700 font-bold text-xs">MP</span>
                                </div>
                                <span class="font-medium text-gray-800">Mike Peterson</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Styling</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Feb 4, 2026 - 3:00 PM</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">{{ __('app.completed') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button
                                class="text-purple-600 hover:text-purple-800 font-medium">{{ __('app.view') }}</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <p class="text-sm text-gray-600">{{ __('app.showing_of', ['count' => 3, 'total' => 12]) }}
                {{ __('app.bookings') }}
            </p>
            <a href="{{ route('admin.bookings.index') }}"
                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-sm font-medium rounded-lg hover:shadow-lg transition">
                {{ __('app.see_all_bookings') }}
            </a>
        </div>
    </div>
</x-admin-layout>