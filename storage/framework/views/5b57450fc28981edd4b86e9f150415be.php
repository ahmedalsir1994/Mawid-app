<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?php echo e(config('app.name')); ?></title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 520px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.07); }
        .header { background: linear-gradient(135deg, #16a34a, #15803d); padding: 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 24px; font-weight: 700; margin: 0 0 6px; }
        .header p  { color: rgba(255,255,255,0.85); font-size: 14px; margin: 0; }
        .badge { display: inline-block; margin-top: 16px; background: rgba(255,255,255,0.2); color: #fff; font-size: 13px; font-weight: 600; padding: 5px 16px; border-radius: 999px; letter-spacing: 0.5px; }
        .body { padding: 40px; }
        .greeting { font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 12px; }
        .message  { font-size: 15px; color: #4b5563; line-height: 1.7; margin: 0 0 28px; }
        .plan-box { background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 12px; padding: 20px 24px; margin-bottom: 28px; }
        .plan-box .plan-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; color: #15803d; margin: 0 0 4px; }
        .plan-box .plan-name  { font-size: 22px; font-weight: 800; color: #166534; margin: 0; }
        .plan-box .plan-sub   { font-size: 13px; color: #4b5563; margin: 4px 0 0; }
        .steps { margin-bottom: 28px; }
        .steps h3 { font-size: 14px; font-weight: 700; color: #374151; margin: 0 0 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .step { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
        .step-num { width: 26px; height: 26px; background: #16a34a; color: #fff; border-radius: 50%; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .step-text { font-size: 14px; color: #4b5563; padding-top: 4px; }
        .cta-btn { display: block; width: fit-content; margin: 0 auto 28px; background: #16a34a; color: #fff; text-decoration: none; font-weight: 700; font-size: 15px; padding: 14px 32px; border-radius: 10px; text-align: center; }
        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 0 0 24px; }
        .note { font-size: 13px; color: #9ca3af; line-height: 1.6; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Welcome to <?php echo e(config('app.name')); ?>! 🎉</h1>
        <p>Your account is ready. Let's get started.</p>
        <?php if($plan !== 'free'): ?>
            <span class="badge"><?php echo e(ucfirst($plan)); ?> Plan Activated</span>
        <?php endif; ?>
    </div>

    <div class="body">
        <p class="greeting">Hi <?php echo e($user->name); ?>,</p>
        <p class="message">
            <?php if($pendingPayment): ?>
                Your email has been verified. You'll be redirected to complete your <?php echo e(ucfirst($plan)); ?> plan payment — once that's done, you'll have full access to everything.
            <?php elseif($plan !== 'free'): ?>
                Your payment was successful and your <strong><?php echo e(ucfirst($plan)); ?> plan</strong> is now active. Your account is fully set up and ready to go!
            <?php else: ?>
                Your email has been verified and your account is now active. You're on the <strong>Free plan</strong> — you can upgrade anytime from your dashboard.
            <?php endif; ?>
        </p>

        <!-- Plan box -->
        <div class="plan-box">
            <p class="plan-label">Your current plan</p>
            <p class="plan-name">
                <?php if($plan === 'free'): ?> 🆓 Free
                <?php elseif($plan === 'pro'): ?> 💼 Pro
                <?php else: ?> 🚀 Plus
                <?php endif; ?>
            </p>
            <p class="plan-sub">
                <?php if($plan === 'free'): ?> 1 branch · 1 staff · up to 3 services
                <?php elseif($plan === 'pro'): ?> 1 branch · up to 3 staff · up to 15 services
                <?php else: ?> 3 branches · up to 15 staff · unlimited services
                <?php endif; ?>
            </p>
        </div>

        <?php if(!$pendingPayment): ?>
        <!-- Quick-start steps -->
        <div class="steps">
            <h3>Get started in 3 steps</h3>
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">Complete your <strong>business profile</strong> — add your logo, address, and contact info.</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">Add your <strong>services</strong> with pricing and duration.</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">Share your <strong>booking page link</strong> with customers and start accepting bookings.</div>
            </div>
        </div>

        <a href="<?php echo e(route('admin.dashboard')); ?>" class="cta-btn">Go to Dashboard →</a>
        <?php endif; ?>

        <hr class="divider">
        <p class="note">
            If you didn't create this account, please ignore this email or
            <a href="mailto:<?php echo e(config('mail.from.address')); ?>" style="color:#16a34a;">contact support</a>.
        </p>
    </div>

    <div class="footer">
        © <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.
    </div>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views/emails/welcome.blade.php ENDPATH**/ ?>