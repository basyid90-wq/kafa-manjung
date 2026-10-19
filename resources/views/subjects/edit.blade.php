@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Kemaskini Mata Pelajaran</h1>
        <a href="{{ route('subjects.index', ['page' => request('page', 1)]) }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="page" value="{{ request('page', 1) }}">

            @php
            $formSlots = [
                'tilawah_tahfiz' => 'Tilawah & Tahfiz Al-Quran',
                'lughati'        => 'Lughati (Lughatul Quran)',
                'ibadah'         => 'Ibadah',
                'akidah'         => 'Akidah',
                'sirah'          => 'Sirah & Tamadun Islam',
                'adab'           => 'Adab & Akhlak',
                'jawi_khat'      => 'Jawi & Khat',
                'bahasa_arab'    => 'Bahasa Arab',
                'amali_solat'    => 'Amali Solat',
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="ek-label">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $subject->name }}" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Kod Subjek <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ $subject->code }}" required
                           class="ek-input">
                </div>

                @role('Super Admin')
                <div>
                    <label class="ek-label">Sekolah <span class="text-gray-400 font-normal">(Kosongkan untuk Global)</span></label>
                    <select name="school_id"
                            class="ek-input">
                        <option value="">-- Subjek Global --</option>
                        @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ $subject->school_id == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <div>
                    <label class="ek-label">Slot Borang Pencapaian</label>
                    <select name="form_slot"
                            class="ek-input">
                        <option value="">-- Tiada --</option>
                        @foreach($formSlots as $key => $label)
                        <option value="{{ $key }}" {{ $subject->form_slot === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Kemaskini Rekod
                </button>
                <a href="{{ route('subjects.index', ['page' => request('page', 1)]) }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
