@extends('layouts.admin')

@section('title', $friend->exists ? 'ゴルフ友を編集' : 'ゴルフ友を追加')
@section('eyebrow', 'Golf Friends')
@section('heading', $friend->exists ? 'ゴルフ友を編集' : 'ゴルフ友を追加')

@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $friend->exists ? route('admin.friends.update', $friend) : route('admin.friends.store') }}"
      class="admin-card p-6 md:p-8 space-y-7 max-w-3xl">
    @csrf
    @if ($friend->exists) @method('PUT') @endif

    <div class="grid gap-6 sm:grid-cols-2">
        <x-admin.field name="name" label="名前" :value="$friend->name" required />
        <x-admin.field name="country" label="国・地域" :value="$friend->country" placeholder="Singapore" />
    </div>
    <div class="grid gap-6 sm:grid-cols-2">
        <x-admin.field name="flag" label="国旗（絵文字）" :value="$friend->flag" placeholder="🇸🇬" />
        <x-admin.field name="instagram" label="Instagram（@なし）" :value="$friend->instagram" placeholder="aki_golf30" />
    </div>

    <x-admin.translatable name="message" label="ひとこと" type="textarea" :rows="3" :values="$friend->message" />

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <x-admin.field name="photo" label="写真" type="file" />
            @if ($friend->photo)<img src="{{ media_url($friend->photo) }}" class="mt-3 h-24 w-24 rounded-lg object-cover border border-[var(--color-line)]">@endif
        </div>
        <x-admin.field name="sort" label="並び順" type="number" :value="$friend->sort ?? 0" />
    </div>

    <label class="flex items-center gap-3 text-sm">
        <input type="checkbox" name="is_published" value="1" class="accent-[var(--color-gold)]" @checked($friend->is_published ?? true)>
        公開する
    </label>

    <div class="flex items-center gap-4 pt-2">
        <button class="btn btn-gold">保存する</button>
        <a href="{{ route('admin.friends.index') }}" class="link-arrow">キャンセル</a>
    </div>
</form>
@endsection
