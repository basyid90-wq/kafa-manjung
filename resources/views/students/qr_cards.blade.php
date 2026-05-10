<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kad QR – {{ $kafaClass->display_name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: Arial, sans-serif;
    font-size: 10pt;
    background: #f8fafc;
    color: #1e293b;
}

/* ══════════════════════════════
   SCREEN STYLES
══════════════════════════════ */
@media screen {

    /* Action bar */
    .print-bar {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        padding: 14px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        border-bottom: 3px solid #6c63ff;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .print-bar h6 { margin: 0; font-size: 1em; font-weight: 700; }
    .print-bar small { color: #94a3b8; font-size: 0.8em; }
    .btn-print {
        background: #6c63ff;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.85em;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background .2s;
    }
    .btn-print:hover { background: #5b53e0; }
    .btn-back {
        color: #94a3b8;
        text-decoration: none;
        font-size: 0.85em;
        padding: 8px 14px;
        border: 1px solid #334155;
        border-radius: 8px;
        transition: background .2s, color .2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-back:hover { background: #1e293b; color: white; }

    /* Screen card grid — 3 or 4 per row depending on viewport */
    .screen-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        padding: 28px 24px;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Flowbite "Share profile with QR" card */
    .screen-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(108,99,255,.06);
        transition: box-shadow .2s, transform .2s;
    }
    .screen-card:hover {
        box-shadow: 0 4px 20px rgba(108,99,255,.18);
        transform: translateY(-2px);
    }

    /* Card gradient header band */
    .screen-card__header {
        width: 100%;
        height: 60px;
        background: linear-gradient(135deg, #6c63ff 0%, #3b82f6 100%);
        flex-shrink: 0;
    }

    /* Avatar ring pulled up over the header */
    .screen-card__avatar-wrap {
        margin-top: -36px;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }
    .screen-card__photo {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,.15);
    }
    .screen-card__photo-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,.15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Card body */
    .screen-card__body { padding: 0 16px 16px; width: 100%; }
    .screen-card__name {
        font-size: 0.9em;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
        margin-bottom: 3px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .screen-card__class {
        font-size: 0.75em;
        color: #6c63ff;
        font-weight: 600;
        margin-bottom: 2px;
    }
    .screen-card__school {
        font-size: 0.7em;
        color: #94a3b8;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .screen-card__divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 12px 0;
    }
    .screen-card__qr {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 8px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }
    .screen-card__qr svg,
    .screen-card__qr img { width: 100px; height: 100px; }
    .screen-card__no-qr {
        font-size: 0.7em;
        color: #94a3b8;
        padding: 20px;
    }

    /* Hide print grid on screen */
    .qr-grid { display: none !important; }
}

/* ══════════════════════════════
   PRINT STYLES — compact A4 2×5
══════════════════════════════ */
@media print {
    .print-bar { display: none !important; }
    .screen-grid { display: none !important; }

    body { margin: 0; background: #fff; }

    .qr-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 4mm;
        padding: 5mm;
        width: 210mm;
        margin: 0 auto;
    }

    .qr-card {
        border: 1.5px solid #ddd;
        border-radius: 8px;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        min-height: 36mm;
        page-break-inside: avoid;
        break-inside: avoid;
    }

    .qr-card__photo {
        width: 48px; height: 48px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #eee;
        flex-shrink: 0;
    }
    .qr-card__photo-placeholder {
        width: 48px; height: 48px;
        border-radius: 6px;
        background: #f0f0f0;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        border: 1px solid #ddd;
    }
    .qr-card__photo-placeholder svg { width: 28px; height: 28px; }

    .qr-card__info { flex: 1; min-width: 0; }
    .qr-card__name {
        font-weight: 700; font-size: 9pt; line-height: 1.3; color: #111;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .qr-card__class { font-size: 7.5pt; color: #555; margin-top: 2px; }
    .qr-card__school {
        font-size: 6.5pt; color: #888; margin-top: 1px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .qr-card__qr {
        flex-shrink: 0; width: 66px; height: 66px;
        display: flex; align-items: center; justify-content: center;
    }
    .qr-card__qr svg { width: 66px; height: 66px; }

    @page { size: A4 portrait; margin: 5mm; }
}
</style>
</head>
<body>

{{-- ── Action bar (screen only) ── --}}
<div class="print-bar">
    <div>
        <h6>Kad QR — {{ $kafaClass->display_name }}</h6>
        <small>{{ $school->name }} &nbsp;·&nbsp; {{ $students->count() }} murid</small>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="{{ url()->previous() }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <button class="btn-print" onclick="window.print()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
            Cetak
        </button>
    </div>
</div>

{{-- ── Screen card grid (Flowbite "Share profile with QR" style) ── --}}
<div class="screen-grid">
    @forelse($students as $student)
    @php $photoSrc = $student->photo ?? $student->profile_picture; @endphp
    <div class="screen-card">
        <div class="screen-card__header"></div>
        <div class="screen-card__avatar-wrap">
            @if($photoSrc)
                <img src="{{ asset('storage/' . $photoSrc) }}"
                     alt="{{ $student->name }}"
                     class="screen-card__photo">
            @else
                <div class="screen-card__photo-placeholder">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" width="34" height="34">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
            @endif
        </div>
        <div class="screen-card__body">
            <div class="screen-card__name" title="{{ $student->name }}">{{ $student->name }}</div>
            <div class="screen-card__class">{{ $kafaClass->display_name }}</div>
            <div class="screen-card__school" title="{{ $school->name }}">{{ $school->name }}</div>
            <hr class="screen-card__divider">
            <div class="screen-card__qr">
                @if($student->qr_code_string)
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($student->qr_code_string) !!}
                @else
                    <div class="screen-card__no-qr">Tiada Kod QR</div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1; text-align:center; padding:60px; color:#94a3b8; font-size:0.9em;">
        Tiada murid dalam kelas ini.
    </div>
    @endforelse
</div>

{{-- ── Print grid — compact A4 layout ── --}}
<div class="qr-grid">
    @forelse($students as $student)
    @php $photoSrc = $student->photo ?? $student->profile_picture; @endphp
    <div class="qr-card">
        @if($photoSrc)
            <img src="{{ asset('storage/' . $photoSrc) }}"
                 alt="{{ $student->name }}"
                 class="qr-card__photo">
        @else
            <div class="qr-card__photo-placeholder">
                <svg viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
        @endif
        <div class="qr-card__info">
            <div class="qr-card__name" title="{{ $student->name }}">{{ $student->name }}</div>
            <div class="qr-card__class">{{ $kafaClass->display_name }}</div>
            <div class="qr-card__school" title="{{ $school->name }}">{{ $school->name }}</div>
        </div>
        <div class="qr-card__qr">
            @if($student->qr_code_string)
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(66)->generate($student->qr_code_string) !!}
            @else
                <div style="font-size:6.5pt; color:#aaa; text-align:center;">Tiada<br>Kod QR</div>
            @endif
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1; text-align:center; padding:40px; color:#888;">
        Tiada murid dalam kelas ini.
    </div>
    @endforelse
</div>

</body>
</html>
