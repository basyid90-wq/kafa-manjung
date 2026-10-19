@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Pengurusan Pindah Murid</h1>
            <p class="ek-page-sub mt-1">Rekod murid yang berpindah keluar dari sekolah</p>
        </div>
        @role('Guru Besar')
        <a href="{{ route('student_transfers.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Rekod Pindah Keluar
        </a>
        @endrole
    </div>

    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Tarikh</th>
                        <th class="px-5 py-3">Nama Murid</th>
                        <th class="px-5 py-3">Sekolah Asal → Destinasi</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center w-28">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transfers as $index => $transfer)
                    @php
                        $statusMap = [
                            'pending'  => ['label' => 'Pending',    'class' => 'bg-yellow-100 text-yellow-700'],
                            'approved' => ['label' => 'Pindah Keluar', 'class' => 'bg-green-100 text-green-700'],
                            'rejected' => ['label' => 'Ditolak',    'class' => 'bg-red-100 text-red-700'],
                        ];
                        $s = $statusMap[$transfer->status] ?? ['label' => $transfer->status, 'class' => 'bg-gray-100 text-gray-600'];
                    @endphp
                    <tr>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $transfers->firstItem() + $index }}</td>
                        <td class="px-5 py-3 text-xs">{{ $transfer->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $transfer->student->name }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1.5 text-xs">
                                <span class="text-gray-700">{{ $transfer->fromSchool->name }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                <span class="text-gray-700">{{ $transfer->to_school_name ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s['class'] }}">
                                {{ $s['label'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-1.5">
                                @if(auth()->user()->canAccessSchool($transfer->from_school_id))
                                <form action="{{ route('student_transfers.destroy', $transfer) }}" method="POST"
                                      data-delete-form data-name="rekod pindah {{ $transfer->student->name }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Batal Rekod Pindah">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada rekod pindah murid buat masa ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transfers->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $transfers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
