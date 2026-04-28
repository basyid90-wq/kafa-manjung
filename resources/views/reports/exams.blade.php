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
                        <!-- Jadual Laporan -->
                        <div class="rbt-dashboard-table table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Sekolah</th>
                                        <th>Jumlah Calon</th>
                                        <th>Peratus Lulus (%)</th>
                                        <th>GPS</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schools as $index => $school)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $school->name }}</td>
                                        <td>{{ $school->total_candidates }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 mr--10" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $school->pass_percentage }}%"></div>
                                                </div>
                                                <strong>{{ number_format($school->pass_percentage, 1) }}%</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $school->gps <= 2.5 ? 'bg-success' : ($school->gps <= 4.0 ? 'bg-warning' : 'bg-danger') }}">
                                                {{ number_format($school->gps, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('schools.show', $school) }}" class="rbt-btn btn-xs btn-border" title="Lihat Profil Sekolah">
                                                <i class="feather-eye"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tiada data untuk peperiksaan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center p--50 border-dashed">
                            <i class="feather-info mb--15" style="font-size: 40px; color: #ccc;"></i>
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
