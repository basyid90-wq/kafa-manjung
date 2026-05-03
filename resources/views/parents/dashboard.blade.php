@extends('layout-fb.layout')

@section('content')
<style>
    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
</style>

<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Portal Ibu Bapa / Penjaga</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Berikut adalah maklumat anak-anak anda.
            </p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ $children->count() }} anak didaftarkan
        </span>
    </div>

    @if($children->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
        <div class="w-20 h-20 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tiada Rekod Anak Dijumpai</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto leading-relaxed">
            Sistem tidak dapat mengesan anak-anak yang dikaitkan dengan No. Kad Pengenalan anda
            (<strong>{{ auth()->user()->ic_number ?? '—' }}</strong>).
            Sila pastikan pihak sekolah telah mendaftarkan Nombor Kad Pengenalan anda dengan tepat dalam profil murid.
        </p>
        <div class="mt-5">
            <a href="{{ route('announcements.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Lihat Hebahan
            </a>
        </div>
    </div>

    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($children as $child)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex flex-col">

            {{-- Avatar --}}
            <div class="flex justify-center mb-4">
                @if($child->profile_picture)
                    <img src="{{ asset('storage/' . $child->profile_picture) }}" alt="{{ $child->name }}"
                         class="w-20 h-20 rounded-full object-cover border-2 border-gray-100 dark:border-gray-700">
                @else
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-800 to-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(mb_substr($child->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- Name --}}
            <div class="text-center mb-4">
                <h2 class="text-sm font-bold text-gray-900 dark:text-white leading-snug">{{ $child->name }}</h2>
                @if($child->jawi_name)
                <p class="text-gray-500 dark:text-gray-400 mt-1" dir="rtl" style="font-family:'Lateef',serif;font-size:1.05em;">
                    {{ $child->jawi_name }}
                </p>
                @endif
            </div>

            {{-- Info --}}
            <div class="space-y-2 text-xs text-gray-500 dark:text-gray-400 flex-grow mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>{{ $child->school->name ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>{{ $child->kafaClass->display_name ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <span class="font-mono">{{ $child->mykid }}</span>
                </div>
                <div>
                    @php $statusActive = ($child->status ?? 'Aktif') === 'Aktif'; @endphp
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $statusActive ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                        {{ $child->status ?? 'Aktif' }}
                    </span>
                </div>
            </div>

            {{-- Button --}}
            <div class="border-t border-gray-100 dark:border-gray-700 pt-4 mt-auto">
                <a href="{{ route('parent.student.show', $child) }}"
                   class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Lihat Profil Penuh
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
