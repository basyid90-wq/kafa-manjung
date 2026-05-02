@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Pengurusan Utama</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Pilih modul di bawah untuk meneruskan tugas anda.</p>
    </div>

    {{-- Developer --}}
    @hasanyrole('Super Admin|Pentadbir')
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">Developer</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
            <a href="{{ route('users.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-700 dark:group-hover:text-blue-400">Pengguna</span>
            </a>
            <a href="{{ route('roles.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-purple-700 dark:group-hover:text-purple-400">Peranan</span>
            </a>
        </div>
    </div>
    @endhasanyrole

    {{-- Pengurusan Pelajar --}}
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">Pengurusan Pelajar</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">

            @hasanyrole('Super Admin|Pentadbir')
            <a href="{{ route('students.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-indigo-700">Murid</span>
            </a>
            <a href="{{ route('kafa_classes.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-pink-400 hover:bg-pink-50 dark:hover:bg-pink-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-pink-700">Kelas</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru KAFA')
            <a href="{{ route('attendances.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-green-700">Kehadiran</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir')
            <a href="{{ route('exams.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-orange-700">Peperiksaan</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru KAFA')
            <a href="{{ route('exams.results.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-cyan-700">Kemasukan Markah</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru Besar|Ibu Bapa')
            <a href="{{ route('timetable.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-700">Jadual Waktu</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
            <a href="{{ route('activities.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-emerald-700">Aktiviti & Program</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru KAFA|Ibu Bapa')
            <a href="{{ route('disciplinary.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-red-700">Disiplin Murid</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru Besar')
            <a href="{{ route('reports.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-violet-700">Laporan & Analisis</span>
            </a>
            @endhasanyrole
        </div>
    </div>

    {{-- Pengurusan Guru & Sekolah --}}
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">Pengurusan Guru & Sekolah</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">

            @hasanyrole('Super Admin|Pentadbir|Guru Besar')
            <a href="{{ route('announcements.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-sky-400 hover:bg-sky-50 dark:hover:bg-sky-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-sky-100 dark:bg-sky-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-sky-700">Hebahan</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru KAFA')
            <a href="{{ route('rph.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-yellow-700">Rekod RPH</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Bendahari Sekolah')
            <a href="{{ route('financial.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-green-700">Akaun Sekolah</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru Besar')
            <a href="{{ route('book_orders.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-amber-700">Tempahan Buku</span>
            </a>
            @endhasanyrole

        </div>
    </div>

    {{-- Admin KAFA --}}
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">Admin KAFA</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">

            @hasanyrole('Super Admin|Pentadbir')
            <a href="{{ route('books.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-amber-700">Katalog Buku</span>
            </a>
            @endhasanyrole

            @hasanyrole('Super Admin|Pentadbir|Guru Besar')
            <a href="{{ route('rph_approvals.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 group-hover:text-red-700">Kelulusan RPH</span>
            </a>
            @endhasanyrole

        </div>
    </div>

</div>
@endsection
