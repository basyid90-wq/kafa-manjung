<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: lateef, Arial, sans-serif;
    font-size: 10.5pt;
    color: #000;
    direction: rtl;
    line-height: 1.3;
}
table { width: 100%; border-collapse: collapse; direction: rtl; }
td, th { font-family: lateef, Arial, sans-serif; font-size: 10.5pt; vertical-align: middle; padding: 2px 4px; }

.sec {
    background: #222; color: #fff;
    text-align: center; font-weight: bold; font-size: 10.5pt;
    padding: 3px 6px; border: 1px solid #111; margin: 2px 0;
}

/* Info table — 9 fixed columns, no nested tables */
.itbl { table-layout: fixed; }
.itbl td { border: none; padding: 2px 4px; font-size: 10.5pt; }
.il  { text-align: right; font-weight: bold; }
.isep { text-align: center; width: 3%; }
.ival { border-bottom: 1px solid #555; }

/* Marks table */
.mt { table-layout: fixed; }
.mt td, .mt th { border: 1px solid #333; padding: 3px 5px; }
.mh { background: #ccc; text-align: center; font-weight: bold; font-size: 10pt; }
.ms { text-align: right; font-size: 10pt; }
/* direction:ltr on marks cells — fixes )A(90 mirroring in RTL context */
.mv { text-align: center; font-size: 10pt; direction: ltr; unicode-bidi: embed; }
.sig  { text-align: center; vertical-align: middle; font-size: 10pt; font-weight: bold; }
.sigb { text-align: center; vertical-align: bottom; font-size: 10pt; font-weight: bold; padding-bottom: 4px; }
.sum td { background: #ebebeb; font-weight: bold; }

.cop {
    width: 58px; height: 58px;
    border-radius: 50%;
    border: 1px dashed #aaa;
    text-align: center; color: #aaa;
    font-size: 9.5pt;
    padding-top: 15px;
    margin: 6px auto 4px auto;
    line-height: 1.4;
}
.wm {
    position: fixed; top: 35%; left: 8%; width: 84%;
    text-align: center; font-size: 70pt; font-weight: bold;
    color: rgba(180,0,0,0.07); transform: rotate(-35deg);
}
</style>
</head>
<body>

@php
use Carbon\Carbon;
$student = $achievement->student;
$school  = $achievement->school;
$class   = $achievement->kafaClass;

// Fix: direction:ltr on .mv prevents )A(90 — but also protect the PHP string itself
$fmt = function($result) use ($examService) {
    if (!$result) return '-';
    if ($result->is_absent) return 'TH';
    return $result->marks . ' (' . $examService->calculateGrade($result->marks) . ')';
};
$fmtN = function($val) use ($examService) {
    if ($val === null) return '-';
    return $val . ' (' . $examService->calculateGrade((int)$val) . ')';
};

$sAmali   = [$midResults->get('amali_solat'),    $endResults->get('amali_solat')];
$sTilawah = [$midResults->get('tilawah_tahfiz'), $endResults->get('tilawah_tahfiz')];
$sAkidah  = [$midResults->get('akidah'),         $endResults->get('akidah')];
$sIbadah  = [$midResults->get('ibadah'),         $endResults->get('ibadah')];
$sSirah   = [$midResults->get('sirah'),          $endResults->get('sirah')];
$sAdab    = [$midResults->get('adab'),           $endResults->get('adab')];
$sJawi    = [$midResults->get('jawi_khat'),      $endResults->get('jawi_khat')];
$sArab    = [$midResults->get('bahasa_arab'),    $endResults->get('bahasa_arab')];
$sLughati = [$midResults->get('lughati'),        $endResults->get('lughati')];

$slots = ['amali_solat','tilawah_tahfiz','akidah','ibadah','sirah','adab','jawi_khat','bahasa_arab','lughati'];
$mSum = 0; $mN = 0; $eSum = 0; $eN = 0;
foreach ($slots as $s) {
    $m = $midResults->get($s); $e = $endResults->get($s);
    if ($m && !$m->is_absent) { $mSum += $m->marks; $mN++; }
    if ($e && !$e->is_absent) { $eSum += $e->marks; $eN++; }
}
if ($achievement->phci_midyear !== null) { $mSum += $achievement->phci_midyear; $mN++; }
if ($achievement->phci_endyear !== null) { $eSum += $achievement->phci_endyear; $eN++; }
$mPct   = $mN > 0 ? round($mSum / (10 * 100) * 100, 1) . '%' : '-';
$ePct   = $eN > 0 ? round($eSum / (10 * 100) * 100, 1) . '%' : '-';
$mTotal = $mN > 0 ? $mSum : '-';
$eTotal = $eN > 0 ? $eSum : '-';

$gender    = $student->gender === 'L' ? 'ليلاکي' : 'ڤرمڤوان';
$dob       = $student->dob ? Carbon::parse($student->dob)->format('d/m/Y') : '';
$age       = $student->dob ? Carbon::parse($student->dob)->age : ($student->age ?? '');
$prevEntry = $student->prev_entry_date ? Carbon::parse($student->prev_entry_date)->format('d/m/Y') : '';
$entryDate = $student->entry_date ? Carbon::parse($student->entry_date)->format('d/m/Y') : '';
$penjaga   = $student->father_name ?? ($student->mother_name ?? '');

// Jawi months — same array used in AttendanceController
$monthNamesJawi = [
    1  => 'جانواري',  2  => 'فيبرواري', 3  => 'مچ',
    4  => 'اڤريل',   5  => 'مي',        6  => 'جون',
    7  => 'جولاي',   8  => 'اوڬوس',     9  => 'سيڤتيمبر',
    10 => 'اوكتوبر', 11 => 'نوۏيمبر',  12 => 'ديسيمبر',
];
$bulan = ($monthNamesJawi[(int) now()->format('n')] ?? '') . ' ' . now()->format('Y');
@endphp

@if($achievement->status !== 'final')
<div class="wm">DRAF</div>
@endif

{{-- HEADER --}}
<table style="margin-bottom:3px;table-layout:fixed;">
    <tr>
        <td style="width:13%;text-align:center;border:none;vertical-align:middle;">
            <img src="{{ public_path('template/perak.png') }}" width="56" height="56" alt="">
        </td>
        <td style="text-align:center;border:none;vertical-align:middle;">
            <div style="font-size:16pt;font-weight:bold;font-family:lateef;line-height:1.2;">ريکود ڤنچاڤاين موريد</div>
            <div style="font-size:10pt;font-weight:bold;letter-spacing:1px;">REKOD PENCAPAIAN MURID</div>
            <div style="font-size:9pt;font-weight:bold;margin-top:1px;">{{ $school->name ?? 'سکوله رنده اݢام رعيت اينتݢراسي کافا' }}</div>
        </td>
        <td style="width:13%;border:none;"></td>
    </tr>
</table>
<div style="border-top:2.5px solid #000;margin-bottom:1px;"></div>
<div style="border-top:1px solid #000;margin-bottom:2px;"></div>

{{-- MAKLUMAT MURID
     9-column flat table — RTL: col1=rightmost, col9=leftmost
     Widths: 23% | 3% | 19% | 15% | 3% | 12% | 11% | 3% | 11%
--}}
<div class="sec">معلومت موريد</div>
<table class="itbl">
    <colgroup>
        <col style="width:23%"><col style="width:3%"><col style="width:19%">
        <col style="width:15%"><col style="width:3%"><col style="width:12%">
        <col style="width:11%"><col style="width:3%"><col style="width:11%">
    </colgroup>
    <tr>
        <td class="il">نام موريد</td>
        <td class="isep">:</td>
        <td class="ival" colspan="7">{{ $student->jawi_name ?: $student->name }}</td>
    </tr>
    <tr>
        <td class="il">نام سکوله</td>
        <td class="isep">:</td>
        <td class="ival" colspan="7">{{ $school->name ?? '' }}</td>
    </tr>
    <tr>
        <td class="il">نومبور سيجيل کلاهيرن</td>
        <td class="isep">:</td>
        <td class="ival" colspan="7">{{ $student->mykid ?? '' }}</td>
    </tr>
    <tr>
        <td class="il">تاريخ لاهير</td>
        <td class="isep">:</td>
        <td class="ival">{{ $dob }}</td>
        <td class="il">عمور</td>
        <td class="isep">:</td>
        <td class="ival">{{ $age }}</td>
        <td class="il">جنتينا</td>
        <td class="isep">:</td>
        <td class="ival">{{ $gender }}</td>
    </tr>
    <tr>
        <td class="il">تمڤت لاهير</td>
        <td class="isep">:</td>
        <td class="ival" colspan="7">{{ $student->birth_place ?? '' }}</td>
    </tr>
    <tr>
        <td class="il">انف کبراڤ</td>
        <td class="isep">:</td>
        <td class="ival">{{ $student->child_order ?? '' }}</td>
        <td class="il">بيلڠن اديق براديق</td>
        <td class="isep">:</td>
        <td class="ival" colspan="4">{{ $student->dependents_count ?? '' }}</td>
    </tr>
    <tr>
        <td class="il">ت. ماسوق سکوله (دهولو)</td>
        <td class="isep">:</td>
        <td class="ival">{{ $prevEntry }}</td>
        <td class="il">ت. ماسوق سکوله (سکارڠ)</td>
        <td class="isep">:</td>
        <td class="ival" colspan="4">{{ $entryDate }}</td>
    </tr>
    <tr>
        <td class="il">جارق رومه کسکوله</td>
        <td class="isep">:</td>
        <td class="ival" colspan="7">{{ $student->home_distance ?? '' }}</td>
    </tr>
    <tr>
        <td class="il">بهاس ڤرتوتورن</td>
        <td class="isep">:</td>
        <td class="ival" colspan="7">{{ $student->spoken_language ?? '' }}</td>
    </tr>
</table>

{{-- MAKLUMAT PENJAGA --}}
<div class="sec">معلومت ڤنجاݢ</div>
<table class="itbl">
    <colgroup>
        <col style="width:26%"><col style="width:3%"><col style="width:71%">
    </colgroup>
    <tr>
        <td class="il">نام ابو باڤ / ڤنجاݢ</td>
        <td class="isep">:</td>
        <td class="ival">{{ $penjaga }}</td>
    </tr>
    <tr>
        <td class="il">علامت سورت مڽورات</td>
        <td class="isep">:</td>
        <td class="ival">{{ $student->address ?? '' }}</td>
    </tr>
    <tr>
        <td></td><td></td>
        <td class="ival" style="height:16px;">&nbsp;</td>
    </tr>
    <tr>
        <td class="il">تنداتاڠن ڤنجاݢ</td>
        <td class="isep">:</td>
        <td class="ival" style="height:18px;">&nbsp;</td>
    </tr>
</table>

{{-- BUTIRAN REKOD PELAJARAN --}}
<div class="sec">بوتيرن ريکود ڤلاجرن</div>
<table class="itbl">
    <colgroup>
        <col style="width:10%"><col style="width:3%"><col style="width:18%">
        <col style="width:10%"><col style="width:3%"><col style="width:28%">
        <col style="width:10%"><col style="width:3%"><col style="width:15%">
    </colgroup>
    <tr>
        <td class="il">تاهون</td>
        <td class="isep">:</td>
        <td class="ival">{{ $achievement->academic_year }}</td>
        <td class="il">بولن</td>
        <td class="isep">:</td>
        <td class="ival">{{ $bulan }}</td>
        <td class="il">کلس</td>
        <td class="isep">:</td>
        <td class="ival">{{ $class->name ?? '' }}</td>
    </tr>
</table>

{{-- JADUAL MARKAH + PENGESAHAN --}}
<table class="mt" style="margin-top:3px;">
    <colgroup>
        <col style="width:36%"><col style="width:12%"><col style="width:12%"><col style="width:40%">
    </colgroup>
    <thead>
        <tr>
            <th class="mh">ڤرکارا</th>
            <th class="mh">مرکه ڤنوه<br>ڤرتڠهن تاهون</th>
            <th class="mh">مرکه ڤنوه<br>اخير تاهون</th>
            <th class="mh">ڤڠساحن</th>
        </tr>
    </thead>
    <tbody>
    {{-- rowspan 5: Ulasan Guru --}}
    <tr>
        <td class="ms">عملي صلاة</td>
        <td class="mv">{{ $fmt($sAmali[0]) }}</td>
        <td class="mv">{{ $fmt($sAmali[1]) }}</td>
        <td class="sig" rowspan="5" style="vertical-align:top;padding:4px 8px;">
            <div style="margin-bottom:4px;font-weight:bold;">اولسن ݢورو</div>
            <div style="font-weight:normal;font-size:9.5pt;text-align:right;line-height:1.5;">{{ $achievement->teacher_comments ?? '' }}</div>
        </td>
    </tr>
    <tr>
        <td class="ms">ڤڠحياتن چارا هيدوڤ اسلام</td>
        <td class="mv">{{ $fmtN($achievement->phci_midyear) }}</td>
        <td class="mv">{{ $fmtN($achievement->phci_endyear) }}</td>
    </tr>
    <tr>
        <td class="ms">تلاوة / تحفيظ القرءان</td>
        <td class="mv">{{ $fmt($sTilawah[0]) }}</td>
        <td class="mv">{{ $fmt($sTilawah[1]) }}</td>
    </tr>
    <tr>
        <td class="ms">عقيدة</td>
        <td class="mv">{{ $fmt($sAkidah[0]) }}</td>
        <td class="mv">{{ $fmt($sAkidah[1]) }}</td>
    </tr>
    <tr>
        <td class="ms">عباده</td>
        <td class="mv">{{ $fmt($sIbadah[0]) }}</td>
        <td class="mv">{{ $fmt($sIbadah[1]) }}</td>
    </tr>
    {{-- rowspan 3: Tandatangan Guru --}}
    <tr>
        <td class="ms">سيره</td>
        <td class="mv">{{ $fmt($sSirah[0]) }}</td>
        <td class="mv">{{ $fmt($sSirah[1]) }}</td>
        <td class="sigb" rowspan="3" style="padding:4px 8px;">
            <div style="font-weight:bold;">تنداتاڠن ݢورو</div>
            <div style="border-top:1px solid #555;margin-top:24px;padding-top:2px;font-weight:normal;font-size:9pt;">نام :</div>
            <div style="font-weight:normal;font-size:9pt;">تاريخ :</div>
        </td>
    </tr>
    <tr>
        <td class="ms">ادب</td>
        <td class="mv">{{ $fmt($sAdab[0]) }}</td>
        <td class="mv">{{ $fmt($sAdab[1]) }}</td>
    </tr>
    <tr>
        <td class="ms">جاوي / خظ</td>
        <td class="mv">{{ $fmt($sJawi[0]) }}</td>
        <td class="mv">{{ $fmt($sJawi[1]) }}</td>
    </tr>
    {{-- rowspan 3: Tandatangan Penjaga --}}
    <tr>
        <td class="ms">بهاس عرب</td>
        <td class="mv">{{ $fmt($sArab[0]) }}</td>
        <td class="mv">{{ $fmt($sArab[1]) }}</td>
        <td class="sigb" rowspan="3" style="padding:4px 8px;">
            <div style="font-weight:bold;">تنداتاڠن ڤنجاݢ</div>
            <div style="border-top:1px solid #555;margin-top:24px;padding-top:2px;font-weight:normal;font-size:9pt;">نام :</div>
            <div style="font-weight:normal;font-size:9pt;">تاريخ :</div>
        </td>
    </tr>
    <tr>
        <td class="ms">لغتي</td>
        <td class="mv">{{ $fmt($sLughati[0]) }}</td>
        <td class="mv">{{ $fmt($sLughati[1]) }}</td>
    </tr>
    <tr class="sum">
        <td class="ms">ڤراتوس</td>
        <td class="mv">{{ $mPct }}</td>
        <td class="mv">{{ $ePct }}</td>
    </tr>
    {{-- rowspan 5: Tandatangan & Cop Guru Besar --}}
    <tr class="sum">
        <td class="ms">جومله مرکه</td>
        <td class="mv">{{ $mTotal }}</td>
        <td class="mv">{{ $eTotal }}</td>
        <td class="sig" rowspan="5" style="vertical-align:middle;padding:4px 8px;">
            <div style="font-weight:bold;margin-bottom:3px;">تنداتاڠن دان چوڤ ݢورو بسر</div>
            <div class="cop">چوڤ<br>سکوله</div>
            <div style="border-top:1px solid #555;margin-top:4px;padding-top:2px;font-weight:normal;font-size:9pt;">نام :</div>
            <div style="font-weight:normal;font-size:9pt;margin-top:3px;">تاريخ :</div>
        </td>
    </tr>
    <tr>
        <td class="ms">کبرسيهن</td>
        <td class="mv" colspan="2">{{ $achievement->kebersihan ?? '-' }}</td>
    </tr>
    <tr>
        <td class="ms">کدودوکن دالم کلس</td>
        <td class="mv" colspan="2">{{ $achievement->class_rank ?? '-' }} / {{ $achievement->total_in_class ?? '-' }}</td>
    </tr>
    <tr>
        <td class="ms">کدودوکن دالم درجه</td>
        <td class="mv" colspan="2">{{ $achievement->grade_rank ?? '-' }} / {{ $achievement->total_in_grade ?? '-' }}</td>
    </tr>
    <tr>
        <td class="ms">کلاکوان</td>
        <td class="mv" colspan="2">{{ $achievement->kelakuan ?? '-' }}</td>
    </tr>
    </tbody>
</table>

<div style="text-align:center;font-size:7.5pt;color:#999;margin-top:3px;border-top:1px solid #e0e0e0;padding-top:2px;">
    Aplikasi Pengurusan KAFA Daerah Manjung (APKM) &nbsp;|&nbsp; Dijana: {{ now()->format('d/m/Y H:i') }}
</div>

</body>
</html>
