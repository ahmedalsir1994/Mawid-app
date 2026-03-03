<?php $__env->startSection('navbar'); ?>
<!-- Navigation -->
    <nav class="fixed w-full bg-white bg-opacity-95  z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="http://mawid.om" rel="noopener noreferrer" class="flex items-center">
                    <img src="/images/Mawid.png" alt="Mawid Logo" class="h-12 w-full">
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-green-600 transition"><?php echo e(__('landing.nav_features')); ?></a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-green-600 transition"><?php echo e(__('landing.nav_how_it_works')); ?></a>
                    <a href="#testimonials" class="text-gray-600 hover:text-green-600 transition"><?php echo e(__('landing.nav_testimonials')); ?></a>
                    <a href="#pricing" class="text-gray-600 hover:text-green-600 transition"><?php echo e(__('landing.nav_pricing')); ?></a>
                </div>

                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex space-x-4 items-center">
                    <!-- Language Switcher -->
                    <div class="flex gap-1 bg-gray-100 rounded-lg p-1">
                        <a href="<?php echo e(route('lang.switch', 'en')); ?>"
                            class="px-3 py-1 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'en' ? 'bg-green-600 text-white' : 'text-gray-700 hover:bg-gray-200'); ?>">
                            EN
                        </a>
                        <a href="<?php echo e(route('lang.switch', 'ar')); ?>"
                            class="px-3 py-1 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'ar' ? 'bg-green-600 text-white' : 'text-gray-700 hover:bg-gray-200'); ?>">
                            AR
                        </a>
                    </div>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                            class="px-4 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">
                            <?php echo e(__('landing.nav_dashboard')); ?>

                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 text-gray-700 hover:text-green-600 transition">
                            <?php echo e(__('landing.nav_sign_in')); ?>

                        </a>
                        <a href="<?php echo e(route('register')); ?>"
                            class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg hover:shadow-lg transition">
                            <?php echo e(__('landing.nav_get_started')); ?>

                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button"
                        class="text-gray-600 hover:text-green-600 focus:outline-none focus:text-green-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-open-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                            <path id="menu-close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <!-- Language Switcher for Mobile -->
                <div class="flex gap-2 justify-center py-2">
                    <a href="<?php echo e(route('lang.switch', 'en')); ?>"
                        class="px-4 py-2 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'en' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'); ?>">
                        EN
                    </a>
                    <a href="<?php echo e(route('lang.switch', 'ar')); ?>"
                        class="px-4 py-2 text-sm font-medium rounded transition <?php echo e(app()->getLocale() === 'ar' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'); ?>">
                        AR
                    </a>
                </div>
                
                <a href="#features"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-green-50 hover:text-green-600 transition">
                    <?php echo e(__('landing.nav_features')); ?>

                </a>
                <a href="#how-it-works"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-green-50 hover:text-green-600 transition">
                    <?php echo e(__('landing.nav_how_it_works')); ?>

                </a>
                <a href="#testimonials"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-green-50 hover:text-green-600 transition">
                    <?php echo e(__('landing.nav_testimonials')); ?>

                </a>
                <a href="#pricing"
                    class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-green-50 hover:text-green-600 transition">
                    <?php echo e(__('landing.nav_pricing')); ?>

                </a>
                <div class="pt-3 space-y-2 border-t border-gray-200">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                            class="block px-3 py-2 rounded-lg text-green-600 font-semibold bg-green-50">
                            <?php echo e(__('landing.nav_dashboard')); ?>

                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>"
                            class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            <?php echo e(__('landing.nav_sign_in')); ?>

                        </a>
                        <a href="<?php echo e(route('register')); ?>"
                            class="block px-3 py-2 bg-gradient-to-r from-green-600 to-green-800 text-white text-center font-semibold rounded-lg">
                            <?php echo e(__('landing.nav_get_started')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\laragon\www\booking-app\resources\views\layouts\navbar.blade.php ENDPATH**/ ?>