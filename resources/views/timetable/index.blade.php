@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Jadual Waktu Kelas</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Jadual pengajaran mengikut kelas dan hari</p>
        </div>
        <div class="flex items-center gap-2">
            @if($classId)
            <button type="button"
                    onclick="openPdfBlob(this, '{{ route('timetable.pdf', $classId) }}')"
                    class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Jadual
            </button>
            @endif
            @role('Guru Besar')
            <a href="{{ route('time_slots.index') }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                Set Waktu Mengajar
            </a>
            @endrole
            @role('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
            <a href="{{ route('timetable.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Kemaskini Jadual
            </a>
            @endrole
        </div>
    </div>

    {{-- ── Filter ── --}}
    <form action="{{ route('timetable.index') }}" method="GET" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
        <div class="flex flex-wrap gap-3">
            @role('Penyelia KAFA')
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Pilih Sekolah</label>
                <select name="school_id" onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ $schoolId == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            @endrole
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Pilih Kelas</label>
                <select name="kafa_class_id" onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">— Pilih Kelas —</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>{{ $class->display_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- ── Timetable Grid ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left w-36">Slot / Masa</th>
                        @foreach($days as $day)
                        <th class="px-4 py-3">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($slots as $slot)
                    <tr class="bg-white dark:bg-gray-800">
                        <td class="px-4 py-3 text-left bg-gray-50 dark:bg-gray-700">
                            <p class="font-semibold text-gray-800 dark:text-gray-200 text-xs">{{ $slot->name }}</p>
                            <p class="text-[10px] text-gray-400">
                                {{ date('h:i A', strtotime($slot->start_time)) }} – {{ date('h:i A', strtotime($slot->end_time)) }}
                            </p>
                        </td>
                        @foreach($days as $day)
                        <td class="px-3 py-2 align-middle" style="min-width:130px;">
                            @if(isset($timetableData[$slot->id][$day]))
                                @php $item = $timetableData[$slot->id][$day]; @endphp
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg px-2 py-1.5 text-center">
                                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300 leading-tight">{{ $item->subject->name }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5 leading-tight">{{ $item->teacher->name }}</p>
                                    @role('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                    <div class="flex items-center justify-center gap-1 mt-1.5">
                                        <a href="{{ route('timetable.edit', $item->id) }}"
                                           class="p-0.5 text-blue-500 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded transition-colors"
                                           title="Edit">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('timetable.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Padam jadual {{ addslashes($item->subject->name) }} ({{ $day }})?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="p-0.5 text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded transition-colors"
                                                    title="Padam">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    @endrole
                                </div>
                            @else
                                <span class="text-gray-300 dark:text-gray-600">—</span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($days) + 1 }}" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada slot masa ditetapkan. Sila hubungi Guru Besar untuk menetapkan slot masa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.onload = function() {
        if (localStorage.getItem('timetable_scroll')) {
            window.scrollTo(0, localStorage.getItem('timetable_scroll'));
        }
    };
    window.onscroll = function() {
        localStorage.setItem('timetable_scroll', window.scrollY);
    };
</script>
@endpush
@endsection
