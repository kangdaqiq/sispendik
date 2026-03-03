@extends('layouts.app')
@section('title', 'Kehadiran')
@section('page-title', 'Data Kehadiran')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-clipboard-check" style="color:var(--success)"></i> Data Kehadiran</h2>
            <a href="{{ route('kehadiran.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Input
                Kehadiran</a>
        </div>
        <div class="card-body">
            <form method="GET" class="search-row">
                <select name="kelas_id" class="form-control" style="width:180px">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)<option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}</option>@endforeach
                </select>
                <input type="date" name="tanggal" class="form-control" style="width:160px" value="{{ request('tanggal') }}">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
            </form>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kehadiran as $kh)
                            <tr>
                                <td>{{ $kh->tanggal->format('d/m/Y') }}</td>
                                <td><strong>{{ $kh->siswa->nama }}</strong></td>
                                <td class="text-muted">{{ $kh->kelas->nama }}</td>
                                <td>
                                    <span
                                        class="badge {{ match ($kh->status) { 'hadir' => 'badge-success', 'sakit' => 'badge-warning', 'izin' => 'badge-info', default => 'badge-danger'} }}">
                                        {{ ucfirst($kh->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $kh->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('kehadiran.edit', $kh) }}" class="btn btn-outline btn-sm"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('kehadiran.destroy', $kh) }}" method="POST"
                                            onsubmit="return confirm('Hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted" style="text-align:center;padding:32px">Belum ada data
                                    kehadiran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $kehadiran->links() }}</div>
        </div>
    </div>
@endsection