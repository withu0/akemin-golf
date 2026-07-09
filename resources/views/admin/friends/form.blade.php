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
            <input
                type="text"
                id="country_search"
                class="admin-input"
                placeholder="国名で検索（例: Fiji）"
                autocomplete="off"
            >
            <div class="flex items-center gap-3">
                <select id="country_code" name="country_code" class="admin-input flex-1" size="1">
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
        <x-admin.media-field name="photo" label="写真" accept="image/*" kind="image" :path="$friend->photo" :square="true" />
        <x-admin.media-field name="video" label="動画（ホバー再生）" accept="video/mp4,video/webm,video/quicktime" kind="video" :path="$friend->video" />
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
    const countrySelect = document.getElementById('country_code');
    const countrySearch = document.getElementById('country_search');
    const countryPreview = document.getElementById('country_flag_preview');

    function updateFlagPreview(code) {
        if (!countryPreview) return;
        code = (code || '').toLowerCase();
        if (code.match(/^[a-z]{2}$/)) {
            countryPreview.src = 'https://flagcdn.com/w80/' + code + '.png';
            countryPreview.classList.remove('hidden');
        } else {
            countryPreview.classList.add('hidden');
        }
    }

    countrySelect?.addEventListener('change', function () {
        updateFlagPreview(this.value);
    });

    countrySearch?.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        let firstMatch = null;
        let visibleCount = 0;

        Array.from(countrySelect.options).forEach((option) => {
            if (option.value === '') {
                option.hidden = false;
                return;
            }

            const matches = !query || option.text.toLowerCase().includes(query);
            option.hidden = !matches;

            if (matches) {
                visibleCount++;
                if (!firstMatch) {
                    firstMatch = option;
                }
            }
        });

        countrySelect.size = query ? Math.min(10, visibleCount + 1) : 1;

        if (query && firstMatch) {
            countrySelect.value = firstMatch.value;
            updateFlagPreview(firstMatch.value);
        }
    });

    countrySearch?.addEventListener('blur', function () {
        setTimeout(() => {
            countrySelect.size = 1;
        }, 150);
    });
</script>
@endsection
