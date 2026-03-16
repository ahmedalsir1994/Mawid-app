<?php
    $selectedPlan  = old('plan',          request('plan',  'free'));
    $selectedCycle = old('billing_cycle',  request('cycle', 'monthly'));
    $planLabels    = ['pro' => 'Pro', 'plus' => 'Plus'];
    $planColors    = ['pro' => 'bg-blue-600', 'plus' => 'bg-green-600'];
    $isPaid        = in_array($selectedPlan, ['pro', 'plus']);

    if ($isPaid) {
        $planData    = \App\Services\PlanService::get($selectedPlan);
        $discountPct = $selectedCycle === 'yearly'
            ? $planData['discount_yearly']
            : $planData['discount_monthly'];
        $oldPrice = $selectedCycle === 'yearly'
            ? $planData['old_price_yearly'] . ' OMR/yr'
            : $planData['old_price_monthly'] . ' OMR/mo';
        $newPrice = $selectedCycle === 'yearly'
            ? number_format($planData['price_yearly_display'], 1) . ' OMR/mo · ' . number_format($planData['price_yearly'], 2) . ' OMR/yr'
            : number_format($planData['price_monthly'], 1) . ' OMR/mo';
    }

    $businessTypes = [
        'beauty_salon'       => 'Beauty Salon',
        'barbershop'         => 'Barbershop',
        'spa_wellness'       => 'Spa & Wellness',
        'medical_clinic'     => 'Medical Clinic',
        'dental_clinic'      => 'Dental Clinic',
        'fitness_gym'        => 'Fitness & Gym',
        'personal_trainer'   => 'Personal Trainer',
        'photography'        => 'Photography Studio',
        'cleaning_services'  => 'Cleaning Services',
        'home_services'      => 'Home Services',
        'tutoring'           => 'Tutoring & Education',
        'legal_consulting'   => 'Legal Consulting',
        'financial_services' => 'Financial Services',
        'it_services'        => 'IT Services',
        'other'              => 'Other',
    ];

    $companySizes = [
        '1-5'    => '1 - 5 employees',
        '6-20'   => '6 - 20 employees',
        '21-50'  => '21 - 50 employees',
        '51-200' => '51 - 200 employees',
        '200+'   => '200+ employees',
    ];

    $howHeardOptions = [
        'google_search' => 'Google Search',
        'facebook'      => 'Facebook',
        'instagram'     => 'Instagram',
        'referral'      => 'Friend or Referral',
        'youtube'       => 'YouTube',
        'advertisement' => 'Advertisement',
        'event'         => 'Event or Conference',
        'other'         => 'Other',
    ];

    // Restore to the right step when Laravel returns validation errors
    $openStep = 1;
    if ($errors->has('how_heard_about_us'))                                                              { $openStep = 3; }
    if ($errors->hasAny(['password', 'password_confirmation', 'terms']))                                 { $openStep = 4; }
    if ($errors->hasAny(['business_name','business_type','company_size','country','timezone','address'])) { $openStep = 2; }
    if ($errors->hasAny(['name', 'email', 'phone']))                                                     { $openStep = 1; }

    $inputClass  = 'block mt-1 w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition';
    $selectClass = 'block mt-1 w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition bg-white';
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - <?php echo e(config('app.name', 'Mawid')); ?></title>
    <link rel="icon" href="/images/Mawidly-fav.png" type="image/png">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-white min-h-screen flex flex-col font-sans antialiased">


<div class="fixed top-0 left-0 right-0 z-50">

    
    <div class="flex w-full h-1.5" aria-hidden="true">
        <?php for($i = 1; $i <= 4; $i++): ?>
        <div id="seg-<?php echo e($i); ?>" class="flex-1 transition-colors duration-300"
             style="<?php echo e($i === 1 ? 'background:#22c55e' : 'background:#e5e7eb'); ?><?php echo e($i < 4 ? ';margin-right:2px' : ''); ?>"></div>
        <?php endfor; ?>
    </div>

    
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between gap-4">

            
            <div class="w-24 flex justify-start">
                <a id="btn-back-home" href="<?php echo e(route('landing')); ?>"
                   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>
                <button id="btn-back-step" type="button" onclick="wizardBack()" style="display:none"
                        class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </button>
            </div>

            
            <a href="<?php echo e(route('landing')); ?>" class="flex flex-col items-center">
                <img src="/images/Mawid.png" alt="<?php echo e(config('app.name', 'Mawid')); ?>" class="h-7">
                <span class="text-xs text-gray-400 mt-0.5 tracking-wide">Account Setup</span>
            </a>

            
            <div class="w-24 flex justify-end">
                <button id="btn-continue" type="button" onclick="wizardNext()"
                        class="px-4 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition whitespace-nowrap">
                    Continue
                </button>
            </div>

        </div>
    </div>
</div>


<div class="h-16"></div>


