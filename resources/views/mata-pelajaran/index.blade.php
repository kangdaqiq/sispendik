@extends('layouts.app')
@section('title', 'Data Mata Pelajaran')
@section('page-title', 'Data Mata Pelajaran')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-book" style="color:var(--warning)"></i> Daftar Mata Pelajaran</h2>
            <a href="{{ route('mata-pelajaran.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                Tambah</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th>KKM</th>
                        <th>Jam/Minggu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataPelajaran as $m)
                        <tr>
                            <td><span class="badge badge-info">{{ $m->kode }}</span></td>
                            <td><strong>{{ $m->nama }}</strong></td>
                            <td class="text-muted">{{ $m->kelompok ?? '-' }}</td>
                            <td>{{ $m->kkm }}</td>
                            <td class="text-muted">{{ $m->jam_per_minggu }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('mata-pelajaran.edit', $m) }}" class="btn btn-outline btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('mata-pelajaran.destroy', $m) }}" method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE') <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty<tr>
                            <td colspan="6" class="text-muted" style="text-align:center;padding:32px">Belum ada mata pelajaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection