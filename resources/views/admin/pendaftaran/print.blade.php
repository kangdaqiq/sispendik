@php 
                Carbon\Carbon::setLocale('id');
    $isPdf = $isPdf ?? false;
    $logoBase64 = '';
    if ($isPdf) {
        $logoPath = public_path('logo-smk.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }
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
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm 18mm;
        }

        @if($isPdf)
            @page {
                margin: 15mm 18mm;
            }

            .page {
                padding: 0;
            }

        @endif

        /* ---- HEADER ---- */
        .header-container {
            display: flex;
            align-items: center;
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
            display: flex;
            gap: 16px;
        }

        .two-col>div {
            flex: 1;
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

        /* ---- TANDA TANGAN ---- */
        .ttd-row {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            gap: 20px;
        }

        .ttd-box {
            flex: 1;
            text-align: center;
        }

        .ttd-box .ttd-label {
            font-size: 10px;
            margin-bottom: 45px;
        }

        .ttd-box .ttd-placeholder {
            font-size: 10px;
            font-weight: bold;
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
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm 18mm;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .doc-page h3 {
            font-size: 14px;
            color: #1e3a5f;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 5px;
            width: 100%;
        }

        .doc-page img {
            max-width: 100%;
            max-height: 250mm;
            object-fit: contain;
            border: 1px solid #d1d5db;
            padding: 4px;
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
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 8px;">
                    <table class="data">
                        <tr>
                            <td colspan="3" style="font-weight:bold; background:#f3f4f6;">Data Ayah</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{{ ucwords(str_replace('_', ' ', $pendaftaran->status_ayah)) }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $pendaftaran->nama_ayah }}</td>
                        </tr>
                        @if($pendaftaran->status_ayah == 'masih_hidup')
                            <tr>
                                <td>No. Telepon</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->no_telp_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pendidikan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pendidikan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Penghasilan / Bln</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->penghasilan_ayah ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 8px;">
                    <table class="data">
                        <tr>
                            <td colspan="3" style="font-weight:bold; background:#f3f4f6;">Data Ibu</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{{ ucwords(str_replace('_', ' ', $pendaftaran->status_ibu)) }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $pendaftaran->nama_ibu }}</td>
                        </tr>
                        @if($pendaftaran->status_ibu == 'masih_hidup')
                            <tr>
                                <td>No. Telepon</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->no_telp_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pendidikan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pendidikan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Penghasilan / Bln</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->penghasilan_ibu ?? '-' }}</td>
                            </tr>
                        @endif
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
        <div class="section-title">E. Dokumen Persyaratan</div>
        <table class="doc-checklist">
            <tr>
                <td class="doc-checked">Kartu Keluarga (KK)</td>
                <td class="{{ $pendaftaran->foto_ktp_ortu ? 'doc-checked' : 'doc-unchecked' }}">KTP Orang Tua</td>
            </tr>
            <tr>
                <td class="{{ $pendaftaran->foto_akte_kelahiran ? 'doc-checked' : 'doc-unchecked' }}">Akte Kelahiran
                </td>
                <td class="doc-checked">Ijazah / SKL</td>
            </tr>
        </table>

        <!-- TANDA TANGAN -->
        <table style="width: 100%; margin-top: 24px;">
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

    </div>

    @if(!$isPdf)
        <!-- LAMPIRAN DOKUMEN -->

        <!-- KK -->
        <div class="page-break"></div>
        <div class="doc-page">
            <h3>Lampiran: Kartu Keluarga (KK)</h3>
            <img src="{{ asset('storage/' . $pendaftaran->foto_kk) }}" alt="Kartu Keluarga">
        </div>

        <!-- KTP Ortu -->
        @if($pendaftaran->foto_ktp_ortu)
            <div class="page-break"></div>
            <div class="doc-page">
                <h3>Lampiran: KTP Orang Tua</h3>
                <img src="{{ asset('storage/' . $pendaftaran->foto_ktp_ortu) }}" alt="KTP Orang Tua">
            </div>
        @endif

        <!-- AKTE KELAHIRAN -->
        @if($pendaftaran->foto_akte_kelahiran)
            <div class="page-break"></div>
            <div class="doc-page">
                <h3>Lampiran: Akte Kelahiran</h3>
                <img src="{{ asset('storage/' . $pendaftaran->foto_akte_kelahiran) }}" alt="Akte Kelahiran">
            </div>
        @endif

        <!-- IJAZAH -->
        <div class="page-break"></div>
        <div class="doc-page">
            <h3>Lampiran: Ijazah / SKL</h3>
            <img src="{{ asset('storage/' . $pendaftaran->ijazah_terakhir) }}" alt="Ijazah / SKL">
        </div>
    @endif
</body>

</html>