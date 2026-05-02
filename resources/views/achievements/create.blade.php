@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Rekod Pencapaian Murid</h1>
        <a href="{{ route('achievements.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-5">
        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Step 1: Pilih Kelas --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        <form method="GET" action="{{ route('achievements.create') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Kelas</label>
                <select name="kafa_class_id" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kafa_class_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Muat Murid
            </button>
        </form>
    </div>

    @if($selectedClass)
    @if(!empty($scrollToStudents))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('student-records-section');
            if (el) el.scrollIntoView({ block: 'start' });
        });
    </script>
    @endif

    <div id="student-records-section">

        {{-- Info bar --}}
        <div class="flex items-center gap-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-4 py-3 mb-4 text-sm text-green-700 dark:text-green-400">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Kelas <strong class="mx-1">{{ $selectedClass->name }}</strong> dipilih — {{ $selectedClass->students->count() }} murid dipaparkan di bawah.
        </div>

        @php
            $hasFinalRecords = isset($existingRecords) && $existingRecords->where('status', 'final')->count() > 0;
            $isGuruKafa = auth()->user()->hasRole('Guru KAFA');
        @endphp

        @if($hasFinalRecords && $isGuruKafa)
        <div class="flex items-start gap-2 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg px-4 py-3 mb-4 text-sm text-yellow-700 dark:text-yellow-400">
            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <div>
                <strong>Sebahagian rekod telah difinalkan.</strong> Rekod bertanda
                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 text-xs font-medium bg-green-600 text-white rounded-full">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Final
                </span>
                tidak boleh diubah oleh Guru KAFA. Hubungi Guru Besar untuk membuka semula.
            </div>
        </div>
        @endif

        <form action="{{ route('achievements.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kafa_class_id" value="{{ $selectedClass->id }}">
            <input type="hidden" name="page" value="{{ $page ?? 1 }}">

            {{-- Exam selectors --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Akademik <span class="text-red-500">*</span></label>
                        <input type="number" name="academic_year"
                               value="{{ old('academic_year', $achievement->academic_year ?? date('Y')) }}"
                               min="2020" max="2099" required
                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    @php $termLabel = ['pertengahan_tahun' => 'PT', 'akhir_tahun' => 'AT', 'lain' => '']; @endphp
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Peperiksaan Pertengahan Tahun</label>
                        <select name="midyear_exam_id"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Tiada --</option>
                            @foreach($exams as $exam)
                                @php $tl = $termLabel[$exam->term] ?? ''; @endphp
                                <option value="{{ $exam->id }}"
                                    {{ old('midyear_exam_id', $achievement->midyear_exam_id ?? '') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }} ({{ $exam->year }}){{ $tl ? ' — '.$tl : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Peperiksaan Akhir Tahun</label>
                        <select name="endyear_exam_id"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Tiada --</option>
                            @foreach($exams as $exam)
                                @php $tl = $termLabel[$exam->term] ?? ''; @endphp
                                <option value="{{ $exam->id }}"
                                    {{ old('endyear_exam_id', $achievement->endyear_exam_id ?? '') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }} ({{ $exam->year }}){{ $tl ? ' — '.$tl : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Per-student cards --}}
            @foreach($selectedClass->students->sortBy('name') as $i => $student)
            @php
                $existing = isset($existingRecords) ? ($existingRecords[$student->id] ?? null) : null;
                $isLocked  = $existing && $existing->status === 'final' && $isGuruKafa;
                $preKelakuan   = old("kelakuan.{$student->id}",   $existing->kelakuan   ?? '');
                $preKebersihan = old("kebersihan.{$student->id}", $existing->kebersihan ?? '');
                $preAmaliSolat = old("amali_solat.{$student->id}", $existing->amali_solat ?? '');
                $prePhciMid    = old("phci_midyear.{$student->id}", $existing->phci_midyear ?? '');
                $prePhciEnd    = old("phci_endyear.{$student->id}", $existing->phci_endyear ?? '');
                $preComments   = old("teacher_comments.{$student->id}", $existing->teacher_comments ?? '');

                $midTotal = 0; $endTotal = 0; $midCount = 0; $endCount = 0;
                $expectedSlots = 9;
                if ($existing && $existing->midyear_exam_id) {
                    $midResults = \App\Models\ExamResult::where('student_id', $student->id)
                        ->where('exam_id', $existing->midyear_exam_id)
                        ->where('is_absent', false)->get();
                    $midTotal = $midResults->sum('marks');
                    $midCount = $midResults->count();
                }
                if ($existing && $existing->endyear_exam_id) {
                    $endResults = \App\Models\ExamResult::where('student_id', $student->id)
                        ->where('exam_id', $existing->endyear_exam_id)
                        ->where('is_absent', false)->get();
                    $endTotal = $endResults->sum('marks');
                    $endCount = $endResults->count();
                }
                $marksIncomplete = $existing &&
                    (($existing->midyear_exam_id && $midCount < $expectedSlots) ||
                     ($existing->endyear_exam_id && $endCount < $expectedSlots));
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-xl border {{ $isLocked ? 'border-green-400 dark:border-green-600' : 'border-gray-200 dark:border-gray-700' }} overflow-hidden mb-3">
                {{-- Card header --}}
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-600 text-white rounded-full">{{ $i + 1 }}</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $student->name }}</span>
                        @if($existing)
                            @if($existing->status === 'final')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Final
                                </span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">Draf</span>
                            @endif
                        @endif
                    </div>
                    {{-- Marks preview --}}
                    @if($existing && ($existing->midyear_exam_id || $existing->endyear_exam_id))
                    <div class="flex flex-wrap gap-1 items-center">
                        @if($existing->midyear_exam_id)
                            <span class="px-1.5 py-0.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded">PT: {{ $midTotal }}</span>
                            <span class="px-1.5 py-0.5 text-xs rounded {{ $midCount >= $expectedSlots ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $midCount }}/{{ $expectedSlots }}</span>
                        @endif
                        @if($existing->endyear_exam_id)
                            <span class="px-1.5 py-0.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded">AT: {{ $endTotal }}</span>
                            <span class="px-1.5 py-0.5 text-xs rounded {{ $endCount >= $expectedSlots ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $endCount }}/{{ $expectedSlots }}</span>
                        @endif
                        <span class="px-1.5 py-0.5 text-xs bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded">Jumlah: {{ $midTotal + $endTotal }}</span>
                    </div>
                    @endif
                </div>

                <div class="p-4 {{ $isLocked ? 'opacity-60' : '' }}">
                    @if($isLocked)
                    <div class="flex items-center gap-2 text-xs text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-3 py-2 mb-3">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Rekod ini telah difinalkan — tidak boleh diubah.
                    </div>
                    @endif

                    @if($marksIncomplete)
                    <div class="flex items-center gap-2 text-xs text-yellow-700 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg px-3 py-2 mb-3">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <span>Markah belum lengkap —
                            @if($existing->midyear_exam_id && $midCount < $expectedSlots) PT: {{ $midCount }}/{{ $expectedSlots }} subjek @endif
                            @if($existing->endyear_exam_id && $endCount < $expectedSlots) AT: {{ $endCount }}/{{ $expectedSlots }} subjek @endif
                        </span>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                        {{-- PHCI PT --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">PHCI (PT)</label>
                            <input type="number" name="phci_midyear[{{ $student->id }}]"
                                   min="0" max="100" placeholder="0–100"
                                   value="{{ $prePhciMid }}" {{ $isLocked ? 'disabled' : '' }}
                                   class="w-full px-2.5 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        </div>

                        {{-- PHCI AT --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">PHCI (AT)</label>
                            <input type="number" name="phci_endyear[{{ $student->id }}]"
                                   min="0" max="100" placeholder="0–100"
                                   value="{{ $prePhciEnd }}" {{ $isLocked ? 'disabled' : '' }}
                                   class="w-full px-2.5 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        </div>

                        {{-- Amali Solat --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Amali Solat</label>
                            <div class="flex gap-1">
                                @foreach(['' => '—', 'Lulus' => 'L', 'Tidak Lulus' => 'TL'] as $val => $lbl)
                                @php
                                    $amId = 'am_'.$student->id.'_'.Str::slug($val ?: 'x');
                                    $checked = $preAmaliSolat === $val;
                                    $color = match($val) { 'Lulus' => 'peer-checked:bg-green-600 peer-checked:border-green-600 peer-checked:text-white', 'Tidak Lulus' => 'peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white', default => 'peer-checked:bg-gray-500 peer-checked:border-gray-500 peer-checked:text-white' };
                                @endphp
                                <label class="flex-1 cursor-pointer {{ $isLocked ? 'pointer-events-none' : '' }}">
                                    <input type="radio" class="peer sr-only" name="amali_solat[{{ $student->id }}]"
                                           id="{{ $amId }}" value="{{ $val }}"
                                           {{ $checked ? 'checked' : '' }} {{ $isLocked ? 'disabled' : '' }}>
                                    <span class="flex items-center justify-center px-2 py-1 text-xs font-medium border border-gray-300 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-400 {{ $color }} transition-colors">{{ $lbl }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Placeholder --}}
                        <div class="hidden md:block"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        {{-- Kelakuan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Kelakuan</label>
                            <div class="flex gap-1">
                                @php $kelColors = ['' => 'peer-checked:bg-gray-500 peer-checked:border-gray-500 peer-checked:text-white', 'A' => 'peer-checked:bg-green-600 peer-checked:border-green-600 peer-checked:text-white', 'B' => 'peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white', 'C' => 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500 peer-checked:text-white', 'D' => 'peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white']; @endphp
                                @foreach(['' => '-', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'] as $val => $lbl)
                                @php
                                    $kelId = 'kel_'.$student->id.'_'.($val ?: 'x');
                                    $checked = $preKelakuan === $val;
                                @endphp
                                <label class="flex-1 cursor-pointer {{ $isLocked ? 'pointer-events-none' : '' }}">
                                    <input type="radio" class="peer sr-only" name="kelakuan[{{ $student->id }}]"
                                           id="{{ $kelId }}" value="{{ $val }}"
                                           {{ $checked ? 'checked' : '' }} {{ $isLocked ? 'disabled' : '' }}>
                                    <span class="flex items-center justify-center px-2 py-1 text-xs font-medium border border-gray-300 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-400 {{ $kelColors[$val] }} transition-colors">{{ $lbl }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Kebersihan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Kebersihan</label>
                            <div class="flex gap-1">
                                @foreach(['' => '-', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'] as $val => $lbl)
                                @php
                                    $kebId = 'keb_'.$student->id.'_'.($val ?: 'x');
                                    $checked = $preKebersihan === $val;
                                @endphp
                                <label class="flex-1 cursor-pointer {{ $isLocked ? 'pointer-events-none' : '' }}">
                                    <input type="radio" class="peer sr-only" name="kebersihan[{{ $student->id }}]"
                                           id="{{ $kebId }}" value="{{ $val }}"
                                           {{ $checked ? 'checked' : '' }} {{ $isLocked ? 'disabled' : '' }}>
                                    <span class="flex items-center justify-center px-2 py-1 text-xs font-medium border border-gray-300 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-400 {{ $kelColors[$val] }} transition-colors">{{ $lbl }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Ulasan Guru --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Ulasan Guru</label>
                        <textarea name="teacher_comments[{{ $student->id }}]" rows="2"
                                  placeholder="Ulasan ringkas prestasi murid..." {{ $isLocked ? 'disabled' : '' }}
                                  class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">{{ $preComments }}</textarea>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Status + Submit --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mt-4">
                <div class="flex flex-wrap items-end gap-4">
                    <div class="w-40">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            @php $currentStatus = old('status', $achievement->status ?? 'draft'); @endphp
                            <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Draf</option>
                            @hasanyrole('Guru Besar|Super Admin')
                            <option value="final" {{ $currentStatus === 'final' ? 'selected' : '' }}>Final</option>
                            @endhasanyrole
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Simpan Rekod
                        </button>
                        <a href="{{ route('achievements.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @else
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg px-4 py-3 text-sm text-blue-700 dark:text-blue-400">
        Pilih kelas di atas untuk memaparkan senarai murid.
    </div>
    @endif
</div>
@endsection
