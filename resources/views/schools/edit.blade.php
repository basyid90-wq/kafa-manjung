@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Sekolah</h1>
        <a href="{{ route('schools.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('schools.update', $school) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Lajur Kiri: Profil Sekolah --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2">Profil Sekolah</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Sekolah <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $school->name) }}" placeholder="Contoh: KAFA Al-Hidayah" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kod Sekolah / Kod KAFA <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $school->code) }}" placeholder="Cth: AYQ1007" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                @role('Penyelia KAFA')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Daerah</label>
                    <input type="text" value="{{ auth()->user()->district->name }}" disabled
                           class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                    <input type="hidden" name="district_id" value="{{ auth()->user()->district_id }}">
                </div>
                @else
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Daerah <span class="text-red-500">*</span></label>
                    <select name="district_id" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Daerah --</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ old('district_id', $school->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Premis</label>
                    <select name="jenis_premis"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">Sila Pilih</option>
                        @foreach(['Sekolah Rendah Agama Rakyat (SRAR)','Menumpang Sekolah Kebangsaan (SK)','Menyewa','Wakaf','Surau','Masjid','Balai Raya / Dewan Orang Ramai','Bangunan Sendiri'] as $opt)
                        <option value="{{ $opt }}" {{ old('jenis_premis', $school->jenis_premis) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="logo_edit">Logo Sekolah</label>
                    @if($school->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="h-16 rounded-lg border border-gray-200 dark:border-gray-700">
                    </div>
                    @endif
                    <input type="file" name="logo" id="logo_edit" accept="image/*"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                           aria-describedby="logo_edit_help">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="logo_edit_help">JPG, PNG atau GIF (MAX. 2MB). Kosongkan jika tiada perubahan.</p>
                </div>
            </div>

            {{-- Lajur Kanan: Maklumat Pengurusan --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2">Maklumat Pengurusan</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Guru Besar / Penyelaras</label>
                    <input type="text" name="nama_guru_besar" value="{{ old('nama_guru_besar', $school->nama_guru_besar) }}" placeholder="Nama penuh"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telefon</label>
                    <input type="text" name="no_telefon" value="{{ old('no_telefon', $school->no_telefon) }}" placeholder="Cth: 012-3456789"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Penuh Sekolah</label>
                    <textarea name="alamat" rows="4"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('alamat', $school->alamat) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Masa Tamat Kehadiran
                        <span class="text-xs text-gray-400 font-normal">(Selepas masa ini = Lewat)</span>
                    </label>
                    <input type="time" name="attendance_cutoff_time"
                           value="{{ old('attendance_cutoff_time', $school->attendance_cutoff_time ? substr($school->attendance_cutoff_time, 0, 5) : '') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tiada had masa. Contoh: 08:30</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('schools.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Kemaskini Sekolah
            </button>
        </div>
    </form>
</div>
@endsection
