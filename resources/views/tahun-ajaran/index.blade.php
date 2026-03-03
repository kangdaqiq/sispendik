@extends('layouts.app')
@section('title', 'Tahun Ajaran')
@section('page-title', 'Tahun Ajaran')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-calendar-alt" style="color:var(--primary-light)"></i> Daftar Tahun Ajaran</h2>
            <a href="{{ route('tahun-ajaran.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                Tambah</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Semester</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ta as $t)
                        <tr>
                            <td><strong>{{ $t->nama }}</strong></td>
                            <td>{{ ucfirst($t->semester) }}</td>
                            <td class="text-muted">{{ $t->tanggal_mulai->format('d/m/Y') }}</td>
                            <td class="text-muted">{{ $t->tanggal_selesai->format('d/m/Y') }}</td>
                            <td><span
                                    class="badge {{ $t->is_aktif ? 'badge-success' : 'badge-warning' }}">{{ $t->is_aktif ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('tahun-ajaran.edit', $t) }}" class="btn btn-outline btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('tahun-ajaran.destroy', $t) }}" method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty<tr>
                            <td colspan="6" class="text-muted" style="text-align:center;padding:32px">Belum ada tahun ajaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection