@extends('layout.layout')

@php $bodyClass = ''; $footer = 'true'; @endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">

                        {{-- Header Profil --}}
                        <div class="d-flex align-items-center gap-4 mb--30 flex-wrap">
                            {{-- Avatar --}}
                            @if($student->profile_picture)
                                <img src="{{ asset('storage/' . $student->profile_picture) }}"
                                     alt="{{ $student->name }}"
                                     style="width:80px;height:80px;object-fit:cover;border-radius:50%;border:3px solid #eef0f8;flex-shrink:0;">
                            @else
                                <div style="width:80px;height:80px;border-radius:50%;
                                            background:linear-gradient(135deg,#1a1a2e,#6c63ff);
                                            display:flex;align-items:center;justify-content:center;
                                            font-size:2rem;color:white;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(mb_substr($student->name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="flex-grow-1">
                                <h4 class="rbt-title-style-3 mb-0">{{ $student->name }}</h4>
                                @if($student->jawi_name)
                                <div dir="rtl" style="font-family:'Lateef',serif;font-size:1.15em;color:#555;line-height:1.4;">
                                    {{ $student->jawi_name }}
                                </div>
                                @endif
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <span class="rbt-badge-5 bg-primary-opacity color-primary" style="font-size:0.78em;">
                                        <i class="feather-home me-1"></i>{{ $student->school->name ?? '—' }}
                                    </span>
                                    <span class="rbt-badge-5 bg-secondary-opacity color-secondary" style="font-size:0.78em;">
                                        <i class="feather-book me-1"></i>{{ $student->kafaClass->display_name ?? '—' }}
                                    </span>
                                    @php $statusColor = $student->status === 'Aktif' ? 'success' : 'warning'; @endphp
                                    <span class="rbt-badge-5 bg-{{ $statusColor }}-opacity color-{{ $statusColor }}" style="font-size:0.78em;">
                                        {{ $student->status ?? 'Aktif' }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('parent.dashboard') }}"
                               class="rbt-btn btn-border-gradient btn-sm align-self-start">
                                <i class="feather-arrow-left me-1"></i>Kembali
                            </a>
                        </div>

                        {{-- Nav Tabs --}}
                        <ul class="nav nav-tabs rbt-default-tab mb--25" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-info" data-bs-toggle="tab"
                                        data-bs-target="#pane-info" type="button" role="tab">
                                    <i class="feather-user me-1"></i>Maklumat & Kehadiran
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-exam" data-bs-toggle="tab"
                                        data-bs-target="#pane-exam" type="button" role="tab">
                                    <i class="feather-bar-chart-2 me-1"></i>Prestasi Akademik
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-cert" data-bs-toggle="tab"
                                        data-bs-target="#pane-cert" type="button" role="tab">
                                    <i class="feather-award me-1"></i>Sijil Pencapaian
                                    @if($certificates->isNotEmpty())
                                    <span class="badge bg-primary ms-1" style="font-size:0.7em;">{{ $certificates->count() }}</span>
                                    @endif
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="profileTabContent">

                            {{-- ══ TAB 1: MAKLUMAT ASAS & KEHADIRAN ══ --}}
                            <div class="tab-pane fade show active" id="pane-info" role="tabpanel">

                                <div class="row g-4 mb--25">
                                    <div class="col-md-6">
                                        <h6 class="rbt-title-style-2 mb--15">Maklumat Peribadi</h6>
                                        <table class="table table-sm table-borderless" style="font-size:0.88em;">
                                            <tbody>
                                                <tr><td class="color-body" width="140">No. MyKid</td><td><strong>{{ $student->mykid }}</strong></td></tr>
                                                <tr><td class="color-body">Tarikh Lahir</td><td>{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d/m/Y') : '—' }}</td></tr>
                                                <tr><td class="color-body">Jantina</td><td>{{ $student->gender ?? '—' }}</td></tr>
                                                <tr><td class="color-body">Bangsa</td><td>{{ $student->race ?? '—' }}</td></tr>
                                                <tr><td class="color-body">Sekolah</td><td>{{ $student->school->name ?? '—' }}</td></tr>
                                                <tr><td class="color-body">Kelas</td><td>{{ $student->kafaClass->display_name ?? '—' }}</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="rbt-title-style-2 mb--15">Ringkasan Kehadiran {{ $year }}</h6>
                                        @if($attendanceTotals['total'] === 0)
                                            <p class="color-body" style="font-size:0.88em;">Tiada rekod kehadiran untuk tahun ini.</p>
                                        @else
                                        <div class="row g-2 text-center">
                                            @foreach([
                                                ['label'=>'Hadir',       'val'=>$attendanceTotals['hadir'],       'color'=>'success'],
                                                ['label'=>'Lewat',       'val'=>$attendanceTotals['lewat'],       'color'=>'warning'],
                                                ['label'=>'Tidak Hadir', 'val'=>$attendanceTotals['tidak_hadir'], 'color'=>'danger'],
                                                ['label'=>'Cuti Sakit',  'val'=>$attendanceTotals['cuti_sakit'],  'color'=>'secondary'],
                                            ] as $item)
                                            <div class="col-6">
                                                <div class="rbt-shadow-box p--15" style="border-radius:10px;">
                                                    <div style="font-size:1.6rem;font-weight:700;color:var(--color-{{ $item['color'] }},#555);">
                                                        {{ $item['val'] }}
                                                    </div>
                                                    <div class="color-body" style="font-size:0.78em;">{{ $item['label'] }}</div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if(count($months) > 0)
                                <h6 class="rbt-title-style-2 mb--15">Pecahan Kehadiran Bulanan</h6>
                                <div class="table-responsive">
                                    <table class="rbt-table table table-borderless" style="font-size:0.85em;">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th class="text-center">Hadir</th>
                                                <th class="text-center">Lewat</th>
                                                <th class="text-center">Tidak Hadir</th>
                                                <th class="text-center">Cuti Sakit</th>
                                                <th class="text-center">Jumlah Hari</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($months as $row)
                                            <tr>
                                                <td>{{ $row['label'] }}</td>
                                                <td class="text-center"><span class="rbt-badge-5 bg-success-opacity color-success">{{ $row['hadir'] }}</span></td>
                                                <td class="text-center"><span class="rbt-badge-5 bg-warning-opacity color-warning">{{ $row['lewat'] }}</span></td>
                                                <td class="text-center"><span class="rbt-badge-5 bg-danger-opacity color-danger">{{ $row['tidak_hadir'] }}</span></td>
                                                <td class="text-center"><span class="rbt-badge-5 bg-secondary-opacity color-secondary">{{ $row['cuti_sakit'] }}</span></td>
                                                <td class="text-center">{{ $row['total'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>

                            {{-- ══ TAB 2: PRESTASI AKADEMIK ══ --}}
                            <div class="tab-pane fade" id="pane-exam" role="tabpanel">
                                @if($examResultGroups->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="feather-bar-chart-2" style="font-size:2.5rem;color:#ccc;"></i>
                                        <p class="color-body mt-2">Tiada rekod keputusan peperiksaan.</p>
                                    </div>
                                @else
                                    @foreach($examResultGroups as $examId => $results)
                                    @php $exam = $examsById[$examId] ?? null; @endphp
                                    <div class="mb--30">
                                        <div class="d-flex justify-content-between align-items-center mb--15 flex-wrap gap-2">
                                            <h6 class="rbt-title-style-2 mb-0">
                                                {{ $exam?->name ?? 'Peperiksaan' }}
                                                <span class="color-body" style="font-size:0.82em;font-weight:400;">
                                                    ({{ $exam?->year ?? '' }})
                                                </span>
                                            </h6>
                                            @php
                                                $avg = round($results->avg('marks'), 1);
                                                $avgGrade = $avg >= 80 ? 'A' : ($avg >= 60 ? 'B' : ($avg >= 50 ? 'C' : ($avg >= 40 ? 'D' : 'E')));
                                                $gradeColor = match($avgGrade) {
                                                    'A' => 'success', 'B' => 'primary',
                                                    'C' => 'warning', 'D' => 'secondary', default => 'danger'
                                                };
                                            @endphp
                                            <span class="rbt-badge-5 bg-{{ $gradeColor }}-opacity color-{{ $gradeColor }}" style="font-size:0.8em;">
                                                Purata: {{ $avg }} ({{ $avgGrade }})
                                            </span>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="rbt-table table table-borderless" style="font-size:0.85em;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th class="text-center">Markah</th>
                                                        <th class="text-center">Gred</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($results as $i => $r)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $r->subject->name ?? '—' }}</td>
                                                        <td class="text-center"><strong>{{ $r->marks ?? '—' }}</strong></td>
                                                        <td class="text-center">
                                                            @php
                                                                $gc = match($r->grade) {
                                                                    'A' => 'success', 'B' => 'primary',
                                                                    'C' => 'warning', 'D' => 'secondary', default => 'danger'
                                                                };
                                                            @endphp
                                                            <span class="rbt-badge-5 bg-{{ $gc }}-opacity color-{{ $gc }}">
                                                                {{ $r->grade ?? '—' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                            {{-- ══ TAB 3: SIJIL PENCAPAIAN ══ --}}
                            <div class="tab-pane fade" id="pane-cert" role="tabpanel">
                                @if($certificates->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="feather-award" style="font-size:2.5rem;color:#ccc;"></i>
                                        <p class="color-body mt-2">Tiada sijil digital dikeluarkan buat masa ini.</p>
                                    </div>
                                @else
                                <div class="table-responsive">
                                    <table class="rbt-table table table-borderless" style="font-size:0.85em;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Sijil</th>
                                                <th>Program / Peperiksaan</th>
                                                <th>Tarikh Dikeluarkan</th>
                                                <th>No. Rujukan</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($certificates as $i => $cert)
                                            <tr id="cert-row-{{ $cert->id }}">
                                                <td>{{ $i + 1 }}</td>
                                                <td><strong>{{ $cert->template->name ?? '—' }}</strong></td>
                                                <td class="color-body">
                                                    {{ $cert->activity->name ?? $cert->exam->name ?? '—' }}
                                                </td>
                                                <td>{{ $cert->issue_date?->format('d/m/Y') ?? '—' }}</td>
                                                <td style="font-size:0.78em;letter-spacing:.04em;">
                                                    {{ $cert->reference_no }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                            class="rbt-btn btn-xs btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                            style="width:35px;height:35px;"
                                                            title="Muat Turun / Pratonton PDF"
                                                            onclick="downloadCert(this, {{ $cert->id }})">
                                                        <i class="feather-download" style="font-size:14px;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>

                        </div>{{-- /tab-content --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
    .rbt-default-tab .nav-link { font-size:0.88em; padding:.6rem 1rem; }
    .color-success  { color:#28a745 !important; }
    .color-warning  { color:#ffc107 !important; }
    .color-danger   { color:#dc3545 !important; }
    .color-secondary{ color:#6c757d !important; }
    .color-primary  { color:#6c63ff !important; }
    .bg-success-opacity  { background:rgba(40,167,69,.1); }
    .bg-warning-opacity  { background:rgba(255,193,7,.12); }
    .bg-danger-opacity   { background:rgba(220,53,69,.1); }
    .bg-secondary-opacity{ background:rgba(108,117,125,.1); }
    .bg-primary-opacity  { background:rgba(108,99,255,.1); }
</style>

@push('scripts')
<script>
var certUrls = {
    @foreach($certificates as $cert)
    {{ $cert->id }}: '{{ route("certificates.single.pdf", $cert) }}',
    @endforeach
};

function downloadCert(btn, certId) {
    var url = certUrls[certId];
    if (!url) return;

    btn.disabled = true;
    var icon = btn.querySelector('i');
    if (icon) icon.className = 'feather-loader spin-icon';

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.pdf) renderPdfBase64(data.pdf);
        else alert('Ralat menjana sijil.');
    })
    .catch(() => alert('Ralat sambungan.'))
    .finally(() => {
        btn.disabled = false;
        if (icon) icon.className = 'feather-download';
    });
}
</script>
<style>
@keyframes spin { to { transform:rotate(360deg); } }
.spin-icon { display:inline-block; animation:spin .8s linear infinite; }
</style>
@endpush
@endsection
