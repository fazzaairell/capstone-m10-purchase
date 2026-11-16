@php
    $err  = fn ($f) => $errors->first("items.$i.$f");
    $base = 'h-10 w-full rounded-sm border bg-surface px-3 placeholder:text-muted ';
    $cls  = fn ($f) => $base . ($err($f) ? 'border-danger-solid' : 'border-line-strong');
@endphp

<div data-item-row class="grid gap-4 p-4 md:grid-cols-12 md:items-start">
    {{-- nama barang --}}
    <div class="md:col-span-5">
        <label for="item-{{ $i }}-name" class="mb-1 block text-label font-semibold md:sr-only">Nama atau deskripsi barang</label>
        <input id="item-{{ $i }}-name" name="items[{{ $i }}][name]" type="text"
               value="{{ $row['name'] ?? '' }}" placeholder="Nama atau deskripsi barang"
               class="{{ $cls('name') }}">
        <x-field-error :message="$err('name')" />
    </div>

    {{-- jumlah --}}
    <div class="md:col-span-2">
        <label for="item-{{ $i }}-quantity" class="mb-1 block text-label font-semibold md:sr-only">Jumlah</label>
        <input id="item-{{ $i }}-quantity" name="items[{{ $i }}][quantity]" type="number"
               min="0.01" step="any" inputmode="decimal" data-qty
               value="{{ $row['quantity'] ?? 1 }}"
               class="{{ $cls('quantity') }} text-right tabular-nums">
        <x-field-error :message="$err('quantity')" />
    </div>

    {{-- satuan --}}
    <div class="md:col-span-2">
        <label for="item-{{ $i }}-unit" class="mb-1 block text-label font-semibold md:sr-only">Satuan</label>
        <select id="item-{{ $i }}-unit" name="items[{{ $i }}][unit]" class="{{ $cls('unit') }}">
            @foreach (\App\Models\PurchaseRequest::UNITS as $unit)
                <option value="{{ $unit }}" @selected(($row['unit'] ?? 'Pcs') === $unit)>{{ $unit }}</option>
            @endforeach
        </select>
        <x-field-error :message="$err('unit')" />
    </div>

    {{-- estimasi harga satuan --}}
    <div class="md:col-span-2">
        <label for="item-{{ $i }}-price" class="mb-1 block text-label font-semibold md:sr-only">Estimasi harga satuan (Rp)</label>
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-muted" aria-hidden="true">Rp</span>
            <input id="item-{{ $i }}-price" name="items[{{ $i }}][price]" type="number"
                   min="0" step="any" inputmode="decimal" data-price
                   value="{{ $row['price'] ?? '' }}"
                   class="{{ $cls('price') }} pl-10 text-right tabular-nums">
        </div>
        <x-field-error :message="$err('price')" />
    </div>

    {{-- hapus baris --}}
    <div class="flex justify-end md:col-span-1">
        <button type="button" data-remove aria-label="Hapus barang" title="Hapus barang"
                class="inline-flex size-10 items-center justify-center rounded-sm text-muted transition-colors
                       hover:bg-danger-bg hover:text-danger-fg
                       disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-transparent disabled:hover:text-muted">
            <x-icon name="trash" class="size-5" />
        </button>
    </div>
</div>