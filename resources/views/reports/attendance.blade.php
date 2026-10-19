@extends('layout-fb.layout')

@section('content')
@php
$monthNames = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
    5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
];
@endphp

<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Laporan Kehadiran Bulanan</h1>
        <span class="px-2.5 py-1 text-sm font-medium bg-blue-100 text-blue-700 rounded-full">
            {{ $monthNames[$month] ?? '' }} {{ $year }}
        </span>
    </div>

    {{-- Filter --}}
    <div class="ek-card mb-5">
        <form action="{{ route('reports.attendance') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-40">
                <label class="ek-label">Bulan</label>
                <select name="month"
                        class="ek-input">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $monthNames[$m] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-28">
                <label class="ek-label">Tahun</label>
                <select name="year"
                        class="ek-input">
                    @foreach(range(date('Y') - 2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="ek-btn-primary">
                Jana Laporan
            </button>
        </form>
    </div>

    {{-- Table --}}
    <div class="ek-table-wrap mb-5">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">Bil</th>
                        <th class="px-4 py-3 text-left">Nama Sekolah</th>
                        <th class="px-4 py-3 text-center">Bil. Murid<br><span class="normal-case font-normal">Bulan Lepas</span></th>
                        <th class="px-4 py-3 text-center">Masuk</th>
                        <th class="px-4 py-3 text-center">Keluar</th>
                        <th class="px-4 py-3 text-center">Bil.<br><span class="normal-case font-normal">Terkini</span></th>
                        <th class="px-4 py-3 text-center">Kehadiran (%)</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $index => $school)
                    <tr>
                        <td class="px-4 py-2.5 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-2.5 font-semibold text-gray-900">{{ $school->name }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700">{{ $school->bil_bulan_lepas }}</td>
                        <td class="px-4 py-2.5 text-center">
                            @if($school->murid_masuk > 0)
                                <span class="ek-badge ek-badge-green px-1.5">+{{ $school->murid_masuk }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if($school->murid_keluar > 0)
                                <span class="ek-badge ek-badge-red px-1.5">-{{ $school->murid_keluar }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center font-semibold text-gray-900">{{ $school->bil_terkini }}</td>
                        <td class="px-4 py-2.5 text-center">
                            <p class="font-semibold text-gray-900">{{ number_format($school->peratus_kehadiran, 1) }}%</p>
                            <p class="text-xs text-gray-500">{{ $school->kedatangan_sebenar }} rekod</p>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @php
                                $statusBadge = match($school->status_color) {
                                    'success' => 'bg-green-100 text-green-700',
                                    'warning' => 'bg-yellow-100 text-yellow-700',
                                    default   => 'bg-red-100 text-red-700',
                                };
                            @endphp
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $statusBadge }}">{{ $school->status_label }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-400 text-sm">Tiada data sekolah untuk dipaparkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($schools->isNotEmpty())
    @php
        $avgPeratus = $schools->avg('peratus_kehadiran');
        $avgColor   = $avgPeratus >= 85 ? 'text-green-600' : ($avgPeratus >= 70 ? 'text-yellow-600' : 'text-red-600');
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Purata Kehadiran Keseluruhan</p>
            <p class="text-2xl font-bold {{ $avgColor }}">{{ number_format($avgPeratus, 1) }}%</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Sekolah Cemerlang (≥85%)</p>
            <p class="text-2xl font-bold text-green-600">{{ $schools->where('peratus_kehadiran', '>=', 85)->count() }} / {{ $schools->count() }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Sekolah Perlu Perhatian (&lt;70%)</p>
            <p class="text-2xl font-bold text-red-600">{{ $schools->where('peratus_kehadiran', '<', 70)->count() }} / {{ $schools->count() }}</p>
        </div>
    </div>
    @endif
</div>
@endsection
