@extends('layouts.app')
@section('title', 'Kelola Pendaftaran Siswa Baru')
@section('page-title', 'Kelola Pendaftaran Siswa Baru')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list mr-1"></i> Daftar Pendaftar Siswa Baru</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="40">No</th>
                        <th>Nama Lengkap</th>
                        <th>NIK / No KK</th>
                        <th>Sekolah Asal</th>
                        <th>Tanggal Daftar</th>
                        <th>Dari Referral</th>
                        <th width="100">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftarans as $index => $pendaftar)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $pendaftar->nama }}</strong></td>
                            <td>
                                {{ $pendaftar->nik }}<br>
                                <small class="text-muted">KK: {{ $pendaftar->no_kk }}</small>
                            </td>
                            <td>{{ $pendaftar->sekolah_asal }}</td>
                            <td>{{ $pendaftar->created_at->format('d M Y') }}</td>
                            <td>
                                @if($pendaftar->referral_code)
                                    @php
                                        $refLink = \App\Models\ReferralLink::where('code', $pendaftar->referral_code)->first();
                                    @endphp
                                    @if($refLink)
                                        <span class="badge badge-info"
                                            title="Kode: {{ $pendaftar->referral_code }}">{{ $refLink->nama }}</span>
                                    @else
                                        <code>{{ $pendaftar->referral_code }}</code>
                                    @endif
                                @else
                                    <span class="text-muted">Langsung</span>
                                @endif
                            </td>
                            <td>
                                @if($pendaftar->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($pendaftar->status == 'diterima')
                                    <span class="badge badge-success">Diterima</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pendaftaran.show', $pendaftar->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada pendaftar baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection