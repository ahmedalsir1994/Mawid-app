<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;



class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority 1: User's session preference (from language switcher)
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (in_array($locale, ['en', 'ar'])) {
                app()->setLocale($locale);
                return $next($request);
            }
        }

        // Priority 2: Business default language
        if (Auth::check() && Auth::user()->business) {
            app()->setLocale(Auth::user()->business->default_language);
        }

        return $next($request);
    }
}