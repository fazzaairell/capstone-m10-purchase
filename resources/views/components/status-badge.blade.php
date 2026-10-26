@props(['type' => 'neutral'])

@php
    $styles = [
        'success' => ['bg-success-bg text-success-fg', 'bg-success-solid'],
        'pending' => ['bg-pending-bg text-pending-fg', 'bg-pending-solid'],
        'danger'  => ['bg-danger-bg text-danger-fg',   'bg-danger-solid'],
        'info'    => ['bg-info-bg text-info-fg',       'bg-info-solid'],
        'neutral' => ['bg-neutral-bg text-neutral-fg', 'bg-neutral-solid'],
    ];
    [$wrap, $dot] = $styles[$type] ?? $styles['neutral'];
@endphp

<span class="inline-flex h-6 items-center gap-2 whitespace-nowrap rounded-full px-3 text-caption font-semibold {{ $wrap }}">
    <span class="size-2 rounded-full {{ $dot }}" aria-hidden="true"></span>
    {{ $slot }}
</span>