@extends('layouts.app')

@section('title', __('site.nav.activities').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="参" :eyebrow="'Activities'" seal="活動"
    title="最近の、活動。"
    lead="ラウンド、旅、出会い。あけみんゴルフの、いきいきとした日々。" />

<section class="wrap py-12 md:py-16">
    @if ($activities->isEmpty())
        <p class="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">準備中です。もうすこしお待ちください。</p>
    @else
        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($activities as $activity)
                <x-activity-card :activity="$activity" />
            @endforeach
        </div>
    @endif
</section>

@endsection
