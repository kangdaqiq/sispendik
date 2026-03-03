@extends('layouts.app')
@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-door-open" style="color:var(--success)"></i> Daftar Kelas</h2>
            <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah
                Kelas</a>
        </div>
        <div class="card-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th>Kapasitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $i => $k)
                            <tr>
                                <td class="text-muted">{{ $kelas->firstItem() + $i }}</td>
                                <td><strong>{{ $k->nama }}</strong> <span class="badge badge-info">{{ $k->tingkat }}</span></td>
                                <td class="text-muted">{{ $k->tahunAjaran->nama }}</td>
                                <td>{{ $k->jurusan?->nama ?? '-' }}</td>
                                <td>{{ $k->waliKelas?->nama ?? '-' }}</td>
                                <td class="text-muted">{{ $k->kapasitas }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('kelas.show', $k) }}" class="btn btn-outline btn-sm"><i
                                                class="fas fa-users"></i></a>
                                        <a href="{{ route('kelas.edit', $k) }}" class="btn btn-outline btn-sm"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('kelas.destroy', $k) }}" method="POST"
                                            onsubmit="return confirm('Hapus kelas ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted" style="text-align:center;padding:32px">Belum ada kelas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $kelas->links() }}</div>
        </div>
    </div>
@endsection