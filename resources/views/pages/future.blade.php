@extends('layouts.app')

@section('title', __('site.nav.future').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="伍" :eyebrow="'The Road Ahead'" seal="未来"
    :title="site_section('future')->t('title') ?: 'これからの、ゴルフ。'"
    :lead="site_section('future')->t('lead') ?: '一打ごとに、未来をひらいていく。あけみんが描く、これからの景色。'"
    :image="media_url(site_section('future')->image, 'media/future.jpg')" />

<section class="wrap-tight py-14 md:py-20">
    <div class="prose-wa reveal">
        {!! nl2br(e(site_section('future')->t('body') ?:
            "目標は、Global Grandmother。\n世界中のグリーンに立ち、年齢を重ねるほどに自由に、しなやかに。\n\nいつか、出会った友と同じコースを歩き、それぞれの国の言葉で笑い合いたい。\nゴルフは、その夢への一歩。これからも毎日挑戦し、エネルギーを高めていきます。")) !!}
    </div>
</section>

{{-- vision steps --}}
<section class="wrap pb-8">
    <div class="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] md:grid-cols-3">
        @foreach ([['挑戦', '毎日、ひとつ', 'A challenge a day'], ['つながり', '世界に友を', 'Friends worldwide'], ['しなやかさ', '生涯、自分の足で', 'Grace for a lifetime']] as $i => $v)
            <div class="bg-[var(--color-paper)] p-9 reveal" style="transition-delay: {{ $i * 90 }}ms">
                <span class="sec-no text-xl">0{{ $i + 1 }}</span>
                <h3 class="display text-2xl mt-4">{{ $v[0] }}</h3>
                <p class="mt-2 font-[var(--font-serif)] text-[var(--color-sumi-soft)]">{{ $v[1] }}</p>
                <p class="eyebrow before:hidden !tracking-[0.2em] mt-3">{{ $v[2] }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="wrap py-12 text-center">
    <a href="{{ route('join') }}" class="btn btn-gold reveal">{{ __('site.cta.join') }}
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
    </a>
</section>

@endsection
