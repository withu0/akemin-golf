@extends('layouts.app')

@section('title', $activity->t('title').' — '.config('site.brand_ja'))

@section('content')

<article class="pt-32 md:pt-40">
    <div class="wrap-tight">
        <a href="{{ route('activities.index') }}" class="link-arrow mb-8 reveal">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M13 7H1M6 2L1 7l5 5" stroke="currentColor" stroke-width="1.4"/></svg>
            {{ __('site.cta.back') }}
        </a>

        <div class="flex items-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-5 reveal">
            @if ($activity->happened_on)<span>{{ $activity->happened_on->isoFormat('YYYY.MM.DD') }}</span>@endif
            @if ($activity->location)<span class="text-[var(--color-gold)]">— {{ $activity->location }}</span>@endif
        </div>

        <h1 class="display text-3xl md:text-5xl leading-tight text-balance reveal">{{ $activity->t('title') }}</h1>
    </div>

    @if ($activity->cover_image)
        <div class="wrap mt-10 md:mt-12 reveal">
            <div class="img-frame aspect-[16/9] paper-edge">
                <img src="{{ media_url($activity->cover_image) }}" alt="{{ $activity->t('title') }}" class="h-full w-full object-cover">
            </div>
        </div>
    @endif

    <div class="wrap-tight py-12 md:py-16">
        <div class="prose-wa reveal">{!! nl2br(e($activity->t('body'))) !!}</div>
    </div>
</article>

@if ($more->isNotEmpty())
<section class="wrap pb-12">
    <hr class="rule-gold mb-12">
    <x-section-head :eyebrow="'More'" title="ほかの活動" class="mb-10" />
    <div class="grid gap-7 sm:grid-cols-3">
        @foreach ($more as $activity)
            <x-activity-card :activity="$activity" />
        @endforeach
    </div>
</section>
@endif

@endsection
