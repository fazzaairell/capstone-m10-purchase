@extends('layouts.app')

@section('title', 'Daftar supplier')

@section('content')
    @php
        $filtering = filled(request('q')) || filled(request('status')) || filled(request('delivery'));
        $btn2 = 'inline-flex h-10 items-center gap-2 rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold transition-colors hover:bg-surface-2';

        // alamat kartu ringkasan: tetap membawa pencarian dan filter lain
        $tileUrl = fn ($status = null) => route('suppliers.index', array_filter([
            'q' => request('q'), 'status' => $status,
            'delivery' => request('delivery'), 'per_page' => request('per_page'),
        ]));

        $tiles = [
            ['key' => null,         'label' => 'Semua supplier', 'count' => $counts->sum(),            'dot' => null],
            ['key' => 'active',     'label' => 'Aktif',          'count' => $counts->get('active', 0),     'dot' => 'bg-success-solid'],
            ['key' => 'suspended',  'label' => 'Ditangguhkan',   'count' => $counts->get('suspended', 0),  'dot' => 'bg-pending-solid'],
            ['key' => 'terminated', 'label' => 'Dihentikan',     'count' => $counts->get('terminated', 0), 'dot' => 'bg-danger-solid'],
        ];
    @endphp

    <nav aria-label="Jejak halaman" class="text-caption text-muted">Pengadaan / Supplier</nav>

    <div class="mb-6 mt-2 flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-head text-h1 font-bold">Daftar supplier</h1>
        <a href="{{ route('suppliers.create') }}"
           class="inline-flex h-10 items-center gap-2 rounded-sm bg-primary px-4 text-label font-semibold text-onprimary transition-colors hover:bg-primary-hover">
            <x-icon name="plus" class="size-4" />
            Tambah supplier
        </a>
    </div>

    {{-- ringkasan sekaligus filter status --}}
    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($tiles as $tile)
            @php
                $active = blank($tile['key']) ? blank(request('status')) : request('status') === $tile['key'];
            @endphp
            <a href="{{ $tileUrl($tile['key']) }}" @if ($active) aria-current="true" @endif
               class="rounded-lg border p-4 transition-colors
                      {{ $active ? 'border-primary bg-primary-soft' : 'border-line bg-surface hover:bg-surface-2' }}">
                <div class="flex items-center gap-2 text-muted">
                    @if ($tile['dot'])
                        <span class="size-2 rounded-full {{ $tile['dot'] }}" aria-hidden="true"></span>
                    @endif
                    {{ $tile['label'] }}
                </div>
                <p class="mt-2 font-head text-display font-extrabold">{{ number_format($tile['count'], 0, ',', '.') }}</p>
            </a>
        @endforeach
    </div>

    {{-- alat: pencarian dan filter pengiriman --}}
    <form id="filter-form" method="GET" action="{{ route('suppliers.index') }}" class="mb-4 flex flex-col gap-3 lg:flex-row">
        <input type="hidden" name="status" value="{{ request('status') }}">

        <div class="relative w-full lg:max-w-md">
            <label for="q" class="sr-only">Cari supplier</label>
            <x-icon name="search" class="pointer-events-none absolute left-4 top-2.5 text-muted" />
            <input id="q" type="search" name="q" value="{{ request('q') }}"
                   placeholder="Cari kode, perusahaan, narahubung, atau kota"
                   class="h-10 w-full rounded-sm border border-line-strong bg-surface pl-12 pr-3 placeholder:text-muted">
        </div>

        <label for="delivery" class="sr-only">Filter pengiriman</label>
        <select id="delivery" name="delivery" onchange="this.form.submit()"
                class="h-10 rounded-sm border border-line-strong bg-surface px-3 lg:w-56">
            <option value="">Semua pengiriman</option>
            @foreach (\App\Models\Supplier::DELIVERY_TYPES as $key => $text)
                <option value="{{ $key }}" @selected(request('delivery') === $key)>{{ $text }}</option>
            @endforeach
        </select>

        <button type="submit" class="{{ $btn2 }}">Cari</button>

        @if ($filtering)
            <a href="{{ route('suppliers.index') }}"
               class="inline-flex h-10 items-center px-2 font-semibold text-primary hover:underline">Reset</a>
        @endif
    </form>

    {{-- tabel --}}
    <div class="overflow-hidden rounded-lg border border-line bg-surface">
        <div class="overflow-x-auto">
            <table class="w-full min-w-240">
                <thead class="bg-surface-2 text-left text-caption text-muted">
                    <tr>
                        <th scope="col" class="h-10 px-4 font-semibold">Supplier</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Narahubung</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Pengiriman</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Pembayaran</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Status</th>
                        <th scope="col" class="h-10 px-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($suppliers as $supplier)
                        <tr class="transition-colors hover:bg-surface-2">
                            <td class="h-12 px-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-primary-soft text-caption font-semibold text-primary"
                                          aria-hidden="true">{{ $supplier->initials }}</span>
                                    <div>
                                        <a href="{{ route('suppliers.show', $supplier) }}" class="font-semibold hover:text-primary">{{ $supplier->company_name }}</a>
                                        <div class="text-caption text-muted">{{ $supplier->supplier_code }} · {{ $supplier->city }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="h-12 px-4">
                                <div>{{ $supplier->contact_person }}</div>
                                <div class="text-caption text-muted">{{ $supplier->phone_format }}</div>
                            </td>
                            <td class="h-12 px-4">
                                <div class="whitespace-nowrap">{{ $supplier->delivery_label }}</div>
                                <div class="text-caption text-muted">Lead time {{ $supplier->lead_time_days }} hari</div>
                            </td>
                            <td class="h-12 whitespace-nowrap px-4">{{ $supplier->payment_terms }}</td>
                            <td class="h-12 whitespace-nowrap px-4">
                                <x-status-badge :type="$supplier->status_type">{{ $supplier->status_label }}</x-status-badge>
                            </td>
                            <td class="h-12 whitespace-nowrap px-4 text-right">
                                <a href="{{ route('suppliers.show', $supplier) }}" title="Lihat detail"
                                   class="inline-flex size-8 items-center justify-center rounded-sm text-muted transition-colors hover:bg-primary-soft hover:text-primary">
                                    <x-icon name="eye" class="size-4" />
                                    <span class="sr-only">Lihat {{ $supplier->company_name }}</span>
                                </a>
                                <a href="{{ route('suppliers.edit', $supplier) }}" title="Edit supplier"
                                   class="inline-flex size-8 items-center justify-center rounded-sm text-muted transition-colors hover:bg-primary-soft hover:text-primary">
                                    <x-icon name="edit" class="size-4" />
                                    <span class="sr-only">Edit {{ $supplier->company_name }}</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <span class="mx-auto flex size-12 items-center justify-center rounded-full bg-surface-2 text-muted">
                                    <x-icon name="inbox" class="size-6" />
                                </span>
                                <p class="mt-4 text-muted">{{ $filtering ? 'Supplier tidak ditemukan' : 'Belum ada supplier' }}</p>
                                <div class="mt-4">
                                    @if ($filtering)
                                        <a href="{{ route('suppliers.index') }}" class="{{ $btn2 }}">Reset filter</a>
                                    @else
                                        <a href="{{ route('suppliers.create') }}" class="{{ $btn2 }}">Tambah supplier</a>
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