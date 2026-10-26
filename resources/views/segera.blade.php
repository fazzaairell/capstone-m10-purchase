@extends('layouts.app')

@section('title', $judul)

@section('content')
    <nav aria-label="Jejak halaman" class="text-caption text-muted">Pengadaan / {{ $judul }}</nav>

    <h1 class="mb-6 mt-2 font-head text-h1 font-bold">{{ $judul }}</h1>

    <div class="rounded-lg border border-line bg-surface px-4 py-12 text-center">
        <p class="text-muted">Halaman ini belum tersedia</p>
    </div>
@endsection