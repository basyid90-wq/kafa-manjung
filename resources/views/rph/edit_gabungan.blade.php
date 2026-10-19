@extends('layout-fb.layout')

@php
$KEMAHIRAN = [
    'menulis'                 => 'Menulis',
    'membaca'                 => 'Membaca',
    'menyanyi'                => 'Menyanyi',
    'melukis'                 => 'Melukis',
    'melabel'                 => 'Melabel',
    'memilih_mengkategorikan' => 'Memilih/Mengkategorikan',
    'mengira_membilang'       => 'Mengira/Membilang',
    'luar_bilik_darjah'       => 'Luar Bilik Darjah',
    'simulasi'                => 'Simulasi',
    'memupuk_menanamkan'      => 'Memupuk/Menanamkan',
    'menghafaz'               => 'Menghafaz',
];
$STRATEGI = [
    'berpusatkan_guru'  => 'Berpusatkan Guru',
    'berpusatkan_murid' => 'Berpusatkan Murid',
    'luar_bilik_darjah' => 'Luar Bilik Darjah',
    'talqi_musyafahah'  => 'Talqi Musyafahah',
];
$FIELD_ROWS = [
    ['key' => 'tajuk_by_year',          'jawi' => 'تاجوق',        'rumi' => 'Tajuk'],
    ['key' => 'isi_pelajaran_by_year',  'jawi' => 'ايسي ڤلاجرن', 'rumi' => 'Isi Pelajaran'],
    ['key' => 'objective_by_year',      'jawi' => 'اوبجيكتيف',    'rumi' => 'Objektif Pelajaran'],
    ['key' => 'aktiviti_by_year',       'jawi' => 'اكتيۏيتي',     'rumi' => 'Aktiviti'],
];
$years = $rph->combined_years ?? [];
sort($years);
$periods = $rph->periods->keyBy('period_no');
@endphp

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Sunting RPH Kelas Cantum</h1>
        <a href="{{ route('rph.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="flex items-start gap-3 p-4 mb-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-sm text-red-800">
        {{ session('error') }}
    </div>
    @endif

    <style>
        @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
        .jawi-label { font-family: 'Lateef', serif; font-size: 1.1em; direction: rtl; text-align: right; display: block; margin-bottom: 4px; }
        .jawi-input { font-family: 'Lateef', serif !important; font-size: 1.2em !important; direction: rtl !important; text-align: right !important; line-height: 1.8 !important; }
        .rph-rumi-box { background: #f8f9fa; border: 1px dashed #ccc; margin-bottom: 4px; font-size: 0.85em; }
    </style>

    {{-- Kelas Cantum info --}}
    <div class="flex items-center gap-3 p-3 mb-5 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-800">
        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <div>
            <strong>Kelas Cantum:</strong> {{ $rph->getCombinedYearsLabel() }}
            &nbsp;|&nbsp;
            <strong>Status:</strong>
            @php
                $sColor = match($rph->status) {
                    'pending' => 'yellow', 'approved' => 'green', 'rejected' => 'red', default => 'gray'
                };
                $sLabel = match($rph->status) {
                    'pending' => 'Menunggu Semakan', 'approved' => 'Diluluskan', 'rejected' => 'Ditolak', 'revision_needed' => 'Perlu Pembaikan', default => ucfirst($rph->status)
                };
            @endphp
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $sColor }}-100 text-{{ $sColor }}-700">{{ $sLabel }}</span>
        </div>
    </div>

    <form action="{{ route('rph.update', $rph) }}" method="POST" id="form-edit-gabungan">
        @csrf @method('PUT')
        <input type="hidden" name="class_type" value="gabungan">
        @foreach($years as $y)
        <input type="hidden" name="combined_years[]" value="{{ $y }}">
        @endforeach

        {{-- Maklumat Asas --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">Maklumat Asas</div>
        <div class="ek-card mb-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <label class="ek-label">Tarikh <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ $rph->date }}" required
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" required
                            class="ek-input">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'] as $d)
                        <option value="{{ $d }}" @selected($rph->hari === $d)>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="ek-label">Minggu <span class="text-red-500">*</span></label>
                    <input name="week" type="number" min="1" max="52" value="{{ $rph->week }}" required
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Kelas (rekod)</label>
                    <select name="kafa_class_id"
                            class="ek-input">
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}" @selected($rph->kafa_class_id == $c->id)>{{ $c->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- 3 Sesi --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">Sesi Pengajaran</div>

        @for($s = 1; $s <= 3; $s++)
        @php $period = $periods->get($s); @endphp
        <div class="ek-table-wrap mb-4">
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2">SESI {{ $s }}</div>
            <div class="p-4">

                {{-- Mata Pelajaran + Masa --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="jawi-label text-gray-600">مات ڤلاجرن</label>
                        <span class="text-xs text-gray-500 block mb-1">Mata Pelajaran <span class="text-red-500">*</span></span>
                        <input type="text" id="s{{ $s }}_mp_rumi"
                               class="rph-rumi-box w-full px-2 py-1 text-xs border border-dashed border-gray-300 rounded bg-gray-50 mb-1"
                               placeholder="Taip Rumi...">
                        <div class="text-center mb-1">
                            <button type="button" onclick="tukarKeJawi('s{{ $s }}_mp_rumi','s{{ $s }}_mp_jawi')"
                                    class="text-xs px-2 py-0.5 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded border border-amber-300">↓ Jawi</button>
                        </div>
                        <input type="text" id="s{{ $s }}_mp_jawi"
                               name="periods[{{ $s }}][mata_pelajaran_jawi]"
                               class="jawi-input w-full px-2 py-1 border border-gray-300 rounded bg-white"
                               dir="rtl" required
                               value="{{ $period?->mata_pelajaran_jawi ?? '' }}">
                    </div>
                    <div>
                        <label class="ek-label">Masa <span class="text-red-500">*</span></label>
                        <input type="text" name="periods[{{ $s }}][masa]" required
                               value="{{ $period?->masa ?? '' }}" placeholder="8:00 - 9:00 PG"
                               class="ek-input">
                    </div>
                </div>

                {{-- Per-year table --}}
                <div class="overflow-x-auto mb-4">
                    <table class="ek-table border border-gray-200 rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold bg-gray-100 text-gray-600 w-24">Perkara</th>
                                @foreach($years as $y)
                                <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 bg-blue-50">TAHUN {{ $y }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($FIELD_ROWS as $f)
                            <tr>
                                <td class="px-3 py-2 align-top bg-gray-50 text-xs">
                                    <div class="jawi-label text-blue-600">{{ $f['jawi'] }}</div>
                                    <span class="text-gray-500">{{ $f['rumi'] }}</span>
                                </td>
                                @foreach($years as $y)
                                @php $val = $period ? ($period->{$f['key']}[$y] ?? '') : ''; @endphp
                                <td class="px-2 py-2 align-top">
                                    <textarea id="s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_rumi"
                                              class="rph-rumi-box w-full px-2 py-1 text-xs border border-dashed border-gray-300 rounded bg-gray-50 mb-1"
                                              rows="2" placeholder="Taip Rumi..."></textarea>
                                    <div class="text-center mb-1">
                                        <button type="button"
                                                onclick="tukarKeJawi('s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_rumi','s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_jawi')"
                                                class="text-xs px-2 py-0.5 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded border border-amber-300">↓ Jawi</button>
                                    </div>
                                    <textarea id="s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_jawi"
                                              name="periods[{{ $s }}][{{ $f['key'] }}][{{ $y }}]"
                                              class="jawi-input w-full px-2 py-1 border border-gray-300 rounded bg-white"
                                              rows="3" dir="rtl" required>{{ $val }}</textarea>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Kemahiran --}}
                <div class="p-3 bg-gray-50 rounded-lg mb-3">
                    <p class="text-xs font-semibold text-gray-700 mb-2">
                        <span class="jawi-label inline" style="font-size:1em;">كماهيرن</span> Kemahiran:
                    </p>
                    <div>
                        @foreach($KEMAHIRAN as $val => $label)
                        <label class="inline-flex items-center gap-1 px-2.5 py-1 text-xs border border-indigo-200 bg-indigo-50 rounded-full cursor-pointer hover:bg-indigo-100 m-0.5">
                            <input type="checkbox" name="periods[{{ $s }}][kemahiran_selected][]" value="{{ $val }}"
                                   @checked($period && in_array($val, $period->kemahiran_selected ?? []))>
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Strategi PdP --}}
                <div class="p-3 bg-gray-50 rounded-lg mb-3">
                    <p class="text-xs font-semibold text-gray-700 mb-2">
                        <span class="jawi-label inline" style="font-size:1em;">ستراتڬي ڤدڤ</span> Strategi PdP:
                    </p>
                    <div>
                        @foreach($STRATEGI as $val => $label)
                        <label class="inline-flex items-center gap-1 px-2.5 py-1 text-xs border border-indigo-200 bg-indigo-50 rounded-full cursor-pointer hover:bg-indigo-100 m-0.5">
                            <input type="checkbox" name="periods[{{ $s }}][strategi_pdc][]" value="{{ $val }}"
                                   @checked($period && in_array($val, $period->strategi_pdc ?? []))>
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Impak Pembelajaran --}}
                <div class="p-3 border border-gray-200 rounded-lg">
                    <p class="text-xs font-semibold text-gray-700 mb-2">
                        <span class="jawi-label inline" style="font-size:1em;">ايمڤك ڤمبلاجرن</span> Impak Pembelajaran:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label class="text-xs font-medium text-gray-600">Murid berjaya (____/____):</label>
                            <input type="text" name="periods[{{ $s }}][impak][berjaya]"
                                   value="{{ $period?->impak['berjaya'] ?? '' }}" placeholder="cth: 20/25"
                                   class="w-full px-2 py-1 text-xs border border-gray-300 rounded bg-white mt-1">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600">Murid belum berjaya (____/____):</label>
                            <input type="text" name="periods[{{ $s }}][impak][belum]"
                                   value="{{ $period?->impak['belum'] ?? '' }}" placeholder="cth: 5/25"
                                   class="w-full px-2 py-1 text-xs border border-gray-300 rounded bg-white mt-1">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600">Aktiviti P&amp;P ditangguhkan kerana:</label>
                            <input type="text" name="periods[{{ $s }}][impak][sebab_ditangguh]"
                                   value="{{ $period?->impak['sebab_ditangguh'] ?? '' }}" placeholder="(kosong jika tidak ditangguh)"
                                   class="w-full px-2 py-1 text-xs border border-gray-300 rounded bg-white mt-1">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600">Aktiviti P&amp;P diteruskan pada:</label>
                            <input type="text" name="periods[{{ $s }}][impak][tarikh_teruskan]"
                                   value="{{ $period?->impak['tarikh_teruskan'] ?? '' }}" placeholder="(kosong jika tidak ditangguh)"
                                   class="w-full px-2 py-1 text-xs border border-gray-300 rounded bg-white mt-1">
                        </div>
                    </div>
                </div>

            </div>{{-- p-4 --}}
        </div>{{-- card --}}
        @endfor

        <div class="flex justify-between items-center mt-5">
            <a href="{{ route('rph.index') }}"
               class="ek-btn-secondary">
                Batal
            </a>
            <button type="submit"
                    class="ek-btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Kemaskini RPH Cantum
            </button>
        </div>
    </form>
</div>

<x-jawi-keyboard />
<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
@endsection
