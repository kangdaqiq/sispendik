@extends('layouts.app')
@section('title', 'Edit Mata Pelajaran')
@section('page-title', 'Edit Mata Pelajaran')
@section('content')
    <div class="card" style="max-width:600px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit Mata Pelajaran</h2>
            <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-outline btn-sm"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('mata-pelajaran.update', $mataPelajaran) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Kode Mapel *</label>
                        <input type="text" name="kode" class="form-control" value="{{ old('kode', $mataPelajaran->kode) }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Mapel *</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $mataPelajaran->nama) }}"
                            required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Kelompok</label>
                        <input type="text" name="kelompok" class="form-control"
                            value="{{ old('kelompok', $mataPelajaran->kelompok) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">KKM</label>
                        <input type="number" name="kkm" class="form-control" min="0" max="100"
                            value="{{ old('kkm', $mataPelajaran->kkm) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam/Minggu</label>
                        <input type="number" name="jam_per_minggu" class="form-control" min="1"
                            value="{{ old('jam_per_minggu', $mataPelajaran->jam_per_minggu) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"
                        rows="2">{{ old('deskripsi', $mataPelajaran->deskripsi) }}</textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection