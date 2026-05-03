@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Rekod Kesalahan Disiplin</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Daftarkan kesalahan disiplin murid baharu.</p>
        </div>
        <a href="{{ route('disciplinary.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 max-w-2xl">
        <form action="{{ route('disciplinary.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Pilih Murid <span class="text-red-500">*</span>
                </label>
                <select name="student_id" id="student_id" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('student_id') border-red-500 @enderror">
                    <option value="">-- Pilih Murid --</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }} ({{ $student->mykid }})
                    </option>
                    @endforeach
                </select>
                @error('student_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Tarikh Kejadian <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date" id="date"
                       value="{{ old('date', date('Y-m-d')) }}"
                       required
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date') border-red-500 @enderror">
                @error('date')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="offense_details" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Butiran Kesalahan <span class="text-red-500">*</span>
                </label>
                <textarea name="offense_details" id="offense_details" rows="5"
                          placeholder="Terangkan kesalahan murid secara terperinci..."
                          required
                          class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('offense_details') border-red-500 @enderror">{{ old('offense_details') }}</textarea>
                @error('offense_details')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="action_taken" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Tindakan Diambil <span class="text-red-500">*</span>
                </label>
                <input type="text" name="action_taken" id="action_taken"
                       value="{{ old('action_taken') }}"
                       placeholder="Contoh: Amaran Pertama, Sesi Kaunseling..."
                       required
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('action_taken') border-red-500 @enderror">
                @error('action_taken')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Rekod
                </button>
                <a href="{{ route('disciplinary.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
