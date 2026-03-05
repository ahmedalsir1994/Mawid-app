<?php

use App\Jobs\AutoRenewSubscriptionsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-renew subscriptions daily at 02:00 AM
Schedule::job(new AutoRenewSubscriptionsJob)->dailyAt('02:00');
