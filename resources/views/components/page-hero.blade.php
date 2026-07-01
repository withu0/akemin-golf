@props(['eyebrow' => null, 'no' => null, 'title' => '', 'lead' => null, 'image' => null, 'seal' => null])

<section class="relative overflow-hidden pt-36 md:pt-48 pb-14 md:pb-20">
    @if ($image)
        <div class="absolute inset-0 -z-10">
            <img src="{{ $image }}" alt="" class="h-full w-full object-cover opacity-[0.16]">
            <div class="absolute inset-0 bg-gradient-to-b from-[var(--color-washi)] via-[var(--color-washi)]/70 to-[var(--color-washi)]"></div>
        </div>
    @endif

    <div class="wrap relative">
        <div class="flex items-center gap-4 mb-6 reveal">
            @if ($no)<span class="sec-no">{{ $no }}</span>@endif
            @if ($eyebrow)<span class="eyebrow">{{ $eyebrow }}</span>@endif
        </div>

        <div class="flex items-end justify-between gap-8">
            <h1 class="display text-[2.6rem] md:text-6xl leading-[1.15] text-balance reveal">{!! $title !!}</h1>
            @if ($seal)
                <span class="hanko shrink-0 mb-2 hidden sm:inline-grid">{{ $seal }}</span>
            @endif
        </div>

        @if ($lead)
            <p class="mt-7 max-w-2xl prose-wa reveal">{{ $lead }}</p>
        @endif

        <hr class="rule-gold mt-10 md:mt-14 reveal">
    </div>
</section>
