@extends('layouts.app')

@section('title', config('site.brand_ja').' — '.config('site.tagline_en'))

@section('content')

{{-- ============================ HERO ============================ --}}
<section class="relative overflow-hidden">
    <div class="wrap pt-32 md:pt-40 pb-16 md:pb-24">
        <div class="grid items-center gap-12 lg:gap-16 lg:grid-cols-[1.05fr_0.95fr]">

            {{-- left: words --}}
            <div class="reveal">
                <span class="eyebrow">{{ __('site.home.hero_eyebrow') }}</span>
                <h1 class="mt-6 display text-[2.9rem] sm:text-6xl lg:text-[4.4rem] leading-[1.12] text-balance">
                    {!! site_section('hero')->t('title') ?: __('site.home.hero_title') !!}
                </h1>
                <p class="mt-7 max-w-xl prose-wa">
                    {{ site_section('hero')->t('lead') ?: __('site.home.hero_lead') }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <a href="{{ route('join') }}" class="btn btn-gold">{{ __('site.cta.join') }}
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
                    </a>
                    <a href="{{ route('about') }}#film" class="link-arrow">
                        {{ __('site.home.watch') }}
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1"/><path d="M6.5 5.5l4 2.5-4 2.5z" fill="currentColor"/></svg>
                    </a>
                </div>
            </div>

            {{-- right: photo collage --}}
            <div class="relative reveal">
                <div class="relative mx-auto w-full max-w-md lg:max-w-none aspect-[5/6] sm:aspect-[6/5] lg:aspect-[5/5]">

                    {{-- faint gold offset frame, tucked behind the portrait --}}
                    <span class="absolute right-[2%] top-[4%] w-[55%] h-[72%] border border-[var(--color-gold-soft)]/55 -translate-x-3 -translate-y-3 z-10"></span>

                    {{-- main portrait --}}
                    <figure class="group absolute right-0 top-0 w-[58%] z-20 rotate-[1.5deg]">
                        <div class="img-frame aspect-[4/5] paper-edge">
                            <img src="{{ media_url(site_section('hero')->image, 'media/portrait.jpg') }}"
                                 alt="{{ config('site.owner_ja') }}" class="h-full w-full object-cover">
                        </div>
                    </figure>

                    {{-- on the course --}}
                    <figure class="group absolute left-0 top-[20%] w-[45%] z-30 -rotate-[3deg]">
                        <div class="img-frame aspect-[3/4] paper-edge">
                            <img src="{{ media_url('media/tropical.jpg') }}" alt="" class="h-full w-full object-cover">
                        </div>
                    </figure>

                    {{-- friends round --}}
                    <figure class="group absolute left-[14%] bottom-0 w-[46%] z-40 rotate-[2.5deg]">
                        <div class="img-frame aspect-[4/3] paper-edge">
                            <img src="{{ media_url('media/la-round.jpg') }}" alt="" class="h-full w-full object-cover">
                        </div>
                    </figure>

                    <span class="hanko absolute right-[8%] bottom-[24%] z-50 bg-[var(--color-paper)]">明見</span>
                    <span class="tategaki absolute left-[1%] top-[2%] text-xs tracking-[0.24em] text-[var(--color-gold)] hidden lg:block z-50">世界とつながるゴルフ</span>
                </div>
            </div>
        </div>
    </div>

    {{-- thin marquee strip --}}
    <div class="border-y border-[var(--color-line)] bg-[var(--color-paper)]/50 overflow-hidden">
        <div class="wrap py-4 flex flex-wrap items-center justify-center gap-x-8 gap-y-1 text-center text-[var(--color-mist)] font-[var(--font-label)] uppercase tracking-[0.3em] text-[0.66rem]">
            <span>Tokyo</span><span class="text-[var(--color-gold)]">✦</span>
            <span>Los Angeles</span><span class="text-[var(--color-gold)]">✦</span>
            <span>Singapore</span><span class="text-[var(--color-gold)]">✦</span>
            <span>Dubai</span><span class="text-[var(--color-gold)]">✦</span>
            <span>Paris</span><span class="text-[var(--color-gold)]">✦</span>
            <span>India</span>
        </div>
    </div>
</section>

{{-- ============================ PURPOSE 目的 ============================ --}}
<section class="wrap py-20 md:py-28">
    <x-section-head align="center" no="壱" :eyebrow="__('site.purpose.eyebrow')"
                    :title="__('site.purpose.title')" :lead="__('site.purpose.lead')" class="mb-14 md:mb-20" />

    <div class="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] md:grid-cols-3">
        @foreach (['one', 'two', 'three'] as $i => $k)
            <div class="bg-[var(--color-paper)] p-9 md:p-10 reveal" style="transition-delay: {{ $i * 90 }}ms">
                <div class="flex items-center justify-between mb-6">
                    <span class="sec-no text-2xl">0{{ $i + 1 }}</span>
                    <span class="tick"></span>
                </div>
                <h3 class="display text-2xl leading-snug">{{ __("site.purpose.{$k}_t") }}</h3>
                <p class="mt-4 text-[var(--color-sumi-soft)] leading-loose">{{ __("site.purpose.{$k}_b") }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ============================ ABOUT teaser ============================ --}}
