@extends('layouts.app')

@section('title', 'Buat permintaan pembelian')

@section('content')
    @php
        // baris barang: dari input sebelumnya (kalau ada galat) atau satu baris kosong
        $rows = old('items');
        if (empty($rows)) {
            $rows = [['name' => '', 'quantity' => 1, 'unit' => 'Pcs', 'price' => null]];
        }
        $nextIndex = max(array_keys($rows)) + 1;

        $departments = ['' => 'Pilih departemen']
            + array_combine(\App\Models\PurchaseRequest::DEPARTMENTS, \App\Models\PurchaseRequest::DEPARTMENTS);

        $btn2 = 'inline-flex h-10 items-center gap-2 rounded-sm border border-line-strong bg-surface px-4 text-label font-semibold transition-colors hover:bg-surface-2';
    @endphp

<nav aria-label="Jejak halaman" class="text-caption text-muted">
    Pengadaan /
    <a href="{{ route('purchase-requests.index') }}" class="text-primary hover:underline">Permintaan pembelian</a>
    / Buat baru
</nav>

    <h1 class="mb-6 mt-2 font-head text-h1 font-bold">Buat permintaan pembelian</h1>

    <form id="pr-form" method="POST" action="{{ route('purchase-requests.store') }}" novalidate>
        @csrf

        @if ($errors->any())
            <div role="alert" class="mb-6 flex items-start gap-3 rounded-lg bg-danger-bg p-4 text-danger-fg">
                <span class="mt-2 size-2 shrink-0 rounded-full bg-danger-solid" aria-hidden="true"></span>
                <div>
                    <p class="font-semibold">Data belum lengkap</p>
                    <p>Periksa kolom yang ditandai merah, lalu coba lagi.</p>
                </div>
            </div>
        @endif

        <div class="overflow-hidden rounded-lg border border-line bg-surface">

            {{-- 1. Informasi pemohon --}}
            <section class="flex gap-4 border-b border-line p-6">
                <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-primary-soft font-semibold text-primary" aria-hidden="true">1</span>
                <div class="min-w-0 flex-1">
                    <h2 class="font-head text-h3 font-semibold">Informasi pemohon</h2>
                    <p class="text-muted">Isi siapa yang mengajukan dan mengapa barang ini dibutuhkan.</p>

                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        <x-field name="requester_name" label="Nama pemohon" placeholder="Isi nama lengkap"
                                 :value="auth()->user()?->name" />
                        <x-field name="department" label="Departemen" :options="$departments" />
                        <x-field name="reason" label="Alasan atau justifikasi pembelian" :textarea="true"
                                 placeholder="Jelaskan mengapa pembelian ini diperlukan"
                                 hint="Jelaskan singkat kebutuhan bisnis untuk pembelian ini." class="md:col-span-2" />
                    </div>
                </div>
            </section>

            {{-- 2. Barang yang diminta --}}
            <section class="flex gap-4 border-b border-line p-6">
                <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-primary-soft font-semibold text-primary" aria-hidden="true">2</span>
                <div class="min-w-0 flex-1">
                    <h2 class="font-head text-h3 font-semibold">Barang yang diminta</h2>
                    <p class="text-muted">Tambahkan semua barang atau jasa yang dibutuhkan untuk permintaan ini.</p>

                    <div class="mt-4 overflow-hidden rounded-lg border border-line">
                        {{-- header kolom (tampil di layar menengah ke atas) --}}
                        <div class="hidden h-10 items-center gap-4 bg-surface-2 px-4 text-caption font-semibold text-muted md:grid md:grid-cols-12">
                            <div class="md:col-span-5">Nama atau deskripsi barang</div>
                            <div class="text-right md:col-span-2">Jumlah</div>
                            <div class="md:col-span-2">Satuan</div>
                            <div class="text-right md:col-span-2">Estimasi harga satuan</div>
                            <div class="md:col-span-1"><span class="sr-only">Aksi</span></div>
                        </div>

                        <div id="item-rows" class="divide-y divide-line" data-next="{{ $nextIndex }}">
                            @foreach ($rows as $i => $row)
                                @include('purchase-request._item-row', ['i' => $i, 'row' => $row])
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" id="add-item" class="{{ $btn2 }}">
                            <x-icon name="plus" class="size-4" />
                            Tambah barang
                        </button>
                        <x-field-error :message="$errors->first('items')" />
                    </div>
                </div>
            </section>

            {{-- total dan tombol --}}
            <div class="flex flex-col gap-4 bg-surface-2 p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-label font-semibold">Total estimasi biaya</p>
                    <p id="total-estimated" aria-live="polite"
                       class="font-head text-display font-extrabold tabular-nums text-primary">Rp 0</p>
                    <p class="text-caption text-muted">Dihitung dari semua barang yang diminta.</p>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3">
                    {{-- setelah ada halaman daftar, arahkan Batal ke sana --}}
                    <a href="{{ route('purchase-requests.index') }}"
                    class="inline-flex h-10 items-center px-4 text-label font-semibold text-primary hover:underline">Batal</a>

                    <button type="submit" name="action" value="draft" data-submit class="{{ $btn2 }} disabled:cursor-not-allowed disabled:text-muted">
                        Simpan draf
                    </button>

                    <button type="submit" name="action" value="submit" data-submit
                            class="inline-flex h-10 items-center gap-2 rounded-sm bg-primary px-4 text-label font-semibold text-onprimary transition-colors
                                   hover:bg-primary-hover disabled:cursor-not-allowed disabled:bg-surface disabled:text-muted">
                        Kirim pengajuan
                        <x-icon name="chevron-right" class="size-4" />
                    </button>
                </div>
            </div>
        </div>

        {{-- cetakan baris baru untuk tombol "Tambah barang" --}}
        <template id="item-template">
            @include('purchase-request._item-row', [
                'i'   => '__INDEX__',
                'row' => ['name' => '', 'quantity' => 1, 'unit' => 'Pcs', 'price' => null],
            ])
        </template>
    </form>
