@php Carbon\Carbon::setLocale('id'); @endphp
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
            margin: 0 auto;
            padding: 15mm 18mm;
        }

        /* ---- HEADER ---- */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .header-logo {
            width: 70px;
            height: 70px;
        }

        .header-text {
            vertical-align: middle;
            padding-left: 15px;
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

        /* ---- TWO COLUMN USING TABLE ---- */
        table.two-col-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.two-col-table td {
            width: 50%;
            vertical-align: top;
            padding: 0 8px 0 0;
        }

        table.two-col-table td+td {
            padding: 0 0 0 8px;
        }

        /* ---- STATUS BADGE ---- */
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-weight: bold;
        }

        /* ---- TANDA TANGAN ---- */
        table.ttd-table {
            width: 100%;
            margin-top: 30px;
            text-align: center;
        }

        table.ttd-table td {
            width: 50%;
            vertical-align: bottom;
        }

        .ttd-label {
            font-size: 10px;
            margin-bottom: 60px;
        }

        .ttd-placeholder {
            font-size: 10px;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
        }

        .doc-page {
            width: 100%;
            padding: 15mm 18mm;
            text-align: center;
        }

        .doc-page h3 {
            font-size: 14px;
            color: #1e3a5f;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 5px;
        }

        .doc-page img {
            max-width: 100%;
            max-height: 800px;
            border: 1px solid #d1d5db;
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 80px;">
                    <img src="{{ public_path('logo-smk.png') }}" alt="Logo SMK" class="header-logo">
                </td>
                <td class="header-text">
                    <div class="header-title">
                        Formulir Pendaftaran Peserta Didik Baru<br>
                        SMK Assuniyah Tumijajar
                    </div>
                    <div class="header-subtitle">
                        Status: <span
                            class="badge badge-{{ $pendaftaran->status }}">{{ strtoupper($pendaftaran->status) }}</span>
                        &nbsp;|&nbsp;
                        Tanggal Daftar: {{ $pendaftaran->created_at->isoFormat('D MMMM YYYY') }}
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
                <td>Desa / Kelurahan</td>
                <td>:</td>
                <td>{{ $pendaftaran->desa }}, RT {{ $pendaftaran->rt ?? '-' }} / RW {{ $pendaftaran->rw ?? '-' }}</td>
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
        </table>

        <!-- DATA ORANG TUA -->
        <div class="section-title">C. Data Orang Tua / Wali</div>

        <table class="two-col-table">
            <tr>
                <td>
                    <table class="data">
                        <tr>
                            <td colspan="3" style="font-weight:bold; background:#e2e8f0; text-align:center;">Data Ayah
                            </td>
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
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
                <td>
                    <table class="data">
                        <tr>
                            <td colspan="3" style="font-weight:bold; background:#e2e8f0; text-align:center;">Data Ibu
                            </td>
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
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        <!-- TANDA TANGAN -->
        <table class="ttd-table">
            <tr>
                <td>
                    <div class="ttd-label">Orang Tua / Wali,</div>
                    <div class="ttd-placeholder">( ______________________________ )</div>
                </td>
                <td>
                    <div class="ttd-label">Tumijajar,
                        {{ \Carbon\Carbon::parse($pendaftaran->created_at)->isoFormat('D MMMM YYYY') }}<br>Panitia
                        Penerimaan,
                    </div>
                    <div class="ttd-placeholder">( ______________________________ )</div>
                </td>
            </tr>
        </table>

    </div>

    <!-- LAMPIRAN DOKUMEN -->

    @if($pendaftaran->foto_kk)
        <div class="page-break"></div>
        <div class="doc-page">
            <h3>Lampiran: Kartu Keluarga (KK)</h3>
            <img src="{{ public_path('storage/' . $pendaftaran->foto_kk) }}" alt="Kartu Keluarga">
        </div>
    @endif

    @if($pendaftaran->foto_ktp_ortu)
        <div class="page-break"></div>
        <div class="doc-page">
            <h3>Lampiran: KTP Orang Tua</h3>
            <img src="{{ public_path('storage/' . $pendaftaran->foto_ktp_ortu) }}" alt="KTP Orang Tua">
        </div>
    @endif

    @if($pendaftaran->foto_akte_kelahiran)
        <div class="page-break"></div>
        <div class="doc-page">
            <h3>Lampiran: Akte Kelahiran</h3>
            <img src="{{ public_path('storage/' . $pendaftaran->foto_akte_kelahiran) }}" alt="Akte Kelahiran">
        </div>
    @endif

    @if($pendaftaran->ijazah_terakhir)
        <div class="page-break"></div>
        <div class="doc-page">
            <h3>Lampiran: Ijazah / SKL</h3>
            <img src="{{ public_path('storage/' . $pendaftaran->ijazah_terakhir) }}" alt="Ijazah / SKL">
        </div>
    @endif

</body>

</html>