@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Sejarah Kelulusan RPH</h1>
        <a href="{{ route('rph_approvals.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Search --}}
    <form action="{{ route('rph_approvals.history') }}" method="GET" class="flex gap-2 mb-5">
        <input name="search" type="text" placeholder="Cari Nama Guru..." value="{{ request('search') }}"
               class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Cari
        </button>
    </form>

    @if($records->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Tiada sejarah kelulusan atau belum ada RPH yang disemak.</p>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Tarikh RPH</th>
                        <th class="px-4 py-3 text-left">Nama Guru</th>
                        <th class="px-4 py-3 text-left">Sekolah / Kelas</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Disemak Oleh</th>
                        <th class="px-4 py-3 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($records as $index => $rph)
                    <tr id="row-{{ $rph->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $records->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $rph->hari }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $rph->user->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $rph->school->name ?? '-' }}</p>
                            <span class="px-1.5 py-0.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded">{{ $rph->kafaClass->display_name ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($rph->status == 'approved')
                                <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">Lulus</span>
                            @elseif($rph->status == 'rejected')
                                <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full">Tolak</span>
                            @elseif($rph->status == 'revision_needed')
                                <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">Pembaikan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">{{ $rph->reviewer->name ?? 'Sistem' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openPdfBlob(this, '{{ route('rph.pdf', $rph) }}')"
                                        title="Lihat PDF"
                                        class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </button>
                                @if(auth()->user()->hasAnyRole(['Super Admin','Pentadbir','Penyelia KAFA']) && (auth()->user()->hasRole('Super Admin') || auth()->id() == $rph->reviewer_id))
                                <form action="{{ route('rph_approvals.revert', $rph) }}" method="POST"
                                      data-delete-form="true"
                                      data-name="Kelulusan RPH ({{ $rph->user->name }})"
                                      class="m-0">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" title="Batal Kelulusan"
                                            class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($records->hasPages())
    <div class="mt-4">{{ $records->links() }}</div>
    @endif
    @endif
</div>
@endsection
