{{-- ── Guru KAFA Dashboard ── --}}
@php
    $today = $data['today'] ?? null;
    $icons = [
        'users'  => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z',
        'check'  => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        'school' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z',
        'bell'   => 'M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0',
        'doc'    => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
        'clip'   => 'M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75',
    ];
@endphp

<div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
    @include('dashboard.fb._stat', ['label' => 'Murid Saya', 'value' => $data['stats']['students_supervised'], 'icon' => $icons['users'], 'tone' => 'blue',
        'note' => ($data['gender']['l'] ?? 0).' lelaki · '.($data['gender']['p'] ?? 0).' perempuan'])
    @include('dashboard.fb._stat', ['label' => 'Kehadiran Hari Ini', 'icon' => $icons['check'], 'tone' => 'highlight',
        'value' => is_null($today['pct'] ?? null) ? '—' : $today['pct'].'%',
        'note'  => !empty($today['recorded']) ? $today['present'].' / '.$today['recorded'].' hadir · '.$today['absent'].' tidak hadir' : 'Belum direkod hari ini'])
    @include('dashboard.fb._stat', ['label' => 'Kelas Diajar', 'value' => $data['stats']['classes_taught'], 'icon' => $icons['school'], 'tone' => 'teal', 'note' => 'Kelas yang anda ajar'])
    @include('dashboard.fb._stat', ['label' => 'Hebahan', 'value' => $data['stats']['announcements_count'], 'icon' => $icons['bell'], 'tone' => 'amber', 'note' => 'Hebahan sekolah & sistem'])
</div>

{{-- Today's teaching schedule --}}
<div class="ek-table-wrap mt-6">
    <div class="border-b border-gray-200 px-5 py-4">
        <h2 class="ek-card-title">Jadual Pengajaran Hari Ini</h2>
        <p class="ek-card-sub">{{ now()->locale('ms')->isoFormat('dddd, D MMMM YYYY') }}</p>
    </div>
    <div class="overflow-x-auto">
        <table class="ek-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Masa</th>
                    <th>Kelas</th>
                    <th>Subjek</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['today_schedule'] as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($t->timeSlot->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($t->timeSlot->end_time)->format('h:i A') }}</td>
                    <td>{{ $t->kafaClass->display_name }}</td>
                    <td>{{ $t->subject->name }}</td>
                    <td>
                        <a href="{{ route('rph.create', ['class_id' => $t->kafa_class_id]) }}" class="ek-btn-icon text-blue-600 hover:bg-blue-50" title="Bina RPH">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-gray-400">Tiada jadual pengajaran untuk hari ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('dashboard.fb._insights', ['quickActions' => [
    ['module' => 'kehadiran',   'label' => 'Tanda Kehadiran', 'url' => route('attendances.index'),   'icon' => $icons['check']],
    ['module' => 'peperiksaan', 'label' => 'Isi Markah',      'url' => route('exams.results.index'), 'icon' => $icons['clip']],
    ['module' => 'rph',         'label' => 'Tulis RPH',       'url' => route('rph.create'),          'icon' => $icons['doc']],
    ['module' => 'murid',       'label' => 'Senarai Murid',   'url' => route('students.index'),      'icon' => $icons['users']],
]])
