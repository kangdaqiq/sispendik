@extends('layouts.app')
@section('title', 'Input Kehadiran')
@section('page-title', 'Input Kehadiran')
@section('content')
    <div class="card" style="max-width:700px">
        <div class="card-header">
            <h2><i class="fas fa-clipboard-check" style="color:var(--success)"></i> Form Input Kehadiran</h2>
            <a href="{{ route('kehadiran.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('kehadiran.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Siswa *</label>
                        <select name="siswa_id" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)<option value="{{ $s->id }}">{{ $s->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelas *</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal *</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ today()->format('Y-m-d') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="hadir">Hadir</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional..."></textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('kehadiran.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection