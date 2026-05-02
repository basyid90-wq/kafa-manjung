@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Pengurusan Pindah Murid</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Permohonan pindah murid antara sekolah</p>
        </div>
        @role('Guru Besar')
        <a href="{{ route('student_transfers.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Permohonan Baru
        </a>
        @endrole
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Tarikh Mohon</th>
                        <th class="px-5 py-3">Nama Murid</th>
                        <th class="px-5 py-3">Sekolah Asal → Destinasi</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center w-28">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($transfers as $index => $transfer)
                    @php
                        $statusMap = [
                            'pending'  => ['label' => 'Pending',    'class' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'],
                            'approved' => ['label' => 'Diluluskan', 'class' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'],
                            'rejected' => ['label' => 'Ditolak',    'class' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
                        ];
                        $s = $statusMap[$transfer->status] ?? ['label' => $transfer->status, 'class' => 'bg-gray-100 text-gray-600'];
                    @endphp
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $transfers->firstItem() + $index }}</td>
                        <td class="px-5 py-3 text-xs">{{ $transfer->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">{{ $transfer->student->name }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1.5 text-xs">
                                <span class="text-gray-700 dark:text-gray-300">{{ $transfer->fromSchool->name }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $transfer->toSchool->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s['class'] }}">
                                {{ $s['label'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($transfer->status == 'pending')
                                    @hasanyrole('Super Admin|Penyelia KAFA')
                                    <form action="{{ route('student_transfers.update', $transfer) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit"
                                                class="p-1.5 text-green-600 hover:bg-green-50 dark:text-green-400 dark:hover:bg-green-900/20 rounded-lg transition-colors"
                                                title="Luluskan">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('student_transfers.update', $transfer) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit"
                                                class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                title="Tolak">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endhasanyrole
                                    @role('Guru Besar')
                                    @if($transfer->from_school_id == auth()->user()->school_id)
                                    <form action="{{ route('student_transfers.destroy', $transfer) }}" method="POST"
                                          onsubmit="return confirm('Batal permohonan pindah {{ addslashes($transfer->student->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                title="Batal / Padam">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                    @endrole
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada permohonan pindah murid buat masa ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transfers->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $transfers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
