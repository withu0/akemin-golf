@extends('layouts.app')

@section('title', __('site.nav.join').' — '.config('site.brand_ja'))

@section('content')

<x-page-hero no="捌" :eyebrow="'Join Us'" seal="募集"
    title="仲間に、なる。"
    :lead="__('site.join.lead')" />

<section class="wrap py-10 md:py-16">
    <div class="grid gap-12 lg:gap-16 lg:grid-cols-[0.85fr_1.15fr]">

        {{-- left: invitation --}}
        <div class="reveal">
            <div class="img-frame aspect-[4/5] max-w-sm paper-edge mb-8">
                <img src="{{ media_url('media/friends.jpg', 'media/portrait.jpg') }}" alt="" class="h-full w-full object-cover">
            </div>
            <p class="prose-wa">国境も、年齢も、こえていきましょう。<br>ゴルフを愛するあなたからのメッセージを、こころよりお待ちしています。</p>
            <a href="{{ config('site.instagram') }}" target="_blank" rel="noopener" class="link-arrow mt-6">
                Instagram @akemi_harisienne_jp
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
            </a>
        </div>

        {{-- right: form --}}
        <div class="reveal">
            @if (session('joined'))
                <div class="bg-[var(--color-matsuba)] grain-dark text-[var(--color-paper)] p-10 md:p-12 text-center">
                    <span class="hanko mx-auto mb-6 bg-transparent !text-[var(--color-gold-soft)] !border-[var(--color-gold-soft)]">謝</span>
                    <h2 class="display text-2xl md:text-3xl">{{ __('site.join.thanks') }}</h2>
                    <p class="mt-4 text-white/75 leading-loose max-w-md mx-auto">{{ __('site.join.thanks_body') }}</p>
                    <a href="{{ route('home') }}" class="link-arrow mt-8 !text-[var(--color-paper)] justify-center">{{ __('site.nav.home') }}
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('join.store') }}" class="bg-[var(--color-paper)] border border-[var(--color-line)] p-8 md:p-12">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-8 border border-[var(--color-shu)]/40 text-[var(--color-shu)] px-4 py-3 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="grid gap-8 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="field-label" for="name">{{ __('site.join.name') }}</label>
                            <input id="name" name="name" value="{{ old('name') }}" required class="field mt-2" placeholder="">
                        </div>
                        <div>
                            <label class="field-label" for="email">{{ __('site.join.email') }} <span class="lowercase">— {{ __('site.join.optional') }}</span></label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="field mt-2">
                        </div>
                        <div>
                            <label class="field-label" for="country">{{ __('site.join.country') }} <span class="lowercase">— {{ __('site.join.optional') }}</span></label>
                            <input id="country" name="country" value="{{ old('country') }}" class="field mt-2">
                        </div>
                    </div>

                    <fieldset class="mt-8">
                        <legend class="field-label mb-3">{{ __('site.join.interest') }}</legend>
                        <div class="flex flex-wrap gap-3">
                            @foreach (['golf' => __('site.join.i_golf'), 'beauty' => __('site.join.i_beauty'), 'community' => __('site.join.i_community')] as $val => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="interest" value="{{ $val }}" class="peer sr-only" @checked(old('interest') === $val)>
                                    <span class="inline-block px-5 py-2.5 border border-[var(--color-line)] rounded-full text-sm font-[var(--font-serif)] transition-colors peer-checked:bg-[var(--color-sumi)] peer-checked:text-[var(--color-paper)] peer-checked:border-[var(--color-sumi)] hover:border-[var(--color-sumi)]">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="mt-8">
                        <label class="field-label" for="message">{{ __('site.join.message') }} <span class="lowercase">— {{ __('site.join.optional') }}</span></label>
                        <textarea id="message" name="message" rows="4" class="field mt-2 resize-none">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-gold mt-10 w-full justify-center">{{ __('site.join.submit') }}
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.4"/></svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</section>

@endsection
