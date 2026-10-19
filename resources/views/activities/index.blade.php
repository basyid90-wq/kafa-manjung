@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Aktiviti & Program Sekolah</h1>
            <p class="ek-page-sub mt-1">Senarai aktiviti dan program yang telah dianjurkan</p>
        </div>
        @role('Super Admin|Guru Besar|Guru KAFA')
        <a href="{{ route('activities.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Daftar Aktiviti Baru
        </a>
        @endrole
    </div>

    {{-- ── Activity Cards Grid ── --}}
    @if($activities->isEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
        <div class="flex flex-col items-center gap-2 text-gray-400">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm">Tiada aktiviti didaftarkan.</p>
        </div>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($activities as $activity)
        @php
            $tahapColors = [
                'sekolah'  => 'bg-blue-100 text-blue-700',
                'daerah'   => 'bg-purple-100 text-purple-700',
                'negeri'   => 'bg-orange-100 text-orange-700',
                'kebangsaan' => 'bg-red-100 text-red-700',
            ];
            $badgeClass = $tahapColors[$activity->tahap ?? 'sekolah'] ?? 'bg-gray-100 text-gray-600';
        @endphp
        <div class="ek-table-wrap hover:shadow-md transition-shadow">
            {{-- Photo --}}
            @if($activity->photo_path)
                <img src="{{ asset('storage/' . $activity->photo_path) }}" alt="{{ $activity->name }}"
                     class="w-full h-44 object-cover">
            @else
                <div class="w-full h-44 bg-gray-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <div class="p-4">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">{{ $activity->name }}</h3>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium shrink-0 {{ $badgeClass }}">
                        {{ $activity->tahap_label }}
                    </span>
                </div>

                <div class="flex items-center gap-3 text-xs text-gray-500 mb-2">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $activity->students_count ?? $activity->students()->count() }} Peserta
                    </span>
                </div>

                <p class="text-xs text-gray-500 leading-relaxed mb-4 line-clamp-2">
                    {{ Str::limit($activity->description, 80) }}
                </p>

                <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                    @role('Super Admin|Guru KAFA|Guru Besar')
                    <a href="{{ route('activities.show', $activity) }}"
                       class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                       title="Lihat Butiran & Sijil">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </a>
                    @endrole

                    @role('Super Admin|Guru KAFA|Guru Besar')
                    <a href="{{ route('activities.attendance', $activity) }}"
                       class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                       title="Penandaan Kehadiran">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </a>
                    <a href="{{ route('activities.edit', $activity) }}"
                       class="p-1.5 text-orange-500 hover:bg-orange-50 rounded-lg transition-colors"
                       title="Edit">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    @endrole
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-5">
        {{ $activities->links() }}
    </div>
    @endif
</div>
@endsection
