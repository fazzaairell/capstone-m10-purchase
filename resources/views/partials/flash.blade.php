{{-- Toast sukses: pojok kanan atas, garis kiri 4px sesuai status --}}
@if (session('success'))
    <div data-toast role="status"
         class="fixed left-4 right-4 top-16 z-50 flex items-start gap-3 rounded-lg border border-l-4 border-l-success-solid bg-surface p-4 shadow-float sm:left-auto sm:w-90">
        <span class="flex size-6 shrink-0 items-center justify-center rounded-full bg-success-bg text-success-fg">
            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </span>
        <div class="min-w-0 flex-1">
            <p class="font-semibold">{{ session('success') }}</p>
            @if (session('success_detail'))
                <p class="text-caption text-muted">{{ session('success_detail') }}</p>
            @endif
        </div>
        <button type="button" aria-label="Tutup" onclick="this.closest('[data-toast]').remove()"
                class="-mr-1 -mt-1 inline-flex size-8 items-center justify-center rounded-sm text-muted hover:bg-surface-2">
            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>
    </div>
    <script>setTimeout(() => document.querySelector('[data-toast]')?.remove(), 5000);</script>
@endif

{{-- Banner galat: lebar penuh di atas konten --}}
@if (session('error'))
    <div role="alert" class="mb-4 flex items-start gap-3 rounded-lg bg-danger-bg p-4 text-danger-fg">
        <span class="mt-2 size-2 shrink-0 rounded-full bg-danger-solid" aria-hidden="true"></span>
        <p class="font-semibold">{{ session('error') }}</p>
    </div>
@endif