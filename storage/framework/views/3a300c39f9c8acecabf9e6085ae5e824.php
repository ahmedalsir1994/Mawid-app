<?php echo csrf_field(); ?>

<div class="space-y-6">
    <!-- Service Name -->
    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.service_name')); ?></label>
        <input lang="en" dir="ltr" type="text" name="name" value="<?php echo e(old('name', $service->name ?? '')); ?>" 
            placeholder="<?php echo e(__('app.service_placeholder')); ?>"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
            <p class="text-red-600 text-sm mt-2 flex items-center space-x-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e($message); ?></span>
            </p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Service Images -->
    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.service_image')); ?></label>

        
        <?php
            $existingImages = $service && $service->images && $service->images->count() > 0
                ? $service->images
                : collect();
            // Legacy single image (shown only if no new-style images yet)
            $legacyImage = (!$existingImages->count() && $service && $service->image) ? $service->image : null;
        ?>

        <?php if($existingImages->count()): ?>
            <div class="mb-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3" id="existingImagesGrid">
                <?php $__currentLoopData = $existingImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="relative group rounded-lg overflow-hidden border border-gray-200 aspect-square bg-gray-50" id="img-<?php echo e($img->id); ?>">
                        <img src="<?php echo e(asset($img->path)); ?>" alt="Service image"
                            class="w-full h-full object-cover">
                        <?php if(isset($service) && $service->id): ?>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40 rounded-lg">
                                <button type="button"
                                    onclick="deleteServiceImage(this, '<?php echo e(route('admin.services.images.destroy', [$service, $img])); ?>', <?php echo e($img->id); ?>)"
                                    class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition shadow">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php elseif($legacyImage): ?>
            <div class="mb-3">
                <img src="<?php echo e(asset($legacyImage)); ?>" alt="" class="h-28 w-auto rounded-lg border border-gray-200 shadow-sm">
                <p class="text-xs text-gray-400 mt-1">Legacy image — upload new images below to replace.</p>
            </div>
        <?php endif; ?>

        
        <div class="relative">
            <label for="imagesInput"
                class="flex flex-col items-center justify-center w-full h-28 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 cursor-pointer transition">
                <svg class="w-8 h-8 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm font-medium text-gray-600">Click to upload photos</span>
                <span class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP · up to 4 MB each · up to 10 files</span>
            </label>
            <input lang="en" dir="ltr" id="imagesInput" type="file" name="images[]" multiple accept="image/jpeg,image/jpg,image/png,image/webp"
                class="sr-only" onchange="previewNewImages(this)">
        </div>

        
        <div id="newImagesPreview" class="mt-3 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3 hidden"></div>

        <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Service Description -->
    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.description_optional')); ?></label>
        <textarea lang="en" dir="ltr" name="description" rows="3" 
            placeholder="<?php echo e(__('app.brief_description')); ?>"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"><?php echo e(old('description', $service->description ?? '')); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
            <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Duration and Price Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Duration -->
        <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.duration_minutes')); ?></label>
            <?php
                $presets     = [15, 30, 45, 60, 75, 90, 120];
                $curDuration = (int) old('duration_minutes', $service->duration_minutes ?? 30);
                $isCustom    = !in_array($curDuration, $presets);
            ?>

            
            <div class="grid grid-cols-4 gap-2 mb-2">
                <?php $__currentLoopData = $presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-duration="<?php echo e($p); ?>"
                    class="duration-btn px-2 py-2 rounded-lg border text-sm font-semibold transition
                        <?php echo e($curDuration === $p && !$isCustom
                            ? 'bg-green-600 text-white border-green-600'
                            : 'bg-white text-gray-700 border-gray-300 hover:border-green-400 hover:bg-green-50'); ?>">
                    <?php echo e($p); ?><span class="font-normal text-xs"> min</span>
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="button" id="customDurationBtn"
                    class="duration-btn px-2 py-2 rounded-lg border text-sm font-semibold transition
                        <?php echo e($isCustom
                            ? 'bg-green-600 text-white border-green-600'
                            : 'bg-white text-gray-700 border-gray-300 hover:border-green-400 hover:bg-green-50'); ?>">
                    Custom
                </button>
            </div>

            
            <div id="customDurationWrap" class="<?php echo e($isCustom ? '' : 'hidden'); ?> relative">
                <input type="number" id="customDurationInput"
                    value="<?php echo e($isCustom ? $curDuration : ''); ?>"
                    min="15" step="15" max="480"
                    placeholder="e.g. 75"
                    oninvalid="return false;"
                    class="w-full px-4 py-3 pr-14 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" />
                <span class="absolute right-4 top-3 text-gray-400 text-sm">min</span>
                <p class="text-xs text-gray-400 mt-1">Must be a multiple of 15 (e.g. 75, 105, 135…)</p>
            </div>

            
            <input type="hidden" name="duration_minutes" id="durationMinutesInput" value="<?php echo e($curDuration); ?>">

            <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <script>
            (function () {
                const btns        = document.querySelectorAll('.duration-btn');
                const customBtn   = document.getElementById('customDurationBtn');
                const customWrap  = document.getElementById('customDurationWrap');
                const customInput = document.getElementById('customDurationInput');
                const hidden      = document.getElementById('durationMinutesInput');

                function setActive(btn) {
                    btns.forEach(b => {
                        b.classList.remove('bg-green-600', 'text-white', 'border-green-600');
                        b.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                    });
                    btn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                    btn.classList.add('bg-green-600', 'text-white', 'border-green-600');
                }

                btns.forEach(btn => {
                    if (btn.dataset.duration) {
                        btn.addEventListener('click', () => {
                            hidden.value = btn.dataset.duration;
                            customWrap.classList.add('hidden');
                            setActive(btn);
                        });
                    }
                });

                customBtn.addEventListener('click', () => {
                    customWrap.classList.remove('hidden');
                    setActive(customBtn);
                    customInput.focus();
                    if (customInput.value) hidden.value = customInput.value;
                });

                customInput.addEventListener('input', () => {
                    const val = parseInt(customInput.value);
                    if (val > 0) hidden.value = val;
                });
            })();
            </script>
        </div>

        <!-- Price -->
        <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2"><?php echo e(__('app.price_optional')); ?></label>
            <div class="relative">
                <span class="absolute left-4 top-3 text-gray-500">$</span>
                <input lang="en" dir="ltr" type="number" step="0.01" name="price" 
                    value="<?php echo e(old('price', $service->price ?? '')); ?>"
                    placeholder="0.00"
                    class="w-full pl-8 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
            </div>
            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <!-- Active Status -->
    <div class="border-t border-gray-200 pt-6">
        <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
            <input lang="en" dir="ltr" type="checkbox" name="is_active" id="is_active" 
                <?php if(old('is_active', $service->is_active ?? true)): echo 'checked'; endif; ?>
                class="w-4 h-4 text-green-600 rounded focus:ring-2 focus:ring-green-500 cursor-pointer" />
            <label for="is_active" class="flex-1 cursor-pointer">
                <p class="font-medium text-gray-800"><?php echo e(__('app.service_is_active')); ?></p>
                <p class="text-sm text-gray-600"><?php echo e(__('app.customers_can_book')); ?></p>
            </label>
        </div>
    </div>

    <!-- Branch Assignment -->
    <?php $allBranches = $branches ?? collect(); ?>
    <?php if($allBranches->isNotEmpty()): ?>
    <div class="border-t border-gray-200 pt-6">
        <label class="block text-sm font-medium text-gray-700 mb-3"><?php echo e(__('app.branches')); ?></label>
        <p class="text-sm text-gray-500 mb-4"><?php echo e(__('app.select_branches_hint')); ?></p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <?php
                $selectedBranchIds = old('branch_ids', $service?->branches->pluck('id')->toArray() ?? []);
            ?>
            <?php $__currentLoopData = $allBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-gray-50 hover:bg-green-50 hover:border-green-300 cursor-pointer transition">
                <input type="checkbox" name="branch_ids[]" value="<?php echo e($branch->id); ?>"
                    <?php echo e(in_array($branch->id, (array) $selectedBranchIds) ? 'checked' : ''); ?>

                    class="w-4 h-4 text-green-600 rounded focus:ring-2 focus:ring-green-500 cursor-pointer">
                <span class="text-sm font-medium text-gray-800"><?php echo e($branch->name); ?></span>
            </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <p class="text-xs text-gray-400 mt-2"><?php echo e(__('app.no_branch_means_all')); ?></p>
        <?php $__errorArgs = ['branch_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="border-t border-gray-200 pt-6 flex items-center justify-between">
        <a href="<?php echo e(route('admin.services.index')); ?>" 
            class="px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100 rounded-lg transition">
            <?php echo e(__('app.cancel')); ?>

        </a>
        <button type="submit" class="px-8 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold hover:shadow-lg transition flex items-center space-x-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            <span><?php echo e(__('app.save_service')); ?></span>
        </button>
    </div>
</div>

<script>
function previewNewImages(input) {
    const preview = document.getElementById('newImagesPreview');
    preview.innerHTML = '';
    const files = Array.from(input.files);
    if (!files.length) { preview.classList.add('hidden'); return; }
    preview.classList.remove('hidden');
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative aspect-square rounded-lg overflow-hidden border border-green-200 bg-gray-50';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-full object-cover';
            const badge = document.createElement('span');
            badge.textContent = 'New';
            badge.className = 'absolute top-1 left-1 bg-green-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded';
            wrapper.appendChild(img);
            wrapper.appendChild(badge);
            preview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

function deleteServiceImage(btn, url, imgId) {
    if (!confirm('Remove this image?')) return;
    btn.disabled = true;
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-HTTP-Method-Override': 'DELETE',
            'Accept': 'application/json',
        },
        body: new URLSearchParams({ _method: 'DELETE' }),
    })
    .then(r => {
        if (!r.ok) throw new Error('Failed');
        const el = document.getElementById('img-' + imgId);
        if (el) el.remove();
    })
    .catch(() => {
        btn.disabled = false;
        alert('Could not delete image. Please try again.');
    });
}
</script><?php /**PATH C:\laragon\www\booking-app\resources\views/admin/services/_form.blade.php ENDPATH**/ ?>