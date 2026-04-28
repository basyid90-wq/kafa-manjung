@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
@endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<style>
    /* Wizard Tab Styling */
    .nav-pills .nav-link {
        border: 1px solid #ddd;
        border-radius: 5px;
        color: #666;
        padding: 15px;
        transition: all 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: var(--color-primary) !important;
        color: white !important;
        border-color: var(--color-primary);
    }
</style>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Kemaskini Maklumat Murid</h4>
                        </div>

                        <form action="{{ route('students.update', array_merge(['student' => $student->id], request()->query())) }}" method="POST" enctype="multipart/form-data" class="rbt-default-form" id="wizard-form">
                            @csrf @method('PUT')
                            
                            <ul class="nav nav-pills nav-justified mb-4" id="studentTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">1. Maklumat Peribadi</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab">2. Akademik (KAFA)</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="parents-tab" data-bs-toggle="tab" data-bs-target="#parents" type="button" role="tab">3. Ibu Bapa / Waris</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="health-tab" data-bs-toggle="tab" data-bs-target="#health" type="button" role="tab">4. Kesihatan & Kecemasan</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="studentTabContent">
                                <!-- Tab 1: Maklumat Peribadi -->
                                <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                    <div class="row row--15">
                                        <div class="col-md-4 offset-md-4 mb--20 text-center">
                                            @if($student->profile_picture)
                                                <div class="mb--10">
                                                    <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px; border: 2px solid #ddd;">
                                                </div>
                                            @endif
                                            <div class="rbt-form-group">
                                                <label for="profile_picture">Tukar Gambar Pelajar</label>
                                                <input id="profile_picture" name="profile_picture" type="file" accept="image/*">
                                                <small class="text-muted">Format: jpeg, png, jpg. Maks: 2MB</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="rbt-form-group">
                                                <label for="name">Nama Penuh Murid (Rumi)</label>
                                                <input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="rbt-form-group">
                                                <label>Nama Murid (Jawi) <small class="text-muted">— digunakan dalam Buku Kedatangan PDF</small></label>
                                                {{-- Kotak Rumi — tiada name, tidak dihantar ke server --}}
                                                <input id="jawi_name_rumi" type="text"
                                                       class="form-control jawi-rumi-helper mb-1"
                                                       placeholder="Taip nama Rumi di sini, kemudian klik ↓ Tukar ke Jawi...">
                                                <div class="text-end mb-1">
                                                    <button type="button" class="btn-tukar-jawi"
                                                            onclick="tukarKeJawi('jawi_name_rumi', 'jawi_name')">
                                                        ↓ Tukar ke Jawi
                                                    </button>
                                                </div>
                                                {{-- Kotak Jawi — name="jawi_name", disimpan ke DB --}}
                                                <input id="jawi_name" name="jawi_name" type="text"
                                                       value="{{ old('jawi_name', $student->jawi_name) }}"
                                                       dir="rtl"
                                                       placeholder="أو اكتب / tampal terus di sini..."
                                                       class="form-control jawi-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="mykid">No. MyKid</label>
                                                <input id="mykid" name="mykid" type="text" value="{{ old('mykid', $student->mykid) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="rbt-form-group">
                                                <label for="dob">Tarikh Lahir</label>
                                                <input id="dob" name="dob" type="date" value="{{ old('dob', $student->dob) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="rbt-form-group">
                                                <label for="age">Umur</label>
                                                <input id="age" name="age" type="number" value="{{ old('age', $student->standard_age) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="gender">Jantina</label>
                                                <select name="gender" id="gender" class="rbt-big-select">
                                                    <option value="">-- Pilih Jantina --</option>
                                                    <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Lelaki</option>
                                                    <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="birth_place">Tempat Lahir</label>
                                                <input id="birth_place" name="birth_place" type="text" value="{{ old('birth_place', $student->birth_place) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="race">Bangsa</label>
                                                <input id="race" name="race" type="text" value="{{ old('race', $student->race) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="citizenship">Warganegara</label>
                                                <input id="citizenship" name="citizenship" type="text" value="{{ old('citizenship', $student->citizenship) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="oku_status">Status OKU</label>
                                                <input id="oku_status" name="oku_status" type="text" value="{{ old('oku_status', $student->oku_status) }}" placeholder="Jika ada">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="rbt-form-group">
                                                <label for="address">Alamat</label>
                                                <textarea id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt--30 text-end">
                                        <button type="button" class="rbt-btn btn-primary btn-next">Seterusnya <i class="feather-arrow-right"></i></button>
                                    </div>
                                </div>

                                <!-- Tab 2: Akademik -->
                                <div class="tab-pane fade" id="academic" role="tabpanel">
                                    <div class="row row--15">
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="registration_no">No. Pendaftaran</label>
                                                <input id="registration_no" name="registration_no" type="text" value="{{ old('registration_no', $student->registration_no) }}">
                                            </div>
                                        </div>
                                        @hasanyrole('Super Admin|Pentadbir|Pembekal')
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="school_id">Pilih Sekolah</label>
                                                <select name="school_id" id="school_id" class="rbt-big-select" required>
                                                    <option value="">-- Pilih Sekolah --</option>
                                                    @foreach($schools as $s)
                                                        <option value="{{ $s->id }}" {{ old('school_id', $student->school_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endhasanyrole
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="session_year">Sesi Persekolahan</label>
                                                <input id="session_year" name="session_year" type="text" value="{{ old('session_year', $student->session_year) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="kafa_class_id">Kelas</label>
                                                <select name="kafa_class_id" id="kafa_class_id" class="rbt-big-select">
                                                    <option value="">-- Pilih Kelas --</option>
                                                    @foreach($classes as $c)
                                                    <option value="{{ $c->id }}" {{ old('kafa_class_id', $student->kafa_class_id) == $c->id ? 'selected' : '' }}>{{ $c->display_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="status">Status Murid</label>
                                                <select name="status" id="status" class="rbt-big-select">
                                                    <option value="Aktif" {{ old('status', $student->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Tidak Aktif" {{ old('status', $student->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                    <option value="Tamat" {{ old('status', $student->status) == 'Tamat' ? 'selected' : '' }}>Tamat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="entry_date">Tarikh Masuk</label>
                                                <input id="entry_date" name="entry_date" type="date" value="{{ old('entry_date', $student->entry_date) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="origin_school">SK / Sekolah Asal</label>
                                                <input id="origin_school" name="origin_school" type="text" value="{{ old('origin_school', $student->origin_school) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="upkk_number">Angka Giliran UPKK</label>
                                                <input id="upkk_number" name="upkk_number" type="text" value="{{ old('upkk_number', $student->upkk_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt--30 d-flex justify-content-between">
                                        <button type="button" class="rbt-btn btn-secondary btn-prev"><i class="feather-arrow-left"></i> Kembali</button>
                                        <button type="button" class="rbt-btn btn-primary btn-next">Seterusnya <i class="feather-arrow-right"></i></button>
                                    </div>
                                </div>

                                <!-- Tab 3: Ibu Bapa / Waris -->
                                <div class="tab-pane fade" id="parents" role="tabpanel">
                                    <div class="row row--15">
                                        <div class="col-lg-12">
                                            <h6 class="mb--10 mt--10">Maklumat Bapa/Penjaga 1</h6>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="father_name">Nama Bapa</label>
                                                <input id="father_name" name="father_name" type="text" value="{{ old('father_name', $student->father_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="father_ic">No. K/P Bapa</label>
                                                <input id="father_ic" name="father_ic" type="text" value="{{ old('father_ic', $student->father_ic) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="father_phone">No. Tel Bapa</label>
                                                <input id="father_phone" name="father_phone" type="text" value="{{ old('father_phone', $student->father_phone) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="father_job">Pekerjaan Bapa</label>
                                                <input id="father_job" name="father_job" type="text" value="{{ old('father_job', $student->father_job) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="father_income">Pendapatan (RM)</label>
                                                <input id="father_income" name="father_income" type="number" step="0.01" value="{{ old('father_income', $student->father_income) }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <hr>
                                            <h6 class="mb--10 mt--10">Maklumat Ibu/Penjaga 2</h6>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="mother_name">Nama Ibu</label>
                                                <input id="mother_name" name="mother_name" type="text" value="{{ old('mother_name', $student->mother_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="mother_ic">No. K/P Ibu</label>
                                                <input id="mother_ic" name="mother_ic" type="text" value="{{ old('mother_ic', $student->mother_ic) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="mother_phone">No. Tel Ibu</label>
                                                <input id="mother_phone" name="mother_phone" type="text" value="{{ old('mother_phone', $student->mother_phone) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="mother_job">Pekerjaan Ibu</label>
                                                <input id="mother_job" name="mother_job" type="text" value="{{ old('mother_job', $student->mother_job) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="rbt-form-group">
                                                <label for="mother_income">Pendapatan (RM)</label>
                                                <input id="mother_income" name="mother_income" type="number" step="0.01" value="{{ old('mother_income', $student->mother_income) }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <hr>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="dependents_count">Bilangan Tanggungan</label>
                                                <input id="dependents_count" name="dependents_count" type="number" value="{{ old('dependents_count', $student->dependents_count) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="rbt-form-group">
                                                <label for="parents_relationship_status">Status Hubungan</label>
                                                <input id="parents_relationship_status" name="parents_relationship_status" type="text" value="{{ old('parents_relationship_status', $student->parents_relationship_status) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt--30 d-flex justify-content-between">
                                        <button type="button" class="rbt-btn btn-secondary btn-prev"><i class="feather-arrow-left"></i> Kembali</button>
                                        <button type="button" class="rbt-btn btn-primary btn-next">Seterusnya <i class="feather-arrow-right"></i></button>
                                    </div>
                                </div>

                                <!-- Tab 4: Kesihatan -->
                                <div class="tab-pane fade" id="health" role="tabpanel">
                                    <div class="row row--15">
                                        <div class="col-12">
                                            <div class="rbt-form-group">
                                                <label for="chronic_disease">Penyakit Kronik</label>
                                                <textarea id="chronic_disease" name="chronic_disease" rows="2">{{ old('chronic_disease', $student->chronic_disease) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="rbt-form-group">
                                                <label for="allergies">Alahan</label>
                                                <textarea id="allergies" name="allergies" rows="2">{{ old('allergies', $student->allergies) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="rbt-form-group">
                                                <label for="emergency_contact">Kenalan Kecemasan</label>
                                                <textarea id="emergency_contact" name="emergency_contact" rows="2">{{ old('emergency_contact', $student->emergency_contact) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt--30 d-flex justify-content-between">
                                        <button type="button" class="rbt-btn btn-secondary btn-prev"><i class="feather-arrow-left"></i> Kembali</button>
                                        <button type="submit" class="rbt-btn btn-success">Kemaskini Rekod <i class="feather-check"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-jawi-keyboard />

@push('scripts')
<script>
    (function() {
        function initWizard() {
            console.log("Initializing Student Wizard...");

            // Matikan selectpicker jika ia wujud pada elemen ini
            function destroySelectPicker(id) {
                const el = $(id);
                if (el.length && typeof el.selectpicker === 'function') {
                    el.selectpicker('destroy');
                    el.show().css({
                        'display': 'block',
                        'visibility': 'visible',
                        'opacity': '1',
                        'position': 'relative'
                    });
                }
            }

            destroySelectPicker('#gender');
            destroySelectPicker('#kafa_class_id');
            destroySelectPicker('#status');
            destroySelectPicker('#school_id');

            // FASA 3: AJAX Ambil Kelas Berdasarkan Sekolah
            const schoolSelect = document.getElementById('school_id');
            const classSelect = document.getElementById('kafa_class_id');

            if (schoolSelect && classSelect) {
                schoolSelect.addEventListener('change', function() {
                    const schoolId = this.value;
                    classSelect.innerHTML = '<option value="">-- Meladukan Senarai... --</option>';

                    if (!schoolId) {
                        classSelect.innerHTML = '<option value="">-- Pilih Sekolah Dahulu --</option>';
                        return;
                    }

                    fetch(`{{ url('get-classes') }}/${schoolId}`)
                        .then(response => response.json())
                        .then(data => {
                            classSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                            data.forEach(item => {
                                classSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                            });
                        })
                        .catch(err => console.error('Error fetching classes:', err));
                });
            }

            // MyKid Auto-calculation Logic
            const mykidInput = document.getElementById('mykid');
            const dobInput = document.getElementById('dob');
            const ageInput = document.getElementById('age');

            function calculateMyKidData() {
                if (!mykidInput) return;
                let mykid = mykidInput.value.replace(/[^0-9]/g, '');
                
                if(mykid.length >= 6) {
                    let yearStr = mykid.substring(0, 2);
                    let month = mykid.substring(2, 4);
                    let day = mykid.substring(4, 6);
                    
                    let year = (parseInt(yearStr) > 50) ? 1900 + parseInt(yearStr) : 2000 + parseInt(yearStr);
                    if(dobInput) dobInput.value = year + '-' + month + '-' + day;
                    
                    let today = new Date();
                    let age = today.getFullYear() - year;
                    if(ageInput) ageInput.value = age;
                } else {
                    if(dobInput) dobInput.value = '';
                    if(ageInput) ageInput.value = '';
                }
            }

            if (mykidInput) {
                mykidInput.addEventListener('input', calculateMyKidData);
                mykidInput.addEventListener('keyup', calculateMyKidData);
                calculateMyKidData(); // Run once on load
            }

            // Wizard Navigation Logic
            const nextButtons = document.querySelectorAll('.btn-next');
            const prevButtons = document.querySelectorAll('.btn-prev');

            nextButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentTab = document.querySelector('.nav-link.active');
                    if (currentTab) {
                        const nextTabLi = currentTab.parentElement.nextElementSibling;
                        if (nextTabLi) {
                            const nextTabLink = nextTabLi.querySelector('.nav-link');
                            if (nextTabLink) {
                                if (window.bootstrap && bootstrap.Tab) {
                                    const tab = new bootstrap.Tab(nextTabLink);
                                    tab.show();
                                } else if (window.jQuery && jQuery.fn.tab) {
                                    jQuery(nextTabLink).tab('show');
                                } else {
                                    nextTabLink.click();
                                }
                            }
                        }
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentTab = document.querySelector('.nav-link.active');
                    if (currentTab) {
                        const prevTabLi = currentTab.parentElement.previousElementSibling;
                        if (prevTabLi) {
                            const prevTabLink = prevTabLi.querySelector('.nav-link');
                            if (prevTabLink) {
                                if (window.bootstrap && bootstrap.Tab) {
                                    const tab = new bootstrap.Tab(prevTabLink);
                                    tab.show();
                                } else if (window.jQuery && jQuery.fn.tab) {
                                    jQuery(prevTabLink).tab('show');
                                } else {
                                    prevTabLink.click();
                                }
                            }
                        }
                    }
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initWizard);
        } else {
            initWizard();
        }
    })();
</script>
@endpush
@endsection
