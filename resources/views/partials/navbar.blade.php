@php
    $userName = auth()->user()->name ?? 'Administrator';
@endphp

<header class="fixed inset-x-0 top-0 z-40 flex h-14 items-center gap-4 border-b border-line bg-surface px-4 sm:px-6">
    {{-- tombol menu, hanya di bawah 1024px --}}
    <button type="button" id="menu-button" onclick="toggleSidebar()"
            aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu"
            class="-ml-2 inline-flex size-10 items-center justify-center rounded-sm hover:bg-surface-2 lg:hidden">
        <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- logo dan nama aplikasi --}}
    <a href="{{ url('/') }}" class="flex items-center gap-2 font-head text-h3 font-semibold">
        <span class="flex size-8 items-center justify-center rounded-sm bg-primary text-onprimary">
            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="4" y="4" width="16" height="16" rx="2"/>
                <path stroke-linecap="round" d="M12 4v16"/>
            </svg>
        </span>
        <span class="hidden sm:inline">Sistem pengadaan</span>
    </a>

    {{-- pencarian global (tengah) --}}
    <form role="search" action="{{ url('/pencarian') }}" method="GET"
          class="hidden md:mx-auto md:block md:max-w-xl md:flex-1">
        <label for="global-search" class="sr-only">Cari di seluruh sistem</label>
        <input id="global-search" type="search" name="q" placeholder="Cari di seluruh sistem"
               class="h-10 w-full rounded-sm border border-line-strong bg-surface px-3 placeholder:text-muted">
    </form>

    {{-- akun (kanan) --}}
    <div class="ml-auto flex items-center gap-3 md:ml-0">
        <span class="hidden sm:inline">{{ $userName }}</span>
        <span class="flex size-8 items-center justify-center rounded-full bg-primary-soft font-semibold text-primary" aria-hidden="true">
            {{ mb_strtoupper(mb_substr($userName, 0, 1)) }}
        </span>
    </div>
</header>