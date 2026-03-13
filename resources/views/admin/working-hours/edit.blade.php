<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl sm:text-2xl md:text-3xl text-gray-800">{{ __('app.working_hours') }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ __('app.set_business_hours') }}</p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">

            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.working_hours.update') }}" class="space-y-6">
                @csrf

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">{{ __('app.day') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">{{ __('app.closed') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">First Shift</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Second Shift</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($days as $dow => $label)
                                @php 
                                    $row = $hours[$dow]; 
                                    $isClosed = old("hours.$dow.is_closed", $row->is_closed);
                                @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition" id="day-{{ $dow }}">
                                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $label }}</td>

                                    <td class="px-6 py-4">
                                        <input lang="en" dir="ltr" type="checkbox" name="hours[{{ $dow }}][is_closed]"
                                            @checked($isClosed)
                                            onchange="toggleTimeInputs(this)"
                                            class="w-4 h-4 text-green-600 rounded focus:ring-2 focus:ring-green-500 cursor-pointer" />
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($isClosed)
                                            <span class="text-gray-400">{{ __('app.closed') }}</span>
                                        @else
                                            <div class="flex flex-col space-y-2">
                                                <div>
                                                    <label class="block text-xs text-gray-600 mb-1">Start</label>
                                                    <input lang="en" dir="ltr" type="time" name="hours[{{ $dow }}][first_shift_start]"
                                                        value="{{ old("hours.$dow.first_shift_start", $row->first_shift_start ?? '') }}"
                                                        class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" />
                                                    @error("hours.$dow.first_shift_start")
                                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-xs text-gray-600 mb-1">End</label>
                                                    <input lang="en" dir="ltr" type="time" name="hours[{{ $dow }}][first_shift_end]"
                                                        value="{{ old("hours.$dow.first_shift_end", $row->first_shift_end ?? '') }}"
                                                        class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" />
                                                    @error("hours.$dow.first_shift_end")
                                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($isClosed)
                                            <span class="text-gray-400">{{ __('app.closed') }}</span>
                                        @else
                                            <div class="flex flex-col space-y-2">
                                                <div>
                                                    <label class="block text-xs text-gray-600 mb-1">Start</label>
                                                    <input lang="en" dir="ltr" type="time" name="hours[{{ $dow }}][second_shift_start]"
                                                        value="{{ old("hours.$dow.second_shift_start", $row->second_shift_start ?? '') }}"
                                                        class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" />
                                                    @error("hours.$dow.second_shift_start")
                                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-xs text-gray-600 mb-1">End</label>
                                                    <input lang="en" dir="ltr" type="time" name="hours[{{ $dow }}][second_shift_end]"
                                                        value="{{ old("hours.$dow.second_shift_end", $row->second_shift_end ?? '') }}"
                                                        class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" />
                                                    @error("hours.$dow.second_shift_end")
                                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 pt-6 flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition">
                        {{ __('app.cancel') }}
                    </a>
                    <button type="submit" class="px-8 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ __('app.save_changes') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleTimeInputs(checkbox) {
            const row = checkbox.closest('tr');
            const startCell = row.querySelectorAll('td')[2];
            const endCell = row.querySelectorAll('td')[3];
            
            if (checkbox.checked) {
                startCell.innerHTML = '<span class="text-gray-400">{{ __('app.closed') }}</span>';
                endCell.innerHTML = '<span class="text-gray-400">{{ __('app.closed') }}</span>';
            } else {
                const dow = checkbox.name.match(/hours\[(\d+)\]/)[1];
                const startValue = checkbox.dataset.startTime || '';
                const endValue = checkbox.dataset.endTime || '';
                startCell.innerHTML = `<input lang="en" dir="ltr" type="time" name="hours[${dow}][start_time]" value="${startValue}" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500" />`;
                endCell.innerHTML = `<input lang="en" dir="ltr" type="time" name="hours[${dow}][end_time]" value="${endValue}" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500" />`;
            }
        }
    </script>
</x-admin-layout>