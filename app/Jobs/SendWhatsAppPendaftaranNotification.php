<?php

namespace App\Jobs;

use App\Models\Pendaftaran;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendWhatsAppPendaftaranNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pendaftaran;
    public $pdfFilename;

    // Jumlah maksimal retry jika Job gagal
    public $tries = 3;

    // Waktu tunggu (detik) sebelum mencoba ulang
    public $backoff = 60;

    // Timeout untuk request HTTP WA
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(Pendaftaran $pendaftaran, string $pdfFilename)
    {
        $this->pendaftaran = $pendaftaran;
        $this->pdfFilename = $pdfFilename;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $waService): void
    {
        $phone = $this->pendaftaran->no_telp;
        $nama = $this->pendaftaran->nama;
        Carbon::setLocale('id');
        $tgl = $this->pendaftaran->created_at->isoFormat('D MMMM YYYY');

        $fullPdfPath = storage_path('app/public/' . $this->pdfFilename);

        // 1. Kirim pesan teks
        Log::info("WA Job [1/2]: Kirim teks ke {$phone}");
        $message = "*PENDAFTARAN BERHASIL*\n\n"
            . "Halo {$nama},\n\n"
            . "Terima kasih telah mendaftar di SMK Assuniyah Tumijajar pada tanggal {$tgl}.\n"
            . "Pendaftaran Anda telah kami terima dan sedang diproses. Berikut adalah lampiran *Formulir Pendaftaran* Anda (PDF).\n\n"
            . "Mohon simpan formulir ini dengan baik.\n\n"
            . "_Panitia PPDB SMK Assuniyah Tumijajar_";

        $waService->sendMessage($phone, $message);
        Log::info("WA Job [1/2 OK]: Teks terkirim ke {$phone}");

        // 2. Kirim PDF
        Log::info("WA Job [2/2]: Kirim PDF ke {$phone}, path: {$fullPdfPath}");
        $captionPdf = "Formulir Pendaftaran - {$nama}";

        if (file_exists($fullPdfPath)) {
            $waService->sendFile($phone, $fullPdfPath, $captionPdf);
            Log::info("WA Job [2/2 OK]: PDF terkirim ke {$phone}");
        } else {
            Log::error("WA Job [2/2 FAIL]: File PDF tidak ditemukan di {$fullPdfPath}");
            throw new \Exception("File PDF tidak ditemukan: {$fullPdfPath}");
        }
    }
}
