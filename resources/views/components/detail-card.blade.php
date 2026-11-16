@props(['title', 'items' => []])

<section class="rounded-lg border border-line bg-surface">
    <h2 class="border-b border-line px-4 py-3 font-head text-h3 font-semibold">{{ $title }}</h2>

    <dl class="divide-y divide-line">
        @foreach ($items as $label => $value)
            <div class="grid gap-1 px-4 py-3 sm:grid-cols-5 sm:gap-4">
                <dt class="text-muted sm:col-span-2">{{ $label }}</dt>
                <dd class="whitespace-pre-line sm:col-span-3">
                    @if (filled($value))
                        {{ $value }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </dd>
            </div>
        @endforeach
    </dl>
</section>