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

                        {{-- Header + Filter Tahun --}}
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb--20">
                            <div>
                                <h4 class="rbt-title-style-3 mb--5">Analitik Pencapaian Murid</h4>
                                <p class="text-muted mb-0">Paparan prestasi murid mengikut sekolah dalam daerah.</p>
                            </div>
                            <form method="GET" action="{{ route('achievements.index') }}" class="d-flex align-items-center gap-2">
                                <label class="mb-0 text-muted" style="font-size:13px; white-space:nowrap;">Tahun:</label>
                                <select name="academic_year" class="form-select form-select-sm" style="width:100px;" onchange="this.form.submit()">
                                    @foreach($years as $yr)
                                        <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        {{-- Summary Cards --}}
                        <div class="row g-3 mb--25">
                            <div class="col-6 col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size:11px;">JUMLAH SEKOLAH</p>
                                    <h4 class="mb-0 color-primary">{{ $summary['totalSchools'] }}</h4>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size:11px;">JUMLAH MURID</p>
                                    <h4 class="mb-0">{{ $summary['totalStudents'] }}</h4>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size:11px;">TELAH DINILAI</p>
                                    <h4 class="mb-0 color-success">{{ $summary['totalRecorded'] }}</h4>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size:11px;">BELUM REKOD</p>
                                    <h4 class="mb-0 {{ $summary['belumRekod'] > 0 ? 'color-danger' : 'color-success' }}">
                                        {{ $summary['belumRekod'] }} sekolah
                                    </h4>
                                </div>
                            </div>
                        </div>

                        {{-- Progress Keseluruhan Daerah --}}
                        @if($summary['totalStudents'] > 0)
                        <div class="rbt-shadow-box p--15 mb--25">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Keseluruhan Penilaian Daerah ({{ $selectedYear }})</small>
                                <small class="fw-bold">{{ $summary['overallPct'] }}%</small>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar {{ $summary['overallPct'] >= 80 ? 'bg-success' : ($summary['overallPct'] >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                     style="width: {{ $summary['overallPct'] }}%"></div>
                            </div>
                        </div>
                        @endif

                        {{-- Top 10 Pelajar Terbaik --}}
                        @if($topStudents->isNotEmpty())
                        <div class="rbt-dashboard-content bg-gradient-11 rbt-shadow-box mb--25" style="border-radius:10px;">
                            <div class="content p-4">
                                <h5 class="rbt-title-style-2 text-white mb--20">
                                    <i class="feather-award me-2"></i>Top 10 Pelajar Terbaik ({{ $selectedYear }})
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0" style="color:#fff;">
                                        <thead style="border-bottom:2px solid rgba(255,255,255,0.3);">
                                            <tr>
                                                <th style="width:80px;">Kedudukan</th>
                                                <th>Nama Murid</th>
                                                <th>Sekolah</th>
                                                <th class="text-end" style="width:130px;">Jumlah Markah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topStudents as $i => $rec)
                                            <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                                                <td>
                                                    @if($i === 0) <span class="badge bg-warning text-dark" style="font-size:13px;">🥇 #1</span>
                                                    @elseif($i === 1) <span class="badge bg-secondary" style="font-size:13px;">🥈 #2</span>
                                                    @elseif($i === 2) <span class="badge" style="background:#cd7f32;font-size:13px;">🥉 #3</span>
                                                    @else <span class="badge bg-light text-dark">#{{ $i + 1 }}</span>
                                                    @endif
                                                </td>
                                                <td class="fw-bold">{{ $rec->student->name ?? '—' }}</td>
                                                <td>{{ $rec->school->name ?? '—' }}</td>
                                                <td class="text-end fw-bold" style="font-size:15px;">{{ number_format($rec->total_marks) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Senarai Sekolah dengan Ranking --}}
                        <h6 class="fw-bold mb--15"><i class="feather-grid me-1"></i> Ranking Sekolah — Penilaian {{ $selectedYear }}</h6>

                        @if($summary['belumRekod'] > 0)
                        <div class="alert alert-warning d-flex align-items-center gap-2 mb--15">
                            <i class="feather-alert-triangle"></i>
                            <span><strong>{{ $summary['belumRekod'] }} sekolah</strong> belum ada rekod pencapaian untuk tahun {{ $selectedYear }}.</span>
                        </div>
                        @endif

                        <div class="rbt-dashboard-table table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Ranking</th>
                                        <th>Nama Sekolah</th>
                                        <th class="text-center">Jumlah Murid</th>
                                        <th class="text-center">Telah Dinilai</th>
                                        <th class="text-center">Peratus (%)</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $rank = 1; @endphp
                                    @forelse($schools as $i => $school)
                                    @php
                                        $pct = $school->students_count > 0
                                            ? round(($school->achievements_count / $school->students_count) * 100, 1) : 0;
                                        $badgeClass = $pct >= 80 ? 'bg-success' : ($pct >= 50 ? 'bg-warning text-dark' : 'bg-danger');
                                        $belumRekod = $school->achievements_count === 0;
                                    @endphp
                                    <tr id="row-{{ $school->id }}" class="{{ $belumRekod ? 'table-danger' : '' }}">
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            @if(!$belumRekod)
                                                @if($rank === 1) <span class="badge bg-warning text-dark">🥇 {{ $rank }}</span>
                                                @elseif($rank === 2) <span class="badge bg-secondary">🥈 {{ $rank }}</span>
                                                @elseif($rank === 3) <span class="badge" style="background:#cd7f32;">🥉 {{ $rank }}</span>
                                                @else <span class="badge bg-light text-dark">{{ $rank }}</span>
                                                @endif
                                                @php $rank++; @endphp
                                            @else
                                                <span class="badge bg-danger">Belum Rekod</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $school->name }}</strong></td>
                                        <td class="text-center">{{ $school->students_count }}</td>
                                        <td class="text-center">{{ $school->achievements_count }}</td>
                                        <td class="text-center">
                                            @if(!$belumRekod)
                                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                                <div class="progress flex-grow-1" style="height:7px; max-width:80px;">
                                                    <div class="progress-bar {{ $badgeClass }}" style="width:{{ $pct }}%"></div>
                                                </div>
                                                <span class="badge {{ $badgeClass }}">{{ $pct }}%</span>
                                            </div>
                                            @else
                                            <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('achievements.school_list', $school->id) }}"
                                               class="rbt-btn btn-xs btn-border" title="Lihat Rekod Murid">
                                                <i class="feather-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center text-muted">Tiada sekolah dijumpai.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
