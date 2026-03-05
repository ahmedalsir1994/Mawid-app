<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New License Created — Mawid</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1e1b4b 0%, #7c3aed 100%); padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 22px; margin: 0; font-weight: 700; }
        .header p { color: #ddd6fe; font-size: 13px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .alert-box { background: #f5f3ff; border-left: 4px solid #7c3aed; border-radius: 6px; padding: 16px 20px; margin-bottom: 28px; }
        .alert-box p { margin: 0; color: #4c1d95; font-size: 14px; font-weight: 600; }
        .field { margin-bottom: 20px; }
        .field-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280; margin-bottom: 4px; }
        .field-value { font-size: 15px; color: #111827; font-weight: 500; }
        .field-value a { color: #7c3aed; text-decoration: none; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge-free   { background: #f3f4f6; color: #374151; }
        .badge-pro    { background: #dbeafe; color: #1e40af; }
        .badge-plus   { background: #ede9fe; color: #5b21b6; }
        .badge-paid   { background: #d1fae5; color: #065f46; }
        .badge-unpaid { background: #fff7ed; color: #92400e; }
        .code { background: #f3f4f6; padding: 4px 10px; border-radius: 5px; font-family: monospace; font-size: 13px; color: #111827; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }
        .btn { display: inline-block; padding: 12px 28px; background: #7c3aed; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { margin: 0; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>🔑 New License Created</h1>
            <p>A new license has been issued on Mawid</p>
        </div>
        <div class="body">
            <div class="alert-box">
                <p>A new license was just created. Review the details below.</p>
            </div>

            <div class="field">
                <div class="field-label">Business</div>
                <div class="field-value"><?php echo e($business->name ?? '—'); ?></div>
            </div>

            <div class="field">
                <div class="field-label">License Key</div>
                <div class="field-value"><span class="code"><?php echo e($license->license_key); ?></span></div>
            </div>

            <div class="field">
                <div class="field-label">Plan</div>
                <div class="field-value">
                    <?php
                        $emoji = match($license->plan) { 'pro'=>'💼','plus'=>'🚀',default=>'🆓' };
                        $badgeClass = match($license->plan) { 'pro'=>'badge-pro','plus'=>'badge-plus',default=>'badge-free' };
                    ?>
                    <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($emoji); ?> <?php echo e(ucfirst($license->plan)); ?></span>
                    &nbsp;
                    <span style="font-size:13px;color:#6b7280;"><?php echo e(ucfirst($license->billing_cycle)); ?></span>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Payment Status</div>
                <div class="field-value">
                    <span class="badge <?php echo e($license->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid'); ?>">
                        <?php echo e(ucfirst($license->payment_status)); ?>

                    </span>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Price</div>
                <div class="field-value">$<?php echo e(number_format($license->price, 2)); ?></div>
            </div>

            <div class="field">
                <div class="field-label">Expires At</div>
                <div class="field-value">
                    <?php echo e($license->expires_at ? $license->expires_at->format('M d, Y') : 'Never'); ?>

                </div>
            </div>

            <div class="field">
                <div class="field-label">Created At</div>
                <div class="field-value"><?php echo e($license->created_at->format('M d, Y — H:i')); ?></div>
            </div>

            <hr class="divider">

            <p style="text-align:center;">
                <a href="<?php echo e($url); ?>" class="btn">View License in Dashboard</a>
            </p>
        </div>
        <div class="footer">
            <p><?php echo e(config('app.name')); ?> · Super Admin Alert · <?php echo e(now()->format('Y')); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views\emails\super-admin\new-license.blade.php ENDPATH**/ ?>