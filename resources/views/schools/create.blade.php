@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Tambah Sekolah</h1>
        <a href="{{ route('schools.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Lajur Kiri: Profil Sekolah --}}
            <div class="ek-card space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Profil Sekolah</h2>

                <div>
                    <label class="ek-label">Nama Sekolah <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: KAFA Al-Hidayah" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Kod Sekolah / Kod KAFA <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Cth: AYQ1007" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Jenis Premis</label>
                    <select name="jenis_premis"
                            class="ek-input">
                        <option value="">Sila Pilih</option>
                        @foreach(['Sekolah Rendah Agama Rakyat (SRAR)','Menumpang Sekolah Kebangsaan (SK)','Menyewa','Wakaf','Surau','Masjid','Balai Raya / Dewan Orang Ramai','Bangunan Sendiri'] as $opt)
                        <option value="{{ $opt }}" {{ old('jenis_premis') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="ek-label" for="logo">Logo Sekolah</label>
                    <div style="display:flex;align-items:center;border:1px solid #d1d5db;border-radius:0.5rem;overflow:hidden;background:#f9fafb;cursor:pointer;" onclick="document.getElementById('logo').click()">
                        <span style="padding:0.5rem 1rem;background:#f3f4f6;border-right:1px solid #d1d5db;font-size:0.875rem;font-weight:500;color:#374151;white-space:nowrap;flex-shrink:0;">Pilih Fail</span>
                        <span id="logo-fname" style="padding:0.5rem 0.75rem;font-size:0.875rem;color:#6b7280;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Tiada fail dipilih</span>
                    </div>
                    <input type="file" name="logo" id="logo" accept="image/*" style="display:none;" onchange="updateFilename(this,'logo-fname')">
                    <p style="margin-top:4px;font-size:0.75rem;color:#6b7280;" id="logo_help">JPG, PNG atau GIF (MAX. 2MB).</p>
                </div>
            </div>

            {{-- Lajur Kanan: Maklumat Pengurusan --}}
            <div class="ek-card space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Maklumat Pengurusan</h2>

                <div>
                    <label class="ek-label">Nama Guru Besar / Penyelaras</label>
                    <input type="text" name="nama_guru_besar" value="{{ old('nama_guru_besar') }}" placeholder="Nama penuh"
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">No. Telefon</label>
                    <x-phone-input name="no_telefon" :value="old('no_telefon')" />
                </div>

                <div>
                    <label class="ek-label">Alamat Penuh Sekolah</label>
                    <textarea name="alamat" rows="4"
                              class="ek-input">{{ old('alamat') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('schools.index') }}"
               class="ek-btn-secondary">
                Batal
            </a>
            <button type="submit"
                    class="ek-btn-primary">
                Simpan Sekolah
            </button>
        </div>
    </form>
</div>
@endsection
