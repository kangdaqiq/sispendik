@extends('layouts.app')
@section('title', 'Edit Kehadiran')
@section('page-title', 'Edit Kehadiran')
@section('content')
    <div class="card" style="max-width:500px">
        <div class="card-header">
            <h2><i class="fas fa-edit" style="color:var(--warning)"></i> Edit Kehadiran</h2>
            <a href="{{ route('kehadiran.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('kehadiran.update', $kehadiran) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        @foreach(['hadir', 'sakit', 'izin', 'alpha'] as $st)
                            <option value="{{ $st }}" {{ $kehadiran->status == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2">{{ $kehadiran->keterangan }}</textarea>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('kehadiran.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection