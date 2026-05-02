@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    {{-- Header + Year Filter --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Analitik Pencapaian Murid</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Paparan prestasi murid mengikut sekolah dalam daerah.</p>
        </div>
        <form method="GET" action="{{ route('achievements.index') }}" class="flex items-center gap-2">
            <label class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">Tahun:</label>
            <select name="academic_year" onchange="this.form.submit()"
                    class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @foreach($years as $yr)
                    <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Jumlah Sekolah</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $summary['totalSchools'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Jumlah Murid</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $summary['totalStudents'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Telah Dinilai</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $summary['totalRecorded'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Belum Rekod</p>
            <p class="text-2xl font-bold {{ $summary['belumRekod'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                {{ $summary['belumRekod'] }} sekolah
            </p>
        </div>
    </div>

    {{-- Overall Progress --}}
    @if($summary['totalStudents'] > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-500 dark:text-gray-400">Keseluruhan Penilaian Daerah ({{ $selectedYear }})</span>
            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $summary['overallPct'] }}%</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div class="h-2 rounded-full {{ $summary['overallPct'] >= 80 ? 'bg-green-500' : ($summary['overallPct'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                 style="width: {{ $summary['overallPct'] }}%"></div>
        </div>
    </div>
    @endif

    {{-- Top 10 Students --}}
    @if($topStudents->isNotEmpty())
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl p-5 mb-5">
        <h2 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
            Top 10 Pelajar Terbaik ({{ $selectedYear }})
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-300">
                <thead>
                    <tr class="border-b border-white/20 text-xs text-gray-400 uppercase">
                        <th class="pb-2 pr-4 w-20">Kedudukan</th>
                        <th class="pb-2 pr-4">Nama Murid</th>
                        <th class="pb-2 pr-4">Sekolah</th>
                        <th class="pb-2 text-right">Jumlah Markah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topStudents as $i => $rec)
                    <tr class="border-b border-white/10">
                        <td class="py-2 pr-4">
                            @if($i === 0) <span class="text-sm">🥇 #1</span>
                            @elseif($i === 1) <span class="text-sm">🥈 #2</span>
                            @elseif($i === 2) <span class="text-sm">🥉 #3</span>
                            @else <span class="text-xs text-gray-400">#{{ $i + 1 }}</span>
                            @endif
                        </td>
                        <td class="py-2 pr-4 font-semibold text-white">{{ $rec->student->name ?? '—' }}</td>
                        <td class="py-2 pr-4 text-xs">{{ $rec->school->name ?? '—' }}</td>
                        <td class="py-2 text-right font-mono font-bold text-white">{{ number_format($rec->total_marks) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Warning --}}
    @if($summary['belumRekod'] > 0)
    <div class="flex items-center gap-3 p-4 mb-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl text-sm text-yellow-800 dark:text-yellow-300">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <span><strong>{{ $summary['belumRekod'] }} sekolah</strong> belum ada rekod pencapaian untuk tahun {{ $selectedYear }}.</span>
    </div>
    @endif

    {{-- School Ranking Table --}}
    <div class="mb-4">
        <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">Ranking Sekolah — Penilaian {{ $selectedYear }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3 w-24">Ranking</th>
                        <th class="px-5 py-3">Nama Sekolah</th>
                        <th class="px-5 py-3 text-center">Jumlah Murid</th>
                        <th class="px-5 py-3 text-center">Telah Dinilai</th>
                        <th class="px-5 py-3 text-center w-40">Peratus (%)</th>
                        <th class="px-5 py-3 text-center w-20">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @php $rank = 1; @endphp
                    @forelse($schools as $i => $school)
                    @php
                        $pct = $school->students_count > 0
                            ? round(($school->achievements_count / $school->students_count) * 100, 1) : 0;
                        $belumRekod = $school->achievements_count === 0;
                        $barColor = $pct >= 80 ? 'bg-green-500' : ($pct >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                        $badgeColor = $pct >= 80 ? 'green' : ($pct >= 50 ? 'yellow' : 'red');
                    @endphp
                    <tr id="row-{{ $school->id }}" class="{{ $belumRekod ? 'bg-red-50 dark:bg-red-900/10' : 'bg-white dark:bg-gray-800' }} hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-5 py-3">
                            @if(!$belumRekod)
                                @if($rank === 1) <span class="text-sm">🥇 {{ $rank }}</span>
                                @elseif($rank === 2) <span class="text-sm">🥈 {{ $rank }}</span>
                                @elseif($rank === 3) <span class="text-sm">🥉 {{ $rank }}</span>
                                @else <span class="text-xs text-gray-500">#{{ $rank }}</span>
                                @endif
                                @php $rank++; @endphp
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Belum Rekod</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">{{ $school->name }}</td>
                        <td class="px-5 py-3 text-center">{{ $school->students_count }}</td>
                        <td class="px-5 py-3 text-center">{{ $school->achievements_count }}</td>
                        <td class="px-5 py-3">
                            @if(!$belumRekod)
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="{{ $barColor }} h-1.5 rounded-full" style="width:{{ $pct }}%"></div>
                                </div>
                                <span class="text-xs font-medium inline-flex items-center px-2 py-0.5 rounded-full
                                    bg-{{ $badgeColor }}-100 text-{{ $badgeColor }}-700
                                    dark:bg-{{ $badgeColor }}-900/30 dark:text-{{ $badgeColor }}-400">
                                    {{ $pct }}%
                                </span>
                            </div>
                            @else
                            <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-center">
                            <a href="{{ route('achievements.school_list', $school->id) }}"
                               class="p-1.5 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors inline-flex"
                               title="Lihat Rekod Murid">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-gray-400 text-sm">Tiada sekolah dijumpai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
