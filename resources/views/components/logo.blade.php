@props([
    'tone' => 'default',
    'variant' => 'header',
    'showEn' => true,
    'tag' => 'span',
])

@php
    $toneClass = match ($tone) {
        'light' => 'brand-wordmark--light',
        'gold'  => 'brand-wordmark--gold',
        default => 'brand-wordmark--default',
    };

    $brandJa = config('site.brand_ja');
    $suffix = 'ゴルフ';
    $name = str_ends_with($brandJa, $suffix) ? mb_substr($brandJa, 0, -mb_strlen($suffix)) : $brandJa;
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => "brand-wordmark brand-wordmark--{$variant} {$toneClass}"]) }}>
    <span class="brand-wordmark-ja" aria-label="{{ $brandJa }}">
        <span class="brand-wordmark-ja-name">{{ $name }}</span>
        @if (str_ends_with($brandJa, $suffix))
            <span class="brand-wordmark-ja-suffix">{{ $suffix }}</span>
        @endif
    </span>
    @if ($showEn)
        <span class="brand-wordmark-en">{{ str_replace(' ', "\u{00a0}", config('site.brand_en')) }}</span>
    @endif
</{{ $tag }}>
