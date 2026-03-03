@extends('layouts.app')
@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal Pelajaran')
@section('content')
    <div class="card" style="max-width:600px">
        <div class="card-header">
            <h2><i class="fas fa-plus" style="color:var(--success)"></i> Form Jadwal Pelajaran</h2>
            <a href="{{ route('jadwal.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tahun Ajaran Aktif *</label>
                        <select name="tahun_ajaran_id" class="form-control" required>
                            @if($ta)
                            <option value="{{ $ta->id }}">{{ $ta->nama }} - {{ ucfirst($ta->semester) }}</option>@endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas *</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mata Pelajaran *</label>
                        <select name="mata_pelajaran_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($mapel as $m)<option value="{{ $m->id }}">{{ $m->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Guru Pengajar *</label>
                        <select name="guru_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($guru as $g)<option value="{{ $g->id }}">{{ $g->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hari *</label>
                        <select name="hari" class="form-control" required>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)<option value="{{ $h }}">
                            {{ $h }}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Jam Mulai *</label>
                        <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Selesai *</label>
                        <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}"
                            required>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection