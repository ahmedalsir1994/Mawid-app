<?php

use App\Console\Commands\ExpireGracePeriodLicenses;
use App\Jobs\AutoRenewSubscriptionsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-renew subscriptions daily at 02:00 AM
Schedule::job(new AutoRenewSubscriptionsJob)->dailyAt('02:00');

// Expire past_due licenses whose grace period has ended (runs daily at 03:00 AM)
Schedule::command(ExpireGracePeriodLicenses::class)->dailyAt('03:00');
