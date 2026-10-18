@extends('layout-fb.layout')

@section('title', 'Langganan')

@section('content')
@php
    $current  = $school->effectivePlan();
    $isOwner  = auth()->user()->hasRole('Guru Besar');
    $waNumber = '60194920559';
    $maxClass = $school->limit('max_classes');
    $perClass = $school->limit('max_students_per_class');
@endphp

<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Langganan</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Pakej semasa dan modul yang tersedia untuk {{ $school->name }}</p>
</div>

{{-- ── Pakej semasa ── --}}
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pakej Semasa</p>
            <div class="flex flex-wrap items-center gap-2 mt-1">
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $school->planLabel() }}</span>
                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ config("plans.types.{$school->type}.label") }}</span>
                @if($school->isPlanExpired())
                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Tamat — kembali ke Percuma</span>
                @endif
            </div>
            @if($school->plan !== 'free' && $school->plan_expires_at)
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ $school->isPlanExpired() ? 'Tamat pada' : 'Aktif hingga' }} {{ $school->plan_expires_at->format('d/m/Y') }}
            </p>
            @endif
        </div>
        <div class="flex gap-6">
            <div>
                <p class="text-xs text-gray-400">Kelas</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $usage['classes'] }}<span class="text-sm text-gray-400"> / {{ $maxClass ?? '∞' }}</span></p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Murid Aktif</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $usage['students'] }}</p>
                <p class="text-xs text-gray-400">maks. {{ $perClass ?? '∞' }} sekelas</p>
            </div>
        </div>
    </div>
    @if($maxClass)
    <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mt-4">
        <div class="h-2 rounded-full bg-blue-600" style="width: {{ min(100, round($usage['classes'] / $maxClass * 100)) }}%"></div>
    </div>
    @endif
</div>

{{-- ── Perbandingan pakej ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    @foreach($plans as $key => $plan)
    @php
        $isCurrent = $key === $current;
        $available = in_array($key, $typePlans, true);
        $isUpgrade = $available && $plan['rank'] > $plans[$current]['rank'];
        $waText    = rawurlencode('Salam, saya ingin naik taraf ' . $school->name . ' ke pakej ' . $plan['label'] . ' eKafa Online.');
    @endphp
    <div class="flex flex-col bg-white dark:bg-gray-800 rounded-xl p-5 {{ $isCurrent ? 'border-2 border-blue-600' : 'border border-gray-200 dark:border-gray-700' }} {{ $available ? '' : 'opacity-60' }}">
        <div class="flex items-center justify-between mb-1">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $plan['label'] }}</h3>
            @if($isCurrent)
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">Pakej Anda</span>
            @elseif(!$available)
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">{{ $key === 'personal' ? 'Untuk guru individu' : 'Untuk sekolah' }}</span>
            @endif
        </div>
        <p class="mb-2"><span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $plan['price'] ? 'RM' . $plan['price'] : 'RM0' }}</span><span class="text-sm text-gray-500 dark:text-gray-400"> / bulan</span></p>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            {{ $plan['max_classes'] ? 'Sehingga ' . $plan['max_classes'] . ' kelas' : 'Kelas tanpa had' }}
            · {{ $plan['max_students_per_class'] ? $plan['max_students_per_class'] . ' murid sekelas' : 'murid tanpa had' }}
        </p>

        <ul class="space-y-2 mb-5 text-sm">
            @foreach($modules as $mKey => $module)
            @php $included = $plan['rank'] >= $plans[$module['plan']]['rank']; @endphp
            <li class="flex items-center gap-2 {{ $included ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500 line-through' }} {{ $highlight === $mKey ? 'font-semibold' : '' }}">
                @if($included)
                <svg class="w-4 h-4 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                @else
                <svg class="w-4 h-4 shrink-0 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                @endif
                {{ $module['label'] }}
            </li>
            @endforeach
        </ul>

        <div class="mt-auto">
            @php
                $isRenewal = $isCurrent && $key !== 'free' && $available;
            @endphp
            @if(($isUpgrade || $isRenewal) && $isOwner)
                @if($billingReady)
                <form method="POST" action="{{ route('billing.checkout') }}">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $key }}">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        {{ $isRenewal ? 'Lanjutkan 1 Bulan' : 'Naik Taraf' }} — RM{{ $plan['price'] }}
                    </button>
                </form>
                <p class="text-xs text-gray-400 mt-2 text-center">Bayaran melalui FPX (Bayarcash). Pakej aktif serta-merta selepas bayaran berjaya.</p>
                @else
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" rel="noopener"
                   class="w-full inline-flex items-center justify-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Naik Taraf ke {{ $plan['label'] }}
                </a>
                <p class="text-xs text-gray-400 mt-2 text-center">Pembayaran dalam talian akan dibuka tidak lama lagi. Buat masa ini, hubungi kami untuk pengaktifan.</p>
                @endif
            @elseif($isUpgrade)
            <p class="text-xs text-gray-500 dark:text-gray-400 text-center">Hubungi Guru Besar anda untuk naik taraf pakej.</p>
            @endif
        </div>
    </div>
    @endforeach
</div>
{{-- ── Sejarah pembayaran ── --}}
@if($payments->total() > 0)
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mt-6">
    <div class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Sejarah Pembayaran</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left w-12">No</th>
                    <th class="px-5 py-3 text-left">Tarikh</th>
                    <th class="px-5 py-3 text-left">No. Pesanan</th>
                    <th class="px-5 py-3 text-left">Pakej</th>
                    <th class="px-5 py-3 text-left">Tempoh</th>
                    <th class="px-5 py-3 text-right">Jumlah</th>
                    <th class="px-5 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($payments as $p)
                @php $badge = ['paid' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400', 'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'][$p->status] ?? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'; @endphp
                <tr>
                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $payments->firstItem() + $loop->index }}</td>
                    <td class="px-5 py-3 text-gray-600 dark:text-gray-300">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-5 py-3 font-mono text-xs text-gray-600 dark:text-gray-300">{{ $p->order_number }}</td>
                    <td class="px-5 py-3 text-gray-900 dark:text-white">{{ config("plans.plans.{$p->plan}.label") }}</td>
                    <td class="px-5 py-3 text-gray-600 dark:text-gray-300">{{ $p->period_start ? $p->period_start->format('d/m/Y') . ' – ' . $p->period_end->format('d/m/Y') : '—' }}</td>
                    <td class="px-5 py-3 text-right text-gray-900 dark:text-white">RM{{ $p->amountString() }}</td>
                    <td class="px-5 py-3"><span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $badge }}">{{ $p->statusLabel() }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">{{ $payments->links() }}</div>
    @endif
</div>
@endif
@endsection
