@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Cipta Rekod Pengajaran Harian (RPH)</h1>
        </div>
        <a href="{{ route('rph.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Tab Switcher --}}
    <div class="flex gap-1 mb-5 bg-gray-100 dark:bg-gray-800 rounded-xl p-1">
        <span class="flex-1 px-4 py-2 text-xs font-medium text-center bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm rounded-lg cursor-default">
            Kelas Biasa
        </span>
        <a href="{{ route('rph.create_gabungan') }}"
           class="flex-1 px-4 py-2 text-xs font-medium text-center text-gray-500 dark:text-gray-400 hover:text-gray-700 rounded-lg transition-colors">
            Kelas Cantum
        </a>
    </div>

    <style>
        @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
        .jawi-input { font-family: 'Lateef', 'Scheherazade New', serif !important; font-size: 1.25em !important; direction: rtl !important; text-align: right !important; line-height: 1.8 !important; }
        .jawi-label { font-family: 'Lateef', serif; font-size: 1.1em; direction: rtl; text-align: right; display: block; margin-bottom: 4px; }
        .rph-period-panel { display: none; }
        .rph-period-panel.active { display: block; }
    </style>

    <form action="{{ route('rph.store') }}" method="POST">
        @csrf

        {{-- A. Maklumat Am --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">A. Maklumat Am</div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarikh <span class="text-red-500">*</span></label>
                    <input id="rph-date" name="date" type="date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" id="rph-hari" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'] as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Minggu <span class="text-red-500">*</span></label>
                    <input name="week" type="number" min="1" max="52" required placeholder="1–52"
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
                    <a href="{{ route('time_slots.index') }}" class="font-semibold text-yellow-900 dark:text-yellow-200 underline">Klik di sini untuk tetapkan Waktu Mengajar</a> sebelum mengisi RPH.
                @endif
            </div>
        </div>
        @endif

        {{-- Period tabs --}}
        <div class="flex gap-2 mb-4 flex-wrap">
            <button type="button" class="rph-tab-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border-2 border-blue-600 bg-blue-600 text-white transition-colors" data-tab="p1">
                Waktu 1 <span class="px-1.5 py-0.5 text-xs rounded-full bg-red-500 text-white">Wajib</span>
            </button>
            <button type="button" class="rph-tab-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 transition-colors" data-tab="p2">
                Waktu 2 <span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-400 text-white">Pilihan</span>
            </button>
            <button type="button" class="rph-tab-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 transition-colors" data-tab="p3">
                Waktu 3 <span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-400 text-white">Pilihan</span>
            </button>
        </div>

        @foreach([1, 2, 3] as $no)
        <div id="p{{ $no }}" class="rph-period-panel {{ $no == 1 ? 'active' : '' }} bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas @if($no == 1)<span class="text-red-500">*</span>@endif</label>
                    <select name="periods[{{ $no }}][kafa_class_id]"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 {{ $no == 1 ? 'required-p1' : '' }}">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Masa</label>
                    @if($timeSlots->isNotEmpty())
                    <select name="periods[{{ $no }}][masa]" id="masa_p{{ $no }}" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 rph-masa-select">
                        <option value="">-- Pilih Masa --</option>
                        @foreach($timeSlots as $slot)
                        @php $slotVal = substr($slot->start_time, 0, 5) . ' – ' . substr($slot->end_time, 0, 5); @endphp
                        <option value="{{ $slotVal }}" data-slot-id="{{ $slot->id }}">
                            {{ $slot->name ? $slot->name . ' (' . $slotVal . ')' : $slotVal }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <input name="periods[{{ $no }}][masa]" type="text" placeholder="cth: 8:00 – 9:00 pagi" dir="ltr"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @endif
                </div>

                @include('rph._field_pair', [
                    'flabel'    => 'مات ڤلاجرن',
                    'rumiId'    => "p{$no}_mata_rumi",
                    'jawiId'    => "p{$no}_mata_jawi",
                    'jawiName'  => "periods[{$no}][mata_pelajaran_jawi]",
                    'jawiValue' => old("periods.{$no}.mata_pelajaran_jawi"),
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
                    'jawiValue' => old("periods.{$no}.{$fname}"),
                    'required'  => $frequired && $no == 1,
                ])
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex justify-between items-center mt-5">
            <a href="{{ route('rph.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Hantar RPH
            </button>
        </div>
    </form>
</div>

<x-jawi-keyboard />

<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
<script>
    // Tab switching
    document.querySelectorAll('.rph-tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.rph-tab-btn').forEach(b => {
                b.classList.remove('border-blue-600', 'bg-blue-600', 'text-white');
                b.classList.add('border-gray-200', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-400');
            });
            document.querySelectorAll('.rph-period-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('border-blue-600', 'bg-blue-600', 'text-white');
            this.classList.remove('border-gray-200', 'bg-white', 'text-gray-600');
            document.getElementById(this.dataset.tab).classList.add('active');
        });
    });

    // Auto-set hari from date
    document.getElementById('rph-date').addEventListener('change', function() {
        const days = ['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'];
        const d = new Date(this.value);
        const dayName = days[d.getDay()];
        const sel = document.getElementById('rph-hari');
        for (let i = 0; i < sel.options.length; i++) {
            if (sel.options[i].value === dayName) { sel.selectedIndex = i; break; }
        }
    });
    document.getElementById('rph-date').dispatchEvent(new Event('change'));

    // Prevent duplicate masa selection
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
