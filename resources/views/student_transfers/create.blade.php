@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="ek-page-title">Rekod Pindah Keluar Murid</h1>
            <p class="ek-page-sub mt-1">Rekodkan murid yang berpindah ke sekolah lain.</p>
        </div>
        <a href="{{ route('student_transfers.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card max-w-2xl">
        <form action="{{ route('student_transfers.store') }}" method="POST" class="space-y-5">
            @csrf

            @if($student)
                {{-- Mode 1: From Profile (Read-Only) --}}
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                <div>
                    <label class="ek-label">Nama Murid</label>
                    <div class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-semibold">
                        {{ $student->name }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="ek-label">Kelas Semasa</label>
                        <div class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-700">
                            {{ $student->kafaClass->display_name ?? 'Tiada Kelas' }}
                        </div>
                    </div>
                    <div>
                        <label class="ek-label">Sekolah Asal</label>
                        <div class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-700">
                            {{ $student->school->name }}
                        </div>
                    </div>
                </div>

            @else
                {{-- Mode 2: New Application (AJAX class → student) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="class_select" class="ek-label">
                            Pilih Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="class_select"
                                class="ek-input">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="student_select" class="ek-label">
                            Pilih Murid <span class="text-red-500">*</span>
                        </label>
                        <select name="student_id" id="student_select" disabled required
                                class="ek-input disabled:opacity-60 disabled:cursor-not-allowed">
                            <option value="">-- Pilih Kelas Dahulu --</option>
                        </select>
                    </div>
                </div>
            @endif

            <div>
                <label for="to_school_name" class="ek-label">
                    Sekolah Destinasi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="to_school_name" id="to_school_name" required maxlength="255"
                       value="{{ old('to_school_name') }}" placeholder="cth: KAFA Integrasi Sri Manjung"
                       class="ek-input">
                <p class="mt-1 text-xs text-gray-400">Rekod murid akan diarkibkan di sekolah ini. Sekolah baharu perlu mendaftar murid dalam akaun mereka sendiri.</p>
                @error('to_school_name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reason" class="ek-label">
                    Sebab Berpindah
                </label>
                <textarea name="reason" id="reason" rows="3"
                          placeholder="Sila nyatakan sebab murid berpindah..."
                          class="ek-input resize-none">{{ old('reason') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="ek-btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Rekod
                </button>
                <a href="{{ route('student_transfers.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@if(!$student)
<script>
(function() {
    var classSelect = document.getElementById('class_select');
    var studentSelect = document.getElementById('student_select');
    var getStudentsUrl = "{{ route('student_transfers.get_students', ':id') }}";

    function loadStudents(classId) {
        studentSelect.innerHTML = '<option value="">-- Memuatkan murid... --</option>';
        studentSelect.disabled = true;

        var url = getStudentsUrl.replace(':id', classId);

        fetch(url)
            .then(function(response) {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return response.json();
            })
            .then(function(data) {
                studentSelect.innerHTML = '';
                studentSelect.add(new Option(data && data.length > 0 ? '-- Pilih Murid --' : 'Tiada murid ditemui', ''));
                (data || []).forEach(function(student) {
                    studentSelect.add(new Option(student.name, student.id));
                });
                studentSelect.disabled = !(data && data.length > 0);
            })
            .catch(function(error) {
                studentSelect.innerHTML = '<option value="">Ralat memuatkan data</option>';
                alert('Gagal memuatkan senarai murid: ' + error.message);
            });
    }

    classSelect.addEventListener('change', function() {
        var classId = this.value;
        if (classId) {
            loadStudents(classId);
        } else {
            studentSelect.innerHTML = '<option value="">-- Pilih Kelas Dahulu --</option>';
            studentSelect.disabled = true;
        }
    });

    // Back-button fix: restore if class already selected
    if (classSelect.value) {
        loadStudents(classSelect.value);
    }
})();
</script>
@endif
@endsection
