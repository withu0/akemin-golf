@extends('layouts.admin')

@section('title', 'ダッシュボード')
@section('eyebrow', 'Dashboard')
@section('heading', 'ようこそ、あけみん')

@section('content')

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @php
        $cards = [
            ['最近の活動', $counts['activities'], 'admin.activities.index'],
            ['ゴルフ友',   $counts['friends'],    'admin.friends.index'],
            ['ゴルフと人生', $counts['posts'],     'admin.posts.index'],
            ['写真',       $counts['photos'],     'admin.photos.index'],
            ['ページ内容', null,                  'admin.sections.index'],
        ];
    @endphp
    @foreach ($cards as $c)
        <a href="{{ route($c[2]) }}" class="admin-card p-6 hover:-translate-y-1 transition-transform block">
            <p class="field-label">{{ $c[0] }}</p>
            <p class="display text-4xl mt-3">{{ $c[1] ?? '—' }}</p>
        </a>
    @endforeach

    <a href="{{ route('admin.applications.index') }}" class="admin-card p-6 hover:-translate-y-1 transition-transform block bg-[var(--color-sumi)] grain-dark text-[var(--color-paper)]">
        <p class="field-label !text-white/50">募集の応募</p>
        <p class="display text-4xl mt-3">{{ $counts['applications'] }}</p>
        @if ($counts['new_apps'] > 0)
            <span class="chip chip-new mt-3 inline-block">未対応 {{ $counts['new_apps'] }}</span>
        @endif
    </a>
</div>

<div class="admin-card mt-8 p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="display text-xl">最近の応募</h2>
        <a href="{{ route('admin.applications.index') }}" class="link-arrow">すべて見る
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
        </a>
    </div>
    @if ($recentApps->isEmpty())
        <p class="text-[var(--color-mist)] text-sm py-6 text-center">まだ応募はありません。</p>
    @else
        <ul class="divide-y divide-[var(--color-line)]">
            @foreach ($recentApps as $app)
                <li class="py-3 flex items-center justify-between gap-4">
                    <div>
                        <span class="font-[var(--font-serif)]">{{ $app->name }}</span>
                        <span class="text-[var(--color-mist)] text-sm ml-2">{{ $app->country }}</span>
                    </div>
                    <span class="text-xs text-[var(--color-mist)] font-[var(--font-label)]">{{ $app->created_at->isoFormat('YYYY.MM.DD') }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
