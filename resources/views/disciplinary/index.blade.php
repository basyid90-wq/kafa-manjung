@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Rekod Disiplin Murid</h1>
            <p class="ek-page-sub mt-1">Senarai rekod pelanggaran disiplin murid</p>
        </div>
        @role('Super Admin|Guru KAFA')
        <a href="{{ route('disciplinary.create') }}"
           class="ek-btn-danger">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Rekod Kesalahan Baru
        </a>
        @endrole
    </div>

    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Murid</th>
                        <th class="px-5 py-3">Tarikh</th>
                        <th class="px-5 py-3">Kesalahan</th>
                        <th class="px-5 py-3">Tindakan Diambil</th>
                        <th class="px-5 py-3">Dilapor Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                    <tr>
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $record->student->name }}</td>
                        <td class="px-5 py-3 text-xs">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ Str::limit($record->offense_details, 50) }}</td>
                        <td class="px-5 py-3">
                            <span class="ek-badge ek-badge-red">
                                {{ $record->action_taken }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500">{{ $record->reporter->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">Tiada rekod disiplin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $records->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
