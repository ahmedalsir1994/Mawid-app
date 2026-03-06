@component('mail::message')
# ✅ Subscription Renewed Successfully

Hi **{{ $user->name }}**,

Your **Mawid {{ ucfirst($invoice->plan) }} plan** has been automatically renewed.

@component('mail::panel')
**Invoice:** {{ $invoice->invoice_number }}
**Plan:** {{ ucfirst($invoice->plan) }} ({{ ucfirst($invoice->billing_cycle) }})
**Amount:** {{ number_format($invoice->amount, 3) }} {{ $invoice->currency ?? 'OMR' }}
**Date:** {{ ($invoice->paid_at ?? $invoice->created_at)->format('d M Y') }}
@if($invoice->billing_period_start && $invoice->billing_period_end)
**Period:** {{ $invoice->billing_period_start->format('d M Y') }} – {{ $invoice->billing_period_end->format('d M Y') }}
@endif
@endcomponent

A PDF copy of your invoice is attached to this email.

@component('mail::button', ['url' => $billingUrl, 'color' => 'green'])
View Billing & Invoices
@endcomponent

If you have any questions or did not expect this charge, please contact us at [mawidoman@gmail.com](mailto:mawidoman@gmail.com).

Thanks,
**Mawid Team**
@endcomponent
