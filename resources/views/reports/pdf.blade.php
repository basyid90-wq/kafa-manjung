<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Profil Murid - {{ $student->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .section { margin-bottom: 25px; }
        .section-title { background: #eee; padding: 5px 10px; font-weight: bold; margin-bottom: 10px; border-left: 5px solid #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .stats-box { width: 100%; margin-bottom: 20px; }
        .stats-item { width: 33%; display: inline-block; text-align: center; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PROFIL MURID APKM</h2>
        <p>Sesi Persekolahan KAFA Manjung</p>
    </div>

    <div class="section">
        <div class="section-title">MAKLUMAT PERIBADI</div>
        <table>
            <tr>
                <td width="20%"><strong>Nama</strong></td>
                <td>{{ $student->name }}</td>
                <td width="20%"><strong>MyKid</strong></td>
                <td>{{ $student->mykid }}</td>
            </tr>
            <tr>
                <td><strong>Sekolah</strong></td>
                <td>{{ $student->school->name }}</td>
                <td><strong>Kelas</strong></td>
                <td>{{ $student->kafaClass->display_name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">RINGKASAN PRESTASI</div>
        <div class="stats-box">
            <div class="stats-item">
                <strong>Kehadiran</strong><br/>
                <span style="font-size: 18px;">{{ $data['attendance']['percentage'] }}%</span>
            </div>
            <div class="stats-item">
                <strong>Disiplin</strong><br/>
                <span style="font-size: 18px;">{{ $data['disciplinary_records']->count() }} Kes</span>
            </div>
            <div class="stats-item">
                <strong>Aktiviti</strong><br/>
                <span style="font-size: 18px;">{{ $data['activities']->count() }} Kali</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">KEPUTUSAN PEPERIKSAAN</div>
        <table>
            <thead>
                <tr>
                    <th>Peperiksaan</th>
                    <th>Subjek</th>
                    <th>Markah</th>
                    <th>Gred</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['exam_results'] as $res)
                <tr>
                    <td>{{ $res->exam->name }}</td>
                    <td>{{ $res->subject->name }}</td>
                    <td>{{ $res->score }}</td>
                    <td>
                        @php
                            $grade = 'G';
                            if($res->score >= 80) $grade = 'A';
                            elseif($res->score >= 60) $grade = 'B';
                            elseif($res->score >= 40) $grade = 'C';
                            elseif($res->score >= 30) $grade = 'D';
                        @endphp
                        {{ $grade }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">REKOD DISIPLIN</div>
        @if($data['disciplinary_records']->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tarikh</th>
                    <th>Kesalahan</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['disciplinary_records'] as $dis)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($dis->date)->format('d/m/Y') }}</td>
                    <td>{{ $dis->offense_details }}</td>
                    <td>{{ $dis->action_taken }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Tiada rekod kesalahan disiplin.</p>
        @endif
    </div>

    <div class="section">
        <div class="section-title">PENYERTAAN AKTIVITI</div>
        @if($data['activities']->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Nama Aktiviti</th>
                    <th>Tarikh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['activities'] as $act)
                <tr>
                    <td>{{ $act->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($act->date)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Tiada rekod penyertaan aktiviti.</p>
        @endif
    </div>

    <div class="footer">
        Dicetak secara automatik oleh Sistem APKM pada {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
