<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We received your message — Mawid</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #000000 0%, #0ba83a 100%); padding: 36px 40px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 24px; margin: 0; font-weight: 700; }
        .header p { color: #bbf7d0; font-size: 13px; margin: 8px 0 0; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 17px; color: #111827; font-weight: 600; margin: 0 0 12px; }
        .intro { font-size: 14px; color: #4b5563; line-height: 1.7; margin: 0 0 28px; }
        .summary-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 20px 24px; margin-bottom: 28px; }
        .summary-box h3 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #16a34a; margin: 0 0 14px; }
        .field { margin-bottom: 12px; }
        .field-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; margin-bottom: 2px; }
        .field-value { font-size: 14px; color: #111827; }
        .message-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 18px; margin-top: 6px; }
        .message-box p { margin: 0; font-size: 13px; color: #374151; line-height: 1.7; white-space: pre-wrap; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }
        .note { font-size: 13px; color: #6b7280; line-height: 1.7; margin: 0 0 24px; }
        .btn { display: inline-block; padding: 12px 28px; background: #16a34a; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { margin: 0; font-size: 12px; color: #9ca3af; }
        .footer a { color: #16a34a; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>✅ Message Received</h1>
            <p>Thank you for reaching out to Mawid</p>
        </div>
        <div class="body">
            <p class="greeting">Hi <?php echo e($submission->name); ?>,</p>
            <p class="intro">
                Thank you for contacting us! We have received your message and our team will get back to you as soon as possible, typically within 1–2 business days.
            </p>

            <!-- Summary of what they sent -->
            <div class="summary-box">
                <h3>Your Submission Summary</h3>

                <?php if($submission->subject): ?>
                <div class="field">
                    <div class="field-label">Subject</div>
                    <div class="field-value"><?php echo e($submission->subject); ?></div>
                </div>
                <?php endif; ?>

                <div class="field">
                    <div class="field-label">Your Message</div>
                    <div class="message-box">
                        <p><?php echo e($submission->message); ?></p>
                    </div>
                </div>

                <div class="field" style="margin-top:14px; margin-bottom:0;">
                    <div class="field-label">Submitted At</div>
                    <div class="field-value" style="font-size:13px; color:#6b7280;"><?php echo e($submission->created_at->format('D, d M Y — H:i')); ?></div>
                </div>
            </div>

            <hr class="divider">

            <p class="note">
                If you have any additional information to share, or if this message was sent by mistake, please reply directly to this email.
            </p>

            <a href="<?php echo e(url('/contact')); ?>" class="btn">Visit Our Website</a>
        </div>
        <div class="footer">
            <p>© <?php echo e(date('Y')); ?> <a href="<?php echo e(url('/')); ?>">Mawid</a> — Booking made simple.</p>
            <p style="margin-top:6px;">This is an automated confirmation. Please do not reply directly to this email for urgent matters.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views\emails\contact-confirmation.blade.php ENDPATH**/ ?>