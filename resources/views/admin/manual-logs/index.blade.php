@extends('layout-fb.layout')

@section('content')
<div>

    <div class="mb-5">
        <h1 class="ek-page-title">Log Muat Turun Panduan Pengguna</h1>
        <p class="ek-page-sub mt-1">
            Rekod setiap kali pengguna memuat turun Buku Panduan. Jumlah: <strong class="text-gray-700">{{ $logs->total() }}</strong> rekod.
        </p>
    </div>

    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Pengguna</th>
                        <th class="px-5 py-3">Peranan</th>
                        <th class="px-5 py-3">Sekolah</th>
                        <th class="px-5 py-3">Tarikh Muat Turun</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $i => $log)
                    <tr>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $logs->firstItem() + $i }}</td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-900 text-sm">{{ $log->user->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $log->user->email ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3">
                            <span class="ek-badge ek-badge-blue">
                                {{ $log->role_name }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500">
                            {{ $log->school->name ?? '—' }}
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500">
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
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
