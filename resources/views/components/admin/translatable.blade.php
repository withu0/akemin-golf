@props(['name', 'label', 'values' => [], 'type' => 'input', 'rows' => 3, 'required' => false])

<div class="space-y-2.5">
    <label class="field-label">{{ $label }} @if ($required)<span class="text-[var(--color-shu)]">*</span>@endif</label>
    @foreach (['ja' => '日本語', 'en' => 'EN', 'zh' => '中文'] as $code => $lname)
        @php($val = old("$name.$code", data_get($values, $code)))
        <div class="flex items-start gap-3">
            <span class="mt-2.5 w-9 shrink-0 text-[0.6rem] uppercase tracking-widest text-[var(--color-mist)] font-[var(--font-label)]">{{ $lname }}</span>
            @if ($type === 'textarea')
                <textarea name="{{ $name }}[{{ $code }}]" rows="{{ $rows }}" class="admin-input" @if($required && $code === 'ja') required @endif>{{ $val }}</textarea>
            @else
                <input name="{{ $name }}[{{ $code }}]" value="{{ $val }}" class="admin-input" @if($required && $code === 'ja') required @endif>
            @endif
        </div>
    @endforeach
</div>
