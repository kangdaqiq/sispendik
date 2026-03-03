@extends('layouts.app')
@section('title', 'Data Guru')
@section('page-title', 'Detail Guru')
@section('content')
    <div class="card" style="max-width:500px">
        <div class="card-body">
            <h3>{{ $guru->nama }}</h3>
            <p class="text-muted">NIP: {{ $guru->nip ?? '-' }}</p>
        </div>
        <div style="padding:16px;display:flex;gap:8px">
            <a href="{{ route('guru.edit', $guru) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route('guru.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
@endsection