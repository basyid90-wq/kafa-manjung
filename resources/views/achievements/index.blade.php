@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="ek-page-title">
                @if(isset($school))
                    Rekod Pencapaian Murid — {{ $school->name }}
                @else
                    Rekod Pencapaian Murid
                @endif
            </h1>
            <p class="ek-page-sub mt-1">Rekod akademik dan pencapaian murid KAFA</p>
        </div>
        @hasanyrole('Guru Besar|Guru KAFA')
        <a href="{{ route('achievements.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Rekod
        </a>
        @endhasanyrole
    </div>

    {{-- ── Completion Stats (Guru Besar) ── --}}
    @hasrole('Guru Besar')
    @if(isset($completionStats) && $completionStats->isNotEmpty())
    <div class="ek-card mb-5">
        <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide mb-3">
            Status Rekod Mengikut Kelas ({{ request('academic_year', date('Y')) }})
        </p>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-500">
                <thead>
                    <tr>
                        <th class="py-2 pr-4">Kelas</th>
                        <th class="py-2 px-3 text-center">Murid</th>
                        <th class="py-2 px-3 text-center">Direkod</th>
                        <th class="py-2 px-3 text-center">Final</th>
                        <th class="py-2 px-3 text-center">Status</th>
                        <th class="py-2 px-3 text-center">Finalisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completionStats as $cls)
                    @php
                        $pct = $cls->students_count > 0 ? round(($cls->recorded_count / $cls->students_count) * 100) : 0;
                        $allFinal = $cls->recorded_count > 0 && $cls->final_count === $cls->recorded_count;
                    @endphp
                    <tr>
                        <td class="py-2 pr-4 font-semibold text-gray-800">{{ $cls->display_name }}</td>
                        <td class="py-2 px-3 text-center">{{ $cls->students_count }}</td>
                        <td class="py-2 px-3 text-center">{{ $cls->recorded_count }}</td>
                        <td class="py-2 px-3 text-center">{{ $cls->final_count }}</td>
                        <td class="py-2 px-3 text-center">
                            @if($cls->recorded_count === 0)
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-700">Belum Rekod</span>
                            @elseif($allFinal)
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Semua Final</span>
                            @else
                                <div class="w-16 h-1.5 bg-gray-200 rounded-full mx-auto overflow-hidden">
                                    <div class="h-full {{ $pct >= 80 ? 'bg-green-500' : 'bg-yellow-500' }} rounded-full" style="width:{{ $pct }}%"></div>
                                </div>
                                <span class="text-[10px] text-gray-400">{{ $pct }}%</span>
                            @endif
                        </td>
                        <td class="py-2 px-3 text-center">
                            @if($cls->recorded_count > 0 && !$allFinal)
                            <form method="POST" action="{{ route('achievements.bulk_finalize') }}" class="inline">
                                @csrf
                                <input type="hidden" name="kafa_class_id" value="{{ $cls->id }}">
                                <input type="hidden" name="academic_year" value="{{ request('academic_year', date('Y')) }}">
                                <button type="submit"
                                        data-confirm="Finalkan semua rekod draf kelas {{ $cls->display_name }}?"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-[10px] font-medium transition-colors">
                                    Final
                                </button>
                            </form>
                            @elseif($allFinal)
                                <svg class="w-4 h-4 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @endhasrole

    {{-- ── Filters ── --}}
    <div class="ek-card mb-5">
        <form method="GET" action="{{ isset($school) ? route('achievements.school_list', $school->id) : route('achievements.index') }}"
              class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Kelas</label>
                <select name="kafa_class_id"
                        class="ek-input">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kafa_class_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->display_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Tahun</label>
                <select name="academic_year"
                        class="ek-input">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                    <option value="{{ $y }}" {{ request('academic_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Status</label>
                <select name="status"
                        class="ek-input">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draf</option>
                    <option value="final" {{ request('status') === 'final' ? 'selected' : '' }}>Final</option>
                </select>
            </div>
            <button type="submit"
                    class="ek-btn-primary">
                Tapis
            </button>
            <a href="{{ isset($school) ? route('achievements.school_list', $school->id) : route('achievements.index') }}"
               class="ek-btn-secondary">
                Reset
            </a>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Murid</th>
                        <th class="px-5 py-3">Kelas</th>
                        <th class="px-5 py-3">Tahun</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center w-32">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $i => $rec)
                    @php $isFinal = $rec->status === 'final'; @endphp
                    <tr id="row-{{ $rec->id }}" class="{{ $isFinal ? 'bg-white' : 'bg-yellow-50/50' }} hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $records->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $rec->student->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $rec->kafaClass->name ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $rec->academic_year }}</td>
                        <td class="px-5 py-3">
                            @if($isFinal)
                                <span class="ek-badge ek-badge-green">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Final
                                </span>
                            @else
                                <span class="ek-badge ek-badge-yellow">
                                    Draf
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Lihat --}}
                                <a href="{{ route('achievements.show', ['achievement' => $rec->id, 'page' => $records->currentPage()]) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Lihat">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                {{-- Edit --}}
                                @hasanyrole('Guru Besar|Guru KAFA|Super Admin')
                                @if(!$isFinal || auth()->user()->hasAnyRole(['Guru Besar', 'Super Admin']))
                                <a href="{{ route('achievements.edit', ['achievement' => $rec->id, 'page' => $records->currentPage()]) }}"
                                   class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                   title="Kemaskini">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @else
                                <span class="p-1.5 text-gray-300 cursor-not-allowed" title="Rekod dikunci (Final)">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                @endif
                                @endhasanyrole

                                {{-- Unlock --}}
                                @hasanyrole('Guru Besar|Super Admin')
                                @if($isFinal)
                                <form method="POST" action="{{ route('achievements.unlock', $rec->id) }}"
                                      data-confirm="Buka semula rekod {{ $rec->student->name ?? '' }} sebagai Draf?">
                                    @csrf
                                    <button type="submit"
                                            class="p-1.5 text-orange-500 hover:bg-orange-50 rounded-lg transition-colors"
                                            title="Buka Semula (Draf)">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                @endhasanyrole

                                {{-- PDF --}}
                                <button type="button"
                                        onclick="openPdfBlob(this, '{{ route('achievements.pdf', $rec->id) }}')"
                                        class="p-1.5 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                        title="Cetak PDF">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">Tiada rekod pencapaian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $records->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
