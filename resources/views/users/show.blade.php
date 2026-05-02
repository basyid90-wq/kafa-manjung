@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Maklumat Pengguna</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('users.edit', $user) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Pengguna
            </a>
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        {{-- Maklumat Peribadi --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Maklumat Peribadi</h2>
            <div class="space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="text-gray-400 w-32 shrink-0">Nama Penuh</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-gray-400 w-32 shrink-0">Alamat Emel</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $user->email }}</span>
                </div>
                <div class="flex gap-2 items-start">
                    <span class="text-gray-400 w-32 shrink-0">Peranan</span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($user->roles as $role)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Maklumat Penugasan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Maklumat Penugasan</h2>
            <div class="space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="text-gray-400 w-32 shrink-0">Daerah</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $user->district->name ?? 'Tiada' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-gray-400 w-32 shrink-0">Sekolah / KAFA</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $user->school->name ?? 'Tiada' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="text-gray-400 w-32 shrink-0">Tarikh Daftar</span>
                    <span class="text-gray-700 dark:text-gray-300">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
