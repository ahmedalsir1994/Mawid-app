<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Check your email</h2>
        <p class="text-sm text-gray-500 mt-1">
            We sent a 6-digit code to verify your account.
        </p>
    </div>

    <?php if(session('info')): ?>
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700">
            <?php echo e(session('info')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('resent')): ?>
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
            <?php echo e(session('resent')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('otp.verify')); ?>">
        <?php echo csrf_field(); ?>

        <!-- OTP Input -->
        <div class="mb-5">
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                Verification Code
            </label>
            <input lang="en" dir="ltr"
                type="text"
                id="otp"
                name="otp"
                maxlength="6"
                inputmode="numeric"
                autocomplete="one-time-code"
                autofocus
                placeholder="000000"
                value="<?php echo e(old('otp')); ?>"
                class="w-full px-4 py-4 text-center text-3xl font-bold tracking-[0.5em] rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <p class="text-xs text-gray-500 mt-2 text-center">
                The code expires in <span class="font-semibold">10 minutes</span>
            </p>
        </div>

        <button type="submit"
            class="w-full py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl hover:shadow-lg transition">
            Verify Email →
        </button>
    </form>

    <!-- Resend -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500 mb-2">Didn't receive the code?</p>
        <form method="POST" action="<?php echo e(route('otp.resend')); ?>" class="inline">
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="text-sm font-semibold text-green-600 hover:text-green-700 hover:underline transition">
                Resend verification code
            </button>
        </form>
    </div>

    <div class="mt-4 text-center">
        <a href="<?php echo e(route('register')); ?>" class="text-xs text-gray-400 hover:text-gray-600 transition">
            ← Back to registration
        </a>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/auth/otp-verify.blade.php ENDPATH**/ ?>