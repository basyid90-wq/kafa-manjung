{{-- Dual-box Rumi→Jawi field pair for RPH forms --}}
{{-- Expected vars: flabel (HTML string), rumiId, jawiId, jawiName, jawiValue, required, jawiRows --}}
@php
    $req   = $required ?? false;
    $jVal  = $jawiValue ?? '';
    $jRows = $jawiRows ?? 3;
@endphp
<div class="col-span-2 md:col-span-2">
    <label class="jawi-label text-gray-600">{!! $flabel !!}</label>
    {{-- Kotak 1: Rumi (tiada name — tidak dihantar ke backend) --}}
    <textarea id="{{ $rumiId }}"
              class="ek-input mb-1 resize-y"
              rows="2"
              placeholder="Taip Rumi di sini..."></textarea>
    <div class="flex justify-end mb-1">
        <button type="button"
                class="text-xs px-3 py-1 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-lg transition-colors border border-amber-300"
                onclick="tukarKeJawi('{{ $rumiId }}', '{{ $jawiId }}')">
            ↓ Tukar ke Jawi
        </button>
    </div>
    {{-- Kotak 2: Jawi (memegang name untuk submit ke Controller) --}}
    <textarea id="{{ $jawiId }}"
              name="{{ $jawiName }}"
              class="ek-input jawi-input resize-y"
              rows="{{ $jRows }}"
              dir="rtl"
              @if($req) data-required-p1="1" @endif
    >{{ $jVal }}</textarea>
</div>
