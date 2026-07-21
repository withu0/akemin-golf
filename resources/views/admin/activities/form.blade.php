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

    <div class="space-y-4">
        <div>
            <p class="field-label mb-2">メディアギャラリー</p>
            <p class="text-sm text-[var(--color-mist)] mb-4">画像・動画を複数アップロードできます。カバーに使うものを選択してください。画像は1ファイル25MB、動画は1ファイル100MBまで。</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <label class="field-label" for="media_images">画像を追加（複数可）</label>
                <input id="media_images" name="media_images[]" type="file" accept="image/*" multiple
                       class="admin-input file:mr-3 file:border-0 file:bg-[var(--color-sumi)] file:text-[var(--color-paper)] file:px-3 file:py-1 file:rounded">
                @error('media_images') <p class="text-sm text-[var(--color-shu)] mt-1">{{ $message }}</p> @enderror
                @error('media_images.*') <p class="text-sm text-[var(--color-shu)] mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-2">
                <label class="field-label" for="media_videos">動画を追加（複数可）</label>
                <input id="media_videos" name="media_videos[]" type="file" accept="video/mp4,video/webm,video/quicktime" multiple
                       class="admin-input file:mr-3 file:border-0 file:bg-[var(--color-sumi)] file:text-[var(--color-paper)] file:px-3 file:py-1 file:rounded">
                @error('media_videos') <p class="text-sm text-[var(--color-shu)] mt-1">{{ $message }}</p> @enderror
                @error('media_videos.*') <p class="text-sm text-[var(--color-shu)] mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        @php $mediaItems = $activity->exists ? $activity->media : collect(); @endphp
        @if ($mediaItems->isNotEmpty())
            <div class="grid gap-4 grid-cols-2 sm:grid-cols-3">
                @foreach ($mediaItems as $media)
                    <div class="relative img-frame aspect-square overflow-hidden border border-[var(--color-line)]">
                        @if ($media->isImage())
                            <img src="{{ media_url($media->path) }}" alt="" class="h-full w-full object-cover">
                        @else
                            <video src="{{ media_url($media->path) }}" class="h-full w-full object-cover" muted preload="metadata"></video>
                            <span class="absolute top-2 left-2 bg-[var(--color-sumi)]/80 text-[var(--color-paper)] text-[10px] tracking-wider uppercase px-1.5 py-0.5">Video</span>
                        @endif

                        <div class="absolute inset-x-0 bottom-0 bg-[var(--color-sumi)]/75 text-[var(--color-paper)] p-2 space-y-1.5">
                            <label class="flex items-center gap-2 text-xs cursor-pointer">
                                <input type="radio" name="cover_media_id" value="{{ $media->id }}"
                                       class="accent-[var(--color-gold)]"
                                       @checked((int) $activity->cover_media_id === (int) $media->id)>
                                カバーに設定
                            </label>
                            <label class="flex items-center gap-2 text-xs cursor-pointer text-[var(--color-shu)]">
                                <input type="checkbox" name="delete_media[]" value="{{ $media->id }}" class="accent-[var(--color-shu)]">
                                削除
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('cover_media_id') <p class="text-sm text-[var(--color-shu)]">{{ $message }}</p> @enderror
        @endif
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
