@extends('layouts.admin')

@section('title', 'ゴルフ友')
@section('eyebrow', 'Golf Friends')
@section('heading', 'ゴルフ友')

@section('actions')
    <a href="{{ route('admin.friends.create') }}" class="btn btn-gold !py-2.5 !px-6">＋ 新規追加</a>
@endsection

@section('content')
<div class="admin-card overflow-hidden">
    @if ($friends->isEmpty())
        <p class="text-center text-[var(--color-mist)] py-16">まだ登録がありません。</p>
    @else
        <table class="w-full text-left">
            <thead class="border-b border-[var(--color-line)]">
                <tr>
                    <th class="admin-th px-5 py-3">名前</th>
                    <th class="admin-th px-5 py-3 hidden sm:table-cell">国</th>
                    <th class="admin-th px-5 py-3 hidden md:table-cell">Instagram</th>
                    <th class="admin-th px-5 py-3">公開</th>
                    <th class="admin-th px-5 py-3 text-right">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-line)]">
                @foreach ($friends as $f)
                    <tr class="hover:bg-[var(--color-washi)]/50">
                        <td class="px-5 py-3.5 font-[var(--font-serif)] flex items-center gap-3">
                            @if ($f->photo)<img src="{{ media_url($f->photo) }}" class="h-9 w-9 rounded-full object-cover">@endif
                            {{ $f->name }}
                        </td>
                        <td class="px-5 py-3.5 text-sm text-[var(--color-mist)] hidden sm:table-cell">{{ $f->flag }} {{ $f->country }}</td>
                        <td class="px-5 py-3.5 text-sm text-[var(--color-mist)] hidden md:table-cell">{{ $f->instagram }}</td>
                        <td class="px-5 py-3.5"><span class="chip {{ $f->is_published ? 'chip-on' : 'chip-off' }}">{{ $f->is_published ? '公開' : '非公開' }}</span></td>
                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                            <a href="{{ route('admin.friends.edit', $f) }}" class="text-sm text-[var(--color-gold)] hover:underline">編集</a>
                            <form method="POST" action="{{ route('admin.friends.destroy', $f) }}" class="inline ml-3" onsubmit="return confirm('削除しますか？')">
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
