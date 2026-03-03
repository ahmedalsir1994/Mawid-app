<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message — Mawid</title>
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
        .message-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px 20px; margin-top: 8px; }
        .message-box p { margin: 0; font-size: 14px; color: #374151; line-height: 1.7; white-space: pre-wrap; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }
        .btn { display: inline-block; padding: 12px 28px; background: #16a34a; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { margin: 0; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>📬 New Contact Message</h1>
            <p>Someone submitted the contact form on Mawid</p>
        </div>
        <div class="body">
            <div class="alert-box">
                <p>You have a new contact submission — please respond promptly.</p>
            </div>

            <div class="field">
                <div class="field-label">Full Name</div>
                <div class="field-value"><?php echo e($submission->name); ?></div>
            </div>

            <div class="field">
                <div class="field-label">Email Address</div>
                <div class="field-value"><a href="mailto:<?php echo e($submission->email); ?>"><?php echo e($submission->email); ?></a></div>
            </div>

            <div class="field">
                <div class="field-label">Phone Number</div>
                <div class="field-value"><a href="tel:<?php echo e($submission->phone); ?>"><?php echo e($submission->phone); ?></a></div>
            </div>

            <?php if($submission->subject): ?>
            <div class="field">
                <div class="field-label">Subject</div>
                <div class="field-value"><?php echo e($submission->subject); ?></div>
            </div>
            <?php endif; ?>

            <div class="field">
                <div class="field-label">Message</div>
                <div class="message-box">
                    <p><?php echo e($submission->message); ?></p>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Submitted At</div>
                <div class="field-value"><?php echo e($submission->created_at->format('D, d M Y — H:i')); ?> (server time)</div>
            </div>

            <hr class="divider">

            <p style="font-size:13px; color:#6b7280; margin:0 0 20px;">
                Reply directly to this email or click the button below to review all submissions in your dashboard.
            </p>
            <a href="<?php echo e(url('/admin/contact-submissions')); ?>" class="btn">View in Dashboard</a>
        </div>
        <div class="footer">
            <p>Mawid — Smart Booking Platform · Muscat, Oman · <a href="mailto:ahmedsecret94@gmail.com" style="color:#16a34a;">ahmedsecret94@gmail.com</a></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views\emails\contact-submission.blade.php ENDPATH**/ ?>