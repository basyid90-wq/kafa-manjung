<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>Kad QR – {{ $kafaClass->display_name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: Arial, sans-serif;
    font-size: 10pt;
    background: #fff;
}

/* ── Print action bar (hidden on print) ── */
.print-bar {
    background: #1a1a2e;
    color: white;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}
.print-bar h6 { margin: 0; font-size: 1em; }
.btn-print {
    background: #6c63ff;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9em;
    font-weight: 600;
}
.btn-back {
    color: #aaa;
    text-decoration: none;
    font-size: 0.85em;
}

/* ── QR card grid: 2 columns × 5 rows = 10 per A4 ── */
.qr-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 6mm;
    padding: 8mm;
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
    min-height: 38mm;
    page-break-inside: avoid;
    break-inside: avoid;
}

.qr-card__photo {
    width: 52px;
    height: 52px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #eee;
    flex-shrink: 0;
}
.qr-card__photo-placeholder {
    width: 52px;
    height: 52px;
    border-radius: 6px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #ddd;
}
.qr-card__photo-placeholder svg {
    width: 30px;
    height: 30px;
    color: #bbb;
}

.qr-card__info {
    flex: 1;
    min-width: 0;
}
.qr-card__name {
    font-weight: 700;
    font-size: 9.5pt;
    line-height: 1.3;
    color: #111;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.qr-card__class {
    font-size: 8pt;
    color: #555;
    margin-top: 2px;
}
.qr-card__school {
    font-size: 7pt;
    color: #888;
    margin-top: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.qr-card__qr {
    flex-shrink: 0;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.qr-card__qr svg {
    width: 70px;
    height: 70px;
}

/* ── Print styles ── */
@media print {
    .print-bar { display: none !important; }

    body { margin: 0; }

    .qr-grid {
        padding: 5mm;
        gap: 4mm;
    }

    @page {
        size: A4 portrait;
        margin: 5mm;
    }
}
</style>
</head>
<body>

{{-- Action bar (hidden on print) --}}
<div class="print-bar">
    <div>
        <h6>Kad QR — {{ $kafaClass->display_name }}</h6>
        <small style="color:#aaa;">{{ $school->name }} &nbsp;·&nbsp; {{ $students->count() }} murid</small>
    </div>
    <div style="display:flex; gap:12px; align-items:center;">
        <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak</button>
    </div>
</div>

{{-- QR card grid --}}
<div class="qr-grid">
    @forelse($students as $student)
    <div class="qr-card">

        {{-- Foto --}}
        @php $photoSrc = $student->photo ?? $student->profile_picture; @endphp
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

        {{-- Maklumat --}}
        <div class="qr-card__info">
            <div class="qr-card__name" title="{{ $student->name }}">{{ $student->name }}</div>
            <div class="qr-card__class">{{ $kafaClass->display_name }}</div>
            <div class="qr-card__school" title="{{ $school->name }}">{{ $school->name }}</div>
        </div>

        {{-- Kod QR --}}
        <div class="qr-card__qr">
            @if($student->qr_code_string)
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(70)->generate($student->qr_code_string) !!}
            @else
                <div style="font-size:7pt; color:#aaa; text-align:center;">Tiada<br>Kod QR</div>
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
