@extends('layouts.app')

@section('title', $supplier->name)

@section('content')
    <nav aria-label="Jejak halaman" class="text-caption text-muted">
        Pengadaan /
        <a href="{{ route('suppliers.index') }}" class="text-primary hover:underline">Supplier</a>
        / {{ $supplier->kode }}
    </nav>

    <div class="mb-6 mt-2 flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-head text-h1 font-bold">{{ $supplier->name }}</h1>

        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('delete-dialog').showModal()"
                    class="inline-flex h-10 items-center rounded-sm bg-danger-action px-4 text-label font-semibold text-on-danger-action hover:brightness-90">
                Hapus
            </button>
            <a href="{{ route('suppliers.edit', $supplier) }}"
               class="inline-flex h-10 items-center rounded-sm bg-primary px-4 text-label font-semibold text-onprimary hover:bg-primary-hover">
                Edit
            </a>
        </div>
    </div>

    <dl class="max-w-3xl divide-y divide-line rounded-lg border border-line bg-surface">
        <div class="grid gap-1 p-4 sm:grid-cols-3 sm:gap-4">
            <dt class="text-muted">Kode</dt>
            <dd class="sm:col-span-2">{{ $supplier->kode }}</dd>
        </div>
        <div class="grid gap-1 p-4 sm:grid-cols-3 sm:gap-4">
            <dt class="text-muted">Nama supplier</dt>
            <dd class="font-semibold sm:col-span-2">{{ $supplier->name }}</dd>
        </div>
        <div class="grid gap-1 p-4 sm:grid-cols-3 sm:gap-4">
            <dt class="text-muted">Kontak</dt>
            <dd class="sm:col-span-2">{{ $supplier->contact_format }}</dd>
        </div>
        <div class="grid gap-1 p-4 sm:grid-cols-3 sm:gap-4">
            <dt class="text-muted">Alamat</dt>
            <dd class="whitespace-pre-line sm:col-span-2">{{ $supplier->address }}</dd>
        </div>
        <div class="grid gap-1 p-4 sm:grid-cols-3 sm:gap-4">
            <dt class="text-muted">Terakhir diperbarui</dt>
            <dd class="sm:col-span-2">{{ $supplier->updated_at->translatedFormat('j M Y, H.i') }} WIB</dd>
        </div>
    </dl>

    {{-- dialog konfirmasi hapus --}}
    <dialog id="delete-dialog"
            class="m-auto w-full max-w-md rounded-lg border border-line bg-surface p-6 text-text shadow-float backdrop:bg-overlay">
        <h2 class="font-head text-h3 font-semibold">Hapus supplier {{ $supplier->name }}?</h2>
        <p class="mt-2 text-muted">Supplier yang dihapus tidak bisa dikembalikan.</p>

        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="mt-6 flex justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="this.closest('dialog').close()"
                    class="inline-flex h-10 items-center rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold hover:bg-surface-2">
                Batal
            </button>
            <button type="submit"
                    class="inline-flex h-10 items-center rounded-sm bg-danger-action px-4 text-label font-semibold text-on-danger-action hover:brightness-90">
                Hapus supplier
            </button>
        </form>
    </dialog>
@endsection