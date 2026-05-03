@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Slip Keputusan Peperiksaan</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                {{ $exam->name }} ({{ $exam->year }}) &mdash; {{ $student->name }}
            </p>
        </div>
        <button onclick="window.print()"
                class="no-print inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak Slip
        </button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-blue-50 dark:bg-blue-900/20 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-center">Markah</th>
                        <th class="px-4 py-3 text-center">Gred</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @php $totalMarks = 0; $subjectCount = count($results); @endphp
                    @foreach($results as $result)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-900 dark:text-white">{{ $result->subject->name }}</td>
                        <td class="px-4 py-2.5 text-center font-mono font-semibold text-gray-900 dark:text-white">{{ $result->marks }}</td>
                        <td class="px-4 py-2.5 text-center">
                            @php
                                $gc = match($result->grade) {
                                    'A' => 'bg-green-100 text-green-700',
                                    'B' => 'bg-blue-100 text-blue-700',
                                    'C' => 'bg-yellow-100 text-yellow-700',
                                    'D' => 'bg-gray-100 text-gray-600',
                                    default => 'bg-red-100 text-red-700'
                                };
                            @endphp
                            <span class="px-2 py-0.5 text-xs font-bold rounded {{ $gc }}">{{ $result->grade }}</span>
                        </td>
                    </tr>
                    @php $totalMarks += $result->marks; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/30 font-semibold">
                        <td class="px-4 py-3 text-gray-900 dark:text-white">Jumlah Keseluruhan</td>
                        <td class="px-4 py-3 text-center font-bold font-mono text-gray-900 dark:text-white">{{ $totalMarks }}</td>
                        <td class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Purata: {{ $subjectCount > 0 ? round($totalMarks / $subjectCount, 2) : 0 }}%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Grade Legend --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Petunjuk Gred</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1 text-sm text-gray-600 dark:text-gray-300">
            <div><strong>A:</strong> 80 – 100 (Cemerlang)</div>
            <div><strong>D:</strong> 40 – 49 (Mencapai Tahap Minimum)</div>
            <div><strong>B:</strong> 60 – 79 (Baik)</div>
            <div><strong>E:</strong> 0 – 39 (Belum Mencapai Tahap Minimum)</div>
            <div><strong>C:</strong> 50 – 59 (Memuaskan)</div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print, nav, aside, header { display: none !important; }
}
</style>
@endsection
