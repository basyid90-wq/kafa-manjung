@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <style>
        @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
    </style>

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $activity->name }}</h1>
            <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y') }}
                </span>
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    {{ $activity->school->name ?? '—' }}
                </span>
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $attendedStudents->count() }} peserta hadir
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            @hasanyrole('Super Admin|Penyelia KAFA|Guru Besar|Guru KAFA')
            <button type="button" id="btnOpenSijil"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg hover:bg-purple-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                Jana Sijil Pukal
            </button>
            <a href="{{ route('activities.attendance', $activity) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg hover:bg-green-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Kehadiran
            </a>
            @endhasanyrole
            <a href="{{ route('activities.index') }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Photo --}}
    @if($activity->photo_path)
    <div class="mb-5">
        <img src="{{ asset('storage/' . $activity->photo_path) }}" alt="{{ $activity->name }}"
             class="w-full max-h-64 object-cover rounded-xl border border-gray-200 dark:border-gray-700">
    </div>
    @endif

    {{-- Description --}}
    @if($activity->description)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $activity->description }}</p>
    </div>
    @endif

    {{-- Senarai Peserta --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Senarai Peserta</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">No</th>
                    <th class="px-4 py-3 text-left font-medium">Nama Pelajar</th>
                    <th class="px-4 py-3 text-left font-medium">Kelas</th>
                    <th class="px-4 py-3 text-left font-medium">No. Sijil</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($attendedStudents as $i => $student)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $student->name }}</p>
                        @if($student->jawi_name)
                        <p class="text-sm text-gray-500 dark:text-gray-400" dir="rtl" style="font-family:'Lateef',serif;font-size:1em;">{{ $student->jawi_name }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $student->kafaClass->display_name ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $student->certificates->first()?->reference_no ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">
                        Tiada peserta dicatat.
                        <a href="{{ route('activities.attendance', $activity) }}" class="text-blue-600 dark:text-blue-400 font-medium ml-1">Rekod kehadiran dahulu.</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Jana Sijil Pukal --}}
<div id="modalSijil" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Jana Sijil Pukal</h3>
            <button onclick="document.getElementById('modalSijil').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-5 py-4">
            @if($templates->isEmpty())
            <div class="text-center py-4">
                <svg class="w-10 h-10 text-yellow-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="text-sm text-gray-600 dark:text-gray-400">Tiada templat sijil tersedia.<br>
                    <a href="{{ route('certificates.templates.create') }}" class="text-blue-600 dark:text-blue-400 font-medium">Buat templat baharu</a>
                </p>
            </div>
            @else
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                Sijil akan dijana bagi <strong>{{ $attendedStudents->count() }} peserta</strong> yang hadir.
            </p>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Templat Sijil</label>
                <select id="selectTemplate"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    @foreach($templates as $t)
                    <option value="{{ $t->id }}">{{ $t->name }} ({{ ucfirst($t->level) }})</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        <div class="flex justify-end gap-2 px-5 py-4 border-t border-gray-100 dark:border-gray-700">
            <button onclick="document.getElementById('modalSijil').classList.add('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Batal
            </button>
            @if($templates->isNotEmpty() && $attendedStudents->isNotEmpty())
            <button type="button" id="btnJanaSijil"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                Jana &amp; Pratonton PDF
            </button>
            @endif
        </div>
    </div>
</div>

<script>
document.getElementById('btnOpenSijil')?.addEventListener('click', function() {
    document.getElementById('modalSijil').classList.remove('hidden');
});

document.addEventListener('DOMContentLoaded', function () {
    var btnJana = document.getElementById('btnJanaSijil');
    if (!btnJana) return;

    btnJana.addEventListener('click', function () {
        var templateId = document.getElementById('selectTemplate').value;
        if (!templateId) return;

        btnJana.disabled = true;
        btnJana.textContent = 'Menjana...';

        fetch('{{ route("certificates.bulk.generate", $activity) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ certificate_template_id: templateId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.pdf) {
                renderPdfBase64(data.pdf);
            } else {
                alert('Ralat menjana sijil.');
            }
        })
        .catch(() => alert('Ralat sambungan.'))
        .finally(() => {
            btnJana.disabled = false;
            btnJana.textContent = 'Jana & Pratonton PDF';
        });
    });
});
</script>
@endsection
