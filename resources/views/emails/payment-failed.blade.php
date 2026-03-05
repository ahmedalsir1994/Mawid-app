@component('mail::message')
# Payment Failed – Action Required

Hi **{{ $user->name }}**,

We were unable to process your payment for your **Mawid {{ ucfirst($license->plan) }}** subscription.

> {{ $reason }}

---

@component('mail::panel')
**Your account is in a grace period.**
You have **{{ $graceDaysLeft }} day(s)** to update your payment method before your account is restricted.
@if($graceEndsAt)
Grace period ends: **{{ \Carbon\Carbon::parse($graceEndsAt)->format('d M Y') }}**
@endif
@endcomponent

---

### What happens if I don't update my card?

- After the grace period ends, your account will be **downgraded to the Free plan**
- Your data and bookings will remain safe
- You can re-subscribe at any time

### How to fix this

@component('mail::button', ['url' => $updateCardUrl, 'color' => 'blue'])
Update Payment Method
@endcomponent

If you believe this is a mistake or need help, please contact our support team.

Thanks,
**The Mawid Team**

---
<small>You are receiving this because you have an active Mawid subscription. If you have already updated your card, please ignore this email.</small>
@endcomponent
