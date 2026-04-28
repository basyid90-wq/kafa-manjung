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
                        <div class="section-title mb--30">
                            <h4 class="rbt-title-style-3">Analitik Pencapaian Murid</h4>
                            <p class="description">Paparan ringkasan prestasi murid mengikut sekolah.</p>
                        </div>

                        {{-- Top 10 Pelajar Terbaik --}}
                        @if($topStudents->isNotEmpty())
                        <div class="rbt-dashboard-content bg-gradient-11 rbt-shadow-box mb--30" style="border-radius:10px;">
                            <div class="content p-4">
                                <div class="section-title mb--20">
                                    <h5 class="rbt-title-style-2 text-white"><i class="feather-award me-2"></i>Top 10 Pelajar Terbaik ({{ date('Y') }})</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless" style="color:#fff;">
                                        <thead style="border-bottom:2px solid rgba(255,255,255,0.3);">
                                            <tr>
                                                <th style="width:60px;">Kedudukan</th>
                                                <th>Nama Murid</th>
                                                <th>Sekolah</th>
                                                <th style="width:120px;text-align:right;">Jumlah Markah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topStudents as $i => $rec)
                                            <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                                                <td>
                                                    @if($i === 0)
                                                        <span class="rbt-badge-5 bg-warning text-dark" style="font-size:16px;padding:8px 12px;">🥇 #1</span>
                                                    @elseif($i === 1)
                                                        <span class="rbt-badge-5" style="background:#c0c0c0;color:#333;font-size:14px;padding:6px 10px;">🥈 #2</span>
                                                    @elseif($i === 2)
                                                        <span class="rbt-badge-5" style="background:#cd7f32;color:#fff;font-size:14px;padding:6px 10px;">🥉 #3</span>
                                                    @else
                                                        <span class="rbt-badge-5 bg-color-white text-dark" style="font-size:13px;padding:5px 10px;">#{{ $i + 1 }}</span>
                                                    @endif
                                                </td>
                                                <td style="font-weight:600;">{{ $rec->student->name ?? '-' }}</td>
                                                <td>{{ $rec->school->name ?? '-' }}</td>
                                                <td style="text-align:right;font-weight:700;font-size:16px;">{{ number_format($rec->total_marks, 0) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Senarai Sekolah --}}
                        <div class="section-title mb--20">
                            <h5 class="rbt-title-style-2">Senarai Sekolah</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sekolah</th>
                                        <th style="text-align:center;">Jumlah Murid</th>
                                        <th style="text-align:center;">Telah Dinilai</th>
                                        <th style="text-align:center;">Status (%)</th>
                                        <th style="text-align:center;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schools as $i => $school)
                                    @php
                                        $percentage = $school->students_count > 0
                                            ? round(($school->achievements_count / $school->students_count) * 100, 1)
                                            : 0;
                                        $badgeClass = $percentage >= 80 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning text-dark' : 'bg-danger');
                                    @endphp
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><strong>{{ $school->name }}</strong></td>
                                        <td style="text-align:center;">{{ $school->students_count }}</td>
                                        <td style="text-align:center;">{{ $school->achievements_count }}</td>
                                        <td style="text-align:center;">
                                            <span class="badge {{ $badgeClass }}">{{ $percentage }}%</span>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('achievements.school_list', $school->id) }}"
                                               class="rbt-btn-link"
                                               title="Lihat Senarai Murid">
                                                <i class="feather-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted">Tiada sekolah dijumpai.</td></tr>
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
