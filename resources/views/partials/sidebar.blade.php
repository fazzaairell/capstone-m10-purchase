@php
    $menus = [
        ['label' => 'Supplier',             'route' => 'suppliers.index',         'match' => 'suppliers.*'],
        ['label' => 'Permintaan pembelian', 'route' => 'purchase-requests.index', 'match' => 'purchase-requests.*'],
        ['label' => 'Purchase order',       'route' => 'purchase-orders.index',   'match' => 'purchase-orders.*'],
    ];
@endphp

<div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 z-20 hidden bg-overlay lg:hidden"></div>

<aside id="sidebar"
       class="fixed bottom-0 left-0 top-14 z-30 w-60 -translate-x-full overflow-y-auto border-r border-line bg-surface p-4
              transition-transform duration-300 lg:translate-x-0">
    <nav aria-label="Menu utama">
        {{-- nama modul tampil sebagai judul grup --}}
        <p class="mb-2 px-3 text-caption font-semibold text-muted">Modul pengadaan</p>

        <ul class="space-y-1">
            @foreach ($menus as $menu)
                @php $active = request()->routeIs($menu['match']); @endphp
                <li>
                    <a href="{{ route($menu['route']) }}"
                       @if ($active) aria-current="page" @endif
                       class="flex h-10 items-center rounded-sm px-3
                              {{ $active ? 'bg-primary-soft font-semibold text-primary' : 'hover:bg-surface-2' }}">
                        {{ $menu['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>