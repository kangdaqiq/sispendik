@extends('layouts.app')
@section('title', 'Edit Tahun Ajaran')
@section('page-title', 'Edit Tahun Ajaran')
@section('content')
    <div class="card" style="max-width:500px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit Tahun Ajaran</h2>
            <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('tahun-ajaran.update', $tahunAjaran) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama *</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $tahunAjaran->nama) }}"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Semester *</label>
                    <select name="semester" class="form-control" required>
                        <option value="ganjil" {{ $tahunAjaran->semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ $tahunAjaran->semester == 'genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai *</label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                            value="{{ old('tanggal_mulai', $tahunAjaran->tanggal_mulai->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai *</label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                            value="{{ old('tanggal_selesai', $tahunAjaran->tanggal_selesai->format('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ $tahunAjaran->is_aktif ? 'checked' : '' }}>
                        <span class="form-label" style="margin:0">Jadikan Aktif</span>
                    </label>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection