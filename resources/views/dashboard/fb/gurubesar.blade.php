{{-- ── Guru Besar Dashboard ── --}}
@php
$cards = [
    ['title'=>'Guru KAFA',    'count'=>$data['stats']['guru_kafa'], 'bg'=>'bg-blue-100 dark:bg-blue-900/30',  'color'=>'text-blue-600 dark:text-blue-400',  'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
    ['title'=>'Jumlah Kelas', 'count'=>$data['stats']['classes'],   'bg'=>'bg-purple-100 dark:bg-purple-900/30','color'=>'text-purple-600 dark:text-purple-400','icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
    ['title'=>'Jumlah Murid', 'count'=>$data['stats']['students'],  'bg'=>'bg-green-100 dark:bg-green-900/30', 'color'=>'text-green-600 dark:text-green-400', 'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
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
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">Permohonan RPH Terkini</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-5 py-3">Nama Guru</th>
                    <th class="px-5 py-3">Tarikh</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($data['pending_rphs'] as $rph)
                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">{{ $rph->user->name }}</td>
                    <td class="px-5 py-3">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }} <span class="text-xs text-gray-400">Minggu {{ $rph->week }}</span></td>
                    <td class="px-5 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span></td>
                    <td class="px-5 py-3"><a href="{{ route('rph_approvals.index') }}" class="text-blue-600 hover:underline dark:text-blue-400">Semak →</a></td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400">Tiada RPH menunggu semakan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
