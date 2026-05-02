{{-- ── Pentadbir Dashboard ── --}}
@php
$uc = $data['user_counts'] ?? [];
$cards = [
    ['title'=>'Pentadbir',    'count'=>$uc['Admin']??0,      'bg'=>'bg-blue-100 dark:bg-blue-900/30',   'color'=>'text-blue-600 dark:text-blue-400',   'icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
    ['title'=>'Penyelia KAFA','count'=>$uc['Penyelia']??0,   'bg'=>'bg-purple-100 dark:bg-purple-900/30', 'color'=>'text-purple-600 dark:text-purple-400','icon'=>'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
    ['title'=>'Guru Besar',   'count'=>$uc['Guru Besar']??0, 'bg'=>'bg-green-100 dark:bg-green-900/30',  'color'=>'text-green-600 dark:text-green-400', 'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    ['title'=>'Pembekal',     'count'=>$uc['Pembekal']??0,   'bg'=>'bg-yellow-100 dark:bg-yellow-900/30', 'color'=>'text-yellow-600 dark:text-yellow-400','icon'=>'M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4'],
];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">Ringkasan Data Daerah</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-5 py-3">Daerah</th>
                    <th class="px-5 py-3">Jumlah Sekolah</th>
                    <th class="px-5 py-3">Jumlah Murid</th>
                    <th class="px-5 py-3">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($data['districts'] as $district)
                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">{{ $district->name }}</td>
                    <td class="px-5 py-3">{{ $district->schools_count }} sekolah</td>
                    <td class="px-5 py-3">{{ $district->students_count }} murid</td>
                    <td class="px-5 py-3">
                        <a href="{{ route('districts.show', $district->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 text-sm">Lihat →</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
