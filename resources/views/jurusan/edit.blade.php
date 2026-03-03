@extends('layouts.app')
@section('title', 'Edit Jurusan')
@section('page-title', 'Edit Jurusan')
@section('content')
    <div class="card" style="max-width:500px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit Jurusan</h2>
            <a href="{{ route('jurusan.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('jurusan.update', $jurusan) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Kode Jurusan *</label>
                    <input type="text" name="kode" class="form-control" value="{{ old('kode', $jurusan->kode) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Jurusan *</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $jurusan->nama) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"
                        rows="3">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('jurusan.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection