@props(['friend'])

<div class="card group block reveal">
    <div
        class="img-frame aspect-[3/4]"
        @if ($friend->video)
        onmouseenter="const v=this.querySelector('video'); if(v){v.play(); this.dataset.playing='1';}"
        onmouseleave="const v=this.querySelector('video'); if(v){v.pause(); v.currentTime=0;} this.dataset.playing='0';"
        @endif
    >
        @if ($friend->photo)
            <img
                src="{{ media_url($friend->photo) }}"
                alt="{{ $friend->name }}"
                class="h-full w-full object-cover transition-opacity duration-300 friend-card-photo"
            >
        @elseif (! $friend->video)
            <div class="h-full w-full grid place-items-center text-5xl">{{ $friend->flag ?: '⛳' }}</div>
        @else
            <div class="h-full w-full grid place-items-center text-5xl bg-[var(--color-washi-2)]">{{ $friend->flag ?: '⛳' }}</div>
        @endif

        @if ($friend->video)
            <video
                src="{{ media_url($friend->video) }}"
                class="friend-card-video absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-300"
                muted
                loop
                playsinline
                preload="metadata"
                @if ($friend->photo) poster="{{ media_url($friend->photo) }}" @endif
            ></video>
            <button
                type="button"
                class="absolute bottom-3 right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white opacity-0 transition-opacity group-hover:opacity-100 hover:bg-black/70"
                aria-label="Fullscreen"
                onclick="event.stopPropagation(); const v=this.previousElementSibling; v.controls=true; v.muted=false; v.requestFullscreen?.(); v.play();"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3" />
                </svg>
            </button>
        @endif

        @if ($friend->flag)
            <span class="absolute top-4 left-4 z-10 text-2xl drop-shadow">{{ $friend->flag }}</span>
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

@if ($friend->video)
<style>
    .img-frame[data-playing="1"] .friend-card-video { opacity: 1; }
    .img-frame[data-playing="1"] .friend-card-photo { opacity: 0; }
</style>
@endif
