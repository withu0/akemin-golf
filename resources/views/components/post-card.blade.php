@props(['post'])

<a href="{{ route('life.show', $post) }}" class="group block reveal">
    <div class="img-frame aspect-[16/10] mb-5">
        @if ($post->cover_image)
            <img src="{{ media_url($post->cover_image) }}" alt="{{ $post->t('title') }}" class="h-full w-full object-cover">
        @else
            <div class="h-full w-full grid place-items-center text-[var(--color-mist)] display text-2xl">エッセイ</div>
        @endif
    </div>
    <div class="flex items-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-2">
        @if ($post->published_at)<span>{{ $post->published_at->isoFormat('YYYY.MM.DD') }}</span>@endif
        @if ($post->category)<span class="text-[var(--color-gold)]">— {{ $post->category }}</span>@endif
    </div>
    <h3 class="display text-2xl leading-snug group-hover:text-[var(--color-gold)] transition-colors">{{ $post->t('title') }}</h3>
    @if ($post->t('excerpt'))
        <p class="mt-3 text-[var(--color-sumi-soft)] leading-relaxed line-clamp-2">{{ $post->t('excerpt') }}</p>
    @endif
</a>
