@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Kemasukan Markah Peperiksaan</h1>
            <p class="ek-page-sub mt-1">Pilih peperiksaan, kelas dan mata pelajaran untuk kemaskini markah</p>
        </div>
        <a href="{{ route('exams.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Urus Peperiksaan
        </a>
    </div>

    {{-- ── Missing Slots Warning ── --}}
    @if(!empty($missingSlots))
    <div class="flex items-start gap-3 p-4 mb-5 bg-red-50 border border-red-200 rounded-xl">
        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-red-800">
                Amaran: {{ count($missingSlots) }} subjek KAFA tiada rekod dalam sistem!
            </p>
            <p class="text-xs text-red-600 mt-1 mb-2">
                Slot berikut belum ada subjek dengan <code class="bg-red-100 px-1 rounded">form_slot</code> ditetapkan — markah untuk slot ini <strong>tidak akan muncul</strong> dalam Rekod Pencapaian Murid:
            </p>
            <div class="flex flex-wrap gap-1">
                @foreach($missingSlots as $slot)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">{{ $slot }}</span>
                @endforeach
            </div>
            <p class="text-xs text-red-500 mt-2">
                Sila tetapkan <strong>Form Slot</strong> yang betul pada setiap subjek dalam Pengurusan Subjek.
            </p>
        </div>
    </div>
    @endif

    {{-- ── Form ── --}}
    <div class="ek-card">
        <form action="{{ route('exams.results.show') }}" method="GET" class="space-y-5">

            <div>
                <label class="ek-label">
                    Pilih Peperiksaan <span class="text-red-500">*</span>
                </label>
                <select name="exam_id" required
                        class="ek-input">
                    <option value="">— Pilih Peperiksaan —</option>
                    @foreach($exams as $exam)
                    <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->year }}) — {{ ucfirst(str_replace('_', ' ', $exam->term)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="ek-label">
                        Pilih Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="kafa_class_id" required
                            class="ek-input">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="ek-label">
                        Pilih Mata Pelajaran <span class="text-red-500">*</span>
                        <span class="text-xs font-normal text-gray-500 ml-1">(🔗 = tersambung ke Rekod Pencapaian)</span>
                    </label>
                    <select name="subject_id" required
                            class="ek-input">
                        <option value="">— Pilih Mata Pelajaran —</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->slot_linked ? '🔗' : ($subject->has_slot ? '⚠️' : '❌') }}
                            {{ $subject->name }}{{ $subject->form_slot ? ' ['.$subject->form_slot.']' : ' [tiada slot]' }}
                        </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1.5">
                        🔗 Tersambung &nbsp;|&nbsp; ⚠️ Ada slot tapi tidak dikenali &nbsp;|&nbsp; ❌ Tiada form_slot
                    </p>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="ek-btn-primary">
                    Teruskan
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
