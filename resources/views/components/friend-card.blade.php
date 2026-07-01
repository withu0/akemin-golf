@props(['friend'])

<div class="card group block reveal">
    <div class="img-frame aspect-[3/4]">
        @if ($friend->photo)
            <img src="{{ media_url($friend->photo) }}" alt="{{ $friend->name }}" class="h-full w-full object-cover">
        @else
            <div class="h-full w-full grid place-items-center text-5xl">{{ $friend->flag ?: '⛳' }}</div>
        @endif
        @if ($friend->flag)
            <span class="absolute top-4 left-4 text-2xl drop-shadow">{{ $friend->flag }}</span>
        @endif
    </div>
    <div class="p-5">
        <h3 class="display text-lg leading-tight">{{ $friend->name }}</h3>
        @if ($friend->country)
            <p class="eyebrow before:hidden !tracking-[0.2em] mt-1.5">{{ $friend->country }}</p>
        @endif
        @if ($friend->t('message'))
            <p class="mt-3 text-sm text-[var(--color-sumi-soft)] leading-relaxed">{{ $friend->t('message') }}</p>
        @endif
        @if ($friend->instagram)
            <a href="https://instagram.com/{{ ltrim($friend->instagram, '@') }}" target="_blank" rel="noopener"
               class="mt-3 inline-block text-xs tracking-widest uppercase text-[var(--color-gold)] hover:underline font-[var(--font-label)]">@ {{ ltrim($friend->instagram, '@') }} ↗</a>
        @endif
    </div>
</div>
