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
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Laporan Kehadiran Bulanan</h1>
        <span class="px-2.5 py-1 text-sm font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
            {{ $monthNames[$month] ?? '' }} {{ $year }}
        </span>
    </div>

    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        <form action="{{ route('reports.attendance') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
                <select name="month"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $monthNames[$m] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-28">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                <select name="year"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @foreach(range(date('Y') - 2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
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
                        <th class="px-4 py-3 text-center">Bil. Murid<br><span class="normal-case font-normal">Bulan Lepas</span></th>
                        <th class="px-4 py-3 text-center">Masuk</th>
                        <th class="px-4 py-3 text-center">Keluar</th>
                        <th class="px-4 py-3 text-center">Bil.<br><span class="normal-case font-normal">Terkini</span></th>
                        <th class="px-4 py-3 text-center">Kehadiran (%)</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($schools as $index => $school)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-2.5 font-semibold text-gray-900 dark:text-white">{{ $school->name }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700 dark:text-gray-300">{{ $school->bil_bulan_lepas }}</td>
                        <td class="px-4 py-2.5 text-center">
                            @if($school->murid_masuk > 0)
                                <span class="px-1.5 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">+{{ $school->murid_masuk }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if($school->murid_keluar > 0)
                                <span class="px-1.5 py-0.5 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full">-{{ $school->murid_keluar }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center font-semibold text-gray-900 dark:text-white">{{ $school->bil_terkini }}</td>
                        <td class="px-4 py-2.5 text-center">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ number_format($school->peratus_kehadiran, 1) }}%</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $school->kedatangan_sebenar }} rekod</p>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @php
                                $statusBadge = match($school->status_color) {
                                    'success' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    'warning' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    default   => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
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
        $avgColor   = $avgPeratus >= 85 ? 'text-green-600 dark:text-green-400' : ($avgPeratus >= 70 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400');
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Purata Kehadiran Keseluruhan</p>
            <p class="text-2xl font-bold {{ $avgColor }}">{{ number_format($avgPeratus, 1) }}%</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Sekolah Cemerlang (≥85%)</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $schools->where('peratus_kehadiran', '>=', 85)->count() }} / {{ $schools->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Sekolah Perlu Perhatian (&lt;70%)</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $schools->where('peratus_kehadiran', '<', 70)->count() }} / {{ $schools->count() }}</p>
        </div>
    </div>
    @endif
</div>
@endsection
