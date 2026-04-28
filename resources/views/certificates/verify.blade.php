<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengesahan Sijil — APKM</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        body{
            min-height:100vh;
            background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);
            display:flex;flex-direction:column;align-items:center;justify-content:center;
            font-family:'Segoe UI',Arial,sans-serif;padding:1.5rem;
        }
        .verify-card{
            background:#fff;border-radius:20px;
            box-shadow:0 20px 60px rgba(0,0,0,.4);
            max-width:520px;width:100%;overflow:hidden;
        }
        .card-header-band{
            background:linear-gradient(135deg,#1a1a2e,#16213e);
            padding:1.5rem 2rem;text-align:center;
        }
        .card-header-band img{height:36px;}
        .card-header-band p{color:rgba(255,255,255,.6);font-size:.75em;margin-top:.4rem;letter-spacing:.05em;}
        .card-body-inner{padding:2rem;}
        .badge-valid{
            display:flex;align-items:center;justify-content:center;gap:.6rem;
            background:rgba(40,167,69,.1);border:1.5px solid rgba(40,167,69,.35);
            border-radius:50px;padding:.55rem 1.4rem;
            color:#1a8f3e;font-weight:700;font-size:.95em;
            margin-bottom:1.5rem;
        }
        .badge-invalid{
            display:flex;align-items:center;justify-content:center;gap:.6rem;
            background:rgba(220,53,69,.1);border:1.5px solid rgba(220,53,69,.3);
            border-radius:50px;padding:.55rem 1.4rem;
            color:#c9303e;font-weight:700;font-size:.95em;
            margin-bottom:1.5rem;
        }
        .badge-icon{font-size:1.3em;}
        .student-name{font-size:1.3em;font-weight:800;color:#1a1a2e;line-height:1.25;}
        .jawi-name{font-size:1.1em;color:#555;margin-top:.2rem;direction:rtl;}
        .divider{border:0;border-top:1px solid #eee;margin:1.2rem 0;}
        .detail-row{display:flex;gap:.75rem;align-items:flex-start;margin-bottom:.75rem;}
        .detail-icon{color:#6c63ff;flex-shrink:0;margin-top:.15rem;}
        .detail-label{font-size:.75em;color:#999;text-transform:uppercase;letter-spacing:.04em;line-height:1;}
        .detail-value{font-size:.9em;color:#222;font-weight:600;line-height:1.3;margin-top:.15rem;}
        .footer-stamp{
            background:#f8f9fa;border-top:1px solid #eee;
            padding:1rem 2rem;text-align:center;
            font-size:.72em;color:#aaa;line-height:1.6;
        }
        .ref-pill{
            display:inline-block;background:#eef0f8;border-radius:6px;
            padding:.2rem .6rem;font-family:monospace;font-size:.8em;
            color:#444;letter-spacing:.06em;margin-top:.3rem;
        }
        @media(max-width:480px){
            .card-body-inner{padding:1.5rem 1.25rem;}
            .card-header-band{padding:1.2rem 1.25rem;}
        }
    </style>
</head>
<body>

@if(!$cert)
{{-- ══ SIJIL TIDAK SAH ══ --}}
<div class="verify-card">
    <div class="card-header-band">
        <p>SISTEM PENGURUSAN KAFA DAERAH MANJUNG (APKM)</p>
    </div>
    <div class="card-body-inner text-center">
        <div class="badge-invalid mx-auto" style="max-width:280px;">
            <span class="badge-icon">⚠️</span> SIJIL TIDAK SAH
        </div>
        <p style="color:#555;font-size:.9em;line-height:1.7;">
            Nombor rujukan <strong>{{ request()->route('refNo') }}</strong> tidak wujud dalam pangkalan data.
            Sijil ini mungkin tidak sah, telah dipinda, atau tidak dikeluarkan oleh sistem ini.
        </p>
        <p style="color:#aaa;font-size:.78em;margin-top:1rem;">
            Sekiranya anda percaya ini adalah kesilapan, sila hubungi pihak sekolah berkenaan.
        </p>
    </div>
    <div class="footer-stamp">
        Pengesahan Digital oleh: Sistem Pengurusan KAFA Daerah Manjung (APKM)<br>
        {{ now()->format('d/m/Y H:i') }} • Dokumen ini dijana secara automatik
    </div>
</div>

@else
{{-- ══ SIJIL SAH ══ --}}
@php
    $student  = $cert->student;
    $school   = $student?->school;
    // Mask last 4 of MyKid: 120304-08-**** (keep prefix, mask last 4 digits)
    $mykid    = $student?->mykid ?? '';
    $maskedIc = strlen($mykid) > 4
        ? substr($mykid, 0, -4) . '****'
        : str_repeat('*', strlen($mykid));
    $program  = $cert->activity?->name ?? $cert->exam?->name ?? $cert->template?->name ?? '—';
    $examDate = $cert->activity?->date ? \Carbon\Carbon::parse($cert->activity->date)->format('d/m/Y') : null;
@endphp

<div class="verify-card">
    <div class="card-header-band">
        <p>SISTEM PENGURUSAN KAFA DAERAH MANJUNG (APKM)</p>
    </div>

    <div class="card-body-inner">
        <div class="badge-valid">
            <span class="badge-icon">✅</span> SIJIL SAH / VERIFIED
        </div>

        <div class="text-center mb-3">
            <div class="student-name">{{ $student?->name ?? '—' }}</div>
            @if($student?->jawi_name)
            <div class="jawi-name" style="font-family:'Noto Naskh Arabic',serif;">{{ $student->jawi_name }}</div>
            @endif
        </div>

        <hr class="divider">

        <div class="detail-row">
            <div class="detail-icon">🪪</div>
            <div>
                <div class="detail-label">No. MyKid (disamarkan)</div>
                <div class="detail-value">{{ $maskedIc ?: '—' }}</div>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-icon">🏆</div>
            <div>
                <div class="detail-label">Nama Sijil / Program</div>
                <div class="detail-value">{{ $cert->template?->name ?? '—' }}</div>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-icon">📋</div>
            <div>
                <div class="detail-label">Aktiviti / Peperiksaan</div>
                <div class="detail-value">
                    {{ $program }}
                    @if($examDate)
                    <span style="font-weight:400;color:#888;font-size:.85em;"> — {{ $examDate }}</span>
                    @endif
                </div>
            </div>
        </div>

        @if($cert->exam)
        @php
            $examResults = \App\Models\ExamResult::where('student_id', $student?->id)
                ->where('exam_id', $cert->exam_id)
                ->with('subject')
                ->get();
            $avg = $examResults->avg('marks');
        @endphp
        @if($examResults->isNotEmpty())
        <div class="detail-row">
            <div class="detail-icon">📊</div>
            <div>
                <div class="detail-label">Keputusan Peperiksaan</div>
                @foreach($examResults as $r)
                <div class="detail-value" style="margin-bottom:.2rem;">
                    {{ $r->subject?->name ?? '—' }}: <strong>{{ $r->marks ?? '—' }}</strong> ({{ $r->grade ?? '—' }})
                </div>
                @endforeach
                @if($avg !== null)
                <div style="font-size:.78em;color:#888;margin-top:.2rem;">
                    Purata: {{ round($avg, 1) }}
                </div>
                @endif
            </div>
        </div>
        @endif
        @endif

        <div class="detail-row">
            <div class="detail-icon">🏫</div>
            <div>
                <div class="detail-label">Dikeluarkan Oleh</div>
                <div class="detail-value">{{ $school?->name ?? '—' }}</div>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-icon">📅</div>
            <div>
                <div class="detail-label">Tarikh Dikeluarkan</div>
                <div class="detail-value">{{ $cert->issue_date?->format('d/m/Y') ?? '—' }}</div>
            </div>
        </div>

        <div class="text-center mt-3">
            <div class="detail-label mb-1">No. Rujukan Digital</div>
            <span class="ref-pill">{{ $cert->reference_no }}</span>
        </div>
    </div>

    <div class="footer-stamp">
        ✅ Pengesahan Digital oleh: <strong>Sistem Pengurusan KAFA Daerah Manjung (APKM)</strong><br>
        Disemak pada: {{ now()->format('d/m/Y H:i') }} • Laman ini dijana secara automatik
    </div>
</div>
@endif

</body>
</html>
