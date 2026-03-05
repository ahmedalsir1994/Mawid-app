<?php $__env->startComponent('mail::message'); ?>
# Payment Failed – Action Required

Hi **<?php echo e($user->name); ?>**,

We were unable to process your payment for your **Mawid <?php echo e(ucfirst($license->plan)); ?>** subscription.

> <?php echo e($reason); ?>


---

<?php $__env->startComponent('mail::panel'); ?>
**Your account is in a grace period.**
You have **<?php echo e($graceDaysLeft); ?> day(s)** to update your payment method before your account is restricted.
<?php if($graceEndsAt): ?>
Grace period ends: **<?php echo e(\Carbon\Carbon::parse($graceEndsAt)->format('d M Y')); ?>**
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>

---

### What happens if I don't update my card?

- After the grace period ends, your account will be **downgraded to the Free plan**
- Your data and bookings will remain safe
- You can re-subscribe at any time

### How to fix this

<?php $__env->startComponent('mail::button', ['url' => $updateCardUrl, 'color' => 'blue']); ?>
Update Payment Method
<?php echo $__env->renderComponent(); ?>

If you believe this is a mistake or need help, please contact our support team.

Thanks,
**The Mawid Team**

---
<small>You are receiving this because you have an active Mawid subscription. If you have already updated your card, please ignore this email.</small>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\booking-app\resources\views\emails\payment-failed.blade.php ENDPATH**/ ?>