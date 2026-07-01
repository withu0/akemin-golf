@extends('layouts.app')

@section('title', $post->t('title').' — '.config('site.brand_ja'))
@section('meta', $post->t('excerpt'))

@section('content')

<article class="pt-32 md:pt-40">
    <div class="wrap-tight text-center">
        <a href="{{ route('life.index') }}" class="link-arrow mb-8 reveal">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M13 7H1M6 2L1 7l5 5" stroke="currentColor" stroke-width="1.4"/></svg>
            {{ __('site.cta.back') }}
        </a>

        <div class="flex items-center justify-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-5 reveal">
            @if ($post->published_at)<span>{{ $post->published_at->isoFormat('YYYY.MM.DD') }}</span>@endif
            @if ($post->category)<span class="text-[var(--color-gold)]">— {{ $post->category }}</span>@endif
        </div>

        <h1 class="display text-3xl md:text-5xl leading-tight text-balance max-w-3xl mx-auto reveal">{{ $post->t('title') }}</h1>
    </div>

    @if ($post->cover_image)
        <div class="wrap mt-10 md:mt-12 reveal">
            <div class="img-frame aspect-[16/9] max-w-4xl mx-auto paper-edge">
                <img src="{{ media_url($post->cover_image) }}" alt="{{ $post->t('title') }}" class="h-full w-full object-cover">
            </div>
        </div>
    @endif

    <div class="wrap-tight py-12 md:py-16">
        @if ($post->t('excerpt'))
            <p class="display text-xl md:text-2xl leading-relaxed text-[var(--color-sumi-soft)] mb-10 reveal">{{ $post->t('excerpt') }}</p>
            <hr class="rule-ink mb-10">
        @endif
        <div class="prose-wa reveal">{!! nl2br(e($post->t('body'))) !!}</div>
    </div>
</article>

@if ($more->isNotEmpty())
<section class="wrap pb-12">
    <hr class="rule-gold mb-12">
    <x-section-head :eyebrow="'More'" title="ほかのことば" class="mb-10" />
    <div class="grid gap-10 sm:grid-cols-3">
        @foreach ($more as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>
</section>
@endif

@endsection
