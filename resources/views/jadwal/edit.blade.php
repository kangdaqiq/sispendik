@extends('layouts.app')
@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal Pelajaran')
@section('content')
    <div class="card" style="max-width:600px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit Jadwal</h2>
            <a href="{{ route('jadwal.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.update', $jadwal) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tahun Ajaran *</label>
                        <select name="tahun_ajaran_id" class="form-control" required>
                            @foreach($ta as $t)<option value="{{ $t->id }}" {{ $jadwal->tahun_ajaran_id == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas *</label>
                        <select name="kelas_id" class="form-control" required>
                            @foreach($kelas as $k)<option value="{{ $k->id }}" {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mata Pelajaran *</label>
                        <select name="mata_pelajaran_id" class="form-control" required>
                            @foreach($mapel as $m)<option value="{{ $m->id }}" {{ $jadwal->mata_pelajaran_id == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Guru Pengajar *</label>
                        <select name="guru_id" class="form-control" required>
                            @foreach($guru as $g)<option value="{{ $g->id }}" {{ $jadwal->guru_id == $g->id ? 'selected' : '' }}>
                            {{ $g->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hari *</label>
                        <select name="hari" class="form-control" required>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)<option value="{{ $h }}" {{ $jadwal->hari == $h ? 'selected' : '' }}>{{ $h }}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Jam Mulai *</label>
                        <input type="time" name="jam_mulai" class="form-control"
                            value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Selesai *</label>
                        <input type="time" name="jam_selesai" class="form-control"
                            value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}"
                            required>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection