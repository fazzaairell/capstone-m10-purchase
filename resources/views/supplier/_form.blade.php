@php
    $supplier = $supplier ?? new \App\Models\Supplier;
    $isEdit   = $supplier->exists;
    $total    = 7;
    $btn2     = 'inline-flex h-10 items-center rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold transition-colors hover:bg-surface-2';
@endphp

<form method="POST" novalidate
      action="{{ $isEdit ? route('suppliers.update', $supplier) : route('suppliers.store') }}"
      onsubmit="const b = this.querySelector('[data-submit]'); b.disabled = true; b.textContent = 'Menyimpan…';"
      class="max-w-5xl space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    @if ($errors->any())
        <div role="alert" class="flex items-start gap-3 rounded-lg bg-danger-bg p-4 text-danger-fg">
            <span class="mt-2 size-2 shrink-0 rounded-full bg-danger-solid" aria-hidden="true"></span>
            <div>
                <p class="font-semibold">Data belum lengkap</p>
                <p>Periksa kolom yang ditandai merah, lalu simpan lagi.</p>
            </div>
        </div>
    @endif

    <x-form-section :step="1" :total="$total" title="Identitas supplier"
                    description="Nama resmi yang tercantum di PO dan faktur.">
        <x-field name="company_name" label="Nama perusahaan" :value="$supplier->company_name" class="md:col-span-2"
                 hint="Nama resmi PT, CV, atau pemasok." />
    </x-form-section>

    <x-form-section :step="2" :total="$total" title="Legalitas dan pajak"
                    description="Menentukan apakah PO memperhitungkan PPN.">
        <x-field name="tax_type" label="Status pajak" :value="$supplier->tax_type" :options="\App\Models\Supplier::TAX_TYPES" />
        <x-field name="npwp" label="NPWP" :value="$supplier->npwp_format" :required="false"
                 optional-text="(wajib untuk PKP)" hint="15 atau 16 digit. Titik dan tanda hubung boleh dipakai." />
    </x-form-section>

    <x-form-section :step="3" :total="$total" title="Narahubung"
                    description="Orang dan alamat email tujuan pengiriman PO.">
        <x-field name="contact_person" label="Nama narahubung" :value="$supplier->contact_person"
                 hint="Nama sales atau Key Account Manager." />
        <x-field name="phone" label="Nomor telepon" :value="$supplier->phone" hint="Contoh: 0812 3456 7890." />
        <x-field name="email" label="Email" type="email" :value="$supplier->email" class="md:col-span-2"
                 hint="Email resmi untuk mengirim Purchase Order." />
    </x-form-section>

    <x-form-section :step="4" :total="$total" title="Alamat"
                    description="Lokasi gudang atau kantor pusat supplier.">
        <x-field name="address" label="Alamat lengkap" :value="$supplier->address" :textarea="true" class="md:col-span-2" />
        <x-field name="city" label="Kota" :value="$supplier->city" />
        <x-field name="postal_code" label="Kode pos" :value="$supplier->postal_code" :required="false" hint="5 digit angka." />
    </x-form-section>

    <x-form-section :step="5" :total="$total" title="Logistik dan pengadaan"
                    description="Dipakai untuk menentukan kapan dan berapa banyak memesan.">
        <x-field name="delivery_type" label="Jenis pengiriman" :value="$supplier->delivery_type" :options="\App\Models\Supplier::DELIVERY_TYPES"
                 hint="DC dikirim ke gudang pusat, DSD dikirim langsung ke toko." />
        <x-field name="lead_time_days" label="Lead time (hari)" type="number" min="0" max="365" step="1"
                 :value="$supplier->lead_time_days" hint="Hari dari PO terbit sampai barang tiba." />
        <x-field name="minimum_order_qty" label="Minimum order (Rp)" type="number" min="0" step="any"
                 :value="$supplier->minimum_order_qty + 0" hint="Isi angka saja, misalnya 5000000. Isi 0 kalau tidak ada batas." />
        <x-field name="return_policy" label="Kebijakan retur" :value="$supplier->return_policy" :options="\App\Models\Supplier::RETURN_POLICIES"
                 hint="Untuk barang rusak atau kedaluwarsa." />
    </x-form-section>

    <x-form-section :step="6" :total="$total" title="Keuangan dan pembayaran"
                    description="Jadwal jatuh tempo dan tujuan transfer. Data rekening diisi lengkap atau dikosongkan semua.">
        <x-field name="payment_terms" label="Termin pembayaran" :value="$supplier->payment_terms" :options="\App\Models\Supplier::PAYMENT_TERMS" class="md:col-span-2" />
        <x-field name="bank_name" label="Nama bank" :value="$supplier->bank_name" :required="false" />
        <x-field name="account_number" label="Nomor rekening" :value="$supplier->account_number" :required="false" />
        <x-field name="account_holder" label="Nama pemilik rekening" :value="$supplier->account_holder" :required="false" class="md:col-span-2"
                 hint="Sesuai buku tabungan." />
    </x-form-section>

    <x-form-section :step="7" :total="$total" title="Status dan evaluasi"
                    description="Hanya supplier berstatus Aktif yang bisa dipilih untuk PO baru.">
        <x-field name="status" label="Status kemitraan" :value="$supplier->status" :options="\App\Models\Supplier::STATUSES" />
        <x-field name="rating" label="Rating performa" :value="$supplier->rating" :options="\App\Models\Supplier::RATINGS" />
        <x-field name="notes" label="Catatan" :value="$supplier->notes" :textarea="true" :required="false" class="md:col-span-2"
                 hint="Catatan khusus operasional supplier." />
    </x-form-section>

    {{-- bar tombol yang menempel di bawah: Batal di kiri aksi utama --}}
    <div class="sticky bottom-0 -mx-4 border-t border-line bg-surface px-4 py-3 sm:-mx-6 sm:px-6">
        <div class="flex justify-end gap-3">
            <a href="{{ $isEdit ? route('suppliers.show', $supplier) : route('suppliers.index') }}" class="{{ $btn2 }}">Batal</a>
            <button type="submit" data-submit
                    class="inline-flex h-10 items-center rounded-sm bg-primary px-4 text-label font-semibold text-onprimary transition-colors
                           hover:bg-primary-hover disabled:cursor-not-allowed disabled:bg-surface-2 disabled:text-muted">
                Simpan
            </button>
        </div>
    </div>
</form>