<main class="flex-1 flex flex-col items-center px-4 sm:px-6 py-10">
    <div class="w-full max-w-xl">

        
        <?php if($isPaid): ?>
        <div class="mb-8 p-4 rounded-xl <?php echo e($planColors[$selectedPlan]); ?> text-white text-center">
            <p class="font-bold text-lg"><?php echo e($planLabels[$selectedPlan]); ?> Plan</p>
            <div class="flex items-center justify-center gap-2 mt-1">
                <span class="text-sm line-through opacity-70"><?php echo e($oldPrice); ?></span>
                <span class="text-lg font-bold"><?php echo e($newPrice); ?></span>
                <span class="text-xs font-bold bg-white text-green-700 px-2 py-0.5 rounded-full">Save <?php echo e($discountPct); ?>%</span>
            </div>
            <p class="text-sm opacity-90 mt-1">Create your account, then complete payment to activate.</p>
        </div>
        <?php endif; ?>

        <form id="wizard-form" method="POST" action="<?php echo e(route('register')); ?>" novalidate>
            <?php echo csrf_field(); ?>
            <input type="hidden" name="plan"          value="<?php echo e($selectedPlan); ?>">
            <input type="hidden" name="billing_cycle" value="<?php echo e($selectedCycle); ?>">

            
            <div id="step-1" class="wizard-step">
                <div class="mb-8">
                    <p class="text-xs font-bold uppercase tracking-widest text-green-600 mb-2">Step 1 of 4</p>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">Tell us about yourself</h1>
                    <p class="text-gray-500 mt-3 text-base">We will use these details to set up your account and reach you.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>"
                               class="<?php echo e($inputClass); ?>" placeholder="Ahmed Al-Harthi"
                               autocomplete="name" />
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                               class="<?php echo e($inputClass); ?>" placeholder="you@example.com"
                               autocomplete="username" />
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
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input id="phone" type="tel" name="phone" value="<?php echo e(old('phone')); ?>"
                               class="<?php echo e($inputClass); ?>" placeholder="+968 9X XXX XXX"
                               autocomplete="tel" />
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <p class="mt-8 text-sm text-gray-400 text-center">
                    Already have an account?
                    <a href="<?php echo e(route('login')); ?>" class="text-green-600 font-medium hover:underline">Sign in</a>
                </p>
            </div>

            
            <div id="step-2" class="wizard-step" style="display:none">
                <div class="mb-8">
                    <p class="text-xs font-bold uppercase tracking-widest text-green-600 mb-2">Step 2 of 4</p>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">Set up your business</h1>
                    <p class="text-gray-500 mt-3 text-base">This helps us tailor Mawid to your business.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                        <input id="business_name" type="text" name="business_name" value="<?php echo e(old('business_name')); ?>"
                               class="<?php echo e($inputClass); ?>" placeholder="Nour Beauty Salon" />
                        <?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="business_type" class="block text-sm font-medium text-gray-700 mb-1">Business Type</label>
                            <select id="business_type" name="business_type" class="<?php echo e($selectClass); ?>">
                                <option value="" disabled <?php echo e(old('business_type') ? '' : 'selected'); ?>>Select type...</option>
                                <?php $__currentLoopData = $businessTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(old('business_type') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['business_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label for="company_size" class="block text-sm font-medium text-gray-700 mb-1">Company Size</label>
                            <select id="company_size" name="company_size" class="<?php echo e($selectClass); ?>">
                                <option value="" disabled <?php echo e(old('company_size') ? '' : 'selected'); ?>>Select size...</option>
                                <?php $__currentLoopData = $companySizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(old('company_size') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['company_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <select id="country" name="country" class="<?php echo e($selectClass); ?>">
                                <option value="" disabled <?php echo e(old('country') ? '' : 'selected'); ?>>Select country...</option>
                                <?php $__currentLoopData = config('countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $cname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($code); ?>" <?php echo e(old('country', 'OM') === $code ? 'selected' : ''); ?>><?php echo e($cname); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                            <select id="timezone" name="timezone" class="<?php echo e($selectClass); ?>">
                                <option value="" disabled>Select timezone...</option>
                                <?php $__currentLoopData = \DateTimeZone::listIdentifiers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tz); ?>" <?php echo e(old('timezone', 'Asia/Muscat') === $tz ? 'selected' : ''); ?>><?php echo e($tz); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Business Address</label>
                        <textarea id="address" name="address" rows="3"
                                  class="block mt-1 w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition"
                                  placeholder="Copy your address from Google Maps (e.g. 123 Main St, Muscat, Oman)"
                        ><?php echo e(old('address')); ?></textarea>
                        <p class="mt-1.5 text-xs text-gray-400">Open Google Maps, find your business, copy the address and paste it here.</p>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div id="step-3" class="wizard-step" style="display:none">
                <div class="mb-8">
                    <p class="text-xs font-bold uppercase tracking-widest text-green-600 mb-2">Step 3 of 4</p>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">How did you find us?</h1>
                    <p class="text-gray-500 mt-3 text-base">Helps us understand where to reach more businesses like yours.</p>
                </div>

                <div class="space-y-3" id="how-heard-list">
                    <?php $__currentLoopData = $howHeardOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="how-heard-option flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition
                                  <?php echo e(old('how_heard_about_us') === $val ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'); ?>">
                        <input type="radio" name="how_heard_about_us" value="<?php echo e($val); ?>"
                               class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                               <?php echo e(old('how_heard_about_us') === $val ? 'checked' : ''); ?>

                               onchange="highlightHowHeard(this)">
                        <span class="text-sm font-medium text-gray-800"><?php echo e($lbl); ?></span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['how_heard_about_us'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-3 text-xs text-red-600">Please select one option.</p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div id="step-4" class="wizard-step" style="display:none">
                <div class="mb-8">
                    <p class="text-xs font-bold uppercase tracking-widest text-green-600 mb-2">Step 4 of 4</p>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">Almost there!</h1>
                    <p class="text-gray-500 mt-3 text-base">Set a secure password to protect your account.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password"
                               class="<?php echo e($inputClass); ?>" autocomplete="new-password"
                               placeholder="Min. 8 characters" />
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
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="<?php echo e($inputClass); ?>" autocomplete="new-password"
                               placeholder="Repeat your password" />
                        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label id="terms-label" class="flex items-start gap-3 cursor-pointer p-4 rounded-xl border-2
                               <?php echo e(old('terms') ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'); ?> transition">
                            <input type="checkbox" id="terms" name="terms" value="1"
                                   <?php echo e(old('terms') ? 'checked' : ''); ?>

                                   class="mt-0.5 h-4 w-4 shrink-0 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                   onchange="toggleTermsBorder(this)">
                            <span class="text-sm text-gray-700 leading-snug">
                                I agree to the
                                <a href="<?php echo e(url('/terms')); ?>" target="_blank" class="text-green-600 font-semibold hover:underline">Terms of Service</a>
                                and
                                <a href="<?php echo e(url('/privacy')); ?>" target="_blank" class="text-green-600 font-semibold hover:underline">Privacy Policy</a>
                            </span>
                        </label>
                        <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <p class="mt-8 text-sm text-gray-400 text-center">
                    Already have an account?
                    <a href="<?php echo e(route('login')); ?>" class="text-green-600 font-medium hover:underline">Sign in</a>
                </p>
            </div>

        </form>
    </div>
</main>

<script>
(function () {
    var currentStep = <?php echo e($openStep); ?>;
    var totalSteps  = 4;

    function updateUI() {
        for (var i = 1; i <= totalSteps; i++) {
            document.getElementById('step-' + i).style.display = (i === currentStep) ? 'block' : 'none';
        }
        for (var j = 1; j <= totalSteps; j++) {
            document.getElementById('seg-' + j).style.background = j <= currentStep ? '#22c55e' : '#e5e7eb';
        }
        var homeBack = document.getElementById('btn-back-home');
        var stepBack = document.getElementById('btn-back-step');
        if (currentStep === 1) {
            homeBack.style.display = 'inline-flex';
            stepBack.style.display = 'none';
        } else {
            homeBack.style.display = 'none';
            stepBack.style.display = 'inline-flex';
        }
        var btn = document.getElementById('btn-continue');
        btn.textContent = (currentStep === totalSteps)
            ? '<?php echo e($isPaid ? "Register & Pay" : "Create Account"); ?>'
            : 'Continue \u2192';
    }

    function getStepFields(step) {
        var el = document.getElementById('step-' + step);
        return el.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"], select, textarea');
    }

    function validateStep(step) {
        var ok = true;
        getStepFields(step).forEach(function (f) {
            f.style.borderColor = '';
            if (!f.value.trim()) {
                f.style.borderColor = '#ef4444';
                ok = false;
            }
        });
        if (step === 3) {
            var checked = document.querySelector('input[name="how_heard_about_us"]:checked');
            if (!checked) {
                document.querySelectorAll('.how-heard-option').forEach(function (l) { l.style.borderColor = '#ef4444'; });
                ok = false;
            }
        }
        if (step === 4) {
            var terms = document.getElementById('terms');
            if (!terms.checked) {
                document.getElementById('terms-label').style.borderColor = '#ef4444';
                ok = false;
            }
        }
        return ok;
    }

    window.wizardNext = function () {
        if (!validateStep(currentStep)) { return; }
        if (currentStep < totalSteps) {
            currentStep++;
            updateUI();
            window.scrollTo(0, 0);
        } else {
            document.getElementById('wizard-form').submit();
        }
    };

    window.wizardBack = function () {
        if (currentStep > 1) { currentStep--; updateUI(); window.scrollTo(0, 0); }
    };

    window.highlightHowHeard = function (radio) {
        document.querySelectorAll('.how-heard-option').forEach(function (l) {
            l.style.borderColor = '';
            l.style.backgroundColor = '';
        });
        var chosen = radio.closest('.how-heard-option');
        if (chosen) { chosen.style.borderColor = '#22c55e'; chosen.style.backgroundColor = '#f0fdf4'; }
    };

    window.toggleTermsBorder = function (cb) {
        var lbl = document.getElementById('terms-label');
        lbl.style.borderColor    = cb.checked ? '#22c55e' : '';
        lbl.style.backgroundColor = cb.checked ? '#f0fdf4' : '';
    };

    updateUI();
}());
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/auth/register.blade.php ENDPATH**/ ?>