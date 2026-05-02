@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Rekod Pengajaran Harian (RPH)</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Senarai RPH yang telah dicipta</p>
        </div>
        @role('Guru KAFA|Penyelia KAFA|Super Admin|Pentadbir|Guru Besar')
        <a href="{{ route('rph.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Cipta RPH Baru
        </a>
        @endrole
    </div>

    {{-- ── Table Card ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 w-10">No</th>
                        <th class="px-4 py-3">Tarikh / Hari</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Tajuk</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center w-28">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($rphs as $rph)
                    @php
                        $p1 = $rph->periods->first();
                        $statusMap = [
                            'pending'          => ['label' => 'Menunggu Semakan', 'class' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'],
                            'approved'         => ['label' => 'Diluluskan',       'class' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'],
                            'rejected'         => ['label' => 'Ditolak',          'class' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
                            'revision_needed'  => ['label' => 'Perlu Pembaikan',  'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'],
                        ];
                        $status = $statusMap[$rph->status] ?? ['label' => $rph->status, 'class' => 'bg-gray-100 text-gray-600'];
                    @endphp
                    <tr id="row-{{ $rph->id }}" class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-gray-400 text-xs">
                            {{ ($rphs->currentPage() - 1) * $rphs->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900 dark:text-white text-xs">
                                {{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}
                            </p>
                            <p class="text-xs text-gray-400">{{ $rph->hari ?? '—' }}</p>
                        </td>
                        <td class="px-4 py-3 jawi-cell text-gray-800 dark:text-gray-200">
                            @if($rph->isGabungan())
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 mb-1 ltr-cell">Kelas Cantum</span>
                                <span class="block text-xs text-gray-400 ltr-cell">{{ $rph->getCombinedYearsLabel() }}</span>
                            @endif
                            {{ $p1?->mata_pelajaran_jawi ?? '—' }}
                        </td>
                        <td class="px-4 py-3 jawi-cell text-gray-700 dark:text-gray-300">
                            {{ $p1?->topic_jawi ?? $rph->topic_jawi ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Lihat --}}
                                <a href="{{ route('rph.show', $rph) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                   title="Lihat Butiran">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                {{-- Edit (hanya jika bukan approved & milik sendiri) --}}
                                @if(auth()->id() == $rph->user_id && $rph->status != 'approved')
                                <a href="{{ route('rph.edit', $rph) }}"
                                   class="p-1.5 text-green-600 hover:bg-green-50 dark:text-green-400 dark:hover:bg-green-900/20 rounded-lg transition-colors"
                                   title="Kemas Kini">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @endif

                                {{-- PDF (hanya jika approved) --}}
                                @if($rph->status == 'approved')
                                <button type="button"
                                        onclick="openPdfBlob(this, '{{ route('rph.pdf', $rph) }}')"
                                        class="p-1.5 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 rounded-lg transition-colors"
                                        title="Cetak / Papar PDF">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-sm">Tiada rekod RPH.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rphs->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $rphs->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
    .jawi-cell { font-family: 'Lateef', serif; font-size: 1.05em; direction: rtl; text-align: right; }
    .ltr-cell  { font-family: inherit; direction: ltr; text-align: left; }
</style>
@endsection
