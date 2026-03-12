<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 520px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.07); }
        .header { background: linear-gradient(135deg, #16a34a, #15803d); padding: 36px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; font-weight: 700; margin: 0; letter-spacing: -0.3px; }
        .header p  { color: rgba(255,255,255,0.85); font-size: 14px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 16px; color: #374151; margin: 0 0 16px; }
        .message  { font-size: 14px; color: #6b7280; line-height: 1.7; margin: 0 0 24px; }
        .ref-box  { background: #f0fdf4; border: 2px dashed #16a34a; border-radius: 12px; text-align: center; padding: 20px; margin: 0 0 28px; }
        .ref-code { font-size: 28px; font-weight: 800; letter-spacing: 0.15em; color: #15803d; display: block; font-family: 'Courier New', monospace; }
        .ref-label{ font-size: 12px; color: #6b7280; margin-top: 4px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
        .details-table td { padding: 10px 12px; font-size: 14px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        .details-table td:first-child { color: #6b7280; font-weight: 500; width: 40%; white-space: nowrap; }
        .details-table td:last-child { color: #111827; font-weight: 600; }
        .branch-badge { display: inline-block; background: #eff6ff; color: #1d4ed8; border-radius: 6px; padding: 2px 10px; font-size: 13px; font-weight: 600; }
        .note-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #92400e; margin-bottom: 24px; }
        .footer-msg { font-size: 13px; color: #6b7280; border-top: 1px solid #f3f4f6; padding-top: 20px; line-height: 1.6; }
        .footer   { background: #f9fafb; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><?php echo e($business->name); ?></h1>
        <p>🎉 Your Booking is Confirmed!</p>
    </div>
    <div class="body">
        <p class="greeting">Hi <strong><?php echo e($booking->customer_name); ?></strong>,</p>
        <p class="message">
            Great news — your appointment has been confirmed. Here are your booking details:
        </p>

        <div class="ref-box">
            <span class="ref-code"><?php echo e($booking->reference_code); ?></span>
            <p class="ref-label">Booking Reference Number — keep this for your records</p>
        </div>

        <table class="details-table">
            <tr>
                <td>📋 Service</td>
                <td><?php echo e($booking->services_label); ?></td>
            </tr>
            <tr>
                <td>⏱ Duration</td>
                <td><?php echo e($booking->total_duration); ?> minutes</td>
            </tr>
            <tr>
                <td>📅 Date</td>
                <td><?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y')); ?></td>
            </tr>
            <tr>
                <td>🕐 Time</td>
                <td><?php echo e(substr($booking->start_time, 0, 5)); ?> – <?php echo e(substr($booking->end_time, 0, 5)); ?></td>
            </tr>
            <?php if($booking->staff): ?>
            <tr>
                <td>👤 Staff</td>
                <td><?php echo e($booking->staff->name); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($booking->branch): ?>
            <tr>
                <td>📍 Branch</td>
                <td>
                    <span class="branch-badge"><?php echo e($booking->branch->name); ?></span>
                    <?php if($booking->branch->address): ?>
                        <br><span style="font-size:12px;color:#6b7280;font-weight:400;"><?php echo e($booking->branch->address); ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php elseif($business->address): ?>
            <tr>
                <td>📍 Location</td>
                <td><?php echo e($business->address); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($booking->customer_notes): ?>
            <tr>
                <td>📝 Notes</td>
                <td><?php echo e($booking->customer_notes); ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if($booking->branch && $booking->branch->phone): ?>
        <div class="note-box">
            📞 Branch contact: <strong><?php echo e($booking->branch->phone); ?></strong>
        </div>
        <?php elseif($business->phone): ?>
        <div class="note-box">
            📞 Contact us: <strong><?php echo e($business->phone); ?></strong>
        </div>
        <?php endif; ?>

        <p class="footer-msg">
            Need to reschedule or cancel? Please contact us as soon as possible.
            We look forward to seeing you! 😊
        </p>
    </div>
    <div class="footer">
        © <?php echo e(date('Y')); ?> <?php echo e($business->name); ?> · Powered by <?php echo e(config('app.name')); ?>

    </div>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/emails/booking-confirmation.blade.php ENDPATH**/ ?>