@component('mail::message')
# ⚠️ Subscription Auto-Renewal Failed

Hi **{{ $notifiable->name }}**,

We were unable to automatically renew your **{{ $plan }} plan** subscription on **{{ now()->format('d M Y') }}**.

**Reason:** {{ $reason }}

@if($attempt >= 3)
> ⚠️ This was the 3rd failed attempt. Auto-renewal has been **disabled**. Please renew manually to avoid service interruption.
@else
> We will try again. Attempt **{{ $attempt }} of 3**.
@endif

Please update your payment method to ensure uninterrupted access:

@component('mail::button', ['url' => $billingUrl, 'color' => 'green'])
Go to Billing
@endcomponent

If you believe this is an error, please contact us at [support@mawid.app](mailto:support@mawid.app).

Thanks,
**Mawid Team**
@endcomponent
