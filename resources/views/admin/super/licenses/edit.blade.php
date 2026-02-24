<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">{{ __('app.edit_license') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('app.update_license_details') }}</p>
    </div>

    <!-- Edit Form -->
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.super.licenses.update', $license) }}"
            class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            @csrf
            @method('PUT')

            <!-- Business Info (Read-only) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.business') }}</label>
                <p class="text-lg font-semibold text-gray-900">{{ $license->business->name }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ __('app.license_id') }}: {{ $license->id }}</p>
            </div>

            <!-- License Key (Read-only) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.license_key') }}</label>
                <div class="flex items-center gap-2">
                    <input type="text" value="{{ $license->license_key }}" disabled
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-900 font-mono">
                    <button type="button" onclick="copyToClipboard('{{ $license->license_key }}')"
                        class="px-4 py-3 bg-blue-100 text-blue-700 font-medium rounded-lg hover:bg-blue-200 transition">
                        {{ __('app.copy') }}
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.status') }} *</label>
                    <select name="status" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="active" @selected(old('status', $license->status) === 'active')>
                            {{ __('app.active') }}</option>
                        <option value="expired" @selected(old('status', $license->status) === 'expired')>
                            {{ __('app.expired') }}</option>
                        <option value="suspended" @selected(old('status', $license->status) === 'suspended')>
                            {{ __('app.suspended') }}
                        </option>
                        <option value="cancelled" @selected(old('status', $license->status) === 'cancelled')>
                            {{ __('app.cancelled') }}
                        </option>
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
                        <option value="unpaid" @selected(old('payment_status', $license->payment_status) === 'unpaid')>
                            {{ __('app.unpaid') }}
                        </option>
                        <option value="paid" @selected(old('payment_status', $license->payment_status) === 'paid')>
                            {{ __('app.paid') }}
                        </option>
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
                        placeholder="5" value="{{ old('max_users', $license->max_users) }}">
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
                        placeholder="100" value="{{ old('max_daily_bookings', $license->max_daily_bookings) }}">
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
                        value="{{ old('expires_at', $license->expires_at->format('Y-m-d')) }}">
                    @error('expires_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.price_usd') }} *</label>
                    <input type="number" name="price" required min="0" step="0.01"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="99.99" value="{{ old('price', $license->price) }}">
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
                    placeholder="{{ __('app.add_notes_license') }}">{{ old('notes', $license->notes) }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- License Info -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">{{ __('app.activated') }}</p>
                        <p class="font-semibold text-gray-900">{{ $license->activated_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">{{ __('app.expires') }}</p>
                        <p class="font-semibold text-gray-900">{{ $license->expires_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">{{ __('app.days_remaining') }}</p>
                        <p class="font-semibold text-gray-900">{{ now()->diffInDays($license->expires_at, false) }}</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                @if(!$license->isActive())
                    <form method="POST" action="{{ route('admin.super.licenses.reactivate', $license) }}" style="flex: 1;">
                        @csrf
                        <button type="submit" onclick="return confirm('{{ __('app.reactivate_license_confirm') }}')"
                            class="w-full px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                            ✓ {{ __('app.reactivate_license') }}
                        </button>
                    </form>
                @endif

                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                    {{ __('app.save_changes') }}
                </button>
                <a href="{{ route('admin.super.licenses.show', $license) }}"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                    {{ __('app.cancel') }}
                </a>
            </div>
        </form>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('{{ __('app.license_key_copied') }}');
            });
        }
    </script>
</x-admin-layout>