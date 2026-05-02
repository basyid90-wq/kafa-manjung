@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Butiran Tempahan #{{ $bookOrder->id }}</h1>
        <div class="flex items-center gap-2 flex-wrap">
            @if($bookOrder->status === 'draft')
                @if(Auth::user()->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA']) || Auth::user()->school_id == $bookOrder->school_id)
                <a href="{{ route('book_orders.edit', $bookOrder) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Draf
                </a>
                <form action="{{ route('book_orders.submit', $bookOrder) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                        Hantar Tempahan
                    </button>
                </form>
                @endif
            @endif

            @if($bookOrder->status === 'submitted_by_school' && (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Pentadbir')))
            <form action="{{ route('book_orders.approve', $bookOrder) }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Luluskan &amp; Hantar ke Pembekal
                </button>
            </form>
            @endif

            @if(in_array($bookOrder->status, ['approved_by_admin', 'processing_by_supplier', 'delivered_to_school', 'completed']))
            <button onclick="window.print()"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </button>
            @endif

            @if($bookOrder->status === 'delivered_to_school' && (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Pentadbir')))
            <form action="{{ route('book_orders.complete', $bookOrder) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Tandakan Selesai
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-sm space-y-2">
            <div class="flex">
                <span class="w-32 text-gray-500 dark:text-gray-400">Sekolah</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $bookOrder->school->name }}</span>
            </div>
            <div class="flex">
                <span class="w-32 text-gray-500 dark:text-gray-400">Tarikh</span>
                <span class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($bookOrder->order_date)->format('d F Y') }}</span>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-sm space-y-2">
            <div class="flex items-center">
                <span class="w-32 text-gray-500 dark:text-gray-400">Status</span>
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $bookOrder->status_badge }}">{{ $bookOrder->status_label }}</span>
            </div>
            <div class="flex">
                <span class="w-32 text-gray-500 dark:text-gray-400">Jumlah</span>
                <span class="font-semibold text-gray-900 dark:text-white">RM{{ number_format($bookOrder->total_price, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-4">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Buku</th>
                        <th class="px-4 py-3 text-center">Harga Seunit</th>
                        <th class="px-4 py-3 text-center">Kuantiti</th>
                        <th class="px-4 py-3 text-center">Jumlah (RM)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($bookOrder->items as $item)
                    @if($item->quantity > 0)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $item->book->name }}</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">{{ number_format($item->price_at_order, 2) }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-700 dark:text-gray-300">{{ $item->quantity }}</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">{{ number_format($item->price_at_order * $item->quantity, 2) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-200 dark:border-gray-600">
                        <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">Jumlah Keseluruhan</td>
                        <td class="px-4 py-3 text-center font-bold text-gray-900 dark:text-white">RM{{ number_format($bookOrder->total_price, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @if($bookOrder->notes)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-4">
        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Catatan Sekolah</p>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $bookOrder->notes }}</p>
    </div>
    @endif

    <a href="{{ Auth::user()->hasRole('Pembekal') ? route('book_orders.supplier_index') : route('book_orders.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:underline">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Senarai
    </a>
</div>

<style>
@media print {
    nav, aside, header, footer, .no-print { display: none !important; }
}
</style>
@endsection
