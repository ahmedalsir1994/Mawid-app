<?php $__env->startComponent('mail::message'); ?>
# ✅ Subscription Renewed Successfully

Hi **<?php echo e($user->name); ?>**,

Your **Mawid <?php echo e(ucfirst($invoice->plan)); ?> plan** has been automatically renewed.

<?php $__env->startComponent('mail::panel'); ?>
**Invoice:** <?php echo e($invoice->invoice_number); ?>

**Plan:** <?php echo e(ucfirst($invoice->plan)); ?> (<?php echo e(ucfirst($invoice->billing_cycle)); ?>)
**Amount:** <?php echo e(number_format($invoice->amount, 3)); ?> <?php echo e($invoice->currency ?? 'OMR'); ?>

**Date:** <?php echo e(($invoice->paid_at ?? $invoice->created_at)->format('d M Y')); ?>

<?php if($invoice->billing_period_start && $invoice->billing_period_end): ?>
**Period:** <?php echo e($invoice->billing_period_start->format('d M Y')); ?> – <?php echo e($invoice->billing_period_end->format('d M Y')); ?>

<?php endif; ?>
<?php echo $__env->renderComponent(); ?>

A PDF copy of your invoice is attached to this email.

<?php $__env->startComponent('mail::button', ['url' => $billingUrl, 'color' => 'green']); ?>
View Billing & Invoices
<?php echo $__env->renderComponent(); ?>

If you have any questions or did not expect this charge, please contact us at [support@mawid.app](mailto:support@mawid.app).

Thanks,
**Mawid Team**
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\booking-app\resources\views\emails\subscription-renewed.blade.php ENDPATH**/ ?>