<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS for all generated URLs when behind a reverse proxy (e.g. Cloudways/Nginx).
        // This prevents CSRF 419 errors caused by http:// session cookies on an https:// site.
        // Works regardless of APP_ENV value by checking actual proxy headers and APP_URL.
        if (!$this->app->runningInConsole()) {
            $isHttps = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
                || isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on'
                || isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' && $_SERVER['HTTPS'] !== ''
                || str_starts_with(config('app.url', ''), 'https://');
            if ($isHttps) {
                URL::forceScheme('https');
            }
        }

        // Custom SMTP driver that works around Windows/Laragon CA bundle issues locally.
        // In production this behaves identically to the standard smtp driver (SSL fully verified).
        Mail::extend('smtp-ssl-fix', function (array $config) {
            $transport = new EsmtpTransport(
                $config['host'],
                (int) $config['port'],
                false   // false = STARTTLS on connect (port 587)
            );

            $transport->setUsername($config['username'] ?? '');
            $transport->setPassword($config['password'] ?? '');

            // Only skip SSL verification on local/dev — never on production.
            if (!$this->app->environment('production')) {
                $transport->getStream()->setStreamOptions([
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ],
                ]);
            }

            return $transport;
        });
    }
}
