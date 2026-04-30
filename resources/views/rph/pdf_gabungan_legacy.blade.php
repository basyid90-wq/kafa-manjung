<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>RPH Gabungan</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'lateef', sans-serif;
    font-size: 10pt;
    color: #000;
}

/* ── TAJUK ─────────────────────────────── */
.tajuk {
    text-align: center;
    font-size: 16pt;
    font-weight: bold;
    border-bottom: 2px double #000;
    padding-bottom: 5px;
    margin-bottom: 8px;
}
.tajuk-jawi {
    font-size: 18pt;
    direction: rtl;
    margin-bottom: 3px;
}

/* ── MAKLUMAT SEKOLAH ─────────────────── */
.info-sekolah {
    margin-bottom: 10px;
    font-size: 9pt;
}
.info-sekolah table {
    width: 100%;
    border-collapse: collapse;
}
.info-sekolah td {
    padding: 3px 5px;
}
.info-sekolah .label {
    font-weight: bold;
    width: 25%;
}
.info-sekolah .value {
    border-bottom: 1px solid #000;
}

/* ── JADUAL UTAMA (3 KOLOM) ─────────────────── */
.jadual-gabungan {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.jadual-gabungan th,
.jadual-gabungan td {
    border: 1px solid #000;
    padding: 8px;
    vertical-align: top;
    text-align: center;
}
.jadual-gabungan th {
    background-color: #e0e0e0;
    font-weight: bold;
    font-size: 11pt;
}
.jadual-gabungan .label-col {
    width: 20%;
    background-color: #f5f5f5;
    font-weight: bold;
    text-align: left;
}
.jadual-gabungan .content-col {
    text-align: left;
    white-space: pre-wrap;
    word-wrap: break-word;
}

/* ── TANDATANGAN ─────────────────── */
.tandatangan {
    margin-top: 20px;
    width: 100%;
}
.tandatangan table {
    width: 100%;
    border-collapse: collapse;
}
.tandatangan td {
    width: 50%;
    padding: 10px;
    vertical-align: top;
}
.ttd-box {
    text-align: center;
}
.ttd-line {
    border-top: 1px solid #000;
    width: 200px;
    margin: 40px auto 5px auto;
}
</style>
</head>
<body>

{{-- TAJUK --}}
<div class="tajuk">
    <div class="tajuk-jawi">ريكود ڤڠاجرن هاريان (كلس ݢابوڠن)</div>
    <div>REKOD PENGAJARAN HARIAN (KELAS GABUNGAN)</div>
</div>

{{-- MAKLUMAT SEKOLAH --}}
<div class="info-sekolah">
    <table>
        <tr>
            <td class="label">Nama Sekolah:</td>
            <td class="value">{{ $rph->school->name ?? '-' }}</td>
            <td class="label">Tarikh:</td>
            <td class="value">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Nama Guru:</td>
            <td class="value">{{ $rph->user->name ?? '-' }}</td>
            <td class="label">Hari:</td>
            <td class="value">{{ $rph->hari }} ({{ $hariJawi[$rph->hari] ?? '' }})</td>
        </tr>
        <tr>
            <td class="label">Kelas Gabungan:</td>
            <td class="value">{{ $rph->getCombinedYearsLabel() }}</td>
            <td class="label">Minggu:</td>
            <td class="value">{{ $rph->week }}</td>
        </tr>
        <tr>
            <td class="label">Mata Pelajaran:</td>
            <td class="value">{{ $rph->mata_pelajaran ?? '-' }}</td>
            <td class="label">Masa:</td>
            <td class="value">{{ $rph->masa ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Topik:</td>
            <td class="value" colspan="3">{{ $rph->topic ?? '-' }}</td>
        </tr>
    </table>
</div>

{{-- JADUAL UTAMA --}}
<table class="jadual-gabungan">
    <thead>
        <tr>
            <th class="label-col">BAHAGIAN</th>
            @foreach($rph->combined_years as $year)
                <th>TAHUN {{ $year }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{-- OBJEKTIF PEMBELAJARAN --}}
        <tr>
            <td class="label-col">Objektif Pembelajaran</td>
            @foreach($rph->combined_years as $year)
                <td class="content-col">{{ $rph->objectives_by_year[$year] ?? '-' }}</td>
            @endforeach
        </tr>

        {{-- STANDARD PEMBELAJARAN --}}
        <tr>
            <td class="label-col">Standard Pembelajaran</td>
            @foreach($rph->combined_years as $year)
                <td class="content-col">{{ $rph->standards_by_year[$year] ?? '-' }}</td>
            @endforeach
        </tr>

        {{-- AKTIVITI P&P --}}
        <tr>
            <td class="label-col">Aktiviti Pengajaran & Pembelajaran</td>
            @foreach($rph->combined_years as $year)
                <td class="content-col">{{ $rph->activities_by_year[$year] ?? '-' }}</td>
            @endforeach
        </tr>

        {{-- PENILAIAN --}}
        <tr>
            <td class="label-col">Penilaian</td>
            @foreach($rph->combined_years as $year)
                <td class="content-col">{{ $rph->assessment_by_year[$year] ?? '-' }}</td>
            @endforeach
        </tr>
    </tbody>
</table>

{{-- TANDATANGAN --}}
<div class="tandatangan">
    <table>
        <tr>
            <td>
                <div class="ttd-box">
                    <p><strong>Disediakan oleh:</strong></p>
                    <div class="ttd-line"></div>
                    <p>{{ $rph->user->name ?? '-' }}</p>
                    <p style="font-size:9pt;">(Guru KAFA)</p>
                </div>
            </td>
            <td>
                <div class="ttd-box">
                    <p><strong>Disahkan oleh:</strong></p>
                    <div class="ttd-line"></div>
                    <p>{{ $rph->reviewer->name ?? '______________________' }}</p>
                    <p style="font-size:9pt;">(Guru Besar)</p>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
