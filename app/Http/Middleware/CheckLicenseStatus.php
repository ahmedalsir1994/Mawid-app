<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLicenseStatus
{
    /**
     * Routes always accessible regardless of license status
     * (billing/upgrade/logout so admins can always pay or reactivate).
     */
    private const ALWAYS_ALLOWED = [
        'admin.billing.index',
        'admin.billing.invoice',
        'admin.billing.invoice.download',
        'admin.billing.update-card',
        'admin.billing.retry-payment',
        'admin.billing.cancel',
        'admin.billing.remove-payment-method',
        'admin.upgrade.index',
        'admin.upgrade.initiate',
        'admin.upgrade.autopay',
        'admin.company.dashboard',
        'admin.business.edit',
        'admin.business.update',
        'admin.working_hours.edit',
        'admin.working_hours.update',
        'paymob.callback',
        'paymob.return',
        'logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        // Only applies to authenticated company admins
        if (!$user || $user->role === 'super_admin') {
            return $next($request);
        }

        // Ensure user has a business
        if (!$user->business_id || !$user->business) {
            return redirect()->route('profile.edit')
                ->with('error', 'No business associated with your account.');
        }

        $license = $user->business?->license;

        // No license, or license is active / still in grace period — pass through
        if (!$license || $license->isActive()) {
            return $next($request);
        }

        $routeName = $request->route()?->getName() ?? '';

        // Billing and upgrade routes always allowed so the admin can pay
        if (in_array($routeName, self::ALWAYS_ALLOWED, true)) {
            return $next($request);
        }

        // Suspended or cancelled: block all write operations, redirect to billing
        if (in_array($license->status, ['suspended', 'cancelled'], true)) {
            if ($request->isMethod('GET')) {
                return $next($request);
            }
            return redirect()->route('admin.billing.index')
                ->with('error', 'Your account is ' . $license->status . '. Please update your billing to continue.');
        }

        // Expired / past_due outside grace: pass through.
        // Individual controllers call canAdd*() which now reflect the soft-downgraded
        // free-plan caps, so write limits are enforced there.
        return $next($request);
    }
}
