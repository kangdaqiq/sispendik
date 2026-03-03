@extends('layouts.app')
@section('title', 'Bulk Tambah Jadwal Pelajaran')
@section('page-title', 'Bulk Tambah Jadwal Pelajaran')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-layer-group" style="color:var(--secondary)"></i> Form Bulk Tambah Jadwal</h2>
            <a href="{{ route('jadwal.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i>
                Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.bulk-store') }}" method="POST" id="bulkJadwalForm">
                @csrf

                <!-- Pilihan Utama (Kelas & Tahun Ajaran) -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id"
                                class="form-control @error('tahun_ajaran_id') is-invalid @enderror" required>
                                @if($ta)
                                    <option value="{{ $ta->id }}">{{ $ta->nama }} - {{ ucfirst($ta->semester) }} (Aktif)
                                    </option>
                                @else
                                    <option value="">-- Tidak ada Tahun Ajaran aktif --</option>
                                @endif
                            </select>
                            @error('tahun_ajaran_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Dynamic Table untuk Jadwal -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="jadwalTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Hari <span class="text-danger">*</span></th>
                                <th>Jam Mulai <span class="text-danger">*</span></th>
                                <th>Jam Selesai <span class="text-danger">*</span></th>
                                <th>Mata Pelajaran <span class="text-danger">*</span></th>
                                <th>Guru <span class="text-danger">*</span></th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="jadwalBody">
                            <!-- Baris Pertama (Default) -->
                            <tr class="jadwal-row">
                                <td>
                                    <select name="jadwal[0][hari]" class="form-control" required>
                                        <option value="">-- Hari --</option>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                            <option value="{{ $hari }}">{{ $hari }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="time" name="jadwal[0][jam_mulai]" class="form-control" required>
                                </td>
                                <td>
                                    <input type="time" name="jadwal[0][jam_selesai]" class="form-control" required>
                                </td>
                                <td>
                                    <select name="jadwal[0][mata_pelajaran_id]" class="form-control" required>
                                        <option value="">-- Mapel --</option>
                                        @foreach ($mapel as $m)
                                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="jadwal[0][guru_id]" class="form-control" required>
                                        <option value="">-- Guru --</option>
                                        @foreach ($guru as $g)
                                            <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-row" disabled><i
                                            class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-info btn-sm" id="addRow">
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Semua
                            Jadwal</button>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let rowIdx = 1;

            // Template untuk baris baru
            const mapelOptions = `@foreach($mapel as $m)<option value="{{ $m->id }}">{{ $m->nama }}</option>@endforeach`;
            const guruOptions = `@foreach($guru as $g)<option value="{{ $g->id }}">{{ $g->nama }}</option>@endforeach`;
            const hariOptions = `@foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)<option value="{{ $hari }}">{{ $hari }}</option>@endforeach`;

            $('#addRow').on('click', function () {
                let newRow = `
                <tr class="jadwal-row">
                    <td>
                        <select name="jadwal[${rowIdx}][hari]" class="form-control" required>
                            <option value="">-- Hari --</option>
                            ${hariOptions}
                        </select>
                    </td>
                    <td>
                        <input type="time" name="jadwal[${rowIdx}][jam_mulai]" class="form-control" required>
                    </td>
                    <td>
                        <input type="time" name="jadwal[${rowIdx}][jam_selesai]" class="form-control" required>
                    </td>
                    <td>
                        <select name="jadwal[${rowIdx}][mata_pelajaran_id]" class="form-control" required>
                            <option value="">-- Mapel --</option>
                            ${mapelOptions}
                        </select>
                    </td>
                    <td>
                        <select name="jadwal[${rowIdx}][guru_id]" class="form-control" required>
                            <option value="">-- Guru --</option>
                            ${guruOptions}
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;

                $('#jadwalBody').append(newRow);
                rowIdx++;
                updateRemoveButtons();
            });

            $(document).on('click', '.remove-row', function () {
                if ($('.jadwal-row').length > 1) {
                    $(this).closest('tr').remove();
                    updateRemoveButtons();
                    reindexRows();
                }
            });

            function updateRemoveButtons() {
                if ($('.jadwal-row').length === 1) {
                    $('.remove-row').prop('disabled', true);
                } else {
                    $('.remove-row').prop('disabled', false);
                }
            }

            function reindexRows() {
                $('.jadwal-row').each(function (index) {
                    $(this).find('select[name^="jadwal"], input[name^="jadwal"]').each(function () {
                        let oldName = $(this).attr('name');
                        let newName = oldName.replace(/\[\d+\]/, `[${index}]`);
                        $(this).attr('name', newName);
                    });
                });
                // Update rowIdx to the current length to prevent future index clashes
                rowIdx = $('.jadwal-row').length;
            }
        });
    </script>
@endpush