@extends('layouts.app')

@section('title', __('site.nav.friends').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="肆" :eyebrow="'Golf Friends'" seal="友"
    title="あけみんゴルフ<br>友世界"
    lead="一打が、ひとつの出会い。世界中でつながった、大切な仲間たち。" />

<section class="wrap py-12 md:py-16">
    @if ($friends->isEmpty())
        <p class="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">仲間を紹介中です。</p>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($friends as $friend)
                <x-friend-card :friend="$friend" />
            @endforeach
        </div>
    @endif
</section>

<section class="wrap py-12 text-center">
    <p class="font-[var(--font-serif)] text-xl text-[var(--color-sumi-soft)] reveal">あなたも、ゴルフ友になりませんか。</p>
    <a href="{{ route('join') }}" class="btn btn-gold mt-6 reveal">{{ __('site.cta.join') }}
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
    </a>
</section>

@endsection
