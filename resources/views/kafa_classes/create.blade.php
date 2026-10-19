@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Tambah Kelas Baru</h1>
        <a href="{{ route('kafa_classes.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form action="{{ route('kafa_classes.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                @hasanyrole('Super Admin')
                <div>
                    <label class="ek-label">Pilih Sekolah <span class="text-red-500">*</span></label>
                    <select name="school_id" id="school_id" required
                            class="ek-input">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <input type="hidden" name="school_id" value="{{ auth()->user()->school_id }}">
                @endhasanyrole

                <div>
                    <label class="ek-label">Tahun <span class="text-red-500">*</span></label>
                    <select name="tahun" id="tahun" required
                            class="ek-input">
                        <option value="">-- Pilih Tahun --</option>
                        @for($t = 1; $t <= 6; $t++)
                        <option value="{{ $t }}" {{ old('tahun') == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="ek-label">Nama Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: ABU BAKAR AS SIDDIQ" required
                           class="ek-input">
                    <p class="text-xs text-gray-400 mt-1">Nama kelas tanpa nombor tahun, sama seperti dalam SIMPENI.</p>
                </div>

                <div>
                    <label class="ek-label">Guru Kelas <span class="text-gray-400 font-normal">(Pilihan)</span></label>
                    <select name="teacher_id" id="teacher_id"
                            class="ek-input">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Simpan Rekod
                </button>
                <a href="{{ route('kafa_classes.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const schoolSelect  = document.getElementById('school_id');
    const teacherSelect = document.getElementById('teacher_id');

    if (schoolSelect) {
        schoolSelect.addEventListener('change', function () {
            const schoolId = this.value;
            teacherSelect.innerHTML = '<option value="">-- Memuatkan... --</option>';
            if (!schoolId) {
                teacherSelect.innerHTML = '<option value="">-- Pilih Sekolah Terlebih Dahulu --</option>';
                return;
            }
            fetch("{{ url('get-teachers') }}/" + schoolId)
                .then(r => { if (!r.ok) throw new Error(); return r.json(); })
                .then(data => {
                    teacherSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';
                    if (!data.length) {
                        teacherSelect.innerHTML += '<option value="" disabled>Tiada Guru Berdaftar di Sekolah Ini</option>';
                    } else {
                        data.forEach(t => {
                            const o = document.createElement('option');
                            o.value = t.id; o.text = t.name;
                            teacherSelect.add(o);
                        });
                    }
                })
                .catch(() => { teacherSelect.innerHTML = '<option value="">-- Ralat memuatkan data --</option>'; });
        });
    }
});
</script>
@endsection
