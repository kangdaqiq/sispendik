@php Carbon\Carbon::setLocale('id');
    $logoPath = public_path('logo-smk.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
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
        }

        .page {
            width: 100%;
            padding: 10mm 15mm;
        }

        /* HEADER */
        table.header-tbl {
            width: 100%;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        table.header-tbl td {
            vertical-align: middle;
        }

        .header-logo {
            width: 65px;
            height: 65px;
        }

        .header-text-td {
            padding-left: 12px;
        }

        .header-title {
            font-size: 15px;
            font-weight: bold;
            color: #1e3a5f;
            text-transform: uppercase;
            line-height: 1.4;
        }

        .header-sub {
            font-size: 10px;
            color: #444;
            margin-top: 3px;
        }

        /* SECTION TITLE */
        .section-title {
            background: #1e3a5f;
            color: #fff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            padding: 4px 8px;
            margin: 10px 0 5px;
        }

        /* DATA TABLE */
        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data tr td {
            padding: 3px 7px;
            vertical-align: top;
            border-bottom: 1px solid #e5e7eb;
            line-height: 1.5;
        }

        table.data tr td:first-child {
            width: 35%;
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

        /* TWO COLUMN */
        table.two-col {
            width: 100%;
            border-collapse: collapse;
        }

        table.two-col>tr>td {
            width: 50%;
            vertical-align: top;
            padding-right: 8px;
        }

        table.two-col>tr>td+td {
            padding-right: 0;
            padding-left: 8px;
        }

        /* TTD */
        table.ttd {
            width: 100%;
            margin-top: 24px;
            text-align: center;
        }

        table.ttd td {
            width: 50%;
        }

        .ttd-space {
            height: 55px;
        }

        .ttd-name {
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="page">

        <!-- HEADER -->
        <table class="header-tbl">
            <tr>
                <td style="width:70px;">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo" class="header-logo">
                    @endif
                </td>
                <td class="header-text-td">
                    <div class="header-title">
                        Formulir Pendaftaran Peserta Didik Baru<br>
                        SMK Assuniyah Tumijajar
                    </div>
                    <div class="header-sub">
                        Status: <strong>{{ strtoupper($pendaftaran->status) }}</strong>
                        &nbsp;|&nbsp;
                        Tanggal Daftar: {{ $pendaftaran->created_at->isoFormat('D MMMM YYYY') }}
                        @if($pendaftaran->referral_code)
                            &nbsp;|&nbsp; Kode Referral: <strong>{{ $pendaftaran->referral_code }}</strong>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- A. DATA DIRI -->
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
                <td>NIK</td>
                <td>:</td>
                <td>{{ $pendaftaran->nik }}</td>
            </tr>
            <tr>
                <td>NISN</td>
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
                <td>Tempat, Tanggal Lahir</td>
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

        <!-- B. ALAMAT SISWA -->
        <div class="section-title">B. Alamat Siswa</div>
        <table class="data">
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $pendaftaran->alamat_detail }}</td>
            </tr>
            <tr>
                <td>Desa / RT / RW</td>
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

        <!-- C. DATA ORANG TUA -->
        <div class="section-title">C. Data Orang Tua</div>
        <table class="two-col">
            <tr>
                <td>
                    <table class="data">
                        <tr>
                            <td colspan="3" style="font-weight:bold; background:#e8edf3; text-align:center;">Ayah</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $pendaftaran->nama_ayah }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{{ ucwords(str_replace('_', ' ', $pendaftaran->status_ayah)) }}</td>
                        </tr>
                        @if($pendaftaran->status_ayah == 'masih_hidup')
                            <tr>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>No. Telp</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->no_telp_ayah ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
                <td>
                    <table class="data">
                        <tr>
                            <td colspan="3" style="font-weight:bold; background:#e8edf3; text-align:center;">Ibu</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $pendaftaran->nama_ibu }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{{ ucwords(str_replace('_', ' ', $pendaftaran->status_ibu)) }}</td>
                        </tr>
                        @if($pendaftaran->status_ibu == 'masih_hidup')
                            <tr>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>No. Telp</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->no_telp_ibu ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        @if($pendaftaran->nama_wali)
            <table class="data" style="margin-top:5px;">
                <tr>
                    <td colspan="3" style="font-weight:bold; background:#f3f4f6;">Data Wali</td>
                </tr>
                <tr>
                    <td>Nama Wali</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->nama_wali }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->pekerjaan_wali ?? '-' }}</td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->no_telp_wali ?? '-' }}</td>
                </tr>
            </table>
        @endif

        <!-- D. ALAMAT ORANG TUA -->
        <div class="section-title">D. Alamat Orang Tua / Wali</div>
        <table class="data">
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $pendaftaran->alamat_detail_ortu }}</td>
            </tr>
            <tr>
                <td>Desa / RT / RW</td>
                <td>:</td>
                <td>{{ $pendaftaran->desa_ortu }}, RT {{ $pendaftaran->rt_ortu ?? '-' }} / RW
                    {{ $pendaftaran->rw_ortu ?? '-' }}
                </td>
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

        <!-- TANDA TANGAN -->
        <table class="ttd">
            <tr>
                <td>
                    <p style="font-size:10px;">Orang Tua / Wali,</p>
                    <div class="ttd-space"></div>
                    <div class="ttd-name">( _________________________ )</div>
                </td>
                <td>
                    <p style="font-size:10px;">
                        Tumijajar, {{ \Carbon\Carbon::parse($pendaftaran->created_at)->isoFormat('D MMMM YYYY') }}<br>
                        Panitia Penerimaan,
                    </p>
                    <div class="ttd-space"></div>
                    <div class="ttd-name">( _________________________ )</div>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>