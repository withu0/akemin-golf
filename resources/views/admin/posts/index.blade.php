@extends('layouts.admin')

@section('title', 'ゴルフと人生')
@section('eyebrow', 'Essays')
@section('heading', 'ゴルフと人生')

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-gold !py-2.5 !px-6">＋ 新規追加</a>
@endsection

@section('content')
<div class="admin-card overflow-hidden">
    @if ($posts->isEmpty())
        <p class="text-center text-[var(--color-mist)] py-16">まだ記事がありません。</p>
    @else
        <table class="w-full text-left">
            <thead class="border-b border-[var(--color-line)]">
                <tr>
                    <th class="admin-th px-5 py-3">タイトル</th>
                    <th class="admin-th px-5 py-3 hidden sm:table-cell">公開日</th>
                    <th class="admin-th px-5 py-3 hidden md:table-cell">分類</th>
                    <th class="admin-th px-5 py-3">公開</th>
                    <th class="admin-th px-5 py-3 text-right">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-line)]">
                @foreach ($posts as $p)
                    <tr class="hover:bg-[var(--color-washi)]/50">
                        <td class="px-5 py-3.5 font-[var(--font-serif)]">{{ $p->t('title') }}</td>
                        <td class="px-5 py-3.5 text-sm text-[var(--color-mist)] hidden sm:table-cell">{{ $p->published_at?->isoFormat('YYYY.MM.DD') }}</td>
                        <td class="px-5 py-3.5 text-sm text-[var(--color-mist)] hidden md:table-cell">{{ $p->category }}</td>
                        <td class="px-5 py-3.5"><span class="chip {{ $p->is_published ? 'chip-on' : 'chip-off' }}">{{ $p->is_published ? '公開' : '下書き' }}</span></td>
                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                            <a href="{{ route('admin.posts.edit', $p) }}" class="text-sm text-[var(--color-gold)] hover:underline">編集</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $p) }}" class="inline ml-3" onsubmit="return confirm('削除しますか？')">
                                @csrf @method('DELETE')
                                <button class="text-sm text-[var(--color-shu)] hover:underline">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
