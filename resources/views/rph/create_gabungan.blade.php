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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Cipta RPH Kelas Cantum</h4>
                            <a href="{{ route('rph.index') }}" class="rbt-btn btn-sm btn-border">
                                <i class="feather-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <form action="{{ route('rph.store') }}" method="POST" id="form-gabungan">
                            @csrf
                            <input type="hidden" name="class_type" value="gabungan">

                            {{-- BAHAGIAN 1: Pilih Tahun --}}
                            <div class="rph-section-header mb--15">1. Pilih Kumpulan Tahun (Kelas Cantum)</div>
                            <div class="mb--20">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="selectYears([1,2,3])">
                                        <i class="feather-users"></i> Tahun 1, 2 &amp; 3
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="selectYears([4,5,6])">
                                        <i class="feather-users"></i> Tahun 4, 5 &amp; 6
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleCustom()">
                                        <i class="feather-settings"></i> Pilih Sendiri
                                    </button>
                                </div>
                                <div id="custom-years" style="display:none;" class="p-3 border rounded bg-light mb-2">
                                    <label class="form-label fw-bold small">Pilih Tahun (Min 2, Maks 3):</label>
                                    <div class="btn-group" role="group">
                                        @for($i = 1; $i <= 6; $i++)
                                        <input type="checkbox" class="btn-check year-checkbox" value="{{ $i }}" id="yr{{ $i }}">
                                        <label class="btn btn-outline-success btn-sm" for="yr{{ $i }}">Tahun {{ $i }}</label>
                                        @endfor
                                    </div>
                                </div>
                                <div id="selected-years-display" class="p-2 bg-info bg-opacity-10 rounded" style="display:none;">
                                    <strong>Tahun Dipilih:</strong> <span id="selected-years-text"></span>
                                    {{-- Hidden inputs untuk combined_years --}}
                                    <div id="combined-years-inputs"></div>
                                </div>
                            </div>

                            {{-- BAHAGIAN 2: Maklumat Asas --}}
                            <div class="rph-section-header mb--15">2. Maklumat Asas</div>
                            <div class="row g-3 mb--20">
                                <div class="col-md-3">
                                    <div class="rbt-form-group">
                                        <label>Tarikh <span class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rbt-form-group">
                                        <label>Hari <span class="text-danger">*</span></label>
                                        <select name="hari" class="rbt-big-select" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach(['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'] as $d)
                                            <option value="{{ $d }}">{{ $d }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="rbt-form-group">
                                        <label>Minggu <span class="text-danger">*</span></label>
                                        <input name="week" type="number" class="form-control" min="1" max="52" required placeholder="1–52">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="rbt-form-group">
                                        <label>Kelas (untuk rekod) <span class="text-danger">*</span></label>
                                        <select name="kafa_class_id" class="rbt-big-select" required>
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach($classes as $c)
                                            <option value="{{ $c->id }}">{{ $c->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- BAHAGIAN 3: 3 Sesi Pengajaran --}}
                            <div class="rph-section-header mb--15">3. Sesi Pengajaran (3 Sesi)</div>
                            <div id="sessions-container">
                                <div class="alert alert-warning">
                                    <i class="feather-info"></i> Sila pilih kumpulan tahun dahulu untuk memaparkan borang sesi.
                                </div>
                            </div>

                            <div class="mt--30" id="btn-row" style="display:none;">
                                <button type="submit" class="rbt-btn btn-gradient">
                                    <i class="feather-save"></i> Simpan RPH Cantum
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
    font-size: 1.05rem;
    font-weight: 600;
    color: #2f57ef;
    border-bottom: 2px solid #2f57ef;
    padding-bottom: 6px;
    margin-bottom: 16px;
}
.year-card {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 24px;
    overflow: hidden;
}
.year-card-header {
    background: linear-gradient(135deg, #2f57ef 0%, #1e3a8a 100%);
    color: white;
    padding: 12px 18px;
    font-weight: 600;
    font-size: 1rem;
}
.year-card-body { padding: 18px; background: #f9fafb; }
.jawi-label {
    font-family: 'Lateef', serif;
    font-size: 1.1em;
    direction: rtl;
    text-align: right;
    display: block;
    margin-bottom: 4px;
}
.jawi-input {
    font-family: 'Lateef', serif !important;
    font-size: 1.2em !important;
    direction: rtl !important;
    text-align: right !important;
    line-height: 1.8 !important;
}
.rph-rumi-box {
    background: #f8f9fa;
    border: 1px dashed #ccc;
    margin-bottom: 4px;
    font-size: 0.85em;
}
.rph-convert-bar { text-align: center; margin: 3px 0 6px; }
.btn-tukar-jawi {
    background: transparent;
    border: 1px solid #6c63ff;
    color: #6c63ff;
    border-radius: 4px;
    padding: 2px 10px;
    font-size: 0.75em;
    cursor: pointer;
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
.kemahiran-badge input { cursor: pointer; }
</style>

<script>
const KEMAHIRAN = [
    ['menulis',                'Menulis'],
    ['membaca',                'Membaca'],
    ['menyanyi',               'Menyanyi'],
    ['melukis',                'Melukis'],
    ['melabel',                'Melabel'],
    ['memilih_mengkategorikan','Memilih/Mengkategorikan'],
    ['mengira_membilang',      'Mengira/Membilang'],
    ['luar_bilik_darjah',      'Luar Bilik Darjah'],
    ['simulasi',               'Simulasi'],
    ['memupuk_menanamkan',     'Memupuk/Menanamkan'],
    ['menghafaz',              'Menghafaz'],
];
const STRATEGI = [
    ['berpusatkan_guru',   'Berpusatkan Guru'],
    ['berpusatkan_murid',  'Berpusatkan Murid'],
    ['luar_bilik_darjah',  'Luar Bilik Darjah'],
    ['talqi_musyafahah',   'Talqi Musyafahah'],
];
const FIELD_ROWS = [
    { key: 'tajuk_by_year',           jawi: 'تاجوق',           rumi: 'Tajuk',            required: true  },
    { key: 'isi_pelajaran_by_year',   jawi: 'ايسي ڤلاجرن',     rumi: 'Isi Pelajaran',    required: true  },
    { key: 'objective_by_year',       jawi: 'اوبجيكتيف',        rumi: 'Objektif Pelajaran', required: true },
    { key: 'aktiviti_by_year',        jawi: 'اكتيۏيتي',         rumi: 'Aktiviti',         required: true  },
];

let selectedYears = [];

function selectYears(years) {
    selectedYears = [...years];
    document.querySelectorAll('.year-checkbox').forEach(cb => cb.checked = false);
    years.forEach(y => { const cb = document.getElementById('yr' + y); if (cb) cb.checked = true; });
    document.getElementById('custom-years').style.display = 'none';
    renderAll();
}

function toggleCustom() {
    const div = document.getElementById('custom-years');
    div.style.display = div.style.display === 'none' ? 'block' : 'none';
    document.querySelectorAll('.year-checkbox').forEach(cb => {
        cb.onchange = function() {
            const checked = Array.from(document.querySelectorAll('.year-checkbox:checked'))
                .map(c => parseInt(c.value)).sort((a, b) => a - b);
            if (checked.length > 3) { this.checked = false; alert('Maksimum 3 tahun sahaja'); return; }
            selectedYears = checked;
            if (checked.length >= 2) renderAll();
        };
    });
}

function renderAll() {
    if (selectedYears.length < 2) return;

    // Update hidden inputs for combined_years
    const inp = document.getElementById('combined-years-inputs');
    inp.innerHTML = selectedYears.map(y => `<input type="hidden" name="combined_years[]" value="${y}">`).join('');
    document.getElementById('selected-years-display').style.display = 'block';
    document.getElementById('selected-years-text').textContent = selectedYears.map(y => 'Tahun ' + y).join(', ');

    // Render 3 session cards
    const container = document.getElementById('sessions-container');
    container.innerHTML = [1, 2, 3].map(s => buildSessionCard(s)).join('');
    document.getElementById('btn-row').style.display = 'block';
}

function buildSessionCard(s) {
    const yearHeaders = selectedYears.map(y => `<th class="text-center">TAHUN ${y}</th>`).join('');

    const fieldRows = FIELD_ROWS.map(f => {
        const yearCells = selectedYears.map(y => `
            <td>
                <textarea id="s${s}_y${y}_${f.key}_rumi" class="form-control rph-rumi-box" rows="2" placeholder="Taip Rumi..."></textarea>
                <div class="rph-convert-bar">
                    <button type="button" class="btn-tukar-jawi"
                            onclick="tukarKeJawi('s${s}_y${y}_${f.key}_rumi','s${s}_y${y}_${f.key}_jawi')">↓ Jawi</button>
                </div>
                <textarea id="s${s}_y${y}_${f.key}_jawi"
                          name="periods[${s}][${f.key}][${y}]"
                          class="form-control jawi-input" rows="3" dir="rtl"${f.required ? ' required' : ''}></textarea>
            </td>`).join('');
        return `
            <tr>
                <td class="label-col">
                    <div class="jawi-label">${f.jawi}</div>
                    <small class="text-muted">${f.rumi}</small>
                </td>
                ${yearCells}
            </tr>`;
    }).join('');

    const kemahiranBoxes = KEMAHIRAN.map(([val, label]) => `
        <label class="kemahiran-badge">
            <input type="checkbox" name="periods[${s}][kemahiran_selected][]" value="${val}"> ${label}
        </label>`).join('');

    const strategiBoxes = STRATEGI.map(([val, label]) => `
        <label class="kemahiran-badge">
            <input type="checkbox" name="periods[${s}][strategi_pdc][]" value="${val}"> ${label}
        </label>`).join('');

    return `
    <div class="year-card">
        <div class="year-card-header"><i class="feather-clock"></i> SESI ${s}</div>
        <div class="year-card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="jawi-label">مات ڤلاجرن</label>
                    <small class="text-muted d-block mb-1">Mata Pelajaran <span class="text-danger">*</span></small>
                    <input type="text" id="s${s}_mp_rumi" class="form-control rph-rumi-box" placeholder="Taip Rumi...">
                    <div class="rph-convert-bar">
                        <button type="button" class="btn-tukar-jawi"
                                onclick="tukarKeJawi('s${s}_mp_rumi','s${s}_mp_jawi')">↓ Jawi</button>
                    </div>
                    <input type="text" id="s${s}_mp_jawi"
                           name="periods[${s}][mata_pelajaran_jawi]"
                           class="form-control jawi-input" dir="rtl" required>
                </div>
                <div class="col-md-4">
                    <label>Masa <span class="text-danger">*</span></label>
                    <input type="text" name="periods[${s}][masa]"
                           class="form-control" required placeholder="Cth: 8:00 - 9:00 PG">
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered rph-cantum-table align-middle">
                    <thead>
                        <tr>
                            <th width="18%">Perkara</th>
                            ${yearHeaders}
                        </tr>
                    </thead>
                    <tbody>${fieldRows}</tbody>
                </table>
            </div>

            <div class="mb-3 p-3 bg-light rounded">
                <label class="fw-bold mb-2 d-block">
                    <span class="jawi-label" style="font-size:1em;">كماهيرن</span> Kemahiran:
                </label>
                <div>${kemahiranBoxes}</div>
            </div>

            <div class="mb-3 p-3 bg-light rounded">
                <label class="fw-bold mb-2 d-block">
                    <span class="jawi-label" style="font-size:1em;">ستراتڬي ڤدڤ</span> Strategi PdP:
                </label>
                <div>${strategiBoxes}</div>
            </div>

            <div class="p-3 border rounded">
                <label class="fw-bold mb-2 d-block">
                    <span class="jawi-label" style="font-size:1em;">ايمڤك ڤمبلاجرن</span> Impak Pembelajaran:
                </label>
                <div class="row g-2">
                    <div class="col-md-5">
                        <label class="small fw-semibold">
                            Murid berjaya capai objektif (____/____):
                        </label>
                        <input type="text" name="periods[${s}][impak][berjaya]"
                               class="form-control form-control-sm" placeholder="cth: 20/25">
                    </div>
                    <div class="col-md-5">
                        <label class="small fw-semibold">
                            Murid belum berjaya (____/____):
                        </label>
                        <input type="text" name="periods[${s}][impak][belum]"
                               class="form-control form-control-sm" placeholder="cth: 5/25">
                    </div>
                    <div class="col-12">
                        <label class="small fw-semibold">Aktiviti P&amp;P ditangguhkan kerana:</label>
                        <input type="text" name="periods[${s}][impak][sebab_ditangguh]"
                               class="form-control form-control-sm" placeholder="(kosong jika tidak ditangguh)">
                    </div>
                    <div class="col-12">
                        <label class="small fw-semibold">Aktiviti P&amp;P diteruskan pada:</label>
                        <input type="text" name="periods[${s}][impak][tarikh_teruskan]"
                               class="form-control form-control-sm" placeholder="(kosong jika tidak ditangguh)">
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

document.getElementById('form-gabungan').addEventListener('submit', function(e) {
    if (selectedYears.length < 2) {
        e.preventDefault();
        alert('Sila pilih sekurang-kurangnya 2 tahun terlebih dahulu.');
    }
});
</script>

<x-jawi-keyboard />

@push('scripts')
<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
@endpush

@endsection
