@csrf

<div class="space-y-6">
    <!-- Service Name -->
    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.service_name') }}</label>
        <input type="text" name="name" value="{{ old('name', $service->name ?? '') }}" 
            placeholder="{{ __('app.service_placeholder') }}"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        @error('name') 
            <p class="text-red-600 text-sm mt-2 flex items-center space-x-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $message }}</span>
            </p>
        @enderror
    </div>

    <!-- Service Image -->
    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.service_image') }}</label>
        @if($service && $service->image)
            <div class="mb-4">
                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="h-32 w-auto rounded-lg shadow-md border border-gray-200">
            </div>
        @endif
        <input type="file" name="image" accept="image/*"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
        <p class="text-gray-600 text-xs mt-2">{{ __('app.upload_service_image_hint') }}</p>
        @error('image') 
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Service Description -->
    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.description_optional') }}</label>
        <textarea name="description" rows="3" 
            placeholder="{{ __('app.brief_description') }}"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $service->description ?? '') }}</textarea>
        @error('description') 
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Duration and Price Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Duration -->
        <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.duration_minutes') }}</label>
            <div class="relative">
                <input type="number" name="duration_minutes"
                    value="{{ old('duration_minutes', $service->duration_minutes ?? 30) }}"
                    min="5" step="5"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                <span class="absolute right-4 top-3 text-gray-500">{{ __('app.min') }}</span>
            </div>
            @error('duration_minutes') 
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.price_optional') }}</label>
            <div class="relative">
                <span class="absolute left-4 top-3 text-gray-500">$</span>
                <input type="number" step="0.01" name="price" 
                    value="{{ old('price', $service->price ?? '') }}"
                    placeholder="0.00"
                    class="w-full pl-8 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
            </div>
            @error('price') 
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Active Status -->
    <div class="border-t border-gray-200 pt-6">
        <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
            <input type="checkbox" name="is_active" id="is_active" 
                @checked(old('is_active', $service->is_active ?? true))
                class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500 cursor-pointer" />
            <label for="is_active" class="flex-1 cursor-pointer">
                <p class="font-medium text-gray-800">{{ __('app.service_is_active') }}</p>
                <p class="text-sm text-gray-600">{{ __('app.customers_can_book') }}</p>
            </label>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="border-t border-gray-200 pt-6 flex items-center justify-between">
        <a href="{{ route('admin.services.index') }}" 
            class="px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition">
            {{ __('app.cancel') }}
        </a>
        <button type="submit" class="px-8 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            <span>{{ __('app.save_service') }}</span>
        </button>
    </div>
</div>