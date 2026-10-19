@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Tambah Mata Pelajaran Baharu</h1>
        <a href="{{ route('subjects.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="ek-label">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="name" placeholder="cth: Al-Quran" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Kod Subjek <span class="text-red-500">*</span></label>
                    <input type="text" name="code" placeholder="cth: ALQ" required
                           class="ek-input">
                </div>

                @role('Super Admin')
                <div>
                    <label class="ek-label">Sekolah <span class="text-gray-400 font-normal">(Kosongkan untuk Global)</span></label>
                    <select name="school_id"
                            class="ek-input">
                        <option value="">-- Subjek Global --</option>
                        @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <div>
                    <label class="ek-label">Slot Borang Pencapaian</label>
                    <select name="form_slot"
                            class="ek-input">
                        <option value="">-- Tiada --</option>
                        <option value="tilawah_tahfiz">Tilawah & Tahfiz Al-Quran</option>
                        <option value="lughati">Lughati (Lughatul Quran)</option>
                        <option value="ibadah">Ibadah</option>
                        <option value="akidah">Akidah</option>
                        <option value="sirah">Sirah & Tamadun Islam</option>
                        <option value="adab">Adab & Akhlak</option>
                        <option value="jawi_khat">Jawi & Khat</option>
                        <option value="bahasa_arab">Bahasa Arab</option>
                        <option value="amali_solat">Amali Solat</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Simpan Rekod
                </button>
                <a href="{{ route('subjects.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
