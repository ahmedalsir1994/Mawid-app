<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.branches.show', $branch) }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl text-gray-800">{{ __('app.edit_branch') }}: {{ $branch->name }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ __('app.edit_branch_desc') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.branches.update', $branch) }}" class="space-y-6">
                @method('PUT')
                @include('admin.branches._form', ['branch' => $branch])
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-purple-500 text-white font-semibold hover:shadow-lg transition">
                        {{ __('app.save_changes') }}
                    </button>
                    <a href="{{ route('admin.branches.show', $branch) }}"
                       class="flex-1 py-3 rounded-lg bg-gray-100 text-gray-700 font-semibold text-center hover:bg-gray-200 transition">
                        {{ __('app.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
