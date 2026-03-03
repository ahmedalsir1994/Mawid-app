<?php $__env->startSection('footer'); ?>
<footer class="bg-white-900 text-black-300 py-12 px-4 sm:px-6 lg:px-8  border-gray-700 ">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <a href="http://mawid.om" target="_blank" rel="noopener noreferrer">
                        <img src="/images/Mawid.png" alt="Mawid Logo" class="h-10 mb-4">
                    </a>
                    <p class="text-sm"><?php echo e(__('landing.footer_desc')); ?></p>
                </div>
                <div>
                    <h5 class="font-bold text-black mb-4"><?php echo e(__('landing.footer_product')); ?></h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-black transition"><?php echo e(__('landing.footer_features')); ?></a></li>
                        <li><a href="#pricing" class="hover:text-black transition"><?php echo e(__('landing.footer_pricing')); ?></a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-black mb-4"><?php echo e(__('landing.footer_company')); ?></h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo e(route('about')); ?>" class="hover:text-black transition"><?php echo e(__('landing.footer_about')); ?></a></li>
                        <li><a href="<?php echo e(route('blog')); ?>" class="hover:text-black transition"><?php echo e(__('landing.footer_blog')); ?></a></li>
                        <li><a href="#" class="hover:text-black transition"><?php echo e(__('landing.footer_careers')); ?></a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-black mb-4"><?php echo e(__('landing.footer_legal')); ?></h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo e(route('privacy')); ?>" class="hover:text-black transition"><?php echo e(__('landing.footer_privacy')); ?></a></li>
                        <li><a href="<?php echo e(route('terms')); ?>" class="hover:text-black transition"><?php echo e(__('landing.footer_terms')); ?></a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-black transition"><?php echo e(__('landing.footer_contact')); ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-sm">
                <p><?php echo e(__('landing.footer_copyright', ['name' => config('app.name')])); ?></p>
            </div>
        </div>
    </footer>
<?php $__env->stopSection(); ?><?php /**PATH C:\laragon\www\booking-app\resources\views/layouts/footer.blade.php ENDPATH**/ ?>