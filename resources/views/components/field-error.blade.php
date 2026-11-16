@props(['message' => null])

@if ($message)
    <p {{ $attributes->merge(['class' => 'mt-1 flex items-start gap-2 text-caption text-danger-fg']) }}>
        <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/>
            <path stroke-linecap="round" d="M12 8v5M12 16h.01"/>
        </svg>
        {{ $message }}
    </p>
@endif