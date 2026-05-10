{{--
    Flowbite-style Phone Input — Malaysia (+60) fixed prefix
    Usage: <x-phone-input name="father_phone" :value="old('father_phone')" />
           <x-phone-input name="father_phone" :value="old('father_phone', $student->father_phone)" />
--}}
@props(['name', 'value' => '', 'placeholder' => 'Contoh: 0123456789', 'required' => false, 'id' => null])

<style>
    .ph-wrapper {
        display:flex;
        border:1px solid #d1d5db;
        border-radius:0.5rem;
        overflow:hidden;
    }
    .dark .ph-wrapper { border-color:#4b5563; }
    .ph-prefix {
        display:flex;
        align-items:center;
        gap:6px;
        padding:8px 12px;
        background:#f9fafb;
        border-right:1px solid #d1d5db;
        white-space:nowrap;
        flex-shrink:0;
        font-size:0.875rem;
        font-weight:600;
        color:#374151;
        user-select:none;
    }
    .dark .ph-prefix { background:#374151; border-color:#4b5563; color:#d1d5db; }
    .ph-input {
        flex:1;
        padding:8px 12px;
        font-size:0.875rem;
        border:none;
        outline:none;
        min-width:0;
        background:white;
        color:#111827;
    }
    .dark .ph-input { background:#374151; color:white; }
    .ph-input::placeholder { color:#9ca3af; }
    .ph-wrapper:focus-within {
        box-shadow:0 0 0 2px rgba(59,130,246,0.5);
        border-color:#3b82f6;
    }
</style>

<div class="ph-wrapper">
    <div class="ph-prefix">
        <span style="font-size:1.1em;">🇲🇾</span>
        <span>+60</span>
    </div>
    <input type="tel"
           name="{{ $name }}"
           id="{{ $id ?? $name }}"
           value="{{ $value }}"
           placeholder="{{ $placeholder }}"
           {{ $required ? 'required' : '' }}
           class="ph-input">
</div>
