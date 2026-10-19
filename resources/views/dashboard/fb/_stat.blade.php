{{-- Stat card. Params: $label, $value, $note (optional), $icon (svg path d), $tone (blue|teal|indigo|amber|highlight) --}}
@php
    $tones = [
        'blue'      => 'bg-blue-50 text-blue-600',
        'teal'      => 'bg-teal-50 text-teal-600',
        'indigo'    => 'bg-indigo-50 text-indigo-600',
        'amber'     => 'bg-amber-50 text-amber-600',
        'highlight' => 'bg-blue-600 text-white',
    ];
    $hl = ($tone ?? 'blue') === 'highlight';
@endphp
<div class="{{ $hl ? 'rounded-xl border border-blue-200 bg-blue-50/60 p-5' : 'ek-card' }}">
    <div class="flex items-center justify-between">
        <p class="text-sm font-medium {{ $hl ? 'text-blue-700' : 'text-gray-500' }}">{{ $label }}</p>
        <span class="ek-icon-tile {{ $tones[$tone ?? 'blue'] }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
        </span>
    </div>
    <p class="mt-2 text-3xl font-bold {{ $hl ? 'text-blue-700' : 'text-gray-900' }}">{{ $value }}</p>
    @if(!empty($note))
    <p class="mt-1 text-xs {{ $hl ? 'text-gray-600' : 'text-gray-500' }}">{{ $note }}</p>
    @endif
</div>
