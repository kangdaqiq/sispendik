@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <!-- Stat Cards Row -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $data['total_siswa'] }}</h3>
                    <p>Total Siswa Aktif</p>
                </div>
                <div class="icon"><i class="fas fa-user-graduate"></i></div>
                <a href="{{ route('siswa.index') }}" class="small-box-footer">
                    Lihat Semua <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $data['total_guru'] }}</h3>
                    <p>Total Guru Aktif</p>
                </div>
                <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <a href="{{ route('guru.index') }}" class="small-box-footer">
                    Lihat Semua <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $data['total_kelas'] }}</h3>
                    <p>Total Kelas</p>
                </div>
                <div class="icon"><i class="fas fa-door-open"></i></div>
                <a href="{{ route('kelas.index') }}" class="small-box-footer">
                    Lihat Semua <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3 style="font-size:1.4rem;">{{ $data['tahun_ajaran']?->nama ?? '-' }}</h3>
                    <p>Tahun Ajaran — {{ ucfirst($data['tahun_ajaran']?->semester ?? '-') }}</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                <a href="{{ route('tahun-ajaran.index') }}" class="small-box-footer">
                    Atur <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-graduate mr-1"></i> Siswa Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Siswa::latest()->take(5)->get() as $s)
                                <tr>
                                    <td class="text-muted">{{ $s->nis }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>
                                        <span class="badge badge-{{ $s->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($s->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Belum ada siswa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chalkboard-teacher mr-1"></i> Guru Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('guru.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Guru::latest()->take(5)->get() as $g)
                                <tr>
                                    <td class="text-muted">{{ $g->nip ?? '-' }}</td>
                                    <td>{{ $g->nama }}</td>
                                    <td>
                                        <span class="badge badge-{{ $g->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($g->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Belum ada guru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection