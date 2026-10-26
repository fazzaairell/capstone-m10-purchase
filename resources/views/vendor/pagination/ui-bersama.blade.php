@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Halaman" class="flex items-center gap-1">
        {{-- sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" class="inline-flex h-8 min-w-8 items-center justify-center rounded-sm px-2 text-muted opacity-50">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya"
               class="inline-flex h-8 min-w-8 items-center justify-center rounded-sm px-2 hover:bg-surface-2">‹</a>
        @endif

        {{-- nomor halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-muted">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                              class="inline-flex h-8 min-w-8 items-center justify-center rounded-sm bg-primary-soft px-2 font-semibold text-primary">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}"
                           class="inline-flex h-8 min-w-8 items-center justify-center rounded-sm px-2 hover:bg-surface-2">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya"
               class="inline-flex h-8 min-w-8 items-center justify-center rounded-sm px-2 hover:bg-surface-2">›</a>
        @else
            <span aria-disabled="true" class="inline-flex h-8 min-w-8 items-center justify-center rounded-sm px-2 text-muted opacity-50">›</span>
        @endif
    </nav>
@endif