@extends('layout-fb.layout')

@section('content')
<style>
    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
</style>

<div class="p-4 md:p-6">

    {{-- Header Profil --}}
    <div class="flex items-start gap-4 mb-6 flex-wrap">
        {{-- Avatar --}}
        @if($student->profile_picture)
            <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="{{ $student->name }}"
                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-100 dark:border-gray-700 flex-shrink-0">
        @else
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-800 to-blue-600 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                {{ strtoupper(mb_substr($student->name, 0, 1)) }}
            </div>
        @endif

        <div class="flex-grow">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $student->name }}</h1>
            @if($student->jawi_name)
            <div dir="rtl" class="text-gray-500 dark:text-gray-400 mt-0.5" style="font-family:'Lateef',serif;font-size:1.1em;">
                {{ $student->jawi_name }}
            </div>
            @endif
            <div class="flex flex-wrap gap-2 mt-2">
                <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">{{ $student->school->name ?? '—' }}</span>
                <span class="px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-full">{{ $student->kafaClass->display_name ?? '—' }}</span>
                @php $statusActive = ($student->status ?? 'Aktif') === 'Aktif'; @endphp
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $statusActive ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $student->status ?? 'Aktif' }}</span>
            </div>
        </div>

        <a href="{{ route('parent.dashboard') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Tab Nav --}}
    <div class="flex gap-1 mb-5 border-b border-gray-200 dark:border-gray-700">
        @foreach([
            ['id' => 'info',  'label' => 'Maklumat & Kehadiran'],
            ['id' => 'exam',  'label' => 'Prestasi Akademik'],
            ['id' => 'cert',  'label' => 'Sijil Pencapaian' . ($certificates->isNotEmpty() ? ' (' . $certificates->count() . ')' : '')],
        ] as $tab)
        <button id="tab-{{ $tab['id'] }}" type="button"
                onclick="switchTab('{{ $tab['id'] }}')"
                class="px-4 py-2.5 text-sm font-medium rounded-t-lg transition-colors border-b-2 -mb-px">
            {{ $tab['label'] }}
        </button>
        @endforeach
    </div>

    {{-- TAB 1: Maklumat & Kehadiran --}}
    <div id="panel-info">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            {{-- Maklumat Peribadi --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Maklumat Peribadi</h2>
                <div class="space-y-2 text-sm">
                    @foreach([
                        ['label'=>'No. MyKid',   'val'=>$student->mykid],
                        ['label'=>'Tarikh Lahir','val'=>$student->dob ? \Carbon\Carbon::parse($student->dob)->format('d/m/Y') : '—'],
                        ['label'=>'Jantina',     'val'=>$student->gender ?? '—'],
                        ['label'=>'Bangsa',      'val'=>$student->race ?? '—'],
                        ['label'=>'Sekolah',     'val'=>$student->school->name ?? '—'],
                        ['label'=>'Kelas',       'val'=>$student->kafaClass->display_name ?? '—'],
                    ] as $row)
                    <div class="flex">
                        <span class="w-32 text-gray-500 dark:text-gray-400 flex-shrink-0">{{ $row['label'] }}</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $row['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Ringkasan Kehadiran --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Ringkasan Kehadiran {{ $year }}</h2>
                @if($attendanceTotals['total'] === 0)
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tiada rekod kehadiran untuk tahun ini.</p>
                @else
                <div class="grid grid-cols-2 gap-3">
                    @foreach([
                        ['label'=>'Hadir',       'val'=>$attendanceTotals['hadir'],       'color'=>'green'],
                        ['label'=>'Lewat',       'val'=>$attendanceTotals['lewat'],       'color'=>'yellow'],
                        ['label'=>'Tidak Hadir', 'val'=>$attendanceTotals['tidak_hadir'], 'color'=>'red'],
                        ['label'=>'Cuti Sakit',  'val'=>$attendanceTotals['cuti_sakit'],  'color'=>'gray'],
                    ] as $item)
                    @php $colorMap = ['green'=>'text-green-600 dark:text-green-400','yellow'=>'text-yellow-600 dark:text-yellow-400','red'=>'text-red-600 dark:text-red-400','gray'=>'text-gray-600 dark:text-gray-400']; @endphp
                    <div class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                        <div class="text-2xl font-bold {{ $colorMap[$item['color']] }}">{{ $item['val'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $item['label'] }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        @if(count($months) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pecahan Kehadiran Bulanan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                        <tr>
                            <th class="px-4 py-2.5 text-left">Bulan</th>
                            <th class="px-4 py-2.5 text-center">Hadir</th>
                            <th class="px-4 py-2.5 text-center">Lewat</th>
                            <th class="px-4 py-2.5 text-center">Tidak Hadir</th>
                            <th class="px-4 py-2.5 text-center">Cuti Sakit</th>
                            <th class="px-4 py-2.5 text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($months as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $row['label'] }}</td>
                            <td class="px-4 py-2.5 text-center"><span class="px-1.5 py-0.5 text-xs bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">{{ $row['hadir'] }}</span></td>
                            <td class="px-4 py-2.5 text-center"><span class="px-1.5 py-0.5 text-xs bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">{{ $row['lewat'] }}</span></td>
                            <td class="px-4 py-2.5 text-center"><span class="px-1.5 py-0.5 text-xs bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full">{{ $row['tidak_hadir'] }}</span></td>
                            <td class="px-4 py-2.5 text-center"><span class="px-1.5 py-0.5 text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 rounded-full">{{ $row['cuti_sakit'] }}</span></td>
                            <td class="px-4 py-2.5 text-center text-gray-700 dark:text-gray-300">{{ $row['total'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    {{-- TAB 2: Prestasi Akademik --}}
    <div id="panel-exam" class="hidden">
        @if($examResultGroups->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-10 text-center">
            <p class="text-gray-400 text-sm">Tiada rekod keputusan peperiksaan.</p>
        </div>
        @else
        @foreach($examResultGroups as $examId => $results)
        @php $exam = $examsById[$examId] ?? null; $avg = round($results->avg('marks'), 1); $avgGrade = $avg >= 80 ? 'A' : ($avg >= 60 ? 'B' : ($avg >= 50 ? 'C' : ($avg >= 40 ? 'D' : 'E'))); $gc = match($avgGrade) { 'A' => 'bg-green-100 text-green-700', 'B' => 'bg-blue-100 text-blue-700', 'C' => 'bg-yellow-100 text-yellow-700', 'D' => 'bg-gray-100 text-gray-600', default => 'bg-red-100 text-red-700' }; @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-4">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $exam?->name ?? 'Peperiksaan' }} <span class="text-gray-400 font-normal">({{ $exam?->year ?? '' }})</span></h2>
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $gc }}">Purata: {{ $avg }} ({{ $avgGrade }})</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                        <tr>
                            <th class="px-4 py-2.5 text-left">No</th>
                            <th class="px-4 py-2.5 text-left">Mata Pelajaran</th>
                            <th class="px-4 py-2.5 text-center">Markah</th>
                            <th class="px-4 py-2.5 text-center">Gred</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($results as $i => $r)
                        @php $rg = match($r->grade ?? 'E') { 'A' => 'bg-green-100 text-green-700', 'B' => 'bg-blue-100 text-blue-700', 'C' => 'bg-yellow-100 text-yellow-700', 'D' => 'bg-gray-100 text-gray-600', default => 'bg-red-100 text-red-700' }; @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-2.5 text-gray-900 dark:text-white">{{ $r->subject->name ?? '—' }}</td>
                            <td class="px-4 py-2.5 text-center font-mono font-semibold text-gray-900 dark:text-white">{{ $r->marks ?? '—' }}</td>
                            <td class="px-4 py-2.5 text-center"><span class="px-2 py-0.5 text-xs font-bold rounded {{ $rg }}">{{ $r->grade ?? '—' }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    {{-- TAB 3: Sijil Pencapaian --}}
    <div id="panel-cert" class="hidden">
        @if($certificates->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-10 text-center">
            <p class="text-gray-400 text-sm">Tiada sijil digital dikeluarkan buat masa ini.</p>
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Nama Sijil</th>
                            <th class="px-4 py-3 text-left">Program / Peperiksaan</th>
                            <th class="px-4 py-3 text-left">Tarikh</th>
                            <th class="px-4 py-3 text-left">No. Rujukan</th>
                            <th class="px-4 py-3 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($certificates as $i => $cert)
                        <tr id="cert-row-{{ $cert->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $cert->template->name ?? '—' }}</td>
                            <td class="px-4 py-2.5 text-gray-600 dark:text-gray-300">{{ $cert->activity->name ?? $cert->exam->name ?? '—' }}</td>
                            <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $cert->issue_date?->format('d/m/Y') ?? '—' }}</td>
                            <td class="px-4 py-2.5 text-xs font-mono text-gray-500 dark:text-gray-400">{{ $cert->reference_no }}</td>
                            <td class="px-4 py-2.5 text-center">
                                <button type="button" onclick="downloadCert(this, {{ $cert->id }})"
                                        title="Pratonton / Muat Turun PDF"
                                        class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
const certUrls = {
    @foreach($certificates as $cert)
    {{ $cert->id }}: '{{ route("certificates.single.pdf", $cert) }}',
    @endforeach
};

function downloadCert(btn, certId) {
    var url = certUrls[certId];
    if (!url) return;
    btn.disabled = true;
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.pdf) renderPdfBase64(data.pdf);
        else alert('Ralat menjana sijil.');
    })
    .catch(() => alert('Ralat sambungan.'))
    .finally(() => { btn.disabled = false; });
}

function switchTab(tab) {
    ['info','exam','cert'].forEach(function(t) {
        document.getElementById('panel-' + t).classList.add('hidden');
        var tb = document.getElementById('tab-' + t);
        tb.classList.remove('border-blue-600','text-blue-600','dark:text-blue-400','dark:border-blue-400');
        tb.classList.add('border-transparent','text-gray-500','dark:text-gray-400');
    });
    document.getElementById('panel-' + tab).classList.remove('hidden');
    var active = document.getElementById('tab-' + tab);
    active.classList.remove('border-transparent','text-gray-500','dark:text-gray-400');
    active.classList.add('border-blue-600','text-blue-600','dark:text-blue-400','dark:border-blue-400');
}
switchTab('info');
</script>
@endsection
