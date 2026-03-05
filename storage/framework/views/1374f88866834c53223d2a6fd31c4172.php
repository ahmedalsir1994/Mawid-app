<?php $__env->startComponent('mail::message'); ?>
# ⚠️ Subscription Auto-Renewal Failed

Hi **<?php echo e($notifiable->name); ?>**,

We were unable to automatically renew your **<?php echo e($plan); ?> plan** subscription on **<?php echo e(now()->format('d M Y')); ?>**.

**Reason:** <?php echo e($reason); ?>


<?php if($attempt >= 3): ?>
> ⚠️ This was the 3rd failed attempt. Auto-renewal has been **disabled**. Please renew manually to avoid service interruption.
<?php else: ?>
> We will try again. Attempt **<?php echo e($attempt); ?> of 3**.
<?php endif; ?>

Please update your payment method to ensure uninterrupted access:

<?php $__env->startComponent('mail::button', ['url' => $billingUrl, 'color' => 'green']); ?>
Go to Billing
<?php echo $__env->renderComponent(); ?>

If you believe this is an error, please contact us at [support@mawid.app](mailto:support@mawid.app).

Thanks,
**Mawid Team**
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\booking-app\resources\views\emails\auto-renew-failed.blade.php ENDPATH**/ ?>