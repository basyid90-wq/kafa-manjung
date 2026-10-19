@extends('layout-fb.layout')

@section('content')
@php
$examService = app(\App\Services\ExamService::class);
$passBar   = fn ($p) => $p >= 80 ? 'bg-green-500' : ($p >= 60 ? 'bg-yellow-500' : 'bg-red-500');
$passBadge = fn ($p) => $p >= 80 ? 'ek-badge-green' : ($p >= 60 ? 'ek-badge-yellow' : 'ek-badge-red');
$passLabel = fn ($p) => $p >= 80 ? 'Cemerlang' : ($p >= 60 ? 'Memuaskan' : 'Perlu Perhatian');
@endphp

<div>

    <div class="mb-6">
        <h1 class="ek-page-title">Laporan Prestasi Peperiksaan</h1>
        <p class="ek-page-sub mt-1">
            {{ $school?->name ?? 'Prestasi mengikut kelas dan subjek' }}@if($exam) &mdash; {{ $exam->name }} ({{ $exam->year }})@endif
        </p>
    </div>

    {{-- Filter --}}
    <div class="ek-card mb-5">
        <form action="{{ route('reports.exams') }}" method="GET" class="flex flex-wrap items-end gap-3">
            @include('reports._school_picker')
            @if($school)
            <div class="flex-1 min-w-48">
                <label class="ek-label">Pilih Peperiksaan</label>
                <select name="exam_id" required class="ek-input">
                    <option value="">-- Pilih Peperiksaan --</option>
                    @foreach($exams as $e)
                        <option value="{{ $e->id }}" {{ $exam?->id == $e->id ? 'selected' : '' }}>{{ $e->name }} ({{ $e->year }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="ek-btn-primary">Jana Analisis</button>
            @endif
        </form>
    </div>

    @if(!$school)
        @include('reports._pick_school')
    @elseif(!$exam)
    <div class="ek-card text-center" style="padding:3rem 1.25rem">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <p class="text-gray-500 text-sm">{{ $exams->isEmpty() ? 'Belum ada peperiksaan didaftarkan untuk sekolah ini.' : 'Sila pilih peperiksaan untuk melihat analisis prestasi.' }}</p>
    </div>
    @elseif($overall['candidates'] === 0)
    <div class="ek-card text-center" style="padding:3rem 1.25rem">
        <p class="text-gray-500 text-sm">Tiada markah dimasukkan untuk peperiksaan ini.</p>
    </div>
    @else

    {{-- Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Jumlah Calon</p>
            <p class="text-2xl font-bold text-blue-600">{{ $overall['candidates'] }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Lulus Semua Subjek</p>
            <p class="text-2xl font-bold text-green-600">{{ $overall['pass'] }}</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Peratus Lulus</p>
            <p class="text-2xl font-bold {{ $overall['pass_pct'] >= 80 ? 'text-green-600' : ($overall['pass_pct'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ number_format($overall['pass_pct'], 1) }}%</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Purata Markah</p>
            <p class="text-2xl font-bold text-gray-900">{{ $overall['avg'] === null ? '—' : number_format($overall['avg'], 1) }}</p>
            @if($overall['avg'] !== null)
            <span class="ek-badge {{ $examService->badgeClass($examService->calculateGrade($overall['avg'])) }} font-bold mt-1">Gred {{ $examService->calculateGrade($overall['avg']) }}</span>
            @endif
        </div>
    </div>

    {{-- Grade distribution --}}
    <div class="ek-card mb-5">
        <h2 class="text-sm font-semibold text-gray-700 mb-3">Taburan Gred (semua subjek)</h2>
        @php $totalGraded = array_sum($overall['grades']) + $overall['absent']; @endphp
        <div class="flex flex-wrap gap-3">
            @foreach($gradeScale as $g)
            @php $n = $overall['grades'][$g['grade']]; @endphp
            <div class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2">
                <span class="ek-badge {{ $examService->badgeClass($g['grade']) }} font-bold">{{ $g['grade'] }}</span>
                <span class="text-sm font-semibold text-gray-900">{{ $n }}</span>
                <span class="text-xs text-gray-500">({{ $totalGraded > 0 ? number_format($n / $totalGraded * 100, 1) : 0 }}%)</span>
            </div>
            @endforeach
            @if($overall['absent'] > 0)
            <div class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2">
                <span class="ek-badge ek-badge-gray font-bold">{{ config('grading.absent_grade') }}</span>
                <span class="text-sm font-semibold text-gray-900">{{ $overall['absent'] }}</span>
            </div>
            @endif
        </div>
    </div>

    @foreach([
        ['title' => 'Prestasi Mengikut Kelas',  'col' => 'Kelas',  'rows' => $byClass],
        ['title' => 'Prestasi Mengikut Subjek', 'col' => 'Subjek', 'rows' => $bySubject],
    ] as $table)
    <div class="ek-table-wrap mb-5">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">{{ $table['title'] }}</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>{{ $table['col'] }}</th>
                        <th class="text-center">Calon</th>
                        <th class="text-center">Lulus</th>
                        <th>Peratus Lulus (%)</th>
                        <th class="text-center">Purata Markah</th>
                        @foreach($gradeScale as $g)
                        <th class="text-center">{{ $g['grade'] }}</th>
                        @endforeach
                        <th class="text-center">{{ config('grading.absent_grade') }}</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($table['rows'] as $i => $row)
                    <tr>
                        <td class="text-gray-500">{{ $i + 1 }}</td>
                        <td class="font-medium text-gray-900">{{ $row['name'] }}</td>
                        <td class="text-center">{{ $row['candidates'] }}</td>
                        <td class="text-center">{{ $row['pass'] }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-12">
                                    <div class="h-2 rounded-full {{ $passBar($row['pass_pct']) }}" style="width: {{ $row['pass_pct'] }}%"></div>
                                </div>
                                <span class="font-semibold text-gray-900 text-xs">{{ number_format($row['pass_pct'], 1) }}%</span>
                            </div>
                        </td>
                        <td class="text-center font-semibold text-gray-900">{{ $row['avg'] === null ? '—' : number_format($row['avg'], 1) }}</td>
                        @foreach($gradeScale as $g)
                        <td class="text-center">{{ $row['grades'][$g['grade']] ?: '—' }}</td>
                        @endforeach
                        <td class="text-center">{{ $row['absent'] ?: '—' }}</td>
                        <td class="text-center"><span class="ek-badge {{ $passBadge($row['pass_pct']) }}">{{ $passLabel($row['pass_pct']) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    <p class="text-xs text-gray-400">
        * Skala gred:
        {{ collect($gradeScale)->map(fn ($g) => "{$g['grade']} {$g['min']}–{$g['max']} ({$g['label']})")->implode(', ') }}.
        Subjek lulus jika gred bukan {{ implode(' / ', config('grading.fail_grades')) }}. Calon lulus hanya jika lulus SEMUA subjek.
        Kiraan gred di jadual kelas adalah bilangan subjek.
    </p>
    @endif
</div>
@endsection
