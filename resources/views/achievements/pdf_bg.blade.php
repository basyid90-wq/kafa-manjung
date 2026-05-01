<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

/* mPDF: position:fixed places element at exact page coordinates (0,0 = top-left) */
/* All coordinates in mm. A4 = 210mm × 297mm. PNG = 1946×2677px. */
/* Scale: X = px × (210/1946) = px × 0.1079 */
/*        Y = px × (297/2677) = px × 0.1109 */

/* Base font for all overlaid text */
.f {
    font-family: lateef, Arial, sans-serif;
    font-size: 9.5pt;
    color: #000;
    direction: rtl;
    text-align: right;
    line-height: 1.0;
}
.fc { text-align: center; direction: ltr; }
.fl { text-align: left; direction: ltr; }
.fb { font-weight: bold; }
.sm { font-size: 8.5pt; }
.xs { font-size: 7.5pt; }

/* DRAF watermark */
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
use App\Services\ExamService;
$examService = app(ExamService::class);

$student = $achievement->student;
$school  = $achievement->school;
$class   = $achievement->kafaClass;

$fmt = function($result) use ($examService) {
    if (!$result) return '-';
    if ($result->is_absent) return 'TH';
    return $result->marks . ' (' . $examService->calculateGrade($result->marks) . ')';
};
$fmtN = function($val) use ($examService) {
    if ($val === null) return '-';
    return $val . ' (' . $examService->calculateGrade((int)$val) . ')';
};

$gender    = $student->gender === 'L' ? 'Lelaki' : 'Perempuan';
$dob       = $student->dob ? Carbon::parse($student->dob)->format('d/m/Y') : '';
$age       = $student->dob ? Carbon::parse($student->dob)->age : ($student->age ?? '');
$prevEntry = $student->prev_entry_date ? Carbon::parse($student->prev_entry_date)->format('d/m/Y') : '';
$entryDate = $student->entry_date ? Carbon::parse($student->entry_date)->format('d/m/Y') : '';
$penjaga   = $student->father_name ?? ($student->mother_name ?? '');

$monthNamesJawi = [
    1=>'Januari', 2=>'Februari', 3=>'Mac', 4=>'April',
    5=>'Mei', 6=>'Jun', 7=>'Julai', 8=>'Ogos',
    9=>'September', 10=>'Oktober', 11=>'November', 12=>'Disember',
];
$bulan = ($monthNamesJawi[(int) now()->format('n')] ?? '') . ' ' . now()->format('Y');

// Marks
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

// PNG template path for CSS (forward slashes for mPDF)
$bgPath = str_replace('\\', '/', public_path('images/rekod-pencapaian-template.png'));

// ─── Coordinate helper ─────────────────────────────────────────────────
// Values in mm. Origin (0,0) = top-left corner of A4 page.
// All fields below are calibrated to the REKOD-PENCAPAIAN-MURID.png template.
// Adjust if needed after print test.

// SECTION Y start positions (mm from top):
$yMurid      = 19.0;   // Maklumat Murid section rows
$yPenjaga    = 67.0;   // Maklumat Penjaga section rows
$yButiran    = 91.0;   // Butiran Rekod row
$yTableStart = 103.0;  // First data row of marks table (Amali Solat)
$rowH        = 7.2;    // Height per marks table row (mm)

// X positions for marks table columns (from left edge, 0-210mm):
// RTL form: subject names on RIGHT, marks in middle, signatures on LEFT
$xMidMark  = 105.0;   // PT (pertengahan tahun) column center
$xEndMark  = 61.0;    // AT (akhir tahun) column center
$wMark     = 40.0;    // Width of each marks column

// Value field X positions for info rows:
$xValRight = 10.0;    // Starting X for right-to-left value (most values fill right portion)
$wValFull  = 130.0;   // Full width value field
$wValMid   = 55.0;    // Medium width value field
$wValSm    = 38.0;    // Small value field (age, jantina etc)
@endphp

@if($achievement->status !== 'final')
<div class="wm">DRAF</div>
@endif

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- BACKGROUND IMAGE — full page                                        --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<div style="position:fixed; top:0mm; left:0mm; width:210mm; height:297mm;">
    <img src="{{ $bgPath }}" style="width:210mm; height:297mm;" />
