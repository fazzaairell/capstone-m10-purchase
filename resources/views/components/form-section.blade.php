@props(['title', 'description' => null, 'step' => null, 'total' => null])

<section class="rounded-lg border border-line bg-surface">
    <div class="grid gap-6 p-6 lg:grid-cols-3">
        <div>
            @if ($step)
                <p class="text-caption font-semibold text-accent">Bagian {{ $step }} dari {{ $total }}</p>
            @endif
            <h2 class="font-head text-h3 font-semibold">{{ $title }}</h2>
            @if ($description)
                <p class="mt-1 text-muted">{{ $description }}</p>
            @endif
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:col-span-2">
            {{ $slot }}
        </div>
    </div>
</section>