<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.branches.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition shrink-0">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-xl sm:text-2xl md:text-3xl text-gray-800">{{ __('app.add_branch') }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ __('app.add_branch_desc') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-xl">
        @if(!$canAdd)
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 text-center">
                <p class="text-purple-800 font-semibold mb-1">{{ __('app.branch_limit_reached') }}</p>
                <p class="text-sm text-gray-600 mb-4">{{ __('app.upgrade_for_more_branches') }}</p>
                <a href="{{ route('admin.upgrade.index') }}" class="inline-block mt-1 px-5 py-2 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
                    🚀 {{ __('app.upgrade_plan') }}
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
                <form method="POST" action="{{ route('admin.branches.store') }}" class="space-y-6">
                    @csrf
                    @include('admin.branches._form')
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-purple-500 text-white font-semibold hover:shadow-lg transition">
                            {{ __('app.create_branch') }}
                        </button>
                        <a href="{{ route('admin.branches.index') }}"
                           class="flex-1 py-3 rounded-lg bg-gray-100 text-gray-700 font-semibold text-center hover:bg-gray-200 transition">
                            {{ __('app.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-admin-layout>
