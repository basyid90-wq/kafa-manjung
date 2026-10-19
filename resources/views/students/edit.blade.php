@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6" x-data="{ tab: 1 }">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Kemaskini Maklumat Murid</h1>
            <p class="ek-page-sub mt-1">{{ $student->name }}</p>
        </div>
        <a href="{{ route('students.index', ['page' => request()->page]) }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Wizard Tabs --}}
    <div class="flex gap-1 mb-6 bg-gray-100 rounded-xl p-1 overflow-x-auto">
        <button type="button" @click="tab = 1"
                :class="tab === 1 ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            1. Maklumat Peribadi
        </button>
        <button type="button" @click="tab = 2"
                :class="tab === 2 ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            2. Akademik (KAFA)
        </button>
        <button type="button" @click="tab = 3"
                :class="tab === 3 ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            3. Ibu Bapa / Waris
        </button>
        <button type="button" @click="tab = 4"
                :class="tab === 4 ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            4. Kesihatan & Kecemasan
        </button>
    </div>

    <form action="{{ route('students.update', array_merge(['student' => $student->id], request()->query())) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Tab 1: Maklumat Peribadi --}}
        <div x-show="tab === 1" class="ek-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2 flex flex-col items-center gap-2">
                    @if($student->profile_picture)
                    <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="Gambar"
                         class="w-24 h-24 rounded-xl border-2 border-gray-200 object-cover">
                    @endif
                    <label class="ek-label" for="profile_picture_edit">Tukar Gambar Pelajar</label>
                    <div style="display:flex;align-items:center;border:1px solid #d1d5db;border-radius:0.5rem;overflow:hidden;background:#f9fafb;cursor:pointer;" onclick="document.getElementById('profile_picture_edit').click()">
                        <span style="padding:0.5rem 1rem;background:#f3f4f6;border-right:1px solid #d1d5db;font-size:0.875rem;font-weight:500;color:#374151;white-space:nowrap;flex-shrink:0;">Pilih Fail</span>
                        <span id="profile_picture_edit-fname" style="padding:0.5rem 0.75rem;font-size:0.875rem;color:#6b7280;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Tiada fail dipilih</span>
                    </div>
                    <input type="file" name="profile_picture" id="profile_picture_edit" accept="image/*" style="display:none;" onchange="updateFilename(this,'profile_picture_edit-fname')">
                    <p style="margin-top:4px;font-size:0.75rem;color:#6b7280;" id="profile_picture_edit_help">JPEG, PNG atau JPG (MAX. 2MB). Kosongkan jika tiada perubahan.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Nama Penuh Murid (Rumi) <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" required
                           class="ek-input">
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Nama Murid (Jawi)</label>
                    <input id="jawi_name_rumi" type="text" placeholder="Taip nama Rumi untuk ditukarkan..."
                           class="ek-input mb-1">
                    <div class="flex justify-end mb-1">
                        <button type="button" onclick="tukarKeJawi('jawi_name_rumi', 'jawi_name')"
                                class="text-xs px-3 py-1 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-lg transition-colors">
                            ↓ Tukar ke Jawi
                        </button>
                    </div>
                    <input id="jawi_name" name="jawi_name" type="text" value="{{ old('jawi_name', $student->jawi_name) }}"
                           dir="rtl" placeholder="أو اكتب / tampal terus di sini..."
                           class="ek-input jawi-input">
                </div>

                <div>
                    <label class="ek-label">No. MyKid <span class="text-red-500">*</span></label>
                    <input id="mykid" type="text" name="mykid" value="{{ old('mykid', $student->mykid) }}" required
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Jantina</label>
                    <select name="gender"
                            class="ek-input">
                        <option value="">-- Pilih Jantina --</option>
                        <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Lelaki</option>
                        <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="ek-label">Tarikh Lahir</label>
                    <input id="dob" type="date" name="dob" value="{{ old('dob', $student->dob) }}" readonly
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Umur</label>
                    <input id="age" type="number" name="age" value="{{ old('age', $student->standard_age) }}" readonly
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}"
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Bangsa</label>
                    <input type="text" name="race" value="{{ old('race', $student->race) }}"
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Warganegara</label>
                    <input type="text" name="citizenship" value="{{ old('citizenship', $student->citizenship) }}"
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Status OKU</label>
                    <input type="text" name="oku_status" value="{{ old('oku_status', $student->oku_status) }}" placeholder="Jika ada"
                           class="ek-input">
                </div>
                <div class="md:col-span-2">
                    <label class="ek-label">Alamat</label>
                    <textarea name="address" rows="3"
                              class="ek-input">{{ old('address', $student->address) }}</textarea>
                </div>
            </div>
            <div class="flex justify-end mt-5">
                <button type="button" @click="tab = 2"
                        class="ek-btn-primary">
                    Seterusnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </div>
        </div>

        {{-- Tab 2: Akademik --}}
        <div x-show="tab === 2" class="ek-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="ek-label">No. Pendaftaran</label>
                    <input type="text" name="registration_no" value="{{ old('registration_no', $student->registration_no) }}"
                           class="ek-input">
                </div>
                @hasanyrole('Super Admin')
                <div>
                    <label class="ek-label">Pilih Sekolah <span class="text-red-500">*</span></label>
                    <select id="school_id" name="school_id" required
                            class="ek-input">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schools as $s)
                            <option value="{{ $s->id }}" {{ old('school_id', $student->school_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endhasanyrole
                <div>
                    <label class="ek-label">Sesi Persekolahan</label>
                    <input type="text" name="session_year" value="{{ old('session_year', $student->session_year) }}"
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Kelas</label>
                    <select id="kafa_class_id" name="kafa_class_id"
                            class="ek-input">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ old('kafa_class_id', $student->kafa_class_id) == $c->id ? 'selected' : '' }}>{{ $c->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="ek-label">Status Murid</label>
                    <select name="status"
                            class="ek-input">
                        <option value="Aktif" {{ old('status', $student->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $student->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="Tamat" {{ old('status', $student->status) == 'Tamat' ? 'selected' : '' }}>Tamat</option>
                    </select>
                </div>
                <div>
                    <label class="ek-label">Tarikh Masuk</label>
                    <input type="date" name="entry_date" value="{{ old('entry_date', $student->entry_date) }}"
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">SK / Sekolah Asal</label>
                    <input type="text" name="origin_school" value="{{ old('origin_school', $student->origin_school) }}"
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Angka Giliran UPKK</label>
                    <input type="text" name="upkk_number" value="{{ old('upkk_number', $student->upkk_number) }}"
                           class="ek-input">
                </div>
            </div>
            <div class="flex justify-between mt-5">
                <button type="button" @click="tab = 1"
                        class="ek-btn-secondary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Kembali
                </button>
                <button type="button" @click="tab = 3"
                        class="ek-btn-primary">
                    Seterusnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </div>
        </div>

        {{-- Tab 3: Ibu Bapa --}}
        <div x-show="tab === 3" class="ek-card">
            <p class="text-sm font-semibold text-gray-700 mb-4">Maklumat Bapa / Penjaga 1</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div><label class="ek-label">Nama Bapa</label><input type="text" name="father_name" value="{{ old('father_name', $student->father_name) }}" class="ek-input"></div>
                <div><label class="ek-label">No. K/P Bapa</label><input type="text" name="father_ic" value="{{ old('father_ic', $student->father_ic) }}" class="ek-input"></div>
                <div><label class="ek-label">No. Tel Bapa</label><x-phone-input name="father_phone" :value="old('father_phone', $student->father_phone)" /></div>
                <div><label class="ek-label">Pekerjaan Bapa</label><input type="text" name="father_job" value="{{ old('father_job', $student->father_job) }}" class="ek-input"></div>
                <div><label class="ek-label">Pendapatan (RM)</label><input type="number" step="0.01" name="father_income" value="{{ old('father_income', $student->father_income) }}" class="ek-input"></div>
            </div>
            <hr class="border-gray-200 mb-4">
            <p class="text-sm font-semibold text-gray-700 mb-4">Maklumat Ibu / Penjaga 2</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div><label class="ek-label">Nama Ibu</label><input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}" class="ek-input"></div>
                <div><label class="ek-label">No. K/P Ibu</label><input type="text" name="mother_ic" value="{{ old('mother_ic', $student->mother_ic) }}" class="ek-input"></div>
                <div><label class="ek-label">No. Tel Ibu</label><x-phone-input name="mother_phone" :value="old('mother_phone', $student->mother_phone)" /></div>
                <div><label class="ek-label">Pekerjaan Ibu</label><input type="text" name="mother_job" value="{{ old('mother_job', $student->mother_job) }}" class="ek-input"></div>
                <div><label class="ek-label">Pendapatan (RM)</label><input type="number" step="0.01" name="mother_income" value="{{ old('mother_income', $student->mother_income) }}" class="ek-input"></div>
            </div>
            <hr class="border-gray-200 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="ek-label">Bilangan Tanggungan</label><input type="number" name="dependents_count" value="{{ old('dependents_count', $student->dependents_count) }}" class="ek-input"></div>
                <div><label class="ek-label">Status Hubungan</label><input type="text" name="parents_relationship_status" value="{{ old('parents_relationship_status', $student->parents_relationship_status) }}" class="ek-input"></div>
            </div>
            <div class="flex justify-between mt-5">
                <button type="button" @click="tab = 2"
                        class="ek-btn-secondary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Kembali
                </button>
                <button type="button" @click="tab = 4"
                        class="ek-btn-primary">
                    Seterusnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </div>
        </div>

        {{-- Tab 4: Kesihatan --}}
        <div x-show="tab === 4" class="ek-card">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="ek-label">Penyakit Kronik</label>
                    <textarea name="chronic_disease" rows="2" class="ek-input">{{ old('chronic_disease', $student->chronic_disease) }}</textarea>
                </div>
                <div>
                    <label class="ek-label">Alahan</label>
                    <textarea name="allergies" rows="2" class="ek-input">{{ old('allergies', $student->allergies) }}</textarea>
                </div>
                <div>
                    <label class="ek-label">Kenalan Kecemasan</label>
                    <textarea name="emergency_contact" rows="2" class="ek-input">{{ old('emergency_contact', $student->emergency_contact) }}</textarea>
                </div>
            </div>
            <div class="flex justify-between mt-5">
                <button type="button" @click="tab = 3"
                        class="ek-btn-secondary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Kembali
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Kemaskini Rekod
                </button>
            </div>
        </div>
    </form>
</div>

<x-jawi-keyboard />

<script>
    const mykidInput = document.getElementById('mykid');
    const dobInput   = document.getElementById('dob');
    const ageInput   = document.getElementById('age');

    function calculateMyKidData() {
        if (!mykidInput) return;
        let mykid = mykidInput.value.replace(/[^0-9]/g, '');
        if (mykid.length>= 6) {
            let yearStr = mykid.substring(0, 2);
            let month   = mykid.substring(2, 4);
            let day     = mykid.substring(4, 6);
            let year    = (parseInt(yearStr)> 50) ? 1900 + parseInt(yearStr) : 2000 + parseInt(yearStr);
            if (dobInput) dobInput.value = year + '-' + month + '-' + day;
            if (ageInput) ageInput.value = new Date().getFullYear() - year;
        } else {
            if (dobInput) dobInput.value = '';
            if (ageInput) ageInput.value = '';
        }
    }

    if (mykidInput) {
        mykidInput.addEventListener('input', calculateMyKidData);
        calculateMyKidData();
    }

    const schoolSelect = document.getElementById('school_id');
    const classSelect  = document.getElementById('kafa_class_id');
    if (schoolSelect && classSelect) {
        schoolSelect.addEventListener('change', function() {
            const schoolId = this.value;
            classSelect.innerHTML = '<option value="">-- Memuatkan... --</option>';
            if (!schoolId) { classSelect.innerHTML = '<option value="">-- Pilih Sekolah Dahulu --</option>'; return; }
            fetch(`{{ url('get-classes') }}/${schoolId}`)
                .then(r => r.json())
                .then(data => {
                    classSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                    data.forEach(item => { classSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`; });
                });
        });
    }
</script>
@endsection
