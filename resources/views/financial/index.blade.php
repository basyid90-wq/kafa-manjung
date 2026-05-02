@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-5">
        <div>
            @role('Penyelia KAFA')
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Semakan Kewangan Daerah</h1>
            @else
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Pengurusan Kewangan</h1>
            @endrole
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Rekod transaksi masuk dan keluar sekolah</p>
        </div>
        @hasanyrole('Super Admin|Pentadbir|Bendahari Sekolah')
        <a href="{{ route('financial.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Rekod
        </a>
        @endhasanyrole
    </div>

    {{-- ── Balance Card ── --}}
    <div class="p-5 mb-5 rounded-xl border {{ $balance >= 0 ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' }}">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $balance >= 0 ? 'bg-green-100 dark:bg-green-900/40' : 'bg-red-100 dark:bg-red-900/40' }} flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 {{ $balance >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                    RM {{ number_format($balance, 2) }}
                </p>
                <p class="text-sm {{ $balance >= 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                    @role('Penyelia KAFA')
                    Jumlah Baki Keseluruhan Daerah
                    @else
                    Baki Semasa Akaun Sekolah
                    @endrole
                </p>
            </div>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Tarikh</th>
                        @role('Penyelia KAFA')
                        <th class="px-5 py-3">Sekolah</th>
                        @endrole
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Jenis</th>
                        <th class="px-5 py-3 text-right">Jumlah (RM)</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center w-20">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($records as $record)
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3 text-xs">{{ $record->transaction_date }}</td>
                        @role('Penyelia KAFA')
                        <td class="px-5 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $record->school->name ?? '—' }}</td>
                        @endrole
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-300">{{ $record->category->name }}</td>
                        <td class="px-5 py-3">
                            @if($record->transaction_type == 'in')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                    </svg>
                                    Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                    </svg>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right font-mono font-semibold text-gray-800 dark:text-gray-200">
                            {{ number_format($record->amount, 2) }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <button type="button"
                                    onclick="openPdfBlob(this, '{{ route('financial.export', $record) }}')"
                                    class="p-1.5 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 rounded-lg transition-colors"
                                    title="Cetak PDF">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->hasRole('Penyelia KAFA') ? 8 : 7 }}" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada rekod transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $records->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
