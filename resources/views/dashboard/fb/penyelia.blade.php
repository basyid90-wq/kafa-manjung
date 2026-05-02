{{-- ── Penyelia KAFA Dashboard ── --}}
@php
$cards = [
    ['title'=>'Sekolah',      'count'=>$data['stats']['schools'],    'bg'=>'bg-blue-100 dark:bg-blue-900/30',   'color'=>'text-blue-600 dark:text-blue-400',   'icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
    ['title'=>'Guru Besar',   'count'=>$data['stats']['guru_besar'], 'bg'=>'bg-purple-100 dark:bg-purple-900/30', 'color'=>'text-purple-600 dark:text-purple-400','icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    ['title'=>'Guru KAFA',    'count'=>$data['stats']['guru_kafa'],  'bg'=>'bg-pink-100 dark:bg-pink-900/30',    'color'=>'text-pink-600 dark:text-pink-400',   'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
    ['title'=>'Jumlah Kelas', 'count'=>$data['stats']['classes'],    'bg'=>'bg-yellow-100 dark:bg-yellow-900/30', 'color'=>'text-yellow-600 dark:text-yellow-400','icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
    ['title'=>'Jumlah Murid', 'count'=>$data['stats']['students'],   'bg'=>'bg-green-100 dark:bg-green-900/30',  'color'=>'text-green-600 dark:text-green-400', 'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
];
@endphp

<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    @foreach($cards as $card)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-center gap-3">
        <div class="p-2.5 {{ $card['bg'] }} rounded-lg shrink-0">
            <svg class="w-5 h-5 {{ $card['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($card['count']) }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $card['title'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">RPH Menunggu Kelulusan (Daerah)</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-5 py-3">No</th>
                    <th class="px-5 py-3">Guru / Sekolah</th>
                    <th class="px-5 py-3">Tarikh</th>
                    <th class="px-5 py-3">Topik</th>
                    <th class="px-5 py-3">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($data['pending_rphs'] as $rph)
                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <td class="px-5 py-3 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $rph->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $rph->school->name }}</p>
                    </td>
                    <td class="px-5 py-3">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</td>
                    <td class="px-5 py-3">{{ Str::limit($rph->topic, 40) }}</td>
                    <td class="px-5 py-3">
                        <a href="{{ route('rph_approvals.index') }}" class="text-blue-600 hover:underline dark:text-blue-400">Urus →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-gray-400">Tiada RPH menunggu kelulusan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
