@extends('layouts.app')

@section('title', __('site.nav.global').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="漆" :eyebrow="'Global Golf'" seal="世界"
    :title="site_section('global')->t('title') ?: 'グリーンは、<br>世界へつづいている。'"
    :lead="site_section('global')->t('lead') ?: 'クラブひとつを携えて、国から国へ。ゴルフは、世界中の友と出会うためのパスポート。'"
    :image="media_url(site_section('global')->image, 'media/airport.jpg')" />

{{-- cities --}}
<section class="wrap py-12 md:py-16">
    <div class="flex flex-wrap justify-center gap-x-10 gap-y-4 reveal">
        @foreach (['東京 Tokyo', 'Los Angeles', 'Singapore', 'Dubai', 'Paris', 'Mumbai'] as $c)
            <span class="font-[var(--font-serif)] text-xl md:text-2xl text-[var(--color-sumi-soft)]">{{ $c }}</span>
            @if (! $loop->last)<span class="text-[var(--color-gold)] self-center">✦</span>@endif
        @endforeach
    </div>
</section>

@if (site_section('global')->t('body'))
<section class="wrap-tight pb-8">
    <div class="prose-wa reveal">{!! nl2br(e(site_section('global')->t('body'))) !!}</div>
</section>
@endif

{{-- friends --}}
@if ($friends->isNotEmpty())
<section class="wrap py-12 md:py-16">
    <x-section-head :eyebrow="__('site.nav.friends')" title="世界の、ゴルフ友。" class="mb-10 md:mb-14" />
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($friends as $friend)
            <x-friend-card :friend="$friend" />
        @endforeach
    </div>
</section>
@endif

<section class="wrap py-12 text-center">
    <a href="{{ route('join') }}" class="btn btn-gold reveal">{{ __('site.cta.join') }}
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
    </a>
</section>

@endsection
