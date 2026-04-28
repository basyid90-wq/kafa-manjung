<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Kiosk Kehadiran QR</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --green:  #2e7d32;
    --orange: #e65100;
    --red:    #c62828;
    --dark:   #0f1117;
    --card:   #1a1d27;
    --border: #2a2d3e;
}

html, body {
    height: 100%;
    background: var(--dark);
    color: #e8eaf0;
    font-family: 'Segoe UI', Arial, sans-serif;
    overflow: hidden;
}

/* ── Layout ── */
.kiosk-wrap {
    display: grid;
    grid-template-rows: auto 1fr auto;
    height: 100vh;
    max-width: 900px;
    margin: 0 auto;
    padding: 24px 20px 16px;
    gap: 20px;
}

/* ── Header ── */
.kiosk-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.kiosk-header h1 {
    font-size: 1.3em;
    font-weight: 700;
    color: #fff;
}
.kiosk-header .school-name {
    font-size: 0.8em;
    color: #888;
    margin-top: 2px;
}
.kiosk-clock {
    font-size: 1.8em;
    font-weight: 700;
    color: #6c63ff;
    font-variant-numeric: tabular-nums;
    letter-spacing: 2px;
}
.btn-exit {
    position: absolute;
    top: 16px;
    right: 20px;
    background: rgba(255,255,255,0.06);
    color: #888;
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 5px 14px;
    font-size: 0.78em;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-exit:hover { background: rgba(255,255,255,0.12); color: #fff; }

/* ── Result card ── */
.result-area {
    display: flex;
    align-items: center;
    justify-content: center;
}

.result-card {
    background: var(--card);
    border: 2px solid var(--border);
    border-radius: 20px;
    padding: 36px 40px;
    width: 100%;
    max-width: 480px;
    text-align: center;
    transition: border-color 0.3s, box-shadow 0.3s;
    min-height: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 14px;
}
.result-card.state-idle   { border-color: var(--border); }
.result-card.state-hadir  { border-color: var(--green);  box-shadow: 0 0 40px rgba(46,125,50,0.3); }
.result-card.state-lewat  { border-color: var(--orange); box-shadow: 0 0 40px rgba(230,81,0,0.3); }
.result-card.state-error  { border-color: var(--red);    box-shadow: 0 0 40px rgba(198,40,40,0.25); }

.result-photo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border);
}
.result-photo-placeholder {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #2a2d3e;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid var(--border);
}
.result-photo-placeholder svg { width: 48px; height: 48px; stroke: #555; }

.result-name  { font-size: 1.7em; font-weight: 700; color: #fff; line-height: 1.2; }
.result-class { font-size: 0.95em; color: #999; }

.result-badge {
    font-size: 1.1em;
    font-weight: 700;
    padding: 8px 24px;
    border-radius: 50px;
    letter-spacing: 0.5px;
}
.badge-hadir { background: rgba(46,125,50,0.2);  color: #66bb6a; border: 1px solid #2e7d32; }
.badge-lewat { background: rgba(230,81,0,0.2);   color: #ffa040; border: 1px solid #e65100; }
.badge-error { background: rgba(198,40,40,0.15); color: #ef9a9a; border: 1px solid #c62828; }

.result-time  { font-size: 0.82em; color: #666; }

.idle-icon { opacity: 0.15; }
.idle-icon svg { width: 80px; height: 80px; stroke: #fff; }
.idle-text { color: #555; font-size: 0.95em; }

/* ── Scanning indicator ── */
.scan-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #555;
    font-size: 0.85em;
}
.scan-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: #6c63ff;
    animation: pulse 1.5s ease-in-out infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.4; transform: scale(0.7); }
}

/* ── Footer log ── */
.kiosk-log {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 10px 16px;
    max-height: 120px;
    overflow-y: auto;
}
.kiosk-log h6 {
    font-size: 0.72em;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}
.log-entry {
    display: flex;
    justify-content: space-between;
    font-size: 0.82em;
    padding: 3px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    color: #aaa;
}
.log-entry:last-child { border-bottom: none; }
.log-name { font-weight: 600; color: #ccc; }
.log-hadir { color: #66bb6a; }
.log-lewat { color: #ffa040; }
.log-error { color: #ef9a9a; }

/* ── Hidden QR input ── */
#qr_input {
    position: fixed;
    left: -9999px;
    opacity: 0;
    width: 1px;
    height: 1px;
}
</style>
</head>
<body>

<a href="{{ route('attendances.index') }}" class="btn-exit">✕ Keluar</a>

<div class="kiosk-wrap">

    {{-- Header --}}
    <div class="kiosk-header">
        <div>
            <h1>🔲 Kiosk Kehadiran</h1>
            <div class="school-name">{{ auth()->user()->school?->name ?? 'Sistem Kehadiran KAFA' }}</div>
        </div>
        <div class="kiosk-clock" id="kiosk-clock">--:--:--</div>
    </div>

    {{-- Result area --}}
    <div class="result-area">
        <div class="result-card state-idle" id="result-card">
            <div class="idle-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.2">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            </div>
            <div class="idle-text">Sedia menerima imbasan QR...</div>
            <div class="scan-indicator">
                <div class="scan-dot"></div>
                Sedang menunggu
            </div>
        </div>
    </div>

    {{-- Scan log --}}
    <div class="kiosk-log">
        <h6>Log Imbasan Terkini</h6>
        <div id="scan-log">
            <div class="log-entry"><span class="log-name" style="color:#555;">— Tiada imbasan lagi —</span></div>
        </div>
    </div>

</div>

{{-- Hidden auto-focus input for scanner --}}
<input type="text" id="qr_input" autocomplete="off" autofocus>

<script>
// ── Clock ──────────────────────────────────────────
function updateClock() {
    const now = new Date();
    const pad = n => String(n).padStart(2, '0');
    document.getElementById('kiosk-clock').textContent =
        pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
}
setInterval(updateClock, 1000);
updateClock();

// ── Always-focus on hidden input ───────────────────
const qrInput = document.getElementById('qr_input');
document.addEventListener('click', () => qrInput.focus());
document.addEventListener('keydown', () => qrInput.focus());
qrInput.focus();

// ── Scan submit on Enter ───────────────────────────
let debounceTimer = null;

qrInput.addEventListener('keydown', function(e) {
    if (e.key !== 'Enter') return;
    e.preventDefault();
    const val = qrInput.value.trim();
    qrInput.value = '';
    if (!val) return;

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => processQr(val), 80);
});

// ── Process QR scan ────────────────────────────────
const card = document.getElementById('result-card');
const log  = document.getElementById('scan-log');
let resetTimer = null;

async function processQr(code) {
    try {
        const res = await fetch('{{ route("kiosk.scan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ qr: code }),
        });

        const data = await res.json();

        if (data.ok) {
            showResult(data);
            addLog(data.name, data.status, data.masa);
        } else {
            showError(data.message ?? 'Kod QR tidak dikenali.');
            addLog('—', 'error', new Date().toLocaleTimeString('ms-MY', {hour:'2-digit', minute:'2-digit', second:'2-digit'}));
        }
    } catch (err) {
        showError('Ralat rangkaian. Cuba lagi.');
    }
}

function showResult(data) {
    clearTimeout(resetTimer);
    const isLewat = data.status === 'Lewat';
    card.className = 'result-card ' + (isLewat ? 'state-lewat' : 'state-hadir');

    const photoHtml = data.photo
        ? `<img src="${data.photo}" class="result-photo" alt="${data.name}">`
        : `<div class="result-photo-placeholder">
             <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
               <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
               <circle cx="12" cy="7" r="4"/>
             </svg>
           </div>`;

    card.innerHTML = `
        ${photoHtml}
        <div class="result-name">${escHtml(data.name)}</div>
        <div class="result-class">${escHtml(data.class)}</div>
        <div class="result-badge ${isLewat ? 'badge-lewat' : 'badge-hadir'}">
            ${isLewat ? '⏰ Lewat' : '✅ Hadir'}
        </div>
        <div class="result-time">Diimbas: ${data.masa}</div>
    `;

    resetTimer = setTimeout(resetCard, 5000);
}

function showError(msg) {
    clearTimeout(resetTimer);
    card.className = 'result-card state-error';
    card.innerHTML = `
        <div style="font-size:2.5em;">❌</div>
        <div class="result-badge badge-error">${escHtml(msg)}</div>
    `;
    resetTimer = setTimeout(resetCard, 4000);
}

function resetCard() {
    card.className = 'result-card state-idle';
    card.innerHTML = `
        <div class="idle-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.2">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
        </div>
        <div class="idle-text">Sedia menerima imbasan QR...</div>
        <div class="scan-indicator">
            <div class="scan-dot"></div>
            Sedang menunggu
        </div>
    `;
    qrInput.focus();
}

function addLog(name, status, masa) {
    const firstEntry = log.querySelector('.log-entry span[style*="color:#555"]');
    if (firstEntry) firstEntry.closest('.log-entry').remove();

    const cls  = status === 'Hadir' ? 'log-hadir' : status === 'Lewat' ? 'log-lewat' : 'log-error';
    const label = status === 'error' ? 'Tidak Dikenali' : status;
    const entry = document.createElement('div');
    entry.className = 'log-entry';
    entry.innerHTML = `<span class="log-name">${escHtml(name)}</span>
                       <span><span class="${cls}">${label}</span> &nbsp; ${masa}</span>`;
    log.insertBefore(entry, log.firstChild);

    // Keep last 10 entries
    while (log.children.length > 10) log.removeChild(log.lastChild);
}

function escHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
</body>
</html>
