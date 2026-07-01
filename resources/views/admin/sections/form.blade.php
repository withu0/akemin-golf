@extends('layouts.admin')

@section('title', 'ページ内容を編集')
@section('eyebrow', 'Pages')
@section('heading', $section->key.' を編集')

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.sections.update', $section) }}"
      class="admin-card p-6 md:p-8 space-y-7 max-w-3xl">
    @csrf @method('PUT')

    <x-admin.field name="eyebrow" label="英語ラベル（小見出し）" :value="$section->eyebrow" placeholder="About" />
    <x-admin.translatable name="title" label="見出し（HTML可・<br>で改行）" :values="$section->title" />
    <x-admin.translatable name="lead" label="リード文" type="textarea" :rows="2" :values="$section->lead" />
    <x-admin.translatable name="body" label="本文（空行で段落／改行はそのまま反映）" type="textarea" :rows="8" :values="$section->body" />

    <div>
        <x-admin.field name="image" label="画像" type="file" />
        @if ($section->image)<img src="{{ media_url($section->image) }}" class="mt-3 h-28 rounded-lg object-cover border border-[var(--color-line)]">@endif
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button class="btn btn-gold">保存する</button>
        <a href="{{ route('admin.sections.index') }}" class="link-arrow">キャンセル</a>
    </div>
</form>
@endsection
