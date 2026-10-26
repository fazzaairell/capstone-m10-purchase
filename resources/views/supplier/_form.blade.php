@php
    $supplier = $supplier ?? null;
    $isEdit   = $supplier?->exists;
@endphp

<form method="POST" novalidate
      action="{{ $isEdit ? route('suppliers.update', $supplier) : route('suppliers.store') }}"
      onsubmit="const b = this.querySelector('[data-submit]'); b.disabled = true; b.textContent = 'Menyimpan…';"
      class="max-w-xl rounded-lg border border-line bg-surface p-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="space-y-4">
        <x-field name="name" label="Nama supplier" :value="$supplier?->name" />

        <x-field name="contact" label="Kontak" :value="$supplier?->contact"
                 hint="Isi nama kontak atau nomor telepon, misalnya Rina Pratiwi atau 0812 3456 7890." />

        <x-field name="address" label="Alamat" :value="$supplier?->address" :textarea="true" />
    </div>

    {{-- tombol di kanan bawah: Batal di kiri aksi utama --}}
    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('suppliers.index') }}"
           class="inline-flex h-10 items-center rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold hover:bg-surface-2">
            Batal
        </a>
        <button type="submit" data-submit
                class="inline-flex h-10 items-center rounded-sm bg-primary px-4 text-label font-semibold text-onprimary
                       hover:bg-primary-hover disabled:cursor-not-allowed disabled:bg-surface-2 disabled:text-muted">
            Simpan
        </button>
    </div>
</form>