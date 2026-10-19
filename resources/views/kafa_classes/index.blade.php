@extends('layout-fb.layout')

@section('content')
<div>

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="ek-page-title">Pengurusan Kelas</h1>
            <p class="ek-page-sub mt-1">Senarai kelas KAFA yang didaftarkan dalam sistem</p>
        </div>
        <a href="{{ route('kafa_classes.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kelas
        </a>
    </div>

    {{-- ── Important Notice ── --}}
    <div class="flex gap-3 p-4 mb-5 bg-blue-50 border border-blue-200 rounded-xl">
        <div class="shrink-0 w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-blue-800 mb-0.5">MAKLUMAN PENTING (WAJIB BACA)</p>
            <p class="text-sm text-blue-700 leading-relaxed">
                Bagi memudahkan urusan <strong>IMPORT</strong> data murid, pastikan <strong>Nama Kelas</strong> adalah
                <strong class="uppercase">TEPAT DAN SAMA</strong> seperti yang didaftarkan dalam
                <strong>Sistem SIMPENI Jakim</strong>.
            </p>
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Nama Kelas &amp; Tahun</th>
                        <th class="px-5 py-3">Guru Kelas</th>
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $c)
                    <tr id="row-{{ $c->id }}">
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($classes->currentPage() - 1) * $classes->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-content-center shrink-0" style="display:flex;align-items:center;justify-content:center;">
                                    <span class="text-xs font-bold text-indigo-600">T{{ $c->tahun ?? '?' }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $c->display_name }}</p>
                                    @if($c->school)
                                    <p class="text-xs text-gray-400">{{ $c->school->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            @if($c->teacher)
                                <span class="ek-badge ek-badge-green">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    {{ $c->teacher->name }}
                                </span>
                            @else
                                <span class="ek-badge ek-badge-gray">
                                    Tiada Guru
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('kafa_classes.edit', $c) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('kafa_classes.destroy', $c) }}" method="POST"
                                      data-delete-form data-name="kelas {{ $c->display_name }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Padam">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <p class="text-sm">Tiada kelas didaftarkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($classes->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $classes->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
