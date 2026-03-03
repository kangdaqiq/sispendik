@extends('layouts.app')
@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa: ' . $siswa->nama)

@section('content')
<div class="row">
    <!-- Left Column: Profile Card & Kelas -->
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                @if($siswa->foto)
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ Storage::url($siswa->foto) }}"
                             alt="User profile picture"
                             style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                @else
                    <div style="width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;font-weight:700;color:white;">
                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                    </div>
                @endif
                <h3 class="profile-username text-center">{{ $siswa->nama }}</h3>
                <p class="text-muted text-center">NIS: {{ $siswa->nis }}</p>
                
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status</b> <a class="float-right text-{{ match ($siswa->status) { 'aktif' => 'success', 'lulus' => 'info', default => 'danger'} }}">
                            {{ ucfirst($siswa->status) }}
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>NISN</b> <a class="float-right">{{ $siswa->nisn }}</a>
                    </li>
                </ul>

                <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-primary btn-block"><b><i class="fas fa-edit mr-1"></i> Edit</b></a>
                <a href="{{ route('siswa.index') }}" class="btn btn-default btn-block"><b><i class="fas fa-arrow-left mr-1"></i> Kembali</b></a>
            </div>
        </div>

        <!-- Riwayat Kelas Card -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-door-open mr-1"></i> Riwayat Kelas</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm text-sm">
                    <thead>
                        <tr>
                            <th>T.A</th>
                            <th>Kelas</th>
                            <th>No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa->kelas as $k)
                            <tr>
                                <td>{{ $k->tahunAjaran->nama }} ({{ ucfirst($k->tahunAjaran->semester) }})</td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->pivot->nomor_absen ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted text-center py-3">Belum ada data kelas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Details -->
    <div class="col-md-9">
        <div class="row">
            <!-- Data Diri & Alamat -->
            <div class="col-md-6">
                <!-- Data Diri Card -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fas fa-user mr-1"></i> Data Diri Pribadi</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-striped mb-0 text-sm">
                            <tr><th width="40%">Nama Lengkap</th><td>{{ $siswa->nama }}</td></tr>
                            <tr><th>Nama Panggilan</th><td>{{ $siswa->nama_panggilan ?? '-' }}</td></tr>
                            <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td></tr>
                            <tr><th>Tempat, Tgl Lahir</th><td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir?->format('d M Y') }}</td></tr>
                            <tr><th>Agama</th><td>{{ $siswa->agama }}</td></tr>
                            <tr><th>No Telp/WA</th><td>{{ $siswa->no_telp }}</td></tr>
                            <tr><th>Sekolah Asal</th><td>{{ $siswa->sekolah_asal ?? '-' }}</td></tr>
                            <tr><th>Status Anak</th><td>{{ ucfirst($siswa->status_anak) }}, anak ke-{{ $siswa->anak_ke }} dari {{ $siswa->dari_bersaudara }} bersaudara</td></tr>
                            <tr><th>Berat / Tinggi</th><td>{{ $siswa->berat_badan }} kg / {{ $siswa->tinggi_badan }} cm</td></tr>
                        </table>
                    </div>
                </div>

                <!-- Alamat Card -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fas fa-map-marker-alt mr-1"></i> Alamat Siswa</h3>
                    </div>
                    <div class="card-body text-sm">
                        <address class="mb-0">
                            {{ $siswa->alamat_detail }}<br>
                            RT {{ $siswa->rt ?? '-' }} / RW {{ $siswa->rw ?? '-' }}<br>
                            Desa/Kel: <strong>{{ $siswa->desa }}</strong><br>
                            Kec: {{ $siswa->kecamatan }}, Kab/Kota: {{ $siswa->kabupaten }}<br>
                            Provinsi: {{ $siswa->provinsi }}<br>
                            Kode Pos: {{ $siswa->kode_pos ?? '-' }}
                        </address>
                        <hr>
                        <p class="mb-0 text-muted small"><i class="fas fa-road mr-1"></i> Alamat Singkat: {{ $siswa->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Keluarga & Dokumen -->
            <div class="col-md-6">
                 <!-- Data Keluarga Card -->
                 <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fas fa-users mr-1"></i> Data Keluarga</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="px-3 pt-2 pb-1 bg-light text-sm"><strong>Data Ayah</strong></div>
                        <table class="table table-sm table-striped mb-0 text-sm">
                            <tr><th width="40%">Status</th><td>{{ ucwords(str_replace('_', ' ', $siswa->status_ayah)) }}</td></tr>
                            <tr><th>Nama</th><td>{{ $siswa->nama_ayah }}</td></tr>
                            @if($siswa->status_ayah == 'masih_hidup')
                                <tr><th>No. Telepon/HP</th><td>{{ $siswa->no_telp_ayah ?? '-' }}</td></tr>
                                <tr><th>Pendidikan</th><td>{{ $siswa->pendidikan_ayah ?? '-' }}</td></tr>
                                <tr><th>Pekerjaan</th><td>{{ $siswa->pekerjaan_ayah ?? '-' }}</td></tr>
                            @endif
                        </table>

                        <div class="px-3 pt-2 pb-1 bg-light border-top text-sm"><strong>Data Ibu</strong></div>
                        <table class="table table-sm table-striped mb-0 text-sm">
                            <tr><th width="40%">Status</th><td>{{ ucwords(str_replace('_', ' ', $siswa->status_ibu)) }}</td></tr>
                            <tr><th>Nama</th><td>{{ $siswa->nama_ibu }}</td></tr>
                            @if($siswa->status_ibu == 'masih_hidup')
                                <tr><th>No. Telepon/HP</th><td>{{ $siswa->no_telp_ibu ?? '-' }}</td></tr>
                                <tr><th>Pendidikan</th><td>{{ $siswa->pendidikan_ibu ?? '-' }}</td></tr>
                                <tr><th>Pekerjaan</th><td>{{ $siswa->pekerjaan_ibu ?? '-' }}</td></tr>
                            @endif
                        </table>

                        @if($siswa->status_ayah == 'sudah_meninggal' && $siswa->status_ibu == 'sudah_meninggal')
                            <div class="px-3 pt-2 pb-1 bg-light border-top text-sm"><strong>Data Wali</strong></div>
                            <table class="table table-sm table-striped mb-0 text-sm">
                                <tr><th width="40%">Nama</th><td>{{ $siswa->nama_wali }}</td></tr>
                                <tr><th>Pendidikan</th><td>{{ $siswa->pendidikan_wali ?? '-' }}</td></tr>
                                <tr><th>Pekerjaan</th><td>{{ $siswa->pekerjaan_wali ?? '-' }}</td></tr>
                                <tr><th>No Telp</th><td>{{ $siswa->no_telp_wali ?? '-' }}</td></tr>
                            </table>
                        @endif
                    </div>
                </div>

                <!-- Alamat Ortu Card -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title"><i class="fas fa-home mr-1"></i> Alamat Orang Tua / Wali</h3>
                    </div>
                    <div class="card-body text-sm">
                        @if($siswa->alamat_ortu_sama)
                            <span class="text-muted font-italic"><i class="fas fa-check text-success mr-1"></i> Sama dengan alamat siswa.</span>
                        @else
                            <address class="mb-0">
                                {{ $siswa->alamat_detail_ortu }}<br>
                                RT {{ $siswa->rt_ortu ?? '-' }} / RW {{ $siswa->rw_ortu ?? '-' }}<br>
                                Desa/Kel: <strong>{{ $siswa->desa_ortu }}</strong><br>
                                Kec: {{ $siswa->kecamatan_ortu }}, Kab/Kota: {{ $siswa->kabupaten_ortu }}<br>
                                Provinsi: {{ $siswa->provinsi_ortu }}<br>
                                Kode Pos: {{ $siswa->kode_pos_ortu ?? '-' }}
                            </address>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen Unggahan -->
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title"><i class="fas fa-file-image mr-1"></i> Dokumen Unggahan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <p class="font-weight-bold text-sm">Foto KK</p>
                        @if($siswa->foto_kk)
                            <a href="{{ Storage::url($siswa->foto_kk) }}" target="_blank">
                                <img src="{{ Storage::url($siswa->foto_kk) }}" alt="KK" class="img-thumbnail" style="height:120px; width:100%; object-fit:contain;">
                                <div class="text-primary small mt-1"><i class="fas fa-search mr-1"></i>Klik untuk perbesar</div>
                            </a>
                        @else
                            <div class="text-muted font-italic p-3 bg-light border text-sm">Belum diunggah</div>
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="font-weight-bold text-sm">Foto KTP Orang Tua</p>
                        @if($siswa->foto_ktp_ortu)
                            <a href="{{ Storage::url($siswa->foto_ktp_ortu) }}" target="_blank">
                                <img src="{{ Storage::url($siswa->foto_ktp_ortu) }}" alt="KTP Ortu" class="img-thumbnail" style="height:120px; width:100%; object-fit:contain;">
                                <div class="text-primary small mt-1"><i class="fas fa-search mr-1"></i>Klik untuk perbesar</div>
                            </a>
                        @else
                            <div class="text-muted font-italic p-3 bg-light border text-sm">Belum diunggah atau tidak ada</div>
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="font-weight-bold text-sm">Ijazah / SKL</p>
                        @if($siswa->ijazah_terakhir)
                            <a href="{{ Storage::url($siswa->ijazah_terakhir) }}" target="_blank">
                                <img src="{{ Storage::url($siswa->ijazah_terakhir) }}" alt="Ijazah" class="img-thumbnail" style="height:120px; width:100%; object-fit:contain;">
                                <div class="text-primary small mt-1"><i class="fas fa-search mr-1"></i>Klik untuk perbesar</div>
                            </a>
                        @else
                            <div class="text-muted font-italic p-3 bg-light border text-sm">Belum diunggah</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection