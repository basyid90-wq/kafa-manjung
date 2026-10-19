@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Edit Sekolah</h1>
        <a href="{{ route('schools.index') }}"
           class="ek-btn-secondary">
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
            <div class="ek-card space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Profil Sekolah</h2>

                <div>
                    <label class="ek-label">Nama Sekolah <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $school->name) }}" placeholder="Contoh: KAFA Al-Hidayah" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Kod Sekolah / Kod KAFA <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $school->code) }}" placeholder="Cth: AYQ1007" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Jenis Premis</label>
                    <select name="jenis_premis"
                            class="ek-input">
                        <option value="">Sila Pilih</option>
                        @foreach(['Sekolah Rendah Agama Rakyat (SRAR)','Menumpang Sekolah Kebangsaan (SK)','Menyewa','Wakaf','Surau','Masjid','Balai Raya / Dewan Orang Ramai','Bangunan Sendiri'] as $opt)
                        <option value="{{ $opt }}" {{ old('jenis_premis', $school->jenis_premis) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="ek-label" for="logo_edit">Logo Sekolah</label>
                    @if($school->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="h-16 rounded-lg border border-gray-200">
                    </div>
                    @endif
                    <div style="display:flex;align-items:center;border:1px solid #d1d5db;border-radius:0.5rem;overflow:hidden;background:#f9fafb;cursor:pointer;" onclick="document.getElementById('logo_edit').click()">
                        <span style="padding:0.5rem 1rem;background:#f3f4f6;border-right:1px solid #d1d5db;font-size:0.875rem;font-weight:500;color:#374151;white-space:nowrap;flex-shrink:0;">Pilih Fail</span>
                        <span id="logo_edit-fname" style="padding:0.5rem 0.75rem;font-size:0.875rem;color:#6b7280;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Tiada fail dipilih</span>
                    </div>
                    <input type="file" name="logo" id="logo_edit" accept="image/*" style="display:none;" onchange="updateFilename(this,'logo_edit-fname')">
                    <p style="margin-top:4px;font-size:0.75rem;color:#6b7280;" id="logo_edit_help">JPG, PNG atau GIF (MAX. 2MB). Kosongkan jika tiada perubahan.</p>
                </div>
            </div>

            {{-- Lajur Kanan: Maklumat Pengurusan --}}
            <div class="ek-card space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-2">Maklumat Pengurusan</h2>

                <div>
                    <label class="ek-label">Nama Guru Besar / Penyelaras</label>
                    <input type="text" name="nama_guru_besar" value="{{ old('nama_guru_besar', $school->nama_guru_besar) }}" placeholder="Nama penuh"
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">No. Telefon</label>
                    <x-phone-input name="no_telefon" :value="old('no_telefon', $school->no_telefon)" />
                </div>

                <div>
                    <label class="ek-label">Alamat Penuh Sekolah</label>
                    <textarea name="alamat" rows="4"
                              class="ek-input">{{ old('alamat', $school->alamat) }}</textarea>
                </div>

                <div>
                    <label class="ek-label">
                        Masa Tamat Kehadiran
                        <span class="text-xs text-gray-400 font-normal">(Selepas masa ini = Lewat)</span>
                    </label>
                    <input type="time" name="attendance_cutoff_time"
                           value="{{ old('attendance_cutoff_time', $school->attendance_cutoff_time ? substr($school->attendance_cutoff_time, 0, 5) : '') }}"
                           class="ek-input">
                    <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tiada had masa. Contoh: 08:30</p>
                </div>
            </div>
        </div>

        @role('Super Admin')
        {{-- ── Langganan (Super Admin sahaja) ── --}}
        <div class="ek-card mt-5">
            <h2 class="text-sm font-bold text-gray-700 border-b border-gray-100 pb-2 mb-4">Langganan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="ek-label">Jenis Akaun</label>
                    <select name="type"
                            class="ek-input">
                        @foreach(config('plans.types') as $key => $type)
                        <option value="{{ $key }}" {{ old('type', $school->type) === $key ? 'selected' : '' }}>{{ $type['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="ek-label">Pakej</label>
                    <select name="plan"
                            class="ek-input">
                        @foreach(config('plans.plans') as $key => $plan)
                        <option value="{{ $key }}" {{ old('plan', $school->plan) === $key ? 'selected' : '' }}>{{ $plan['label'] }}</option>
                        @endforeach
                    </select>
                    @error('plan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="ek-label">Tarikh Tamat Pakej</label>
                    <input type="date" name="plan_expires_at"
                           value="{{ old('plan_expires_at', $school->plan_expires_at?->format('Y-m-d')) }}"
                           class="ek-input">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk pakej tanpa tarikh tamat. Diabaikan untuk pakej Percuma.</p>
                </div>
                <div>
                    <label class="ek-label">Pemilik Akaun</label>
                    <select name="owner_id"
                            class="ek-input">
                        <option value="">— Tiada —</option>
                        @foreach($school->users()->role('Guru Besar')->orderBy('name')->get() as $owner)
                        <option value="{{ $owner->id }}" {{ (int) old('owner_id', $school->owner_id) === $owner->id ? 'selected' : '' }}>{{ $owner->name }} ({{ $owner->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endrole

        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('schools.index') }}"
               class="ek-btn-secondary">
                Batal
            </a>
            <button type="submit"
                    class="ek-btn-primary">
                Kemaskini Sekolah
            </button>
        </div>
    </form>
</div>
@endsection
