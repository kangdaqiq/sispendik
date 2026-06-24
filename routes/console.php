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

Artisan::command('pendaftaran:resend-notif {--days=1} {--id=*} {--group-only}', function () {
    $days = $this->option('days');
    $ids = $this->option('id');
    $groupOnly = $this->option('group-only');

    $query = \App\Models\Pendaftaran::query();

    if (!empty($ids)) {
        $query->whereIn('id', $ids);
    } else {
        $query->where('created_at', '>=', now()->subDays($days));
    }

    $pendaftarans = $query->get();

    if ($pendaftarans->isEmpty()) {
        $this->info("Tidak ada pendaftaran ditemukan.");
        return;
    }

    $typeText = $groupOnly ? "hanya ke grup guru" : "ke siswa & grup guru";
    $this->info("Mengirim ulang notifikasi ({$typeText}) untuk " . $pendaftarans->count() . " pendaftaran...");

    foreach ($pendaftarans as $pendaftaran) {
        $this->info("- Mengirim notifikasi untuk: {$pendaftaran->nama} (ID: {$pendaftaran->id})");
        try {
            \App\Jobs\SendWhatsAppPendaftaranNotification::dispatchSync($pendaftaran, $groupOnly);
            $this->info("  Berhasil.");
        } catch (\Exception $e) {
            $this->error("  Gagal: " . $e->getMessage());
        }
    }

    $this->info("Selesai.");
})->purpose('Mengirim ulang notifikasi pendaftaran siswa baru');
