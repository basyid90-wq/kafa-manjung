@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';

    $monthNames = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Mac',      4 => 'April',
        5 => 'Mei',     6 => 'Jun',       7 => 'Julai',    8 => 'Ogos',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
    ];
@endphp

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

                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Laporan Kehadiran Bulanan</h4>
                            <span class="rbt-badge-5 bg-primary-opacity color-primary" style="font-size:0.9em;">
                                {{ $monthNames[$month] ?? '' }} {{ $year }}
                            </span>
                        </div>

                        {{-- Borang Tapisan --}}
                        <form action="{{ route('reports.attendance') }}" method="GET" class="row g-3 mb--30">
                            <div class="col-lg-4 col-md-5 col-12">
                                <div class="rbt-form-group">
                                    <label class="form-label">Bulan</label>
                                    <select name="month" class="rbt-big-select">
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                                {{ $monthNames[$m] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="rbt-form-group">
                                    <label class="form-label">Tahun</label>
                                    <select name="year" class="rbt-big-select">
                                        @foreach(range(date('Y') - 2, date('Y')) as $y)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-3 col-12 d-flex align-items-end">
                                <button type="submit" class="rbt-btn btn-gradient w-100">Jana Laporan</button>
                            </div>
                        </form>

                        {{-- Jadual Laporan --}}
                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Sekolah</th>
                                        <th class="text-center">Bil. Murid<br><small>Bulan Lepas</small></th>
                                        <th class="text-center">Masuk</th>
                                        <th class="text-center">Keluar</th>
                                        <th class="text-center">Bil.<br><small>Terkini</small></th>
                                        <th class="text-center">Kehadiran (%)</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schools as $index => $school)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $school->name }}</strong></td>
                                        <td class="text-center">{{ $school->bil_bulan_lepas }}</td>
                                        <td class="text-center">
                                            @if($school->murid_masuk > 0)
                                                <span class="rbt-badge-5 bg-success-opacity color-success">+{{ $school->murid_masuk }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($school->murid_keluar > 0)
                                                <span class="rbt-badge-5 bg-danger-opacity color-danger">-{{ $school->murid_keluar }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center"><strong>{{ $school->bil_terkini }}</strong></td>
                                        <td class="text-center">
                                            <strong>{{ number_format($school->peratus_kehadiran, 1) }}%</strong>
                                            <br>
                                            <small class="text-muted">{{ $school->kedatangan_sebenar }} rekod hadir</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="rbt-badge-5 bg-{{ $school->status_color }}-opacity color-{{ $school->status_color }}">
                                                {{ $school->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Tiada data sekolah untuk dipaparkan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($schools->isNotEmpty())
                        {{-- Ringkasan bawah --}}
                        <div class="row mt--30">
                            <div class="col-md-4">
                                <div class="rbt-shadow-box p--20 text-center">
                                    <p class="mb-1 text-muted" style="font-size:0.82em;">Purata Kehadiran Keseluruhan</p>
                                    @php
                                        $avgPeratus = $schools->avg('peratus_kehadiran');
                                        $avgColor   = $avgPeratus >= 85 ? 'success' : ($avgPeratus >= 70 ? 'warning' : 'danger');
                                    @endphp
                                    <h4 class="color-{{ $avgColor }}">{{ number_format($avgPeratus, 1) }}%</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rbt-shadow-box p--20 text-center">
                                    <p class="mb-1 text-muted" style="font-size:0.82em;">Sekolah Cemerlang (≥85%)</p>
                                    <h4 class="color-success">{{ $schools->where('peratus_kehadiran', '>=', 85)->count() }} / {{ $schools->count() }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rbt-shadow-box p--20 text-center">
                                    <p class="mb-1 text-muted" style="font-size:0.82em;">Sekolah Perlu Perhatian (&lt;70%)</p>
                                    <h4 class="color-danger">{{ $schools->where('peratus_kehadiran', '<', 70)->count() }} / {{ $schools->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
