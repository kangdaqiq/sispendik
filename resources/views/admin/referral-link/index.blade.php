@extends('layouts.app')
@section('title', 'Kelola Referral Link')
@section('page-title', 'Referral Link Pendaftaran')

@section('content')
    <div class="row">
        {{-- Form Buat Link Baru --}}
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Buat Referral Link Baru</h3>
                </div>
                <form action="{{ route('admin.referral-link.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="nama">Nama Pemilik Link <span class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}"
                                placeholder="Contoh: Budi Santoso" required>
                            <small class="text-muted">Nama ini akan tampil di data pendaftaran sebagai referral.</small>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control"
                                value="{{ old('keterangan') }}" placeholder="Contoh: Alumni 2010, Guru, dsb">
                        </div>
                        <div class="alert alert-light border mb-0">
                            <i class="fas fa-info-circle text-primary mr-1"></i>
                            Kode referral akan di-<em>generate</em> otomatis dari nama.
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-link mr-1"></i> Buat Referral Link
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Daftar Link --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list mr-1"></i> Daftar Referral Link</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="40">No</th>
                                <th>Nama Pemilik</th>
                                <th>Keterangan</th>
                                <th>Kode & Link</th>
                                <th width="80" class="text-center">Pendaftar</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($referralLinks as $index => $link)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $link->nama }}</strong></td>
                                    <td>{{ $link->keterangan ?? '-' }}</td>
                                    <td>
                                        <code class="d-block mb-1">{{ $link->code }}</code>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm ref-link-input"
                                                id="link_{{ $link->id }}" value="{{ url('/pendaftaran?ref=' . $link->code) }}"
                                                readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary btn-sm"
                                                    onclick="copyLink('link_{{ $link->id }}', this)" title="Salin Link">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ $link->pendaftarans_count > 0 ? 'success' : 'secondary' }} badge-pill">
                                            {{ $link->pendaftarans_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.referral-link.destroy', $link->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus referral link milik {{ $link->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-block">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada referral link. Buat yang pertama!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyLink(inputId, btn) {
            const el = document.getElementById(inputId);
            el.select();
            el.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(el.value).then(function () {
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check text-success"></i>';
                setTimeout(() => btn.innerHTML = original, 2000);
            });
        }
    </script>
@endpush