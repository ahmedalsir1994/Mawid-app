<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 480px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.07); }
        .header { background: linear-gradient(135deg, #16a34a, #15803d); padding: 36px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; font-weight: 700; margin: 0; letter-spacing: -0.3px; }
        .header p  { color: rgba(255,255,255,0.8); font-size: 14px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 16px; color: #374151; margin: 0 0 16px; }
        .message  { font-size: 14px; color: #6b7280; line-height: 1.7; margin: 0 0 28px; }
        .otp-box  { background: #f0fdf4; border: 2px dashed #16a34a; border-radius: 12px; text-align: center; padding: 24px 20px; margin: 0 0 28px; }
        .otp-code { font-size: 44px; font-weight: 800; letter-spacing: 0.18em; color: #15803d; display: block; font-family: 'Courier New', monospace; }
        .otp-label{ font-size: 12px; color: #6b7280; margin-top: 6px; }
        .expiry   { font-size: 13px; color: #6b7280; background: #fefce8; border: 1px solid #fde68a; border-radius: 8px; padding: 10px 14px; margin-bottom: 24px; }
        .expiry strong { color: #92400e; }
        .warning  { font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 20px; line-height: 1.6; }
        .footer   { background: #f9fafb; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><?php echo e(config('app.name')); ?></h1>
        <p>Email Verification</p>
    </div>
    <div class="body">
        <p class="greeting">Hi <strong><?php echo e($userName); ?></strong>,</p>
        <p class="message">
            You're almost there! Enter the verification code below in the app to activate your account.
        </p>

        <div class="otp-box">
            <span class="otp-code"><?php echo e($otp); ?></span>
            <p class="otp-label">Your one-time verification code</p>
        </div>

        <div class="expiry">
            ⏰ This code will expire in <strong>10 minutes</strong>.
            If it expires, you can request a new one from the verification page.
        </div>

        <p class="warning">
            If you didn't create an account with <?php echo e(config('app.name')); ?>, you can safely ignore this email.
            Do not share this code with anyone.
        </p>
    </div>
    <div class="footer">
        © <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.
    </div>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views/emails/otp-verification.blade.php ENDPATH**/ ?>