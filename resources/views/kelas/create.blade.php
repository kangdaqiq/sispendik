@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas Baru')
@section('content')
    <div class="card" style="max-width:600px">
        <div class="card-header">
            <h2><i class="fas fa-plus" style="color:var(--success)"></i> Form Kelas</h2>
            <a href="{{ route('kelas.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tahun Ajaran *</label>
                        <select name="tahun_ajaran_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($ta as $t)<option value="{{ $t->id }}" {{ $t->is_aktif ? 'selected' : '' }}>{{ $t->nama }}
                            - {{ ucfirst($t->semester) }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tingkat *</label>
                        <select name="tingkat" class="form-control" required>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Kelas *</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: X-IPA-1"
                            value="{{ old('nama') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jurusan</label>
                        <select name="jurusan_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach($jurusan as $j)<option value="{{ $j->id }}">{{ $j->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Wali Kelas</label>
                        <select name="wali_kelas_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach($guru as $g)<option value="{{ $g->id }}">{{ $g->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', 35) }}"
                            min="1">
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('kelas.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection