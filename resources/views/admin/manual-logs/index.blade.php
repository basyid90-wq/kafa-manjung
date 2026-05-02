@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Log Muat Turun Panduan Pengguna</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Rekod setiap kali pengguna memuat turun Buku Panduan. Jumlah: <strong class="text-gray-700 dark:text-gray-300">{{ $logs->total() }}</strong> rekod.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Pengguna</th>
                        <th class="px-5 py-3">Peranan</th>
                        <th class="px-5 py-3">Sekolah</th>
                        <th class="px-5 py-3">Tarikh Muat Turun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($logs as $i => $log)
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $logs->firstItem() + $i }}</td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $log->user->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $log->user->email ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $log->role_name }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">
                            {{ $log->school->name ?? '—' }}
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">
                            {{ $log->downloaded_at?->format('d/m/Y H:i') ?? '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada rekod muat turun.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
