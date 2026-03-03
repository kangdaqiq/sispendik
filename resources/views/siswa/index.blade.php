@extends('layouts.app')
@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-user-graduate" style="color:var(--primary-light)"></i> Daftar Siswa</h2>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah
                Siswa</a>
        </div>
        <div class="card-body">
            <form method="GET" class="search-row">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari nama / NIS..." value="{{ request('search') }}">
                </div>
                <select name="status" class="form-control" style="width:160px">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
            </form>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $i => $s)
                            <tr>
                                <td class="text-muted">{{ $siswa->firstItem() + $i }}</td>
                                <td>{{ $s->nis }}</td>
                                <td><strong>{{ $s->nama }}</strong></td>
                                <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="text-muted">{{ $s->kelasAktif()?->nama ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge {{ match ($s->status) { 'aktif' => 'badge-success', 'lulus' => 'badge-info', default => 'badge-danger'} }}">
                                        {{ ucfirst($s->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('siswa.show', $s) }}" class="btn btn-outline btn-sm" title="Detail"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('siswa.edit', $s) }}" class="btn btn-outline btn-sm" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('siswa.destroy', $s) }}" method="POST"
                                            onsubmit="return confirm('Hapus siswa ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted" style="text-align:center;padding:32px">Tidak ada data siswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $siswa->links() }}</div>
        </div>
    </div>
@endsection