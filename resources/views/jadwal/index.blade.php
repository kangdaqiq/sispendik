@extends('layouts.app')
@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-clock" style="color:var(--secondary)"></i> Daftar Jadwal</h2>
            <div class="flex gap-2">
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah
                    Jadwal</a>
                <a href="{{ route('jadwal.bulk-create') }}" class="btn btn-info btn-sm"><i class="fas fa-layer-group"></i>
                    Bulk Tambah Jadwal</a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $j)
                        <tr>
                            <td><strong>{{ $j->kelas->nama }}</strong></td>
                            <td><span class="badge badge-info">{{ $j->hari }}</span></td>
                            <td class="text-muted">{{ $j->jam_mulai }} – {{ $j->jam_selesai }}</td>
                            <td>{{ $j->mataPelajaran->nama }}</td>
                            <td class="text-muted">{{ $j->guru->nama }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('jadwal.edit', $j) }}" class="btn btn-outline btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('jadwal.destroy', $j) }}" method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE') <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty<tr>
                            <td colspan="6" class="text-muted" style="text-align:center;padding:32px">Belum ada jadwal</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection