@extends('layouts.app')

@section('title', $supplier->company_name)

@section('content')
    @php
        $metrics = [
            ['icon' => 'clock',   'label' => 'Lead time',          'value' => $supplier->lead_time_days . ' hari'],
            ['icon' => 'package', 'label' => 'Minimum order',      'value' => $supplier->minimum_order_format],
            ['icon' => 'card',    'label' => 'Termin pembayaran',  'value' => $supplier->payment_terms],
        ];

        $identitas = [
            'Kode supplier'       => $supplier->supplier_code,
            'Terdaftar sejak'     => $supplier->created_at->translatedFormat('j M Y'),
            'Terakhir diperbarui' => $supplier->updated_at->translatedFormat('j M Y, H.i') . ' WIB',
        ];
        $pajak = [
            'Status pajak' => $supplier->tax_label,
            'NPWP'         => $supplier->npwp_format,
        ];
        $narahubung = [
            'Nama narahubung' => $supplier->contact_person,
            'Nomor telepon'   => $supplier->phone_format,
            'Email'           => $supplier->email,
        ];
        $alamat = [
            'Alamat'   => $supplier->address,
            'Kota'     => $supplier->city,
            'Kode pos' => $supplier->postal_code,
        ];
        $logistik = [
            'Jenis pengiriman' => $supplier->delivery_label,
            'Kebijakan retur'  => $supplier->return_policy_label,
        ];
        $keuangan = [
            'Nama bank'             => $supplier->bank_name,
            'Nomor rekening'        => $supplier->account_number,
            'Nama pemilik rekening' => $supplier->account_holder,
        ];
    @endphp

    <nav aria-label="Jejak halaman" class="text-caption text-muted">
        Pengadaan /
        <a href="{{ route('suppliers.index') }}" class="text-primary hover:underline">Supplier</a>
        / {{ $supplier->supplier_code }}
    </nav>

    <div class="mb-6 mt-2 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <span class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-primary-soft font-head text-h3 font-bold text-primary"
                  aria-hidden="true">{{ $supplier->initials }}</span>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="font-head text-h1 font-bold">{{ $supplier->company_name }}</h1>
                <x-status-badge :type="$supplier->status_type">{{ $supplier->status_label }}</x-status-badge>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('delete-dialog').showModal()"
                    class="inline-flex h-10 items-center rounded-sm bg-danger-action px-4 text-label font-semibold text-on-danger-action transition hover:brightness-90">
                Hapus
            </button>
            <a href="{{ route('suppliers.edit', $supplier) }}"
               class="inline-flex h-10 items-center gap-2 rounded-sm bg-primary px-4 text-label font-semibold text-onprimary transition-colors hover:bg-primary-hover">
                <x-icon name="edit" class="size-4" />
                Edit
            </a>
        </div>
    </div>

    {{-- kartu metrik --}}
    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($metrics as $m)
            <div class="rounded-lg border border-line bg-surface p-4">
                <div class="flex items-center gap-2 text-muted">
                    <x-icon :name="$m['icon']" class="size-4" />
                    {{ $m['label'] }}
                </div>
                <p class="mt-2 font-head text-h2 font-bold">{{ $m['value'] }}</p>
            </div>
        @endforeach

        <div class="rounded-lg border border-line bg-surface p-4">
            <div class="flex items-center gap-2 text-muted">
                <x-icon name="star" class="size-4" />
                Rating performa
            </div>
            <div class="mt-2 flex items-center gap-2">
                <div class="flex" aria-hidden="true">
                    @for ($i = 1; $i <= 5; $i++)
                        <x-icon name="star" :filled="$i <= $supplier->rating"
                                class="size-4 {{ $i <= $supplier->rating ? 'text-primary' : 'text-line-strong' }}" />
                    @endfor
                </div>
                <p class="font-head text-h2 font-bold">{{ $supplier->rating }}<span class="text-body font-normal text-muted"> dari 5</span></p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <x-detail-card title="Identitas" :items="$identitas" />
        <x-detail-card title="Legalitas dan pajak" :items="$pajak" />
        <x-detail-card title="Narahubung" :items="$narahubung" />
        <x-detail-card title="Alamat" :items="$alamat" />
        <x-detail-card title="Logistik" :items="$logistik" />
        <x-detail-card title="Rekening pembayaran" :items="$keuangan" />
        <div class="lg:col-span-2">
            <x-detail-card title="Catatan" :items="['Catatan operasional' => $supplier->notes]" />
        </div>
    </div>

    {{-- dialog konfirmasi hapus --}}
    <dialog id="delete-dialog"
            class="m-auto w-full max-w-md rounded-lg border border-line bg-surface p-6 text-text shadow-float backdrop:bg-overlay">
        <h2 class="font-head text-h3 font-semibold">Hapus supplier {{ $supplier->company_name }}?</h2>
        <p class="mt-2 text-muted">
            Supplier tidak akan tampil di daftar dan tidak bisa dipilih untuk PO baru. Data lama tetap tersimpan.
        </p>

        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="mt-6 flex justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="this.closest('dialog').close()"
                    class="inline-flex h-10 items-center rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold transition-colors hover:bg-surface-2">
                Batal
            </button>
            <button type="submit"
                    class="inline-flex h-10 items-center rounded-sm bg-danger-action px-4 text-label font-semibold text-on-danger-action transition hover:brightness-90">
                Hapus supplier
            </button>
        </form>
    </dialog>
@endsection