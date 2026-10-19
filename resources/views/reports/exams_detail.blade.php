@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="ek-page-title">Perincian Prestasi Peperiksaan</h1>
            <p class="ek-page-sub mt-1">{{ $school->name }} &mdash; {{ $exam->name }} ({{ $exam->year }})</p>
        </div>
        <a href="{{ route('reports.exams', ['exam_id' => $examId]) }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">JUMLAH CALON</p>
            <p class="text-2xl font-bold text-blue-600">{{ $overallStats['candidates'] }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">JUMLAH LULUS</p>
            <p class="text-2xl font-bold text-green-600">{{ $overallStats['pass'] }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">PERATUS LULUS</p>
            @php $pc = $overallStats['pass_pct']; $pcColor = $pc >= 80 ? 'text-green-600' : ($pc >= 60 ? 'text-yellow-600' : 'text-red-600'); @endphp
            <p class="text-2xl font-bold {{ $pcColor }}">{{ number_format($pc, 1) }}%</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">GPS SEKOLAH</p>
            @php $gps = $overallStats['gps']; $gpsBg = $gps <= 2.5 ? 'bg-green-100 text-green-700' : ($gps <= 4.0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'); @endphp
            <span class="inline-block px-3 py-1 text-xl font-bold rounded-lg {{ $gpsBg }}">{{ number_format($gps, 2) }}</span>
        </div>
    </div>

    {{-- Helper macro for subject/class tables --}}
    @php
    function statusBadge($pct) {
        if ($pct >= 80) return 'bg-green-100 text-green-700';
        if ($pct >= 60) return 'bg-yellow-100 text-yellow-700';
        return 'bg-red-100 text-red-700';
    }
    function statusLabel($pct) {
        if ($pct >= 80) return 'Cemerlang';
        if ($pct >= 60) return 'Memuaskan';
        return 'Perlu Perhatian';
    }
    function gpsBadge($gps) {
        if ($gps <= 2.5) return 'bg-green-100 text-green-700';
        if ($gps <= 4.0) return 'bg-yellow-100 text-yellow-700';
        return 'bg-red-100 text-red-700';
    }
    @endphp

    {{-- Per Subjek --}}
    <div class="ek-table-wrap mb-5">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Prestasi Mengikut Subjek</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Subjek</th>
                        <th class="px-4 py-3 text-center">Calon</th>
                        <th class="px-4 py-3 text-center">Lulus</th>
                        <th class="px-4 py-3 text-center">Peratus Lulus (%)</th>
                        <th class="px-4 py-3 text-center">GPS</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bySubject as $index => $row)
                    <tr>
                        <td class="px-4 py-2.5 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900">{{ $row['subject']->name ?? '—' }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700">{{ $row['candidates'] }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700">{{ $row['pass'] }}</td>
                        <td class="px-4 py-2.5">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-10">
                                    <div class="h-2 rounded-full {{ $row['pass_pct'] >= 80 ? 'bg-green-500' : ($row['pass_pct'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                         style="width: {{ $row['pass_pct'] }}%"></div>
                                </div>
                                <span class="font-semibold text-xs text-gray-900">{{ number_format($row['pass_pct'], 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <span class="px-2 py-0.5 text-xs font-bold rounded {{ gpsBadge($row['gps']) }}">{{ number_format($row['gps'], 2) }}</span>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ statusBadge($row['pass_pct']) }}">{{ statusLabel($row['pass_pct']) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400 text-sm">Tiada data subjek.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Per Kelas --}}
    <div class="ek-table-wrap mb-4">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Prestasi Mengikut Kelas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Kelas</th>
                        <th class="px-4 py-3 text-center">Calon</th>
                        <th class="px-4 py-3 text-center">Lulus</th>
                        <th class="px-4 py-3 text-center">Peratus Lulus (%)</th>
                        <th class="px-4 py-3 text-center">GPS</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($byClass as $index => $row)
                    <tr>
                        <td class="px-4 py-2.5 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900">{{ $row['class_name'] }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700">{{ $row['candidates'] }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700">{{ $row['pass'] }}</td>
                        <td class="px-4 py-2.5">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-10">
                                    <div class="h-2 rounded-full {{ $row['pass_pct'] >= 80 ? 'bg-green-500' : ($row['pass_pct'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                         style="width: {{ $row['pass_pct'] }}%"></div>
                                </div>
                                <span class="font-semibold text-xs text-gray-900">{{ number_format($row['pass_pct'], 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <span class="px-2 py-0.5 text-xs font-bold rounded {{ gpsBadge($row['gps']) }}">{{ number_format($row['gps'], 2) }}</span>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ statusBadge($row['pass_pct']) }}">{{ statusLabel($row['pass_pct']) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400 text-sm">Tiada data kelas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-xs text-gray-400">* GPS: A=1, B=2, C=3, D=4, E=5, G=6. GPS rendah = prestasi lebih baik. Murid lulus hanya jika SEMUA subjek gred A–E.</p>
</div>
@endsection