@endsection

@push('scripts')
<script>
    (() => {
        const form    = document.getElementById('pr-form');
        const rows    = document.getElementById('item-rows');
        const tpl     = document.getElementById('item-template');
        const totalEl = document.getElementById('total-estimated');
        let next      = Number(rows.dataset.next);

        // total = jumlah x harga satuan, dijumlahkan semua baris
        function recalc() {
            let total = 0;
            rows.querySelectorAll('[data-item-row]').forEach((row) => {
                const qty   = parseFloat(row.querySelector('[data-qty]').value) || 0;
                const price = parseFloat(row.querySelector('[data-price]').value) || 0;
                total += qty * price;
            });
            totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID', { maximumFractionDigits: 2 });
        }

        // minimal satu baris harus ada
        function syncRemove() {
            const list = rows.querySelectorAll('[data-item-row]');
            list.forEach((row) => { row.querySelector('[data-remove]').disabled = list.length === 1; });
        }

        document.getElementById('add-item').addEventListener('click', () => {
            rows.insertAdjacentHTML('beforeend', tpl.innerHTML.replaceAll('__INDEX__', next++));
            syncRemove();
            recalc();
            rows.lastElementChild.querySelector('input').focus();
        });

        rows.addEventListener('click', (e) => {
            const button = e.target.closest('[data-remove]');
            if (!button) return;
            button.closest('[data-item-row]').remove();
            syncRemove();
            recalc();
        });

        rows.addEventListener('input', recalc);

        // cegah kirim ganda; nilai tombol yang diklik dipindah ke input tersembunyi
        // karena tombol yang dinonaktifkan tidak ikut terkirim
        form.addEventListener('submit', (e) => {
            const clicked = e.submitter;
            if (!clicked) return;

            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'action';
            hidden.value = clicked.value;
            form.appendChild(hidden);

            form.querySelectorAll('[data-submit]').forEach((b) => { b.disabled = true; });
            clicked.textContent = clicked.value === 'submit' ? 'Mengirim…' : 'Menyimpan…';
        });

        syncRemove();
        recalc();
    })();
</script>
@endpush