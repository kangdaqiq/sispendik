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

class SendWhatsAppPendaftaranNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pendaftaran;
    public $pdfPath;

    // Tentukan jumlah maksimal retry jika Job gagal (contoh: 3 kali percobaan)
    public $tries = 3;

    // Tentukan waktu tunggu (detik) sebelum mencoba ulang (contoh: 60 detik)
    public $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(Pendaftaran $pendaftaran, string $pdfPath)
    {
        $this->pendaftaran = $pendaftaran;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $waService): void
    {
        $phone = $this->pendaftaran->no_telp;
        $nama = $this->pendaftaran->nama;
        \Carbon\Carbon::setLocale('id');
        $tgl = $this->pendaftaran->created_at->isoFormat('D MMMM YYYY');

        // 1. Kirim pesan notifikasi teks dahulu
        $message = "*PENDAFTARAN BERHASIL*\n\n"
            . "Halo {$nama},\n\n"
            . "Terima kasih telah mendaftar di SMK Assuniyah Tumijajar pada tanggal {$tgl}.\n"
            . "Pendaftaran Anda telah kami terima dan sedang diproses. Berikut adalah lampiran *Formulir Pendaftaran* Anda (PDF).\n\n"
            . "Mohon simpan bukti ini dengan baik.\n\n"
            . "_Panitia PPDB SMK Assuniyah Tumijajar_";

        Log::info("Job: Mengirim pesan WA ke {$phone}");

        // Jika sendMessage mengembalikan exception / false (tergantung implementasi service), Job otomatis gagal & masuk antrean retry
        $waService->sendMessage($phone, $message);

        // 2. Kirim dokumen PDF Bukti Pendaftaran
        Log::info("Job: Mengirim PDF Pendaftaran ke {$phone}");

        $captionPdf = "Formulir Pendaftaran - {$nama}";
        $fullPdfPath = storage_path('app/public/' . $this->pdfPath);

        if (file_exists($fullPdfPath)) {
            $waService->sendFile($phone, $fullPdfPath, $captionPdf);
        } else {
            Log::error("Job: File PDF tidak ditemukan di {$fullPdfPath}");
            // Throw exception agar di-retry jika file sebenarnya masih butuh waktu di-generate (meskipun jarang terjadi jika flow synchronous)
            throw new \Exception("File PDF tidak ditemukan: {$fullPdfPath}");
        }
    }
}
