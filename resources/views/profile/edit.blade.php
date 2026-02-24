<x-user-layout>
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('app.back_to_dashboard') }}
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('app.profile_settings') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('app.manage_account_preferences') }}</p>
    </div>

    <!-- Settings Sections -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Profile Information Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">{{ __('app.personal_information') }}</h2>
                <p class="text-gray-600 text-sm mt-1">{{ __('app.update_profile_details') }}</p>
            </div>

            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">{{ __('app.change_password') }}</h2>
                <p class="text-gray-600 text-sm mt-1">{{ __('app.update_password_secure') }}</p>
            </div>

            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white rounded-xl shadow-md border border-red-100 p-8">
            <div class="mb-6 pb-6 border-b border-red-200">
                <h2 class="text-2xl font-bold text-red-900">{{ __('app.danger_zone') }}</h2>
                <p class="text-red-700 text-sm mt-1">{{ __('app.irreversible_actions') }}</p>
            </div>

            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-user-layout>