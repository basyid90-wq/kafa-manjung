@extends('layout-fb.layout')

@section('content')
@php
$monthNames = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
    5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
];
@endphp

<div class="p-4 md:p-6">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Rumusan Tempahan untuk Pembekal</h1>
    </div>

    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        <form action="{{ route('book_orders.supplier_summary') }}" method="GET"
              class="flex flex-wrap items-end gap-3">
            <div class="w-40">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
                <select name="month"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Bulan --</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $monthNames[$m] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-32">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                <select name="year"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Tahun --</option>
                    @foreach(range(date('Y') - 2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Tapis
            </button>
            @php $pdfUrl = route('book_orders.supplier_summary.pdf', array_filter(['month' => $month, 'year' => $year])); @endphp
            <button type="button" onclick="openPdfBlob(this, '{{ $pdfUrl }}')"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak PDF
            </button>
        </form>
    </div>

    @if($month || $year)
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
        Menunjukkan data bagi: <strong class="text-gray-900 dark:text-white">{{ $month ? $monthNames[(int)$month] : 'Semua Bulan' }} {{ $year ?: '' }}</strong>
    </p>
    @else
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Ringkasan kuantiti keseluruhan bagi semua tempahan yang telah diluluskan/selesai.</p>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Buku</th>
                        <th class="px-4 py-3 text-center">Kuantiti Keseluruhan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @php $grandTotal = 0; @endphp
                    @forelse($summary as $i => $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $row->book->name }}</td>
                        <td class="px-4 py-2.5 text-center font-semibold text-gray-900 dark:text-white">{{ $row->total_quantity }} unit</td>
                    </tr>
                    @php $grandTotal += $row->total_quantity; @endphp
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-400 text-sm">Tiada data untuk tempoh yang dipilih.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($summary->isNotEmpty())
                <tfoot>
                    <tr class="border-t-2 border-gray-200 dark:border-gray-600">
                        <td colspan="2" class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">Jumlah Keseluruhan Unit</td>
                        <td class="px-4 py-3 text-center font-bold text-gray-900 dark:text-white">{{ $grandTotal }} unit</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <a href="{{ route('book_orders.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:underline">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
</div>
@endsection
