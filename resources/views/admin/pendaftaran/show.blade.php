@extends('layouts.app')
@section('title', 'Detail Pendaftaran')
@section('page-title', 'Detail Pendaftaran: ' . $pendaftaran->nama)

@section('content')

    @if($pendaftaran->status == 'pending')
        <!-- Proses Pendaftaran -->
        <div class="card card-warning mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks mr-1"></i> Proses Pendaftaran</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('admin.pendaftaran.terima', $pendaftaran->id) }}" method="POST">
                            @csrf
                            <div class="card card-outline card-success">
                                <div class="card-header">
                                    <h3 class="card-title text-success"><i class="fas fa-check mr-1"></i> Terima Pendaftaran
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted small">Jika diterima, sistem akan otomatis membuat akun untuk siswa
                                        ini.</p>
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="nis">Nomor Induk Siswa (NIS)</label>
                                        <input type="text" id="nis" name="nis" class="form-control"
                                            value="{{ old('nis', date('Y') . rand(1000, 9999)) }}" required>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success btn-block"
                                        onclick="return confirm('Yakin ingin MENERIMA siswa ini?')">
                                        <i class="fas fa-check mr-1"></i> Simpan & Terima
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-danger"><i class="fas fa-times mr-1"></i> Tolak Pendaftaran</h3>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">Jika ditolak, pendaftaran tidak dapat dibatalkan melalui sistem.</p>
                            </div>
                            <div class="card-footer">
                                <form action="{{ route('admin.pendaftaran.tolak', $pendaftaran->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block"
                                        onclick="return confirm('Yakin ingin MENOLAK siswa ini?')">
                                        <i class="fas fa-times mr-1"></i> Tolak Pendaftaran
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-{{ $pendaftaran->status == 'diterima' ? 'success' : 'danger' }}">
            <i class="fas fa-info-circle mr-1"></i>
            Status Pendaftaran: <strong>{{ strtoupper($pendaftaran->status) }}</strong>
        </div>
    @endif

    <!-- Detail Data -->
    <div class="row">
        <!-- Data Diri -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="card-title"><i class="fas fa-user mr-1"></i> Data Diri Pribadi</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped mb-0">
                        <tr>
                            <th width="40%">Nama Lengkap</th>
                            <td>{{ $pendaftaran->nama }}</td>
                        </tr>
                        <tr>
                            <th>Nama Panggilan</th>
                            <td>{{ $pendaftaran->nama_panggilan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>{{ $pendaftaran->nik }}</td>
                        </tr>
                        <tr>
                            <th>No KK</th>
                            <td>{{ $pendaftaran->no_kk }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Tempat, Tgl Lahir</th>
                            <td>{{ $pendaftaran->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>{{ $pendaftaran->agama }}</td>
                        </tr>
                        <tr>
                            <th>No Telp/WA</th>
                            <td>{{ $pendaftaran->no_telp }}</td>
                        </tr>
                        <tr>
                            <th>Sekolah Asal</th>
                            <td>{{ $pendaftaran->sekolah_asal }}</td>
                        </tr>
                        <tr>
                            <th>Status Anak</th>
                            <td>{{ ucfirst($pendaftaran->status_anak) }}, anak ke-{{ $pendaftaran->anak_ke }} dari
                                {{ $pendaftaran->dari_bersaudara }} bersaudara
                            </td>
                        </tr>
                        <tr>
                            <th>Berat / Tinggi</th>
                            <td>{{ $pendaftaran->berat_badan }} kg / {{ $pendaftaran->tinggi_badan }} cm</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt mr-1"></i> Alamat Siswa</h3>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        {{ $pendaftaran->alamat_detail }}<br>
                        RT {{ $pendaftaran->rt ?? '-' }} / RW {{ $pendaftaran->rw ?? '-' }}<br>
                        Desa/Kel: <strong>{{ $pendaftaran->desa }}</strong><br>
                        Kec: {{ $pendaftaran->kecamatan }}, Kab/Kota: {{ $pendaftaran->kabupaten }}<br>
                        Provinsi: {{ $pendaftaran->provinsi }}<br>
                        Kode Pos: {{ $pendaftaran->kode_pos ?? '-' }}
                    </address>
                </div>
            </div>
        </div>

        <!-- Data Keluarga -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="card-title"><i class="fas fa-users mr-1"></i> Data Keluarga</h3>
                </div>
                <div class="card-body p-0">
                    <div class="px-3 pt-2 pb-1"><strong>Data Ayah</strong></div>
                    <table class="table table-sm table-striped mb-0">
                        <tr>
                            <th width="40%">Status</th>
                            <td>{{ ucwords(str_replace('_', ' ', $pendaftaran->status_ayah)) }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pendaftaran->nama_ayah }}</td>
                        </tr>
                        @if($pendaftaran->status_ayah == 'masih_hidup')
                            <tr>
                                <th>No. Telepon/HP</th>
                                <td>{{ $pendaftaran->no_telp_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan</th>
                                <td>{{ $pendaftaran->pendidikan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>

                    <div class="px-3 pt-2 pb-1 border-top"><strong>Data Ibu</strong></div>
                    <table class="table table-sm table-striped mb-0">
                        <tr>
                            <th width="40%">Status</th>
                            <td>{{ ucwords(str_replace('_', ' ', $pendaftaran->status_ibu)) }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pendaftaran->nama_ibu }}</td>
                        </tr>
                        @if($pendaftaran->status_ibu == 'masih_hidup')
                            <tr>
                                <th>No. Telepon/HP</th>
                                <td>{{ $pendaftaran->no_telp_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan</th>
                                <td>{{ $pendaftaran->pendidikan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>

                    @if($pendaftaran->status_ayah == 'sudah_meninggal' && $pendaftaran->status_ibu == 'sudah_meninggal')
                        <div class="px-3 pt-2 pb-1 border-top"><strong>Data Wali</strong></div>
                        <table class="table table-sm table-striped mb-0">
                            <tr>
                                <th width="40%">Nama</th>
                                <td>{{ $pendaftaran->nama_wali }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan</th>
                                <td>{{ $pendaftaran->pendidikan_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>{{ $pendaftaran->pekerjaan_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No Telp</th>
                                <td>{{ $pendaftaran->no_telp_wali ?? '-' }}</td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="card-title"><i class="fas fa-home mr-1"></i> Alamat Orang Tua / Wali</h3>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        {{ $pendaftaran->alamat_detail_ortu }}<br>
                        RT {{ $pendaftaran->rt_ortu ?? '-' }} / RW {{ $pendaftaran->rw_ortu ?? '-' }}<br>
                        Desa/Kel: <strong>{{ $pendaftaran->desa_ortu }}</strong><br>
                        Kec: {{ $pendaftaran->kecamatan_ortu }}, Kab/Kota: {{ $pendaftaran->kabupaten_ortu }}<br>
                        Provinsi: {{ $pendaftaran->provinsi_ortu }}<br>
                        Kode Pos: {{ $pendaftaran->kode_pos_ortu ?? '-' }}
                    </address>
                </div>
            </div>
        </div>
    </div>

    <!-- Referral Info -->
    @if($pendaftaran->referral_code)
        @php $refLink = \App\Models\ReferralLink::where('code', $pendaftaran->referral_code)->first(); @endphp
        <div class="alert alert-info mb-3">
            <i class="fas fa-link mr-1"></i>
            Mendaftar melalui referral <strong>{{ $refLink ? '"' . $refLink->nama . '"' : '' }}</strong>
            — Kode: <code>{{ $pendaftaran->referral_code }}</code>
            @if($refLink && $refLink->keterangan) <span class="text-muted">({{ $refLink->keterangan }})</span> @endif
        </div>
    @endif

    <!-- Dokumen Unggahan -->
    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title"><i class="fas fa-file-image mr-1"></i> Dokumen Unggahan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <p class="font-weight-bold">Foto KK</p>
                    <a href="{{ Storage::url($pendaftaran->foto_kk) }}" target="_blank">
                        <img src="{{ Storage::url($pendaftaran->foto_kk) }}" alt="KK" class="img-thumbnail"
                            style="max-height:200px; object-fit:cover;">
                        <div class="text-primary small mt-1"><i class="fas fa-search mr-1"></i>Klik untuk perbesar</div>
                    </a>
                </div>
                <div class="col-md-3 text-center">
                    <p class="font-weight-bold">Foto KTP Orang Tua</p>
                    @if($pendaftaran->foto_ktp_ortu)
                        <a href="{{ Storage::url($pendaftaran->foto_ktp_ortu) }}" target="_blank">
                            <img src="{{ Storage::url($pendaftaran->foto_ktp_ortu) }}" alt="KTP Ortu" class="img-thumbnail"
                                style="max-height:200px; object-fit:cover;">
                            <div class="text-primary small mt-1"><i class="fas fa-search mr-1"></i>Klik untuk perbesar</div>
                        </a>
                    @else
                        <div class="text-muted font-italic p-4 bg-light border">Tidak ada (Ortu sudah meninggal)</div>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    <p class="font-weight-bold">Akte Kelahiran</p>
                    @if($pendaftaran->foto_akte_kelahiran)
                        <a href="{{ Storage::url($pendaftaran->foto_akte_kelahiran) }}" target="_blank">
                            <img src="{{ Storage::url($pendaftaran->foto_akte_kelahiran) }}" alt="Akte" class="img-thumbnail"
                                style="max-height:200px; object-fit:cover;">
                            <div class="text-primary small mt-1"><i class="fas fa-search mr-1"></i>Klik untuk perbesar</div>
                        </a>
                    @else
                        <div class="text-muted font-italic p-4 bg-light border">Tidak diunggah</div>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    <p class="font-weight-bold">Ijazah / SKL</p>
                    <a href="{{ Storage::url($pendaftaran->ijazah_terakhir) }}" target="_blank">
                        <img src="{{ Storage::url($pendaftaran->ijazah_terakhir) }}" alt="Ijazah" class="img-thumbnail"
                            style="max-height:200px; object-fit:cover;">
                        <div class="text-primary small mt-1"><i class="fas fa-search mr-1"></i>Klik untuk perbesar</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
        <a href="{{ route('admin.pendaftaran.print', $pendaftaran->id) }}" target="_blank" class="btn btn-dark">
            <i class="fas fa-print mr-1"></i> Cetak / Simpan PDF
        </a>
    </div>

@endsection