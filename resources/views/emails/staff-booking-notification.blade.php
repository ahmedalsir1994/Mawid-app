<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 520px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.07); }
        .header { background: linear-gradient(135deg, #1d4ed8, #2563eb); padding: 36px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; font-weight: 700; margin: 0; letter-spacing: -0.3px; }
        .header p  { color: rgba(255,255,255,0.85); font-size: 14px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 16px; color: #374151; margin: 0 0 16px; }
        .ref-box  { background: #eff6ff; border: 2px dashed #2563eb; border-radius: 12px; text-align: center; padding: 16px 20px; margin: 0 0 24px; }
        .ref-code { font-size: 24px; font-weight: 800; letter-spacing: 0.12em; color: #1d4ed8; display: block; font-family: 'Courier New', monospace; }
        .ref-label{ font-size: 12px; color: #6b7280; margin-top: 4px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .details-table td { padding: 10px 12px; font-size: 14px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        .details-table td:first-child { color: #6b7280; font-weight: 500; width: 40%; white-space: nowrap; }
        .details-table td:last-child { color: #111827; font-weight: 600; }
        .branch-badge { display: inline-block; background: #eff6ff; color: #1d4ed8; border-radius: 6px; padding: 2px 10px; font-size: 13px; font-weight: 600; }
        .cta { display: block; text-align: center; background: #1d4ed8; color: #fff; text-decoration: none; padding: 14px 28px; border-radius: 10px; font-weight: 700; font-size: 15px; margin-bottom: 24px; }
        .note { font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 20px; line-height: 1.6; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $business->name }}</h1>
        <p>📅 New Booking Received</p>
    </div>
    <div class="body">
        <p class="greeting">Hi <strong>{{ $recipient->name }}</strong>,</p>

        <div class="ref-box">
            <span class="ref-code">{{ $booking->reference_code }}</span>
            <p class="ref-label">Booking Reference</p>
        </div>

        <table class="details-table">
            <tr>
                <td>👤 Customer</td>
                <td>{{ $booking->customer_name }}</td>
            </tr>
            <tr>
                <td>📞 Phone</td>
                <td>{{ $booking->customer_phone }}</td>
            </tr>
            @if($booking->customer_email)
            <tr>
                <td>✉️ Email</td>
                <td>{{ $booking->customer_email }}</td>
            </tr>
            @endif
            <tr>
                <td>📋 Service</td>
                <td>{{ $booking->services_label }} ({{ $booking->total_duration }} min)</td>
            </tr>
            <tr>
                <td>📅 Date</td>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</td>
            </tr>
            <tr>
                <td>🕐 Time</td>
                <td>{{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}</td>
            </tr>
            @if($booking->branch)
            <tr>
                <td>📍 Branch</td>
                <td>
                    <span class="branch-badge">{{ $booking->branch->name }}</span>
                    @if($booking->branch->address)
                        <br><span style="font-size:12px;color:#6b7280;font-weight:400;">{{ $booking->branch->address }}</span>
                    @endif
                </td>
            </tr>
            @endif
            @if($booking->customer_notes)
            <tr>
                <td>📝 Notes</td>
                <td>{{ $booking->customer_notes }}</td>
            </tr>
            @endif
        </table>

        <p class="note">
            This booking was just confirmed. Please ensure you are available at the scheduled time.
            You can manage this booking from your dashboard.
        </p>
    </div>
    <div class="footer">
        © {{ date('Y') }} {{ $business->name }} · Powered by {{ config('app.name') }}
    </div>
</div>
</body>
</html>
