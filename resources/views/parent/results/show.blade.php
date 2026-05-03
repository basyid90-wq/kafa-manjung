@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Keputusan: {{ $student->name }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Peperiksaan</th>
                        <th class="px-4 py-3 text-left">Tahun</th>
                        <th class="px-4 py-3 text-left">Pencapaian</th>
                        <th class="px-4 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($exams as $exam)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $exam->name }}</td>
                        <td class="px-4 py-2.5 text-gray-600 dark:text-gray-300">{{ $exam->year }}</td>
                        <td class="px-4 py-2.5 text-gray-600 dark:text-gray-300">
                            @php $avg = $exam->results()->where('student_id', $student->id)->avg('marks'); @endphp
                            Purata: {{ round($avg, 2) }}%
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <a href="{{ route('parent.results.detail', [$student, $exam]) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
                                Lihat Butiran
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">Tiada rekod keputusan peperiksaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
