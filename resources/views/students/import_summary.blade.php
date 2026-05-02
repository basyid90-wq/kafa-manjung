@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Ringkasan Import SIMPENI</h1>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-blue-700 dark:text-blue-400">{{ $summary['total'] }}</p>
            <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">Rekod Dibaca</p>
        </div>
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-green-700 dark:text-green-400">{{ $summary['success'] }}</p>
            <p class="text-sm text-green-600 dark:text-green-400 mt-1">Berjaya Disusun</p>
        </div>
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-red-700 dark:text-red-400">{{ $summary['failed_class'] }}</p>
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">Tiada Kelas</p>
        </div>
    </div>

    @if($summary['failed_class'] > 0)
    <div class="flex items-center justify-between bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl px-4 py-3 mb-5 text-sm text-yellow-700 dark:text-yellow-400">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            Terdapat <strong class="mx-1">{{ $summary['failed_class'] }}</strong> murid yang tidak dapat dipadankan dengan kelas sedia ada.
        </div>
        <a href="{{ route('students.index', ['class_id' => 'none']) }}"
           class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
            Susun Sekarang
        </a>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Senarai Murid Diimport</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Murid</th>
                        <th class="px-4 py-3 text-left">MyKid</th>
                        <th class="px-4 py-3 text-left">Kelas Padanan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($summary['details'] as $i => $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $row['name'] }}</td>
                        <td class="px-4 py-2.5 text-xs font-mono text-gray-500 dark:text-gray-400">{{ $row['mykid'] }}</td>
                        <td class="px-4 py-2.5">
                            @if($row['class'])
                                <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">{{ $row['class'] }}</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full">TIADA PADANAN</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5">
                            @if($row['class'])
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Berjaya">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Perlu susun manual">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end mt-5">
        <a href="{{ route('students.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            Kembali ke Senarai Murid
        </a>
    </div>
</div>
@endsection
