@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Permohonan Pindah Murid</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Hantar permohonan pertukaran sekolah murid.</p>
        </div>
        <a href="{{ route('student_transfers.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 max-w-2xl">
        <form action="{{ route('student_transfers.store') }}" method="POST" class="space-y-5">
            @csrf

            @if($student)
                {{-- Mode 1: From Profile (Read-Only) --}}
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Murid</label>
                    <div class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white font-semibold">
                        {{ $student->name }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kelas Semasa</label>
                        <div class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                            {{ $student->kafaClass->display_name ?? 'Tiada Kelas' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Sekolah Asal</label>
                        <div class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                            {{ $student->school->name }}
                        </div>
                    </div>
                </div>

            @else
                {{-- Mode 2: New Application (AJAX class → student) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="class_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Pilih Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="class_select"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="student_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Pilih Murid <span class="text-red-500">*</span>
                        </label>
                        <select name="student_id" id="student_select" disabled required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:opacity-60 disabled:cursor-not-allowed">
                            <option value="">-- Pilih Kelas Dahulu --</option>
                        </select>
                    </div>
                </div>
            @endif

            <div>
                <label for="to_school_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Sekolah Destinasi <span class="text-red-500">*</span>
                </label>
                <select name="to_school_id" id="to_school_id" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('to_school_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($groupedSchools as $districtName => $schools)
                        <optgroup label="Daerah: {{ $districtName }}">
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('to_school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('to_school_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Sebab Berpindah
                </label>
                <textarea name="reason" id="reason" rows="3"
                          placeholder="Sila nyatakan sebab murid berpindah..."
                          class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('reason') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Hantar Permohonan
                </button>
                <a href="{{ route('student_transfers.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
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
                var html = '<option value="">-- Pilih Murid --</option>';
                if (data && data.length > 0) {
                    data.forEach(function(student) {
                        html += '<option value="' + student.id + '">' + student.name + '</option>';
                    });
                    studentSelect.disabled = false;
                } else {
                    html = '<option value="">Tiada murid ditemui</option>';
                }
                studentSelect.innerHTML = html;
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
