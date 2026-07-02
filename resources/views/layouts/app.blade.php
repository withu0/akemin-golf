<!DOCTYPE html>
<html lang="{{ config('site.locales')[app()->getLocale()]['html'] ?? app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('site.brand_ja')) — {{ config('site.brand_ja') }}</title>
    <meta name="description" content="@yield('meta', __('site.footer.tagline'))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+SC:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">

@php
    $nav = [
        ['key' => 'about',      'route' => 'about',            'no' => '01'],
        ['key' => 'beauty',     'route' => 'beauty',           'no' => '02'],
        ['key' => 'activities', 'route' => 'activities.index', 'no' => '03'],
        ['key' => 'friends',    'route' => 'friends.index',    'no' => '04'],
        ['key' => 'future',     'route' => 'future',           'no' => '05'],
        ['key' => 'life',       'route' => 'life.index',       'no' => '06'],
        ['key' => 'global',     'route' => 'global',           'no' => '07'],
        ['key' => 'join',       'route' => 'join',             'no' => '08'],
    ];
@endphp

{{-- ============================ Header ============================ --}}
<header data-header class="site-header fixed inset-x-0 top-0 z-50">
    <div class="wrap flex items-center justify-between py-5">
        <a href="{{ route('home') }}">
            <x-logo />
        </a>

        <nav class="hidden lg:flex items-center gap-7">
            @foreach (['about' => 'about', 'activities' => 'activities.index', 'friends' => 'friends.index', 'global' => 'global'] as $k => $r)
                <a href="{{ route($r) }}" class="nav-link {{ request()->routeIs($r === 'activities.index' ? 'activities.*' : ($r === 'friends.index' ? 'friends.*' : $r)) ? 'is-active' : '' }}">{{ __("site.nav.$k") }}</a>
            @endforeach
            <a href="{{ route('join') }}" class="btn btn-gold !px-6 !py-2.5">{{ __('site.nav.join') }}</a>
        </nav>

        <div class="flex items-center gap-5">
            {{-- language switcher --}}
            <div class="hidden sm:flex items-center gap-2 text-[0.7rem] font-[var(--font-label)] tracking-widest">
                @foreach (config('site.locales') as $code => $loc)
                    <a href="{{ switch_locale_url($code) }}"
                       class="uppercase transition-colors {{ app()->getLocale() === $code ? 'text-[var(--color-gold)]' : 'text-[var(--color-mist)] hover:text-[var(--color-sumi)]' }}">
                        {{ $code === 'zh' ? '中' : strtoupper($code) }}
                    </a>
                    @if (! $loop->last)<span class="text-[var(--color-line)]">/</span>@endif
                @endforeach
            </div>

            <button data-menu-toggle aria-expanded="false" aria-label="{{ __('site.meta.menu') }}"
                    class="flex items-center gap-2.5 text-sumi">
                <span class="hidden md:inline eyebrow before:hidden !tracking-[0.3em]">{{ __('site.meta.menu') }}</span>
                <span class="flex flex-col gap-[5px]">
                    <span class="block h-px w-6 bg-[var(--color-sumi)]"></span>
                    <span class="block h-px w-6 bg-[var(--color-sumi)]"></span>
                </span>
            </button>
        </div>
    </div>
</header>

{{-- ======================= Fullscreen menu ======================= --}}
<div id="site-menu" class="grain-dark">
    <div class="wrap h-full flex flex-col">
        <div class="flex items-center justify-between py-5">
            <x-logo variant="menu" tone="light" />
            <button data-menu-close aria-label="{{ __('site.meta.close') }}" class="eyebrow before:hidden !text-[var(--color-gold-soft)] !tracking-[0.3em]">{{ __('site.meta.close') }} ✕</button>
        </div>

        <nav class="flex-1 flex flex-col justify-center gap-3 md:gap-4">
            <a href="{{ route('home') }}" class="menu-link"><span class="menu-no">00</span>{{ __('site.nav.home') }}</a>
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}" class="menu-link">
                    <span class="menu-no">{{ $item['no'] }}</span>{{ __("site.nav.{$item['key']}") }}
                </a>
            @endforeach
        </nav>

        <div class="flex flex-wrap items-center justify-between gap-4 py-7 border-t border-white/15">
            <div class="flex items-center gap-4">
                @foreach (config('site.locales') as $code => $loc)
                    <a href="{{ switch_locale_url($code) }}" class="text-sm tracking-widest uppercase {{ app()->getLocale() === $code ? 'text-[var(--color-gold-soft)]' : 'text-white/55 hover:text-white' }}">{{ $loc['label'] }}</a>
                @endforeach
            </div>
            <a href="{{ config('site.instagram') }}" target="_blank" rel="noopener" class="text-sm tracking-widest uppercase text-white/55 hover:text-white">Instagram ↗</a>
        </div>
    </div>
</div>

{{-- ============================ Main ============================ --}}
<main>
    @yield('content')
</main>

{{-- ============================ Footer ============================ --}}
<footer class="relative mt-24 bg-[var(--color-sumi)] text-[var(--color-paper)] grain-dark">
    <div class="wrap py-16 md:py-20">
        <div class="grid gap-12 md:grid-cols-[1.4fr_1fr_1fr]">
            <div>
                <x-logo variant="footer" tone="gold" :show-en="false" class="mb-4" />
                <p class="text-white/65 max-w-sm leading-relaxed">{{ __('site.footer.tagline') }}</p>
                <p class="mt-6 eyebrow before:hidden !text-[var(--color-gold-soft)]">{{ __('site.meta.founder') }} — {{ config('site.owner_ja') }}</p>
            </div>

            <div>
                <p class="eyebrow before:hidden mb-5 !text-white/40">{{ __('site.footer.nav') }}</p>
                <ul class="space-y-2.5">
                    @foreach ($nav as $item)
                        <li><a href="{{ route($item['route']) }}" class="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]">{{ __("site.nav.{$item['key']}") }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="eyebrow before:hidden mb-5 !text-white/40">Connect</p>
                <ul class="space-y-2.5">
                    <li><a href="{{ config('site.instagram') }}" target="_blank" rel="noopener" class="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]">Instagram @akemi_harisienne_jp ↗</a></li>
                    <li><a href="{{ config('site.harisienne') }}" target="_blank" rel="noopener" class="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]">{{ __('site.footer.also') }} ↗</a></li>
                    <li><a href="{{ route('join') }}" class="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]">{{ __('site.nav.join') }}</a></li>
                </ul>
            </div>
        </div>

        <hr class="rule-gold my-12 opacity-40">

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-white/45 text-xs tracking-widest uppercase font-[var(--font-label)]">
            <span>© {{ date('Y') }} {{ config('site.footer.rights') ?? 'Akemin Golf' }} · {{ config('site.owner_en') }}</span>
            <span>{{ config('site.tagline_en') }}</span>
        </div>
    </div>
</footer>

</body>
</html>
