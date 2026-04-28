{{--
    Floating Jawi Keyboard — Global Component
    Usage: <x-jawi-keyboard /> (place before @endsection in views that need Jawi input)
    Controlled by: public/assets/js/jawi-keyboard.js (loaded globally in layout)
    Smart focus: tracks last focused element with class .jawi-input
--}}

{{-- ── Wrapper: fixed, centered at screen bottom ── --}}
<div id="jawi-keyboard-wrapper"
     style="position:fixed; bottom:0; left:50%; transform:translateX(-50%);
            z-index:99990; width:min(720px, 100vw); pointer-events:none;">

    {{-- Toggle pill button --}}
    <div class="text-center" style="pointer-events:auto;">
        <button id="jawi-keyboard-toggle"
                type="button"
                aria-expanded="false"
                title="Buka / Tutup Keyboard Jawi"
                style="background:linear-gradient(135deg,#1a1a2e 0%,#6c63ff 100%);
                       color:white; border:none; border-radius:20px 20px 0 0;
                       padding:6px 24px; font-size:0.78em; font-weight:600;
                       cursor:pointer; letter-spacing:.3px;
                       box-shadow:0 -3px 12px rgba(108,99,255,.4);
                       transition:opacity .2s;">
            <i class="feather-grid" style="font-size:.85em; vertical-align:middle;"></i>
            ⌨ Keyboard Jawi
        </button>
    </div>

    {{-- Keyboard panel (hidden by default) --}}
    <div id="jawi-keyboard-panel"
         class="d-none bg-white shadow-lg p-3"
         style="pointer-events:auto;
                border-radius:16px 16px 0 0;
                border-top:3px solid #6c63ff;
                border-left:1px solid #e8e8f0;
                border-right:1px solid #e8e8f0;">

        {{-- Key grid: 10 columns --}}
        @php
            $row1 = ['ا','ب','ت','ث','ج','ح','خ','د','ذ','ر'];
            $row2 = ['ز','س','ش','ص','ض','ط','ظ','ع','غ','ف'];
            $row3 = ['ق','ك','ل','م','ن','و','ه','ء','ي','ى'];
            $row4 = ['ة','چ','ڠ','ڤ','ݢ','ڽ','ۏ']; // 7 letters + Space(2) + BkSp(1) = 10
        @endphp

        <div style="display:grid; grid-template-columns:repeat(10,1fr); gap:4px;">

            @foreach(array_merge($row1, $row2, $row3, $row4) as $char)
            <button type="button"
                    class="btn btn-outline-secondary btn-sm jk-key"
                    data-char="{{ $char }}"
                    style="font-family:'Lateef','Scheherazade New',serif;
                           font-size:1.25em; padding:5px 2px; min-width:0;
                           line-height:1.4; border-color:#dde0f0;">
                {{ $char }}
            </button>
            @endforeach

            {{-- Ruang — spans 2 columns --}}
            <button type="button"
                    class="btn btn-outline-secondary btn-sm jk-key"
                    data-char=" "
                    style="grid-column:span 2; font-size:0.75em; border-color:#dde0f0;">
                ␣ Ruang
            </button>

            {{-- Backspace — spans 1 column --}}
            <button type="button"
                    id="jk-backspace"
                    class="btn btn-outline-danger btn-sm"
                    style="font-size:0.75em;">
                ⌫
            </button>

        </div>

        <p class="text-center mt-2 mb-0 text-muted"
           style="font-size:0.7em;">
            Klik pada kotak input Jawi dahulu, kemudian pilih huruf di atas.
        </p>
    </div>
</div>

{{-- Styles — scoped to keyboard & jawi inputs --}}
<style>
    @font-face {
        font-family: 'Lateef';
        src: url('/fonts/Lateef-Regular.ttf') format('truetype');
    }
    /* Applied to every Jawi input on this page */
    .jawi-input {
        font-family: 'Lateef', 'Scheherazade New', serif !important;
        font-size: 1.2em !important;
        direction: rtl !important;
        text-align: right !important;
        line-height: 2 !important;
    }
    /* Rumi helper box (no name attr — not submitted) */
    .jawi-rumi-helper {
        background: #f8f9fa;
        color: #444;
        font-size: 0.9em;
    }
    /* Tukar ke Jawi button */
    .btn-tukar-jawi {
        background: transparent;
        border: 1px solid #6c63ff;
        color: #6c63ff;
        border-radius: 4px;
        padding: 3px 14px;
        font-size: 0.78em;
        cursor: pointer;
        transition: background .2s, color .2s;
    }
    .btn-tukar-jawi:hover { background: #6c63ff; color: white; }
    /* Toggle button hover */
    #jawi-keyboard-toggle:hover { opacity: .88; }
    /* Active jawi-input highlight */
    .jawi-input:focus {
        border-color: #6c63ff !important;
        box-shadow: 0 0 0 3px rgba(108,99,255,.18) !important;
    }
    /* key hover */
    .jk-key:hover {
        background: #6c63ff;
        border-color: #6c63ff;
        color: white;
    }
</style>
