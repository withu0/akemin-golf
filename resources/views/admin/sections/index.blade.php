@extends('layouts.admin')

@section('title', 'ページ内容')
@section('eyebrow', 'Pages')
@section('heading', 'ページ内容の編集')

@section('content')
@php
    $labels = [
        'hero'   => 'トップ（ヒーロー）',
        'about'  => '自己紹介',
        'beauty' => 'ゴルフと美容',
        'future' => 'これからのゴルフ',
        'global' => 'グローバルゴルフ',
    ];
@endphp
<div class="grid gap-4 sm:grid-cols-2">
    @foreach ($sections as $section)
        <a href="{{ route('admin.sections.edit', $section) }}" class="admin-card p-6 hover:-translate-y-1 transition-transform block">
            <p class="field-label">{{ $section->eyebrow ?: 'Section' }}</p>
            <h3 class="display text-xl mt-2">{{ $labels[$section->key] ?? $section->key }}</h3>
            <p class="text-sm text-[var(--color-mist)] mt-2 line-clamp-2">{{ $section->t('title') }}</p>
            <span class="link-arrow mt-4 inline-flex">編集する
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
            </span>
        </a>
    @endforeach
</div>
@if ($sections->isEmpty())
    <p class="text-center text-[var(--color-mist)] py-16 admin-card mt-4">シードを実行すると、編集できるページが表示されます。</p>
@endif
@endsection
