@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Profil Murid</h1>
        <div class="flex items-center gap-2">
            @role('Guru Besar')
            <a href="{{ route('student_transfers.create', ['student_id' => $student->id, 'page' => request()->page]) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg hover:bg-orange-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Mohon Pindah
            </a>
            @endrole
            <a href="{{ route('students.edit', [$student, 'page' => request()->page]) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Kemaskini
            </a>
            <a href="{{ route('students.index', ['page' => request()->page]) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Profile Header Card --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-100 dark:border-blue-800 p-5 mb-5">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="relative shrink-0">
                <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('assets/images/team/team-01.jpg') }}"
                     alt="{{ $student->name }}"
                     class="w-28 h-28 rounded-full border-4 border-white dark:border-gray-700 shadow-md object-cover">
                <span class="absolute bottom-0 right-0 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                    {{ $student->status == 'Aktif' ? 'bg-green-500' : 'bg-gray-400' }} text-white">
                    {{ $student->status ?? 'Aktif' }}
                </span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $student->name }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">MyKid: {{ $student->mykid }}</p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 shadow-sm">
                        {{ $student->gender == 'L' ? 'Lelaki' : 'Perempuan' }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 shadow-sm">
                        {{ $student->standard_age }} Tahun
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 shadow-sm">
                        {{ $student->kafaClass->display_name ?? 'Tiada Kelas' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- 1. Maklumat Peribadi --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">1. Maklumat Peribadi</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div class="flex gap-2">
                    <span class="text-gray-400 w-36 shrink-0">Tarikh Lahir</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d/m/Y') : '—' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-gray-400 w-36 shrink-0">Tempat Lahir</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $student->birth_place ?? '—' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-gray-400 w-36 shrink-0">Bangsa</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $student->race ?? '—' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-gray-400 w-36 shrink-0">Warganegara</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $student->citizenship ?? '—' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-gray-400 w-36 shrink-0">Status OKU</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $student->oku_status ?? 'Tiada' }}</span>
                </div>
                <div class="flex gap-2 sm:col-span-2">
                    <span class="text-gray-400 w-36 shrink-0">Alamat</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $student->address ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- 2. Akademik --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">2. Akademik (KAFA)</h3>
            <div class="space-y-2 text-sm">
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">No. Pendaftaran</span><span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->registration_no ?? '—' }}</span></div>
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">Sesi</span><span class="text-gray-700 dark:text-gray-300">{{ $student->session_year ?? '—' }}</span></div>
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">Tarikh Masuk</span><span class="text-gray-700 dark:text-gray-300">{{ $student->entry_date ?? '—' }}</span></div>
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">Sekolah Asal</span><span class="text-gray-700 dark:text-gray-300">{{ $student->origin_school ?? '—' }}</span></div>
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">No. UPKK</span><span class="text-gray-700 dark:text-gray-300">{{ $student->upkk_number ?? '—' }}</span></div>
            </div>
        </div>

        {{-- 3. Kesihatan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border-l-4 border-red-400 border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="text-sm font-bold text-red-600 dark:text-red-400 border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">3. Maklumat Kesihatan</h3>
            <div class="space-y-2 text-sm">
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">Penyakit Kronik</span><span class="text-gray-700 dark:text-gray-300">{{ $student->chronic_disease ?? 'Tiada' }}</span></div>
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">Alahan</span><span class="text-gray-700 dark:text-gray-300">{{ $student->allergies ?? 'Tiada' }}</span></div>
                <div class="flex gap-2"><span class="text-gray-400 w-36 shrink-0">Kecemasan</span><span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->emergency_contact ?? '—' }}</span></div>
            </div>
        </div>

        {{-- 4. Ibu Bapa --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">4. Maklumat Ibu Bapa / Penjaga</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Bapa --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wide mb-3">Bapa / Penjaga 1</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">Nama</span><span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->father_name ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">No. IC</span><span class="text-gray-700 dark:text-gray-300">{{ $student->father_ic ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">No. Tel</span><span class="text-gray-700 dark:text-gray-300">{{ $student->father_phone ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">Pekerjaan</span><span class="text-gray-700 dark:text-gray-300">{{ $student->father_job ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">Pendapatan</span><span class="text-gray-700 dark:text-gray-300">RM {{ number_format($student->father_income ?? 0, 2) }}</span></div>
                    </div>
                </div>
                {{-- Ibu --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wide mb-3">Ibu / Penjaga 2</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">Nama</span><span class="font-medium text-gray-700 dark:text-gray-300">{{ $student->mother_name ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">No. IC</span><span class="text-gray-700 dark:text-gray-300">{{ $student->mother_ic ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">No. Tel</span><span class="text-gray-700 dark:text-gray-300">{{ $student->mother_phone ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">Pekerjaan</span><span class="text-gray-700 dark:text-gray-300">{{ $student->mother_job ?? '—' }}</span></div>
                        <div class="flex gap-2"><span class="text-gray-400 w-28 shrink-0">Pendapatan</span><span class="text-gray-700 dark:text-gray-300">RM {{ number_format($student->mother_income ?? 0, 2) }}</span></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex flex-wrap gap-6 text-sm">
                <div><span class="text-gray-400">Tanggungan:</span> <strong class="text-gray-700 dark:text-gray-300">{{ $student->dependents_count ?? 0 }} Orang</strong></div>
                <div><span class="text-gray-400">Status Hubungan:</span> <strong class="text-gray-700 dark:text-gray-300">{{ $student->parents_relationship_status ?? '—' }}</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection
