<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registered — Mawid</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #000000 0%, #0ba83a 100%); padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 22px; margin: 0; font-weight: 700; }
        .header p { color: #bbf7d0; font-size: 13px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .alert-box { background: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 6px; padding: 16px 20px; margin-bottom: 28px; }
        .alert-box p { margin: 0; color: #166534; font-size: 14px; font-weight: 600; }
        .field { margin-bottom: 20px; }
        .field-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280; margin-bottom: 4px; }
        .field-value { font-size: 15px; color: #111827; font-weight: 500; }
        .field-value a { color: #16a34a; text-decoration: none; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }
        .btn { display: inline-block; padding: 12px 28px; background: #16a34a; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { margin: 0; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>🆕 New User Registered</h1>
            <p>A new business owner just signed up on Mawid</p>
        </div>
        <div class="body">
            <div class="alert-box">
                <p>A new account has been created. Review the details below.</p>
            </div>

            <div class="field">
                <div class="field-label">Full Name</div>
                <div class="field-value"><?php echo e($user->name); ?></div>
            </div>

            <div class="field">
                <div class="field-label">Email Address</div>
                <div class="field-value"><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></div>
            </div>

            <div class="field">
                <div class="field-label">Business Name</div>
                <div class="field-value"><?php echo e($business->name); ?></div>
            </div>

            <div class="field">
                <div class="field-label">Business Slug / Public URL</div>
                <div class="field-value">
                    <a href="<?php echo e(route('public.business', $business->slug)); ?>">
                        <?php echo e(route('public.business', $business->slug)); ?>

                    </a>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Registered At</div>
                <div class="field-value"><?php echo e($user->created_at->format('M d, Y — H:i')); ?></div>
            </div>

            <hr class="divider">

            <p style="text-align:center;">
                <a href="<?php echo e($url); ?>" class="btn">View User in Dashboard</a>
            </p>
        </div>
        <div class="footer">
            <p><?php echo e(config('app.name')); ?> · Super Admin Alert · <?php echo e(now()->format('Y')); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views/emails/super-admin/new-user.blade.php ENDPATH**/ ?>