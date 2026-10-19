@extends('layout-fb.layout')

@section('content')
<div>

    <div class="mb-6">
        <h1 class="ek-page-title">Keputusan: {{ $student->name }}</h1>
    </div>

    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">Peperiksaan</th>
                        <th class="px-4 py-3 text-left">Tahun</th>
                        <th class="px-4 py-3 text-left">Pencapaian</th>
                        <th class="px-4 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                    <tr>
                        <td class="px-4 py-2.5 font-medium text-gray-900">{{ $exam->name }}</td>
                        <td class="px-4 py-2.5 text-gray-600">{{ $exam->year }}</td>
                        <td class="px-4 py-2.5 text-gray-600">
                            @php $avg = $exam->results()->where('student_id', $student->id)->avg('marks'); @endphp
                            Purata: {{ round($avg, 2) }}%
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <a href="{{ route('parent.results.detail', [$student, $exam]) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
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
