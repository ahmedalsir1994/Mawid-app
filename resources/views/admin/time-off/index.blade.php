<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-gray-800">{{ __('app.time_off_holidays') }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ __('app.manage_time_off') }}</p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8 space-y-8">

            @if (session('success'))
                <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Add Time Off Form -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('app.add_time_off') }}</h3>

                <form method="POST" action="{{ route('admin.time_off.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.start_date') }}</label>
                            <input lang="en" dir="ltr" type="date" name="start_date" value="{{ old('start_date') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            @error('start_date') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.end_date') }}</label>
                            <input lang="en" dir="ltr" type="date" name="end_date" value="{{ old('end_date') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            @error('end_date') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.note_optional') }}</label>
                            <input lang="en" dir="ltr" type="text" name="note" value="{{ old('note') }}"
                                placeholder="e.g., Eid, Vacation..."
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            @error('note') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit"
                        class="px-6 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ __('app.add_time_off') }}</span>
                    </button>
                </form>
            </div>

            <!-- Existing Time Off List -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('app.existing_time_off') }}</h3>

                @if ($items->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-600">{{ __('app.no_time_off') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-200 bg-gray-50">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                        {{ __('app.start_date') }}
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                        {{ __('app.end_date') }}
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                        {{ __('app.duration') }}
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                        {{ __('app.note') }}</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase">
                                        {{ __('app.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item->start_date }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item->end_date }}</td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ \Carbon\Carbon::parse($item->start_date)->diffInDays(\Carbon\Carbon::parse($item->end_date)) + 1 }}
                                            {{ __('app.days') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $item->note ?? '-' }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('admin.time_off.destroy', $item) }}"
                                                class="inline"
                                                onsubmit="return confirm('{{ __('app.delete_time_off_confirm') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>