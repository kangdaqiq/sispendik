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
        Log::info("Job [STEP 1]: Mulai generate PDF untuk {$nama}");
        try {
            $pendaftaran = $this->pendaftaran;
            $pdf = Pdf::loadView('admin.pendaftaran.pdf', compact('pendaftaran'))
                ->setPaper('a4', 'portrait');

            $pdfFilename = 'pdf_pendaftaran/Formulir_Pendaftaran_' . $this->pendaftaran->nisn . '_' . time() . '.pdf';
            Storage::disk('public')->put($pdfFilename, $pdf->output());
            $fullPdfPath = storage_path('app/public/' . $pdfFilename);
            Log::info("Job [STEP 1 OK]: PDF tersimpan di {$fullPdfPath}");
        } catch (\Exception $e) {
            Log::error("Job [STEP 1 FAIL]: Gagal generate PDF - " . $e->getMessage());
            throw $e;
        }

        // 2. Kirim pesan teks
        Log::info("Job [STEP 2]: Kirim teks WA ke {$phone}");
        $message = "*PENDAFTARAN BERHASIL*\n\n"
            . "Halo {$nama},\n\n"
            . "Terima kasih telah mendaftar di SMK Assuniyah Tumijajar pada tanggal {$tgl}.\n"
            . "Pendaftaran Anda telah kami terima dan sedang diproses. Berikut adalah lampiran *Formulir Pendaftaran* Anda (PDF).\n\n"
            . "Mohon simpan formulir ini dengan baik.\n\n"
            . "_Panitia PPDB SMK Assuniyah Tumijajar_";

        $waService->sendMessage($phone, $message);
        Log::info("Job [STEP 2 OK]: Teks WA berhasil dikirim");

        // 3. Kirim dokumen PDF
        Log::info("Job [STEP 3]: Kirim PDF ke {$phone}, path: {$fullPdfPath}");
        $captionPdf = "Formulir Pendaftaran - {$nama}";

        if (file_exists($fullPdfPath)) {
            $waService->sendFile($phone, $fullPdfPath, $captionPdf);
            Log::info("Job [STEP 3 OK]: PDF berhasil dikirim ke {$phone}");
        } else {
            Log::error("Job [STEP 3 FAIL]: File PDF tidak ditemukan di {$fullPdfPath}");
            throw new \Exception("File PDF tidak ditemukan: {$fullPdfPath}");
        }
    }
}

