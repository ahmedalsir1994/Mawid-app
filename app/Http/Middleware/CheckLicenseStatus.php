<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLicenseStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Skip check for super admins (they don't have a business/license)
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // Check if user has a business
        if (!$user->business_id || !$user->business) {
            return redirect()->route('profile.edit')
                ->with('error', 'No business associated with your account.');
        }

        $business = $user->business;
        $license = $business->license;

        // Check if license exists and is active
        if (!$license || !$license->isActive()) {
            return redirect()->route('admin.license.suspended')
                ->with('error', 'Your license is ' . ($license ? $license->status : 'missing') . '. Please contact support to reactivate.');
        }

        return $next($request);
    }
}
