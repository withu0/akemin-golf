@props(['friend'])

<div class="card group block reveal">
    <div
        class="img-frame aspect-[3/4]"
        @if ($friend->video)
        data-friend-card-video
        onmouseenter="if(window.matchMedia('(hover: hover) and (pointer: fine)').matches){const v=this.querySelector('video'); if(v){v.play(); this.dataset.playing='1';}}"
        onmouseleave="if(window.matchMedia('(hover: hover) and (pointer: fine)').matches){const v=this.querySelector('video'); if(v){v.pause(); v.currentTime=0;} this.dataset.playing='0';}"
        @endif
    >
        @if ($friend->photo)
            <img
                src="{{ media_url($friend->photo) }}"
                alt="{{ $friend->name }}"
                class="relative z-[1] h-full w-full object-cover transition-opacity duration-300 friend-card-photo"
            >
        @elseif (! $friend->video)
            <div class="h-full w-full grid place-items-center text-5xl">{{ $friend->flag ?: '⛳' }}</div>
        @endif

        @if ($friend->video)
            <video
                src="{{ media_url($friend->video) }}"
                class="friend-card-video absolute inset-0 h-full w-full object-cover transition-opacity duration-300 {{ $friend->photo ? 'opacity-0' : 'opacity-100' }}"
                muted
                loop
                playsinline
                preload="{{ $friend->photo ? 'metadata' : 'auto' }}"
                @if ($friend->photo) poster="{{ media_url($friend->photo) }}" @endif
            ></video>
            <div class="friend-card-play pointer-events-none absolute inset-0 z-[2] flex items-center justify-center transition-opacity duration-300">
                <div class="absolute inset-0 bg-black/25"></div>
                <span class="relative flex h-16 w-16 items-center justify-center rounded-full bg-[var(--color-paper)]/95 text-[var(--color-sumi)] shadow-lg ring-2 ring-white/40 transition-transform duration-300 group-hover:scale-110">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" class="ml-1">
                        <path d="M6 4.5l12 6.5-12 6.5V4.5z" fill="currentColor" />
                    </svg>
                </span>
            </div>
        @endif

        @if ($friend->photo || $friend->video)
            <button
                type="button"
                class="friend-card-fullscreen absolute bottom-3 right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white opacity-0 transition-opacity group-hover:opacity-100 hover:bg-black/70"
                aria-label="Fullscreen"
                onclick="event.stopPropagation(); const frame=this.closest('.img-frame'); const playing=frame?.dataset.playing==='1'; const v=frame?.querySelector('video'); const p=frame?.querySelector('.friend-card-photo'); if(playing&&v){v.controls=true;v.muted=false;v.requestFullscreen?.();v.play();}else if(p){p.requestFullscreen?.();}else if(v){v.controls=true;v.muted=false;v.requestFullscreen?.();v.play();}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3" />
                </svg>
            </button>
        @endif

        @if (flag_url($friend->country_code))
            <img
                src="{{ flag_url($friend->country_code) }}"
                alt="{{ $friend->country }}"
                class="absolute top-4 left-4 z-10 h-9 w-9 rounded-full object-cover ring-2 ring-white/80 shadow-md"
            >
        @elseif ($friend->flag)
            <span class="absolute top-4 left-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-[var(--color-paper)]/90 text-xl shadow-md ring-2 ring-white/80">{{ $friend->flag }}</span>
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
    .img-frame[data-playing="1"] .friend-card-play { opacity: 0; }
    .img-frame[data-playing="1"] .friend-card-fullscreen { opacity: 1; }
</style>
@endif
