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
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-green-600"><?php echo e(__('app.dashboard')); ?></a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium"><?php echo e(__('app.upgrade_plan')); ?></span>
        </nav>
    </div>

    <?php if(session('limit_message')): ?>
        <div class="mb-6 p-4 bg-amber-50 border border-amber-300 rounded-xl flex items-start gap-3">
            <span class="text-2xl">⚠️</span>
            <div>
                <p class="font-semibold text-amber-800"><?php echo e(__('app.plan_limit_reached')); ?></p>
                <p class="text-amber-700 text-sm mt-1"><?php echo e(session('limit_message')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-300 rounded-xl text-red-700">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="py-4 px-0">
        <div class="text-center mb-10">
            <div class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-semibold mb-4">
                <?php echo e(__('landing.pricing_badge')); ?>

            </div>
            <?php if($licenseExpired ?? false): ?>
            <h2 class="text-4xl font-bold mb-3">Reactivate Your Subscription</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Your account is on the Free plan. Reactivate your previous plan or upgrade to restore full access instantly.</p>
            <?php else: ?>
            <h2 class="text-4xl font-bold mb-3"><?php echo e(__('landing.pricing_title')); ?></h2>
            <p class="text-gray-500 max-w-xl mx-auto"><?php echo e(__('landing.pricing_subtitle')); ?></p>
            <?php endif; ?>

            
            <?php
                $currentPlan   = $license?->plan ?? 'free';
                $licenseExpired = $license && ($license->isExpired() || ($license->isPastDue() && !$license->isInGracePeriod()));
            ?>
            <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 <?php echo e($licenseExpired ? 'bg-red-50 border border-red-200' : 'bg-gray-100'); ?> rounded-full text-sm text-gray-600">
                <span><?php echo e(__('app.current_plan')); ?>:</span>
                <span class="font-bold <?php echo e($licenseExpired ? 'text-red-700' : 'text-gray-900'); ?>"><?php echo e(ucfirst($currentPlan)); ?></span>
                <?php if($licenseExpired): ?>
                    <span class="text-red-400">·</span>
                    <span class="text-red-600 font-semibold">Expired — reactivate below</span>
                <?php elseif($license?->expires_at): ?>
                    <span class="text-gray-400">·</span>
                    <span class="text-gray-500"><?php echo e(__('app.renews')); ?> <?php echo e($license->expires_at->format('M d, Y')); ?></span>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="flex flex-col items-center mb-10 gap-3">
            <div class="inline-flex items-center bg-gray-100 rounded-xl p-1 gap-1">
                <button id="btn-monthly" onclick="setCycle('monthly')"
                    class="px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900">
                    <?php echo e(__('landing.billing_monthly')); ?>

                </button>
                <button id="btn-yearly" onclick="setCycle('yearly')"
                    class="px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500">
                    <?php echo e(__('landing.billing_yearly')); ?>

                </button>
            </div>
        </div>

        
        <div class="grid md:grid-cols-3 gap-8 items-start">

            
            <?php $isCurrent = $currentPlan === 'free'; ?>
            <div id="plan-card-free" class="relative bg-white rounded-2xl border <?php echo e($isCurrent ? 'border-2 border-green-400 shadow-lg' : 'border-gray-200'); ?> p-8 hover:shadow-lg transition">
                <?php if($isCurrent): ?>
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        <?php echo e(__('app.current_plan')); ?>

                    </div>
                <?php endif; ?>
                <div class="text-3xl mb-3">🆓</div>
                <h3 class="text-xl font-bold text-gray-900"><?php echo e(__('landing.plan_free_name')); ?></h3>
                <p class="text-sm text-gray-500 mt-1 mb-5"><?php echo e(__('landing.plan_free_tagline')); ?></p>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-800"><?php echo e(__('landing.plan_free_price')); ?></span>
                    <span class="text-gray-500 text-sm ml-1"><?php echo e(__('landing.plan_free_period')); ?></span>
                </div>
                <ul class="space-y-2 mb-8">
                    <?php $__currentLoopData = ['plan_free_f1','plan_free_f2','plan_free_f3','plan_free_f4']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fkey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center gap-2 text-sm text-gray-700">
                            <span class="w-5 h-5 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                            <?php echo e(__("landing.{$fkey}")); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php if($isCurrent): ?>
                    <button disabled class="w-full py-3 rounded-xl bg-gray-100 text-gray-500 font-semibold cursor-default">
                        <?php echo e(__('app.current_plan')); ?>

                    </button>
                <?php else: ?>
                    <div class="w-full py-3 px-4 rounded-xl border border-gray-200 bg-gray-50 text-center">
                        <p class="text-sm text-gray-500">Your plan reverts to Free automatically when your subscription expires.</p>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php $isCurrent = $currentPlan === 'pro'; ?>
            <div id="plan-card-pro" class="relative bg-white rounded-2xl border-2 <?php echo e($isCurrent && $licenseExpired ? 'border-red-400 shadow-lg' : ($isCurrent ? 'border-green-400 shadow-lg' : 'border-blue-500 shadow-xl')); ?> p-8 transition">
                <?php if($isCurrent && $licenseExpired): ?>
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-red-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        Expired — Reactivate
                    </div>
                <?php elseif($isCurrent): ?>
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        <?php echo e(__('app.current_plan')); ?>

                    </div>
                <?php else: ?>
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        <?php echo e(__('landing.plan_popular')); ?>

                    </div>
                <?php endif; ?>
                <div class="text-3xl mb-3">💼</div>
                <h3 class="text-xl font-bold text-gray-900"><?php echo e(__('landing.plan_pro_name')); ?></h3>
                <p class="text-sm text-gray-500 mt-1 mb-5"><?php echo e(__('landing.plan_pro_tagline')); ?></p>
                <div class="mb-6">
                    <div class="cycle-monthly">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm line-through text-gray-400">10 OMR</span>
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 35%</span>
                        </div>
                        <span class="text-4xl font-bold text-gray-900">6.5</span>
                        <span class="text-lg font-semibold text-gray-500 ml-1">OMR</span>
                        <span class="text-sm text-gray-500"> / <?php echo e(__('landing.per_month')); ?></span>
                    </div>
                    <div class="cycle-yearly" style="display:none">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm line-through text-gray-400">10 OMR/mo</span>
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 45%</span>
                        </div>
                        <div class="flex items-end gap-2">
                            <span class="text-4xl font-bold text-gray-900">5.5</span>
                            <span class="text-lg font-semibold text-gray-500 mb-0.5">OMR / <?php echo e(__('landing.per_month')); ?></span>
                        </div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-sm text-gray-500">66 OMR <?php echo e(__('landing.per_year')); ?></span>
                        </div>
                    </div>
                </div>
                <ul class="space-y-2 mb-8">
                    <?php $__currentLoopData = ['plan_pro_f1','plan_pro_f2','plan_pro_f3','plan_pro_f4','plan_pro_f5']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fkey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center gap-2 text-sm text-gray-700">
                            <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                            <?php echo e(__("landing.{$fkey}")); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php if($isCurrent && !$licenseExpired): ?>
                    <button disabled class="w-full py-3 rounded-xl bg-gray-100 text-gray-500 font-semibold cursor-default">
                        <?php echo e(__('app.current_plan')); ?>

                    </button>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('admin.upgrade.initiate')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="plan" value="pro">
                        <input type="hidden" name="billing_cycle" class="cycle-input" value="monthly">
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold hover:shadow-lg transition">
                            <?php echo e($isCurrent && $licenseExpired ? '🔄 Reactivate Pro' : __('landing.plan_pro_cta')); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>

            
            <?php $isCurrent = $currentPlan === 'plus'; ?>
            <div id="plan-card-plus" class="relative bg-white rounded-2xl border <?php echo e($isCurrent && $licenseExpired ? 'border-2 border-red-400 shadow-lg' : ($isCurrent ? 'border-2 border-green-400 shadow-lg' : 'border-gray-200')); ?> p-8 hover:shadow-lg transition">
                <?php if($isCurrent && $licenseExpired): ?>
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-red-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        Expired — Reactivate
                    </div>
                <?php elseif($isCurrent): ?>
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                        <?php echo e(__('app.current_plan')); ?>

                    </div>
                <?php endif; ?>
                <div class="text-3xl mb-3">🚀</div>
                <h3 class="text-xl font-bold text-gray-900"><?php echo e(__('landing.plan_plus_name')); ?></h3>
                <p class="text-sm text-gray-500 mt-1 mb-5"><?php echo e(__('landing.plan_plus_tagline')); ?></p>
                <div class="mb-6">
                    <div class="cycle-monthly">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm line-through text-gray-400">14 OMR</span>
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 30%</span>
                        </div>
                        <span class="text-4xl font-bold text-gray-900">9.8</span>
                        <span class="text-lg font-semibold text-gray-500 ml-1">OMR</span>
                        <span class="text-sm text-gray-500"> / <?php echo e(__('landing.per_month')); ?></span>
                    </div>
                    <div class="cycle-yearly" style="display:none">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm line-through text-gray-400">14 OMR/mo</span>
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Save 35%</span>
                        </div>
                        <div class="flex items-end gap-2">
                            <span class="text-4xl font-bold text-gray-900">9.1</span>
                            <span class="text-lg font-semibold text-gray-500 mb-0.5">OMR / <?php echo e(__('landing.per_month')); ?></span>
                        </div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-sm text-gray-500">109.2 OMR <?php echo e(__('landing.per_year')); ?></span>
                        </div>
                    </div>
                </div>
                <ul class="space-y-2 mb-8">
                    <?php $__currentLoopData = ['plan_plus_f1','plan_plus_f2','plan_plus_f3','plan_plus_f4','plan_plus_f5']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fkey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center gap-2 text-sm text-gray-700">
                            <span class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                            <?php echo e(__("landing.{$fkey}")); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php if($isCurrent && !$licenseExpired): ?>
                    <button disabled class="w-full py-3 rounded-xl bg-gray-100 text-gray-500 font-semibold cursor-default">
                        <?php echo e(__('app.current_plan')); ?>

                    </button>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('admin.upgrade.initiate')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="plan" value="plus">
                        <input type="hidden" name="billing_cycle" class="cycle-input" value="monthly">
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold hover:shadow-lg transition">
                            <?php echo e($isCurrent && $licenseExpired ? '🔄 Reactivate Plus' : __('landing.plan_plus_cta')); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>

        </div>

        <p class="text-center text-sm text-gray-500 mt-8"><?php echo e(__('landing.plan_no_card')); ?></p>
    </div>

    <script>
        let currentCycle = 'monthly';

        function setCycle(cycle) {
            currentCycle = cycle;
            const isYearly = cycle === 'yearly';

            document.getElementById('btn-monthly').className = isYearly
                ? 'px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500'
                : 'px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900';
            document.getElementById('btn-yearly').className = isYearly
                ? 'px-6 py-2 rounded-lg font-medium text-sm transition bg-white shadow text-gray-900'
                : 'px-6 py-2 rounded-lg font-medium text-sm transition text-gray-500';

            document.querySelectorAll('.cycle-monthly').forEach(el => el.style.display = isYearly ? 'none' : 'block');
            document.querySelectorAll('.cycle-yearly').forEach(el => el.style.display = isYearly ? 'block' : 'none');
            const yearlyCaption = document.getElementById('yearly-caption');
            if (yearlyCaption) yearlyCaption.style.display = isYearly ? 'block' : 'none';
            document.querySelectorAll('.cycle-input').forEach(el => el.value = cycle);
        }

        <?php if(!empty($preselectedPlan) && in_array($preselectedPlan, ['pro', 'plus'])): ?>
        document.addEventListener('DOMContentLoaded', function () {
            const card = document.getElementById('plan-card-<?php echo e($preselectedPlan); ?>');
            if (card) {
                card.classList.add('ring-2', 'ring-blue-400');
                setTimeout(() => card.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
            }
        });
        <?php endif; ?>
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\booking-app\resources\views/admin/upgrade/index.blade.php ENDPATH**/ ?>