<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">{{ __('app.service_categories') }}</h2>
        <a href="{{ route('admin.service_categories.create') }}" class="mt-2 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">{{ __('app.add_category') }}</a>
    </x-slot>
    <div class="max-w-xl mt-6">
        @foreach($categories as $category)
            <div class="flex items-center justify-between bg-white rounded shadow p-4 mb-2">
                <span>{{ $category->name }}</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.service_categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">{{ __('app.edit_category') ?? 'Edit' }}</a>
                    <form method="POST" action="{{ route('admin.service_categories.destroy', $category) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:text-red-800">{{ __('app.delete_category') }}</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-admin-layout>
