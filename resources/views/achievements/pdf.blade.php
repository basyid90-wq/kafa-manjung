<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: Arial, sans-serif; font-size: 10pt; color: #000; }

.page { width: 100%; }

/* Header */
.header-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
.header-table td { vertical-align: middle; padding: 2px 4px; }
.logo-cell { width: 70px; text-align: center; }
.logo-cell img { width: 60px; height: 60px; }
.title-cell { text-align: center; }
.title-cell h1 { font-size: 13pt; font-weight: bold; margin-bottom: 2px; }
.title-cell h2 { font-size: 11pt; font-weight: bold; }
.title-cell p  { font-size: 9pt; }

hr.thick { border: 2px solid #000; margin: 4px 0; }
hr.thin  { border: 1px solid #000; margin: 3px 0; }

/* Info table */
.info-table { width: 100%; border-collapse: collapse; margin: 6px 0; font-size: 9.5pt; }
.info-table td { padding: 2px 4px; }
.info-table .label { width: 38%; }
.info-table .colon { width: 3%; }
.info-table .value { border-bottom: 1px solid #333; width: 59%; }

/* Section heading */
.section-heading {
    background: #003087;
    color: #fff;
    text-align: center;
    font-weight: bold;
    font-size: 10pt;
    padding: 3px 6px;
    margin: 6px 0 3px 0;
}

/* Marks table */
.marks-table { width: 100%; border-collapse: collapse; font-size: 9pt; margin-bottom: 4px; }
.marks-table th, .marks-table td { border: 1px solid #444; padding: 3px 5px; text-align: center; }
.marks-table th { background: #dde3ef; font-weight: bold; }
.marks-table td.subject { text-align: left; }
.marks-table tr.total-row { background: #f0f0f0; font-weight: bold; }

/* Bottom section */
.bottom-section { margin-top: 6px; font-size: 9pt; }
.bottom-table { width: 100%; border-collapse: collapse; }
.bottom-table td { vertical-align: top; padding: 2px 4px; }

/* Signature area */
.sig-table { width: 100%; border-collapse: collapse; margin-top: 14px; font-size: 9pt; }
.sig-table td { text-align: center; padding: 2px 6px; width: 33%; }
.sig-line { border-top: 1px solid #000; margin-top: 36px; padding-top: 3px; }

/* Grade legend */
.legend { font-size: 8pt; margin: 4px 0; border: 1px solid #999; padding: 3px 6px; }
.legend span { margin-right: 10px; }

/* Behaviour boxes */
.behav-table { width: 100%; border-collapse: collapse; font-size: 9pt; }
.behav-table td { border: 1px solid #444; padding: 3px 6px; }
.behav-table th { background: #dde3ef; border: 1px solid #444; padding: 3px 6px; font-weight: bold; }

/* Rank box */
.rank-box { border: 1px solid #444; padding: 4px 8px; font-size: 9pt; display: inline-block; margin: 3px 4px; }
</style>
</head>
<body>
<div class="page">

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('template/perak.png') }}" alt="Logo">
            </td>
            <td class="title-cell">
                <h1>REKOD PENCAPAIAN MURID</h1>
                <h2>KELAS AGAMA FARDHU AIN (KAFA)</h2>
                <p>{{ $achievement->school->name ?? '' }} &nbsp;|&nbsp; Tahun {{ $achievement->academic_year }}</p>
            </td>
            <td style="width:70px;"></td>
        </tr>
    </table>
    <hr class="thick">

    {{-- Maklumat Murid --}}
    @php
    $student = $achievement->student;
    $class   = $achievement->kafaClass;
    $school  = $achievement->school;

    $formSlotLabels = [
        'tilawah_tahfiz' => 'Tilawah & Tahfiz Al-Quran',
        'lughati'        => 'Lughati (Lughatul Quran)',
        'ibadah'         => 'Ibadah',
        'akidah'         => 'Akidah',
        'sirah'          => 'Sirah & Tamadun Islam',
        'adab'           => 'Adab & Akhlak',
        'jawi_khat'      => 'Jawi & Khat',
        'bahasa_arab'    => 'Bahasa Arab',
        'amali_solat'    => 'Amali Solat',
    ];
    $allSlots = array_keys($formSlotLabels);

    $midTotals = ['sum' => 0, 'count' => 0];
    $endTotals = ['sum' => 0, 'count' => 0];
    @endphp

    <table class="info-table">
        <tr>
            <td class="label">Nama Murid (Rumi)</td>
            <td class="colon">:</td>
            <td class="value">{{ strtoupper($student->name) }}</td>
            <td class="label">No. Kad Pengenalan</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->mykid }}</td>
        </tr>
        <tr>
            <td class="label">Nama Murid (Jawi)</td>
            <td class="colon">:</td>
            <td class="value" dir="rtl" style="font-family:lateef,Arial;font-size:12pt;">{{ $student->jawi_name }}</td>
            <td class="label">Jantina</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->gender === 'L' ? 'Lelaki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="colon">:</td>
            <td class="value">{{ $class->name ?? '-' }}</td>
            <td class="label">Tarikh Lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Sekolah</td>
            <td class="colon">:</td>
            <td class="value">{{ $school->name ?? '-' }}</td>
            <td class="label">Tempat Lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->birth_place ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nama Bapa/Penjaga</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->father_name ?? '-' }}</td>
            <td class="label">No. IC Bapa/Penjaga</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->father_ic ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nama Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->mother_name ?? '-' }}</td>
            <td class="label">No. IC Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $student->mother_ic ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value" colspan="3">{{ $student->address ?? '-' }}</td>
        </tr>
    </table>

    <hr class="thin">

    {{-- Markah Peperiksaan --}}
    <div class="section-heading">REKOD MARKAH PEPERIKSAAN</div>

    <table class="marks-table">
        <thead>
            <tr>
                <th style="width:5%">Bil.</th>
                <th style="width:38%;text-align:left;">Mata Pelajaran</th>
                <th style="width:19%">Pertengahan Tahun<br><small>({{ $achievement->midyearExam->name ?? '-' }})</small></th>
                <th style="width:19%">Akhir Tahun<br><small>({{ $achievement->endyearExam->name ?? '-' }})</small></th>
            </tr>
        </thead>
        <tbody>
            @foreach($allSlots as $i => $slot)
            @php
                $midR = $midResults->get($slot);
                $endR = $endResults->get($slot);

                if ($midR) {
                    if ($midR->is_absent) {
                        $midVal = 'TH';
                    } else {
                        $midVal = $examService->formatMark($midR->marks);
                        $midTotals['sum']   += $midR->marks;
                        $midTotals['count'] += 1;
                    }
                } else {
                    $midVal = '-';
                }

                if ($endR) {
                    if ($endR->is_absent) {
                        $endVal = 'TH';
                    } else {
                        $endVal = $examService->formatMark($endR->marks);
                        $endTotals['sum']   += $endR->marks;
                        $endTotals['count'] += 1;
                    }
                } else {
                    $endVal = '-';
                }
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="subject">{{ $formSlotLabels[$slot] }}</td>
                <td>{{ $midVal }}</td>
                <td>{{ $endVal }}</td>
            </tr>
            @endforeach

            {{-- PHCI --}}
            @php
                $phciMidVal = $achievement->phci_midyear !== null ? $examService->formatMark($achievement->phci_midyear) : '-';
                $phciEndVal = $achievement->phci_endyear !== null ? $examService->formatMark($achievement->phci_endyear) : '-';
                if ($achievement->phci_midyear !== null) {
                    $midTotals['sum']   += $achievement->phci_midyear;
                    $midTotals['count'] += 1;
                }
                if ($achievement->phci_endyear !== null) {
                    $endTotals['sum']   += $achievement->phci_endyear;
                    $endTotals['count'] += 1;
                }
            @endphp
            <tr>
                <td>{{ count($allSlots) + 1 }}</td>
                <td class="subject">Penghayatan Cara Hidup Islam (PHCI)</td>
                <td>{{ $phciMidVal }}</td>
                <td>{{ $phciEndVal }}</td>
            </tr>

            {{-- Jumlah --}}
            @php
                $nSubjects = count($allSlots) + 1; // +1 for PHCI
                $midTotal   = $midTotals['count'] > 0 ? $midTotals['sum'] : '-';
                $midPercent = $midTotals['count'] > 0
                    ? round($midTotals['sum'] / ($midTotals['count'] * 100) * 100, 1) . '%'
                    : '-';
                $endTotal   = $endTotals['count'] > 0 ? $endTotals['sum'] : '-';
                $endPercent = $endTotals['count'] > 0
                    ? round($endTotals['sum'] / ($endTotals['count'] * 100) * 100, 1) . '%'
                    : '-';
            @endphp
            <tr class="total-row">
                <td colspan="2" class="subject">Jumlah Markah (Daripada {{ $nSubjects * 100 }})</td>
                <td>{{ $midTotal }}</td>
                <td>{{ $endTotal }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" class="subject">Peratus (%)</td>
                <td>{{ $midPercent }}</td>
                <td>{{ $endPercent }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Grade legend --}}
    <div class="legend">
        <strong>Skala Gred:</strong>
        <span>A = 80–100 (Cemerlang)</span>
        <span>B = 60–79 (Baik)</span>
        <span>C = 40–59 (Memuaskan)</span>
        <span>D = 0–39 (Lemah)</span>
        <span>TH = Tidak Hadir</span>
    </div>

    {{-- Kelakuan, Kebersihan & Kedudukan --}}
    <hr class="thin">
    <div class="section-heading">PENILAIAN & KEDUDUKAN</div>

    <table class="bottom-table">
        <tr>
            <td style="width:50%;">
                <table class="behav-table">
                    <tr>
                        <th colspan="2">Penilaian Tingkah Laku</th>
                    </tr>
                    <tr>
                        <td>Kelakuan</td>
                        <td style="text-align:center; font-weight:bold;">{{ $achievement->kelakuan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Kebersihan</td>
                        <td style="text-align:center; font-weight:bold;">{{ $achievement->kebersihan ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width:50%; text-align:center; vertical-align:middle;">
                <div style="font-size:9pt; font-weight:bold; margin-bottom:4px;">Kedudukan</div>
                <div class="rank-box">
                    Kelas: <strong>{{ $achievement->class_rank ?? '-' }}</strong> / {{ $achievement->total_in_class ?? '-' }}
                </div>
                <div class="rank-box">
                    Darjah: <strong>{{ $achievement->grade_rank ?? '-' }}</strong> / {{ $achievement->total_in_grade ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Ulasan Guru --}}
    <hr class="thin" style="margin-top:6px;">
    <div class="section-heading">ULASAN GURU</div>
    <div style="border: 1px solid #999; min-height: 40px; padding: 5px 8px; font-size: 9.5pt;">
        {{ $achievement->teacher_comments ?? '' }}
    </div>

    {{-- Signatures --}}
    <table class="sig-table">
        <tr>
            <td>
                <div class="sig-line">Tandatangan Guru KAFA</div>
                <div style="margin-top:3px;">Nama: _______________________</div>
                <div>Tarikh: ______________________</div>
            </td>
            <td>
                <div class="sig-line">Disahkan oleh Guru Besar</div>
                <div style="margin-top:3px;">Nama: _______________________</div>
                <div>Tarikh: ______________________</div>
                @if($school && $school->logo)
                <div style="margin-top:6px;text-align:center;">
                    <img src="{{ public_path('storage/' . $school->logo) }}" style="height:45px;" alt="cop">
                </div>
                @endif
            </td>
            <td>
                <div class="sig-line">Tandatangan Ibu Bapa/Penjaga</div>
                <div style="margin-top:3px;">Nama: _______________________</div>
                <div>Tarikh: ______________________</div>
            </td>
        </tr>
    </table>

    {{-- Footer --}}
    <hr class="thin" style="margin-top:8px;">
    <div style="text-align:center; font-size:8pt; color:#555; margin-top:3px;">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) &nbsp;|&nbsp; Dijana pada: {{ now()->format('d/m/Y H:i') }}
    </div>

</div>
</body>
</html>
