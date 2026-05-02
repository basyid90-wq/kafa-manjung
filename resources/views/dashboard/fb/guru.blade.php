{{-- ── Guru KAFA Dashboard ── --}}
@php
$cards = [
    ['title'=>'Kelas Diajar',  'count'=>$data['stats']['classes_taught'],        'bg'=>'bg-blue-100 dark:bg-blue-900/30',  'color'=>'text-blue-600 dark:text-blue-400',  'icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
    ['title'=>'Jumlah Murid',  'count'=>$data['stats']['students_supervised'],   'bg'=>'bg-green-100 dark:bg-green-900/30', 'color'=>'text-green-600 dark:text-green-400', 'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
    ['title'=>'Hebahan Aktif', 'count'=>$data['stats']['announcements_count'],   'bg'=>'bg-yellow-100 dark:bg-yellow-900/30','color'=>'text-yellow-600 dark:text-yellow-400','icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    @foreach($cards as $card)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-center gap-4">
        <div class="p-3 {{ $card['bg'] }} rounded-lg shrink-0">
            <svg class="w-6 h-6 {{ $card['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $card['count'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card['title'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">
            Jadual Pengajaran Hari Ini — {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-5 py-3">Masa</th>
                    <th class="px-5 py-3">Kelas</th>
                    <th class="px-5 py-3">Subjek</th>
                    <th class="px-5 py-3">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($data['today_schedule'] as $t)
                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($t->timeSlot->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($t->timeSlot->end_time)->format('h:i A') }}
                    </td>
                    <td class="px-5 py-3">{{ $t->kafaClass->display_name }}</td>
                    <td class="px-5 py-3">{{ $t->subject->name }}</td>
                    <td class="px-5 py-3">
                        <a href="{{ route('rph.create', ['class_id' => $t->kafa_class_id]) }}" class="text-blue-600 hover:underline dark:text-blue-400">+ Bina RPH</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400">Tiada jadual pengajaran untuk hari ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
