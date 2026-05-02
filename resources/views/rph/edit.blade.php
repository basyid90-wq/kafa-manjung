@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Kemas Kini RPH</h1>
        <a href="{{ route('rph.show', $rph) }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if($rph->review_comment)
    <div class="flex items-start gap-3 p-4 mb-5 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-r-xl text-sm text-yellow-800 dark:text-yellow-300">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <div>
            <strong>Ulasan Semakan:</strong>
            <p class="mt-1 mb-0">{{ $rph->review_comment }}</p>
        </div>
    </div>
    @endif

    <style>
        @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
        .jawi-input { font-family: 'Lateef', 'Scheherazade New', serif !important; font-size: 1.25em !important; direction: rtl !important; text-align: right !important; line-height: 1.8 !important; }
        .jawi-label { font-family: 'Lateef', serif; font-size: 1.1em; direction: rtl; text-align: right; display: block; margin-bottom: 4px; }
        .rph-period-panel { display: none; }
        .rph-period-panel.active { display: block; }
    </style>

    <form action="{{ route('rph.update', $rph) }}" method="POST">
        @csrf @method('PUT')

        {{-- A. Maklumat Am --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">A. Maklumat Am</div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarikh <span class="text-red-500">*</span></label>
                    <input id="rph-date" name="date" type="date" value="{{ $rph->date }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" id="rph-hari" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'] as $d)
                        <option value="{{ $d }}" {{ $rph->hari == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Minggu <span class="text-red-500">*</span></label>
                    <input name="week" type="number" min="1" max="52" value="{{ $rph->week }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        {{-- B. Waktu Pengajaran --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">B. Waktu Pengajaran</div>

        @if($timeSlots->isEmpty())
        <div class="flex items-start gap-3 p-4 mb-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-r-xl text-sm text-yellow-800 dark:text-yellow-300">
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong>Waktu Mengajar Belum Ditetapkan.</strong><br>
                @if(auth()->user()->hasRole('Guru KAFA'))
                    Sila minta Guru Besar anda menetapkan Waktu Mengajar sekolah terlebih dahulu.
                @else
                    <a href="{{ route('time_slots.index') }}" class="font-semibold underline">Klik di sini untuk tetapkan Waktu Mengajar</a>
                @endif
            </div>
        </div>
        @endif

        <div class="flex gap-2 mb-4 flex-wrap">
            @foreach([1,2,3] as $no)
            <button type="button" class="rph-tab-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border-2 transition-colors
                {{ $no == 1 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}" data-tab="p{{ $no }}">
                Waktu {{ $no }}
                @if($no == 1)<span class="px-1.5 py-0.5 text-xs rounded-full bg-red-500 text-white">Wajib</span>
                @else<span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-400 text-white">Pilihan</span>@endif
            </button>
            @endforeach
        </div>

        @foreach([1, 2, 3] as $no)
        @php $period = $rph->periods->firstWhere('period_no', $no); @endphp
        <div id="p{{ $no }}" class="rph-period-panel {{ $no == 1 ? 'active' : '' }} bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas @if($no == 1)<span class="text-red-500">*</span>@endif</label>
                    <select name="periods[{{ $no }}][kafa_class_id]"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ ($period?->kafa_class_id == $c->id) ? 'selected' : '' }}>{{ $c->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Masa</label>
                    @if($timeSlots->isNotEmpty())
                    <select name="periods[{{ $no }}][masa]" id="masa_p{{ $no }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 rph-masa-select">
                        <option value="">-- Pilih Masa --</option>
                        @foreach($timeSlots as $slot)
                        @php $slotVal = substr($slot->start_time, 0, 5) . ' – ' . substr($slot->end_time, 0, 5); @endphp
                        <option value="{{ $slotVal }}" data-slot-id="{{ $slot->id }}" {{ ($period?->masa === $slotVal) ? 'selected' : '' }}>
                            {{ $slot->name ? $slot->name . ' (' . $slotVal . ')' : $slotVal }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <input name="periods[{{ $no }}][masa]" type="text" value="{{ $period?->masa }}" placeholder="cth: 8:00 – 9:00 pagi"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @endif
                </div>

                @include('rph._field_pair', [
                    'flabel'    => 'مات ڤلاجرن',
                    'rumiId'    => "p{$no}_mata_rumi",
                    'jawiId'    => "p{$no}_mata_jawi",
                    'jawiName'  => "periods[{$no}][mata_pelajaran_jawi]",
                    'jawiValue' => $period?->mata_pelajaran_jawi,
                    'jawiRows'  => 2,
                ])

                @php
                    $fields = [
                        ['topic_jawi',         'تاجوق ڤلاجرن',      'topic',     true],
                        ['kemahiran_jawi',     'كماهيرن',            'kemahiran', true],
                        ['isi_pelajaran_jawi', 'ايسي ڤلاجرن',        'isi',       true],
                        ['objective_jawi',     'اوبجيكتيف ڤمبلاجرن', 'objektif',  true],
                        ['aktiviti_jawi',      'اكتيۏيتي ڤ&ڤ',       'aktiviti',  true],
                        ['reflection_jawi',    'ايمڤک ڤمبلاجرن',     'refleksi',  false],
                    ];
                @endphp

                @foreach($fields as [$fname, $flabel, $fid, $frequired])
                @include('rph._field_pair', [
                    'flabel'    => $flabel . ($frequired && $no == 1 ? ' <span class="text-red-500">*</span>' : ''),
                    'rumiId'    => "p{$no}_{$fid}_rumi",
                    'jawiId'    => "p{$no}_{$fid}_jawi",
                    'jawiName'  => "periods[{$no}][{$fname}]",
                    'jawiValue' => $period?->{$fname},
                    'required'  => $frequired && $no == 1,
                ])
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex justify-between mt-5">
            <a href="{{ route('rph.show', $rph) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Hantar Semula
            </button>
        </div>
    </form>
</div>

<x-jawi-keyboard />
<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
<script>
    document.querySelectorAll('.rph-tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.rph-tab-btn').forEach(b => {
                b.classList.remove('border-blue-600','bg-blue-600','text-white');
                b.classList.add('border-gray-200','bg-white','text-gray-600');
            });
            document.querySelectorAll('.rph-period-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('border-blue-600','bg-blue-600','text-white');
            this.classList.remove('border-gray-200','bg-white','text-gray-600');
            document.getElementById(this.dataset.tab).classList.add('active');
        });
    });

    function syncMasaDropdowns() {
        var selects = Array.from(document.querySelectorAll('.rph-masa-select'));
        if (!selects.length) return;
        function refresh() {
            selects.forEach(function(sel) {
                var usedByOthers = selects.filter(s => s !== sel).map(s => s.value).filter(v => v !== '');
                Array.from(sel.options).forEach(opt => {
                    if (!opt.value) return;
                    opt.disabled = usedByOthers.indexOf(opt.value) !== -1;
                });
            });
        }
        selects.forEach(sel => sel.addEventListener('change', refresh));
        refresh();
    }
    document.addEventListener('DOMContentLoaded', syncMasaDropdowns);
</script>
@endsection
