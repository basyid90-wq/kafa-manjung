@extends('layout-fb.layout')

@section('content')
@php
use App\Services\ExamService;
$examService = app(ExamService::class);

$formSlotLabels = [
    'tilawah_tahfiz' => 'Tilawah & Tahfiz Al-Quran',
    'lughati'        => 'Lughati',
    'ibadah'         => 'Ibadah',
    'akidah'         => 'Akidah',
    'sirah'          => 'Sirah & Tamadun Islam',
    'adab'           => 'Adab & Akhlak',
    'jawi_khat'      => 'Jawi & Khat',
    'bahasa_arab'    => 'Bahasa Arab',
    'amali_solat'    => 'Amali Solat',
];
$allSlots = array_keys($formSlotLabels);
@endphp

<div class="p-4 md:p-6">

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Rekod Pencapaian</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $achievement->student->name }}</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            @hasanyrole('Guru Besar|Super Admin')
            @if($achievement->status === 'final')
            <form method="POST" action="{{ route('achievements.unlock', $achievement->id) }}"
                  data-delete-form data-name="buka semula rekod ini sebagai Draf">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg hover:bg-orange-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                    Buka Semula
                </button>
            </form>
            @else
            <a href="{{ route('achievements.edit', $achievement->id) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Kemaskini
            </a>
            @endif
            @endhasanyrole
            @hasrole('Guru KAFA')
            @if($achievement->status !== 'final')
            <a href="{{ route('achievements.edit', $achievement->id) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Kemaskini
            </a>
            @endif
            @endhasrole
            <a href="javascript:void(0);" onclick="openPdfBlob(this, '{{ route('achievements.pdf', $achievement->id) }}')"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak PDF
            </a>
            <a href="{{ route('achievements.index') }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @php
        $hasMissingMid = $achievement->midyear_exam_id && $midResults->count() < count($allSlots);
        $hasMissingEnd = $achievement->endyear_exam_id && $endResults->count() < count($allSlots);
        $noExamLinked  = !$achievement->midyear_exam_id && !$achievement->endyear_exam_id;
    @endphp

    @if($noExamLinked || $hasMissingMid || $hasMissingEnd || $achievement->status === 'draft')
    <div class="flex items-start gap-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl px-4 py-3 mb-5 text-sm text-yellow-700 dark:text-yellow-400">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <div>
            @if($achievement->status === 'draft')
                <strong>Rekod ini masih DRAF.</strong> PDF boleh dicetak tetapi ditandakan sebagai draf.<br>
            @endif
            @if($noExamLinked)
                <strong>Tiada peperiksaan dipaut.</strong> Markah tidak akan muncul dalam rekod ini.<br>
            @else
                @if($hasMissingMid)
                    Markah <strong>Pertengahan Tahun</strong> belum lengkap ({{ $midResults->count() }}/{{ count($allSlots) }} mata pelajaran diisi).<br>
                @endif
                @if($hasMissingEnd)
                    Markah <strong>Akhir Tahun</strong> belum lengkap ({{ $endResults->count() }}/{{ count($allSlots) }} mata pelajaran diisi).<br>
                @endif
            @endif
            @hasanyrole('Guru Besar|Guru KAFA')
            <a href="{{ route('achievements.edit', $achievement->id) }}" class="font-semibold underline">Kemaskini rekod &rarr;</a>
            @endhasanyrole
        </div>
    </div>
    @endif

    {{-- Student Info --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Nama</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $achievement->student->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Nama Jawi</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $achievement->student->jawi_name ?? '-' }}</span>
                </div>
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">No. Kad Pengenalan</span>
                    <span class="font-mono text-gray-700 dark:text-gray-300">{{ $achievement->student->mykid }}</span>
                </div>
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Kelas</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $achievement->kafaClass->name ?? '-' }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Sekolah</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $achievement->school->name ?? '-' }}</span>
                </div>
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Tahun Akademik</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $achievement->academic_year }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Status</span>
                    @if($achievement->status === 'final')
                        <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">Final</span>
                    @else
                        <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">Draf</span>
                    @endif
                </div>
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Kedudukan Kelas</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $achievement->class_rank ?? '-' }} / {{ $achievement->total_in_class ?? '-' }}</span>
                </div>
                <div class="flex">
                    <span class="w-40 text-gray-500 dark:text-gray-400">Kedudukan Darjah</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $achievement->grade_rank ?? '-' }} / {{ $achievement->total_in_grade ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Marks Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-5">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Markah Peperiksaan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-center">Pertengahan Tahun</th>
                        <th class="px-4 py-3 text-center">Akhir Tahun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($allSlots as $i => $slot)
                    @php
                        $midR = $midResults->get($slot);
                        $endR = $endResults->get($slot);
                        $midVal = $midR ? ($midR->is_absent ? 'TH' : $examService->formatMark($midR->marks)) : '-';
                        $endVal = $endR ? ($endR->is_absent ? 'TH' : $examService->formatMark($endR->marks)) : '-';
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-2.5 text-gray-900 dark:text-white">{{ $formSlotLabels[$slot] }}</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">{{ $midVal }}</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">{{ $endVal }}</td>
                    </tr>
                    @endforeach
                    {{-- PHCI --}}
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 bg-blue-50/40 dark:bg-blue-900/10">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ count($allSlots) + 1 }}</td>
                        <td class="px-4 py-2.5 text-gray-900 dark:text-white font-medium">Penghayatan Cara Hidup Islam (PHCI)</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">
                            {{ $achievement->phci_midyear !== null ? $examService->formatMark($achievement->phci_midyear) : '-' }}
                        </td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">
                            {{ $achievement->phci_endyear !== null ? $examService->formatMark($achievement->phci_endyear) : '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Lain-lain --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Penilaian Lain</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Kelakuan</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $achievement->kelakuan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Kebersihan</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $achievement->kebersihan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Amali Solat</p>
                @if($achievement->amali_solat === 'Lulus')
                    <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">Lulus</span>
                @elseif($achievement->amali_solat === 'Tidak Lulus')
                    <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full">Tidak Lulus</span>
                @else
                    <p class="text-gray-500 dark:text-gray-400">-</p>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Ulasan Guru</p>
                <p class="text-gray-700 dark:text-gray-300">{{ $achievement->teacher_comments ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
