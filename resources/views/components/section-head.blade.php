@props(['eyebrow' => null, 'no' => null, 'title' => '', 'lead' => null, 'align' => 'left'])

<div {{ $attributes->merge(['class' => 'reveal max-w-2xl '.($align === 'center' ? 'mx-auto text-center' : '')]) }}>
    <div class="flex items-center gap-4 mb-5 {{ $align === 'center' ? 'justify-center' : '' }}">
        @if ($no)<span class="sec-no">{{ $no }}</span>@endif
        @if ($eyebrow)<span class="eyebrow">{{ $eyebrow }}</span>@endif
    </div>
    <h2 class="display text-3xl md:text-[2.6rem] leading-snug text-balance">{!! $title !!}</h2>
    @if ($lead)
        <p class="mt-5 text-[var(--color-sumi-soft)] leading-loose">{{ $lead }}</p>
    @endif
</div>
