@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Paparan Markah</h1>
            <div class="flex flex-wrap gap-2 mt-2">
                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">{{ $exam->name }}</span>
                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $kafaClass->display_name }}</span>
                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400">{{ $subject->name }}</span>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            @if(!$is_locked)
                <a href="{{ route('exams.results.enter', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Kemaskini Markah
                </a>

                @role('Guru Besar')
                <form action="{{ route('exams.results.lock') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <input type="hidden" name="kafa_class_id" value="{{ $kafaClass->id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                    <button type="button"
                            onclick="if(confirm('Adakah anda pasti untuk mengesahkan dan mengunci markah ini? Tindakan ini tidak boleh diubah.')) this.closest('form').submit();"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Sahkan & Kunci
                    </button>
                </form>
                @endrole
            @else
                <span class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Disahkan & Dikunci
                </span>
            @endif
        </div>
    </div>

    {{-- Slot warning --}}
    @if(!empty($slot_warning))
    <div class="flex items-start gap-3 p-4 mb-5 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl text-sm text-yellow-800 dark:text-yellow-300">
        <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <div>
            <strong>Subjek ini tiada <code class="bg-yellow-100 dark:bg-yellow-800 px-1 rounded">form_slot</code> yang dikenali.</strong>
            Markah akan disimpan tetapi <strong>tidak akan muncul dalam Rekod Pencapaian Murid</strong>.
            Sila tetapkan <em>Form Slot</em> yang betul pada subjek ini dalam Pengurusan Subjek.
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left w-10">No</th>
                        <th class="px-4 py-3 text-left">Nama Murid</th>
                        <th class="px-4 py-3 text-left">MyKid</th>
                        <th class="px-4 py-3 text-center">Markah</th>
                        <th class="px-4 py-3 text-center">Gred</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($students as $index => $student)
                    @php $res = $results->get($student->id); @endphp
                    <tr id="row-{{ $student->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $student->name }}</td>
                        <td class="px-4 py-2.5 text-xs font-mono text-gray-400">{{ $student->mykid }}</td>
                        <td class="px-4 py-2.5 text-center">
                            @if($res)
                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $res->marks ?? '—' }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if($res)
                                @php
                                    $gc = in_array($res->grade, ['E', 'TH'])
                                        ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                        : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full {{ $gc }}">{{ $res->grade }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if($res && $res->is_absent)
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">TH (Tidak Hadir)</span>
                            @elseif($res && $res->marks !== null)
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Hadir</span>
                            @else
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">Belum Berisi</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if($students->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-400">Tiada senarai murid dijumpai untuk kelas ini.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('exams.results.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:underline">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Pemilihan
    </a>
</div>
@endsection
