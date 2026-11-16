@props([
    'name',
    'label',
    'value'        => null,
    'required'     => true,
    'type'         => 'text',
    'textarea'     => false,
    'options'      => null,
    'hint'         => null,
    'optionalText' => '(opsional)',
    'placeholder'  => null,
    'min'          => null,
    'max'          => null,
    'step'         => null,
])

@php
    $error   = $errors->first($name);
    $current = old($name, $value);
    $base    = 'w-full rounded-sm border bg-surface px-3 placeholder:text-muted '
             . ($error ? 'border-danger-solid' : 'border-line-strong');
    $aria    = $error ? 'aria-invalid="true" aria-describedby="' . $name . '-error"' : '';
@endphp

<div {{ $attributes }}>
    <label for="{{ $name }}" class="mb-1 block text-label font-semibold">
        {{ $label }}
        @if ($required)
            <span class="text-danger-fg" aria-hidden="true">*</span>
        @else
            <span class="font-normal text-muted">{{ $optionalText }}</span>
        @endif
    </label>

    @if ($options)
        <select id="{{ $name }}" name="{{ $name }}" {!! $aria !!} class="{{ $base }} h-10">
            @foreach ($options as $key => $text)
                <option value="{{ $key }}" @selected((string) $current === (string) $key)>{{ $text }}</option>
            @endforeach
        </select>
    @elseif ($textarea)
        <textarea id="{{ $name }}" name="{{ $name }}" rows="3" {!! $aria !!}
                  @if ($placeholder) placeholder="{{ $placeholder }}" @endif
                  class="{{ $base }} py-2">{{ $current }}</textarea>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $current }}" {!! $aria !!}
               @if ($placeholder) placeholder="{{ $placeholder }}" @endif
               @if ($min !== null) min="{{ $min }}" @endif
               @if ($max !== null) max="{{ $max }}" @endif
               @if ($step !== null) step="{{ $step }}" @endif
               class="{{ $base }} h-10">
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