@props(['activity'])

@php
    $cover = $activity->relationLoaded('coverMedia')
        ? $activity->coverMedia
        : $activity->coverMedia()->first();
@endphp

<a href="{{ route('activities.show', $activity) }}" class="card group block reveal">
    <div class="img-frame aspect-[4/3]">
        @if ($cover?->isImage())
            <img src="{{ media_url($cover->path) }}" alt="{{ $activity->t('title') }}" class="h-full w-full object-cover">
        @elseif ($cover?->isVideo())
            <video src="{{ media_url($cover->path) }}" class="h-full w-full object-cover" muted playsinline preload="metadata"></video>
        @else
            <div class="h-full w-full grid place-items-center text-[var(--color-mist)] display text-2xl">{{ config('site.brand_ja') }}</div>
        @endif
    </div>
    <div class="p-6">
        <div class="flex items-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-3">
            @if ($activity->happened_on)<span>{{ $activity->happened_on->isoFormat('YYYY.MM.DD') }}</span>@endif
            @if ($activity->location)<span class="text-[var(--color-gold)]">— {{ $activity->location }}</span>@endif
        </div>
        <h3 class="display text-xl leading-snug group-hover:text-[var(--color-gold)] transition-colors">{{ $activity->t('title') }}</h3>
    </div>
</a>
