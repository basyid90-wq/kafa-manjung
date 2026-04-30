<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>RPH Kelas Cantum</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body {
    font-family: 'lateef', sans-serif;
    font-size: 12pt;
    color: #000;
    direction: rtl;
}

/* ── TAJUK ───────────────────────────────────────── */
.tajuk {
    text-align: center;
    font-size: 20pt;
    font-weight: bold;
    border-bottom: 2.5px double #000;
    padding-bottom: 4px;
    margin-bottom: 6px;
    direction: rtl;
}

/* ── HEADER (Minggu / Hari / Tarikh sahaja) ──────── */
.info-bar {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 6px;
    font-size: 12pt;
    direction: rtl;
}
.info-bar td { padding: 2px 6px; }
.info-bar .lbl { font-weight: bold; white-space: nowrap; }
.info-bar .val {
    border-bottom: 1px solid #000;
    min-width: 60px;
    display: inline-block;
    padding: 0 4px;
}

/* ── JADUAL UTAMA ────────────────────────────────── */
.jadual {
    width: 100%;
    border-collapse: collapse;
    font-size: 11pt;
    margin-bottom: 0;
}
.jadual th, .jadual td {
    border: 1px solid #000;
    padding: 4px 6px;
    vertical-align: top;
}
.lbl-col {
    background: #f0f0f0;
    font-weight: bold;
    width: 17%;
    text-align: right;
    direction: rtl;
    white-space: nowrap;
}
.yr-head {
    background: #dde;
    text-align: center;
    font-size: 12pt;
    font-weight: bold;
    direction: rtl;
}
.content-cell {
    direction: rtl;
    text-align: right;
    white-space: pre-wrap;
    word-wrap: break-word;
    min-height: 22px;
}
.shared-cell {
    direction: rtl;
    text-align: right;
}

/* ── CHECKBOX ────────────────────────────────────── */
.cb-wrap { white-space: nowrap; display: inline-block; margin: 2px 8px; font-size: 11pt; }
.cb-box {
    display: inline-block;
    width: 12px; height: 12px;
    border: 1px solid #000;
    vertical-align: middle;
    text-align: center;
    line-height: 12px;
    margin-left: 3px;
    font-size: 10pt;
}

/* ── IMPAK ───────────────────────────────────────── */
.impak-inner { width: 100%; border-collapse: collapse; }
.impak-inner td { border: none; padding: 2px 5px; font-size: 11pt; direction: rtl; }
.garis { border-bottom: 1px solid #000; display: inline-block; min-width: 80px; }

/* ── PEMISAH SESI ────────────────────────────────── */
.sesi-divider {
    margin: 6px 0 0 0;
    border-top: 2px solid #000;
}

/* ── TANDATANGAN ─────────────────────────────────── */
.ttd-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.ttd-table td { width: 50%; padding: 6px 10px; text-align: center; direction: rtl; font-size: 11pt; }
.ttd-line { border-top: 1px solid #000; width: 160px; margin: 30px auto 3px auto; }

/* ── PAGE BREAK ──────────────────────────────────── */
.page-break { page-break-after: always; }
</style>
</head>
<body>

@php
$KEMAHIRAN_JAWI = [
    'menulis'                 => 'متوليس',
    'membaca'                 => 'مباچ',
    'menyanyi'                => 'منيا ڤتي',
    'melukis'                 => 'ملوكيس',
    'melabel'                 => 'ملابيل',
    'memilih_mengkategorikan' => 'مميزكن/مڠكاتيكوريكن',
    'mengira_membilang'       => 'مغيرا/ممبيلڠ',
    'luar_bilik_darjah'       => 'لوار بيليق درجه',
    'simulasi'                => 'سيمولاسي',
    'memupuk_menanamkan'      => 'ميڤوت/ميانتاكن',
    'menghafaz'               => 'مفحظ',
];
$STRATEGI_JAWI = [
    'berpusatkan_guru'  => 'برڤوستكن كورو',
    'berpusatkan_murid' => 'برڤوستكن موريد',
    'luar_bilik_darjah' => 'لوار بيليق درجه',
    'talqi_musyafahah'  => 'تلقي مشافهة',
];
$years   = collect($rph->combined_years ?? [])->sort()->values()->all();
$periods = $rph->periods->keyBy('period_no');
$nYears  = count($years);
$tarikh  = \Carbon\Carbon::parse($rph->date)->format('d/m/Y');
@endphp

{{-- ══ TAJUK ══ --}}
<div class="tajuk">رنچڠن ڤڠاجرن هاريان كلس چنتوم</div>

{{-- ══ HEADER: ميڠكو / هاري / تاريخ sahaja ══ --}}
<table class="info-bar">
    <tr>
        <td style="width:33%; text-align:right;">
            <span class="lbl">ميڠكو :</span>
            <span class="val">{{ $rph->week }}</span>
        </td>
        <td style="width:34%; text-align:center;">
            <span class="lbl">هاري :</span>
            <span class="val">{{ $hariJawi[$rph->hari] ?? $rph->hari }}</span>
        </td>
        <td style="width:33%; text-align:left;">
            <span class="lbl">تاريخ :</span>
            <span class="val">{{ $tarikh }}</span>
        </td>
    </tr>
</table>

{{-- ══ 3 SESI ══ --}}
@for($s = 1; $s <= 3; $s++)
@php $p = $periods->get($s); @endphp

@if($s === 3)
<div class="page-break"></div>
<div class="tajuk">رنچڠن ڤڠاجرن هاريان كلس چنتوم</div>
<table class="info-bar">
    <tr>
        <td style="width:33%; text-align:right;">
            <span class="lbl">ميڠكو :</span>
            <span class="val">{{ $rph->week }}</span>
        </td>
        <td style="width:34%; text-align:center;">
            <span class="lbl">هاري :</span>
            <span class="val">{{ $hariJawi[$rph->hari] ?? $rph->hari }}</span>
        </td>
        <td style="width:33%; text-align:left;">
            <span class="lbl">تاريخ :</span>
            <span class="val">{{ $tarikh }}</span>
        </td>
    </tr>
</table>
@endif

@if($s > 1 && $s < 3)
<div class="sesi-divider"></div>
@endif

<table class="jadual" style="margin-top:{{ $s === 1 ? '0' : '4px' }};">
    <thead>
        <tr>
            <th class="lbl-col" style="background:#dde;"></th>
            @foreach($years as $y)
            <th class="yr-head">تاهون : {{ $y }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{-- مات ڤلاجرن --}}
        <tr>
            <td class="lbl-col">مات ڤلاجرن</td>
            <td colspan="{{ $nYears }}" class="shared-cell">{{ $p->mata_pelajaran_jawi ?? '' }}</td>
        </tr>
        {{-- ماس --}}
        <tr>
            <td class="lbl-col">ماس</td>
            <td colspan="{{ $nYears }}" class="shared-cell">{{ $p->masa ?? '' }}</td>
        </tr>
        {{-- تاجوق --}}
        <tr>
            <td class="lbl-col">تاجوق</td>
            @foreach($years as $y)
            <td class="content-cell">{{ $p->tajuk_by_year[$y] ?? '' }}</td>
            @endforeach
        </tr>
        {{-- ايسي ڤلاجرن --}}
        <tr>
            <td class="lbl-col">ايسي ڤلاجرن</td>
            @foreach($years as $y)
            <td class="content-cell" style="min-height:28px;">{{ $p->isi_pelajaran_by_year[$y] ?? '' }}</td>
            @endforeach
        </tr>
        {{-- اوبجيكتيف ڤلاجرن --}}
        <tr>
            <td class="lbl-col">اوبجيكتيف ڤلاجرن</td>
            @foreach($years as $y)
            <td class="content-cell" style="min-height:28px;">{{ $p->objective_by_year[$y] ?? '' }}</td>
            @endforeach
        </tr>
        {{-- اكتيۏيتي --}}
        <tr>
            <td class="lbl-col">اكتيۏيتي</td>
            @foreach($years as $y)
            <td class="content-cell" style="min-height:32px;">{{ $p->aktiviti_by_year[$y] ?? '' }}</td>
            @endforeach
        </tr>
        {{-- كماهيرن --}}
        <tr>
            <td class="lbl-col">كماهيرن</td>
            <td colspan="{{ $nYears }}">
                @foreach($KEMAHIRAN_JAWI as $val => $jawiLabel)
                @php $checked = $p && in_array($val, $p->kemahiran_selected ?? []); @endphp
                <span class="cb-wrap">
                    <span class="cb-box">{{ $checked ? ' / ' : '   ' }}</span>{{ $jawiLabel }}
                </span>
                @endforeach
            </td>
        </tr>
        {{-- ستراتڬي في دي سي --}}
        <tr>
            <td class="lbl-col">ستراتڬي في دي سي</td>
            <td colspan="{{ $nYears }}">
                @foreach($STRATEGI_JAWI as $val => $jawiLabel)
                @php $checked = $p && in_array($val, $p->strategi_pdc ?? []); @endphp
                <span class="cb-wrap">
                    <span class="cb-box">{{ $checked ? ' / ' : '   ' }}</span>{{ $jawiLabel }}
                </span>
                @endforeach
            </td>
        </tr>
        {{-- ايمڤك ڤمبلاجرن --}}
        <tr>
            <td class="lbl-col">ايمڤك ڤمبلاجرن</td>
            <td colspan="{{ $nYears }}">
                @php $impak = $p->impak ?? []; @endphp
                <table class="impak-inner">
                    <tr>
                        <td style="width:50%;">
                            <span class="garis">{{ $impak['berjaya'] ?? '' }}</span>
                            اورڠ موريد دافتي مڽبوت / ممبوات / مڠيچم اوبجيكتيف ڤمبلاجرن / كماهيرن.
                        </td>
                        <td style="width:50%;">
                            <span class="garis">{{ $impak['belum'] ?? '' }}</span>
                            اورڠ موريد بلوم دافتي. تيندقن لنجوت ديڤرلوكن.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            اكتيۏيتي ڤ&ڤ دتڠڬوهكن كران :
                            <span class="garis">{{ $impak['sebab_ditangguh'] ?? '' }}</span>
                        </td>
                        <td>
                            اكتيۏيتي ڤ&ڤ دتروسكن ڤد :
                            <span class="garis">{{ $impak['tarikh_teruskan'] ?? '' }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

@endfor

{{-- ══ TANDATANGAN ══ --}}
<table class="ttd-table">
    <tr>
        <td>
            <p>دسيدياكن اوليه :</p>
            <div class="ttd-line"></div>
            <p>{{ $rph->user->name ?? '' }}</p>
            <p style="font-size:8pt;">(كورو كافا)</p>
        </td>
        <td>
            <p>دساهكن اوليه :</p>
            <div class="ttd-line"></div>
            <p>{{ $rph->reviewer->name ?? '' }}</p>
            <p style="font-size:8pt;">(كورو بسر)</p>
        </td>
    </tr>
</table>

</body>
</html>
