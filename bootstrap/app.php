<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies + all forwarded headers (required on Cloudways/Nginx)
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
        );

        // CSRF exceptions
        $middleware->validateCsrfTokens(except: [
            '/paymob/callback',
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\SetLanguage::class,
            \App\Http\Middleware\EnsureUserIsActive::class,
        ]);

        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'set.language' => \App\Http\Middleware\SetLanguage::class,
            'check_role' => \App\Http\Middleware\CheckRole::class,
            'check_license' => \App\Http\Middleware\CheckLicenseStatus::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if (auth()->check()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', __('app.session_expired_retry'));
            }

            return redirect()->route('login')
                ->withInput($request->except('password', '_token'))
                ->with('error', __('app.session_expired'));
        });
    })->create();