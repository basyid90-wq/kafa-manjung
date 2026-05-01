<!DOCTYPE html>
<html lang="en">

<x-head/>

<body class="<?php echo (isset($bodyClass) ?  $bodyClass   : 'rbt-header-sticky')?>">


    <?php 

        if (!isset($switcher)) {
            ?>
            <x-switcher/>
            <?php
        }
    ?>

    <?php 
        if (!isset($header)) {
            ?>
            <x-header/>
            <?php
        }
    ?>

    {{-- Global Dashboard Carousel Removed --}}

    <style>
        /* Global Spacing Adjustments */
        /* Global Spacing & Background Adjustments */
        body {
            background-color: #f8f9fa !important;
        }
        .rbt-section-overlayping-top {
            margin-top: 0 !important;
            padding-top: 50px !important;
        }
        .rbt-dashboard-area {
            padding-top: 50px !important;
        }
        @media (max-width: 768px) {
            .rbt-section-overlayping-top,
            .rbt-dashboard-area {
                padding-top: 30px !important;
            }
        }
        /* Disable global smooth scroll to prevent jarring jumps on load */
        html {
            scroll-behavior: auto !important;
        }
        /* === STANDARDIZE ALL FORM DROPDOWNS (bootstrap-select) === */
        /* Match text input: height 50px, same border, padding, font */
        .rbt-form-group .bootstrap-select {
            width: 100% !important;
            display: block !important;
        }
        .bootstrap-select > .dropdown-toggle {
            width: 100% !important;
            height: 50px !important;
            padding: 10px 20px !important;
            background-color: transparent !important;
            border: var(--border-width) solid var(--color-border) !important;
            border-radius: var(--radius) !important;
            font-size: 16px !important;
            font-weight: 400 !important;
            color: var(--color-body) !important;
            text-align: left !important;
            line-height: 28px !important;
            box-shadow: none !important;
            transition: border-color 0.3s !important;
        }
        /* Focus state — thin primary border, no blue glow */
        .rbt-form-group .bootstrap-select > .dropdown-toggle:focus,
        .rbt-form-group .bootstrap-select > .dropdown-toggle:focus-visible,
        .rbt-form-group .bootstrap-select.show > .dropdown-toggle {
            border-color: var(--color-primary) !important;
            outline: none !important;
            box-shadow: none !important;
        }
        .rbt-form-group .bootstrap-select > .dropdown-toggle .filter-option {
            line-height: 28px !important;
        }
        /* Dropdown menu items — match input font size */
        .bootstrap-select .dropdown-menu li a,
        .bootstrap-select .dropdown-menu .dropdown-item {
            font-size: 16px !important;
            padding: 10px 20px !important;
        }
        /* Attendance table compact selects (inside <td>, not .rbt-form-group) */
        td .bootstrap-select {
            width: 100% !important;
            min-width: 140px;
        }
        td .bootstrap-select > .dropdown-toggle {
            width: 100% !important;
            height: 40px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            font-weight: 400 !important;
            color: var(--color-body) !important;
            text-align: left !important;
            background-color: transparent !important;
            border: 1px solid var(--color-border) !important;
            border-radius: var(--radius) !important;
            box-shadow: none !important;
            line-height: 26px !important;
        }
        td .bootstrap-select > .dropdown-toggle:focus,
        td .bootstrap-select > .dropdown-toggle:focus-visible {
            box-shadow: none !important;
            border-color: var(--color-primary) !important;
            outline: none !important;
        }
        td .bootstrap-select .dropdown-menu li a {
            font-size: 14px !important;
            padding: 6px 12px !important;
        }
    </style>

    @yield('content')

    <?php 

        if (isset($topToBottom) && $topToBottom === 'true') {
            ?>
            <x-topToBottom />
            <?php
        }
    ?>

    <?php 

        if (isset($footer) && $footer === 'true') {
            ?>
            <x-footer />
            <?php
        }
    ?>
    

    <x-script/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
    <script src="{{ asset('assets/js/jawi-keyboard.js') }}"></script>
    @stack('scripts')

    {{-- PDF Viewer Overlay — PDF.js canvas renderer (IDM-proof, no iframe) --}}
    <div id="rph-pdf-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:99998; background:#333;">
        {{-- Header bar --}}
        <div style="position:absolute; top:0; left:0; right:0; height:48px; background:#1a1a2e; color:white; display:flex; justify-content:space-between; align-items:center; padding:0 18px; gap:10px; z-index:2;">
            <span style="font-weight:600; font-size:0.95em;">
                <i class="feather-file-text" style="margin-right:6px;"></i>RPH — Paparan PDF
            </span>
            <div style="display:flex; gap:8px; align-items:center;">
                <a id="rph-pdf-download-link" href="#" download style="color:#aaa; font-size:0.82em; text-decoration:none; padding:4px 12px; border:1px solid #555; border-radius:4px; white-space:nowrap;">
                    ⬇ Simpan
                </a>
                <button onclick="closePdfViewer()" style="background:#dc3545; color:white; border:none; padding:5px 16px; border-radius:4px; cursor:pointer; font-size:0.88em;">
                    ✕ Tutup
                </button>
            </div>
        </div>
        {{-- Canvas container — PDF.js renders pages here --}}
        <div id="rph-pdf-container" style="position:absolute; top:48px; left:0; right:0; bottom:0; overflow-y:auto; background:#525659; display:flex; flex-direction:column; align-items:center; padding:20px 0; gap:12px;">
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        // Persistence logic for Sidebar Scroll
        (function() {
            const sidebar = document.querySelector('.rbt-default-sidebar');
            if (!sidebar) return;

            const scrollPos = sessionStorage.getItem('sidebarScrollPos');
            if (scrollPos) {
                sidebar.scrollTop = scrollPos;
            }

            document.querySelectorAll('.dashboard-mainmenu a, .rbt-default-sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    sessionStorage.setItem('sidebarScrollPos', sidebar.scrollTop);
                });
            });
        })();

        // SweetAlert2 Success Popup (global — no need for per-page session alerts)
        @if(session('success'))
            Swal.fire({
                title: 'Berjaya!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#6e41ff',
                confirmButtonText: 'Tutup',
                timer: 4000,
                timerProgressBar: true
            });
        @endif

        // SweetAlert2 Error Popup
        @if(session('error'))
            Swal.fire({
                title: 'Ralat!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Tutup'
            });
        @endif

        // Global SweetAlert2 Delete Confirmation Handler
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-delete-form]').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var itemName = form.getAttribute('data-name') || 'rekod ini';
                    Swal.fire({
                        title: 'Pengesahan Padam',
                        html: 'Adakah anda pasti mahu memadam <strong>' + itemName + '</strong>?<br><small style="color:#999;">Tindakan ini tidak boleh dikembalikan.</small>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Padam!',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        // Suppress auto-scroll to top on load
        if (window.history.scrollRestoration) {
            window.history.scrollRestoration = 'manual';
        }

        // PDF.js worker — must be set before any getDocument() call
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        }

        var _pdfBlobUrl = null;

        function openPdfBlob(btn, url) {
            var overlay   = document.getElementById('rph-pdf-overlay');
            var container = document.getElementById('rph-pdf-container');
            var dlLink    = document.getElementById('rph-pdf-download-link');

            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';

            container.innerHTML = '<div style="color:#ccc; margin-top:60px; font-size:1em; font-family:Arial,sans-serif;">Memuatkan PDF...</div>';

            // Server returns JSON {data: base64, filename: '...'} — IDM never intercepts application/json
            fetch(url, {
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function(res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function(json) {
                // Decode base64 → Uint8Array → ArrayBuffer
                var binary = atob(json.data);
                var bytes  = new Uint8Array(binary.length);
                for (var i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
                var buffer = bytes.buffer;

                // Blob URL for download button
                var blob = new Blob([buffer], { type: 'application/pdf' });
                if (_pdfBlobUrl) URL.revokeObjectURL(_pdfBlobUrl);
                _pdfBlobUrl = URL.createObjectURL(blob);
                dlLink.href = _pdfBlobUrl;
                dlLink.download = json.filename || 'RPH.pdf';

                // Render with PDF.js
                return pdfjsLib.getDocument({ data: buffer }).promise;
            })
            .then(function(pdfDoc) {
                container.innerHTML = '';
                var renderPage = function(pageNum) {
                    return pdfDoc.getPage(pageNum).then(function(page) {
                        // Scale to fit container width (~A4 portrait at 96dpi)
                        var desiredWidth = Math.min(container.clientWidth - 40, 860);
                        var viewport0    = page.getViewport({ scale: 1 });
                        var scale        = desiredWidth / viewport0.width;
                        var viewport     = page.getViewport({ scale: scale });

                        var canvas       = document.createElement('canvas');
                        canvas.width     = viewport.width;
                        canvas.height    = viewport.height;
                        canvas.style.cssText = 'display:block; box-shadow:0 2px 10px rgba(0,0,0,0.6); background:#fff; flex-shrink:0;';
                        container.appendChild(canvas);

                        return page.render({
                            canvasContext: canvas.getContext('2d'),
                            viewport: viewport
                        }).promise;
                    });
                };

                var chain = Promise.resolve();
                for (var i = 1; i <= pdfDoc.numPages; i++) {
                    chain = chain.then(renderPage.bind(null, i));
                }
                return chain;
            })
            .catch(function(err) {
                overlay.style.display = 'none';
                document.body.style.overflow = '';
                Swal.fire({
                    title: 'Ralat',
                    text: 'Gagal memuatkan PDF: ' + err.message,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }

        // Render a pre-fetched base64 PDF string directly in the overlay
        function renderPdfBase64(base64) {
            var overlay   = document.getElementById('rph-pdf-overlay');
            var container = document.getElementById('rph-pdf-container');

            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
            container.innerHTML = '<div style="color:#ccc;margin-top:60px;font-size:1em;font-family:Arial,sans-serif;">Memuatkan PDF...</div>';

            var binary = atob(base64);
            var bytes  = new Uint8Array(binary.length);
            for (var i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);

            pdfjsLib.getDocument({ data: bytes.buffer }).promise
            .then(function(pdfDoc) {
                container.innerHTML = '';
                var renderPage = function(pageNum) {
                    return pdfDoc.getPage(pageNum).then(function(page) {
                        var desiredWidth = Math.min(container.clientWidth - 40, 860);
                        var viewport0    = page.getViewport({ scale: 1 });
                        var scale        = desiredWidth / viewport0.width;
                        var viewport     = page.getViewport({ scale: scale });
                        var canvas       = document.createElement('canvas');
                        canvas.width     = viewport.width;
                        canvas.height    = viewport.height;
                        canvas.style.cssText = 'display:block;box-shadow:0 2px 10px rgba(0,0,0,.6);background:#fff;flex-shrink:0;';
                        container.appendChild(canvas);
                        return page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise;
                    });
                };
                var chain = Promise.resolve();
                for (var i = 1; i <= pdfDoc.numPages; i++) chain = chain.then(renderPage.bind(null, i));
                return chain;
            })
            .catch(function(err) {
                overlay.style.display = 'none';
                document.body.style.overflow = '';
                Swal.fire({ title: 'Ralat', text: 'Gagal memuatkan PDF: ' + err.message, icon: 'error', confirmButtonColor: '#dc3545' });
            });
        }

        function closePdfViewer() {
            var overlay   = document.getElementById('rph-pdf-overlay');
            var container = document.getElementById('rph-pdf-container');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
            container.innerHTML = '';
            if (_pdfBlobUrl) {
                setTimeout(function() { URL.revokeObjectURL(_pdfBlobUrl); _pdfBlobUrl = null; }, 500);
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var overlay = document.getElementById('rph-pdf-overlay');
                if (overlay && overlay.style.display === 'block') closePdfViewer();
            }
        });
    </script>

    @auth
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.getElementById('btnManualDownload');
        if (btn) {
            btn.addEventListener('click', function () {
                openPdfBlob(btn, '{{ route("manual.download") }}');
            });
        }
    });
    </script>
    @endauth

    {{-- Anti-FOUC: reveal body once all CSS and DOM are ready --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.style.visibility = 'visible';
        });
    </script>

</body>

</html>
