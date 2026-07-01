@extends('layouts.admin')

@section('title', '写真')
@section('eyebrow', 'Gallery')
@section('heading', '写真ギャラリー')

@section('content')

<form method="POST" enctype="multipart/form-data" action="{{ route('admin.photos.store') }}" class="admin-card p-6 md:p-8 mb-8 space-y-5">
    @csrf
    <div class="grid gap-6 sm:grid-cols-[1fr_auto] sm:items-end">
        <div class="space-y-2">
            <label class="field-label" for="photos">写真を選ぶ（複数可）</label>
            <input id="photos" name="photos[]" type="file" accept="image/*" multiple required
                   class="admin-input file:mr-3 file:border-0 file:bg-[var(--color-sumi)] file:text-[var(--color-paper)] file:px-3 file:py-1 file:rounded">
        </div>
        <button class="btn btn-gold">アップロード</button>
    </div>
    <x-admin.field name="album" label="アルバム名（任意）" placeholder="Los Angeles 2026" />
</form>

@if ($photos->isEmpty())
    <p class="text-center text-[var(--color-mist)] py-16 admin-card">まだ写真がありません。</p>
@else
    <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($photos as $photo)
            <div class="group relative img-frame aspect-square admin-card overflow-hidden">
                <img src="{{ media_url($photo->path) }}" alt="" class="h-full w-full object-cover">
                <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}"
                      class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('削除しますか？')">
                    @csrf @method('DELETE')
                    <button class="bg-[var(--color-shu)] text-white w-7 h-7 rounded-full text-sm leading-none">✕</button>
                </form>
            </div>
        @endforeach
    </div>
@endif

@endsection
