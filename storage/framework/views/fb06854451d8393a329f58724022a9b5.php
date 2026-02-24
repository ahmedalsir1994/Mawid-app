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
            <h2 class="font-bold text-3xl text-gray-800"><?php echo e(__('app.business_settings')); ?></h2>
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
                            <input type="file" name="logo" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
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
                            <input type="text" name="name" value="<?php echo e(old('name', $business->name)); ?>"
                                placeholder="<?php echo e(__('app.your_business_name')); ?>"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
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
                                <span class="absolute left-4 top-3 text-gray-500">yoursite.com/</span>
                                <input type="text" name="slug" value="<?php echo e(old('slug', $business->slug)); ?>"
                                    placeholder="business-slug"
                                    class="w-full pl-48 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
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
                        </div>
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
                            <select name="country"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="OM" <?php if(old('country', $business->country) === 'OM'): echo 'selected'; endif; ?>>🇴🇲 Oman (OM)
                                </option>
                                <option value="SA" <?php if(old('country', $business->country) === 'SA'): echo 'selected'; endif; ?>>🇸🇦 Saudi
                                    Arabia (SA)</option>
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
                            <select name="default_language"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
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
                            <select name="timezone"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="Asia/Muscat" <?php if(old('timezone', $business->timezone) === 'Asia/Muscat'): echo 'selected'; endif; ?>>Asia/Muscat (GMT+4)</option>
                                <option value="Asia/Riyadh" <?php if(old('timezone', $business->timezone) === 'Asia/Riyadh'): echo 'selected'; endif; ?>>Asia/Riyadh (GMT+3)</option>
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
                            <select name="currency"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="OMR" <?php if(old('currency', $business->currency) === 'OMR'): echo 'selected'; endif; ?>>OMR - Omani
                                    Rial</option>
                                <option value="SAR" <?php if(old('currency', $business->currency) === 'SAR'): echo 'selected'; endif; ?>>SAR - Saudi
                                    Riyal</option>
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
                            <input type="tel" name="phone" value="<?php echo e(old('phone', $business->phone)); ?>"
                                placeholder="+968 XXXX XXXX"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
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
                            <textarea name="address" rows="3" placeholder="<?php echo e(__('app.your_business_address')); ?>"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"><?php echo e(old('address', $business->address)); ?></textarea>
                            <?php $__errorArgs = ['address'];
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

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                        class="px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition">
                        <?php echo e(__('app.cancel')); ?>

                    </a>
                    <button type="submit"
                        class="px-8 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><?php echo e(__('app.save_changes')); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/business/edit.blade.php ENDPATH**/ ?>