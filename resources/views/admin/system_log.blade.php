@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Log Sistem</h1>
            <p class="ek-page-sub mt-1">Rekod ralat dan aktiviti sistem terkini.</p>
        </div>
        <a href="{{ route('dashboard') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex items-center gap-2 mb-5">
        <select name="level"
                class="ek-input">
            <option value="error"   {{ $filterLevel === 'error'   ? 'selected' : '' }}>Error sahaja</option>
            <option value="warning" {{ $filterLevel === 'warning' ? 'selected' : '' }}>Warning sahaja</option>
            <option value="info"    {{ $filterLevel === 'info'    ? 'selected' : '' }}>Info sahaja</option>
            <option value="all"     {{ $filterLevel === 'all'     ? 'selected' : '' }}>Semua paras</option>
        </select>
        <button type="submit"
                class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Tapis
        </button>
    </form>

    @if(empty($entries))
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-800">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Tiada entri log untuk paras yang dipilih. Sistem berjalan lancar.
        </div>
    @else
    <p class="text-xs text-gray-400 mb-4">Menunjukkan {{ count($entries) }} entri terkini (50 maksimum)</p>

    <div class="space-y-3">
        @foreach($entries as $entry)
        @php
            $levelColor = match($entry['level']) {
                'error', 'critical', 'emergency', 'alert' => 'red',
                'warning' => 'yellow',
                'notice', 'info' => 'blue',
                default => 'gray',
            };
        @endphp
        <div class="ek-card"
             style="border-left: 4px solid;">
            <div class="flex items-start justify-between gap-3 mb-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    bg-{{ $levelColor }}-100 text-{{ $levelColor }}-700
">
                    {{ strtoupper($entry['level']) }}
                </span>
                <span class="text-xs text-gray-400 shrink-0">{{ $entry['datetime'] }}</span>
            </div>
            <p class="text-xs font-mono text-gray-700 break-all">{{ $entry['message'] }}</p>
            @if(!empty(trim($entry['trace'])))
            <details class="mt-2">
                <summary class="text-xs text-gray-400 cursor-pointer hover:text-gray-600">Lihat Stack Trace</summary>
                <pre class="mt-2 text-xs font-mono bg-gray-50 rounded-lg p-3 max-h-40 overflow-y-auto text-gray-600">{{ trim($entry['trace']) }}</pre>
            </details>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
