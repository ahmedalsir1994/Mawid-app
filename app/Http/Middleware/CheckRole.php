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

        // Support multiple roles separated by comma
        $allowedRoles = array_map('trim', explode(',', $role));
        
        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized. Required role: ' . $role . ', Your role: ' . auth()->user()->role);
        }

        return $next($request);
    }
}
