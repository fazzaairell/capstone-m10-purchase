@props([
    'name',
    'label',
    'value'    => null,
    'required' => true,
    'type'     => 'text',
    'textarea' => false,
    'hint'     => null,
])

@php
    $error = $errors->first($name);
    $field = 'w-full rounded-sm border bg-surface px-3 placeholder:text-muted '
           . ($error ? 'border-danger-solid' : 'border-line-strong');
@endphp

<div>
    <label for="{{ $name }}" class="mb-1 block text-label font-semibold">
        {{ $label }}
        @if ($required)
            <span class="text-danger-fg" aria-hidden="true">*</span>
        @else
            <span class="font-normal text-muted">(opsional)</span>
        @endif
    </label>

    @if ($textarea)
        <textarea id="{{ $name }}" name="{{ $name }}" rows="3"
                  @if ($error) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
                  class="{{ $field }} py-2">{{ old($name, $value) }}</textarea>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}"
               @if ($error) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
               class="{{ $field }} h-10">
    @endif

    @if ($error)
        <p id="{{ $name }}-error" class="mt-1 flex items-start gap-2 text-caption text-danger-fg">
            <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" d="M12 8v5M12 16h.01"/>
            </svg>
            {{ $error }}
        </p>
    @elseif ($hint)
        <p class="mt-1 text-caption text-muted">{{ $hint }}</p>
    @endif
</div>