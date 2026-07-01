@extends('layouts.admin')

@section('title', $post->exists ? '記事を編集' : '記事を追加')
@section('eyebrow', 'Essays')
@section('heading', $post->exists ? '記事を編集' : '記事を追加')

@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
      class="admin-card p-6 md:p-8 space-y-7 max-w-3xl">
    @csrf
    @if ($post->exists) @method('PUT') @endif

    <x-admin.translatable name="title" label="タイトル" :values="$post->title" required />
    <x-admin.translatable name="excerpt" label="リード文（抜粋）" type="textarea" :rows="2" :values="$post->excerpt" />
    <x-admin.translatable name="body" label="本文" type="textarea" :rows="8" :values="$post->body" />

    <div class="grid gap-6 sm:grid-cols-3">
        <x-admin.field name="category" label="分類" :value="$post->category ?? 'life'" placeholder="life" />
        <x-admin.field name="published_at" label="公開日" type="date" :value="optional($post->published_at)->format('Y-m-d')" />
        <x-admin.field name="sort" label="並び順" type="number" :value="$post->sort ?? 0" />
    </div>

    <div>
        <x-admin.field name="cover_image" label="カバー写真" type="file" />
        @if ($post->cover_image)<img src="{{ media_url($post->cover_image) }}" class="mt-3 h-24 rounded-lg object-cover border border-[var(--color-line)]">@endif
    </div>

    <x-admin.field name="slug" label="スラッグ（URL・空欄で自動生成）" :value="$post->slug" />

    <label class="flex items-center gap-3 text-sm">
        <input type="checkbox" name="is_published" value="1" class="accent-[var(--color-gold)]" @checked($post->is_published ?? true)>
        公開する
    </label>

    <div class="flex items-center gap-4 pt-2">
        <button class="btn btn-gold">保存する</button>
        <a href="{{ route('admin.posts.index') }}" class="link-arrow">キャンセル</a>
    </div>
</form>
@endsection
