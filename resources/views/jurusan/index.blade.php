@extends('layouts.app')
@section('title', 'Jurusan')
@section('page-title', 'Data Jurusan')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-code-branch" style="color:var(--primary-light)"></i> Daftar Jurusan</h2>
            <a href="{{ route('jurusan.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusan as $j)
                        <tr>
                            <td><span class="badge badge-info">{{ $j->kode }}</span></td>
                            <td><strong>{{ $j->nama }}</strong></td>
                            <td class="text-muted">{{ $j->deskripsi ?? '-' }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('jurusan.edit', $j) }}" class="btn btn-outline btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('jurusan.destroy', $j) }}" method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE') <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty<tr>
                            <td colspan="4" class="text-muted" style="text-align:center;padding:32px">Belum ada jurusan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection