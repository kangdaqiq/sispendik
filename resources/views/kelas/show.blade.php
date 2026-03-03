@extends('layouts.app')
@section('title', 'Detail Kelas')
@section('page-title', 'Detail Kelas')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-users" style="color:var(--secondary)"></i> {{ $kelas->nama }} — Daftar Siswa</h2>
            <a href="{{ route('kelas.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i>
                Kembali</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No Absen</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas->siswa as $s)
                        <tr>
                            <td class="text-muted">{{ $s->pivot->nomor_absen ?? '-' }}</td>
                            <td>{{ $s->nis }}</td>
                            <td><strong>{{ $s->nama }}</strong></td>
                            <td>{{ $s->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                            <td><span
                                    class="badge {{ $s->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($s->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted" style="text-align:center;padding:32px">Belum ada siswa di kelas
                                ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection