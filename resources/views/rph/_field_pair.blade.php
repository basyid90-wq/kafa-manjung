{{-- Dual-box Rumi→Jawi field pair for RPH forms --}}
{{-- Expected vars: flabel (HTML string), rumiId, jawiId, jawiName, jawiValue, required, jawiRows --}}
@php
    $req   = $required ?? false;
    $jVal  = $jawiValue ?? '';
    $jRows = $jawiRows ?? 3;
@endphp
<div class="col-12">
    <div class="rbt-form-group">
        <label class="jawi-label">{!! $flabel !!}</label>
        {{-- Kotak 1: Rumi (tiada name — tidak dihantar ke backend) --}}
        <textarea id="{{ $rumiId }}"
                  class="form-control rph-rumi-box"
                  rows="2"
                  placeholder="Taip Rumi di sini..."></textarea>
        <div class="rph-convert-bar">
            <button type="button"
                    class="btn-tukar-jawi"
                    onclick="tukarKeJawi('{{ $rumiId }}', '{{ $jawiId }}')">
                ↓ Tukar ke Jawi
            </button>
        </div>
        {{-- Kotak 2: Jawi (memegang name untuk submit ke Controller) --}}
        <textarea id="{{ $jawiId }}"
                  name="{{ $jawiName }}"
                  class="jawi-input form-control"
                  rows="{{ $jRows }}"
                  dir="rtl"
                  @if($req) data-required-p1="1" @endif
        >{{ $jVal }}</textarea>
    </div>
</div>
