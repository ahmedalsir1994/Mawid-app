<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
    .cropper-crop-box, .cropper-view-box { border-radius: 0; }
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div>
            <h2 class="font-bold text-xl sm:text-2xl md:text-3xl text-gray-800"><?php echo e(__('app.business_settings')); ?></h2>
            <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.configure_business')); ?></p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">

            <?php if(session('success')): ?>
                <div
                    class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.business.update')); ?>" class="space-y-8"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- Business Info Section -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6"><?php echo e(__('app.business_information')); ?></h3>

                    <div class="space-y-6">
                        <!-- Company Logo -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.company_logo')); ?></label>
                            <?php if($business->logo): ?>
                                <div class="mb-4">
                                    <img src="<?php echo e(asset($business->logo)); ?>" alt="<?php echo e(__('app.current_logo')); ?>"
                                        class="h-24 w-auto rounded-lg shadow-md border border-gray-200">
                                </div>
                            <?php endif; ?>
                            <label for="logoFileInput" class="flex items-center gap-3 cursor-pointer group mt-1">
                                <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg border-2 border-dashed border-gray-300 group-hover:border-green-400 group-hover:bg-green-50 transition-all bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-600 group-hover:text-green-700 transition-colors"><?php echo e($business->logo ? 'Change logo' : 'Upload logo'); ?></span>
                                </div>
                                <span id="logoFileName" class="text-sm text-gray-400 italic truncate max-w-xs">No file chosen</span>
                            </label>
                            <input lang="en" dir="ltr" type="file" name="logo" id="logoFileInput" accept="image/*"
                                class="sr-only" onchange="logoFileSelected(this)" />
                            <p class="text-gray-600 text-xs mt-2"><?php echo e(__('app.upload_logo_hint')); ?></p>
                            <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Business Name -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.business_name')); ?></label>
                            <input lang="en" dir="ltr" type="text" name="name" value="<?php echo e(old('name', $business->name)); ?>"
                                placeholder="<?php echo e(__('app.your_business_name')); ?>"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Slug -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.business_slug')); ?></label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-gray-500">mawid.om/</span>
                                <input lang="en" dir="ltr" type="text" name="slug" id="slugInput" value="<?php echo e(old('slug', $business->slug)); ?>"
                                    placeholder="business-slug"
                                    class="w-full pl-28 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            </div>
                            <p class="text-gray-600 text-xs mt-2"><?php echo e(__('app.slug_hint')); ?></p>
                            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <!-- Public Booking Link -->
                            <div class="mt-3">
                                <p class="text-xs font-semibold text-gray-600 mb-1"><?php echo e(__('app.public_booking_link') ?? 'Public Booking Link'); ?></p>
                                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <span id="publicLinkDisplay" class="flex-1 text-sm text-gray-700 truncate select-all"><?php echo e(url('/')); ?>/<?php echo e(old('slug', $business->slug)); ?></span>
                                    <button type="button" id="copyLinkBtn" onclick="copyBookingLink()"
                                        class="shrink-0 flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 transition">
                                        <svg id="copyIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span id="copyBtnText">Copy</span>
                                    </button>
                                    <a id="openLinkBtn" href="<?php echo e(url('/')); ?>/<?php echo e(old('slug', $business->slug)); ?>" target="_blank"
                                        class="shrink-0 flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Open
                                    </a>
                                </div>
                            </div>
                        </div>

                        <script>
                            (function () {
                                const base = '<?php echo e(url('/')); ?>/';
                                const slugInput = document.getElementById('slugInput');
                                const display = document.getElementById('publicLinkDisplay');
                                const openBtn = document.getElementById('openLinkBtn');

                                slugInput.addEventListener('input', function () {
                                    const full = base + this.value;
                                    display.textContent = full;
                                    openBtn.href = full;
                                });

                                window.copyBookingLink = function () {
                                    const text = document.getElementById('publicLinkDisplay').textContent;
                                    navigator.clipboard.writeText(text).then(() => {
                                        const btn = document.getElementById('copyBtnText');
                                        const icon = document.getElementById('copyIcon');
                                        btn.textContent = 'Copied!';
                                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
                                        setTimeout(() => {
                                            btn.textContent = 'Copy';
                                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>';
                                        }, 2000);
                                    });
                                };
                            })();
                        </script>
                    </div>
                </div>

                <!-- Location & Preferences Section -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6"><?php echo e(__('app.location_preferences')); ?></h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Country -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.country')); ?></label>
                            <select lang="en" dir="ltr" name="country"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <?php $__currentLoopData = config('countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $cname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php if(old('country', $business->country) === $code): echo 'selected'; endif; ?>>
                                        <?php echo e($cname); ?> (<?php echo e($code); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Default Language -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.default_language')); ?></label>
                            <select lang="en" dir="ltr" name="default_language"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="en" <?php if(old('default_language', $business->default_language) === 'en'): echo 'selected'; endif; ?>>English</option>
                                <option value="ar" <?php if(old('default_language', $business->default_language) === 'ar'): echo 'selected'; endif; ?>>العربية</option>
                            </select>
                            <?php $__errorArgs = ['default_language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Timezone -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.timezone')); ?></label>
                            <select lang="en" dir="ltr" name="timezone"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <?php $__currentLoopData = \DateTimeZone::listIdentifiers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tz); ?>" <?php if(old('timezone', $business->timezone) === $tz): echo 'selected'; endif; ?>>
                                        <?php echo e($tz); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Currency -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.currency')); ?></label>
                            <select lang="en" dir="ltr" name="currency"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="OMR" <?php if(old('currency', $business->currency) === 'OMR'): echo 'selected'; endif; ?>>OMR - Omani
                                    Rial</option>
                                
                            </select>
                            <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6"><?php echo e(__('app.contact_information')); ?></h3>

                    <div class="space-y-6">
                        <!-- Phone -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.phone_number')); ?></label>
                            <input lang="en" dir="ltr" type="tel" name="phone" value="<?php echo e(old('phone', $business->phone)); ?>"
                                placeholder="+968 XXXX XXXX"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Address -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.address')); ?></label>
                            <textarea lang="en" dir="ltr" name="address" rows="3"
                                placeholder="Copy your address from Google Maps (e.g. 123 Main St, Muscat, Oman)"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"><?php echo e(old('address', $business->address)); ?></textarea>
                            <p class="text-gray-500 text-xs mt-1.5">💡 Open Google Maps → find your business → copy the address and paste it here.</p>
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- How Heard About Us -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">How did you hear about us?</label>
                            <select lang="en" dir="ltr" name="how_heard_about_us"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">— Not specified —</option>
                                <?php $__currentLoopData = [
                                    'google_search'  => 'Google Search',
                                    'facebook'       => 'Facebook',
                                    'instagram'      => 'Instagram',
                                    'referral'       => 'Friend or Referral',
                                    'youtube'        => 'YouTube',
                                    'advertisement'  => 'Advertisement',
                                    'event'          => 'Event or Conference',
                                    'other'          => 'Other',
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php if(old('how_heard_about_us', $business->how_heard_about_us) === $val): echo 'selected'; endif; ?>>
                                        <?php echo e($lbl); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['how_heard_about_us'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images Section -->
                <?php
                    $gallery = $business->gallery_images ?? [null, null, null];
                    while (count($gallery) < 3) $gallery[] = null;
                    // Normalise entries stored as {"path":"...","position":"..."} objects
                    $gallery = array_map(fn($p) => is_array($p) ? ($p['path'] ?? null) : $p, $gallery);
                ?>
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Gallery Images</h3>
                    <p class="text-sm text-gray-500 mb-1">Upload 3 photos to showcase your business on your public booking page.</p>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mb-4">
                        <span class="inline-flex items-center gap-1.5 text-xs text-blue-700 bg-blue-50 border border-blue-200 rounded-full px-3 py-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Recommended: <strong>800 × 800 px</strong> (1:1 ratio)
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-xs text-gray-600 bg-gray-100 border border-gray-200 rounded-full px-3 py-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            JPG · PNG · WebP &nbsp;·&nbsp; Max 2 MB each
                        </span>
                       
                    </div>

                    <?php $__errorArgs = ['gallery'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span><?php echo e($message); ?></span>
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div id="galleryError" class="hidden mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span id="galleryErrorMsg">Please upload all 3 gallery photos before saving.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <?php $__currentLoopData = [1, 2, 3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $img = $gallery[$slot - 1] ?? null; ?>
                            <div>
                                <p class="text-xs font-semibold text-gray-600 mb-2">Photo <?php echo e($slot); ?></p>

                                
                                <div id="galleryCard<?php echo e($slot); ?>"
                                     class="relative w-full h-40 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 bg-gray-50 cursor-pointer transition-colors hover:border-green-400 hover:bg-green-50"
                                     onclick="document.getElementById('galleryInput<?php echo e($slot); ?>').click()"
                                     ondragover="event.preventDefault(); this.classList.add('!border-green-500','!bg-green-100')"
                                     ondragleave="this.classList.remove('!border-green-500','!bg-green-100')"
                                     ondrop="galleryDrop(event, <?php echo e($slot); ?>)">

                                    
                                    <div id="galleryEmpty<?php echo e($slot); ?>" class="absolute inset-0 flex flex-col items-center justify-center gap-1 pointer-events-none <?php echo e($img ? 'hidden' : ''); ?>">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <span class="text-xs text-gray-500 font-medium">Click or drag photo</span>
                                        <span class="text-[11px] text-gray-400">JPG · PNG · WebP · max 2 MB</span>
                                    </div>

                                    
                                    <img id="galleryPreview<?php echo e($slot); ?>"
                                         src="<?php echo e($img ? asset($img) : ''); ?>"
                                         alt="Photo <?php echo e($slot); ?>"
                                         class="absolute inset-0 w-full h-full object-cover <?php echo e($img ? '' : 'hidden'); ?>">

                                    
                                    <button type="button" id="galleryRemoveBtn<?php echo e($slot); ?>"
                                        class="absolute top-2 right-2 w-7 h-7 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow transition <?php echo e($img ? '' : 'hidden'); ?>"
                                        onclick="event.stopPropagation(); galleryRemove(<?php echo e($slot); ?>, '<?php echo e(route('admin.business.gallery.remove', $slot)); ?>', <?php echo e($img ? 'true' : 'false'); ?>)"
                                        title="Remove">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                
                                <p id="galleryName<?php echo e($slot); ?>" class="hidden mt-1.5 text-xs text-gray-500 truncate px-0.5"></p>

                                <input type="file" id="galleryInput<?php echo e($slot); ?>" name="gallery_image_<?php echo e($slot); ?>"
                                       accept="image/jpeg,image/jpg,image/png,image/webp"
                                       class="hidden" onchange="galleryPick(<?php echo e($slot); ?>, this)">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Services & Images Section -->
                <?php
                    $bizServices = \App\Models\Service::where('business_id', $business->id)
                        ->with('images')
                        ->orderBy('name')->get();
                ?>
                <?php if($bizServices->isNotEmpty()): ?>
                <div class="border-b border-gray-200 pb-8">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-lg font-bold text-gray-800">Services &amp; Photos</h3>
                        <a href="<?php echo e(route('admin.services.index')); ?>" class="text-xs font-semibold text-green-700 hover:underline">Manage services →</a>
                    </div>
                    <p class="text-sm text-gray-500 mb-5">Each service displays its own photos on the public page. Click a service to add or change its photos.</p>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $bizServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $svcImages = $svc->images;
                                $firstImg  = $svcImages->first();
                            ?>
                            <div class="flex items-center gap-4 p-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white transition">
                                
                                <div class="shrink-0 w-16 h-16 rounded-lg overflow-hidden border border-gray-200 bg-white">
                                    <?php if($firstImg): ?>
                                        <img src="<?php echo e(asset($firstImg->path)); ?>" alt="<?php echo e($svc->name); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate"><?php echo e($svc->name); ?></p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        <?php echo e($svcImages->count()); ?> photo<?php echo e($svcImages->count() !== 1 ? 's' : ''); ?>

                                        &middot; <?php echo e($svc->duration_minutes); ?> min
                                        <?php if($svc->price !== null): ?> &middot; <?php echo e(number_format($svc->price, 2)); ?> <?php echo e($business->currency); ?> <?php endif; ?>
                                    </p>
                                    
                                    <?php if($svcImages->count() > 1): ?>
                                        <div class="mt-2 flex gap-1.5">
                                            <?php $__currentLoopData = $svcImages->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <img src="<?php echo e(asset($si->path)); ?>" class="w-8 h-8 rounded object-cover border border-gray-100">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($svcImages->count() > 5): ?>
                                                <div class="w-8 h-8 rounded bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                                    +<?php echo e($svcImages->count() - 5); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <a href="<?php echo e(route('admin.services.edit', $svc)); ?>"
                                   class="shrink-0 px-3 py-1.5 rounded-lg border border-gray-300 text-xs font-semibold text-gray-700 hover:bg-gray-100 transition">
                                    Edit photos
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                        class="px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition">
                        <?php echo e(__('app.cancel')); ?>

                    </a>
                    <button type="submit"
                        class="px-8 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-600 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><?php echo e(__('app.save_changes')); ?></span>
                    </button>
                </div>
            </form>

            <script>
            /* ───────────────────────────────────────────────────
             * Crop Modal state
             * ─────────────────────────────────────────────────── */
            let cropperInstance = null;
            let activeCropSlot  = null;
            let activeCropInput = null;

            /* ── Gallery: pick file → open crop modal ── */
            function galleryPick(slot, input) {
                if (!input.files || !input.files[0]) return;
                const file = input.files[0];

                if (file.size > 2 * 1024 * 1024) {
                    alert('Photo ' + slot + ' exceeds the 2 MB size limit. Please choose a smaller image.');
                    input.value = '';
                    return;
                }

                activeCropSlot  = slot;
                activeCropInput = input;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('cropperImage');
                    img.src = e.target.result;
                    document.getElementById('cropModal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';

                    // Small delay so the image is fully rendered before Cropper initialises
                    setTimeout(function () {
                        if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }
                        cropperInstance = new Cropper(img, {
                            aspectRatio:  1,
                            viewMode:     1,
                            autoCropArea: 0.85,
                            movable:      true,
                            zoomable:     true,
                            rotatable:    false,
                            scalable:     false,
                            background:   false,
                        });
                    }, 80);
                };
                reader.readAsDataURL(file);
            }

            /* ── Apply cropped canvas → inject File back into input ── */
            function applyCrop() {
                if (!cropperInstance || !activeCropInput) return;

                const applyBtn = document.getElementById('cropApplyBtn');
                applyBtn.disabled = true;
                applyBtn.textContent = 'Processing…';

                cropperInstance.getCroppedCanvas({ width: 800, height: 800 }).toBlob(function (blob) {
                    const slot  = activeCropSlot;
                    const file  = new File([blob], 'gallery_photo_' + slot + '.jpg', { type: 'image/jpeg' });

                    // Inject into the real file input via DataTransfer
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    activeCropInput.files = dt.files;

                    // Update preview
                    const preview   = document.getElementById('galleryPreview'   + slot);
                    const empty     = document.getElementById('galleryEmpty'     + slot);
                    const removeBtn = document.getElementById('galleryRemoveBtn' + slot);
                    const nameEl    = document.getElementById('galleryName'      + slot);

                    const objURL = URL.createObjectURL(blob);
                    preview.src = objURL;
                    preview.classList.remove('hidden');
                    empty.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                    if (nameEl) { nameEl.textContent = file.name; nameEl.classList.remove('hidden'); }

                    closeCropModal();
                    checkGalleryError();
                }, 'image/jpeg', 0.92);
            }

            /* ── Cancel crop ── */
            function cancelCrop() {
                if (activeCropInput) activeCropInput.value = '';
                closeCropModal();
            }

            function closeCropModal() {
                document.getElementById('cropModal').classList.add('hidden');
                document.body.style.overflow = '';
                if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }
                activeCropSlot  = null;
                activeCropInput = null;
                const applyBtn = document.getElementById('cropApplyBtn');
                if (applyBtn) { applyBtn.disabled = false; applyBtn.textContent = 'Apply Crop'; }
            }

            /* ── Gallery: remove a slot (saved = AJAX, unsaved = local reset) ── */
            function galleryRemove(slot, url, isSaved) {
                if (isSaved) {
                    if (!confirm('Remove this photo?')) return;
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(r) { return r.json(); })
                    .then(function(data) { if (data.ok) galleryReset(slot); })
                    .catch(function() { alert('Could not remove the photo. Please try again.'); });
                } else {
                    galleryReset(slot);
                }
            }

            function galleryReset(slot) {
                const preview   = document.getElementById('galleryPreview'   + slot);
                const empty     = document.getElementById('galleryEmpty'     + slot);
                const removeBtn = document.getElementById('galleryRemoveBtn' + slot);
                const nameEl    = document.getElementById('galleryName'      + slot);
                const inputEl   = document.getElementById('galleryInput'     + slot);
                preview.classList.add('hidden');
                preview.src = '';
                empty.classList.remove('hidden');
                removeBtn.classList.add('hidden');
                if (nameEl)  { nameEl.classList.add('hidden'); nameEl.textContent = ''; }
                if (inputEl) inputEl.value = '';
            }

            /* ── Gallery: drag-and-drop ── */
            function galleryDrop(event, slot) {
                event.preventDefault();
                const card = document.getElementById('galleryCard' + slot);
                if (card) card.classList.remove('!border-green-500', '!bg-green-100');
                const input = document.getElementById('galleryInput' + slot);
                if (event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files[0]) {
                    const dt = new DataTransfer();
                    dt.items.add(event.dataTransfer.files[0]);
                    input.files = dt.files;
                    galleryPick(slot, input);
                }
            }

            /* ── Gallery: show/hide error banner ── */
            function checkGalleryError() {
                var allFilled = [1, 2, 3].every(function(s) {
                    var p = document.getElementById('galleryPreview' + s);
                    return p && !p.classList.contains('hidden') && p.src && p.src !== window.location.href;
                });
                if (allFilled) {
                    var err = document.getElementById('galleryError');
                    if (err) err.classList.add('hidden');
                }
            }

            /* ── Logo file-picker display ── */
            function logoFileSelected(input) {
                var nameEl = document.getElementById('logoFileName');
                if (nameEl && input.files && input.files[0]) {
                    nameEl.textContent = input.files[0].name;
                    nameEl.classList.remove('text-gray-400', 'italic');
                    nameEl.classList.add('text-green-700', 'font-medium');
                }
            }

            /* ── Form submit: validate all 3 gallery slots filled ── */
            (function () {
                var form = document.querySelector('form[action="<?php echo e(route('admin.business.update')); ?>"]');
                if (!form) return;
                form.addEventListener('submit', function(e) {
                    var emptySlots = [1, 2, 3].filter(function(s) {
                        var p = document.getElementById('galleryPreview' + s);
                        return !p || p.classList.contains('hidden') || !p.src || p.src === window.location.href;
                    });
                    if (emptySlots.length > 0) {
                        e.preventDefault();
                        var err = document.getElementById('galleryError');
                        var msg = document.getElementById('galleryErrorMsg');
                        if (err && msg) {
                            msg.textContent = 'Please upload a photo for slot ' + emptySlots.join(', ') + ' before saving.';
                            err.classList.remove('hidden');
                            err.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
            })();
            </script>
        </div>
    </div>

    
    <div id="cropModal" class="hidden fixed inset-0 z-[60] bg-black/75 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col overflow-hidden">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-lg text-gray-900">Crop Photo</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Drag to reposition · Scroll to zoom · 1:1 ratio locked</p>
                </div>
                <button type="button" onclick="cancelCrop()"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            
            <div class="bg-gray-900 flex items-center justify-center" style="height: 350px; max-height: 55vh;">
                <img id="cropperImage" src="" alt="Crop preview"
                    style="max-width: 100%; max-height: 100%; display: block;">
            </div>

            
            <div class="px-6 pt-3 pb-0">
                <p class="text-xs text-gray-400 text-center">
                    The cropped image will be saved as an 800 × 800 px JPEG square.
                </p>
            </div>

            
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 mt-2">
                <button type="button" onclick="cancelCrop()"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button id="cropApplyBtn" type="button" onclick="applyCrop()"
                    class="px-6 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                    Apply Crop
                </button>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\Mawid-app\resources\views/admin/business/edit.blade.php ENDPATH**/ ?>