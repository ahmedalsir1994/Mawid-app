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
        // On production, force HTTPS for all generated URLs so the session cookie
        // domain and the form action always match, preventing CSRF 419 errors.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Fix SSL certificate verification on Windows by providing the CA bundle
        // or by using a custom SMTP transport with relaxed SSL options.
        Mail::extend('smtp-ssl-fix', function (array $config) {
            $transport = new EsmtpTransport(
                $config['host'],
                (int) $config['port'],
                false   // false = STARTTLS on connect (port 587)
            );

            $transport->setUsername($config['username'] ?? '');
            $transport->setPassword($config['password'] ?? '');

            // On Windows/Laragon, OpenSSL cannot locate the system CA bundle.
            // The TLS connection is still encrypted; only certificate validation is skipped.
            // To re-enable, set openssl.cafile in php.ini pointing to a valid CA bundle.
            $transport->getStream()->setStreamOptions([
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ]);

            return $transport;
        });
    }
}
