<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>RPH</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'lateef', sans-serif;
    font-size: 10.5pt;
    color: #000;
    direction: rtl;
}

/* ── TAJUK ─────────────────────────────── */
.tajuk {
    text-align: center;
    font-size: 18pt;
    font-weight: bold;
    border-bottom: 2px double #000;
    padding-bottom: 3px;
    margin-bottom: 4px;
}

/* ── BARIS MAKLUMAT AM ─────────────────── */
.info-bar {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 3px;
}
.info-bar td {
    font-size: 10pt;
    padding: 2px 5px;
    direction: rtl;
}
.lbl { font-weight: bold; }
.val {
    border-bottom: 1px solid #000;
    min-width: 50px;
    display: inline-block;
    padding: 0 3px;
}

/* ── JADUAL UTAMA ─────────────────────── */
/*
  RTL TABLE — Col 1 in HTML → RIGHT visually (narrow, labels/meta)
               Col 2 in HTML → LEFT visually  (wide, content)
*/
.jadual {
    width: 100%;
    border-collapse: collapse;
    direction: rtl;
}
.jadual th, .jadual td {
    border: 1px solid #000;
    vertical-align: top;
}

.col-kanan { width: 27%; }
.col-kiri  { width: 73%; }

/* Header row */
.th-meta {
    text-align: center;
    font-size: 9pt;
    font-weight: bold;
    padding: 3px 4px;
    background: #efefef;
    line-height: 1.6;
    direction: rtl;
}
.th-kandungan {
    text-align: center;
    font-size: 13pt;
    font-weight: bold;
    padding: 4px 6px;
    background: #efefef;
}

/* Period meta row */
.td-meta {
    padding: 3px 5px;
    font-size: 9pt;
    line-height: 1.5;
    direction: ltr;
    text-align: left;
}
.td-meta-lbl {
    font-size: 10pt;
    direction: rtl;
}

/* Label cells */
.td-label {
    padding: 2px 5px;
    font-size: 10pt;
    font-weight: bold;
    text-align: right;
    vertical-align: middle;
    background: #fafafa;
    white-space: nowrap;
    direction: rtl;
}

/* Content cells */
.td-content {
    padding: 2px 7px;
    font-size: 10.5pt;
    line-height: 1.45;
    vertical-align: top;
    direction: rtl;
    text-align: right;
}

/* Dashed divider between periods */
.tr-divider td {
    border-top: 1.5px dashed #888;
    padding: 0;
    height: 1px;
    border-bottom: none;
    border-left: 1px solid #000;
    border-right: 1px solid #000;
}

/* Status footer */
.td-status {
    font-size: 8pt;
    padding: 3px 7px;
    background: #f5f5f5;
    direction: ltr;
    border-top: 1px solid #aaa;
}


/* Watermark */
.wm {
    position: fixed;
    top: 36%; left: 8%;
    font-size: 48pt;
    font-weight: bold;
    opacity: 0.05;
    transform: rotate(-30deg);
    z-index: -1;
}
.wm-lulus { color: #2e7d32; }
.wm-draf  { color: #e65100; }
</style>
</head>
<body>

@if($rph->status === 'approved')
<div class="wm wm-lulus">LULUS</div>
@else
<div class="wm wm-draf">DRAF</div>
@endif

{{-- TAJUK --}}
<div class="tajuk">رانچڠن ڤڠاجرن هارين</div>

{{-- MAKLUMAT AM --}}
<table class="info-bar">
    <tr>
        <td style="width:33%; text-align:right;">
            <span class="lbl">ميڠکو :</span>
            <span class="val">{{ $rph->week }}</span>
        </td>
        <td style="width:34%; text-align:center;">
            <span class="lbl">هاري :</span>
            <span class="val">{{ $hariJawi[$rph->hari] ?? $rph->hari }}</span>
        </td>
        <td style="width:33%; text-align:left;">
            <span class="lbl">تاريخ :</span>
            <span class="val">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</span>
        </td>
    </tr>
</table>

{{-- JADUAL KANDUNGAN --}}
<table class="jadual">

    {{-- ── Header row ── --}}
    <tr>
        {{-- Col 1 → RIGHT (narrow): meta header --}}
        <th class="col-kanan th-meta">
            تاهون / کلس<br>ماس<br>مات ڤلاجرن / بيدڠ
        </th>
        {{-- Col 2 → LEFT (wide): kandungan --}}
        <th class="col-kiri th-kandungan">کاندوڠن</th>
    </tr>

    @php
        $labelRows = [
            'topic_jawi'         => 'تاجوق :',
            'kemahiran_jawi'     => 'كماهيرن :',
            'isi_pelajaran_jawi' => 'ايسي ڤلاجرن :',
            'objective_jawi'     => 'اوبجيكتيف :',
            'aktiviti_jawi'      => 'اكتيۏيتي :',
            'reflection_jawi'    => 'ايمڤک ڤمبلاجرن :',
        ];
        $periods = collect([1,2,3])->map(fn($n) => $rph->periods->firstWhere('period_no', $n));
    @endphp

    @foreach($periods as $idx => $period)

    {{-- Dashed divider between periods --}}
    @if($idx > 0)
    <tr class="tr-divider"><td colspan="2"></td></tr>
    @endif

    {{-- ── Period meta row ── --}}
    <tr>
        {{-- Col 1 → RIGHT: class / time / subject --}}
        <td class="col-kanan td-meta">
            <span class="td-meta-lbl">تاهون/کلس :</span><br>
            {{ $period?->kafaClass?->name ?? '___________' }}<br>
            <span class="td-meta-lbl">ماس :</span><br>
            {{ $period?->masa ?? '___________' }}<br>
            <span class="td-meta-lbl">مات ڤلاجرن :</span><br>
            {{ $period?->mata_pelajaran_jawi ?? '___________' }}
        </td>
        {{-- Col 2 → LEFT: blank --}}
        <td class="col-kiri td-content">&nbsp;</td>
    </tr>

    {{-- ── Content rows ── --}}
    @foreach($labelRows as $field => $label)
    <tr>
        {{-- Col 1 → RIGHT: label --}}
        <td class="col-kanan td-label">{{ $label }}</td>
        {{-- Col 2 → LEFT: content --}}
        <td class="col-kiri td-content">{{ $period?->{$field} ?? '' }}</td>
    </tr>
    @endforeach

    @endforeach

    {{-- ── Status row ── --}}
    <tr>
        <td colspan="2" class="td-status">
            <table style="width:100%; border:none; direction:ltr; border-collapse:collapse;">
                <tr>
                    <td style="border:none; text-align:left;">
                        Status:
                        @if($rph->status === 'approved')
                            <strong style="color:#2e7d32;">Diluluskan</strong>
                            @if($rph->reviewer) oleh <strong>{{ $rph->reviewer->name }}</strong> @endif
                        @elseif($rph->status === 'pending')
                            <span style="color:#e65100;">Menunggu Semakan</span>
                        @elseif($rph->status === 'revision_needed')
                            <span style="color:#1565c0;">Perlu Pembaikan</span>
                        @elseif($rph->status === 'rejected')
                            <span style="color:#c62828;">Ditolak</span>
                        @endif
                    </td>
                    <td style="border:none; text-align:right; color:#777;">
                        Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>

@if($rph->review_comment)
<div style="margin-top:4px; padding:4px 8px; border:1px solid #e65100; border-radius:3px; background:#fff8e1; font-size:8pt; direction:ltr;">
    <strong>Ulasan:</strong> {{ $rph->review_comment }}
</div>
@endif


</body>
</html>
