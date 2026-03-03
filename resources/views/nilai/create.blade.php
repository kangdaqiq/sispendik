@extends('layouts.app')
@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai Siswa')
@section('content')
    <div class="card" style="max-width:700px">
        <div class="card-header">
            <h2><i class="fas fa-star" style="color:var(--warning)"></i> Form Input Nilai</h2>
            <a href="{{ route('nilai.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i>
                Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('nilai.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tahun Ajaran *</label>
                        <select name="tahun_ajaran_id" class="form-control" required>
                            @if($ta)
                                <option value="{{ $ta->id }}" selected>{{ $ta->nama }} - {{ ucfirst($ta->semester) }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas *</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)<option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Siswa *</label>
                        <select name="siswa_id" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)<option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mata Pelajaran *</label>
                        <select name="mata_pelajaran_id" class="form-control" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapel as $m)<option value="{{ $m->id }}">{{ $m->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Guru *</label>
                        <select name="guru_id" class="form-control" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru as $g)<option value="{{ $g->id }}">{{ $g->nama }}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nilai Tugas</label>
                        <input type="number" name="nilai_tugas" class="form-control" min="0" max="100" step="0.01"
                            value="{{ old('nilai_tugas') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nilai UTS</label>
                        <input type="number" name="nilai_uts" class="form-control" min="0" max="100" step="0.01"
                            value="{{ old('nilai_uts') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nilai UAS</label>
                        <input type="number" name="nilai_uas" class="form-control" min="0" max="100" step="0.01"
                            value="{{ old('nilai_uas') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2"
                        placeholder="Opsional...">{{ old('catatan') }}</textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Nilai</button>
                    <a href="{{ route('nilai.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection