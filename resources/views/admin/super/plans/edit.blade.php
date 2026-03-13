<x-admin-layout>
    <!-- Header -->
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.super.plans.index') }}" class="hover:text-green-600">Plans</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">Edit {{ $plan->name }}</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900">{{ $plan->emoji }} Edit Plan: {{ $plan->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">Slug: <code class="bg-gray-100 px-1 rounded">{{ $plan->slug }}</code> — used in license assignments</p>
    </div>

    <div class="max-w-3xl bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm">
        <form method="POST" action="{{ route('admin.super.plans.update', $plan) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Identity -->
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Emoji *</label>
                    <input type="text" name="emoji" value="{{ old('emoji', $plan->emoji) }}" required maxlength="10"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-lg text-center">
                    @error('emoji')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug * <span class="text-gray-400 font-normal text-xs">(unique, lowercase)</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $plan->slug) }}" required maxlength="20"
                        pattern="[a-z0-9_-]+"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition">
                    @error('slug')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $plan->name) }}" required maxlength="50"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $plan->tagline) }}" maxlength="200"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition">
            </div>

            <!-- Pricing -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3 border-b border-gray-100 pb-2">Pricing (OMR)</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Monthly Price *</label>
                        <input type="number" name="price_monthly" value="{{ old('price_monthly', $plan->price_monthly) }}"
                            required min="0" step="0.001"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('price_monthly')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Yearly Price * <span class="text-gray-400">(total)</span></label>
                        <input type="number" name="price_yearly" value="{{ old('price_yearly', $plan->price_yearly) }}"
                            required min="0" step="0.001"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('price_yearly')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Display Monthly</label>
                        <input type="number" name="price_monthly_display" value="{{ old('price_monthly_display', $plan->price_monthly_display) }}"
                            min="0" step="0.001"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Display Yearly per-mo</label>
                        <input type="number" name="price_yearly_display" value="{{ old('price_yearly_display', $plan->price_yearly_display) }}"
                            min="0" step="0.001"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Old Monthly Price</label>
                        <input type="number" name="old_price_monthly" value="{{ old('old_price_monthly', $plan->old_price_monthly) }}"
                            min="0" step="0.001"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Old Yearly Price</label>
                        <input type="number" name="old_price_yearly" value="{{ old('old_price_yearly', $plan->old_price_yearly) }}"
                            min="0" step="0.001"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Monthly Discount %</label>
                        <input type="number" name="discount_monthly" value="{{ old('discount_monthly', $plan->discount_monthly) }}"
                            min="0" max="100"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Yearly Discount %</label>
                        <input type="number" name="discount_yearly" value="{{ old('discount_yearly', $plan->discount_yearly) }}"
                            min="0" max="100"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                </div>
            </div>

            <!-- Limits -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3 border-b border-gray-100 pb-2">Limits <span class="text-gray-400 font-normal">(0 = unlimited)</span></p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Branches *</label>
                        <input type="number" name="max_branches" value="{{ old('max_branches', $plan->max_branches) }}"
                            required min="1"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_branches')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Staff *</label>
                        <input type="number" name="max_staff" value="{{ old('max_staff', $plan->max_staff) }}"
                            required min="1"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_staff')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Services * <span class="text-gray-400">(0=∞)</span></label>
                        <input type="number" name="max_services" value="{{ old('max_services', $plan->max_services) }}"
                            required min="0"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_services')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Daily Bookings * <span class="text-gray-400">(0=∞)</span></label>
                        <input type="number" name="max_daily_bookings" value="{{ old('max_daily_bookings', $plan->max_daily_bookings) }}"
                            required min="0"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        @error('max_daily_bookings')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Monthly Bookings <span class="text-gray-400">(0=∞)</span></label>
                        <input type="number" name="max_monthly_bookings" value="{{ old('max_monthly_bookings', $plan->max_monthly_bookings) }}"
                            min="0"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $plan->sort_order) }}"
                            min="0"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                </div>
            </div>

            <!-- Features & Status -->
            <div class="flex flex-wrap items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="whatsapp_reminders" value="1"
                        @checked(old('whatsapp_reminders', $plan->whatsapp_reminders))
                        class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="text-sm text-gray-700">WhatsApp Reminders</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                        @checked(old('is_active', $plan->is_active))
                        class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="text-sm text-gray-700">Active (visible to users)</span>
                </label>
            </div>

            <!-- Landing Page Card -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3 border-b border-gray-100 pb-2">Landing Page Card</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Feature Bullets <span class="text-gray-400 font-normal text-xs">(one per line)</span></label>
                        <textarea name="features_text" rows="5"
                            placeholder="Everything in Free&#10;Up to 15 Services&#10;WhatsApp Reminders"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm font-mono">{{ old('features_text', implode("\n", $plan->features ?? [])) }}</textarea>
                        <p class="mt-1 text-xs text-gray-400">These appear as ✓ bullet points on the pricing card.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">CTA Button Label</label>
                            <input type="text" name="cta_label" value="{{ old('cta_label', $plan->cta_label) }}" maxlength="100"
                                placeholder="e.g. Start Pro →"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Accent Color</label>
                            <select name="accent_color"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                                <option value="gray" @selected(old('accent_color', $plan->accent_color) === 'gray')>⬜ Gray (default / free)</option>
                                <option value="blue" @selected(old('accent_color', $plan->accent_color) === 'blue')>🔵 Blue (featured)</option>
                                <option value="green" @selected(old('accent_color', $plan->accent_color) === 'green')>🟢 Green</option>
                                <option value="purple" @selected(old('accent_color', $plan->accent_color) === 'purple')>🟣 Purple</option>
                                <option value="orange" @selected(old('accent_color', $plan->accent_color) === 'orange')>🟠 Orange</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1"
                                @checked(old('is_featured', $plan->is_featured))
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Featured card <span class="text-gray-400">(highlighted border + badge)</span></span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Featured Badge Label <span class="text-gray-400">(shown when card is featured)</span></label>
                        <input type="text" name="featured_label" value="{{ old('featured_label', $plan->featured_label) }}" maxlength="50"
                            placeholder="Most Popular"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition text-sm">
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-2">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:shadow-lg transition">
                    Save Changes
                </button>
                <a href="{{ route('admin.super.plans.index') }}"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
