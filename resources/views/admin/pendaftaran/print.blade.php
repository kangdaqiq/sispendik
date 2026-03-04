@php 
                                                                                    Carbon\Carbon::setLocale('id');
    $isPdf = $isPdf ?? false;
    $logoBase64 = '';

    // Helper function for base64 images
    $getBase64 = function ($path) {
        $absPath = storage_path('app/public/' . $path);
        if ($path && file_exists($absPath)) {
            $ext = pathinfo($absPath, PATHINFO_EXTENSION);
            if (strtolower($ext) == 'jpg')
                $ext = 'jpeg';
            return 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($absPath));
        }
        return '';
    };

    $fotoKkBase64 = '';
    $fotoKtpOrtuBase64 = '';
    $fotoAkteBase64 = '';
    $ijazahBase64 = '';

    if ($isPdf) {
        $logoPath = public_path('logo-smk.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }
        $fotoKkBase64 = $getBase64($pendaftaran->foto_kk);
        $fotoKtpOrtuBase64 = $getBase64($pendaftaran->foto_ktp_ortu);
        $fotoAkteBase64 = $getBase64($pendaftaran->foto_akte_kelahiran);
        $ijazahBase64 = $getBase64($pendaftaran->ijazah_terakhir);
    }
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - {{ $pendaftaran->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            background: #fff;
        }

        .page {
            width: 100%;
        }

        /* ---- HEADER ---- */
        .header-container {
            width: 100%;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .header-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-right: 18px;
        }

        .header-text {
            flex: 1;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 4px 0;
            line-height: 1.3;
        }

        .header-subtitle {
            font-size: 11px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ---- SECTION ---- */
        .section-title {
            background: #1e3a5f;
            color: #fff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 10px;
            margin: 12px 0 6px;
        }

        /* ---- TABLE ---- */
        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data tr td {
            padding: 3.5px 8px;
            vertical-align: top;
            border-bottom: 1px solid #e5e7eb;
            line-height: 1.5;
        }

        table.data tr td:first-child {
            width: 36%;
            font-weight: 600;
            color: #374151;
        }

        table.data tr td:nth-child(2) {
            width: 2%;
            color: #9ca3af;
        }

        table.data tr:nth-child(even) {
            background: #f9fafb;
        }

        /* ---- TWO COLUMN ---- */
        .two-col {
            width: 100%;
            display: flex;
            gap: 2%;
        }

        .two-col>div {
            width: 49%;
        }

        /* ---- DOKUMEN ---- */
        .doc-checklist {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .doc-checklist td {
            font-size: 11px;
            color: #111;
            padding: 4px 0;
        }

        .doc-checked::before {
            content: '✓ ';
            color: #16a34a;
            font-weight: bold;
        }

        .doc-unchecked::before {
            content: '✗ ';
            color: #dc2626;
        }

        /* ---- STATUS BADGE ---- */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-pending {
            background: #fef9c3;
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .badge-diterima {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .badge-ditolak {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* ---- PRINT CONTROLS (screen only) ---- */
        .print-controls {
            position: fixed;
            top: 16px;
            right: 16px;
            display: flex;
            gap: 8px;
            z-index: 999;
        }

        .btn-print {
            background: #1e3a5f;
            color: #fff;
            border: none;
            padding: 9px 20px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-back {
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 9px 20px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
        }

        .doc-page {
            width: 100%;
            padding: 5mm 0;
            text-align: center;
        }

        .doc-page h3 {
            font-size: 13px;
            color: #1e3a5f;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 4px;
            width: 100%;
        }

        .doc-page img {
            /* F4 content area: 330mm - 30mm margins - ~20mm judul = ~280mm */
            max-width: 100%;
            max-height: 275mm;
            width: auto;
            height: auto;
            border: 1px solid #d1d5db;
            padding: 2px;
            background: #f9fafb;
        }

        @media print {
            .print-controls {
                display: none;
            }

            .page {
                padding: 10mm 15mm;
            }

            body {
                background: #fff;
            }

            @page {
                size: 210mm 330mm;
                margin: 0;
            }
        }
    </style>
</head>

<body>

    @if(!$isPdf)
        <!-- Print Controls (screen only) -->
        <div class="print-controls">
            <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="btn-back">← Kembali</a>
            <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        </div>
    @endif

    <div class="page">

        <!-- Header Baru -->
        <table style="width: 100%; border-bottom: 3px solid #1e3a5f; padding-bottom: 12px; margin-bottom: 16px;">
            <tr>
                <td style="width: 80px; vertical-align: middle;">
                    @if($isPdf && $logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo SMK" class="header-logo" style="margin-right:0;">
                    @else
                        <img src="{{ asset('logo-smk.png') }}" alt="Logo SMK" class="header-logo" style="margin-right:0;"
                            onerror="this.style.display='none'">
                    @endif
                </td>
                <td style="vertical-align: middle;">
                    <div class="header-title">
                        Formulir Pendaftaran Peserta Didik Baru<br>
                        SMK Assuniyah Tumijajar
                    </div>
                    <div class="header-subtitle">
                        Status: <span
                            class="badge badge-{{ $pendaftaran->status }}">{{ strtoupper($pendaftaran->status) }}</span>
                        &nbsp;|&nbsp;
                        Tanggal Daftar: {{ $pendaftaran->created_at->isoFormat('D MMMM YYYY') }}
                        @if($pendaftaran->referral_code)
                            &nbsp;|&nbsp; Referral: <strong>{{ $pendaftaran->referral_code }}</strong>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- DATA DIRI -->
        <div class="section-title">A. Data Diri Siswa</div>
        <table class="data">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $pendaftaran->nama }}</td>
            </tr>
            <tr>
                <td>Nama Panggilan</td>
                <td>:</td>
                <td>{{ $pendaftaran->nama_panggilan ?? '-' }}</td>
            </tr>
            <tr>
                <td>NIK Siswa</td>
                <td>:</td>
                <td>{{ $pendaftaran->nik }}</td>
            </tr>
            <tr>
                <td>NISN Siswa</td>
                <td>:</td>
                <td>{{ $pendaftaran->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. Kartu Keluarga</td>
                <td>:</td>
                <td>{{ $pendaftaran->no_kk }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Tempat, Tgl Lahir</td>
                <td>:</td>
                <td>{{ $pendaftaran->tempat_lahir }},
                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->isoFormat('D MMMM YYYY') }}
                </td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $pendaftaran->agama }}</td>
            </tr>
            <tr>
                <td>No. Telepon / WA</td>
                <td>:</td>
                <td>{{ $pendaftaran->no_telp }}</td>
            </tr>
            <tr>
                <td>Sekolah Asal</td>
                <td>:</td>
                <td>{{ $pendaftaran->sekolah_asal }}</td>
            </tr>
            <tr>
                <td>Status Anak</td>
                <td>:</td>
                <td>{{ ucfirst($pendaftaran->status_anak) }}, anak ke-{{ $pendaftaran->anak_ke }} dari
                    {{ $pendaftaran->dari_bersaudara }} bersaudara
                </td>
            </tr>
            <tr>
                <td>Berat / Tinggi Badan</td>
                <td>:</td>
                <td>{{ $pendaftaran->berat_badan }} kg / {{ $pendaftaran->tinggi_badan }} cm</td>
            </tr>
        </table>

        <!-- ALAMAT -->
        <div class="section-title">B. Alamat Siswa</div>
        <table class="data">
            <tr>
                <td>Alamat Detail</td>
                <td>:</td>
                <td>{{ $pendaftaran->alamat_detail }}</td>
            </tr>
            <tr>
                <td>RT / RW</td>
                <td>:</td>
                <td>{{ $pendaftaran->rt ?? '-' }} / {{ $pendaftaran->rw ?? '-' }}</td>
            </tr>
            <tr>
                <td>Desa / Kelurahan</td>
                <td>:</td>
                <td>{{ $pendaftaran->desa }}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>:</td>
                <td>{{ $pendaftaran->kecamatan }}</td>
            </tr>
            <tr>
                <td>Kabupaten / Kota</td>
                <td>:</td>
                <td>{{ $pendaftaran->kabupaten }}</td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>:</td>
                <td>{{ $pendaftaran->provinsi }}</td>
            </tr>
            <tr>
                <td>Kode Pos</td>
                <td>:</td>
                <td>{{ $pendaftaran->kode_pos ?? '-' }}</td>
            </tr>
        </table>

        <!-- DATA ORANG TUA -->
        <div class="section-title">C. Data Orang Tua / Wali</div>
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:50%; vertical-align:top; padding-right:6px;">
                    <table style="width:100%; border-collapse:collapse; font-size:11px;">
                        <tr>
                            <td colspan="3"
                                style="font-weight:bold; background:#f3f4f6; padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Data Ayah</td>
                        </tr>
                        <tr style="background:#fff;">
                            <td
                                style="width:44%; padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Status</td>
                            <td
                                style="width:4%; padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ ucwords(str_replace('_', ' ', $pendaftaran->status_ayah)) }}
                            </td>
                        </tr>
                        <tr style="background:#f9fafb;">
                            <td
                                style="width:44%; padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Nama</td>
                            <td
                                style="width:4%; padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->nama_ayah }}
                            </td>
                        </tr>
                        <tr style="background:#fff;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                No. Telepon</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ayah == 'masih_hidup' ? ($pendaftaran->no_telp_ayah ?? '-') : '-' }}
                            </td>
                        </tr>
                        <tr style="background:#f9fafb;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Pendidikan</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ayah == 'masih_hidup' ? ($pendaftaran->pendidikan_ayah ?? '-') : '-' }}
                            </td>
                        </tr>
                        <tr style="background:#fff;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Pekerjaan</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ayah == 'masih_hidup' ? ($pendaftaran->pekerjaan_ayah ?? '-') : '-' }}
                            </td>
                        </tr>
                        <tr style="background:#f9fafb;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Penghasilan / Bln</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ayah == 'masih_hidup' ? ($pendaftaran->penghasilan_ayah ?? '-') : '-' }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%; vertical-align:top; padding-left:6px;">
                    <table style="width:100%; border-collapse:collapse; font-size:11px;">
                        <tr>
                            <td colspan="3"
                                style="font-weight:bold; background:#f3f4f6; padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Data Ibu</td>
                        </tr>
                        <tr style="background:#fff;">
                            <td
                                style="width:44%; padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Status</td>
                            <td
                                style="width:4%; padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ ucwords(str_replace('_', ' ', $pendaftaran->status_ibu)) }}
                            </td>
                        </tr>
                        <tr style="background:#f9fafb;">
                            <td
                                style="width:44%; padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Nama</td>
                            <td
                                style="width:4%; padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->nama_ibu }}
                            </td>
                        </tr>
                        <tr style="background:#fff;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                No. Telepon</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ibu == 'masih_hidup' ? ($pendaftaran->no_telp_ibu ?? '-') : '-' }}
                            </td>
                        </tr>
                        <tr style="background:#f9fafb;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Pendidikan</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ibu == 'masih_hidup' ? ($pendaftaran->pendidikan_ibu ?? '-') : '-' }}
                            </td>
                        </tr>
                        <tr style="background:#fff;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Pekerjaan</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ibu == 'masih_hidup' ? ($pendaftaran->pekerjaan_ibu ?? '-') : '-' }}
                            </td>
                        </tr>
                        <tr style="background:#f9fafb;">
                            <td
                                style="padding:4px 8px; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                Penghasilan / Bln</td>
                            <td
                                style="padding:4px 8px; color:#9ca3af; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                :</td>
                            <td style="padding:4px 8px; border-bottom:1px solid #e5e7eb; font-size:11px;">
                                {{ $pendaftaran->status_ibu == 'masih_hidup' ? ($pendaftaran->penghasilan_ibu ?? '-') : '-' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        @if($pendaftaran->nama_wali)
            <table class="data" style="margin-top:6px;">
                <tr>
                    <td colspan="3" style="font-weight:bold; background:#f3f4f6;">Data Wali</td>
                </tr>
                <tr>
                    <td>Nama Wali</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->nama_wali }}</td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->no_telp_wali ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pendidikan</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->pendidikan_wali ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->pekerjaan_wali ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Penghasilan / Bln</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->penghasilan_wali ?? '-' }}</td>
                </tr>
            </table>
        @endif

        <!-- ALAMAT ORANG TUA -->
        <div class="section-title">D. Alamat Orang Tua / Wali</div>
        <table class="data">
            <tr>
                <td>Alamat Detail</td>
                <td>:</td>
                <td>{{ $pendaftaran->alamat_detail_ortu }}</td>
            </tr>
            <tr>
                <td>RT / RW</td>
                <td>:</td>
                <td>{{ $pendaftaran->rt_ortu ?? '-' }} / {{ $pendaftaran->rw_ortu ?? '-' }}</td>
            </tr>
            <tr>
                <td>Desa / Kelurahan</td>
                <td>:</td>
                <td>{{ $pendaftaran->desa_ortu }}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>:</td>
                <td>{{ $pendaftaran->kecamatan_ortu }}</td>
            </tr>
            <tr>
                <td>Kabupaten / Kota</td>
                <td>:</td>
                <td>{{ $pendaftaran->kabupaten_ortu }}</td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>:</td>
                <td>{{ $pendaftaran->provinsi_ortu }}</td>
            </tr>
        </table>

        <!-- DOKUMEN -->
        <div class="section-title" style="page-break-inside: avoid;">E. Dokumen Persyaratan</div>
        <table style="width:100%; border-collapse:collapse; margin-top:6px; page-break-inside: avoid;">
            <tr>
                <td style="padding:4px 0; font-size:11px; color:#16a34a; font-weight:bold;">[v] Kartu Keluarga (KK)</td>
                <td
                    style="padding:4px 0; font-size:11px; {{ $pendaftaran->foto_ktp_ortu ? 'color:#16a34a; font-weight:bold;' : 'color:#dc2626;' }}">
                    {{ $pendaftaran->foto_ktp_ortu ? '[v]' : '[x]' }} KTP Orang Tua
                </td>
            </tr>
            <tr>
                <td
                    style="padding:4px 0; font-size:11px; {{ $pendaftaran->foto_akte_kelahiran ? 'color:#16a34a; font-weight:bold;' : 'color:#dc2626;' }}">
                    {{ $pendaftaran->foto_akte_kelahiran ? '[v]' : '[x]' }} Akte Kelahiran
                </td>
                <td style="padding:4px 0; font-size:11px; color:#16a34a; font-weight:bold;">[v] Ijazah / SKL</td>
            </tr>
        </table>

        <!-- TANDA TANGAN -->
        <table style="width: 100%; margin-top: 24px; page-break-inside: avoid;">
            <tr>
                <td style="width: 50%; text-align: center;">
                    <div style="font-size: 10px; margin-bottom: 45px;">Orang Tua / Wali,</div>
                    <div style="font-size: 10px; font-weight: bold;">( ______________________________ )</div>
                </td>
                <td style="width: 50%; text-align: center;">
                    <div style="font-size: 10px; margin-bottom: 45px;">
                        Tumijajar, {{ \Carbon\Carbon::parse($pendaftaran->created_at)->isoFormat('D MMMM YYYY') }}<br>
                        Panitia Penerimaan,
                    </div>
                    <div style="font-size: 10px; font-weight: bold;">( ______________________________ )</div>
                </td>
            </tr>
        </table>

        <!-- LAMPIRAN DOKUMEN -->

        <!-- KK -->
        @if($pendaftaran->foto_kk)
            <div class="page-break"></div>
            <div class="doc-page">
                <h3>Lampiran: Kartu Keluarga (KK)</h3>
                @if($isPdf && $fotoKkBase64)
                    <img src="{{ $fotoKkBase64 }}" alt="Kartu Keluarga">
                @else
                    <img src="{{ asset('storage/' . $pendaftaran->foto_kk) }}" alt="Kartu Keluarga">
                @endif
            </div>
        @endif

        <!-- KTP Ortu -->
        @if($pendaftaran->foto_ktp_ortu)
            <div class="page-break"></div>
            <div class="doc-page">
                <h3>Lampiran: KTP Orang Tua</h3>
                @if($isPdf && $fotoKtpOrtuBase64)
                    <img src="{{ $fotoKtpOrtuBase64 }}" alt="KTP Orang Tua">
                @else
                    <img src="{{ asset('storage/' . $pendaftaran->foto_ktp_ortu) }}" alt="KTP Orang Tua">
                @endif
            </div>
        @endif

        <!-- AKTE KELAHIRAN -->
        @if($pendaftaran->foto_akte_kelahiran)
            <div class="page-break"></div>
            <div class="doc-page">
                <h3>Lampiran: Akte Kelahiran</h3>
                @if($isPdf && $fotoAkteBase64)
                    <img src="{{ $fotoAkteBase64 }}" alt="Akte Kelahiran">
                @else
                    <img src="{{ asset('storage/' . $pendaftaran->foto_akte_kelahiran) }}" alt="Akte Kelahiran">
                @endif
            </div>
        @endif

        <!-- IJAZAH -->
        @if($pendaftaran->ijazah_terakhir)
            <div class="page-break"></div>
            <div class="doc-page">
                <h3>Lampiran: Ijazah / SKL</h3>
                @if($isPdf && $ijazahBase64)
                    <img src="{{ $ijazahBase64 }}" alt="Ijazah / SKL">
                @else
                    <img src="{{ asset('storage/' . $pendaftaran->ijazah_terakhir) }}" alt="Ijazah / SKL">
                @endif
            </div>
        @endif
</body>

</html>