<section class="relative py-20 md:py-28 bg-[var(--color-paper)] border-y border-[var(--color-line)]">
    <div class="wrap grid items-center gap-12 lg:grid-cols-2">
        <div class="relative reveal order-2 lg:order-1">
            <div class="img-frame aspect-[5/6] max-w-md mx-auto paper-edge">
                <img src="{{ media_url(site_section('about')->image, 'media/about.jpg') }}" alt="{{ config('site.owner_ja') }}" class="h-full w-full object-cover">
            </div>
            <span class="tategaki absolute -left-2 -top-4 h-28 text-sm text-[var(--color-gold)] hidden md:block">自己紹介</span>
        </div>
        <div class="order-1 lg:order-2">
            <x-section-head no="弐" :eyebrow="'About — '.config('site.owner_en')"
                            :title="site_section('about')->t('title') ?: '美容鍼の世界から、<br>グリーンの上へ。'" />
            <div class="prose-wa mt-7 reveal">
                {!! nl2br(e(site_section('about')->t('lead') ?: 'ハリジェンヌ主宰・光本朱見。世界35カ国で美を学び、いまはゴルフを通して世界中に友をつないでいます。')) !!}
            </div>
            <a href="{{ route('about') }}" class="link-arrow mt-8 reveal">
                {{ __('site.cta.learn_more') }}
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================ ACTIVITIES 最近の活動 ============================ --}}
@if ($activities->isNotEmpty())
<section class="wrap py-20 md:py-28">
    <div class="flex flex-wrap items-end justify-between gap-6 mb-12 md:mb-16">
        <x-section-head no="参" :eyebrow="__('site.nav.activities')" title="最近の活動" />
        <a href="{{ route('activities.index') }}" class="link-arrow reveal">
            {{ __('site.cta.view_all') }}
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
        </a>
    </div>
    <div class="grid gap-7 md:grid-cols-3">
        @foreach ($activities as $activity)
            <x-activity-card :activity="$activity" />
        @endforeach
    </div>
</section>
@endif

{{-- ============================ FRIENDS / GLOBAL ============================ --}}
@if ($friends->isNotEmpty())
<section class="relative py-20 md:py-28 bg-[var(--color-matsuba)] grain-dark text-[var(--color-paper)]">
    <div class="wrap">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-12 md:mb-16">
            <div class="reveal max-w-2xl">
                <span class="eyebrow !text-[var(--color-gold-soft)]">{{ __('site.nav.global') }}</span>
                <h2 class="mt-5 display text-3xl md:text-[2.6rem] leading-snug">世界に、ゴルフ友。</h2>
            </div>
            <a href="{{ route('friends.index') }}" class="link-arrow reveal !text-[var(--color-paper)]">
                {{ __('site.cta.view_all') }}
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
            </a>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($friends as $friend)
                <div class="reveal">
                    <div class="img-frame aspect-[3/4] group">
                        @if ($friend->photo)
                            <img src="{{ media_url($friend->photo) }}" alt="{{ $friend->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full grid place-items-center text-5xl bg-white/5">{{ $friend->flag ?: '⛳' }}</div>
                        @endif
                    </div>
                    <p class="mt-3 display text-lg">{{ $friend->name }}</p>
                    <p class="text-white/55 text-sm tracking-wide">{{ $friend->flag }} {{ $friend->country }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================ LIFE essays ============================ --}}
@if ($posts->isNotEmpty())
<section class="wrap py-20 md:py-28">
    <div class="flex flex-wrap items-end justify-between gap-6 mb-12 md:mb-16">
        <x-section-head no="肆" :eyebrow="__('site.nav.life')" title="ゴルフと、人生。" />
        <a href="{{ route('life.index') }}" class="link-arrow reveal">
            {{ __('site.cta.view_all') }}
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
        </a>
    </div>
    <div class="grid gap-12 md:grid-cols-2">
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>
</section>
@endif

{{-- ============================ JOIN band ============================ --}}
<section class="wrap pb-8">
    <div class="relative overflow-hidden bg-[var(--color-sumi)] grain-dark text-[var(--color-paper)] px-7 py-16 md:px-16 md:py-24 text-center reveal">
        <span class="hanko mx-auto mb-8 bg-[var(--color-sumi)] !text-[var(--color-gold-soft)] !border-[var(--color-gold-soft)]">募集</span>
        <h2 class="display text-3xl md:text-5xl leading-snug max-w-3xl mx-auto text-balance">{{ __('site.join.lead') }}</h2>
        <a href="{{ route('join') }}" class="btn btn-gold mt-10">{{ __('site.cta.join') }}
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
        </a>
    </div>
</section>

@endsection
