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
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Laporan Prestasi Peperiksaan</h4>
                        </div>

                        <!-- Borang Tapisan -->
                        <div class="rbt-shadow-box mb--30 p--20 bg-light">
                            <form action="{{ route('reports.exams') }}" method="GET" class="row g-3">
                                <div class="col-md-9">
                                    <label class="form-label">Pilih Peperiksaan</label>
                                    <select name="exam_id" class="form-select" style="height: 50px;" required>
                                        <option value="">-- Pilih Peperiksaan --</option>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                                                {{ $exam->name }} ({{ $exam->year }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="rbt-btn btn-gradient btn-sm w-100" style="height: 50px;">Jana Analisis</button>
                                </div>
                            </form>
                        </div>

                        @if($examId)

                        {{-- Kad Ringkasan Daerah --}}
                        @if($districtTotals && $districtTotals['total_candidates'] > 0)
                        <div class="row g-3 mb--20">
                            <div class="col-md-4">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size:12px;">JUMLAH CALON DAERAH</p>
                                    <h4 class="mb-0 color-primary">{{ $districtTotals['total_candidates'] }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size:12px;">PURATA LULUS DAERAH</p>
                                    <h4 class="mb-0 {{ $districtTotals['pass_percentage'] >= 80 ? 'color-success' : ($districtTotals['pass_percentage'] >= 60 ? 'color-warning' : 'color-danger') }}">
                                        {{ number_format($districtTotals['pass_percentage'], 1) }}%
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rbt-shadow-box text-center p--15">
                                    <p class="mb--5 text-muted" style="font-size:12px;">GPS PURATA DAERAH</p>
                                    <h4 class="mb-0">
                                        <span class="badge {{ $districtTotals['gps'] <= 2.5 ? 'bg-success' : ($districtTotals['gps'] <= 4.0 ? 'bg-warning' : 'bg-danger') }}" style="font-size:16px;">
                                            {{ number_format($districtTotals['gps'], 2) }}
                                        </span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Jadual Laporan -->
                        <div class="rbt-dashboard-table table-responsive mt--10">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Ranking</th>
                                        <th>Nama Sekolah</th>
                                        <th>Jumlah Calon</th>
                                        <th>Peratus Lulus (%)</th>
                                        <th>GPS</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $rank = 1; @endphp
                                    @forelse($schools as $index => $school)
                                    <tr id="row-{{ $school->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($school->total_candidates > 0)
                                                @if($rank === 1)
                                                    <span class="badge bg-warning text-dark">🥇 {{ $rank }}</span>
                                                @elseif($rank === 2)
                                                    <span class="badge bg-secondary">🥈 {{ $rank }}</span>
                                                @elseif($rank === 3)
                                                    <span class="badge" style="background:#cd7f32;">🥉 {{ $rank }}</span>
                                                @else
                                                    <span class="badge bg-light text-dark">{{ $rank }}</span>
                                                @endif
                                                @php $rank++; @endphp
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $school->name }}</td>
                                        <td>{{ $school->total_candidates > 0 ? $school->total_candidates : '—' }}</td>
                                        <td>
                                            @if($school->total_candidates > 0)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 8px; min-width: 60px;">
                                                    <div class="progress-bar {{ $school->pass_percentage >= 80 ? 'bg-success' : ($school->pass_percentage >= 60 ? 'bg-warning' : 'bg-danger') }}"
                                                         style="width: {{ $school->pass_percentage }}%"></div>
                                                </div>
                                                <strong>{{ number_format($school->pass_percentage, 1) }}%</strong>
                                            </div>
                                            @else
                                            <span class="text-muted">Tiada Data</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($school->total_candidates > 0)
                                            <span class="badge {{ $school->gps <= 2.5 ? 'bg-success' : ($school->gps <= 4.0 ? 'bg-warning' : 'bg-danger') }}">
                                                {{ number_format($school->gps, 2) }}
                                            </span>
                                            @else
                                            <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($school->total_candidates > 0)
                                            <a href="{{ route('reports.exams.detail', ['school' => $school->id, 'exam_id' => $examId]) }}"
                                               class="rbt-btn btn-xs btn-border" title="Lihat Perincian Subjek & Kelas">
                                                <i class="feather-bar-chart-2"></i>
                                            </a>
                                            @else
                                            <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tiada data untuk peperiksaan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                {{-- Baris Jumlah Daerah --}}
                                @if($districtTotals && $districtTotals['total_candidates'] > 0)
                                <tfoot>
                                    <tr class="fw-bold" style="border-top: 2px solid #dee2e6; background: #f8f9fa;">
                                        <td colspan="3" class="text-end">Jumlah / Purata Daerah</td>
                                        <td>{{ $districtTotals['total_candidates'] }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 8px; min-width: 60px;">
                                                    <div class="progress-bar {{ $districtTotals['pass_percentage'] >= 80 ? 'bg-success' : ($districtTotals['pass_percentage'] >= 60 ? 'bg-warning' : 'bg-danger') }}"
                                                         style="width: {{ $districtTotals['pass_percentage'] }}%"></div>
                                                </div>
                                                <strong>{{ number_format($districtTotals['pass_percentage'], 1) }}%</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $districtTotals['gps'] <= 2.5 ? 'bg-success' : ($districtTotals['gps'] <= 4.0 ? 'bg-warning' : 'bg-danger') }}">
                                                {{ number_format($districtTotals['gps'], 2) }}
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>

                        <div class="mt--10">
                            <small class="text-muted">
                                * GPS: Gred Purata Sekolah — A=1, B=2, C=3, D=4, E=5, G=6. GPS rendah = prestasi lebih baik.
                            </small>
                        </div>

                        @else
                        <div class="text-center p--50 border-dashed">
                            <i class="feather-bar-chart-2 mb--15" style="font-size: 40px; color: #ccc;"></i>
                            <p>Sila pilih peperiksaan untuk melihat analisis prestasi sekolah.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
