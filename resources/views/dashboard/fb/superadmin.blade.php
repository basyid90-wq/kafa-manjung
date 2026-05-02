{{-- ── Super Admin Dashboard ── --}}
@php
$cards = [
    ['title'=>'Jumlah Sekolah',   'count'=>$data['stats']['schools'],      'icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'bg'=>'bg-blue-100 dark:bg-blue-900/30',   'color'=>'text-blue-600 dark:text-blue-400'],
    ['title'=>'Jumlah Pengguna',  'count'=>$data['stats']['total_users'],   'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'bg'=>'bg-purple-100 dark:bg-purple-900/30', 'color'=>'text-purple-600 dark:text-purple-400', 'note'=>'semua role'],
    ['title'=>'Jumlah Murid',     'count'=>$data['stats']['students'],      'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'bg'=>'bg-green-100 dark:bg-green-900/30',  'color'=>'text-green-600 dark:text-green-400'],
    ['title'=>'Pengguna Baharu',  'count'=>$data['stats']['new_users_yr'],  'icon'=>'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'bg'=>'bg-yellow-100 dark:bg-yellow-900/30', 'color'=>'text-yellow-600 dark:text-yellow-400', 'note'=>'tahun '.now()->year],
];
@endphp

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach($cards as $card)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-center gap-4">
        <div class="p-3 {{ $card['bg'] }} rounded-lg shrink-0">
            <svg class="w-6 h-6 {{ $card['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($card['count']) }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card['title'] }}</p>
            @isset($card['note'])<p class="text-xs text-gray-400">{{ $card['note'] }}</p>@endisset
        </div>
    </div>
    @endforeach
</div>

{{-- Aduan + Sistem --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

    {{-- Panel Aduan --}}
    <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Aduan Masalah Terkini</h2>
            <a href="{{ route('feedback.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">Lihat Semua →</a>
        </div>
        <div class="flex gap-2 mb-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ $data['feedback_counts']['baru'] }} Baru</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">{{ $data['feedback_counts']['dalam_semakan'] }} Dalam Semakan</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ $data['feedback_counts']['selesai'] }} Selesai</span>
        </div>
        @if($data['recent_feedback']->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400"><span class="text-green-500">✓</span> Tiada aduan buat masa ini.</p>
        @else
        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($data['recent_feedback'] as $fb)
            <li class="py-3 flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $fb->status_class }}">{{ $fb->status_label }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $fb->module }}</span>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ Str::limit($fb->description, 80) }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $fb->user->name ?? '-' }} · {{ $fb->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('feedback.show', $fb->id) }}" class="text-blue-500 hover:text-blue-700 shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    {{-- Panel Kesihatan Sistem --}}
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Kesihatan Sistem</h2>
            <a href="{{ route('admin.system_log') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">Log Penuh →</a>
        </div>
        <ul class="space-y-0 divide-y divide-gray-100 dark:divide-gray-700">
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600 dark:text-gray-300">Pangkalan Data</span>
                @if($data['db_ok'])
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Online</span>
                @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">Ralat</span>
                @endif
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600 dark:text-gray-300">Storan Fail</span>
                @if($data['storage_ok'])
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Boleh Tulis</span>
                @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">Tidak Boleh</span>
                @endif
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600 dark:text-gray-300">Ralat Terakhir</span>
                @if($data['last_error_time'])
                    <span class="text-xs text-red-500 font-mono">{{ $data['last_error_time'] }}</span>
                @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Tiada Ralat</span>
                @endif
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600 dark:text-gray-300">PHP</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ PHP_VERSION }}</span>
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600 dark:text-gray-300">Laravel</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ app()->version() }}</span>
            </li>
        </ul>
    </div>
</div>