</div>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- MAKLUMAT MURID                                                      --}}
{{-- Row layout (RTL): label on right ~148-202mm, value fills 8-148mm   --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}

{{-- Nama Murid --}}
<div class="f" style="position:fixed; top:{{ $yMurid + 0*4.6 }}mm; left:8mm; width:138mm; font-size:9.5pt;">
    {{ $student->jawi_name ?: $student->name }}
</div>

{{-- Nama Sekolah --}}
<div class="f" style="position:fixed; top:{{ $yMurid + 1*4.6 }}mm; left:8mm; width:138mm; font-size:9pt;">
    {{ $school->name ?? '' }}
</div>

{{-- No. Sijil Kelahiran --}}
<div class="fl" style="position:fixed; top:{{ $yMurid + 2*4.6 }}mm; left:8mm; width:138mm; font-size:9.5pt;">
    {{ $student->mykid ?? '' }}
</div>

{{-- Tarikh Lahir / Umur / Jantina (same row) --}}
<div class="fl" style="position:fixed; top:{{ $yMurid + 3*4.6 }}mm; left:8mm; width:42mm; font-size:9pt;">
    {{ $dob }}
</div>
<div class="fc" style="position:fixed; top:{{ $yMurid + 3*4.6 }}mm; left:57mm; width:20mm; font-size:9pt;">
    {{ $age }}
</div>
<div class="f" style="position:fixed; top:{{ $yMurid + 3*4.6 }}mm; left:80mm; width:30mm; font-size:9pt;">
    {{ $gender }}
</div>

{{-- Tempat Lahir --}}
<div class="f" style="position:fixed; top:{{ $yMurid + 4*4.6 }}mm; left:8mm; width:138mm; font-size:9pt;">
    {{ $student->birth_place ?? '' }}
</div>

{{-- Anak ke / Bilangan adik-beradik --}}
<div class="fc" style="position:fixed; top:{{ $yMurid + 5*4.6 }}mm; left:8mm; width:30mm; font-size:9pt;">
    {{ $student->child_order ?? '' }}
</div>
<div class="fc" style="position:fixed; top:{{ $yMurid + 5*4.6 }}mm; left:80mm; width:40mm; font-size:9pt;">
    {{ $student->dependents_count ?? '' }}
</div>

{{-- T. Masuk Dahulu / T. Masuk Sekarang --}}
<div class="fl" style="position:fixed; top:{{ $yMurid + 6*4.6 }}mm; left:8mm; width:42mm; font-size:9pt;">
    {{ $prevEntry }}
</div>
<div class="fl" style="position:fixed; top:{{ $yMurid + 6*4.6 }}mm; left:80mm; width:65mm; font-size:9pt;">
    {{ $entryDate }}
</div>

{{-- Jarak Rumah --}}
<div class="f" style="position:fixed; top:{{ $yMurid + 7*4.6 }}mm; left:8mm; width:138mm; font-size:9pt;">
    {{ $student->home_distance ?? '' }}
</div>

{{-- Bahasa Pertuturan --}}
<div class="f" style="position:fixed; top:{{ $yMurid + 8*4.6 }}mm; left:8mm; width:138mm; font-size:9pt;">
    {{ $student->spoken_language ?? '' }}
</div>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- MAKLUMAT PENJAGA                                                    --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}

{{-- Nama Penjaga --}}
<div class="f" style="position:fixed; top:{{ $yPenjaga + 0*5.0 }}mm; left:8mm; width:138mm; font-size:9pt;">
    {{ $penjaga }}
</div>

{{-- Alamat --}}
<div class="f" style="position:fixed; top:{{ $yPenjaga + 1*5.0 }}mm; left:8mm; width:138mm; font-size:9pt;">
    {{ $student->address ?? '' }}
</div>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- BUTIRAN REKOD (Tahun / Bulan / Kelas)                              --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}

{{-- Kelas (rightmost in RTL → rightmost mm-wise ~148-202) --}}
<div class="fc" style="position:fixed; top:{{ $yButiran }}mm; left:155mm; width:48mm; font-size:9.5pt;">
    {{ $class->name ?? '' }}
</div>

{{-- Bulan --}}
<div class="fc" style="position:fixed; top:{{ $yButiran }}mm; left:90mm; width:50mm; font-size:9pt;">
    {{ $bulan }}
</div>

{{-- Tahun --}}
<div class="fc" style="position:fixed; top:{{ $yButiran }}mm; left:8mm; width:40mm; font-size:9.5pt;">
    {{ $achievement->academic_year }}
