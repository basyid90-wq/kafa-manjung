@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Laporan Prestasi Peperiksaan</h1>
    </div>

    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        <form action="{{ route('reports.exams') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Peperiksaan</label>
                <select name="exam_id" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Peperiksaan --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                            {{ $exam->name }} ({{ $exam->year }})
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Jana Analisis
            </button>
        </form>
    </div>

    @if($examId)

    {{-- District summary cards --}}
    @if($districtTotals && $districtTotals['total_candidates'] > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">JUMLAH CALON DAERAH</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $districtTotals['total_candidates'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">PURATA LULUS DAERAH</p>
            @php $pc = $districtTotals['pass_percentage']; $pcColor = $pc >= 80 ? 'text-green-600 dark:text-green-400' : ($pc >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400'); @endphp
            <p class="text-2xl font-bold {{ $pcColor }}">{{ number_format($pc, 1) }}%</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">GPS PURATA DAERAH</p>
            @php $gps = $districtTotals['gps']; $gpsBadge = $gps <= 2.5 ? 'bg-green-100 text-green-700' : ($gps <= 4.0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'); @endphp
            <span class="inline-block px-3 py-1 text-xl font-bold rounded-lg {{ $gpsBadge }}">{{ number_format($gps, 2) }}</span>
        </div>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-3">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Ranking</th>
                        <th class="px-4 py-3 text-left">Nama Sekolah</th>
                        <th class="px-4 py-3 text-center">Jumlah Calon</th>
                        <th class="px-4 py-3 text-center">Peratus Lulus (%)</th>
                        <th class="px-4 py-3 text-center">GPS</th>
                        <th class="px-4 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @php $rank = 1; @endphp
                    @forelse($schools as $index => $school)
                    <tr id="row-{{ $school->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-2.5">
                            @if($school->total_candidates > 0)
                                @if($rank === 1)
                                    <span class="px-2 py-0.5 text-xs font-bold bg-yellow-100 text-yellow-800 rounded-full">🥇 {{ $rank }}</span>
                                @elseif($rank === 2)
                                    <span class="px-2 py-0.5 text-xs font-bold bg-gray-200 text-gray-700 rounded-full">🥈 {{ $rank }}</span>
                                @elseif($rank === 3)
                                    <span class="px-2 py-0.5 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">🥉 {{ $rank }}</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 rounded-full">{{ $rank }}</span>
                                @endif
                                @php $rank++; @endphp
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $school->name }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700 dark:text-gray-300">{{ $school->total_candidates > 0 ? $school->total_candidates : '—' }}</td>
                        <td class="px-4 py-2.5">
                            @if($school->total_candidates > 0)
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2 min-w-12">
                                    <div class="h-2 rounded-full {{ $school->pass_percentage >= 80 ? 'bg-green-500' : ($school->pass_percentage >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                         style="width: {{ $school->pass_percentage }}%"></div>
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white text-xs">{{ number_format($school->pass_percentage, 1) }}%</span>
                            </div>
                            @else
                            <span class="text-gray-400 text-center block">Tiada Data</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if($school->total_candidates > 0)
                            @php $bg = $school->gps <= 2.5 ? 'bg-green-100 text-green-700' : ($school->gps <= 4.0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'); @endphp
                            <span class="px-2 py-0.5 text-xs font-bold rounded {{ $bg }}">{{ number_format($school->gps, 2) }}</span>
                            @else
                            <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if($school->total_candidates > 0)
                            <a href="{{ route('reports.exams.detail', ['school' => $school->id, 'exam_id' => $examId]) }}"
                               title="Lihat Perincian"
                               class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors inline-flex">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </a>
                            @else
                            <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">Tiada data untuk peperiksaan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($districtTotals && $districtTotals['total_candidates'] > 0)
                <tfoot>
                    <tr class="border-t-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/30 font-semibold">
                        <td colspan="3" class="px-4 py-3 text-right text-gray-900 dark:text-white">Jumlah / Purata Daerah</td>
                        <td class="px-4 py-3 text-center text-gray-900 dark:text-white">{{ $districtTotals['total_candidates'] }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2 min-w-12">
                                    <div class="h-2 rounded-full {{ $districtTotals['pass_percentage'] >= 80 ? 'bg-green-500' : ($districtTotals['pass_percentage'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                         style="width: {{ $districtTotals['pass_percentage'] }}%"></div>
                                </div>
                                <span class="font-bold text-gray-900 dark:text-white text-xs">{{ number_format($districtTotals['pass_percentage'], 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php $bg = $districtTotals['gps'] <= 2.5 ? 'bg-green-100 text-green-700' : ($districtTotals['gps'] <= 4.0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'); @endphp
                            <span class="px-2 py-0.5 text-xs font-bold rounded {{ $bg }}">{{ number_format($districtTotals['gps'], 2) }}</span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <p class="text-xs text-gray-400">* GPS: Gred Purata Sekolah — A=1, B=2, C=3, D=4, E=5, G=6. GPS rendah = prestasi lebih baik.</p>

    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Sila pilih peperiksaan untuk melihat analisis prestasi sekolah.</p>
    </div>
    @endif
</div>
@endsection
