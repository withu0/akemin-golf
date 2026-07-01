@extends('layouts.admin')

@section('title', '募集の応募')
@section('eyebrow', 'Applications')
@section('heading', '募集の応募')

@section('content')
@if ($applications->isEmpty())
    <p class="text-center text-[var(--color-mist)] py-16 admin-card">まだ応募はありません。</p>
@else
    <div class="space-y-4">
        @foreach ($applications as $app)
            <div class="admin-card p-6 {{ $app->handled ? 'opacity-70' : '' }}">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="display text-lg">{{ $app->name }}</h3>
                            @if (! $app->handled)<span class="chip chip-new">未対応</span>@else<span class="chip chip-on">対応済</span>@endif
                        </div>
                        <p class="text-sm text-[var(--color-mist)] mt-1">
                            {{ $app->country }}
                            @if ($app->email) · <a href="mailto:{{ $app->email }}" class="hover:underline text-[var(--color-gold)]">{{ $app->email }}</a>@endif
                            @if ($app->interest) · {{ $app->interest }}@endif
                            · {{ strtoupper($app->locale) }}
                        </p>
                    </div>
                    <span class="text-xs text-[var(--color-mist)] font-[var(--font-label)]">{{ $app->created_at->isoFormat('YYYY.MM.DD HH:mm') }}</span>
                </div>

                @if ($app->message)
                    <p class="mt-4 text-[var(--color-sumi-soft)] leading-relaxed whitespace-pre-line border-l-2 border-[var(--color-gold-soft)] pl-4">{{ $app->message }}</p>
                @endif

                <div class="flex items-center gap-4 mt-5 pt-4 border-t border-[var(--color-line)]">
                    <form method="POST" action="{{ route('admin.applications.update', $app) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="handled" value="{{ $app->handled ? 0 : 1 }}">
                        <button class="text-sm text-[var(--color-gold)] hover:underline">{{ $app->handled ? '未対応に戻す' : '対応済にする' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.applications.destroy', $app) }}" onsubmit="return confirm('削除しますか？')">
                        @csrf @method('DELETE')
                        <button class="text-sm text-[var(--color-shu)] hover:underline">削除</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