</div>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- JADUAL MARKAH — each row: PT col, AT col                           --}}
{{-- PT (pertengahan tahun) center: ~122mm                              --}}
{{-- AT (akhir tahun) center: ~79mm                                     --}}
{{-- Ulasan Guru: left portion 8-54mm                                   --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}

@php
// Row Y positions in the marks table
$rows = [
    'amali'   => $yTableStart + 0 * $rowH,
    'phci'    => $yTableStart + 1 * $rowH,
    'tilawah' => $yTableStart + 2 * $rowH,
    'akidah'  => $yTableStart + 3 * $rowH,
    'ibadah'  => $yTableStart + 4 * $rowH,
    'sirah'   => $yTableStart + 5 * $rowH,
    'adab'    => $yTableStart + 6 * $rowH,
    'jawi'    => $yTableStart + 7 * $rowH,
    'arab'    => $yTableStart + 8 * $rowH,
    'lughati' => $yTableStart + 9 * $rowH,
    'peratus' => $yTableStart + 10 * $rowH,
    'jumlah'  => $yTableStart + 11 * $rowH,
    'kbrshn'  => $yTableStart + 12 * $rowH,
    'ked_kls' => $yTableStart + 13 * $rowH,
    'ked_drj' => $yTableStart + 14 * $rowH,
    'klakuan' => $yTableStart + 15 * $rowH,
];
@endphp

{{-- Amali Solat --}}
<div class="fc" style="position:fixed; top:{{ $rows['amali'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sAmali[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['amali'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sAmali[1]) }}</div>

{{-- PHCI --}}
<div class="fc" style="position:fixed; top:{{ $rows['phci'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmtN($achievement->phci_midyear) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['phci'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmtN($achievement->phci_endyear) }}</div>

{{-- Tilawah/Tahfiz --}}
<div class="fc" style="position:fixed; top:{{ $rows['tilawah'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sTilawah[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['tilawah'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sTilawah[1]) }}</div>

{{-- Akidah --}}
<div class="fc" style="position:fixed; top:{{ $rows['akidah'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sAkidah[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['akidah'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sAkidah[1]) }}</div>

{{-- Ibadah --}}
<div class="fc" style="position:fixed; top:{{ $rows['ibadah'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sIbadah[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['ibadah'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sIbadah[1]) }}</div>

{{-- Sirah --}}
<div class="fc" style="position:fixed; top:{{ $rows['sirah'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sSirah[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['sirah'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sSirah[1]) }}</div>

{{-- Adab --}}
<div class="fc" style="position:fixed; top:{{ $rows['adab'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sAdab[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['adab'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sAdab[1]) }}</div>

{{-- Jawi / Khat --}}
<div class="fc" style="position:fixed; top:{{ $rows['jawi'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sJawi[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['jawi'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sJawi[1]) }}</div>

{{-- Bahasa Arab --}}
<div class="fc" style="position:fixed; top:{{ $rows['arab'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sArab[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['arab'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sArab[1]) }}</div>

{{-- Lughati / Firasat --}}
<div class="fc" style="position:fixed; top:{{ $rows['lughati'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sLughati[0]) }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['lughati'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $fmt($sLughati[1]) }}</div>

{{-- Peratus --}}
<div class="fc" style="position:fixed; top:{{ $rows['peratus'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $mPct }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['peratus'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $ePct }}</div>

{{-- Jumlah Markah --}}
<div class="fc" style="position:fixed; top:{{ $rows['jumlah'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $mTotal }}</div>
<div class="fc" style="position:fixed; top:{{ $rows['jumlah'] + 0.5 }}mm; left:{{ $xEndMark - $wMark/2 }}mm; width:{{ $wMark }}mm;">{{ $eTotal }}</div>

{{-- Kebersihan --}}
<div class="fc" style="position:fixed; top:{{ $rows['kbrshn'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark * 2 }}mm;">{{ $achievement->kebersihan ?? '-' }}</div>

{{-- Kedudukan Kelas --}}
<div class="fc" style="position:fixed; top:{{ $rows['ked_kls'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark * 2 }}mm;">{{ $achievement->class_rank ?? '-' }} / {{ $achievement->total_in_class ?? '-' }}</div>

{{-- Kedudukan Darjah --}}
<div class="fc" style="position:fixed; top:{{ $rows['ked_drj'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark * 2 }}mm;">{{ $achievement->grade_rank ?? '-' }} / {{ $achievement->total_in_grade ?? '-' }}</div>

{{-- Kelakuan --}}
<div class="fc" style="position:fixed; top:{{ $rows['klakuan'] + 0.5 }}mm; left:{{ $xMidMark - $wMark/2 }}mm; width:{{ $wMark * 2 }}mm;">{{ $achievement->kelakuan ?? '-' }}</div>

{{-- Ulasan Guru (spans 5 rows from Amali to Ibadah in the right/signature column) --}}
<div class="f sm" style="position:fixed; top:{{ $rows['amali'] + 1.0 }}mm; left:8mm; width:46mm; line-height:1.4;">
    {{ $achievement->teacher_comments ?? '' }}
</div>

{{-- Amali Solat Penilaian (bottom section) --}}
<div class="fc" style="position:fixed; top:{{ $rows['amali'] + 0.5 }}mm; left:8mm; width:46mm; font-size:8.5pt;">
    {{ $achievement->amali_solat ?? '' }}
</div>

</body>
</html>
