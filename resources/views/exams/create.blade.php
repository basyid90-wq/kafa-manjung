@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="ek-page-title">Tambah Peperiksaan</h1>
            <p class="ek-page-sub mt-1">Daftarkan peperiksaan baharu dalam sistem.</p>
        </div>
        <a href="{{ route('exams.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card max-w-2xl">
        <form action="{{ route('exams.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="ek-label">
                    Nama Peperiksaan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       placeholder="Peperiksaan Pertengahan Tahun"
                       required
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="year" class="ek-label">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="year" name="year"
                           value="{{ old('year', date('Y')) }}"
                           min="2000" max="2099"
                           required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('year') border-red-500 @enderror">
                    @error('year')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="term" class="ek-label">
                        Penggal <span class="text-red-500">*</span>
                    </label>
                    <select id="term" name="term"
                            class="ek-input">
                        <option value="pertengahan_tahun" {{ old('term') === 'pertengahan_tahun' ? 'selected' : '' }}>Pertengahan Tahun</option>
                        <option value="akhir_tahun" {{ old('term') === 'akhir_tahun' ? 'selected' : '' }}>Akhir Tahun</option>
                        <option value="lain" {{ old('term') === 'lain' ? 'selected' : '' }}>Lain-lain</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="ek-btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Peperiksaan
                </button>
                <a href="{{ route('exams.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
