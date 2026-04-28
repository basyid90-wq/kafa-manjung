<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .timetable-block {
            height: 31%;
            padding: 5px;
        }
        .separator {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #6e41ff;
        }
        .logo-container {
            width: 15%;
            text-align: left;
        }
        .logo-img {
            height: 50px;
        }
        .school-info {
            width: 70%;
            text-align: center;
        }
        .school-name {
            font-size: 14pt;
            font-weight: bold;
            color: #6e41ff;
        }
        .class-name {
            font-size: 11pt;
            font-weight: bold;
        }
        .timetable-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Important for mPDF */
        }
        .timetable-table th, .timetable-table td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
            font-size: 8pt;
            overflow: hidden;
        }
        .timetable-table th {
            background-color: #f8f9fa;
            color: #6e41ff;
        }
        .time-col {
            width: 18%;
        }
        .day-col {
            width: 16.4%;
        }
        .subject-name {
            font-weight: bold;
            display: block;
        }
        .teacher-name {
            font-size: 7pt;
            color: #666;
        }
    </style>
</head>
<body>

    @for ($i = 0; $i < 3; $i++)
        <div class="timetable-block">
            <table class="header-table">
                <tr>
                    <td class="logo-container">
                        <img src="{{ $logoPath }}" class="logo-img">
                    </td>
                    <td class="school-info">
                        <div class="school-name">{{ mb_strtoupper($school->name) }}</div>
                        <div class="class-name">JADUAL WAKTU: {{ mb_strtoupper($kafaClass->display_name) }}</div>
                    </td>
                    <td class="logo-container" style="text-align: right;"></td>
                </tr>
            </table>

            <table class="timetable-table">
                <thead>
                    <tr>
                        <th class="time-col">Slot / Masa</th>
                        @foreach($days as $day)
                            <th class="day-col">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($slots as $slot)
                        <tr>
                            <td class="time-col">
                                <strong>{{ $slot->name }}</strong><br>
                                <small>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</small>
                            </td>
                            @foreach($days as $day)
                                @php
                                    $item = $timetableData[$slot->id][$day] ?? null;
                                @endphp
                                <td class="{{ $item ? 'subject-cell' : 'empty-cell' }}">
                                    @if($item)
                                        <div class="subject-name">{{ $item->subject->name }}</div>
                                        <div class="teacher-name">{{ $item->teacher->name }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($i < 2)
            <div class="separator"></div>
        @endif
    @endfor

</body>
</html>
