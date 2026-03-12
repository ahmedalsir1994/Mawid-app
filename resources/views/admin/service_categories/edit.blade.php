<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Edit Category</h2>
    </x-slot>
    <div class="max-w-xl mt-6">
        <form method="POST" action="{{ route('admin.service_categories.update', $category->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-800 mb-2">Category Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            @error('name')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">Update Category</button>
        <a href="{{ route('admin.service_categories.index') }}" class="ml-4 text-sm text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
</x-admin-layout>
