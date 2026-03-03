<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.services.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl text-gray-800">{{ __('app.create_service') }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ __('app.add_new_service') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        @if(isset($canAdd) && !$canAdd)
            <x-upgrade-modal :license="$license" :plan="$plan" limitType="services" />
        @else
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-6"
                enctype="multipart/form-data">
                @include('admin.services._form', ['service' => null])
            </form>
        </div>
        @endif
    </div>
</x-admin-layout>