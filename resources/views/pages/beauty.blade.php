@extends('layouts.app')

@section('title', __('site.nav.beauty').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="弐" :eyebrow="__('site.beauty.eyebrow')" seal="美"
    :title="site_section('beauty')->t('title') ?: __('site.beauty.title')"
    :lead="site_section('beauty')->t('lead') ?: __('site.beauty.lead')"
    :image="media_url(site_section('beauty')->image, 'media/beauty.jpg')" />

{{-- five pillars --}}
<section class="wrap py-10 md:py-16">
    <div class="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] sm:grid-cols-2 lg:grid-cols-5">
        @foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $i => $p)
            <div class="bg-[var(--color-paper)] p-7 reveal flex flex-col" style="transition-delay: {{ $i * 70 }}ms">
                <span class="sec-no text-xl">0{{ $i + 1 }}</span>
                <h3 class="display text-2xl mt-4 mb-3">{{ __("site.beauty.{$p}_t") }}</h3>
                <p class="text-[var(--color-sumi-soft)] text-[0.95rem] leading-relaxed">{{ __("site.beauty.{$p}_b") }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- editable essay --}}
@if (site_section('beauty')->t('body'))
<section class="wrap-tight py-12 md:py-20">
    <div class="prose-wa reveal">{!! nl2br(e(site_section('beauty')->t('body'))) !!}</div>
</section>
@endif

{{-- closing quote band --}}
<section class="wrap py-12">
    <div class="bg-[var(--color-paper)] border border-[var(--color-line)] px-8 py-14 md:py-20 text-center reveal">
        <span class="eyebrow">Harisienne</span>
        <p class="display text-2xl md:text-4xl leading-snug max-w-3xl mx-auto mt-6 text-balance">「より美しく、未来を求めて。」</p>
        <a href="{{ config('site.harisienne') }}" target="_blank" rel="noopener" class="link-arrow mt-8">
            {{ __('site.footer.also') }}
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
        </a>
    </div>
</section>

@endsection
