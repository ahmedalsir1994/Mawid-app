<x-admin-layout>
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.staff.index') }}"
                class="text-gray-600 hover:text-gray-900 transition">
                ← {{ __('app.back_to_staff') }}
            </a>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mt-4">{{ __('app.edit_staff_member') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('app.update_staff_information', ['name' => $staff->name]) }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.staff.update', $staff) }}" class="space-y-6"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.full_name') }} <span class="text-red-500">*</span>
                </label>
                <input lang="en" dir="ltr" type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.email_address') }} <span class="text-red-500">*</span>
                </label>
                <input lang="en" dir="ltr" type="email" name="email" id="email" value="{{ old('email', $staff->email) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.new_password_leave_blank') }}
                </label>
                <input lang="en" dir="ltr" type="password" name="password" id="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">{{ __('app.minimum_8_if_changing') }}</p>
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.confirm_new_password') }}
                </label>
                <input lang="en" dir="ltr" type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center">
                    <input lang="en" dir="ltr" type="checkbox" name="is_active" value="1" 
                        {{ old('is_active', $staff->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">{{ __('app.active_staff_can_login') }}</span>
                </label>
            </div>

            <!-- Title / Role Label -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title <span class="text-gray-400 font-normal">(optional)</span></label>
                <input lang="en" dir="ltr" type="text" name="title" id="title" value="{{ old('title', $staff->title) }}"
                    placeholder="e.g. Barber, Stylist, Therapist"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            @if(isset($branches) && $branches->isNotEmpty())
            <!-- Branch Assignment -->
            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('app.branch') }} <span class="text-gray-400 font-normal">({{ __('app.optional') ?? 'optional' }})</span>
                </label>
                <select name="branch_id" id="branch_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                    <option value="">— {{ __('app.no_branch_assigned') ?? 'No specific branch' }} —</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id', $staff->branch_id) == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}{{ $branch->address ? ' · ' . $branch->address : '' }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">{{ __('app.branch_assignment_hint') ?? 'Assign this staff member to a specific branch location.' }}</p>
                @error('branch_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            @endif

            <!-- Photo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo <span class="text-gray-400 font-normal">(optional)</span></label>
                @if($staff->photo)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset($staff->photo) }}" class="w-16 h-16 rounded-full object-cover border-2 border-green-500">
                        <span class="text-sm text-gray-500">Current photo — upload a new one to replace it</span>
                    </div>
                @endif
                <label for="photoInput" class="flex flex-col items-center justify-center w-full h-28 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 cursor-pointer transition">
                    <svg class="w-8 h-8 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-600">Click to upload new photo</span>
                    <span class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP &middot; max 3 MB</span>
                </label>
                <input lang="en" dir="ltr" id="photoInput" type="file" name="photo" accept="image/jpeg,image/jpg,image/png,image/webp"
                    class="sr-only" onchange="previewStaffPhoto(this)">
                <div id="photoPreview" class="mt-3 hidden">
                    <img id="photoPreviewImg" src="" class="w-20 h-20 rounded-full object-cover border-2 border-green-500">
                </div>
                @error('photo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    {{ __('app.update_staff_member') }}
                </button>
                <a href="{{ route('admin.staff.show', $staff) }}"
                    class="text-gray-600 hover:text-gray-900 font-medium px-6 py-3 rounded-lg transition">
                    {{ __('app.cancel') }}
                </a>
            </div>
        </form>
    </div>

    <script>
    function previewStaffPhoto(input) {
        const preview = document.getElementById('photoPreview');
        const img = document.getElementById('photoPreviewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; preview.classList.remove('hidden'); };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</x-admin-layout>
