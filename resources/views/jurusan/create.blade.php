@extends('layouts.app')
@section('title', 'Tambah Jurusan')
@section('page-title', 'Tambah Jurusan')
@section('content')
    <div class="card" style="max-width:500px">
        <div class="card-header">
            <h2><i class="fas fa-plus" style="color:var(--success)"></i> Form Jurusan</h2>
            <a href="{{ route('jurusan.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('jurusan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Kode Jurusan *</label>
                    <input type="text" name="kode" class="form-control" placeholder="MIPA" value="{{ old('kode') }}"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Jurusan *</label>
                    <input type="text" name="nama" class="form-control" placeholder="Matematika dan Ilmu Pengetahuan Alam"
                        value="{{ old('nama') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('jurusan.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection