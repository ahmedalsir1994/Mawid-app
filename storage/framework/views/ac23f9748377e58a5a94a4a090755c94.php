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
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900"><?php echo e(__('app.edit_business')); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e(__('app.update_business_details', ['name' => $business->name])); ?></p>
            </div>
            <a href="<?php echo e(route('admin.super.businesses.index')); ?>"
                class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                <?php echo e(__('app.back')); ?>

            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
        <form action="<?php echo e(route('admin.super.businesses.update', $business)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Business Name -->
                <div>
                    <label for="name"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.business_name_required')); ?></label>
                    <input lang="en" dir="ltr" type="text" name="name" id="name" value="<?php echo e(old('name', $business->name)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.slug_required')); ?></label>
                    <input lang="en" dir="ltr" type="text" name="slug" id="slug" value="<?php echo e(old('slug', $business->slug)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.address_required')); ?></label>
                    <input lang="en" dir="ltr" type="text" name="address" id="address" value="<?php echo e(old('address', $business->address)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Country -->
                <div>
                    <label for="country"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.country_required')); ?></label>
                    <input lang="en" dir="ltr" type="text" name="country" id="country" value="<?php echo e(old('country', $business->country)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.phone_required')); ?></label>
                    <input lang="en" dir="ltr" type="tel" name="phone" id="phone" value="<?php echo e(old('phone', $business->phone)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.currency_required')); ?></label>
                    <select lang="en" dir="ltr" name="currency" id="currency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                        <option value=""><?php echo e(__('app.select_currency')); ?></option>
                        <option value="USD" <?php if(old('currency', $business->currency) === 'USD'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.usd_us_dollar')); ?>

                        </option>
                        <option value="EUR" <?php if(old('currency', $business->currency) === 'EUR'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.eur_euro')); ?></option>
                        <option value="GBP" <?php if(old('currency', $business->currency) === 'GBP'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.gbp_british_pound')); ?>

                        </option>
                        <option value="AED" <?php if(old('currency', $business->currency) === 'AED'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.aed_uae_dirham')); ?>

                        </option>
                        <option value="CAD" <?php if(old('currency', $business->currency) === 'CAD'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.cad_canadian_dollar')); ?></option>
                        <option value="AUD" <?php if(old('currency', $business->currency) === 'AUD'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.aud_australian_dollar')); ?></option>
                    </select>
                    <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Timezone -->
                <div>
                    <label for="timezone"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.timezone_required')); ?></label>
                    <select lang="en" dir="ltr" name="timezone" id="timezone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        required>
                        <option value=""><?php echo e(__('app.select_timezone')); ?></option>
                        <option value="UTC" <?php if(old('timezone', $business->timezone) === 'UTC'): echo 'selected'; endif; ?>><?php echo e(__('app.utc')); ?>

                        </option>
                        <option value="America/New_York" <?php if(old('timezone', $business->timezone) === 'America/New_York'): echo 'selected'; endif; ?>><?php echo e(__('app.est_eastern_time')); ?></option>
                        <option value="America/Chicago" <?php if(old('timezone', $business->timezone) === 'America/Chicago'): echo 'selected'; endif; ?>><?php echo e(__('app.cst_central_time')); ?></option>
                        <option value="America/Los_Angeles" <?php if(old('timezone', $business->timezone) === 'America/Los_Angeles'): echo 'selected'; endif; ?>><?php echo e(__('app.pst_pacific_time')); ?></option>
                        <option value="Europe/London" <?php if(old('timezone', $business->timezone) === 'Europe/London'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.gmt_london')); ?>

                        </option>
                        <option value="Europe/Paris" <?php if(old('timezone', $business->timezone) === 'Europe/Paris'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.cet_paris')); ?>

                        </option>
                        <option value="Asia/Dubai" <?php if(old('timezone', $business->timezone) === 'Asia/Dubai'): echo 'selected'; endif; ?>>
                            <?php echo e(__('app.gst_dubai')); ?></option>
                        <option value="Asia/Singapore" <?php if(old('timezone', $business->timezone) === 'Asia/Singapore'): echo 'selected'; endif; ?>><?php echo e(__('app.sgt_singapore')); ?></option>
                    </select>
                    <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active"
                        class="block text-sm font-semibold text-gray-900 mb-2"><?php echo e(__('app.status')); ?></label>
                    <select lang="en" dir="ltr" name="is_active" id="is_active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <option value="0" <?php if(!$business->is_active): echo 'selected'; endif; ?>><?php echo e(__('app.inactive')); ?></option>
                        <option value="1" <?php if($business->is_active): echo 'selected'; endif; ?>><?php echo e(__('app.active')); ?></option>
                    </select>
                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <form action="<?php echo e(route('admin.super.businesses.destroy', $business)); ?>" method="POST" class="inline"
                    onsubmit="return confirm('<?php echo e(__('app.delete_business_full_confirm')); ?>')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <?php echo e(__('app.delete_business')); ?>

                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="<?php echo e(route('admin.super.businesses.show', $business)); ?>"
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                        <?php echo e(__('app.cancel')); ?>

                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:shadow-lg transition font-medium">
                        <?php echo e(__('app.update_business')); ?>

                    </button>
                </div>
            </div>
        </form>
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
<?php endif; ?><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/super/businesses/edit.blade.php ENDPATH**/ ?>