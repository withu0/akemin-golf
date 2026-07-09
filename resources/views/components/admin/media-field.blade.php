@props([
    'name',
    'label',
    'accept',
    'kind' => 'image',
    'path' => null,
    'square' => false,
])

@php
    $removeName = 'remove_'.$name;
    $url = $path ? media_url($path) : null;
@endphp

<div>
    <x-admin.field :name="$name" :label="$label" type="file" :accept="$accept" />

    @if ($url)
        @if ($kind === 'video')
            <video src="{{ $url }}" class="mt-3 h-24 w-40 rounded-lg object-cover border border-[var(--color-line)]" muted playsinline preload="metadata"></video>
        @else
            <img src="{{ $url }}" alt="" class="mt-3 h-24 rounded-lg object-cover border border-[var(--color-line)] {{ $square ? 'w-24' : '' }}">
        @endif

        <label class="flex items-center gap-2 text-sm mt-2 text-[var(--color-shu)]">
            <input type="checkbox" name="{{ $removeName }}" value="1" class="accent-[var(--color-gold)]" @checked(old($removeName))>
            {{ $label }}を削除
        </label>
    @endif
</div>
