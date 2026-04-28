@extends('layout.layout')

@php $bodyClass = ''; $footer = 'true'; @endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Cipta Rekod Pengajaran Harian (RPH)</h4>
                        </div>

                        {{-- Tab Switcher: Kelas Biasa vs Gabungan --}}
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="return false;">
                                    <i class="feather-book"></i> Kelas Biasa
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rph.create_gabungan') }}">
                                    <i class="feather-users"></i> Kelas Gabungan
                                </a>
                            </li>
                        </ul>

                        <form action="{{ route('rph.store') }}" method="POST">
                            @csrf

                            {{-- ── A. Maklumat Am ── --}}
                            <div class="rph-section-header mb--20">A. Maklumat Am</div>
                            <div class="row g-3 mb--20">
                                <div class="col-md-3 col-6">
                                    <div class="rbt-form-group">
                                        <label>Tarikh <span class="text-danger">*</span></label>
                                        <input id="rph-date" name="date" type="date" class="form-control" required value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="rbt-form-group">
                                        <label>Hari <span class="text-danger">*</span></label>
                                        <select name="hari" id="rph-hari" class="rbt-big-select" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach(['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'] as $d)
                                            <option value="{{ $d }}">{{ $d }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-4">
                                    <div class="rbt-form-group">
                                        <label>Minggu <span class="text-danger">*</span></label>
                                        <input name="week" type="number" class="form-control" min="1" max="52" required placeholder="1–52">
                                    </div>
                                </div>
                            </div>

                            {{-- ── B. Waktu Pengajaran (3 tabs) ── --}}
                            <div class="rph-section-header mb--15">B. Waktu Pengajaran</div>

                            {{-- Notis: Slot Masa belum ditetapkan --}}
                            @if($timeSlots->isEmpty())
                            <div class="d-flex align-items-start gap-2 mb--20 p-3"
                                 style="border-left:4px solid #f9a825; background:#fff8e1; border-radius:8px;">
                                <i class="feather-alert-circle mt-1" style="color:#f9a825; flex-shrink:0;"></i>
                                <div style="font-size:0.9em;">
                                    <strong>Waktu Mengajar Belum Ditetapkan.</strong><br>
                                    @if(auth()->user()->hasRole('Guru KAFA'))
                                        Sila minta Guru Besar anda menetapkan Waktu Mengajar sekolah terlebih dahulu.
                                    @else
                                        <a href="{{ route('time_slots.index') }}" style="color:#e65100; font-weight:600;">Klik di sini untuk tetapkan Waktu Mengajar</a> sebelum mengisi RPH.
                                    @endif
                                </div>
                            </div>
                            @endif

                            {{-- Tab buttons --}}
                            <div class="rph-period-tabs mb--20">
                                <button type="button" class="rph-period-tab active" data-tab="p1">
                                    Waktu 1 <span class="badge-required">Wajib</span>
                                </button>
                                <button type="button" class="rph-period-tab" data-tab="p2">
                                    Waktu 2 <span class="badge-optional">Pilihan</span>
                                </button>
                                <button type="button" class="rph-period-tab" data-tab="p3">
                                    Waktu 3 <span class="badge-optional">Pilihan</span>
                                </button>
                            </div>

                            @foreach([1, 2, 3] as $no)
                            <div id="p{{ $no }}" class="rph-period-panel {{ $no > 1 ? 'd-none' : '' }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="rbt-form-group">
                                            <label>Kelas @if($no == 1)<span class="text-danger">*</span>@endif</label>
                                            <select name="periods[{{ $no }}][kafa_class_id]"
                                                    class="rbt-big-select {{ $no == 1 ? 'required-p1' : '' }}">
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach($classes as $c)
                                                <option value="{{ $c->id }}">{{ $c->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rbt-form-group">
                                            <label>Masa</label>
                                            @if($timeSlots->isNotEmpty())
                                            <select name="periods[{{ $no }}][masa]"
                                                    id="masa_p{{ $no }}"
                                                    class="rbt-big-select rph-masa-select">
                                                <option value="">-- Pilih Masa --</option>
                                                @foreach($timeSlots as $slot)
                                                @php $slotVal = substr($slot->start_time, 0, 5) . ' – ' . substr($slot->end_time, 0, 5); @endphp
                                                <option value="{{ $slotVal }}" data-slot-id="{{ $slot->id }}">
                                                    {{ $slot->name ? $slot->name . ' (' . $slotVal . ')' : $slotVal }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @else
                                            <input name="periods[{{ $no }}][masa]" type="text" class="form-control"
                                                   placeholder="cth: 8:00 – 9:00 pagi" dir="ltr">
                                            @endif
                                        </div>
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
                                        'flabel'    => $flabel . ($frequired && $no == 1 ? ' <span class="text-danger">*</span>' : ''),
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

                            {{-- Butang --}}
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap--10 mt--30">
                                <a class="rbt-btn btn-border" href="{{ route('rph.index') }}">Batal</a>
                                <button class="rbt-btn btn-gradient" type="submit">
                                    <i class="feather-send"></i> Hantar RPH
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @font-face {
        font-family: 'Lateef';
        src: url('/fonts/Lateef-Regular.ttf') format('truetype');
    }
    .rph-section-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9em;
    }
    .rph-period-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .rph-period-tab {
        padding: 8px 20px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        background: #f8f9fa;
        cursor: pointer;
        font-size: 0.9em;
        font-weight: 600;
        color: #555;
        transition: all 0.2s;
    }
    .rph-period-tab.active {
        border-color: var(--color-primary);
        background: var(--color-primary);
        color: white;
    }
    .badge-required {
        background: #dc3545;
        color: white;
        font-size: 0.65em;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 4px;
        vertical-align: middle;
    }
    .badge-optional {
        background: #6c757d;
        color: white;
        font-size: 0.65em;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 4px;
        vertical-align: middle;
    }
    .jawi-input {
        font-family: 'Lateef', 'Scheherazade New', serif !important;
        font-size: 1.25em !important;
        direction: rtl !important;
        text-align: right !important;
        line-height: 1.8 !important;
    }
    .jawi-label {
        font-family: 'Lateef', serif;
        font-size: 1.1em;
        direction: rtl;
        text-align: right;
        display: block;
        margin-bottom: 6px;
    }
    .rph-period-panel {
        background: #fafbff;
        border: 1px solid #eef0f8;
        border-radius: 10px;
        padding: 20px;
    }
    .rph-rumi-box {
        font-size: 0.9em;
        background: #f8f9fa;
        color: #444;
        resize: vertical;
        margin-bottom: 0;
    }
    .rph-convert-bar {
        text-align: right;
        margin: 4px 0;
    }
    .btn-tukar-jawi {
        background: transparent;
        border: 1px solid #6c63ff;
        color: #6c63ff;
        border-radius: 4px;
        padding: 2px 10px;
        font-size: 0.78em;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }
    .btn-tukar-jawi:hover {
        background: #6c63ff;
        color: white;
    }
</style>

<x-jawi-keyboard />

@push('scripts')
<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
<script>
    // Tab switching
    document.querySelectorAll('.rph-period-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.rph-period-tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.rph-period-panel').forEach(p => p.classList.add('d-none'));
            this.classList.add('active');
            document.getElementById(this.dataset.tab).classList.remove('d-none');
        });
    });

    // Auto-set hari from date
    document.getElementById('rph-date').addEventListener('change', function() {
        const days = ['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'];
        const d = new Date(this.value);
        const dayName = days[d.getDay()];
        const sel = document.getElementById('rph-hari');
        for (let i = 0; i < sel.options.length; i++) {
            if (sel.options[i].value === dayName) {
                sel.selectedIndex = i;
                if (typeof $ !== 'undefined' && $(sel).selectpicker) $(sel).selectpicker('refresh');
                break;
            }
        }
    });

    // Trigger to pre-set today's hari
    document.getElementById('rph-date').dispatchEvent(new Event('change'));

    // Halang pilihan Masa yang sama pada dua waktu berbeza
    function syncMasaDropdowns() {
        var selects = Array.from(document.querySelectorAll('.rph-masa-select'));
        if (!selects.length) return;

        function refresh() {
            selects.forEach(function(sel) {
                var usedByOthers = selects
                    .filter(function(s) { return s !== sel; })
                    .map(function(s) { return s.value; })
                    .filter(function(v) { return v !== ''; });

                Array.from(sel.options).forEach(function(opt) {
                    if (!opt.value) return;
                    opt.disabled = usedByOthers.indexOf(opt.value) !== -1;
                });

                if (typeof $ !== 'undefined' && $(sel).selectpicker) {
                    $(sel).selectpicker('refresh');
                }
            });
        }

        selects.forEach(function(sel) {
            sel.addEventListener('change', refresh);
        });
        refresh();
    }
    document.addEventListener('DOMContentLoaded', syncMasaDropdowns);
</script>
@endpush
@endsection
