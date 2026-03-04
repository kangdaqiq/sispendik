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
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Carbon\Carbon;

class SendWhatsAppPendaftaranNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pendaftaran;

    // Jumlah maksimal retry jika Job gagal
    public $tries = 3;

    // Waktu tunggu (detik) sebelum mencoba ulang
    public $backoff = 60;

    // Timeout untuk request HTTP WA
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

        // 1. Generate PDF di dalam queue
        Log::info("WA Job [0/2]: Generate PDF untuk {$nama}");
        $pendaftaran = $this->pendaftaran;
        $isPdf = true;

        // Render blade ke HTML
        $html = view('admin.pendaftaran.print_pdf', compact('pendaftaran', 'isPdf'))->render();

        // Naikkan pcre limit karena HTML mengandung base64 images
        ini_set('pcre.backtrack_limit', 10000000);

        // mPDF: F4 = 210mm x 330mm, margin: top=15, right=18, bottom=15, left=18
        $mpdf = new Mpdf([
            'format' => [210, 330],
            'margin_top' => 15,
            'margin_right' => 18,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'default_font' => 'dejavusans',
        ]);

        // Split CSS dan body untuk handle HTML berukuran besar
        preg_match('/<style[^>]*>(.*?)<\/style>/si', $html, $cssMatch);
        $css = $cssMatch[1] ?? '';
        preg_match('/<body[^>]*>(.*?)<\/body>/si', $html, $bodyMatch);
        $body = $bodyMatch[1] ?? $html;
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($body, \Mpdf\HTMLParserMode::HTML_BODY);

        $pdfContent = $mpdf->Output('', 'S'); // string output

        $pdfFilename = 'pdf_pendaftaran/Formulir_Pendaftaran_' . ($pendaftaran->nisn ?: $pendaftaran->id) . '_' . time() . '.pdf';
        Storage::disk('public')->put($pdfFilename, $pdfContent);
        $fullPdfPath = storage_path('app/public/' . $pdfFilename);
        Log::info("WA Job [0/2 OK]: PDF berhasil digenerate di {$fullPdfPath}");

        // 2. Kirim pesan teks
        Log::info("WA Job [1/2]: Kirim teks ke {$phone}");
        $message = "*PENDAFTARAN BERHASIL*\n\n"
            . "Halo {$nama},\n\n"
            . "Terima kasih telah mendaftar di SMK Assuniyah Tumijajar pada tanggal {$tgl}.\n"
            . "Pendaftaran Anda telah kami terima dan sedang diproses. Berikut adalah lampiran *Formulir Pendaftaran* Anda (PDF).\n\n"
            . "Mohon simpan formulir ini dengan baik.\n\n"
            . "_Panitia PPDB SMK Assuniyah Tumijajar_";

        $waService->sendMessage($phone, $message);
        Log::info("WA Job [1/2 OK]: Teks terkirim ke {$phone}");

        // 3. Kirim PDF
        Log::info("WA Job [2/2]: Kirim PDF ke {$phone}, path: {$fullPdfPath}");
        $captionPdf = "Formulir Pendaftaran - {$nama}";

        if (file_exists($fullPdfPath)) {
            $waService->sendFile($phone, $fullPdfPath, $captionPdf);
            Log::info("WA Job [2/2 OK]: PDF terkirim ke {$phone}");

            // Hapus file PDF setelah berhasil dikirim
            Storage::disk('public')->delete($pdfFilename);
            Log::info("WA Job: File PDF temp dihapus: {$pdfFilename}");
        } else {
            Log::error("WA Job [2/2 FAIL]: File PDF tidak ditemukan di {$fullPdfPath}");
            throw new \Exception("File PDF tidak ditemukan: {$fullPdfPath}");
        }
    }
}
