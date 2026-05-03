@extends('layout-fb.layout')

@section('content')
@php
$monthNames = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
    5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
];
$periodLabel = $jenis === 'Mingguan'
    ? "Minggu {$minggu} / {$tahun}"
    : (($monthNames[$bulan] ?? '') . " {$tahun}");
@endphp

<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Laporan KPI RPH</h1>
        <span class="px-2.5 py-1 text-sm font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
            {{ $jenis }} — {{ $periodLabel }}
        </span>
    </div>

    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        <form action="{{ route('reports.rph_kpi') }}" method="GET" class="flex flex-wrap items-end gap-3" id="kpi-form">
            <div class="w-36">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Laporan</label>
                <select name="jenis_laporan" id="jenis_laporan"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="Bulanan"  {{ $jenis === 'Bulanan'  ? 'selected' : '' }}>Bulanan</option>
                    <option value="Mingguan" {{ $jenis === 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                </select>
            </div>

            <div id="field-bulan" class="w-32">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
                <select name="bulan"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $monthNames[$m] }}</option>
                    @endforeach
                </select>
            </div>

            <div id="field-tahun" class="w-24">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                <select name="tahun"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @foreach(range(date('Y') - 2, date('Y')) as $y)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div id="field-minggu" class="hidden w-28">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Minggu (1–52)</label>
                <input type="number" name="minggu" value="{{ $minggu }}" min="1" max="52"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="w-36">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Hari/RPH</label>
                <input type="number" name="jumlah_hari_persekolahan" value="{{ $jumlahHari }}" min="1" max="31"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Jana Laporan
            </button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Bil</th>
                        <th class="px-4 py-3 text-left">Nama Sekolah</th>
                        <th class="px-4 py-3 text-center">Bil. Guru</th>
                        <th class="px-4 py-3 text-center">Target RPH</th>
                        <th class="px-4 py-3 text-center">RPH Dihantar</th>
                        <th class="px-4 py-3 text-center">Prestasi (%)</th>
                        <th class="px-4 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($schools as $i => $school)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-2.5 font-semibold text-gray-900 dark:text-white">{{ $school->name }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700 dark:text-gray-300">{{ $school->bil_guru }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700 dark:text-gray-300">{{ $school->target_rph }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700 dark:text-gray-300">{{ $school->rph_dihantar }}</td>
                        <td class="px-4 py-2.5 text-center">
                            @php
                                $kpiBadge = match($school->badge_kpi) {
                                    'success' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    'warning' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    default   => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                };
                            @endphp
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $kpiBadge }}">{{ number_format($school->peratus_kpi, 1) }}%</span>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <button type="button"
                                    class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                    data-school="{{ $school->name }}"
                                    data-details='@json($school->guru_details)'
                                    onclick="showGuruDetails(this)"
                                    title="Terperinci">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">Tiada data sekolah untuk dipaparkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($schools->isNotEmpty())
    @php
        $totalGuru   = $schools->sum('bil_guru');
        $totalTarget = $schools->sum('target_rph');
        $totalHantar = $schools->sum('rph_dihantar');
        $avgKpi      = $totalTarget > 0 ? round(($totalHantar / $totalTarget) * 100, 1) : 0;
        $avgColor    = $avgKpi >= 85 ? 'text-green-600 dark:text-green-400' : ($avgKpi >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400');
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Jumlah Guru</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalGuru }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Jumlah Target RPH</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalTarget }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">RPH Dihantar</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalHantar }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Purata KPI Keseluruhan</p>
            <p class="text-2xl font-bold {{ $avgColor }}">{{ $avgKpi }}%</p>
        </div>
    </div>
    @endif
</div>

{{-- Modal Terperinci Per-Guru --}}
<div id="modalGuru" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-2xl mx-4">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Pecahan Per-Guru</h3>
                <p id="modal-school-name" class="text-xs text-blue-600 dark:text-blue-400 mt-0.5"></p>
            </div>
            <button onclick="document.getElementById('modalGuru').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-5 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-3 py-2 text-left">Bil</th>
                        <th class="px-3 py-2 text-left">Nama Guru</th>
                        <th class="px-3 py-2 text-center">Target RPH</th>
                        <th class="px-3 py-2 text-center">RPH Dihantar</th>
                        <th class="px-3 py-2 text-center">Pencapaian (%)</th>
                    </tr>
                </thead>
                <tbody id="guru-details-tbody" class="divide-y divide-gray-100 dark:divide-gray-700"></tbody>
            </table>
        </div>
        <div class="flex justify-end px-5 py-4 border-t border-gray-100 dark:border-gray-700">
            <button onclick="document.getElementById('modalGuru').classList.add('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
document.getElementById('jenis_laporan').addEventListener('change', function() {
    togglePeriod(this.value);
});

function togglePeriod(val) {
    const bulan  = document.getElementById('field-bulan');
    const tahun  = document.getElementById('field-tahun');
    const minggu = document.getElementById('field-minggu');
    if (val === 'Mingguan') {
        bulan.classList.add('hidden');
        tahun.classList.add('hidden');
        minggu.classList.remove('hidden');
    } else {
        bulan.classList.remove('hidden');
        tahun.classList.remove('hidden');
        minggu.classList.add('hidden');
    }
}
togglePeriod('{{ $jenis }}');

function showGuruDetails(btn) {
    const school  = btn.dataset.school;
    const details = JSON.parse(btn.dataset.details);

    document.getElementById('modal-school-name').textContent = school;

    let rows = '';
    if (details.length === 0) {
        rows = '<tr><td colspan="5" class="px-3 py-4 text-center text-gray-400 text-sm">Tiada guru Guru KAFA berdaftar.</td></tr>';
    } else {
        details.forEach((g, i) => {
            const badgeColor = g.badge === 'success'
                ? 'bg-green-100 text-green-700'
                : (g.badge === 'warning' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
            rows += `<tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                <td class="px-3 py-2 text-gray-500">${i + 1}</td>
                <td class="px-3 py-2 font-medium text-gray-900 dark:text-white">${g.name}</td>
                <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300">${g.target}</td>
                <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300">${g.hantar}</td>
                <td class="px-3 py-2 text-center"><span class="px-2 py-0.5 text-xs font-medium rounded-full ${badgeColor}">${g.peratus}%</span></td>
            </tr>`;
        });
    }

    document.getElementById('guru-details-tbody').innerHTML = rows;
    document.getElementById('modalGuru').classList.remove('hidden');
}
</script>
@endsection
