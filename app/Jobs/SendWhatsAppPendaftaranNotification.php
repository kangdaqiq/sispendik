<?php

namespace App\Jobs;

use App\Models\Pendaftaran;
use App\Services\WhatsAppService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SendWhatsAppPendaftaranNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pendaftaran;

    // Tentukan jumlah maksimal retry jika Job gagal
    public $tries = 3;

    // Tentukan waktu tunggu (detik) sebelum mencoba ulang
    public $backoff = 60;

    // Beri cukup waktu untuk generate PDF + kirim WA
    public $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
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

        // 1. Generate PDF di dalam Job (background)
        Log::info("Job: Generate PDF Formulir Pendaftaran untuk {$nama}");
        $pendaftaran = $this->pendaftaran;
        $pdf = Pdf::loadView('admin.pendaftaran.pdf', compact('pendaftaran'))
            ->setPaper('a4', 'portrait');

        $pdfFilename = 'pdf_pendaftaran/Formulir_Pendaftaran_' . $this->pendaftaran->nisn . '_' . time() . '.pdf';
        Storage::disk('public')->put($pdfFilename, $pdf->output());
        $fullPdfPath = storage_path('app/public/' . $pdfFilename);

        // 2. Kirim pesan teks
        $message = "*PENDAFTARAN BERHASIL*\n\n"
            . "Halo {$nama},\n\n"
            . "Terima kasih telah mendaftar di SMK Assuniyah Tumijajar pada tanggal {$tgl}.\n"
            . "Pendaftaran Anda telah kami terima dan sedang diproses. Berikut adalah lampiran *Formulir Pendaftaran* Anda (PDF).\n\n"
            . "Mohon simpan formulir ini dengan baik.\n\n"
            . "_Panitia PPDB SMK Assuniyah Tumijajar_";

        Log::info("Job: Mengirim pesan WA ke {$phone}");
        $waService->sendMessage($phone, $message);

        // 3. Kirim dokumen PDF
        Log::info("Job: Mengirim PDF Formulir Pendaftaran ke {$phone}");
        $captionPdf = "Formulir Pendaftaran - {$nama}";

        if (file_exists($fullPdfPath)) {
            $waService->sendFile($phone, $fullPdfPath, $captionPdf);
        } else {
            Log::error("Job: File PDF tidak ditemukan di {$fullPdfPath}");
            throw new \Exception("File PDF tidak ditemukan: {$fullPdfPath}");
        }
    }
}

