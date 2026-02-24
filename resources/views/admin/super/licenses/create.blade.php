<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">{{ __('app.create_license') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('app.create_new_license') }}</p>
    </div>

    <!-- Create Form -->
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.super.licenses.store') }}"
            class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            @csrf

            <!-- Business Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.business') }} *</label>
                <select name="business_id" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    <option value="">{{ __('app.select_business') }}</option>
                    @foreach($businesses as $business)
                        <option value="{{ $business->id }}">{{ $business->name }}</option>
                    @endforeach
                </select>
                @error('business_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- License Key -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.license_key') }} *</label>
                <div class="flex gap-2">
                    <input type="text" name="license_key" required
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="LIC-XXX..." value="{{ old('license_key') }}">
                    <button type="button" onclick="generateKey()"
                        class="px-4 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition">
                        {{ __('app.generate') }}
                    </button>
                </div>
                @error('license_key')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.status') }} *</label>
                    <select name="status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="active" selected>{{ __('app.active') }}</option>
                        <option value="expired">{{ __('app.expired') }}</option>
                        <option value="suspended">{{ __('app.suspended') }}</option>
                        <option value="cancelled">{{ __('app.cancelled') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.payment_status') }} *</label>
                    <select name="payment_status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="unpaid">{{ __('app.unpaid') }}</option>
                        <option value="paid" selected>{{ __('app.paid') }}</option>
                    </select>
                    @error('payment_status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Max Users -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.max_users') }} *</label>
                    <input type="number" name="max_users" required min="1"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="5" value="{{ old('max_users', 5) }}">
                    @error('max_users')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Max Daily Bookings -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.max_daily_bookings') }}
                        *</label>
                    <input type="number" name="max_daily_bookings" required min="1"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="100" value="{{ old('max_daily_bookings', 100) }}">
                    @error('max_daily_bookings')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Expires At -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.expiration_date') }}
                        *</label>
                    <input type="date" name="expires_at" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        value="{{ old('expires_at') }}">
                    @error('expires_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.price_usd') }} *</label>
                    <input type="number" name="price" required min="0" step="0.01"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="99.99" value="{{ old('price', 0) }}">
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.notes') }}</label>
                <textarea name="notes" rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="{{ __('app.add_notes_license') }}">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                    {{ __('app.create_license') }}
                </button>
                <a href="{{ route('admin.super.licenses.index') }}"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                    {{ __('app.cancel') }}
                </a>
            </div>
        </form>
    </div>

    <script>
        function generateKey() {
            const key = 'LIC-' + Math.random().toString(36).substring(2, 22).toUpperCase();
            document.querySelector('input[name="license_key"]').value = key;
        }
    </script>
</x-admin-layout>