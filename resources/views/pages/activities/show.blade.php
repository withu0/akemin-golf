@extends('layouts.app')

@section('title', $activity->t('title').' — '.config('site.brand_ja'))

@section('content')

@php
    $cover = $activity->relationLoaded('coverMedia')
        ? $activity->coverMedia
        : $activity->coverMedia()->first();
    $gallery = $activity->relationLoaded('media')
        ? $activity->media
        : $activity->media()->get();
@endphp

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

    @if ($cover)
        <div class="wrap mt-10 md:mt-12 reveal">
            <div class="img-frame aspect-[16/9] paper-edge">
                @if ($cover->isImage())
                    <img src="{{ media_url($cover->path) }}" alt="{{ $activity->t('title') }}" class="h-full w-full object-cover">
                @else
                    <video src="{{ media_url($cover->path) }}" class="h-full w-full object-cover" controls playsinline preload="metadata"></video>
                @endif
            </div>
        </div>
    @endif

    @if ($gallery->count() > 1 || (! $cover && $gallery->isNotEmpty()))
        <div class="wrap mt-6 md:mt-8 reveal">
            <div class="grid gap-2 sm:gap-2.5 grid-cols-2 sm:grid-cols-4">
                @foreach ($gallery as $media)
                    <div class="img-frame aspect-square overflow-hidden">
                        @if ($media->isImage())
                            <img src="{{ media_url($media->path) }}" alt="{{ $activity->t('title') }}" class="h-full w-full object-cover">
                        @else
                            <video src="{{ media_url($media->path) }}" class="h-full w-full object-cover" controls playsinline preload="metadata"></video>
                        @endif
                    </div>
                @endforeach
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
