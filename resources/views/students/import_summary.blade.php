@extends('layout-fb.layout')

@section('content')
<div>

    <div class="mb-6">
        <h1 class="ek-page-title">Ringkasan Import SIMPENI</h1>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-blue-700">{{ $summary['total'] }}</p>
            <p class="text-sm text-blue-600 mt-1">Rekod Dibaca</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $summary['success'] }}</p>
            <p class="text-sm text-green-600 mt-1">Berjaya Disusun</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-red-700">{{ $summary['failed_class'] }}</p>
            <p class="text-sm text-red-600 mt-1">Tiada Kelas</p>
        </div>
    </div>

    @if($summary['failed_class'] > 0)
    <div class="flex items-center justify-between bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 mb-5 text-sm text-yellow-700">
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
    <div class="ek-table-wrap">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Senarai Murid Diimport</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Murid</th>
                        <th class="px-4 py-3 text-left">MyKid</th>
                        <th class="px-4 py-3 text-left">Kelas Padanan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($summary['details'] as $i => $row)
                    <tr>
                        <td class="px-4 py-2.5 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900">{{ $row['name'] }}</td>
                        <td class="px-4 py-2.5 text-xs font-mono text-gray-500">{{ $row['mykid'] }}</td>
                        <td class="px-4 py-2.5">
                            @if($row['class'])
                                <span class="ek-badge ek-badge-green">{{ $row['class'] }}</span>
                            @else
                                <span class="ek-badge ek-badge-red">TIADA PADANAN</span>
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
           class="ek-btn-primary">
            Kembali ke Senarai Murid
        </a>
    </div>
</div>
@endsection
