{{-- ── Super Admin Dashboard ── --}}
@php
$icons = [
    'school' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z',
    'users'  => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z',
    'student'=> 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342',
    'new'    => 'M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z',
];
$ok  = 'ek-badge ek-badge-green';
$bad = 'ek-badge ek-badge-red';
@endphp

<div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
    @include('dashboard.fb._stat', ['label' => 'Jumlah Sekolah',  'value' => number_format($data['stats']['schools']),      'icon' => $icons['school'],  'tone' => 'blue',   'note' => 'Semua ruang kerja'])
    @include('dashboard.fb._stat', ['label' => 'Jumlah Pengguna', 'value' => number_format($data['stats']['total_users']),  'icon' => $icons['users'],   'tone' => 'indigo', 'note' => 'Semua peranan'])
    @include('dashboard.fb._stat', ['label' => 'Jumlah Murid',    'value' => number_format($data['stats']['students']),     'icon' => $icons['student'], 'tone' => 'teal',   'note' => 'Semua sekolah'])
    @include('dashboard.fb._stat', ['label' => 'Pengguna Baharu', 'value' => number_format($data['stats']['new_users_yr']), 'icon' => $icons['new'],     'tone' => 'amber',  'note' => 'Tahun '.now()->year])
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-5">

    {{-- Recent feedback --}}
    <div class="ek-card xl:col-span-3">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="ek-card-title">Aduan Masalah Terkini</h2>
            <a href="{{ route('feedback.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Lihat semua</a>
        </div>
        <div class="mb-4 flex flex-wrap gap-2">
            <span class="ek-badge ek-badge-red">{{ $data['feedback_counts']['baru'] }} Baru</span>
            <span class="ek-badge ek-badge-yellow">{{ $data['feedback_counts']['dalam_semakan'] }} Dalam Semakan</span>
            <span class="ek-badge ek-badge-green">{{ $data['feedback_counts']['selesai'] }} Selesai</span>
        </div>
        @if($data['recent_feedback']->isEmpty())
            <p class="text-sm text-gray-500"><span class="text-green-600">✓</span> Tiada aduan buat masa ini.</p>
        @else
        <ul class="divide-y divide-gray-100">
            @foreach($data['recent_feedback'] as $fb)
            <li class="flex items-start justify-between gap-3 py-3">
                <div class="min-w-0 flex-1">
                    <div class="mb-1 flex items-center gap-2">
                        <span class="inline-flex items-center rounded px-2 py-0.5 text-xs font-medium {{ $fb->status_class }}">{{ $fb->status_label }}</span>
                        <span class="ek-badge ek-badge-gray">{{ $fb->module }}</span>
                    </div>
                    <p class="truncate text-sm text-gray-700">{{ Str::limit($fb->description, 80) }}</p>
                    <p class="mt-0.5 text-xs text-gray-500">{{ $fb->user->name ?? '-' }} · {{ $fb->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('feedback.show', $fb->id) }}" class="ek-btn-icon text-blue-600 hover:bg-blue-50" title="Lihat">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    {{-- System health --}}
    <div class="ek-card xl:col-span-2">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="ek-card-title">Kesihatan Sistem</h2>
            <a href="{{ route('admin.system_log') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Log penuh</a>
        </div>
        <ul class="divide-y divide-gray-100">
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600">Pangkalan Data</span>
                <span class="{{ $data['db_ok'] ? $ok : $bad }}">{{ $data['db_ok'] ? 'Online' : 'Ralat' }}</span>
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600">Storan Fail</span>
                <span class="{{ $data['storage_ok'] ? $ok : $bad }}">{{ $data['storage_ok'] ? 'Boleh Tulis' : 'Tidak Boleh' }}</span>
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600">Ralat Terakhir</span>
                @if($data['last_error_time'])
                    <span class="font-mono text-xs text-red-600">{{ $data['last_error_time'] }}</span>
                @else
                    <span class="{{ $ok }}">Tiada Ralat</span>
                @endif
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600">PHP</span>
                <span class="ek-badge ek-badge-gray">{{ PHP_VERSION }}</span>
            </li>
            <li class="flex items-center justify-between py-2.5">
                <span class="text-sm text-gray-600">Laravel</span>
                <span class="ek-badge ek-badge-gray">{{ app()->version() }}</span>
            </li>
        </ul>
    </div>
</div>
