@extends('layouts.app')
@section('title', 'Data Guru')
@section('page-title', 'Data Guru')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-chalkboard-teacher" style="color:var(--secondary)"></i> Daftar Guru</h2>
            <a href="{{ route('guru.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Guru</a>
        </div>
        <div class="card-body">
            <form method="GET" class="search-row">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari nama / NIP..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Cari</button>
            </form>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>No. Telp</th>
                            <th>Pendidikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guru as $i => $g)
                            <tr>
                                <td class="text-muted">{{ $guru->firstItem() + $i }}</td>
                                <td class="text-muted">{{ $g->nip ?? '-' }}</td>
                                <td><strong>{{ $g->nama }}</strong></td>
                                <td>{{ $g->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                                <td class="text-muted">{{ $g->no_telp ?? '-' }}</td>
                                <td class="text-muted">{{ $g->pendidikan_terakhir ?? '-' }}</td>
                                <td><span
                                        class="badge {{ $g->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($g->status) }}</span>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('guru.edit', $g) }}" class="btn btn-outline btn-sm"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('guru.destroy', $g) }}" method="POST"
                                            onsubmit="return confirm('Hapus guru ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted" style="text-align:center;padding:32px">Tidak ada data guru
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $guru->links() }}</div>
        </div>
    </div>
@endsection