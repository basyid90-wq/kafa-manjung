{{-- Dual-box Rumi→Jawi field pair for RPH forms --}}
{{-- Expected vars: flabel (HTML string), rumiId, jawiId, jawiName, jawiValue, required, jawiRows --}}
@php
    $req   = $required ?? false;
    $jVal  = $jawiValue ?? '';
    $jRows = $jawiRows ?? 3;
@endphp
<div class="col-span-2 md:col-span-2">
    <label class="jawi-label text-gray-600 dark:text-gray-400">{!! $flabel !!}</label>
    {{-- Kotak 1: Rumi (tiada name — tidak dihantar ke backend) --}}
    <textarea id="{{ $rumiId }}"
              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 mb-1 resize-y"
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
              class="jawi-input w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 resize-y"
              rows="{{ $jRows }}"
              dir="rtl"
              @if($req) data-required-p1="1" @endif
    >{{ $jVal }}</textarea>
</div>
