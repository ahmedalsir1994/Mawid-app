<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-800">{{ __('app.booking_details') }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ __('app.reference') }}: {{ $booking->reference_code }}
                    @if($booking->is_walk_in)
                        <span class="ms-2 inline-flex items-center px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">🚶 Walk-in</span>
                    @endif
                </p>
            </div>
            <a href="{{ auth()->user()->role === 'staff' ? route('admin.staff.bookings.index') : route('admin.bookings.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                ← {{ __('app.back_to_bookings') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-medium">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('app.booking_status') }}</h3>
                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full
                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <div>
                    <form method="POST"
                        action="{{ auth()->user()->role === 'staff' ? route('admin.staff.bookings.status', $booking) : route('admin.bookings.status', $booking) }}"
                        class="inline">
                        @csrf
                        <select lang="en" dir="ltr" name="status"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500"
                            onchange="this.form.submit()">
                            @foreach (['pending' => __('app.pending'), 'confirmed' => __('app.confirmed'), 'cancelled' => __('app.cancelled'), 'completed' => __('app.completed')] as $st => $label)
                                <option value="{{ $st }}" @selected($booking->status === $st)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                {{ __('app.customer_information') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 font-medium">{{ __('app.name') }}</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->customer_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Phone</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->customer_phone }}</p>
                </div>
                @if($booking->customer_email)
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->customer_email }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Appointment Details
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="{{ $booking->allServices()->count() > 1 ? 'md:col-span-2' : '' }}">
                    <p class="text-sm text-gray-600 font-medium">Service</p>
                    @if($booking->allServices()->count() > 1)
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($booking->allServices() as $svc)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-50 border border-green-200 text-sm font-medium text-green-800">
                                    <span>{{ $svc->name }}</span>
                                    <span class="text-green-500 text-xs">· {{ $svc->duration_minutes }} min</span>
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-lg font-semibold text-green-600">{{ $booking->services_label }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Duration</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $booking->total_duration }} minutes</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Date</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Time</p>
                    <p class="text-lg font-semibold text-gray-900">{{ substr($booking->start_time, 0, 5) }} -
                        {{ substr($booking->end_time, 0, 5) }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Assigned Staff</p>
                    @if(auth()->user()->role === 'company_admin' && count($staffMembers))
                        <form method="POST" action="{{ route('admin.bookings.reassign', $booking) }}" class="mt-2 flex items-center gap-2">
                            @csrf
                            <select name="staff_user_id"
                                class="flex-1 px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                <option value="">— Unassigned —</option>
                                @foreach($staffMembers as $sm)
                                    <option value="{{ $sm->id }}" @selected($booking->staff_user_id == $sm->id)>
                                        {{ $sm->name }}{{ $sm->title ? ' · '.$sm->title : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition whitespace-nowrap">
                                Reassign
                            </button>
                        </form>
                    @else
                        @if($booking->staff)
                            <div class="flex items-center space-x-2 mt-1">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-700 font-bold text-sm">{{ strtoupper(substr($booking->staff->name, 0, 1)) }}</span>
                                </div>
                                <p class="text-lg font-semibold text-gray-900">{{ $booking->staff->name }}</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic mt-1">Not assigned</p>
                        @endif
                    @endif
                </div>
                @if($booking->branch)
                <div>
                    <p class="text-sm text-gray-600 font-medium">Branch</p>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            📍 {{ $booking->branch->name }}
                        </span>
                        @if($booking->branch->address)
                            <p class="text-sm text-gray-500 mt-1">{{ $booking->branch->address }}</p>
                        @endif
                        @if($booking->branch->phone)
                            <p class="text-xs text-gray-400 mt-0.5">📞 {{ $booking->branch->phone }}</p>
                        @endif
                    </div>
                </div>
                @endif
                @if($booking->customer_notes)
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600 font-medium">Notes</p>
                        <p class="text-gray-900">{{ $booking->customer_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reminder Status -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Reminder Status
            </h3>
            <div class="flex items-center justify-between">
                <div>
                    @if($booking->reminder_sent_at)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            ✓ Reminder Sent
                        </span>
                        <p class="text-sm text-gray-600 mt-2">Sent {{ $booking->reminder_sent_at->diffForHumans() }}</p>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Not Sent
                        </span>
                    @endif
                </div>
                <div>
                    @php
                        // Clean and format phone number
                        $phone = preg_replace('/[^0-9+]/', '', $booking->customer_phone);
                        $phone = ltrim($phone, '+');

                        // Add country code if not present
                        if (!preg_match('/^(968|966|971|965|973|974)/', $phone)) {
                            $phone = '968' . $phone;
                        }

                        // Format date and create message
                        $date = \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y');
                        $time = substr($booking->start_time, 0, 5);

                        $message = "Hello {$booking->customer_name}! 👋\n\n";
                        $message .= "This is a reminder from *" . $booking->business->name . "*\n\n";
                        $message .= "📅 *Appointment Details:*\n";
                        $message .= "Service: {$booking->services_label}\n";
                        $message .= "Date: {$date}\n";
                        $message .= "Time: {$time}\n";

                        if ($booking->branch) {
                            $message .= "Branch: " . $booking->branch->name . "\n";
                            if ($booking->branch->address) {
                                $message .= "Location: " . $booking->branch->address . "\n";
                            }
                        } elseif ($booking->business->address) {
                            $message .= "Location: " . $booking->business->address . "\n";
                        }

                        $message .= "\nWe look forward to seeing you! 😊\n";
                        $message .= "Reply here if you need to reschedule or have any questions.";

                        $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . urlencode($message);
                    @endphp
                    <button type="button" onclick="sendReminder({{ $booking->id }})"
                        class="inline-flex px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        <span>Send Reminder</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Booking Timeline -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Booking Timeline
            </h3>
            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-600">Created:</span>
                    <span
                        class="ml-2 font-semibold text-gray-900">{{ $booking->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="text-gray-600">Last Updated:</span>
                    <span
                        class="ml-2 font-semibold text-gray-900">{{ $booking->updated_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sendReminder(bookingId) {
            // Open WhatsApp
            const whatsappUrl = '{{ $whatsappUrl }}';
            window.open(whatsappUrl, '_blank');

            // Mark reminder as sent via AJAX
            @if(auth()->user()->role === 'staff')
                const url = '{{ route('admin.staff.bookings.reminder', $booking->id) }}';
            @else
                const url = '{{ route('admin.bookings.reminder', $booking->id) }}';
            @endif

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated reminder status
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</x-admin-layout>