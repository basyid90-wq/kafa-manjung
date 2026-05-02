@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Tempahan Buku KAFA</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Senarai tempahan buku oleh sekolah</p>
        </div>
        <div class="flex items-center gap-2">
            @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
            <a href="{{ route('book_orders.supplier_summary') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Ringkasan Pembekal
            </a>
            @endhasanyrole

            @hasrole('Pembekal')
            <a href="{{ route('book_orders.supplier_index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                Senarai Tempahan Pembekal
            </a>
            @endrole

            @hasanyrole('Guru Besar|Penyelia KAFA')
            <a href="{{ route('book_orders.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Tempahan Baru
            </a>
            @endhasanyrole
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        @hasanyrole('Super Admin|Pentadbir|Pembekal|Penyelia KAFA')
                        <th class="px-5 py-3">Sekolah</th>
                        @endhasanyrole
                        <th class="px-5 py-3">Tarikh</th>
                        <th class="px-5 py-3 text-right">Jumlah (RM)</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($orders as $order)
                    @php
                        $statusMap = [
                            'draft'     => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                            'submitted' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'approved'  => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'rejected'  => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            'delivered' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                        ];
                        $statusClass = $statusMap[$order->status] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                        </td>
                        @hasanyrole('Super Admin|Pentadbir|Pembekal|Penyelia KAFA')
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-white text-sm">
                            {{ $order->school->name ?? '—' }}
                        </td>
                        @endhasanyrole
                        <td class="px-5 py-3 text-xs">
                            {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}
                        </td>
                        <td class="px-5 py-3 text-right font-mono font-semibold text-gray-800 dark:text-gray-200">
                            {{ number_format($order->total_price, 2) }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('book_orders.show', $order) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                   title="Lihat Butiran">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                                <form action="{{ route('book_orders.destroy', $order) }}" method="POST"
                                      onsubmit="return confirm('Padam Tempahan #{{ $order->id }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                            title="Padam">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @else
                                    @if($order->status == 'draft')
                                    <form action="{{ route('book_orders.destroy', $order) }}" method="POST"
                                          onsubmit="return confirm('Padam Draf Tempahan #{{ $order->id }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                title="Padam Draf">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                @endhasanyrole
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada rekod tempahan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
