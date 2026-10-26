@extends('layouts.app')

@section('title', 'Daftar supplier')

@section('content')
    @php
        $filtering = filled(request('q'));
    @endphp

    <nav aria-label="Jejak halaman" class="text-caption text-muted">Pengadaan / Supplier</nav>

    <div class="mb-6 mt-2 flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-head text-h1 font-bold">Daftar supplier</h1>
        <a href="{{ route('suppliers.create') }}"
           class="inline-flex h-10 items-center rounded-sm bg-primary px-4 text-label font-semibold text-onprimary hover:bg-primary-hover">
            Tambah supplier
        </a>
    </div>

    {{-- alat: pencarian --}}
    <form id="filter-form" method="GET" action="{{ route('suppliers.index') }}" class="mb-4">
        <label for="q" class="sr-only">Cari supplier</label>
        <input id="q" type="search" name="q" value="{{ request('q') }}"
               placeholder="Cari kode, nama, atau kontak supplier"
               class="h-10 w-full rounded-sm border border-line-strong bg-surface px-3 placeholder:text-muted sm:max-w-sm">
    </form>

    {{-- tabel di dalam kartu --}}
    <div class="overflow-hidden rounded-lg border border-line bg-surface">
        <div class="overflow-x-auto">
            <table class="w-full min-w-160">
                <thead class="bg-surface-2 text-left text-caption text-muted">
                    <tr>
                        <th scope="col" class="h-10 px-4 font-semibold">Kode</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Nama supplier</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Kontak</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Alamat</th>
                        <th scope="col" class="h-10 px-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-surface-2">
                            <td class="h-12 whitespace-nowrap px-4 text-caption text-muted">{{ $supplier->kode }}</td>
                            <td class="h-12 px-4 font-semibold">{{ $supplier->name }}</td>
                            <td class="h-12 px-4">{{ $supplier->contact_format }}</td>
                            <td class="h-12 max-w-xs px-4">
                                <span class="line-clamp-2" title="{{ $supplier->address }}">{{ $supplier->address }}</span>
                            </td>
                            <td class="h-12 whitespace-nowrap px-4 text-right">
                                <a href="{{ route('suppliers.show', $supplier) }}" class="font-semibold text-primary hover:underline">Lihat</a>
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="ml-4 font-semibold text-primary hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <p class="text-muted">{{ $filtering ? 'Supplier tidak ditemukan' : 'Belum ada supplier' }}</p>
                                <div class="mt-4">
                                    @if ($filtering)
                                        <a href="{{ route('suppliers.index') }}"
                                           class="inline-flex h-10 items-center rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold hover:bg-surface-2">
                                            Reset pencarian
                                        </a>
                                    @else
                                        <a href="{{ route('suppliers.create') }}"
                                           class="inline-flex h-10 items-center rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold hover:bg-surface-2">
                                            Tambah supplier
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 border-t border-line px-4 py-3 text-muted">
            <p>
                Menampilkan {{ $suppliers->firstItem() ?? 0 }}–{{ $suppliers->lastItem() ?? 0 }}
                dari {{ number_format($suppliers->total(), 0, ',', '.') }} supplier
            </p>

            <div class="flex flex-wrap items-center gap-4">
                <label class="flex items-center gap-2">
                    Baris per halaman
                    <select name="per_page" form="filter-form" onchange="this.form.submit()"
                            class="h-8 rounded-sm border border-line-strong bg-surface px-2 text-text">
                        @foreach ([10, 25, 50] as $n)
                            <option value="{{ $n }}" @selected($suppliers->perPage() === $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                </label>

                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
@endsection