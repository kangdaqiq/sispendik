@extends('layouts.app')
@section('title', 'Edit Nilai')
@section('page-title', 'Edit Nilai Siswa')
@section('content')
    <div class="card" style="max-width:600px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit Nilai</h2>
            <a href="{{ route('nilai.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <div class="alert alert-success"
                style="background:rgba(79,70,229,.1);border-color:var(--primary);color:var(--primary-light)">
                <strong>{{ $nilai->siswa->nama }}</strong> — {{ $nilai->mataPelajaran->nama }} — {{ $nilai->kelas->nama }}
            </div>
            <form action="{{ route('nilai.update', $nilai) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nilai Tugas</label>
                        <input type="number" name="nilai_tugas" class="form-control" min="0" max="100" step="0.01"
                            value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nilai UTS</label>
                        <input type="number" name="nilai_uts" class="form-control" min="0" max="100" step="0.01"
                            value="{{ old('nilai_uts', $nilai->nilai_uts) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nilai UAS</label>
                        <input type="number" name="nilai_uas" class="form-control" min="0" max="100" step="0.01"
                            value="{{ old('nilai_uas', $nilai->nilai_uas) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $nilai->catatan) }}</textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Nilai</button>
                    <a href="{{ route('nilai.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection