@extends('layouts.app')

@section('title', 'Tambah supplier')

@section('content')
    <nav aria-label="Jejak halaman" class="text-caption text-muted">
        Pengadaan /
        <a href="{{ route('suppliers.index') }}" class="text-primary hover:underline">Supplier</a>
        / Tambah
    </nav>

    <h1 class="mb-6 mt-2 font-head text-h1 font-bold">Tambah supplier</h1>

    @include('supplier._form')
@endsection