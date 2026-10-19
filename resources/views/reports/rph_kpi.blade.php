@extends('layout-fb.layout')

@section('content')
@php
$monthNames = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
    5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
];
$periodLabel = $jenis === 'Mingguan'
    ? "Minggu {$minggu} / {$tahun} ({$periodStart->format('d/m')} – {$periodEnd->format('d/m')})"
    : "{$monthNames[$bulan]} {$tahun}";
$kpiBadge = fn ($p) => $p >= 85 ? 'ek-badge-green' : ($p >= 50 ? 'ek-badge-yellow' : 'ek-badge-red');
$kpiLabel = fn ($p) => $p >= 85 ? 'Capai' : ($p >= 50 ? 'Sederhana' : 'Perlu Perhatian');
@endphp

<div>

    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="ek-page-title">Laporan KPI RPH</h1>
            <p class="ek-page-sub mt-1">{{ $school?->name ?? 'Penghantaran RPH mengikut guru' }}</p>
        </div>
        <span class="ek-badge ek-badge-blue">{{ $jenis }} — {{ $periodLabel }}</span>
    </div>

    {{-- Filter --}}
    <div class="ek-card mb-5">
        <form action="{{ route('reports.rph_kpi') }}" method="GET" class="flex flex-wrap items-end gap-3">
            @include('reports._school_picker')
            <div class="w-36">
                <label class="ek-label">Jenis Laporan</label>
                <select name="jenis_laporan" id="jenis_laporan" class="ek-input">
                    <option value="Bulanan"  {{ $jenis === 'Bulanan'  ? 'selected' : '' }}>Bulanan</option>
                    <option value="Mingguan" {{ $jenis === 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                </select>
            </div>

            <div id="field-bulan" class="w-32">
                <label class="ek-label">Bulan</label>
                <select name="bulan" class="ek-input">
                    @foreach($monthNames as $m => $label)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-24">
                <label class="ek-label">Tahun</label>
                <select name="tahun" class="ek-input">
                    @foreach(range(date('Y') - 2, date('Y')) as $y)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div id="field-minggu" class="hidden w-28">
                <label class="ek-label">Minggu (1–53)</label>
                <input type="number" name="minggu" value="{{ $minggu }}" min="1" max="53" class="ek-input">
            </div>

            <div class="w-36">
                <label class="ek-label">Target RPH / Guru</label>
                <input type="number" name="jumlah_hari_persekolahan" value="{{ $jumlahHari }}" min="1" max="31" class="ek-input">
            </div>

            <button type="submit" class="ek-btn-primary">Jana Laporan</button>
        </form>
    </div>

    @if(!$school)
        @include('reports._pick_school')
    @else

    {{-- Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Bilangan Guru</p>
            <p class="text-2xl font-bold text-gray-900">{{ $summary['teachers'] }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">RPH Dihantar / Target</p>
            <p class="text-2xl font-bold text-gray-900">{{ $summary['hantar'] }} <span class="text-sm font-normal text-gray-500">/ {{ $summary['target'] }}</span></p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">KPI Sekolah</p>
            <p class="text-2xl font-bold {{ $summary['peratus'] >= 85 ? 'text-green-600' : ($summary['peratus'] >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ number_format($summary['peratus'], 1) }}%</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Guru Capai KPI (≥85%)</p>
            <p class="text-2xl font-bold text-green-600">{{ $summary['achieved'] }} <span class="text-sm font-normal text-gray-500">/ {{ $summary['teachers'] }}</span></p>
        </div>
    </div>

    {{-- By teacher --}}
    <div class="ek-table-wrap mb-3">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">KPI RPH Mengikut Guru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Kelas</th>
                        <th class="text-center">Target</th>
                        <th class="text-center">Dihantar</th>
                        <th class="text-center">Diluluskan</th>
                        <th class="text-center">Menunggu Semakan</th>
                        <th class="text-center">Perlu Pembetulan</th>
                        <th>Pencapaian (%)</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teacherRows as $i => $t)
                    <tr>
                        <td class="text-gray-500">{{ $i + 1 }}</td>
                        <td class="font-medium text-gray-900">{{ $t['name'] }}</td>
                        <td>{{ $t['classes'] ?: '—' }}</td>
                        <td class="text-center">{{ $t['target'] }}</td>
                        <td class="text-center font-semibold text-gray-900">{{ $t['hantar'] }}</td>
                        <td class="text-center">{{ $t['approved'] }}</td>
                        <td class="text-center">{{ $t['pending'] }}</td>
                        <td class="text-center">{{ $t['revise'] ?: '—' }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-12">
                                    <div class="h-2 rounded-full {{ $t['peratus'] >= 85 ? 'bg-green-500' : ($t['peratus'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $t['peratus'] }}%"></div>
                                </div>
                                <span class="font-semibold text-gray-900 text-xs">{{ number_format($t['peratus'], 1) }}%</span>
                            </div>
                        </td>
                        <td class="text-center"><span class="ek-badge {{ $kpiBadge($t['peratus']) }}">{{ $kpiLabel($t['peratus']) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="text-center text-gray-400" style="padding:2rem 1rem">Tiada Guru KAFA berdaftar di sekolah ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-xs text-gray-400">* Pencapaian = RPH dihantar ÷ target bagi tempoh dipilih (maksimum 100%). Semua RPH dikira termasuk yang belum disemak.</p>
    @endif
</div>

<script>
function togglePeriod(val) {
    document.getElementById('field-bulan').classList.toggle('hidden', val === 'Mingguan');
    document.getElementById('field-minggu').classList.toggle('hidden', val !== 'Mingguan');
}
document.getElementById('jenis_laporan').addEventListener('change', function () { togglePeriod(this.value); });
togglePeriod(@json($jenis));
</script>
@endsection
