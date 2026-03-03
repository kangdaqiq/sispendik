@extends('layouts.app')
@section('title', 'Tambah Tahun Ajaran')
@section('page-title', 'Tambah Tahun Ajaran')
@section('content')
    <div class="card" style="max-width:500px">
        <div class="card-header">
            <h2><i class="fas fa-plus" style="color:var(--success)"></i> Form Tahun Ajaran</h2>
            <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('tahun-ajaran.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama *</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: 2025/2026"
                        value="{{ old('nama') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Semester *</label>
                    <select name="semester" class="form-control" required>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai *</label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai *</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif') ? 'checked' : '' }}>
                        <span class="form-label" style="margin:0">Jadikan Aktif</span>
                    </label>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection