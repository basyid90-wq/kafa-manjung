<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>RPH Kelas Cantum</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'lateef', sans-serif; font-size: 8.5pt; color: #000; }

/* ── TAJUK ─────────────────────────────────────── */
.tajuk {
    text-align: center;
    border: 2px solid #000;
    padding: 6px 4px;
    margin-bottom: 4px;
}
.tajuk-jawi { font-size: 16pt; direction: rtl; line-height: 1.3; }
.tajuk-rumi { font-size: 10pt; font-weight: bold; letter-spacing: 1px; }

/* ── HEADER INFO ────────────────────────────────── */
.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 4px;
    font-size: 8pt;
}
.info-table td { padding: 2px 4px; }
.info-table .lbl { font-weight: bold; width: 22%; white-space: nowrap; }
.info-table .val { border-bottom: 1px solid #000; }

/* ── SESI LABEL ─────────────────────────────────── */
.sesi-header {
    background: #333;
    color: #fff;
    font-weight: bold;
    font-size: 9pt;
    padding: 4px 8px;
    margin-top: 6px;
    margin-bottom: 0;
}

/* ── JADUAL CANTUM ──────────────────────────────── */
.jadual {
    width: 100%;
    border-collapse: collapse;
    font-size: 8pt;
}
.jadual th, .jadual td {
    border: 1px solid #000;
    padding: 3px 5px;
    vertical-align: top;
}
.jadual .lbl {
    background: #f0f0f0;
    font-weight: bold;
    width: 16%;
    text-align: right;
    direction: rtl;
    white-space: nowrap;
}
.jadual .lbl-sub {
    font-size: 7pt;
    font-weight: normal;
    direction: ltr;
    display: block;
    text-align: left;
    color: #444;
}
.jadual .val { white-space: pre-wrap; word-wrap: break-word; }
.jadual .shared-val { text-align: center; }
.jadual th.yr-head { background: #dde; text-align: center; font-size: 8.5pt; }

/* ── KEMAHIRAN / STRATEGI (checkbox rows) ────────── */
.checkbox-row { display: inline-block; margin: 1px 4px; font-size: 7.5pt; }
.cb-box {
    display: inline-block;
    width: 9px; height: 9px;
    border: 1px solid #000;
    vertical-align: middle;
    text-align: center;
    line-height: 9px;
    margin-right: 2px;
    font-size: 8pt;
}
.cb-checked { background: #000; color: #fff; }

/* ── IMPAK ───────────────────────────────────────── */
.impak-table { width: 100%; border-collapse: collapse; font-size: 7.5pt; }
.impak-table td { border: 1px solid #000; padding: 2px 5px; }
.fraction-box {
    display: inline-block;
    border-bottom: 1px solid #000;
    min-width: 25px;
    text-align: center;
}

/* ── TANDATANGAN ─────────────────────────────────── */
.ttd-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
.ttd-table td { width: 50%; padding: 5px 10px; text-align: center; }
.ttd-line { border-top: 1px solid #000; width: 160px; margin: 30px auto 3px auto; }

/* ── PAGE BREAK ──────────────────────────────────── */
.page-break { page-break-after: always; }
</style>
</head>
<body>

@php
$KEMAHIRAN = [
    'menulis'                 => 'Menulis',
    'membaca'                 => 'Membaca',
    'menyanyi'                => 'Menyanyi',
    'melukis'                 => 'Melukis',
    'melabel'                 => 'Melabel',
    'memilih_mengkategorikan' => 'Memilih/Mengkategorikan',
    'mengira_membilang'       => 'Mengira/Membilang',
    'luar_bilik_darjah'       => 'Luar Bilik Darjah',
    'simulasi'                => 'Simulasi',
    'memupuk_menanamkan'      => 'Memupuk/Menanamkan',
    'menghafaz'               => 'Menghafaz',
];
$STRATEGI = [
    'berpusatkan_guru'  => 'Berpusatkan Guru',
    'berpusatkan_murid' => 'Berpusatkan Murid',
    'luar_bilik_darjah' => 'Luar Bilik Darjah',
    'talqi_musyafahah'  => 'Talqi Musyafahah',
];
$years = collect($rph->combined_years ?? [])->sort()->values()->all();
$periods = $rph->periods->keyBy('period_no');
$colCount = count($years); // 2 or 3
@endphp

{{-- ═══════════════ TAJUK ═══════════════ --}}
<div class="tajuk">
    <div class="tajuk-jawi">رنچڠن ڤڠاجرن هاريان كلس چنتوم</div>
    <div class="tajuk-rumi">RANCANGAN PENGAJARAN HARIAN KELAS CANTUM</div>
</div>

{{-- ═══════════════ MAKLUMAT HEADER ═══════════════ --}}
<table class="info-table">
    <tr>
        <td class="lbl">Sekolah :</td>
        <td class="val" colspan="3">{{ $rph->school->name ?? '-' }}</td>
        <td class="lbl">Tarikh :</td>
        <td class="val">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="lbl">Guru :</td>
        <td class="val" colspan="3">{{ $rph->user->name ?? '-' }}</td>
        <td class="lbl">Hari :</td>
        <td class="val">{{ $rph->hari }} ({{ $hariJawi[$rph->hari] ?? '' }})</td>
    </tr>
    <tr>
        <td class="lbl">Kelas Cantum :</td>
        <td class="val" colspan="3">{{ $rph->getCombinedYearsLabel() }}</td>
        <td class="lbl">Minggu :</td>
        <td class="val">{{ $rph->week }}</td>
    </tr>
</table>

{{-- ═══════════════ SESI LOOP ═══════════════ --}}
@for($s = 1; $s <= 3; $s++)
@php $p = $periods->get($s); @endphp

@if($s === 3)
{{-- Page break before sesi 3 --}}
<div class="page-break"></div>
{{-- Repeat tajuk + header ringkas on page 2 --}}
<div class="tajuk" style="margin-top:0;">
    <div class="tajuk-jawi">رنچڠن ڤڠاجرن هاريان كلس چنتوم</div>
    <div class="tajuk-rumi">RANCANGAN PENGAJARAN HARIAN KELAS CANTUM (sambungan)</div>
</div>
<table class="info-table">
    <tr>
        <td class="lbl">Guru :</td><td class="val">{{ $rph->user->name ?? '-' }}</td>
        <td class="lbl">Tarikh :</td><td class="val">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</td>
        <td class="lbl">Kelas :</td><td class="val">{{ $rph->getCombinedYearsLabel() }}</td>
    </tr>
</table>
@endif

<div class="sesi-header">SESI {{ $s }}</div>

<table class="jadual">
    {{-- Header tahun --}}
    <thead>
        <tr>
            <th class="lbl" style="background:#dde;">Perkara</th>
            @foreach($years as $y)
            <th class="yr-head">TAHUN {{ $y }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{-- Mata Pelajaran (shared, span all year cols) --}}
        <tr>
            <td class="lbl">مات ڤلاجرن<span class="lbl-sub">Mata Pelajaran</span></td>
            <td colspan="{{ $colCount }}" class="shared-val">{{ $p->mata_pelajaran_jawi ?? '-' }}</td>
        </tr>
        {{-- Masa (shared) --}}
        <tr>
            <td class="lbl">ماس<span class="lbl-sub">Masa</span></td>
            <td colspan="{{ $colCount }}" class="shared-val">{{ $p->masa ?? '-' }}</td>
        </tr>
        {{-- Tajuk per tahun --}}
        <tr>
            <td class="lbl">تاجوق<span class="lbl-sub">Tajuk</span></td>
            @foreach($years as $y)
            <td class="val">{{ $p->tajuk_by_year[$y] ?? '-' }}</td>
            @endforeach
        </tr>
        {{-- Isi Pelajaran per tahun --}}
        <tr>
            <td class="lbl">ايسي ڤلاجرن<span class="lbl-sub">Isi Pelajaran</span></td>
            @foreach($years as $y)
            <td class="val" style="min-height:30px;">{{ $p->isi_pelajaran_by_year[$y] ?? '-' }}</td>
            @endforeach
        </tr>
        {{-- Objektif per tahun --}}
        <tr>
            <td class="lbl">اوبجيكتيف<span class="lbl-sub">Objektif</span></td>
            @foreach($years as $y)
            <td class="val" style="min-height:30px;">{{ $p->objective_by_year[$y] ?? '-' }}</td>
            @endforeach
        </tr>
        {{-- Aktiviti per tahun --}}
        <tr>
            <td class="lbl">اكتيۏيتي<span class="lbl-sub">Aktiviti</span></td>
            @foreach($years as $y)
            <td class="val" style="min-height:35px;">{{ $p->aktiviti_by_year[$y] ?? '-' }}</td>
            @endforeach
        </tr>

        {{-- Kemahiran (shared checkboxes) --}}
        <tr>
            <td class="lbl">كماهيرن<span class="lbl-sub">Kemahiran</span></td>
            <td colspan="{{ $colCount }}">
                @foreach($KEMAHIRAN as $val => $label)
                @php $checked = $p && in_array($val, $p->kemahiran_selected ?? []); @endphp
                <span class="checkbox-row">
                    <span class="cb-box {{ $checked ? 'cb-checked' : '' }}">{{ $checked ? '✓' : '&nbsp;' }}</span>{{ $label }}
                </span>
                @endforeach
            </td>
        </tr>

        {{-- Strategi PdC (shared checkboxes) --}}
        <tr>
            <td class="lbl">ستراتڬي ڤدڤ<span class="lbl-sub">Strategi PdP</span></td>
            <td colspan="{{ $colCount }}">
                @foreach($STRATEGI as $val => $label)
                @php $checked = $p && in_array($val, $p->strategi_pdc ?? []); @endphp
                <span class="checkbox-row">
                    <span class="cb-box {{ $checked ? 'cb-checked' : '' }}">{{ $checked ? '✓' : '&nbsp;' }}</span>{{ $label }}
                </span>
                @endforeach
            </td>
        </tr>

        {{-- Impak Pembelajaran --}}
        <tr>
            <td class="lbl">ايمڤك<span class="lbl-sub">Impak Pembelajaran</span></td>
            <td colspan="{{ $colCount }}">
                @php $impak = $p->impak ?? []; @endphp
                <table class="impak-table">
                    <tr>
                        <td style="width:50%;">
                            _____ / _____ Murid berjaya mencapai objektif pembelajaran / kemahiran.
                            @if(!empty($impak['berjaya']))
                            <br><strong>{{ $impak['berjaya'] }}</strong>
                            @endif
                        </td>
                        <td style="width:50%;">
                            _____ / _____ Murid belum berjaya. Tindakan lanjut diperlukan.
                            @if(!empty($impak['belum']))
                            <br><strong>{{ $impak['belum'] }}</strong>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Aktiviti P&amp;P ditangguhkan kerana:
                            <span style="border-bottom:1px solid #000; display:inline-block; min-width:120px;">
                                {{ $impak['sebab_ditangguh'] ?? '&nbsp;' }}
                            </span>
                        </td>
                        <td>
                            Aktiviti P&amp;P diteruskan pada:
                            <span style="border-bottom:1px solid #000; display:inline-block; min-width:100px;">
                                {{ $impak['tarikh_teruskan'] ?? '&nbsp;' }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

@endfor

{{-- ═══════════════ TANDATANGAN ═══════════════ --}}
<table class="ttd-table">
    <tr>
        <td>
            <p><strong>Disediakan oleh:</strong></p>
            <div class="ttd-line"></div>
            <p>{{ $rph->user->name ?? '-' }}</p>
            <p style="font-size:7.5pt;">(Guru KAFA)</p>
        </td>
        <td>
            <p><strong>Disahkan oleh:</strong></p>
            <div class="ttd-line"></div>
            <p>{{ $rph->reviewer->name ?? '______________________' }}</p>
            <p style="font-size:7.5pt;">(Guru Besar)</p>
        </td>
    </tr>
</table>

</body>
</html>
