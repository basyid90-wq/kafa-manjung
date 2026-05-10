{{--
    Floating Jawi Keyboard — Tailwind CSS version
    Usage: <x-jawi-keyboard /> before @endsection
    Focus a .jawi-input textarea first, then tap keys.
--}}
<style>
    @font-face {
        font-family: 'Lateef';
        src: url('/fonts/Lateef-Regular.ttf') format('truetype');
    }
    .jawi-input {
        font-family: 'Lateef', serif !important;
        font-size: 1.2em !important;
        direction: rtl !important;
        text-align: right !important;
        line-height: 2 !important;
    }
    .jawi-input:focus {
        border-color: #6c63ff !important;
        box-shadow: 0 0 0 3px rgba(108,99,255,.18) !important;
    }
    .jk-key:hover {
        background: #6c63ff !important;
        border-color: #6c63ff !important;
        color: white !important;
    }
    .jawi-rumi-helper {
        background: #f8f9fa;
        color: #444;
        font-size: 0.9em;
    }
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
</style>

<div id="jawi-keyboard-wrapper"
     style="position:fixed; bottom:0; left:50%; transform:translateX(-50%);
            z-index:99990; width:min(720px,100vw); pointer-events:none;">

    {{-- Toggle pill --}}
    <div style="text-align:center; pointer-events:auto;">
        <button id="jawi-keyboard-toggle" type="button"
                style="background:linear-gradient(135deg,#1a1a2e 0%,#6c63ff 100%);
                       color:white; border:none; border-radius:20px 20px 0 0;
                       padding:6px 24px; font-size:0.78em; font-weight:600;
                       cursor:pointer; letter-spacing:.3px;
                       box-shadow:0 -3px 12px rgba(108,99,255,.4);">
            ⌨ Keyboard Jawi
        </button>
    </div>

    {{-- Keyboard panel — hidden by default --}}
    <div id="jawi-keyboard-panel"
         style="display:none; pointer-events:auto;
                background:#1e293b; border-radius:16px 16px 0 0;
                border-top:3px solid #6c63ff;
                border-left:1px solid #334155;
                border-right:1px solid #334155;
                padding:12px;">

        @php
            $rows = [
                ['ا','ب','ت','ث','ج','ح','خ','د','ذ','ر'],
                ['ز','س','ش','ص','ض','ط','ظ','ع','غ','ف'],
                ['ق','ك','ل','م','ن','و','ه','ء','ي','ى'],
                ['ة','چ','ڠ','ڤ','ݢ','ڽ','ۏ'],
            ];
        @endphp

        <div style="display:grid; grid-template-columns:repeat(10,1fr); gap:4px;">
            @foreach(array_merge(...$rows) as $char)
            <button type="button" class="jk-key"
                    data-char="{{ $char }}"
                    style="font-family:'Lateef',serif; font-size:1.25em;
                           padding:6px 2px; min-width:0; line-height:1.4;
                           background:#0f172a; color:#e2e8f0;
                           border:1px solid #475569; border-radius:6px;
                           cursor:pointer; transition:background .15s;">
                {{ $char }}
            </button>
            @endforeach

            {{-- Space --}}
            <button type="button" class="jk-key" data-char=" "
                    style="grid-column:span 2; font-size:0.75em;
                           background:#0f172a; color:#e2e8f0;
                           border:1px solid #475569; border-radius:6px;
                           padding:6px 2px; cursor:pointer; transition:background .15s;">
                ␣ Ruang
            </button>

            {{-- Backspace --}}
            <button type="button" id="jk-backspace"
                    style="font-size:0.85em;
                           background:#7f1d1d; color:#fca5a5;
                           border:1px solid #991b1b; border-radius:6px;
                           padding:6px 2px; cursor:pointer; transition:background .15s;"
                    onmouseover="this.style.background='#991b1b'"
                    onmouseout="this.style.background='#7f1d1d'">
                ⌫
            </button>
        </div>

        <p style="text-align:center; margin-top:8px; margin-bottom:0;
                  font-size:0.7em; color:#94a3b8;">
            Klik pada kotak input Jawi dahulu, kemudian pilih huruf di atas.
        </p>
    </div>
</div>

<script>
(function() {
    var toggle  = document.getElementById('jawi-keyboard-toggle');
    var panel   = document.getElementById('jawi-keyboard-panel');
    var activeInput = null;

    // Track focused jawi-input
    document.addEventListener('focusin', function(e) {
        if (e.target && e.target.classList.contains('jawi-input')) {
            activeInput = e.target;
        }
    });

    // Toggle panel
    toggle.addEventListener('click', function() {
        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
    });

    // Insert character
    document.querySelectorAll('.jk-key').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!activeInput) return;
            var char  = this.getAttribute('data-char');
            var start = activeInput.selectionStart;
            var end   = activeInput.selectionEnd;
            var val   = activeInput.value;
            activeInput.value = val.substring(0, start) + char + val.substring(end);
            activeInput.selectionStart = activeInput.selectionEnd = start + char.length;
            activeInput.dispatchEvent(new Event('input'));
        });
    });

    // Backspace
    document.getElementById('jk-backspace').addEventListener('click', function() {
        if (!activeInput) return;
        var start = activeInput.selectionStart;
        var end   = activeInput.selectionEnd;
        if (start === end && start > 0) {
            activeInput.value = activeInput.value.substring(0, start - 1) + activeInput.value.substring(end);
            activeInput.selectionStart = activeInput.selectionEnd = start - 1;
        } else {
            activeInput.value = activeInput.value.substring(0, start) + activeInput.value.substring(end);
            activeInput.selectionStart = activeInput.selectionEnd = start;
        }
        activeInput.dispatchEvent(new Event('input'));
    });
})();
</script>
