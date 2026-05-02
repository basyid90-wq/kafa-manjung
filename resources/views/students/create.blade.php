@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6" x-data="{ tab: 1 }">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Murid Baru</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Isi maklumat murid merentas semua bahagian.</p>
        </div>
        <a href="{{ route('students.index', ['page' => request()->page]) }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Wizard Tabs --}}
    <div class="flex gap-1 mb-6 bg-gray-100 dark:bg-gray-800 rounded-xl p-1 overflow-x-auto">
        <button type="button" @click="tab = 1"
                :class="tab === 1 ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            1. Maklumat Peribadi
        </button>
        <button type="button" @click="tab = 2"
                :class="tab === 2 ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            2. Akademik (KAFA)
        </button>
        <button type="button" @click="tab = 3"
                :class="tab === 3 ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            3. Ibu Bapa / Waris
        </button>
        <button type="button" @click="tab = 4"
                :class="tab === 4 ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                class="flex-1 min-w-max px-3 py-2 text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            4. Kesihatan & Kecemasan
        </button>
    </div>

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Tab 1: Maklumat Peribadi --}}
        <div x-show="tab === 1" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Photo upload centred --}}
                <div class="md:col-span-2 flex flex-col items-center gap-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Pelajar</label>
                    <input type="file" name="profile_picture" accept="image/*"
                           class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400">Format: jpeg, png, jpg. Maks: 2MB</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Penuh Murid (Rumi) <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nama Murid (Jawi) <span class="text-xs text-gray-400">— digunakan dalam Buku Kedatangan PDF</span>
                    </label>
                    <input id="jawi_name_rumi" type="text" placeholder="Taip nama Rumi di sini, kemudian klik ↓ Tukar ke Jawi..."
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-1">
                    <div class="flex justify-end mb-1">
                        <button type="button" onclick="tukarKeJawi('jawi_name_rumi', 'jawi_name')"
                                class="text-xs px-3 py-1 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-lg transition-colors">
                            ↓ Tukar ke Jawi
                        </button>
                    </div>
                    <input id="jawi_name" name="jawi_name" type="text" value="{{ old('jawi_name') }}"
                           dir="rtl" placeholder="أو اكتب / tampal terus di sini..."
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 jawi-input">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. MyKid <span class="text-red-500">*</span></label>
                    <input id="mykid" type="text" name="mykid" value="{{ old('mykid') }}" placeholder="Contoh: 150523081234" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jantina</label>
                    <select name="gender"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Jantina --</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Lelaki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarikh Lahir</label>
                    <input id="dob" type="date" name="dob" value="{{ old('dob') }}" readonly
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Umur</label>
                    <input id="age" type="number" name="age" value="{{ old('age') }}" readonly
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bangsa</label>
                    <input type="text" name="race" value="{{ old('race') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Warganegara</label>
                    <input type="text" name="citizenship" value="{{ old('citizenship') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status OKU</label>
                    <input type="text" name="oku_status" value="{{ old('oku_status') }}" placeholder="Jika ada"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                    <textarea name="address" rows="3"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                </div>
            </div>
            <div class="flex justify-end mt-5">
                <button type="button" @click="tab = 2"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Seterusnya
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Tab 2: Akademik --}}
        <div x-show="tab === 2" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Pendaftaran</label>
                    <input type="text" name="registration_no" value="{{ old('registration_no') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                @hasanyrole('Super Admin|Pentadbir|Pembekal')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Sekolah <span class="text-red-500">*</span></label>
                    <select id="school_id" name="school_id" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schools as $s)
                            <option value="{{ $s->id }}" {{ old('school_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endhasanyrole

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sesi Persekolahan</label>
                    <input type="text" name="session_year" value="{{ old('session_year') }}" placeholder="Contoh: 2024/2025"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                    <select id="kafa_class_id" name="kafa_class_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ old('kafa_class_id') == $c->id ? 'selected' : '' }}>{{ $c->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Murid</label>
                    <select name="status"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="Tamat" {{ old('status') == 'Tamat' ? 'selected' : '' }}>Tamat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarikh Masuk</label>
                    <input type="date" name="entry_date" value="{{ old('entry_date') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SK / Sekolah Asal</label>
                    <input type="text" name="origin_school" value="{{ old('origin_school') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Angka Giliran UPKK</label>
                    <input type="text" name="upkk_number" value="{{ old('upkk_number') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="flex justify-between mt-5">
                <button type="button" @click="tab = 1"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Kembali
                </button>
                <button type="button" @click="tab = 3"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Seterusnya
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Tab 3: Ibu Bapa --}}
        <div x-show="tab === 3" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Maklumat Bapa / Penjaga 1</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Bapa</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. K/P Bapa</label>
                    <input type="text" name="father_ic" value="{{ old('father_ic') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Tel Bapa</label>
                    <input type="text" name="father_phone" value="{{ old('father_phone') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pekerjaan Bapa</label>
                    <input type="text" name="father_job" value="{{ old('father_job') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pendapatan (RM)</label>
                    <input type="number" step="0.01" name="father_income" value="{{ old('father_income') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700 mb-4">
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Maklumat Ibu / Penjaga 2</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ibu</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. K/P Ibu</label>
                    <input type="text" name="mother_ic" value="{{ old('mother_ic') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Tel Ibu</label>
                    <input type="text" name="mother_phone" value="{{ old('mother_phone') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pekerjaan Ibu</label>
                    <input type="text" name="mother_job" value="{{ old('mother_job') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pendapatan (RM)</label>
                    <input type="number" step="0.01" name="mother_income" value="{{ old('mother_income') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bilangan Tanggungan</label>
                    <input type="number" name="dependents_count" value="{{ old('dependents_count') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Hubungan</label>
                    <input type="text" name="parents_relationship_status" value="{{ old('parents_relationship_status') }}" placeholder="Contoh: Berkahwin, Duda, Ibu Tunggal"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-between mt-5">
                <button type="button" @click="tab = 2"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Kembali
                </button>
                <button type="button" @click="tab = 4"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Seterusnya
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Tab 4: Kesihatan --}}
        <div x-show="tab === 4" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Penyakit Kronik</label>
                    <textarea name="chronic_disease" rows="2" placeholder="Nyatakan jika ada"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('chronic_disease') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alahan</label>
                    <textarea name="allergies" rows="2" placeholder="Nyatakan jika ada"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('allergies') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kenalan Kecemasan</label>
                    <textarea name="emergency_contact" rows="2" placeholder="Nama & No. Telefon"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('emergency_contact') }}</textarea>
                </div>
            </div>
            <div class="flex justify-between mt-5">
                <button type="button" @click="tab = 3"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Kembali
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Rekod
                </button>
            </div>
        </div>

    </form>
</div>

<x-jawi-keyboard />

<script>
    // MyKid auto-calculate DOB and age
    const mykidInput = document.getElementById('mykid');
    const dobInput   = document.getElementById('dob');
    const ageInput   = document.getElementById('age');

    function calculateMyKidData() {
        if (!mykidInput) return;
        let mykid = mykidInput.value.replace(/[^0-9]/g, '');
        if (mykid.length >= 6) {
            let yearStr = mykid.substring(0, 2);
            let month   = mykid.substring(2, 4);
            let day     = mykid.substring(4, 6);
            let year    = (parseInt(yearStr) > 50) ? 1900 + parseInt(yearStr) : 2000 + parseInt(yearStr);
            if (dobInput) dobInput.value = year + '-' + month + '-' + day;
            let today = new Date();
            let age = today.getFullYear() - year;
            if (ageInput) ageInput.value = age;
        } else {
            if (dobInput) dobInput.value = '';
            if (ageInput) ageInput.value = '';
        }
    }

    if (mykidInput) {
        mykidInput.addEventListener('input', calculateMyKidData);
        calculateMyKidData();
    }

    // AJAX fetch classes by school
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
                    data.forEach(item => {
                        classSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                });
        });
    }
</script>
@endsection
