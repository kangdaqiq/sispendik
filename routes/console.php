<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Proses antrian (queue) tiap menit via cron job
// Pastikan crontab server sudah ada: * * * * * php /var/www/html/sispendik/artisan schedule:run >> /dev/null 2>&1
Schedule::command('queue:work --stop-when-empty --tries=3 --timeout=120')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();
