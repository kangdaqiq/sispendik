@extends('layouts.app')
@section('title', 'Edit Siswa')
@section('page-title', 'Edit Data Siswa')
@section('content')
    <div class="card" style="max-width:800px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit: {{ $siswa->nama }}</h2>
            <a href="{{ route('siswa.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i>
                Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row mb-4">
                    <div class="col-md-6 form-group">
                        <label>NIS <span class="text-danger">*</span></label>
                        <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                            value="{{ old('nis', $siswa->nis) }}" required>
                        @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}"
                            required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" class="form-control"
                            value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Agama</label>
                        <select name="agama" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach(['Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $a)
                                <option value="{{ $a }}" {{ old('agama', $siswa->agama) == $a ? 'selected' : '' }}>{{ $a }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>No. HP / WhatsApp Siswa</label>
                        <input type="text" name="no_telp" class="form-control"
                            value="{{ old('no_telp', $siswa->no_telp) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Sekolah Asal</label>
                        <input type="text" name="sekolah_asal" class="form-control"
                            value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label text-warning font-weight-bold">Status Siswa *</label>
                        <select name="status" class="form-control border-warning shadow-sm">
                            @foreach(['aktif', 'nonaktif', 'lulus', 'pindah'] as $st)
                                <option value="{{ $st }}" {{ old('status', $siswa->status) == $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h4 class="mb-3 border-bottom pb-2 text-primary"><i class="fas fa-home"></i> Detail Keluarga & Fisik</h4>
                <div class="row mb-4">
                    <div class="col-md-3 form-group">
                        <label>Anak Ke-</label>
                        <input type="number" name="anak_ke" class="form-control"
                            value="{{ old('anak_ke', $siswa->anak_ke) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Dari (Bersaudara)</label>
                        <input type="number" name="dari_bersaudara" class="form-control"
                            value="{{ old('dari_bersaudara', $siswa->dari_bersaudara) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Status Anak</label>
                        <select name="status_anak" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="kandung" {{ old('status_anak', $siswa->status_anak) == 'kandung' ? 'selected' : '' }}>Anak Kandung</option>
                            <option value="tiri" {{ old('status_anak', $siswa->status_anak) == 'tiri' ? 'selected' : '' }}>
                                Anak Tiri</option>
                            <option value="angkat" {{ old('status_anak', $siswa->status_anak) == 'angkat' ? 'selected' : '' }}>Anak Angkat</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" class="form-control"
                            value="{{ old('berat_badan', $siswa->berat_badan) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" class="form-control"
                            value="{{ old('tinggi_badan', $siswa->tinggi_badan) }}">
                    </div>
                </div>

                <h4 class="mb-3 border-bottom pb-2 text-primary"><i class="fas fa-map-marker-alt"></i> Alamat Siswa</h4>
                <div class="row mb-4">
                    <div class="col-md-3 form-group">
                        <label>Provinsi</label>
                        <select id="provinsi" class="form-control">
                            <option value="">-- Memuat... --</option>
                        </select>
                        <input type="hidden" name="provinsi" id="provinsi_text"
                            value="{{ old('provinsi', $siswa->provinsi) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Kabupaten/Kota</label>
                        <select id="kabupaten" class="form-control">
                            <option value="">-- Memuat/Pilih --</option>
                        </select>
                        <input type="hidden" name="kabupaten" id="kabupaten_text"
                            value="{{ old('kabupaten', $siswa->kabupaten) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Kecamatan</label>
                        <select id="kecamatan" class="form-control">
                            <option value="">-- Memuat/Pilih --</option>
                        </select>
                        <input type="hidden" name="kecamatan" id="kecamatan_text"
                            value="{{ old('kecamatan', $siswa->kecamatan) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Desa/Kelurahan</label>
                        <select id="desa" class="form-control">
                            <option value="">-- Memuat/Pilih --</option>
                        </select>
                        <input type="hidden" name="desa" id="desa_text" value="{{ old('desa', $siswa->desa) }}">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Detail Alamat (Jalan/Dusun)</label>
                        <textarea name="alamat_detail" class="form-control"
                            rows="2">{{ old('alamat_detail', $siswa->alamat_detail) }}</textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>RT</label>
                        <input type="text" name="rt" class="form-control" value="{{ old('rt', $siswa->rt) }}" maxlength="5">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>RW</label>
                        <input type="text" name="rw" class="form-control" value="{{ old('rw', $siswa->rw) }}" maxlength="5">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kode Pos</label>
                        <input type="text" id="kode_pos" name="kode_pos" class="form-control"
                            value="{{ old('kode_pos', $siswa->kode_pos) }}">
                    </div>
                </div>

                <h4 class="mb-3 border-bottom pb-2 text-primary"><i class="fas fa-users"></i> Data Orang Tua</h4>

                <!-- Ayah -->
                <h5 class="mt-3">Data Ayah</h5>
                <div class="row mb-3 bg-light p-3 rounded">
                    <div class="col-md-12 form-group">
                        <label>Status Ayah</label>
                        <select name="status_ayah" id="status_ayah" class="form-control">
                            <option value="masih_hidup" {{ old('status_ayah', $siswa->status_ayah) == 'masih_hidup' ? 'selected' : '' }}>Masih Hidup</option>
                            <option value="sudah_meninggal" {{ old('status_ayah', $siswa->status_ayah) == 'sudah_meninggal' ? 'selected' : '' }}>Sudah Meninggal</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control"
                            value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                    </div>
                    <div class="col-md-4 form-group ayah_detail">
                        <label>Pendidikan Ayah</label>
                        <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="SD/Sederajat" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                            <option value="SMP/Sederajat" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                            <option value="SMA/Sederajat" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'SMA/Sederajat' ? 'selected' : '' }}>SMA / Sederajat</option>
                            <option value="D1-D3" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'D1-D3' ? 'selected' : '' }}>D1 - D3</option>
                            <option value="S1/D4" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'S1/D4' ? 'selected' : '' }}>S1 / D4</option>
                            <option value="S2" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'S3' ? 'selected' : '' }}>S3</option>
                            <option value="Tidak Sekolah" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group ayah_detail">
                        <label>Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control"
                            value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}">
                    </div>
                    <div class="col-md-4 form-group ayah_detail">
                        <label>No. HP Ayah</label>
                        <input type="text" name="no_telp_ayah" id="no_telp_ayah" class="form-control"
                            value="{{ old('no_telp_ayah', $siswa->no_telp_ayah) }}">
                    </div>
                </div>

                <!-- Ibu -->
                <h5 class="mt-4">Data Ibu</h5>
                <div class="row mb-3 bg-light p-3 rounded">
                    <div class="col-md-12 form-group">
                        <label>Status Ibu</label>
                        <select name="status_ibu" id="status_ibu" class="form-control">
                            <option value="masih_hidup" {{ old('status_ibu', $siswa->status_ibu) == 'masih_hidup' ? 'selected' : '' }}>Masih Hidup</option>
                            <option value="sudah_meninggal" {{ old('status_ibu', $siswa->status_ibu) == 'sudah_meninggal' ? 'selected' : '' }}>Sudah Meninggal</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control"
                            value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                    </div>
                    <div class="col-md-4 form-group ibu_detail">
                        <label>Pendidikan Ibu</label>
                        <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="SD/Sederajat" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                            <option value="SMP/Sederajat" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                            <option value="SMA/Sederajat" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'SMA/Sederajat' ? 'selected' : '' }}>SMA / Sederajat</option>
                            <option value="D1-D3" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'D1-D3' ? 'selected' : '' }}>D1 - D3</option>
                            <option value="S1/D4" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'S1/D4' ? 'selected' : '' }}>S1 / D4</option>
                            <option value="S2" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'S2' ? 'selected' : '' }}>
                                S2</option>
                            <option value="S3" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'S3' ? 'selected' : '' }}>
                                S3</option>
                            <option value="Tidak Sekolah" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group ibu_detail">
                        <label>Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control"
                            value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}">
                    </div>
                    <div class="col-md-4 form-group ibu_detail">
                        <label>No. HP Ibu</label>
                        <input type="text" name="no_telp_ibu" id="no_telp_ibu" class="form-control"
                            value="{{ old('no_telp_ibu', $siswa->no_telp_ibu) }}">
                    </div>
                </div>

                <!-- No telp ortu container dimatikan karena sudah dipisah -->
                <div class="row" style="display:none;">
                    <div class="col-md-12 form-group">
                        <label>No. HP / WhatsApp Orang Tua (Ayah / Ibu)</label>
                        <input type="text" name="no_telp_ortu" class="form-control"
                            value="{{ old('no_telp_ortu', $siswa->no_telp_ortu) }}">
                    </div>
                </div>

                <h5 class="mt-4">Alamat Orang Tua</h5>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="alamat_ortu_sama" id="alamat_ortu_sama"
                            value="1" {{ old('alamat_ortu_sama', $siswa->alamat_ortu_sama) ? 'checked' : '' }}>
                        <label class="form-check-label" for="alamat_ortu_sama">
                            Alamat Orang Tua Sama dengan Siswa
                        </label>
                    </div>
                </div>
                <div id="alamat_ortu_container" class="row mb-3 bg-light p-3 rounded" style="position: relative;">
                    <!-- Overlay to visually indicate disabled state -->
                    <div id="alamat_ortu_overlay"
                        style="display: none; position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(249, 250, 251, 0.5); z-index: 5; border-radius: 0.25rem; pointer-events: none;">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Provinsi</label>
                        <select id="provinsi_ortu_select" name="provinsi_ortu_select" class="form-control" required>
                            <option value="">-- Memuat... --</option>
                        </select>
                        <input type="hidden" name="provinsi_ortu" id="provinsi_ortu_text"
                            value="{{ old('provinsi_ortu', $siswa->provinsi_ortu) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Kabupaten/Kota</label>
                        <select id="kabupaten_ortu_select" name="kabupaten_ortu_select" class="form-control" required>
                            <option value="">-- Memuat/Pilih --</option>
                        </select>
                        <input type="hidden" name="kabupaten_ortu" id="kabupaten_ortu_text"
                            value="{{ old('kabupaten_ortu', $siswa->kabupaten_ortu) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Kecamatan</label>
                        <select id="kecamatan_ortu_select" name="kecamatan_ortu_select" class="form-control" required>
                            <option value="">-- Memuat/Pilih --</option>
                        </select>
                        <input type="hidden" name="kecamatan_ortu" id="kecamatan_ortu_text"
                            value="{{ old('kecamatan_ortu', $siswa->kecamatan_ortu) }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Desa/Kelurahan</label>
                        <select id="desa_ortu_select" name="desa_ortu_select" class="form-control" required>
                            <option value="">-- Memuat/Pilih --</option>
                        </select>
                        <input type="hidden" name="desa_ortu" id="desa_ortu_text"
                            value="{{ old('desa_ortu', $siswa->desa_ortu) }}">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Detail Alamat (Jalan/Dusun)</label>
                        <textarea name="alamat_detail_ortu" id="alamat_detail_ortu" class="form-control" rows="2"
                            required>{{ old('alamat_detail_ortu', $siswa->alamat_detail_ortu) }}</textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>RT</label>
                        <input type="text" name="rt_ortu" id="rt_ortu" class="form-control"
                            value="{{ old('rt_ortu', $siswa->rt_ortu) }}" maxlength="5">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>RW</label>
                        <input type="text" name="rw_ortu" id="rw_ortu" class="form-control"
                            value="{{ old('rw_ortu', $siswa->rw_ortu) }}" maxlength="5">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kode Pos</label>
                        <input type="text" id="kode_pos_ortu" name="kode_pos_ortu" class="form-control"
                            value="{{ old('kode_pos_ortu', $siswa->kode_pos_ortu) }}">
                    </div>
                </div>

                <!-- Wali -->
                <div id="data_wali_container" style="display: none;">
                    <h5 class="mt-4 text-warning">Data Wali (Aktif karena kedua ortu meninggal)</h5>
                    <div class="row mb-3 bg-light p-3 rounded border border-warning">
                        <div class="col-md-6 form-group">
                            <label>Nama Wali</label>
                            <input type="text" name="nama_wali" class="form-control"
                                value="{{ old('nama_wali', $siswa->nama_wali) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>No. HP Wali</label>
                            <input type="text" name="no_telp_wali" class="form-control"
                                value="{{ old('no_telp_wali', $siswa->no_telp_wali) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Pendidikan Wali</label>
                            <select name="pendidikan_wali" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="SD/Sederajat" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                <option value="SMP/Sederajat" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA/Sederajat" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'SMA/Sederajat' ? 'selected' : '' }}>SMA / Sederajat</option>
                                <option value="D1-D3" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'D1-D3' ? 'selected' : '' }}>D1 - D3</option>
                                <option value="S1/D4" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'S1/D4' ? 'selected' : '' }}>S1 / D4</option>
                                <option value="S2" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'S3' ? 'selected' : '' }}>S3</option>
                                <option value="Tidak Sekolah" {{ old('pendidikan_wali', $siswa->pendidikan_wali) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Pekerjaan Wali</label>
                            <input type="text" name="pekerjaan_wali" class="form-control"
                                value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}">
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 border-bottom pb-2 text-primary mt-4"><i class="fas fa-file-upload"></i> Upload Dokumen
                    Tersimpan</h4>
                <div class="row mb-4 bg-light p-3 rounded align-items-end">
                    <div class="col-md-3 form-group">
                        <label>Pas Foto Siswa</label>
                        @if($siswa->foto)
                            <div class="mb-2"><img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto" class="img-thumbnail"
                                    width="80"></div>
                        @else
                            <div class="mb-2 text-muted small">Belum ada foto</div>
                        @endif
                        <input type="file" name="foto" class="form-control-file" accept="image/*">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Kartu Keluarga (KK)</label>
                        @if($siswa->foto_kk)
                            <div class="mb-2"><a href="{{ asset('storage/' . $siswa->foto_kk) }}" target="_blank"
                                    class="btn btn-sm btn-info">Lihat KK</a></div>
                        @else
                            <div class="mb-2 text-muted small">Belum ada KK</div>
                        @endif
                        <input type="file" name="foto_kk" class="form-control-file" accept="image/*">
                    </div>
                    <div class="col-md-3 form-group" id="ktp_ortu_container">
                        <label>KTP Orang Tua</label>
                        @if($siswa->foto_ktp_ortu)
                            <div class="mb-2"><a href="{{ asset('storage/' . $siswa->foto_ktp_ortu) }}" target="_blank"
                                    class="btn btn-sm btn-info">Lihat KTP</a></div>
                        @else
                            <div class="mb-2 text-muted small">Belum ada KTP</div>
                        @endif
                        <input type="file" name="foto_ktp_ortu" class="form-control-file" accept="image/*">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Ijazah Terakhir / SKL</label>
                        @if($siswa->ijazah_terakhir)
                            <div class="mb-2"><a href="{{ asset('storage/' . $siswa->ijazah_terakhir) }}" target="_blank"
                                    class="btn btn-sm btn-info">Lihat Ijazah</a></div>
                        @else
                            <div class="mb-2 text-muted small">Belum ada Ijazah</div>
                        @endif
                        <input type="file" name="ijazah_terakhir" class="form-control-file" accept="image/*">
                    </div>
                </div>
                <hr>
                <div class="form-group mb-0 text-right">
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data Siswa</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // --- Parent & Guardian Logic ---
                const statusAyah = document.getElementById('status_ayah');
                const statusIbu = document.getElementById('status_ibu');
                const ayahDetailElements = document.querySelectorAll('.ayah_detail');
                const ibuDetailElements = document.querySelectorAll('.ibu_detail');
                const waliContainer = document.getElementById('data_wali_container');
                const ktpOrtuContainer = document.getElementById('ktp_ortu_container');

                function updateParentLogic() {
                    const ayahMeninggal = statusAyah.value === 'sudah_meninggal';
                    const ibuMeninggal = statusIbu.value === 'sudah_meninggal';

                    // Show/hide Ayah detail
                    ayahDetailElements.forEach(el => el.style.display = ayahMeninggal ? 'none' : 'block');
                    // Show/hide Ayah detail
                    ayahDetailElements.forEach(el => el.style.display = ayahMeninggal ? 'none' : 'block');
                    if (ayahMeninggal && !'{{ old("status_ayah", $siswa->status_ayah) }}') {
                        document.querySelector('select[name="pendidikan_ayah"]').value = '';
                        document.querySelector('input[name="pekerjaan_ayah"]').value = '';
                        document.querySelector('input[name="no_telp_ayah"]').value = '';
                    }

                    // Show/hide Ibu detail
                    ibuDetailElements.forEach(el => el.style.display = ibuMeninggal ? 'none' : 'block');
                    if (ibuMeninggal && !'{{ old("status_ibu", $siswa->status_ibu) }}') {
                        document.querySelector('select[name="pendidikan_ibu"]').value = '';
                        document.querySelector('input[name="pekerjaan_ibu"]').value = '';
                        document.querySelector('input[name="no_telp_ibu"]').value = '';
                    }

                    // Wali logic
                    if (ayahMeninggal && ibuMeninggal) {
                        waliContainer.style.display = 'block';
                        ktpOrtuContainer.style.display = 'none';
                    } else {
                        waliContainer.style.display = 'none';
                        ktpOrtuContainer.style.display = 'block';
                    }
                }

                statusAyah.addEventListener('change', updateParentLogic);
                statusIbu.addEventListener('change', updateParentLogic);
                updateParentLogic(); // Initial check

                // --- Region (Wilayah) Logic using Local API ---
                const elProvinsi = document.getElementById('provinsi');
                const elKabupaten = document.getElementById('kabupaten');
                const elKecamatan = document.getElementById('kecamatan');
                const elDesa = document.getElementById('desa');
                const elKodePos = document.getElementById('kode_pos');

                const hidProvinsi = document.getElementById('provinsi_text');
                const hidKabupaten = document.getElementById('kabupaten_text');
                const hidKecamatan = document.getElementById('kecamatan_text');
                const hidDesa = document.getElementById('desa_text');

                // Initial loaded values
                const initProv = hidProvinsi.value;
                const initKab = hidKabupaten.value;
                const initKec = hidKecamatan.value;
                const initDesa = hidDesa.value;

                // Fetch Provinces
                fetch('/api/wilayah/provinces')
                    .then(res => res.json())
                    .then(data => {
                        let options = '<option value="">-- Pilih Provinsi --</option>';
                        data.forEach(prov => {
                            const selected = (prov.name === initProv) ? 'selected' : '';
                            options += `<option value="${prov.id}" ${selected}>${prov.name}</option>`;
                            if (selected) {
                                loadKabupaten(prov.id, initKab);
                            }
                        });
                        elProvinsi.innerHTML = options;

                        // Sync parent immediately if checked
                        if (typeof syncAlamatSama === 'function' && mainCb.checked) syncAlamatSama();
                    });

                function loadKabupaten(provId, selectedName = null) {
                    elKabupaten.innerHTML = '<option value="">-- Memuat... --</option>';
                    fetch(`/api/wilayah/regencies/${provId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                            data.forEach(kab => {
                                const selected = (kab.name === selectedName) ? 'selected' : '';
                                options += `<option value="${kab.id}" ${selected}>${kab.name}</option>`;
                                if (selected) {
                                    loadKecamatan(kab.id, initKec);
                                }
                            });
                            elKabupaten.innerHTML = options;
                            elKabupaten.disabled = false;

                            if (typeof syncAlamatSama === 'function' && mainCb.checked) syncAlamatSama();
                        });
                }

                function loadKecamatan(kabId, selectedName = null) {
                    elKecamatan.innerHTML = '<option value="">-- Memuat... --</option>';
                    fetch(`/api/wilayah/districts/${kabId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kecamatan --</option>';
                            data.forEach(kec => {
                                const selected = (kec.name === selectedName) ? 'selected' : '';
                                options += `<option value="${kec.id}" ${selected}>${kec.name}</option>`;
                                if (selected) {
                                    loadDesa(kec.id, initDesa);
                                }
                            });
                            elKecamatan.innerHTML = options;
                            elKecamatan.disabled = false;

                            if (typeof syncAlamatSama === 'function' && mainCb.checked) syncAlamatSama();
                        });
                }

                function loadDesa(kecId, selectedName = null) {
                    elDesa.innerHTML = '<option value="">-- Memuat... --</option>';
                    fetch(`/api/wilayah/villages/${kecId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                            data.forEach(desa => {
                                const selected = (desa.name === selectedName) ? 'selected' : '';
                                options += `<option value="${desa.id}" data-postal="${desa.postal_code || ''}" ${selected}>${desa.name}</option>`;
                            });
                            elDesa.innerHTML = options;
                            elDesa.disabled = false;

                            if (typeof syncAlamatSama === 'function' && mainCb.checked) syncAlamatSama();
                        });
                }


                elProvinsi.addEventListener('change', function () {
                    const id = this.value;
                    hidProvinsi.value = this.options[this.selectedIndex]?.text || '';

                    elKabupaten.innerHTML = '<option value="">-- Memuat... --</option>';
                    elKabupaten.disabled = true;
                    elKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    elKecamatan.disabled = true;
                    elDesa.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    elDesa.disabled = true;
                    if (!initProv) elKodePos.value = ''; // Only clear if not initially loading

                    if (id) loadKabupaten(id);
                });

                elKabupaten.addEventListener('change', function () {
                    const id = this.value;
                    hidKabupaten.value = this.options[this.selectedIndex]?.text || '';

                    elKecamatan.innerHTML = '<option value="">-- Memuat... --</option>';
                    elKecamatan.disabled = true;
                    elDesa.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    elDesa.disabled = true;
                    if (!initKab) elKodePos.value = '';

                    if (id) loadKecamatan(id);
                });

                elKecamatan.addEventListener('change', function () {
                    const id = this.value;
                    hidKecamatan.value = this.options[this.selectedIndex]?.text || '';

                    elDesa.innerHTML = '<option value="">-- Memuat... --</option>';
                    elDesa.disabled = true;
                    if (!initKec) elKodePos.value = '';

                    if (id) loadDesa(id);
                });

                elDesa.addEventListener('change', function () {
                    hidDesa.value = this.options[this.selectedIndex]?.text || '';
                    const postalCode = this.options[this.selectedIndex]?.getAttribute('data-postal') || '';
                    if (postalCode && !elKodePos.value) elKodePos.value = postalCode;
                });

                // --- 2. Address Logic Sync & Parent Fetch ---
                const cbAlamatSama = document.getElementById('alamat_ortu_sama');
                const containerAlamatOrtu = document.getElementById('alamat_ortu_container');
                const overlayAlamatOrtu = document.getElementById('alamat_ortu_overlay');

                let mainCb = cbAlamatSama;

                const provSdn = elProvinsi;
                const kabSdn = elKabupaten;
                const kecSdn = elKecamatan;
                const desaSdn = elDesa;
                const detailSdn = document.querySelector('textarea[name="alamat_detail"]');
                const rtSdn = document.querySelector('input[name="rt"]');
                const rwSdn = document.querySelector('input[name="rw"]');
                const posSdn = document.querySelector('input[name="kode_pos"]');

                const provOrtu = document.getElementById('provinsi_ortu_select');
                const kabOrtu = document.getElementById('kabupaten_ortu_select');
                const kecOrtu = document.getElementById('kecamatan_ortu_select');
                const desaOrtu = document.getElementById('desa_ortu_select');
                const detailOrtu = document.getElementById('alamat_detail_ortu');
                const rtOrtu = document.getElementById('rt_ortu');
                const rwOrtu = document.getElementById('rw_ortu');
                const posOrtu = document.getElementById('kode_pos_ortu');

                const provTextOrtu = document.getElementById('provinsi_ortu_text');
                const kabTextOrtu = document.getElementById('kabupaten_ortu_text');
                const kecTextOrtu = document.getElementById('kecamatan_ortu_text');
                const desaTextOrtu = document.getElementById('desa_ortu_text');

                const initProvOrtu = provTextOrtu.value;
                const initKabOrtu = kabTextOrtu.value;
                const initKecOrtu = kecTextOrtu.value;
                const initDesaOrtu = desaTextOrtu.value;

                // Initial fetch for parent province
                fetch('/api/wilayah/provinces')
                    .then(res => res.json())
                    .then(data => {
                        let options = '<option value="">-- Pilih Provinsi --</option>';
                        data.forEach(prov => {
                            const selected = (prov.name === initProvOrtu) ? 'selected' : '';
                            options += `<option value="${prov.id}" ${selected}>${prov.name}</option>`;
                        });
                        provOrtu.innerHTML = options;

                        if (initProvOrtu && !mainCb.checked) {
                            const selectedProvId = data.find(p => p.name === initProvOrtu)?.id;
                            if (selectedProvId) loadKabupatenOrtu(selectedProvId, initKabOrtu);
                        }
                    });

                function loadKabupatenOrtu(provId, selectedName = null) {
                    kabOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                    fetch(`/api/wilayah/regencies/${provId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                            data.forEach(kab => {
                                const selected = (kab.name === selectedName) ? 'selected' : '';
                                options += `<option value="${kab.id}" ${selected}>${kab.name}</option>`;
                            });
                            kabOrtu.innerHTML = options;
                            if (!mainCb.checked) kabOrtu.disabled = false;

                            if (selectedName && !mainCb.checked) {
                                const selectedKabId = data.find(k => k.name === selectedName)?.id;
                                if (selectedKabId) loadKecamatanOrtu(selectedKabId, initKecOrtu);
                            }
                        });
                }

                function loadKecamatanOrtu(kabId, selectedName = null) {
                    kecOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                    fetch(`/api/wilayah/districts/${kabId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kecamatan --</option>';
                            data.forEach(kec => {
                                const selected = (kec.name === selectedName) ? 'selected' : '';
                                options += `<option value="${kec.id}" ${selected}>${kec.name}</option>`;
                            });
                            kecOrtu.innerHTML = options;
                            if (!mainCb.checked) kecOrtu.disabled = false;

                            if (selectedName && !mainCb.checked) {
                                const selectedKecId = data.find(k => k.name === selectedName)?.id;
                                if (selectedKecId) loadDesaOrtu(selectedKecId, initDesaOrtu);
                            }
                        });
                }

                function loadDesaOrtu(kecId, selectedName = null) {
                    desaOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                    fetch(`/api/wilayah/villages/${kecId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                            data.forEach(desa => {
                                const selected = (desa.name === selectedName) ? 'selected' : '';
                                options += `<option value="${desa.id}" data-postal="${desa.postal_code || ''}" ${selected}>${desa.name}</option>`;
                            });
                            desaOrtu.innerHTML = options;
                            if (!mainCb.checked) desaOrtu.disabled = false;
                        });
                }

                provOrtu.addEventListener('change', function () {
                    const id = this.value;
                    provTextOrtu.value = this.options[this.selectedIndex]?.text || '';

                    kabOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                    kabOrtu.disabled = true;
                    kecOrtu.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    kecOrtu.disabled = true;
                    desaOrtu.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    desaOrtu.disabled = true;
                    if (!initProvOrtu) posOrtu.value = '';

                    if (id) loadKabupatenOrtu(id);
                });

                kabOrtu.addEventListener('change', function () {
                    const id = this.value;
                    kabTextOrtu.value = this.options[this.selectedIndex]?.text || '';

                    kecOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                    kecOrtu.disabled = true;
                    desaOrtu.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    desaOrtu.disabled = true;
                    if (!initKabOrtu) posOrtu.value = '';

                    if (id) loadKecamatanOrtu(id);
                });

                kecOrtu.addEventListener('change', function () {
                    const id = this.value;
                    kecTextOrtu.value = this.options[this.selectedIndex]?.text || '';

                    desaOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                    desaOrtu.disabled = true;
                    if (!initKecOrtu) posOrtu.value = '';

                    if (id) loadDesaOrtu(id);
                });

                desaOrtu.addEventListener('change', function () {
                    desaTextOrtu.value = this.options[this.selectedIndex]?.text || '';
                    const postalCode = this.options[this.selectedIndex]?.getAttribute('data-postal') || '';
                    if (postalCode && !posOrtu.value) posOrtu.value = postalCode;
                });

                function syncAlamatSama() {
                    if (mainCb.checked) {
                        if (provSdn.options[provSdn.selectedIndex]) {
                            provOrtu.innerHTML = `<option value="${provSdn.value}">${provSdn.options[provSdn.selectedIndex].text}</option>`;
                            provTextOrtu.value = document.getElementById('provinsi_text').value;
                        }
                        if (kabSdn.options[kabSdn.selectedIndex] && kabSdn.value) {
                            kabOrtu.innerHTML = `<option value="${kabSdn.value}">${kabSdn.options[kabSdn.selectedIndex].text}</option>`;
                            kabTextOrtu.value = document.getElementById('kabupaten_text').value;
                        }
                        if (kecSdn.options[kecSdn.selectedIndex] && kecSdn.value) {
                            kecOrtu.innerHTML = `<option value="${kecSdn.value}">${kecSdn.options[kecSdn.selectedIndex].text}</option>`;
                            kecTextOrtu.value = document.getElementById('kecamatan_text').value;
                        }
                        if (desaSdn.options[desaSdn.selectedIndex] && desaSdn.value) {
                            desaOrtu.innerHTML = `<option value="${desaSdn.value}">${desaSdn.options[desaSdn.selectedIndex].text}</option>`;
                            desaTextOrtu.value = document.getElementById('desa_text').value;
                        }

                        detailOrtu.value = detailSdn.value;
                        rtOrtu.value = rtSdn.value;
                        rwOrtu.value = rwSdn.value;
                        posOrtu.value = posSdn.value;
                    }
                }

                let isAlamatLoad = true;
                function updateAlamatLogic() {
                    if (mainCb.checked) {
                        overlayAlamatOrtu.style.display = 'block';

                        provOrtu.disabled = true;
                        kabOrtu.disabled = true;
                        kecOrtu.disabled = true;
                        desaOrtu.disabled = true;
                        detailOrtu.readOnly = true;
                        rtOrtu.readOnly = true;
                        rwOrtu.readOnly = true;
                        posOrtu.readOnly = true;

                        provOrtu.removeAttribute('required');
                        kabOrtu.removeAttribute('required');
                        kecOrtu.removeAttribute('required');
                        desaOrtu.removeAttribute('required');
                        detailOrtu.removeAttribute('required');

                        syncAlamatSama();
                    } else {
                        overlayAlamatOrtu.style.display = 'none';

                        provOrtu.disabled = false;
                        kabOrtu.disabled = !provOrtu.value;
                        kecOrtu.disabled = !kabOrtu.value;
                        desaOrtu.disabled = !kecOrtu.value;

                        detailOrtu.readOnly = false;
                        rtOrtu.readOnly = false;
                        rwOrtu.readOnly = false;
                        posOrtu.readOnly = false;

                        provOrtu.setAttribute('required', 'required');
                        kabOrtu.setAttribute('required', 'required');
                        kecOrtu.setAttribute('required', 'required');
                        desaOrtu.setAttribute('required', 'required');
                        detailOrtu.setAttribute('required', 'required');

                        if (!isAlamatLoad) {
                            const cProv = provOrtu.value;
                            const cKab = kabOrtu.value;
                            const cKec = kecOrtu.value;
                            const cDesa = desaOrtu.value;

                            fetch('/api/wilayah/provinces').then(r => r.json()).then(d => {
                                let opt = '<option value="">-- Pilih Provinsi --</option>';
                                d.forEach(x => opt += `<option value="${x.id}">${x.name}</option>`);
                                provOrtu.innerHTML = opt;
                                provOrtu.value = cProv;
                            });

                            if (cProv) {
                                fetch(`/api/wilayah/regencies/${cProv}`).then(r => r.json()).then(d => {
                                    let opt = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                                    d.forEach(x => opt += `<option value="${x.id}">${x.name}</option>`);
                                    kabOrtu.innerHTML = opt;
                                    kabOrtu.value = cKab;
                                    kabOrtu.disabled = false;
                                });
                            }
                            if (cKab) {
                                fetch(`/api/wilayah/districts/${cKab}`).then(r => r.json()).then(d => {
                                    let opt = '<option value="">-- Pilih Kecamatan --</option>';
                                    d.forEach(x => opt += `<option value="${x.id}">${x.name}</option>`);
                                    kecOrtu.innerHTML = opt;
                                    kecOrtu.value = cKec;
                                    kecOrtu.disabled = false;
                                });
                            }
                            if (cKec) {
                                fetch(`/api/wilayah/villages/${cKec}`).then(r => r.json()).then(d => {
                                    let opt = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                                    d.forEach(x => opt += `<option value="${x.id}" data-postal="${x.postal_code || ''}">${x.name}</option>`);
                                    desaOrtu.innerHTML = opt;
                                    desaOrtu.value = cDesa;
                                    desaOrtu.disabled = false;
                                });
                            }
                        }
                    }
                    isAlamatLoad = false;
                }

                mainCb.addEventListener('change', updateAlamatLogic);

                [provSdn, kabSdn, kecSdn, desaSdn].forEach(el => el.addEventListener('change', () => {
                    if (mainCb.checked) syncAlamatSama();
                }));
                [detailSdn, rtSdn, rwSdn, posSdn].forEach(el => el.addEventListener('input', () => {
                    if (mainCb.checked) syncAlamatSama();
                }));

                // Call updateAlamatLogic on load to enforce the current checkbox state
                setTimeout(updateAlamatLogic, 500);
            });
        </script>
    @endpush
@endsection