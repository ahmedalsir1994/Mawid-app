<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Super admin can access any role-gated route
        if (auth()->user()->role === 'super_admin') {
            return $next($request);
        }

        // Support multiple roles separated by comma
        $allowedRoles = array_map('trim', explode(',', $role));
        
        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403);
        }

        return $next($request);
    }
}
