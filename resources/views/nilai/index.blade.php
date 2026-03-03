@extends('layouts.app')
@section('title', 'Data Nilai')
@section('page-title', 'Penilaian Siswa')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-star" style="color:var(--warning)"></i> Data Nilai</h2>
            <a href="{{ route('nilai.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Input Nilai</a>
        </div>
        <div class="card-body">
            <form method="GET" class="search-row">
                <select name="kelas_id" class="form-control" style="width:180px">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
                <select name="mata_pelajaran_id" class="form-control" style="width:180px">
                    <option value="">Semua Mapel</option>
                    @foreach($mapel as $m)
                        <option value="{{ $m->id }}" {{ request('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
            </form>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Akhir</th>
                            <th>Predikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilai as $n)
                            <tr>
                                <td><strong>{{ $n->siswa->nama }}</strong></td>
                                <td class="text-muted">{{ $n->kelas->nama }}</td>
                                <td>{{ $n->mataPelajaran->nama }}</td>
                                <td>{{ $n->nilai_tugas ?? '-' }}</td>
                                <td>{{ $n->nilai_uts ?? '-' }}</td>
                                <td>{{ $n->nilai_uas ?? '-' }}</td>
                                <td><strong>{{ $n->nilai_akhir ?? '-' }}</strong></td>
                                <td>
                                    @if($n->predikat)
                                        <span
                                            class="badge {{ match ($n->predikat) { 'A' => 'badge-success', 'B' => 'badge-info', 'C' => 'badge-warning', default => 'badge-danger'} }}">{{ $n->predikat }}</span>
                                    @else -
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('nilai.edit', $n) }}" class="btn btn-outline btn-sm"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('nilai.destroy', $n) }}" method="POST"
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
                                <td colspan="9" class="text-muted" style="text-align:center;padding:32px">Belum ada data nilai
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $nilai->links() }}</div>
        </div>
    </div>
@endsection