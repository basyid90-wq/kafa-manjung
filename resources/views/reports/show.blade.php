@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <h1 class="ek-page-title">Profil Analisis Murid</h1>
        <div class="flex items-center gap-2">
            <a href="javascript:void(0);" onclick="openPdfBlob(this, '{{ route('reports.export.pdf', $student) }}')"
               class="ek-btn-secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                PDF
            </a>
            <a href="{{ route('reports.export.excel', $student) }}"
               class="ek-btn-secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Excel
            </a>
        </div>
    </div>

    {{-- Student Info --}}
    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
            <div>
                <p class="mb-1"><span class="text-gray-500 w-28 inline-block">Nama:</span> <strong class="text-gray-900">{{ $student->name }}</strong></p>
                <p class="mb-1"><span class="text-gray-500 w-28 inline-block">MyKid:</span> <span class="font-mono text-gray-700">{{ $student->mykid }}</span></p>
                <p class="mb-1"><span class="text-gray-500 w-28 inline-block">Jantina:</span> <span class="text-gray-700">{{ $student->gender }}</span></p>
            </div>
            <div>
                <p class="mb-1"><span class="text-gray-500 w-28 inline-block">Sekolah:</span> <span class="text-gray-700">{{ $student->school->name }}</span></p>
                <p class="mb-1"><span class="text-gray-500 w-28 inline-block">Kelas:</span> <span class="text-gray-700">{{ $student->kafaClass->display_name }}</span></p>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Kehadiran</p>
            <p class="text-3xl font-bold text-blue-600">{{ $data['attendance']['percentage'] }}%</p>
            <p class="text-xs text-gray-400 mt-1">{{ $data['attendance']['present_days'] }}/{{ $data['attendance']['total_days'] }} Hari</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Kesalahan Disiplin</p>
            <p class="text-3xl font-bold text-red-600">{{ $data['disciplinary_records']->count() }}</p>
            <p class="text-xs text-gray-400 mt-1">Kes Rekod</p>
        </div>
        <div class="ek-card text-center">
            <p class="text-xs text-gray-500 mb-1">Penyertaan Aktiviti</p>
            <p class="text-3xl font-bold text-green-600">{{ $data['activities']->count() }}</p>
            <p class="text-xs text-gray-400 mt-1">Program</p>
        </div>
    </div>

    {{-- Exam Results --}}
    <div class="ek-table-wrap mb-5">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Keputusan Peperiksaan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">Peperiksaan</th>
                        <th class="px-4 py-3 text-left">Subjek</th>
                        <th class="px-4 py-3 text-center">Markah</th>
                        <th class="px-4 py-3 text-center">Gred</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['exam_results'] as $res)
                    <tr>
                        <td class="px-4 py-2.5 text-gray-700">{{ $res->exam->name }}</td>
                        <td class="px-4 py-2.5 text-gray-700">{{ $res->subject->name }}</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-900">{{ $res->marks }}</td>
                        <td class="px-4 py-2.5 text-center">
                            @php
                                $grade = $res->grade ?: app(\App\Services\ExamService::class)->calculateGrade($res->marks);
                                $gc = match($grade) { 'A' => 'bg-green-100 text-green-700', 'B' => 'bg-blue-100 text-blue-700', 'C' => 'bg-yellow-100 text-yellow-700', 'D' => 'bg-gray-100 text-gray-600', default => 'bg-red-100 text-red-700' };
                            @endphp
                            <span class="px-2 py-0.5 text-xs font-bold rounded {{ $gc }}">{{ $grade }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Disciplinary --}}
    <div class="ek-table-wrap mb-5">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Kronologi Disiplin</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">Tarikh</th>
                        <th class="px-4 py-3 text-left">Butiran Kesalahan</th>
                        <th class="px-4 py-3 text-left">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['disciplinary_records'] as $dis)
                    <tr>
                        <td class="px-4 py-2.5 text-gray-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($dis->date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2.5 text-gray-700">{{ $dis->offense_details }}</td>
                        <td class="px-4 py-2.5 text-gray-700">{{ $dis->action_taken }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400 text-sm">Tiada rekod disiplin.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('reports.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:underline">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Senarai
    </a>
</div>
@endsection
