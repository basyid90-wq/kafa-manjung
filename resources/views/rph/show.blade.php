@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <style>
        @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
        .jawi-text { font-family: 'Lateef', serif !important; font-size: 1.2em !important; direction: rtl; text-align: right; display: block; }
        .jawi-label { font-family: 'Lateef', serif; font-size: 1.05em; direction: rtl; text-align: right; display: block; }
    </style>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Butiran RPH</h1>
        <div class="flex items-center gap-2 flex-wrap">
            @if($rph->status == 'approved')
            <button type="button"
                    onclick="openPdfBlob(this, '{{ route('rph.pdf', $rph) }}')"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak / Papar PDF
            </button>
            @endif
            @if($rph->user_id == auth()->id() && $rph->status != 'approved')
            <a href="{{ route('rph.edit', $rph) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Kemas Kini
            </a>
            @endif
            <a href="{{ route('rph.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Status Banners --}}
    @if($rph->status == 'revision_needed' && $rph->review_comment)
    <div class="flex items-start gap-3 p-4 mb-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-r-xl text-sm text-yellow-800 dark:text-yellow-300">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div><strong>Perlukan Pembaikan</strong><p class="mt-1">{{ $rph->review_comment }}</p></div>
    </div>
    @elseif($rph->status == 'rejected' && $rph->review_comment)
    <div class="flex items-start gap-3 p-4 mb-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-r-xl text-sm text-red-800 dark:text-red-300">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div><strong>RPH Ditolak</strong><p class="mt-1">{{ $rph->review_comment }}</p></div>
    </div>
    @elseif($rph->status == 'approved')
    <div class="flex items-start gap-3 p-4 mb-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-r-xl text-sm text-green-800 dark:text-green-300">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div><strong>RPH Telah Diluluskan</strong>@if($rph->reviewer)<p class="mt-1">Oleh: {{ $rph->reviewer->name }}</p>@endif</div>
    </div>
    @endif

    {{-- A. Maklumat Am --}}
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">A. Maklumat Am</div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3">
            <p class="text-xs text-gray-400 mb-0.5">Tarikh</p>
            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3">
            <p class="text-xs text-gray-400 mb-0.5">Hari</p>
            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $rph->hari ?? '—' }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3">
            <p class="text-xs text-gray-400 mb-0.5">Minggu</p>
            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $rph->week }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3">
            <p class="text-xs text-gray-400 mb-0.5">Guru</p>
            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $rph->user->name ?? '—' }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3">
            <p class="text-xs text-gray-400 mb-0.5">Status</p>
            @php
                $statusColor = match($rph->status) {
                    'pending'          => 'yellow',
                    'approved'         => 'green',
                    'rejected'         => 'red',
                    'revision_needed'  => 'blue',
                    default            => 'gray',
                };
                $statusLabel = match($rph->status) {
                    'pending'          => 'Menunggu Semakan',
                    'approved'         => 'Diluluskan',
                    'rejected'         => 'Ditolak',
                    'revision_needed'  => 'Perlu Pembaikan',
                    default            => ucfirst($rph->status),
                };
            @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700
                dark:bg-{{ $statusColor }}-900/30 dark:text-{{ $statusColor }}-400">
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    {{-- B. Kandungan Pengajaran --}}
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">B. Kandungan Pengajaran</div>

    @forelse($rph->periods as $period)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-4">
        <p class="text-xs font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400 mb-4">Waktu {{ $period->period_no }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                <p class="text-xs text-gray-400 mb-0.5">Kelas</p>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $period->kafaClass->display_name ?? '—' }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                <p class="text-xs text-gray-400 mb-0.5">Masa</p>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $period->masa ?? '—' }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                <p class="text-xs text-gray-400 mb-0.5">Mata Pelajaran</p>
                <p class="jawi-text text-gray-900 dark:text-white text-sm">{{ $period->mata_pelajaran_jawi ?? '—' }}</p>
            </div>
        </div>

        @php
            $fields = [
                ['تاجوق ڤلاجرن',       $period->topic_jawi],
                ['كماهيرن',             $period->kemahiran_jawi],
                ['ايسي ڤلاجرن',         $period->isi_pelajaran_jawi],
                ['اوبجيكتيف ڤمبلاجرن',  $period->objective_jawi],
                ['اكتيۏيتي ڤ&ڤ',        $period->aktiviti_jawi],
                ['ايمڤک ڤمبلاجرن',      $period->reflection_jawi],
            ];
        @endphp
        <div class="space-y-3">
            @foreach($fields as [$label, $value])
            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-3 border border-gray-100 dark:border-gray-700">
                <p class="jawi-label text-blue-600 dark:text-blue-400 mb-1">{!! $label !!}</p>
                <p class="jawi-text text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $value ?: '—' }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <p class="text-gray-400 text-sm mt-4">Tiada data waktu pengajaran.</p>
    @endforelse

</div>
@endsection
