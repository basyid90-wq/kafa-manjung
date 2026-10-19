{{-- Attendance chart, announcements, subject averages and quick actions. Params: $data, $quickActions --}}
@php
    $user        = auth()->user();
    $examService = app(\App\Services\ExamService::class);
    $barColors   = ['#2563EB', '#0D9488', '#7C3AED', '#D97706', '#DB2777', '#0891B2', '#65A30D'];
@endphp

<div class="mt-6 grid gap-6 xl:grid-cols-3">
    {{-- Attendance, last 7 school days --}}
    <div class="ek-card xl:col-span-2">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="ek-card-title">Kehadiran 7 Hari Persekolahan Terakhir</h2>
                <p class="ek-card-sub">Peratus murid hadir (termasuk lewat)</p>
            </div>
            @if(!is_null($data['week7_avg'] ?? null))
            <span class="ek-badge ek-badge-gray">Purata {{ $data['week7_avg'] }}%</span>
            @endif
        </div>
        <div class="mt-6 flex items-end gap-2 sm:gap-4" style="height:210px">
            @foreach($data['week7'] ?? [] as $d)
            <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                <span class="text-xs font-semibold text-gray-700">{{ is_null($d['pct']) ? '—' : $d['pct'].'%' }}</span>
                <div class="flex w-full flex-1 items-end justify-center">
                    <div class="w-full rounded-t-lg {{ $d['isToday'] ? 'bg-blue-600' : 'bg-blue-200' }}"
                         style="max-width:52px;height:{{ is_null($d['pct']) ? 2 : max($d['pct'], 2) }}%;{{ is_null($d['pct']) ? 'background:#E5E7EB' : '' }}"
                         title="{{ $d['date'] }}"></div>
                </div>
                <span class="text-xs {{ $d['isToday'] ? 'font-semibold text-blue-700' : 'text-gray-500' }}">{{ $d['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Announcements --}}
    <div class="ek-card">
        <div class="flex items-center justify-between">
            <h2 class="ek-card-title">Hebahan Terkini</h2>
            <a href="{{ route('announcements.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Lihat semua</a>
        </div>
        @if(($data['announcements'] ?? collect())->isNotEmpty())
        <ul class="mt-4 space-y-3">
            @foreach($data['announcements'] as $a)
            <li class="rounded-lg border border-gray-100 p-3">
                <div class="flex items-center justify-between gap-2">
                    <p class="truncate text-sm font-semibold text-gray-900">{{ $a->title }}</p>
                    @if($a->category)
                    <span class="shrink-0 rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-600">{{ $a->category }}</span>
                    @endif
                </div>
                <p class="mt-1 line-clamp-2 text-xs text-gray-600">{{ \Illuminate\Support\Str::limit(strip_tags($a->content), 140) }}</p>
                <p class="mt-1.5 text-[11px] text-gray-500">{{ \Carbon\Carbon::parse($a->created_at)->locale('ms')->isoFormat('D MMM YYYY') }}</p>
            </li>
            @endforeach
        </ul>
        @else
        <div class="mt-4 flex flex-col items-center rounded-lg border border-dashed border-gray-300 p-6 text-center">
            <p class="text-sm font-semibold text-gray-900">Tiada hebahan</p>
            <p class="mt-1 text-xs text-gray-600">Hebahan sekolah akan dipaparkan di sini.</p>
            @if($user->canUse('hebahan') && $user->hasRole('Guru Besar'))
            <a href="{{ route('announcements.create') }}" class="mt-3 text-xs font-semibold text-blue-700 hover:text-blue-800">Cipta hebahan</a>
            @endif
        </div>
        @endif
    </div>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-3">
    {{-- Average marks per subject --}}
    <div class="ek-card xl:col-span-2">
        <div>
            <h2 class="ek-card-title">Purata Markah Ikut Subjek</h2>
            <p class="ek-card-sub">{{ $data['exam'] ? $data['exam']->name.' '.$data['exam']->year : 'Belum ada markah peperiksaan' }}</p>
        </div>
        @if(($data['subject_avg'] ?? collect())->isNotEmpty())
        <ul class="mt-5 space-y-3">
            @foreach($data['subject_avg'] as $j => $s)
            @php $g = $examService->calculateGrade($s->avg); @endphp
            <li class="flex items-center gap-3">
                <span class="w-28 shrink-0 truncate text-sm text-gray-700 sm:w-36">{{ $s->name }}</span>
                <span class="h-2.5 flex-1 rounded-full bg-gray-100"><span class="block h-2.5 rounded-full" style="width:{{ (int) $s->avg }}%;background:{{ $barColors[$j % count($barColors)] }}"></span></span>
                <span class="w-10 shrink-0 text-right text-sm font-semibold text-gray-900">{{ (int) $s->avg }}</span>
                <span class="ek-badge {{ $examService->badgeClass($g) }} w-7 justify-center px-0 text-[10px] font-bold">{{ $g }}</span>
            </li>
            @endforeach
        </ul>
        @else
        <p class="mt-5 text-sm text-gray-500">Purata akan dipaparkan selepas markah peperiksaan dimasukkan.</p>
        @endif
    </div>

    {{-- Quick actions --}}
    <div class="ek-card">
        <h2 class="ek-card-title">Tindakan Pantas</h2>
        <div class="mt-4 grid grid-cols-2 gap-3">
            @foreach($quickActions as $qa)
            @php $locked = !$user->canUse($qa['module']); @endphp
            <a href="{{ $locked ? route('subscription.index', ['modul' => $qa['module']]) : $qa['url'] }}"
               class="relative flex flex-col items-center gap-2 rounded-xl border border-gray-200 p-4 text-center transition-colors hover:border-blue-300 hover:bg-blue-50/50">
                <span class="ek-icon-tile h-10 w-10 bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $qa['icon'] }}"/></svg>
                </span>
                <span class="text-xs font-semibold text-gray-800">{{ $qa['label'] }}</span>
                @if($locked)
                <svg class="absolute right-2 top-2 h-3.5 w-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-label="Berkunci"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</div>
