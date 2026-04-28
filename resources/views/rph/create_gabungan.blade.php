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
                            <h4 class="rbt-title-style-3">Cipta RPH Kelas Gabungan</h4>
                            <a href="{{ route('rph.index') }}" class="rbt-btn btn-sm btn-border">
                                <i class="feather-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <form action="{{ route('rph.store') }}" method="POST" id="form-gabungan">
                            @csrf
                            <input type="hidden" name="class_type" value="gabungan">

                            {{-- Pilih Kumpulan Tahun --}}
                            <div class="rph-section-header mb--15">Pilih Kumpulan Kelas</div>
                            <div class="mb--30">
                                <div class="btn-group d-flex mb-3" role="group">
                                    <button type="button" class="btn btn-outline-primary" onclick="selectYears([1,2,3])">
                                        <i class="feather-users"></i> Tahun 1, 2 & 3
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="selectYears([4,5,6])">
                                        <i class="feather-users"></i> Tahun 4, 5 & 6
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="toggleCustom()">
                                        <i class="feather-settings"></i> Custom
                                    </button>
                                </div>

                                {{-- Custom Selection --}}
                                <div id="custom-years" style="display:none;" class="p-3 border rounded bg-light">
                                    <label class="form-label fw-bold">Pilih Tahun (Min 2, Max 3):</label>
                                    <div class="btn-group" role="group">
                                        @for($i = 1; $i <= 6; $i++)
                                        <input type="checkbox" class="btn-check year-checkbox" name="combined_years[]"
                                               value="{{ $i }}" id="year{{ $i }}">
                                        <label class="btn btn-outline-success" for="year{{ $i }}">Tahun {{ $i }}</label>
                                        @endfor
                                    </div>
                                    <small class="text-muted d-block mt-2">Pilih 2-3 tahun sahaja</small>
                                </div>

                                <div id="selected-years-display" class="mt-3 p-3 bg-info bg-opacity-10 rounded" style="display:none;">
                                    <strong>Tahun Dipilih:</strong> <span id="selected-years-text"></span>
                                </div>
                            </div>

                            {{-- Maklumat Asas --}}
                            <div class="rph-section-header mb--15">Maklumat Asas</div>
                            <div class="row g-3 mb--30">
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
                                        <label>Masa <span class="text-danger">*</span></label>
                                        <input type="text" name="masa" class="form-control" required placeholder="Cth: 8:00 - 9:00 AM">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb--30">
                                <div class="col-md-6">
                                    <div class="rbt-form-group">
                                        <label>Mata Pelajaran <span class="text-danger">*</span></label>
                                        <input type="text" name="mata_pelajaran" class="form-control" required placeholder="Cth: Tilawah Al-Quran">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="rbt-form-group">
                                        <label>Topik <span class="text-danger">*</span></label>
                                        <input type="text" name="topic" class="form-control" required placeholder="Cth: Surah Al-Fatihah">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb--30">
                                <div class="col-md-6">
                                    <div class="rbt-form-group">
                                        <label>Kelas (untuk rekod) <span class="text-danger">*</span></label>
                                        <select name="kafa_class_id" class="rbt-big-select" required>
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach($classes as $c)
                                            <option value="{{ $c->id }}">{{ $c->display_name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Pilih mana-mana kelas yang terlibat (untuk tujuan pelaporan)</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Dynamic Fields Container --}}
                            <div id="year-fields-container"></div>

                            <div class="mt--30">
                                <button type="submit" class="rbt-btn btn-gradient" id="btn-submit" disabled>
                                    <i class="feather-save"></i> Simpan RPH Gabungan
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
    font-size: 1.1rem;
    font-weight: 600;
    color: #2f57ef;
    border-bottom: 2px solid #2f57ef;
    padding-bottom: 8px;
    margin-bottom: 20px;
}
.year-card {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
}
.year-card-header {
    background: linear-gradient(135deg, #2f57ef 0%, #1e3a8a 100%);
    color: white;
    padding: 15px 20px;
    font-weight: 600;
    font-size: 1.1rem;
}
.year-card-body {
    padding: 20px;
    background: #f9fafb;
}
</style>

<script>
let selectedYears = [];

function selectYears(years) {
    selectedYears = years;
    document.getElementById('custom-years').style.display = 'none';

    // Uncheck all
    document.querySelectorAll('.year-checkbox').forEach(cb => cb.checked = false);

    // Check selected
    years.forEach(y => {
        document.getElementById('year' + y).checked = true;
    });

    generateYearFields(years);
}

function toggleCustom() {
    const customDiv = document.getElementById('custom-years');
    const isVisible = customDiv.style.display !== 'none';
    customDiv.style.display = isVisible ? 'none' : 'block';

    if (!isVisible) {
        // Setup listeners
        document.querySelectorAll('.year-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const checked = Array.from(document.querySelectorAll('.year-checkbox:checked'))
                    .map(c => parseInt(c.value))
                    .sort((a, b) => a - b);

                if (checked.length < 2) {
                    alert('Minimum 2 tahun diperlukan');
                    this.checked = false;
                    return;
                }
                if (checked.length > 3) {
                    alert('Maksimum 3 tahun sahaja');
                    this.checked = false;
                    return;
                }

                selectedYears = checked;
                generateYearFields(checked);
            });
        });
    }
}

function generateYearFields(years) {
    const container = document.getElementById('year-fields-container');
    const display = document.getElementById('selected-years-display');
    const displayText = document.getElementById('selected-years-text');
    const btnSubmit = document.getElementById('btn-submit');

    if (years.length === 0) {
        container.innerHTML = '';
        display.style.display = 'none';
        btnSubmit.disabled = true;
        return;
    }

    // Show selected years
    display.style.display = 'block';
    displayText.textContent = years.map(y => 'Tahun ' + y).join(', ');
    btnSubmit.disabled = false;

    container.innerHTML = '';

    years.forEach(year => {
        container.innerHTML += `
            <div class="year-card">
                <div class="year-card-header">
                    <i class="feather-book-open"></i> TAHUN ${year}
                </div>
                <div class="year-card-body">
                    <div class="mb-3">
                        <label class="jawi-label">اوبجيكتيف ڤمبلاجرن <span class="text-danger">*</span></label>
                        <textarea id="y${year}_objektif_rumi"
                                  class="form-control rph-rumi-box"
                                  rows="2"
                                  placeholder="Taip Rumi di sini..."></textarea>
                        <div class="rph-convert-bar">
                            <button type="button"
                                    class="btn-tukar-jawi"
                                    onclick="tukarKeJawi('y${year}_objektif_rumi', 'y${year}_objektif_jawi')">
                                ↓ Tukar ke Jawi
                            </button>
                        </div>
                        <textarea id="y${year}_objektif_jawi"
                                  name="objectives_by_year[${year}]"
                                  class="form-control jawi-input"
                                  rows="3"
                                  dir="rtl"
                                  required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="jawi-label">ستندرد ڤمبلاجرن <span class="text-danger">*</span></label>
                        <textarea id="y${year}_standard_rumi"
                                  class="form-control rph-rumi-box"
                                  rows="2"
                                  placeholder="Taip Rumi di sini..."></textarea>
                        <div class="rph-convert-bar">
                            <button type="button"
                                    class="btn-tukar-jawi"
                                    onclick="tukarKeJawi('y${year}_standard_rumi', 'y${year}_standard_jawi')">
                                ↓ Tukar ke Jawi
                            </button>
                        </div>
                        <textarea id="y${year}_standard_jawi"
                                  name="standards_by_year[${year}]"
                                  class="form-control jawi-input"
                                  rows="3"
                                  dir="rtl"
                                  required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="jawi-label">اكتيۏيتي ڤ&ڤ <span class="text-danger">*</span></label>
                        <textarea id="y${year}_aktiviti_rumi"
                                  class="form-control rph-rumi-box"
                                  rows="2"
                                  placeholder="Taip Rumi di sini..."></textarea>
                        <div class="rph-convert-bar">
                            <button type="button"
                                    class="btn-tukar-jawi"
                                    onclick="tukarKeJawi('y${year}_aktiviti_rumi', 'y${year}_aktiviti_jawi')">
                                ↓ Tukar ke Jawi
                            </button>
                        </div>
                        <textarea id="y${year}_aktiviti_jawi"
                                  name="activities_by_year[${year}]"
                                  class="form-control jawi-input"
                                  rows="4"
                                  dir="rtl"
                                  required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="jawi-label">ڤنيلاين</label>
                        <textarea id="y${year}_penilaian_rumi"
                                  class="form-control rph-rumi-box"
                                  rows="2"
                                  placeholder="Taip Rumi di sini..."></textarea>
                        <div class="rph-convert-bar">
                            <button type="button"
                                    class="btn-tukar-jawi"
                                    onclick="tukarKeJawi('y${year}_penilaian_rumi', 'y${year}_penilaian_jawi')">
                                ↓ Tukar ke Jawi
                            </button>
                        </div>
                        <textarea id="y${year}_penilaian_jawi"
                                  name="assessment_by_year[${year}]"
                                  class="form-control jawi-input"
                                  rows="3"
                                  dir="rtl"></textarea>
                    </div>
                </div>
            </div>
        `;
    });
}

// Form validation
document.getElementById('form-gabungan').addEventListener('submit', function(e) {
    if (selectedYears.length < 2) {
        e.preventDefault();
        alert('Sila pilih sekurang-kurangnya 2 tahun');
        return false;
    }
});
</script>

<style>
    .jawi-label {
        font-family: 'Lateef', 'Scheherazade New', serif;
        font-size: 1.1em;
        direction: rtl;
        text-align: right;
        display: block;
        margin-bottom: 8px;
    }
    .jawi-input {
        font-family: 'Lateef', 'Scheherazade New', serif !important;
        font-size: 1.25em !important;
        direction: rtl !important;
        text-align: right !important;
        line-height: 1.8 !important;
    }
    .rph-rumi-box {
        background: #f8f9fa;
        border: 1px dashed #ccc;
        margin-bottom: 5px;
    }
    .rph-convert-bar {
        text-align: center;
        margin: 5px 0 10px 0;
    }
    .btn-tukar-jawi {
        background: transparent;
        border: 1px solid #6c63ff;
        color: #6c63ff;
        border-radius: 4px;
        padding: 3px 14px;
        font-size: 0.78em;
        cursor: pointer;
        transition: background .2s, color .2s;
    }
    .btn-tukar-jawi:hover {
        background: #6c63ff;
        color: white;
    }
</style>

<x-jawi-keyboard />

@push('scripts')
<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
@endpush

@endsection
