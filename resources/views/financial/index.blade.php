@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-5">
        <div>
                        <h1 class="ek-page-title">Pengurusan Kewangan</h1>
            <p class="ek-page-sub mt-1">Rekod transaksi masuk dan keluar sekolah</p>
        </div>
        @hasanyrole('Super Admin|Guru Besar')
        <a href="{{ route('financial.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Rekod
        </a>
        @endhasanyrole
    </div>

    {{-- ── Balance Card ── --}}
    <div class="p-5 mb-5 rounded-xl border {{ $balance >= 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $balance >= 0 ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    RM {{ number_format($balance, 2) }}
                </p>
                <p class="text-sm {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Baki Semasa Akaun Sekolah
                </p>
            </div>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Tarikh</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Jenis</th>
                        <th class="px-5 py-3 text-right">Jumlah (RM)</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center w-20">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                    <tr>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3 text-xs">{{ $record->transaction_date }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $record->category->name }}</td>
                        <td class="px-5 py-3">
                            @if($record->transaction_type == 'in')
                                <span class="ek-badge ek-badge-green">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                    </svg>
                                    Masuk
                                </span>
                            @else
                                <span class="ek-badge ek-badge-red">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                    </svg>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right font-mono font-semibold text-gray-800">
                            {{ number_format($record->amount, 2) }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="ek-badge ek-badge-gray">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <button type="button"
                                    onclick="openPdfBlob(this, '{{ route('financial.export', $record) }}')"
                                    class="p-1.5 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                    title="Cetak PDF">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada rekod transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $records->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
