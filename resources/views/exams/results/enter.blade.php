@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Kemasukan Markah Peperiksaan</h1>
        <div class="flex flex-wrap gap-2 mt-2">
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">{{ $exam->name }}</span>
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $kafaClass->display_name }}</span>
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400">{{ $subject->name }}</span>
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

    <form action="{{ route('exams.results.store') }}" method="POST" id="marksForm">
        @csrf
        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="kafa_class_id" value="{{ $kafaClass->id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-24">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left w-10">No</th>
                            <th class="px-4 py-3 text-left">Nama Murid</th>
                            <th class="px-4 py-3 text-center w-36">Markah (0-100)</th>
                            <th class="px-4 py-3 text-center w-20">TH</th>
                            <th class="px-4 py-3 text-center w-24">Kosongkan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($students as $index => $student)
                        @php $res = $results->get($student->id); @endphp
                        <tr id="row-{{ $student->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-2.5">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $student->name }}</p>
                                <p class="text-xs text-gray-400 font-mono">{{ $student->mykid }}</p>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <input type="number"
                                       name="marks[{{ $student->id }}]"
                                       class="input-mark w-24 px-2 py-1.5 text-center text-lg font-bold border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:opacity-50 disabled:cursor-not-allowed"
                                       value="{{ $res ? $res->marks : '' }}"
                                       min="0" max="100"
                                       placeholder="0-100"
                                       @if($res && $res->is_absent) disabled @endif>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <input type="checkbox"
                                       id="th-{{ $student->id }}"
                                       name="absent[{{ $student->id }}]"
                                       value="1"
                                       class="checkbox-absent w-4 h-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400"
                                       @if($res && $res->is_absent) checked @endif>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                @if($res)
                                <input type="checkbox"
                                       id="clear-{{ $student->id }}"
                                       name="clear[{{ $student->id }}]"
                                       value="1"
                                       class="checkbox-clear w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-400"
                                       title="Padamkan rekod murid ini">
                                @else
                                <span class="text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sticky Save Footer --}}
        <div class="fixed bottom-0 left-0 right-0 lg:left-64 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-3 z-30">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
                <p class="text-xs text-gray-400 hidden md:block">
                    <svg class="w-4 h-4 inline mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pastikan semua markah telah dimasukkan sebelum tekan Simpan.
                </p>
                <div class="flex items-center gap-2 ml-auto">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Markah
                    </button>
                    <a href="{{ route('exams.results.show', request()->query()) }}"
                       class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // TH checkbox toggles mark input
    document.querySelectorAll('.checkbox-absent').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var row = this.closest('tr');
            var markInput = row.querySelector('.input-mark');
            if (this.checked) {
                markInput.value = '';
                markInput.disabled = true;
            } else {
                markInput.disabled = false;
                markInput.focus();
            }
        });
    });

    // Kosongkan checkbox disables mark + TH
    document.querySelectorAll('.checkbox-clear').forEach(function(cb) {
        cb.addEventListener('change', function() {
            var row = this.closest('tr');
            var markInput = row.querySelector('.input-mark');
            var thCheckbox = row.querySelector('.checkbox-absent');
            if (this.checked) {
                markInput.value = '';
                markInput.disabled = true;
                if (thCheckbox) { thCheckbox.checked = false; thCheckbox.disabled = true; }
                row.style.opacity = '0.5';
            } else {
                markInput.disabled = false;
                if (thCheckbox) thCheckbox.disabled = false;
                row.style.opacity = '';
            }
        });
    });

    // Scroll to highlighted row
    if (window.location.hash) {
        var el = document.getElementById(window.location.hash.substring(1));
        if (el) {
            el.scrollIntoView({ block: 'center' });
            el.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
            setTimeout(function() { el.classList.remove('bg-blue-50', 'dark:bg-blue-900/20'); }, 2000);
        }
    }
});
</script>
@endsection
