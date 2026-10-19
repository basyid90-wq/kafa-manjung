@extends('layout-fb.layout')

@section('content')
<div>

    <div class="mb-5">
        <h1 class="ek-page-title">Kemasukan Markah Peperiksaan</h1>
        <div class="flex flex-wrap gap-2 mt-2">
            <span class="ek-badge ek-badge-blue">{{ $exam->name }}</span>
            <span class="ek-badge ek-badge-gray">{{ $kafaClass->display_name }}</span>
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-cyan-100 text-cyan-700">{{ $subject->name }}</span>
        </div>
    </div>

    {{-- Slot warning --}}
    @if(!empty($slot_warning))
    <div class="flex items-start gap-3 p-4 mb-5 bg-yellow-50 border border-yellow-200 rounded-xl text-sm text-yellow-800">
        <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <div>
            <strong>Subjek ini tiada <code class="bg-yellow-100 px-1 rounded">form_slot</code> yang dikenali.</strong>
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

        <div class="ek-table-wrap mb-24">
            <div class="overflow-x-auto">
                <table class="ek-table">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left w-10">No</th>
                            <th class="px-4 py-3 text-left">Nama Murid</th>
                            <th class="px-4 py-3 text-center w-36">Markah (0-100)</th>
                            <th class="px-4 py-3 text-center w-20">TH</th>
                            <th class="px-4 py-3 text-center w-24">Kosongkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        @php $res = $results->get($student->id); @endphp
                        <tr id="row-{{ $student->id }}">
                            <td class="px-4 py-2.5 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-2.5">
                                <p class="font-medium text-gray-900">{{ $student->name }}</p>
                                <p class="text-xs text-gray-400 font-mono">{{ $student->mykid }}</p>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <input type="number"
                                       name="marks[{{ $student->id }}]"
                                       class="ek-input input-mark w-24 px-2 py-1.5 text-center text-lg font-bold disabled:opacity-50 disabled:cursor-not-allowed"
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
        <div class="fixed bottom-0 left-0 right-0 lg:left-64 bg-white border-t border-gray-200 p-3 z-30">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
                <p class="text-xs text-gray-400 hidden md:block">
                    <svg class="w-4 h-4 inline mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pastikan semua markah telah dimasukkan sebelum tekan Simpan.
                </p>
                <div class="flex items-center gap-2 ml-auto">
                    <button type="submit"
                            class="ek-btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Markah
                    </button>
                    <a href="{{ route('exams.results.show', request()->query()) }}"
                       class="ek-btn-secondary">
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
            el.classList.add('bg-blue-50');
            setTimeout(function() { el.classList.remove('bg-blue-50'); }, 2000);
        }
    }
});
</script>
@endsection
