<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #1f2937; font-size: 13px; margin: 0; padding: 0; }
        .container { padding: 40px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .header-left h2 { font-size: 22px; font-weight: bold; color: #16a34a; margin: 0 0 4px; }
        .header-right { text-align: right; }
        .header-right h1 { font-size: 28px; font-weight: bold; color: #111827; margin: 0; }
        .header-right .inv-num { font-size: 16px; color: #6b7280; font-family: monospace; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: bold; }
        .badge-paid    { background: #d1fae5; color: #065f46; }
        .badge-pending { background: #fef9c3; color: #78350f; }
        .badge-failed  { background: #fee2e2; color: #991b1b; }
        .two-col { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .two-col-right { text-align: right; }
        .label { font-size: 10px; font-weight: bold; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; }
        .biz-name { font-size: 18px; font-weight: bold; color: #111827; }
        .biz-email { color: #6b7280; font-size: 12px; }
        .detail-row { display: flex; justify-content: flex-end; gap: 20px; font-size: 12px; margin-bottom: 3px; }
        .detail-label { color: #9ca3af; }
        .detail-val { font-weight: 600; color: #111827; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        thead tr { border-bottom: 2px solid #e5e7eb; }
        thead th { padding-bottom: 10px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #9ca3af; letter-spacing: .05em; }
        thead th:last-child { text-align: right; }
        tbody tr { border-bottom: 1px solid #f3f4f6; }
        tbody td { padding: 14px 0; color: #1f2937; }
        tbody td:last-child { text-align: right; font-weight: 600; }
        .item-name { font-weight: 600; font-size: 14px; }
        .item-period { font-size: 11px; color: #9ca3af; margin-top: 2px; }
        .totals { display: flex; justify-content: flex-end; margin-bottom: 40px; }
        .totals-inner { width: 240px; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 6px; color: #6b7280; }
        .total-final { display: flex; justify-content: space-between; font-size: 15px; font-weight: bold; color: #111827; border-top: 1px solid #e5e7eb; padding-top: 8px; margin-top: 8px; }
        .footer { border-top: 1px solid #f3f4f6; padding-top: 20px; text-align: center; font-size: 11px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h2>Mawid</h2>
            <div style="color:#6b7280; font-size:12px;">mawid.app</div>
            <div style="color:#6b7280; font-size:12px;">support@mawid.app</div>
        </div>
        <div class="header-right">
            <h1>INVOICE</h1>
            <div class="inv-num">{{ $invoice->invoice_number }}</div>
            @php
                $badgeClass = match($invoice->status) {
                    'paid'    => 'badge-paid',
                    'pending' => 'badge-pending',
                    'failed'  => 'badge-failed',
                    default   => '',
                };
            @endphp
            <div style="margin-top:8px;">
                <span class="badge {{ $badgeClass }}">{{ strtoupper($invoice->status) }}</span>
            </div>
        </div>
    </div>

    <!-- Billing Info -->
    <div class="two-col">
        <div>
            <div class="label">Billed To</div>
            <div class="biz-name">{{ $invoice->business_name }}</div>
            @if($invoice->business_email)
                <div class="biz-email">{{ $invoice->business_email }}</div>
            @endif
        </div>
        <div class="two-col-right">
            <div class="label">Invoice Details</div>
            @if($invoice->paid_at)
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-val">{{ $invoice->paid_at->format('d M Y') }}</span>
                </div>
            @endif
            @if($invoice->billing_period_start && $invoice->billing_period_end)
                <div class="detail-row">
                    <span class="detail-label">Period:</span>
                    <span class="detail-val">{{ $invoice->billing_period_start->format('d M Y') }} – {{ $invoice->billing_period_end->format('d M Y') }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Line Items -->
    <table>
        <thead>
            <tr>
                <th style="text-align:left;">Description</th>
                <th style="text-align:center;">Billing Cycle</th>
                <th style="text-align:right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="item-name">Mawid {{ ucfirst($invoice->plan) }} Plan</div>
                    @if($invoice->billing_period_start && $invoice->billing_period_end)
                        <div class="item-period">
                            {{ $invoice->billing_period_start->format('d M Y') }} – {{ $invoice->billing_period_end->format('d M Y') }}
                        </div>
                    @endif
                </td>
                <td style="text-align:center; color:#6b7280;">{{ ucfirst($invoice->billing_cycle ?? '—') }}</td>
                <td>{{ number_format($invoice->amount, 3) }} {{ $invoice->currency ?? 'OMR' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        <div class="totals-inner">
            <div class="total-row">
                <span>Subtotal</span>
                <span>{{ number_format($invoice->amount, 3) }} {{ $invoice->currency ?? 'OMR' }}</span>
            </div>
            <div class="total-row">
                <span>VAT (0%)</span>
                <span>0.000 {{ $invoice->currency ?? 'OMR' }}</span>
            </div>
            <div class="total-final">
                <span>Total</span>
                <span>{{ number_format($invoice->amount, 3) }} {{ $invoice->currency ?? 'OMR' }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Thank you for your business! Questions? Contact us at support@mawid.app
    </div>
</div>
</body>
</html>
