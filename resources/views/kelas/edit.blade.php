@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('page-title', 'Edit Kelas')
@section('content')
    <div class="card" style="max-width:600px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit: {{ $kelas->nama }}</h2>
            <a href="{{ route('kelas.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas.update', $kelas) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tahun Ajaran *</label>
                        <select name="tahun_ajaran_id" class="form-control" required>
                            @foreach($ta as $t)<option value="{{ $t->id }}" {{ $kelas->tahun_ajaran_id == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tingkat *</label>
                        <select name="tingkat" class="form-control" required>
                            @foreach(['X', 'XI', 'XII'] as $tg)<option value="{{ $tg }}" {{ $kelas->tingkat == $tg ? 'selected' : '' }}>{{ $tg }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Kelas *</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $kelas->nama) }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jurusan</label>
                        <select name="jurusan_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach($jurusan as $j)<option value="{{ $j->id }}" {{ $kelas->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Wali Kelas</label>
                        <select name="wali_kelas_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach($guru as $g)<option value="{{ $g->id }}" {{ $kelas->wali_kelas_id == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control"
                            value="{{ old('kapasitas', $kelas->kapasitas) }}" min="1">
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('kelas.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection