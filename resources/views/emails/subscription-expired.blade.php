@component('mail::message')
# Your subscription has expired

Hi **{{ $admin->name }}**,

Your **{{ ucfirst($license->plan) }}** subscription for **{{ $license->business->name }}** has expired.

**Your data is completely safe** — all your services, branches, staff accounts, and booking history are preserved.

However, your account has been automatically downgraded to the **Free plan** limits:

- ✅ 1 Branch
- ✅ 1 Staff account
- ✅ Up to 3 Services
- ✅ Up to 25 bookings/month

Resources beyond these limits are still stored but will not accept new bookings or be available to customers until you upgrade.

@component('mail::button', ['url' => route('admin.upgrade.index'), 'color' => 'primary'])
Upgrade to Restore Full Access
@endcomponent

You can upgrade at any time and your data will be immediately fully restored at your previous capacity.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
