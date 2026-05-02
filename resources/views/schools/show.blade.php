@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Maklumat Sekolah</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('schools.edit', $school) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Sekolah
            </a>
            <a href="{{ route('schools.index') }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Profil Sekolah --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2">Profil Sekolah</h2>

            <div>
                <p class="text-xs text-gray-400 mb-0.5">Nama Sekolah</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $school->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Kod Sekolah / Kod KAFA</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $school->code }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Daerah</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $school->district->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Jenis Premis</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $school->jenis_premis ?? '—' }}</p>
            </div>
            @if($school->logo)
            <div>
                <p class="text-xs text-gray-400 mb-1">Logo</p>
                <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="h-16 rounded-lg border border-gray-200 dark:border-gray-700">
            </div>
            @endif
        </div>

        {{-- Maklumat Pengurusan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 space-y-3">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2">Maklumat Pengurusan</h2>

            <div>
                <p class="text-xs text-gray-400 mb-0.5">Nama Guru Besar / Penyelaras</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $school->nama_guru_besar ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">No. Telefon</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $school->no_telefon ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Alamat Penuh Sekolah</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white whitespace-pre-line">{{ $school->alamat ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
