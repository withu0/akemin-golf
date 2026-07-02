<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '管理') — {{ config('site.brand_ja') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500;600;700&family=Noto+Sans+JP:wght@300;400;500;700&family=Jost:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[var(--color-washi)]">

@php
    $adminNav = [
        ['route' => 'admin.dashboard',        'label' => 'ダッシュボード', 'match' => 'admin.dashboard'],
        ['route' => 'admin.sections.index',   'label' => 'ページ内容',     'match' => 'admin.sections.*'],
        ['route' => 'admin.activities.index', 'label' => '最近の活動',     'match' => 'admin.activities.*'],
        ['route' => 'admin.friends.index',    'label' => 'ゴルフ友',       'match' => 'admin.friends.*'],
        ['route' => 'admin.posts.index',      'label' => 'ゴルフと人生',   'match' => 'admin.posts.*'],
        ['route' => 'admin.photos.index',     'label' => '写真',           'match' => 'admin.photos.*'],
        ['route' => 'admin.applications.index','label' => '募集の応募',     'match' => 'admin.applications.*'],
    ];
@endphp

<div class="flex min-h-screen">
    {{-- sidebar --}}
    <aside class="hidden md:flex w-64 shrink-0 flex-col sticky top-0 self-start h-screen bg-[var(--color-sumi)] grain-dark text-[var(--color-paper)] p-6">
        <a href="{{ route('admin.dashboard') }}" class="mb-2">
            <x-logo variant="menu" tone="light" :show-en="false" />
        </a>
        <p class="eyebrow before:hidden !text-white/40 !text-[0.55rem] mb-8">Studio · 管理画面</p>

        <nav class="flex-1 space-y-1">
            @foreach ($adminNav as $item)
                <a href="{{ route($item['route']) }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-[var(--font-serif)] tracking-wide transition-colors {{ request()->routeIs($item['match']) ? 'bg-white/10 text-[var(--color-gold-soft)]' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-6 pt-6 border-t border-white/10 space-y-3">
            <a href="{{ route('home') }}" target="_blank" class="block text-xs text-white/50 hover:text-white tracking-widest uppercase font-[var(--font-label)]">サイトを見る ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="text-xs text-white/50 hover:text-[var(--color-shu)] tracking-widest uppercase font-[var(--font-label)]">ログアウト</button>
            </form>
        </div>
    </aside>

    {{-- main --}}
    <div class="flex-1 min-w-0">
        {{-- mobile topbar --}}
        <div class="md:hidden flex items-center justify-between bg-[var(--color-sumi)] text-[var(--color-paper)] px-5 py-4">
            <x-logo variant="menu" tone="light" :show-en="false" />
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="text-xs uppercase tracking-widest">出</button></form>
        </div>

        <main class="p-6 md:p-10 max-w-5xl">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <div>
                    <p class="eyebrow">@yield('eyebrow', 'Admin')</p>
                    <h1 class="display text-2xl md:text-3xl mt-2">@yield('heading', '')</h1>
                </div>
                @yield('actions')
            </div>

            @if (session('status'))
                <div class="mb-6 bg-[var(--color-matsuba)] text-[var(--color-paper)] px-5 py-3 text-sm rounded-lg">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-6 border border-[var(--color-shu)]/40 text-[var(--color-shu)] px-5 py-3 text-sm rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
