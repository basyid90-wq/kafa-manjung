<!DOCTYPE html>
<html lang="ms" dir="rtl">
<head>
<meta charset="UTF-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: lateef, dejavusans, Arial;
    font-size: 9pt;
    color: #111;
    direction: rtl;
}

/* ── Header ── */
.header {
    text-align: center;
    margin-bottom: 5px;
    direction: rtl;
}
.header h2 {
    font-size: 12pt;
    font-weight: 700;
    margin-bottom: 2px;
    font-family: lateef;
}
.header h3 {
    font-size: 9.5pt;
    font-weight: 400;
    color: #333;
    font-family: lateef;
}

/* ── Grid table ── */
table.grid {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    direction: rtl;
}

table.grid th,
table.grid td {
    border: 0.5pt solid #777;
    padding: 2px 1px;
    text-align: center;
    vertical-align: middle;
    overflow: hidden;
}

.col-no   { width: 18pt; font-family: dejavusans; }
.col-nama { width: 90pt; text-align: right; padding-right: 3px; font-family: dejavusans, lateef; }
.col-day  { font-size: 7pt; font-family: dejavusans; }
.col-jum  { width: 20pt; font-weight: 700; font-family: dejavusans; }

thead th {
    background: #e8eaf0;
    font-weight: 700;
    font-size: 7.5pt;
}
thead th.col-nama { font-family: lateef; font-size: 8pt; }
thead th.col-no   { font-family: lateef; font-size: 8pt; }
thead th.col-jum  { font-family: lateef; font-size: 8pt; }

th.day-blank, td.day-blank {
    background: #ddd;
    color: #bbb;
    font-size: 6pt;
}

td.mark-hadir  { color: #1a5c1a; font-weight: 700; }
td.mark-lewat  { color: #7a3300; font-weight: 700; }
td.mark-absent { color: #b00000; font-weight: 700; }

tbody tr:nth-child(even) { background: #f7f8fc; }
tbody tr:nth-child(even) td.day-blank { background: #d5d5d5; }

/* ── Summary table ── */
table.rumusan {
    width: 55%;
    border-collapse: collapse;
    margin-top: 8px;
    direction: rtl;
    float: right;
}

table.rumusan td {
    border: 0.5pt solid #888;
    padding: 2px 5px;
    font-size: 8.5pt;
    vertical-align: middle;
}

table.rumusan td.lbl {
    font-family: lateef;
    font-size: 9.5pt;
    text-align: right;
    background: #f0f0f0;
    width: 75%;
}

table.rumusan td.val {
    font-family: dejavusans;
    font-weight: 700;
    text-align: center;
    width: 25%;
}

/* ── Legend ── */
.legend {
    margin-top: 8px;
    font-size: 7.5pt;
    color: #444;
    direction: rtl;
    font-family: dejavusans, lateef;
    clear: both;
}
.legend span { margin-left: 14px; }

/* ── Footer ── */
.footer {
    margin-top: 6px;
    font-size: 7pt;
    color: #777;
    text-align: left;
    direction: ltr;
    font-family: dejavusans;
}
</style>
</head>
<body>

<div class="header">
    <h2>بوكو كداتغن مريد</h2>
    <h3>
        {{ $kafaClass->display_name }}
        &nbsp;&bull;&nbsp;
        {{ $school->name }}
        &nbsp;&bull;&nbsp;
        {{ $monthNameJawi }}
    </h3>
</div>

{{-- ── Grid 31 Hari ── --}}
<table class="grid">
    <thead>
        <tr>
            <th class="col-no">بل</th>
            <th class="col-nama">نام مريد</th>
            @for($d = 1; $d <= 31; $d++)
                @if($d <= $daysInMonth)
                    <th class="col-day">{{ $d }}</th>
                @else
                    <th class="col-day day-blank"></th>
                @endif
            @endfor
            <th class="col-jum">جمله</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $i => $student)
        @php
            $studentRecs = $records->get($student->id) ?? collect();
            $jumlah = 0;
        @endphp
        <tr>
            <td class="col-no">{{ $i + 1 }}</td>
            <td class="col-nama">{{ $student->jawi_name ?: $student->name }}</td>

            @for($d = 1; $d <= 31; $d++)
                @if($d <= $daysInMonth)
                    @php
                        $rec = $studentRecs->get($d);
                        if ($rec) {
                            if ($rec->status === 'Hadir') {
                                $mark = '/'; $cls = 'mark-hadir'; $jumlah++;
                            } elseif ($rec->status === 'Lewat') {
                                $mark = 'L'; $cls = 'mark-lewat'; $jumlah++;
                            } else {
                                $mark = 'O'; $cls = 'mark-absent';
                            }
                        } else {
                            $mark = ''; $cls = '';
                        }
                    @endphp
                    <td class="col-day {{ $cls }}">{{ $mark }}</td>
                @else
                    <td class="col-day day-blank"></td>
                @endif
            @endfor

            <td class="col-jum">{{ $jumlah }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- ── Jadual Rumusan Rasmi (Jawi) ── --}}
@php
    $bil_sedia_ada_display = $bil_bulan_lepas;
@endphp
<table class="rumusan">
    <tr>
        <td class="lbl">بلاڠن دالم دفتر ڤد اخير بولن سوده</td>
        <td class="val">{{ $bil_sedia_ada_display }}</td>
    </tr>
    <tr>
        <td class="lbl">بلاڠن ماسوق</td>
        <td class="val">{{ $murid_masuk }}</td>
    </tr>
    <tr>
        <td class="lbl">بلاڠن كلوار</td>
        <td class="val">{{ $murid_keluar }}</td>
    </tr>
    <tr>
        <td class="lbl">بلاڠن دالم دفتر قد اخير بولن اين</td>
        <td class="val">{{ $bil_terkini }}</td>
    </tr>
    <tr>
        <td class="lbl">جمله كداتڠن يڠ سبنر</td>
        <td class="val">{{ $kedatangan_sebenar }}</td>
    </tr>
    <tr>
        <td class="lbl">جمله كداتڠن يڠ سفاتوتڽ &nbsp;({{ $bil_terkini }} &times; {{ $totalDays }} هاري)</td>
        <td class="val">{{ $kedatangan_sepatutnya }}</td>
    </tr>
    <tr>
        <td class="lbl">ڤراتوس كداتڠن</td>
        <td class="val">{{ number_format($peratus, 1) }}%</td>
    </tr>
    <tr>
        <td class="lbl">ڤوراة كداتڠن</td>
        <td class="val">{{ $purata }}</td>
    </tr>
</table>

<div class="legend">
    <span><strong>/</strong> = Hadir</span>
    <span><strong>L</strong> = Lewat</span>
    <span><strong>O</strong> = Tidak Hadir</span>
    <span style="color:#999;">&#9632;</span> = Tiada rekod
</div>

<div class="footer">
    Dijana: {{ now()->format('d/m/Y H:i') }}
</div>

</body>
</html>
