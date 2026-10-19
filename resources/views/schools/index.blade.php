@extends('layout-fb.layout')

@section('content')
<div>

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Pengurusan Sekolah</h1>
            <p class="ek-page-sub mt-1">Senarai sekolah KAFA yang berdaftar</p>
        </div>
        @unlessrole('Guru Besar')
        <a href="{{ route('schools.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Sekolah
        </a>
        @endunlessrole
    </div>

    {{-- ── Table Card ── --}}
    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Nama Sekolah</th>
                        <th class="px-5 py-3">Kod</th>
                        <th class="px-5 py-3">Pakej</th>
                        <th class="px-5 py-3">No. Telefon</th>
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr id="row-{{ $school->id }}">
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($schools->currentPage() - 1) * $schools->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-900">{{ $school->name }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <code class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs font-mono">{{ $school->code }}</code>
                        </td>
                        <td class="px-5 py-3">
                            @php $planColor = ['free' => 'bg-gray-100 text-gray-700', 'personal' => 'bg-blue-100 text-blue-700', 'sekolah' => 'bg-green-100 text-green-700'][$school->effectivePlan()]; @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $planColor }}">{{ $school->planLabel() }}</span>
                            @if($school->isPlanExpired())
                            <span class="ek-badge ek-badge-red">Tamat</span>
                            @elseif($school->plan_expires_at)
                            <p class="text-xs text-gray-400 mt-0.5">hingga {{ $school->plan_expires_at->format('d/m/Y') }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600">
                            {{ $school->no_telefon ?? '—' }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('schools.edit', $school) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @unlessrole('Guru Besar')
                                <form action="{{ route('schools.destroy', $school) }}" method="POST"
                                      data-delete-form data-name="sekolah {{ $school->name }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Padam">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endunlessrole
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <p class="text-sm">Tiada sekolah berdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schools->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $schools->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
