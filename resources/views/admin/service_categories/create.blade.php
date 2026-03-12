<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Add Service Category</h2>
    </x-slot>
    <div class="max-w-xl mt-6">
        <form method="POST" action="{{ route('admin.service_categories.store') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('app.category_name') }}</label>
                <input type="text" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required maxlength="120">
            </div>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">{{ __('app.create_category') }}</button>
        </form>
    </div>
</x-admin-layout>
