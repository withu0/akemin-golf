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
        <div class="space-y-2">
            <label class="field-label" for="country_code">国旗</label>
            <div class="flex items-center gap-3">
                <select id="country_code" name="country_code" class="admin-input flex-1">
                    <option value="">— 選択 —</option>
                    @foreach ($countries as $code => $label)
                        <option value="{{ $code }}" @selected(old('country_code', $friend->country_code) === $code)>{{ $label }}</option>
                    @endforeach
                </select>
                <img
                    id="country_flag_preview"
                    src="{{ flag_url(old('country_code', $friend->country_code)) }}"
                    alt=""
                    class="h-10 w-10 rounded-full object-cover ring-2 ring-[var(--color-line)] {{ flag_url(old('country_code', $friend->country_code)) ? '' : 'hidden' }}"
                >
            </div>
        </div>
        <x-admin.field name="instagram" label="Instagram（@なし）" :value="$friend->instagram" placeholder="aki_golf30" />
    </div>

    <x-admin.translatable name="message" label="ひとこと" type="textarea" :rows="3" :values="$friend->message" />

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <x-admin.field name="photo" label="写真" type="file" accept="image/*" />
            @if ($friend->photo)<img src="{{ media_url($friend->photo) }}" class="mt-3 h-24 w-24 rounded-lg object-cover border border-[var(--color-line)]">@endif
        </div>
        <div>
            <x-admin.field name="video" label="動画（ホバー再生）" type="file" accept="video/mp4,video/webm,video/quicktime" />
            @if ($friend->video)
                <video src="{{ media_url($friend->video) }}" class="mt-3 h-24 w-40 rounded-lg object-cover border border-[var(--color-line)]" muted playsinline preload="metadata"></video>
            @endif
        </div>
    </div>

    <x-admin.field name="sort" label="並び順" type="number" :value="$friend->sort ?? 0" />

    <label class="flex items-center gap-3 text-sm">
        <input type="checkbox" name="is_published" value="1" class="accent-[var(--color-gold)]" @checked($friend->is_published ?? true)>
        公開する
    </label>

    <div class="flex items-center gap-4 pt-2">
        <button class="btn btn-gold">保存する</button>
        <a href="{{ route('admin.friends.index') }}" class="link-arrow">キャンセル</a>
    </div>
</form>

<script>
    document.getElementById('country_code')?.addEventListener('change', function () {
        const preview = document.getElementById('country_flag_preview');
        if (!preview) return;
        const code = this.value.toLowerCase();
        if (code.match(/^[a-z]{2}$/)) {
            preview.src = 'https://flagcdn.com/w80/' + code + '.png';
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    });
</script>
@endsection
