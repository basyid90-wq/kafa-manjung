@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Pengurusan Pesanan Pembekal</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Senarai pesanan buku yang perlu diproses.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">ID Pesanan</th>
                        <th class="px-5 py-3">Sekolah</th>
                        <th class="px-5 py-3 text-right">Jumlah (RM)</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($orders as $i => $order)
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-5 py-3 font-mono font-medium text-gray-900 dark:text-white">
                            #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ $order->school->name }}</td>
                        <td class="px-5 py-3 text-right font-mono font-semibold text-gray-800 dark:text-gray-200">
                            {{ number_format($order->total_price, 2) }}
                        </td>
                        <td class="px-5 py-3">
                            @php
                                $statusColor = match($order->status) {
                                    'approved_by_admin'       => 'blue',
                                    'processing_by_supplier'  => 'yellow',
                                    'delivered'               => 'green',
                                    default                   => 'gray',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700
                                dark:bg-{{ $statusColor }}-900/30 dark:text-{{ $statusColor }}-400">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($order->status == 'approved_by_admin')
                                <form action="{{ route('book_orders.process', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors">
                                        Sahkan Pesanan
                                    </button>
                                </form>
                                @endif

                                @if($order->status == 'processing_by_supplier')
                                <form action="{{ route('book_orders.deliver', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors">
                                        Selesai Dihantar
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('book_orders.show', $order) }}"
                                   class="p-1.5 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada pesanan aktif untuk diuruskan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
