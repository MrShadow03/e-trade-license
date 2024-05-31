<?php

use Illuminate\Foundation\Inspiring;
use App\Jobs\TradeLicenseExpiringJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:check-expired-applications')->everyMinute()->withoutOverlapping()->runInBackground()->description('Check for expired applications and dispatch jobs');

Schedule::command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping()->runInBackground()->description('Process the next job on the queue');