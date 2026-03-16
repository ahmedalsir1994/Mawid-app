<?php
    $inputClass = 'block mt-1 w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition';
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - <?php echo e(config('app.name', 'Mawid')); ?></title>
    <link rel="icon" href="/images/Mawidly-fav.png" type="image/png">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-white min-h-screen flex flex-col font-sans antialiased">


<div class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between gap-4">

        
        <div class="w-24 flex justify-start">
            <a href="<?php echo e(route('landing')); ?>"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
        </div>

        
        <a href="<?php echo e(route('landing')); ?>" class="flex flex-col items-center">
            <img src="/images/Mawid.png" alt="<?php echo e(config('app.name', 'Mawid')); ?>" class="h-7">
            <span class="text-xs text-gray-400 mt-0.5 tracking-wide">Welcome back</span>
        </a>

        
        <div class="w-24"></div>

    </div>
</div>


<div class="h-14"></div>


<main class="flex-1 flex flex-col items-center px-4 sm:px-6 py-10">
    <div class="w-full max-w-xl">

        
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">Sign in to your account</h1>
            <p class="text-gray-500 mt-3 text-base">Enter your credentials to access your dashboard.</p>
        </div>

        
        <?php if(session('status')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
            <?php echo e(session('status')); ?>

        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <?php if(request('expired')): ?>
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-sm text-yellow-700">
            Your session expired. Please sign in again to continue.
        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>
            <?php if(request('intended')): ?>
                <input type="hidden" name="intended" value="<?php echo e(request('intended')); ?>">
            <?php endif; ?>

            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                       class="<?php echo e($inputClass); ?>" placeholder="you@example.com"
                       required autofocus autocomplete="username" />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>"
                       class="text-xs text-green-600 hover:underline font-medium">
                        Forgot password?
                    </a>
                    <?php endif; ?>
                </div>
                <input id="password" type="password" name="password"
                       class="<?php echo e($inputClass); ?>" placeholder="Your password"
                       required autocomplete="current-password" />
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            
            <div class="pt-2">
                <button type="submit"
                        class="w-full py-3 px-6 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">
                    Sign In
                </button>
            </div>

            
            <p class="text-sm text-gray-400 text-center">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>" class="text-green-600 font-medium hover:underline">Create one</a>
            </p>
        </form>

    </div>
</main>

</body>
</html>
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/auth/login.blade.php ENDPATH**/ ?>