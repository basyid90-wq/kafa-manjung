@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Rekod Disiplin Murid</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Senarai rekod pelanggaran disiplin murid</p>
        </div>
        @role('Super Admin|Pentadbir|Guru KAFA')
        <a href="{{ route('disciplinary.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Rekod Kesalahan Baru
        </a>
        @endrole
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Murid</th>
                        <th class="px-5 py-3">Tarikh</th>
                        <th class="px-5 py-3">Kesalahan</th>
                        <th class="px-5 py-3">Tindakan Diambil</th>
                        <th class="px-5 py-3">Dilapor Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($records as $record)
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">{{ $record->student->name }}</td>
                        <td class="px-5 py-3 text-xs">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-300">{{ Str::limit($record->offense_details, 50) }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                {{ $record->action_taken }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">{{ $record->reporter->name }}</td>
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
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $records->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
