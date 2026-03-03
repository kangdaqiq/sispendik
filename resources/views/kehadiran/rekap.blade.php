@extends('layouts.app')
@section('title', 'Rekap Kehadiran')
@section('page-title', 'Rekap Kehadiran per Kelas')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-chart-bar" style="color:var(--primary-light)"></i> Rekap Kehadiran</h2>
        </div>
        <div class="card-body">
            <form method="GET" class="search-row">
                <select name="kelas_id" class="form-control" style="width:220px" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)<option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}</option>@endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Tampilkan</button>
            </form>
            @if(count($data))
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Siswa</th>
                                <th style="color:var(--success)"><i class="fas fa-check"></i> Hadir</th>
                                <th style="color:var(--warning)"><i class="fas fa-procedures"></i> Sakit</th>
                                <th style="color:var(--secondary)"><i class="fas fa-file-alt"></i> Izin</th>
                                <th style="color:var(--danger)"><i class="fas fa-times"></i> Alpha</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $i => $d)
                                <tr>
                                    <td class="text-muted">{{ $i + 1 }}</td>
                                    <td><strong>{{ $d['siswa']->nama }}</strong></td>
                                    <td style="color:var(--success)">{{ $d['hadir'] }}</td>
                                    <td style="color:var(--warning)">{{ $d['sakit'] }}</td>
                                    <td style="color:var(--secondary)">{{ $d['izin'] }}</td>
                                    <td style="color:var(--danger)">{{ $d['alpha'] }}</td>
                                    <td class="text-muted">{{ $d['hadir'] + $d['sakit'] + $d['izin'] + $d['alpha'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(request('kelas_id'))
                <div class="text-muted" style="text-align:center;padding:40px">Tidak ada data kehadiran untuk kelas ini.</div>
            @endif
        </div>
    </div>
@endsection