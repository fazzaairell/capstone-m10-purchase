@extends('layouts.app')

@section('title', 'Permintaan pembelian')

@section('content')
    @php
        $filtering = filled(request('q')) || filled(request('status'));
        $btn2 = 'inline-flex h-10 items-center gap-2 rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold transition-colors hover:bg-surface-2';

        // alamat kartu ringkasan: tetap membawa pencarian dan jumlah baris
        $tileUrl = fn ($status = null) => route('purchase-requests.index', array_filter([
            'q'        => request('q'),
            'status'   => $status,
            'per_page' => request('per_page'),
        ]));

        $tiles = [
            ['key' => null,       'label' => 'Semua',                'count' => $counts->sum(),               'dot' => null],
            ['key' => 'draft',    'label' => 'Draft',                'count' => $counts->get('draft', 0),    'dot' => 'bg-neutral-solid'],
            ['key' => 'pending',  'label' => 'Menunggu persetujuan', 'count' => $counts->get('pending', 0),  'dot' => 'bg-pending-solid'],
            ['key' => 'approved', 'label' => 'Disetujui',            'count' => $counts->get('approved', 0), 'dot' => 'bg-success-solid'],
            ['key' => 'rejected', 'label' => 'Ditolak',              'count' => $counts->get('rejected', 0), 'dot' => 'bg-danger-solid'],
        ];
    @endphp

    <nav aria-label="Jejak halaman" class="text-caption text-muted">Pengadaan / Permintaan pembelian</nav>

    <div class="mb-6 mt-2 flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-head text-h1 font-bold">Permintaan pembelian</h1>
        <a href="{{ route('purchase-requests.create') }}"
           class="inline-flex h-10 items-center gap-2 rounded-sm bg-primary px-4 text-label font-semibold text-onprimary transition-colors hover:bg-primary-hover">
            <x-icon name="plus" class="size-4" />
            Ajukan pembelian baru
        </a>
    </div>

    {{-- ringkasan sekaligus filter status --}}
    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-5">
        @foreach ($tiles as $tile)
            @php
                $active = blank($tile['key']) ? blank(request('status')) : request('status') === $tile['key'];
            @endphp
            <a href="{{ $tileUrl($tile['key']) }}" @if ($active) aria-current="true" @endif
               class="rounded-lg border p-4 transition-colors
                      {{ $active ? 'border-primary bg-primary-soft' : 'border-line bg-surface hover:bg-surface-2' }}">
                <div class="flex items-center gap-2 text-muted">
                    @if ($tile['dot'])
                        <span class="size-2 shrink-0 rounded-full {{ $tile['dot'] }}" aria-hidden="true"></span>
                    @endif
                    {{ $tile['label'] }}
                </div>
                <p class="mt-2 font-head text-display font-extrabold tabular-nums">{{ number_format($tile['count'], 0, ',', '.') }}</p>
            </a>
        @endforeach
    </div>

    {{-- alat: pencarian --}}
    <form id="filter-form" method="GET" action="{{ route('purchase-requests.index') }}" class="mb-4 flex flex-col gap-3 sm:flex-row">
        <input type="hidden" name="status" value="{{ request('status') }}">

        <div class="relative w-full sm:max-w-md">
            <label for="q" class="sr-only">Cari permintaan pembelian</label>
            <x-icon name="search" class="pointer-events-none absolute left-4 top-2.5 text-muted" />
            <input id="q" type="search" name="q" value="{{ request('q') }}"
                   placeholder="Cari nomor, pemohon, atau departemen"
                   class="h-10 w-full rounded-sm border border-line-strong bg-surface pl-12 pr-3 placeholder:text-muted">
        </div>

        <button type="submit" class="{{ $btn2 }}">Cari</button>

        @if ($filtering)
            <a href="{{ route('purchase-requests.index') }}"
               class="inline-flex h-10 items-center px-2 font-semibold text-primary hover:underline">Reset</a>
        @endif
    </form>

    {{-- tabel --}}
    <div class="overflow-hidden rounded-lg border border-line bg-surface">
        <div class="overflow-x-auto">
            <table class="w-full min-w-200">
                <thead class="bg-surface-2 text-left text-caption text-muted">
                    <tr>
                        <th scope="col" class="h-10 px-4 font-semibold">Nomor</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Pemohon</th>
                        <th scope="col" class="h-10 px-4 text-right font-semibold">Jumlah barang</th>
                        <th scope="col" class="h-10 px-4 text-right font-semibold">Total estimasi</th>
                        <th scope="col" class="h-10 px-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($purchaseRequests as $pr)
                        <tr class="transition-colors hover:bg-surface-2">
                            <td class="h-12 whitespace-nowrap px-4">
                                <div class="font-semibold">{{ $pr->pr_number }}</div>
                                <div class="text-caption text-muted">{{ $pr->created_at->translatedFormat('j M Y') }}</div>
                            </td>
                            <td class="h-12 px-4">
                                <div>{{ $pr->requester_name }}</div>
                                <div class="text-caption text-muted">{{ $pr->department ?? 'Departemen belum diisi' }}</div>
                            </td>
                            <td class="h-12 whitespace-nowrap px-4 text-right tabular-nums">{{ $pr->items_count }}</td>
                            <td class="h-12 whitespace-nowrap px-4 text-right font-semibold tabular-nums">{{ $pr->total_format }}</td>
                            <td class="h-12 whitespace-nowrap px-4">
                                <x-status-badge :type="$pr->status_type">{{ $pr->status_label }}</x-status-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <span class="mx-auto flex size-12 items-center justify-center rounded-full bg-surface-2 text-muted">
                                    <x-icon name="inbox" class="size-6" />
                                </span>
                                <p class="mt-4 text-muted">{{ $filtering ? 'Permintaan tidak ditemukan' : 'Belum ada permintaan pembelian' }}</p>
                                <div class="mt-4">
                                    @if ($filtering)
                                        <a href="{{ route('purchase-requests.index') }}" class="{{ $btn2 }}">Reset filter</a>
                                    @else
                                        <a href="{{ route('purchase-requests.create') }}" class="{{ $btn2 }}">Ajukan pembelian baru</a>
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
                Menampilkan {{ $purchaseRequests->firstItem() ?? 0 }}–{{ $purchaseRequests->lastItem() ?? 0 }}
                dari {{ number_format($purchaseRequests->total(), 0, ',', '.') }} permintaan
            </p>

            <div class="flex flex-wrap items-center gap-4">
                <label class="flex items-center gap-2">
                    Baris per halaman
                    <select name="per_page" form="filter-form" onchange="this.form.submit()"
                            class="h-8 rounded-sm border border-line-strong bg-surface px-2 text-text">
                        @foreach ([10, 25, 50] as $n)
                            <option value="{{ $n }}" @selected($purchaseRequests->perPage() === $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                </label>

                {{ $purchaseRequests->links() }}
            </div>
        </div>
    </div>
@endsection