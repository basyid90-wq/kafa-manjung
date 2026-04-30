@extends('layout.layout')

@php
$bodyClass = ''; $footer = 'true';
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
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Sunting RPH Kelas Cantum</h4>
                            <a href="{{ route('rph.index') }}" class="rbt-btn btn-sm btn-border">
                                <i class="feather-arrow-left"></i> Kembali
                            </a>
                        </div>

                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('rph.update', $rph) }}" method="POST" id="form-edit-gabungan">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="class_type" value="gabungan">

                            {{-- Combined years hidden --}}
                            @foreach($years as $y)
                            <input type="hidden" name="combined_years[]" value="{{ $y }}">
                            @endforeach

                            {{-- Tahun info --}}
                            <div class="alert alert-info mb--20">
                                <i class="feather-users"></i>
                                <strong>Kelas Cantum:</strong> {{ $rph->getCombinedYearsLabel() }}
                                &nbsp;|&nbsp;
                                <strong>Status semasa:</strong>
                                <span class="badge bg-{{ $rph->status === 'pending' ? 'warning' : ($rph->status === 'rejected' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($rph->status) }}
                                </span>
                            </div>

                            {{-- Maklumat Asas --}}
                            <div class="rph-section-header mb--15">Maklumat Asas</div>
                            <div class="row g-3 mb--20">
                                <div class="col-md-3">
                                    <div class="rbt-form-group">
                                        <label>Tarikh <span class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control" required value="{{ $rph->date }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rbt-form-group">
                                        <label>Hari <span class="text-danger">*</span></label>
                                        <select name="hari" class="rbt-big-select" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach(['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'] as $d)
                                            <option value="{{ $d }}" @selected($rph->hari === $d)>{{ $d }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="rbt-form-group">
                                        <label>Minggu <span class="text-danger">*</span></label>
                                        <input name="week" type="number" class="form-control" min="1" max="52"
                                               required value="{{ $rph->week }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="rbt-form-group">
                                        <label>Kelas (rekod)</label>
                                        <select name="kafa_class_id" class="rbt-big-select">
                                            @foreach($classes as $c)
                                            <option value="{{ $c->id }}" @selected($rph->kafa_class_id == $c->id)>
                                                {{ $c->display_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- 3 Sesi --}}
                            <div class="rph-section-header mb--15">Sesi Pengajaran</div>

                            @for($s = 1; $s <= 3; $s++)
                            @php $period = $periods->get($s); @endphp
                            <div class="year-card">
                                <div class="year-card-header"><i class="feather-clock"></i> SESI {{ $s }}</div>
                                <div class="year-card-body">

                                    {{-- Mata Pelajaran + Masa --}}
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="jawi-label">مات ڤلاجرن</label>
                                            <small class="text-muted d-block mb-1">Mata Pelajaran <span class="text-danger">*</span></small>
                                            <input type="text" id="s{{ $s }}_mp_rumi" class="form-control rph-rumi-box"
                                                   placeholder="Taip Rumi...">
                                            <div class="rph-convert-bar">
                                                <button type="button" class="btn-tukar-jawi"
                                                        onclick="tukarKeJawi('s{{ $s }}_mp_rumi','s{{ $s }}_mp_jawi')">↓ Jawi</button>
                                            </div>
                                            <input type="text" id="s{{ $s }}_mp_jawi"
                                                   name="periods[{{ $s }}][mata_pelajaran_jawi]"
                                                   class="form-control jawi-input" dir="rtl" required
                                                   value="{{ $period->mata_pelajaran_jawi ?? '' }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Masa <span class="text-danger">*</span></label>
                                            <input type="text" name="periods[{{ $s }}][masa]"
                                                   class="form-control" required
                                                   value="{{ $period->masa ?? '' }}"
                                                   placeholder="8:00 - 9:00 PG">
                                        </div>
                                    </div>

                                    {{-- Per-year table --}}
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered rph-cantum-table align-middle">
                                            <thead>
                                                <tr>
                                                    <th width="18%">Perkara</th>
                                                    @foreach($years as $y)
                                                    <th class="text-center">TAHUN {{ $y }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($FIELD_ROWS as $f)
                                                <tr>
                                                    <td class="label-col">
                                                        <div class="jawi-label">{{ $f['jawi'] }}</div>
                                                        <small class="text-muted">{{ $f['rumi'] }}</small>
                                                    </td>
                                                    @foreach($years as $y)
                                                    @php $val = $period ? ($period->{$f['key']}[$y] ?? '') : ''; @endphp
                                                    <td>
                                                        <textarea id="s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_rumi"
                                                                  class="form-control rph-rumi-box" rows="2"
                                                                  placeholder="Taip Rumi..."></textarea>
                                                        <div class="rph-convert-bar">
                                                            <button type="button" class="btn-tukar-jawi"
                                                                    onclick="tukarKeJawi('s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_rumi','s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_jawi')">↓ Jawi</button>
                                                        </div>
                                                        <textarea id="s{{ $s }}_y{{ $y }}_{{ $f['key'] }}_jawi"
                                                                  name="periods[{{ $s }}][{{ $f['key'] }}][{{ $y }}]"
                                                                  class="form-control jawi-input" rows="3"
                                                                  dir="rtl" required>{{ $val }}</textarea>
                                                    </td>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Kemahiran --}}
                                    <div class="mb-3 p-3 bg-light rounded">
                                        <label class="fw-bold mb-2 d-block">
                                            <span class="jawi-label" style="font-size:1em;">كماهيرن</span> Kemahiran:
                                        </label>
                                        <div>
                                            @foreach($KEMAHIRAN as $val => $label)
                                            <label class="kemahiran-badge">
                                                <input type="checkbox"
                                                       name="periods[{{ $s }}][kemahiran_selected][]"
                                                       value="{{ $val }}"
                                                       @checked($period && in_array($val, $period->kemahiran_selected ?? []))>
                                                {{ $label }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Strategi PdC --}}
                                    <div class="mb-3 p-3 bg-light rounded">
                                        <label class="fw-bold mb-2 d-block">
                                            <span class="jawi-label" style="font-size:1em;">ستراتڬي ڤدڤ</span> Strategi PdP:
                                        </label>
                                        <div>
                                            @foreach($STRATEGI as $val => $label)
                                            <label class="kemahiran-badge">
                                                <input type="checkbox"
                                                       name="periods[{{ $s }}][strategi_pdc][]"
                                                       value="{{ $val }}"
                                                       @checked($period && in_array($val, $period->strategi_pdc ?? []))>
                                                {{ $label }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Impak --}}
                                    <div class="p-3 border rounded">
                                        <label class="fw-bold mb-2 d-block">
                                            <span class="jawi-label" style="font-size:1em;">ايمڤك ڤمبلاجرن</span> Impak Pembelajaran:
                                        </label>
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <label class="small fw-semibold">Murid berjaya (____/____):</label>
                                                <input type="text" name="periods[{{ $s }}][impak][berjaya]"
                                                       class="form-control form-control-sm"
                                                       placeholder="cth: 20/25"
                                                       value="{{ $period->impak['berjaya'] ?? '' }}">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="small fw-semibold">Murid belum berjaya (____/____):</label>
                                                <input type="text" name="periods[{{ $s }}][impak][belum]"
                                                       class="form-control form-control-sm"
                                                       placeholder="cth: 5/25"
                                                       value="{{ $period->impak['belum'] ?? '' }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="small fw-semibold">Aktiviti P&amp;P ditangguhkan kerana:</label>
                                                <input type="text" name="periods[{{ $s }}][impak][sebab_ditangguh]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $period->impak['sebab_ditangguh'] ?? '' }}"
                                                       placeholder="(kosong jika tidak ditangguh)">
                                            </div>
                                            <div class="col-12">
                                                <label class="small fw-semibold">Aktiviti P&amp;P diteruskan pada:</label>
                                                <input type="text" name="periods[{{ $s }}][impak][tarikh_teruskan]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $period->impak['tarikh_teruskan'] ?? '' }}"
                                                       placeholder="(kosong jika tidak ditangguh)">
                                            </div>
                                        </div>
                                    </div>

                                </div>{{-- year-card-body --}}
                            </div>{{-- year-card --}}
                            @endfor

                            <div class="mt--30">
                                <button type="submit" class="rbt-btn btn-gradient">
                                    <i class="feather-save"></i> Kemaskini RPH Cantum
                                </button>
                                <a href="{{ route('rph.index') }}" class="rbt-btn btn-border">
                                    <i class="feather-x"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rph-section-header {
    font-size: 1.05rem; font-weight: 600; color: #2f57ef;
    border-bottom: 2px solid #2f57ef; padding-bottom: 6px; margin-bottom: 16px;
}
.year-card { border: 2px solid #e0e0e0; border-radius: 8px; margin-bottom: 24px; overflow: hidden; }
.year-card-header {
    background: linear-gradient(135deg, #2f57ef 0%, #1e3a8a 100%);
    color: white; padding: 12px 18px; font-weight: 600; font-size: 1rem;
}
.year-card-body { padding: 18px; background: #f9fafb; }
.jawi-label {
    font-family: 'Lateef', serif; font-size: 1.1em;
    direction: rtl; text-align: right; display: block; margin-bottom: 4px;
}
.jawi-input {
    font-family: 'Lateef', serif !important; font-size: 1.2em !important;
    direction: rtl !important; text-align: right !important; line-height: 1.8 !important;
}
.rph-rumi-box { background: #f8f9fa; border: 1px dashed #ccc; margin-bottom: 4px; font-size: 0.85em; }
.rph-convert-bar { text-align: center; margin: 3px 0 6px; }
.btn-tukar-jawi {
    background: transparent; border: 1px solid #6c63ff; color: #6c63ff;
    border-radius: 4px; padding: 2px 10px; font-size: 0.75em; cursor: pointer;
}
.btn-tukar-jawi:hover { background: #6c63ff; color: white; }
.rph-cantum-table th { background: #e8eaf6; font-size: 0.85rem; }
.rph-cantum-table .label-col { background: #f3f4f6; font-size: 0.82rem; min-width: 100px; }
.rph-cantum-table td { vertical-align: top; padding: 6px; }
.kemahiran-badge {
    display: inline-flex; align-items: center; gap: 4px;
    background: #f0f4ff; border: 1px solid #c7d2fe;
    border-radius: 20px; padding: 3px 10px;
    font-size: 0.78rem; cursor: pointer; margin: 2px;
}
</style>

<x-jawi-keyboard />

@push('scripts')
<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
@endpush

@endsection
