@extends('layout-fb.layout')

@section('content')
@php
$monthNames = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
    5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
];
$pctBadge = fn ($p) => $p === null ? 'ek-badge-gray' : ($p >= 85 ? 'ek-badge-green' : ($p >= 70 ? 'ek-badge-yellow' : 'ek-badge-red'));
$pctLabel = fn ($p) => $p === null ? 'Tiada Rekod' : ($p >= 85 ? 'Cemerlang' : ($p >= 70 ? 'Memuaskan' : 'Perlu Perhatian'));
$pctText  = fn ($p) => $p === null ? 'text-gray-400' : ($p >= 85 ? 'text-green-600' : ($p >= 70 ? 'text-yellow-600' : 'text-red-600'));
@endphp

<div>

    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="ek-page-title">Laporan Kehadiran Bulanan</h1>
            <p class="ek-page-sub mt-1">{{ $school?->name ?? 'Kehadiran murid mengikut kelas' }}</p>
        </div>
        <span class="ek-badge ek-badge-blue">{{ $monthNames[$month] }} {{ $year }}</span>
    </div>

    {{-- Filter --}}
    <div class="ek-card mb-5">
        <form action="{{ route('reports.attendance') }}" method="GET" class="flex flex-wrap items-end gap-3">
            @include('reports._school_picker')
            <div class="w-40">
                <label class="ek-label">Bulan</label>
                <select name="month" class="ek-input">
                    @foreach($monthNames as $m => $label)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-28">
                <label class="ek-label">Tahun</label>
                <select name="year" class="ek-input">
                    @foreach(range(date('Y') - 2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
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
            <p class="text-xs text-gray-500 mb-1">Murid Aktif</p>
            <p class="text-2xl font-bold text-gray-900">{{ $summary['students'] }}</p>
            @if($summary['masuk'] || $summary['keluar'])
            <p class="text-xs text-gray-500 mt-1">Masuk +{{ $summary['masuk'] }} · Keluar -{{ $summary['keluar'] }}</p>
            @endif
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Purata Kehadiran</p>
            <p class="text-2xl font-bold {{ $pctText($summary['peratus']) }}">{{ $summary['peratus'] === null ? '—' : number_format($summary['peratus'], 1) . '%' }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Hari Direkod</p>
            <p class="text-2xl font-bold text-gray-900">{{ $summary['days'] }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Murid Kehadiran &lt;70%</p>
            <p class="text-2xl font-bold {{ $summary['low_students'] > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $summary['low_students'] }}</p>
        </div>
    </div>

    {{-- By class --}}
    <div class="ek-table-wrap mb-5">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Kehadiran Mengikut Kelas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Guru Kelas</th>
                        <th class="text-center">Bil. Murid</th>
                        <th class="text-center">Hari Direkod</th>
                        <th class="text-center">Hadir</th>
                        <th class="text-center">Lewat</th>
                        <th class="text-center">Tidak Hadir</th>
                        <th class="text-center">Cuti Sakit</th>
                        <th class="text-center">Kehadiran (%)</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classRows as $i => $row)
                    <tr>
                        <td class="text-gray-500">{{ $i + 1 }}</td>
                        <td class="font-medium text-gray-900">{{ $row['name'] }}</td>
                        <td>{{ $row['teacher'] ?? '—' }}</td>
                        <td class="text-center">{{ $row['students'] }}</td>
                        <td class="text-center">{{ $row['days'] }}</td>
                        <td class="text-center">{{ $row['hadir'] }}</td>
                        <td class="text-center">{{ $row['lewat'] }}</td>
                        <td class="text-center">{{ $row['tidak_hadir'] }}</td>
                        <td class="text-center">{{ $row['cuti_sakit'] }}</td>
                        <td class="text-center font-semibold text-gray-900">{{ $row['peratus'] === null ? '—' : number_format($row['peratus'], 1) . '%' }}</td>
                        <td class="text-center"><span class="ek-badge {{ $pctBadge($row['peratus']) }}">{{ $pctLabel($row['peratus']) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="11" class="text-center text-gray-400" style="padding:2rem 1rem">Tiada kelas berdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Monthly trend --}}
        <div class="ek-table-wrap">
            <div class="px-4 py-3 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-700">Trend Kehadiran {{ $year }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="ek-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th class="text-center">Hari Direkod</th>
                            <th>Kehadiran (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthly as $m => $row)
                        <tr @if($m == $month) class="bg-blue-50" @endif>
                            <td class="text-gray-500">{{ $m }}</td>
                            <td class="font-medium text-gray-900">{{ $monthNames[$m] }}</td>
                            <td class="text-center">{{ $row['days'] ?: '—' }}</td>
                            <td>
                                @if($row['peratus'] === null)
                                    <span class="text-gray-400">—</span>
                                @else
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-12">
                                        <div class="h-2 rounded-full {{ $row['peratus'] >= 85 ? 'bg-green-500' : ($row['peratus'] >= 70 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $row['peratus'] }}%"></div>
                                    </div>
                                    <span class="font-semibold text-gray-900 text-xs">{{ number_format($row['peratus'], 1) }}%</span>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Low attendance students --}}
        <div class="ek-table-wrap" style="align-self:start">
            <div class="px-4 py-3 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-700">Murid Perlu Perhatian (&lt;70%) — {{ $monthNames[$month] }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="ek-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Murid</th>
                            <th>Kelas</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Kehadiran (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStudents as $i => $st)
                        <tr>
                            <td class="text-gray-500">{{ $i + 1 }}</td>
                            <td class="font-medium text-gray-900">{{ $st['name'] }}</td>
                            <td>{{ $st['class'] ?? '—' }}</td>
                            <td class="text-center">{{ $st['hadir'] }} / {{ $st['total'] }}</td>
                            <td class="text-center"><span class="ek-badge ek-badge-red">{{ number_format($st['peratus'], 1) }}%</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-gray-400" style="padding:2rem 1rem">Tiada murid dengan kehadiran bawah 70%.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($summary['low_students'] > $lowStudents->count())
            <p class="px-4 py-2 text-xs text-gray-500 border-t border-gray-100">Memaparkan {{ $lowStudents->count() }} daripada {{ $summary['low_students'] }} murid.</p>
            @endif
        </div>
    </div>

    <p class="text-xs text-gray-400 mt-3">* Kehadiran (%) = (Hadir + Lewat) ÷ jumlah rekod kehadiran bulan tersebut.</p>
    @endif
</div>
@endsection
