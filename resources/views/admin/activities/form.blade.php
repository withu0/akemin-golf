@extends('layouts.admin')

@section('title', $activity->exists ? '活動を編集' : '活動を追加')
@section('eyebrow', 'Activities')
@section('heading', $activity->exists ? '活動を編集' : '活動を追加')

@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $activity->exists ? route('admin.activities.update', $activity) : route('admin.activities.store') }}"
      class="admin-card p-6 md:p-8 space-y-7 max-w-3xl">
    @csrf
    @if ($activity->exists) @method('PUT') @endif

    <x-admin.translatable name="title" label="タイトル" :values="$activity->title" required />
    <x-admin.translatable name="body" label="本文" type="textarea" :rows="5" :values="$activity->body" />

    <div class="grid gap-6 sm:grid-cols-2">
        <x-admin.field name="location" label="場所" :value="$activity->location" placeholder="Los Angeles, California" />
        <x-admin.field name="happened_on" label="日付" type="date" :value="$activity->happened_on?->format('Y-m-d')" />
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <x-admin.media-field name="cover_image" label="カバー写真" accept="image/*" kind="image" :path="$activity->cover_image" />
        <x-admin.media-field name="video" label="動画（ホバー再生）" accept="video/mp4,video/webm,video/quicktime" kind="video" :path="$activity->video" />
    </div>

    <x-admin.field name="sort" label="並び順（小さいほど先）" type="number" :value="$activity->sort ?? 0" />

    <label class="flex items-center gap-3 text-sm">
        <input type="checkbox" name="is_published" value="1" class="accent-[var(--color-gold)]" @checked($activity->is_published ?? true)>
        公開する
    </label>

    <div class="flex items-center gap-4 pt-2">
        <button class="btn btn-gold">保存する</button>
        <a href="{{ route('admin.activities.index') }}" class="link-arrow">キャンセル</a>
    </div>
</form>
@endsection
