@extends('layout.layout')

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

                        {{-- Header --}}
                        <div class="section-title d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h4 class="rbt-title-style-3 mb--5">Perincian Prestasi Peperiksaan</h4>
                                <p class="mb-0 text-muted">{{ $school->name }} &mdash; {{ $exam->name }} ({{ $exam->year }})</p>
                            </div>
                            <a href="{{ route('reports.exams', ['exam_id' => $examId]) }}"
                               class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left"></i> Kembali
                            </a>
                        </div>

                        {{-- Kad Ringkasan Sekolah --}}
                        <div class="row g-3 mt--10 mb--30">
                            <div class="col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size: 11px;">JUMLAH CALON</p>
                                    <h4 class="mb-0 color-primary">{{ $overallStats['candidates'] }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size: 11px;">JUMLAH LULUS</p>
                                    <h4 class="mb-0 color-success">{{ $overallStats['pass'] }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size: 11px;">PERATUS LULUS</p>
                                    <h4 class="mb-0 {{ $overallStats['pass_pct'] >= 80 ? 'color-success' : ($overallStats['pass_pct'] >= 60 ? 'color-warning' : 'color-danger') }}">
                                        {{ number_format($overallStats['pass_pct'], 1) }}%
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size: 11px;">GPS SEKOLAH</p>
                                    <h4 class="mb-0">
                                        <span class="badge {{ $overallStats['gps'] <= 2.5 ? 'bg-success' : ($overallStats['gps'] <= 4.0 ? 'bg-warning' : 'bg-danger') }}" style="font-size: 15px;">
                                            {{ number_format($overallStats['gps'], 2) }}
                                        </span>
                                    </h4>
                                </div>
                            </div>
                        </div>

                        {{-- Jadual Per Subjek --}}
                        <h6 class="mb--15 fw-bold"><i class="feather-book mr--5"></i> Prestasi Mengikut Subjek</h6>
                        <div class="rbt-dashboard-table table-responsive mb--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Subjek</th>
                                        <th>Jumlah Calon</th>
                                        <th>Jumlah Lulus</th>
                                        <th>Peratus Lulus (%)</th>
                                        <th>GPS</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bySubject as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row['subject']->name ?? '—' }}</td>
                                        <td>{{ $row['candidates'] }}</td>
                                        <td>{{ $row['pass'] }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 8px; min-width: 60px;">
                                                    <div class="progress-bar {{ $row['pass_pct'] >= 80 ? 'bg-success' : ($row['pass_pct'] >= 60 ? 'bg-warning' : 'bg-danger') }}"
                                                         style="width: {{ $row['pass_pct'] }}%"></div>
                                                </div>
                                                <strong>{{ number_format($row['pass_pct'], 1) }}%</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $row['gps'] <= 2.5 ? 'bg-success' : ($row['gps'] <= 4.0 ? 'bg-warning' : 'bg-danger') }}">
                                                {{ number_format($row['gps'], 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($row['pass_pct'] >= 80)
                                                <span class="badge bg-success">Cemerlang</span>
                                            @elseif($row['pass_pct'] >= 60)
                                                <span class="badge bg-warning text-dark">Memuaskan</span>
                                            @else
                                                <span class="badge bg-danger">Perlu Perhatian</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Tiada data subjek untuk peperiksaan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Jadual Per Kelas --}}
                        <h6 class="mb--15 fw-bold"><i class="feather-users mr--5"></i> Prestasi Mengikut Kelas</h6>
                        <div class="rbt-dashboard-table table-responsive mb--20">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kelas</th>
                                        <th>Jumlah Calon</th>
                                        <th>Jumlah Lulus</th>
                                        <th>Peratus Lulus (%)</th>
                                        <th>GPS</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($byClass as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row['class_name'] }}</td>
                                        <td>{{ $row['candidates'] }}</td>
                                        <td>{{ $row['pass'] }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 8px; min-width: 60px;">
                                                    <div class="progress-bar {{ $row['pass_pct'] >= 80 ? 'bg-success' : ($row['pass_pct'] >= 60 ? 'bg-warning' : 'bg-danger') }}"
                                                         style="width: {{ $row['pass_pct'] }}%"></div>
                                                </div>
                                                <strong>{{ number_format($row['pass_pct'], 1) }}%</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $row['gps'] <= 2.5 ? 'bg-success' : ($row['gps'] <= 4.0 ? 'bg-warning' : 'bg-danger') }}">
                                                {{ number_format($row['gps'], 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($row['pass_pct'] >= 80)
                                                <span class="badge bg-success">Cemerlang</span>
                                            @elseif($row['pass_pct'] >= 60)
                                                <span class="badge bg-warning text-dark">Memuaskan</span>
                                            @else
                                                <span class="badge bg-danger">Perlu Perhatian</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Tiada data kelas untuk peperiksaan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--10">
                            <small class="text-muted">
                                * GPS: A=1, B=2, C=3, D=4, E=5, G=6. GPS rendah = prestasi lebih baik. Murid lulus hanya jika SEMUA subjek gred A–E.
                            </small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
