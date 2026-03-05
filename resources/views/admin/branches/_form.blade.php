@csrf

<!-- Name -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.branch_name') }} <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $branch->name ?? '') }}"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-500 outline-none transition"
           placeholder="{{ __('app.branch_name_placeholder') }}" required>
    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<!-- Address -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.address') }}</label>
    <input type="text" name="address" value="{{ old('address', $branch->address ?? '') }}"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-500 outline-none transition"
           placeholder="{{ __('app.address_placeholder') }}">
    @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<!-- Phone -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.phone') }}</label>
    <input type="text" name="phone" value="{{ old('phone', $branch->phone ?? '') }}"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-500 outline-none transition"
           placeholder="+968 99999999">
    @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<!-- Active toggle -->
<div class="flex items-center gap-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" id="is_active"
           {{ old('is_active', ($branch->is_active ?? true) ? '1' : '0') == '1' ? 'checked' : '' }}
           class="w-5 h-5 rounded text-purple-600 focus:ring-purple-400">
    <label for="is_active" class="text-sm font-medium text-gray-700">{{ __('app.branch_is_active') }}</label>
</div>
