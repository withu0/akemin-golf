@extends('layouts.app')

@section('title', __('site.nav.about').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="弐" :eyebrow="'About — '.config('site.owner_en')" seal="朱見"
    :title="site_section('about')->t('title') ?: '美容鍼の世界から、<br>グリーンの上へ。'"
    :lead="site_section('about')->t('lead') ?: 'ハリジェンヌ主宰・光本朱見。世界で仕事しながら、ゴルフで友をつないでいます。'"
    :image="media_url(site_section('about')->image, 'media/portrait.jpg')" />

{{-- bio --}}
<section class="wrap py-14 md:py-20">
    <div class="grid gap-12 lg:gap-16 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="relative reveal">
            <div class="img-frame aspect-[4/5] max-w-md paper-edge">
                <img src="{{ media_url('media/portrait.jpg') }}" alt="{{ config('site.owner_ja') }}" class="h-full w-full object-cover">
            </div>
            <span class="tategaki absolute -right-7 top-6 text-xs tracking-[0.22em] text-[var(--color-gold)] hidden lg:block">より美しく、未来を求めて</span>
        </div>

        <div class="prose-wa reveal">
            {!! nl2br(e(site_section('about')->t('body') ?:
                "はじめまして、光本朱見（あけみん）です。\n美容鍼サロン「ハリジェンヌ」を主宰し、世界35カ国で美と健康を学んできました。\n\nゴルフは、私にとって人生そのもの。グリーンに立てば、年齢も国籍も関係なく、ひとつの笑顔でつながれます。\n\n美容・集中力・健康・体力・足腰——ゴルフはそのすべてを磨いてくれる。だから私は、ゴルフを通して世界中に友達を増やし、エネルギーを高めながら、Global Grandmother を目指しています。")) !!}
        </div>
    </div>
</section>

{{-- credentials strip --}}
<section class="wrap pb-6">
    <div class="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] sm:grid-cols-3 reveal">
        @foreach ([['35', '世界で学んだ国', 'Countries studied'], ['∞', '世界の友', 'Friends worldwide'], ['1日1歩', '毎日の挑戦', 'A challenge a day']] as $stat)
            <div class="bg-[var(--color-paper)] p-8 text-center">
                <p class="display text-4xl text-[var(--color-gold)]">{{ $stat[0] }}</p>
                <p class="mt-2 font-[var(--font-serif)] text-lg">{{ $stat[1] }}</p>
                <p class="eyebrow before:hidden !tracking-[0.2em] mt-1">{{ $stat[2] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- film --}}
<section id="film" class="wrap py-16 md:py-24 scroll-mt-28">
    <x-section-head align="center" :eyebrow="'Film'" title="スウィングという、いちばんの自己紹介。" class="mb-10 md:mb-14" />
    <div class="reveal img-frame aspect-video max-w-4xl mx-auto paper-edge bg-[var(--color-sumi)]">
        <video class="h-full w-full object-cover" controls preload="metadata" playsinline
               poster="{{ media_url('media/film-poster.jpg', 'media/portrait.jpg') }}">
            <source src="{{ media_url('media/golf.mp4') }}" type="video/mp4">
        </video>
    </div>
</section>

@endsection
