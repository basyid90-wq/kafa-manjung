@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
    $monthNames = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
        5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
    ];
    $periodLabel = $jenis === 'Mingguan'
        ? "Minggu {$minggu} / {$tahun}"
        : (($monthNames[$bulan] ?? '') . " {$tahun}");
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

                        <div class="section-title d-flex justify-content-between align-items-center mb--20 flex-wrap gap-2">
                            <h4 class="rbt-title-style-3">Laporan KPI RPH</h4>
                            <span class="rbt-badge-5 bg-primary-opacity color-primary" style="font-size:0.9em;">
                                {{ $jenis }} — {{ $periodLabel }}
                            </span>
                        </div>

                        {{-- Borang Tapisan --}}
                        <form action="{{ route('reports.rph_kpi') }}" method="GET" class="row g-3 mb--30" id="kpi-form">

                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label class="form-label">Jenis Laporan</label>
                                    <select name="jenis_laporan" class="rbt-big-select" id="jenis_laporan" onchange="togglePeriod(this.value)">
                                        <option value="Bulanan"  {{ $jenis === 'Bulanan'  ? 'selected' : '' }}>Bulanan</option>
                                        <option value="Mingguan" {{ $jenis === 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Bulanan fields --}}
                            <div class="col-lg-2 col-md-4 col-12" id="field-bulan">
                                <div class="rbt-form-group">
                                    <label class="form-label">Bulan</label>
                                    <select name="bulan" class="rbt-big-select">
                                        @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $monthNames[$m] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-4 col-12" id="field-tahun">
                                <div class="rbt-form-group">
                                    <label class="form-label">Tahun</label>
                                    <select name="tahun" class="rbt-big-select">
                                        @foreach(range(date('Y') - 2, date('Y')) as $y)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Mingguan field --}}
                            <div class="col-lg-2 col-md-4 col-12 d-none" id="field-minggu">
                                <div class="rbt-form-group">
                                    <label class="form-label">Minggu (1–52)</label>
                                    <input type="number" name="minggu" value="{{ $minggu }}" min="1" max="52"
                                           class="form-control" style="height:50px;">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-4 col-12">
                                <div class="rbt-form-group">
                                    <label class="form-label">Target Hari/RPH</label>
                                    <input type="number" name="jumlah_hari_persekolahan" value="{{ $jumlahHari }}"
                                           min="1" max="31" class="form-control" style="height:50px;">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4 col-12 d-flex align-items-end">
                                <button type="submit" class="rbt-btn btn-gradient w-100">Jana Laporan</button>
                            </div>
                        </form>

                        {{-- Jadual Induk Sekolah --}}
                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Sekolah</th>
                                        <th class="text-center">Bil. Guru</th>
                                        <th class="text-center">Target RPH</th>
                                        <th class="text-center">RPH Dihantar</th>
                                        <th class="text-center">Prestasi (%)</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schools as $i => $school)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><strong>{{ $school->name }}</strong></td>
                                        <td class="text-center">{{ $school->bil_guru }}</td>
                                        <td class="text-center">{{ $school->target_rph }}</td>
                                        <td class="text-center">{{ $school->rph_dihantar }}</td>
                                        <td class="text-center">
                                            <span class="rbt-badge-5 bg-{{ $school->badge_kpi }}-opacity color-{{ $school->badge_kpi }}">
                                                {{ number_format($school->peratus_kpi, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button"
                                                    class="rbt-btn btn-xs btn-border-gradient"
                                                    style="padding:6px 12px; font-size:0.8em;"
                                                    data-school="{{ $school->name }}"
                                                    data-details='@json($school->guru_details)'
                                                    onclick="showGuruDetails(this)">
                                                <i class="feather-users me-1"></i> Terperinci
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">Tiada data sekolah untuk dipaparkan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($schools->isNotEmpty())
                        {{-- Ringkasan bawah --}}
                        @php
                            $totalGuru   = $schools->sum('bil_guru');
                            $totalTarget = $schools->sum('target_rph');
                            $totalHantar = $schools->sum('rph_dihantar');
                            $avgKpi      = $totalTarget > 0 ? round(($totalHantar / $totalTarget) * 100, 1) : 0;
                            $avgColor    = $avgKpi >= 85 ? 'success' : ($avgKpi >= 50 ? 'warning' : 'danger');
                        @endphp
                        <div class="row mt--30">
                            <div class="col-md-3">
                                <div class="rbt-shadow-box p--20 text-center">
                                    <p class="mb-1 text-muted" style="font-size:0.82em;">Jumlah Guru</p>
                                    <h4>{{ $totalGuru }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rbt-shadow-box p--20 text-center">
                                    <p class="mb-1 text-muted" style="font-size:0.82em;">Jumlah Target RPH</p>
                                    <h4>{{ $totalTarget }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rbt-shadow-box p--20 text-center">
                                    <p class="mb-1 text-muted" style="font-size:0.82em;">RPH Dihantar</p>
                                    <h4>{{ $totalHantar }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rbt-shadow-box p--20 text-center">
                                    <p class="mb-1 text-muted" style="font-size:0.82em;">Purata KPI Keseluruhan</p>
                                    <h4 class="color-{{ $avgColor }}">{{ $avgKpi }}%</h4>
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

{{-- Modal Terperinci Per-Guru --}}
<div class="modal fade" id="guruDetailsModal" tabindex="-1" aria-labelledby="guruDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guruDetailsLabel">
                    <i class="feather-users me-2"></i> Pecahan Per-Guru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p id="modal-school-name" class="fw-bold mb--15" style="color:var(--color-primary);"></p>
                <div class="table-responsive">
                    <table class="rbt-table table table-borderless">
                        <thead>
                            <tr>
                                <th>Bil</th>
                                <th>Nama Guru</th>
                                <th class="text-center">Target RPH</th>
                                <th class="text-center">RPH Dihantar</th>
                                <th class="text-center">Pencapaian (%)</th>
                            </tr>
                        </thead>
                        <tbody id="guru-details-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="rbt-btn btn-border-gradient" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePeriod(val) {
    const bulanan  = ['field-bulan', 'field-tahun'];
    const mingguan = ['field-minggu'];

    if (val === 'Mingguan') {
        bulanan.forEach(id => document.getElementById(id).classList.add('d-none'));
        mingguan.forEach(id => document.getElementById(id).classList.remove('d-none'));
    } else {
        bulanan.forEach(id => document.getElementById(id).classList.remove('d-none'));
        mingguan.forEach(id => document.getElementById(id).classList.add('d-none'));
    }
}

// Init on load
togglePeriod('{{ $jenis }}');

function showGuruDetails(btn) {
    const school   = btn.dataset.school;
    const details  = JSON.parse(btn.dataset.details);

    document.getElementById('modal-school-name').textContent = school;

    const badgeMap = { success: 'bg-success', warning: 'bg-warning text-dark', danger: 'bg-danger' };

    let rows = '';
    if (details.length === 0) {
        rows = '<tr><td colspan="5" class="text-center text-muted py-3">Tiada guru Guru KAFA berdaftar dalam sekolah ini.</td></tr>';
    } else {
        details.forEach((g, i) => {
            const badge = badgeMap[g.badge] || 'bg-secondary';
            rows += `<tr>
                <td>${i + 1}</td>
                <td>${g.name}</td>
                <td class="text-center">${g.target}</td>
                <td class="text-center">${g.hantar}</td>
                <td class="text-center"><span class="badge ${badge} px-3">${g.peratus}%</span></td>
            </tr>`;
        });
    }

    document.getElementById('guru-details-tbody').innerHTML = rows;
    new bootstrap.Modal(document.getElementById('guruDetailsModal')).show();
}
</script>
@endpush
