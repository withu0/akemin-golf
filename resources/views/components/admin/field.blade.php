@props(['name', 'label', 'value' => null, 'type' => 'text', 'required' => false, 'hint' => null, 'accept' => null])

<div class="space-y-2">
    <label class="field-label" for="{{ $name }}">{{ $label }} @if ($required)<span class="text-[var(--color-shu)]">*</span>@endif</label>
    @if ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" {{ $attributes }} class="admin-input" @if($required) required @endif>{{ old($name, $value) }}</textarea>
    @elseif ($type === 'file')
        <input id="{{ $name }}" name="{{ $name }}" type="file" @if($accept) accept="{{ $accept }}" @else accept="image/*" @endif {{ $attributes }} class="admin-input file:mr-3 file:border-0 file:bg-[var(--color-sumi)] file:text-[var(--color-paper)] file:px-3 file:py-1 file:rounded">
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" {{ $attributes }} class="admin-input" @if($required) required @endif>
    @endif
    @if ($hint)<p class="text-xs text-[var(--color-mist)]">{{ $hint }}</p>@endif
</div>
