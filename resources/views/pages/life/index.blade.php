@extends('layouts.app')

@section('title', __('site.nav.life').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="陸" :eyebrow="'Golf & Life'" seal="人生"
    title="ゴルフと、人生。"
    lead="グリーンの上で気づいた、小さな哲学。あけみんの綴る、ことば。" />

<section class="wrap py-12 md:py-16">
    @if ($posts->isEmpty())
        <p class="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">執筆中です。</p>
    @else
        <div class="grid gap-12 md:gap-x-10 md:gap-y-16 md:grid-cols-2">
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>
    @endif
</section>

@endsection
