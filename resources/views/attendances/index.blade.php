@extends('layout-fb.layout')

@php
    $dateParts = explode('-', $date);
    $pdfYear  = (int) $dateParts[0];
    $pdfMonth = (int) $dateParts[1];
@endphp

@section('content')
<div class="p-4 md:p-6">

    {{-- ── Header with date filter ── --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Kehadiran Murid</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <form action="{{ route('attendances.index') }}" method="GET" class="flex items-center gap-2">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tarikh:</label>
            <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                   class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>

    @forelse($classes as $c)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">

        {{-- Class Header --}}
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                Kelas: {{ $c->display_name }}
            </h2>
            <div class="flex flex-wrap items-center gap-2">
                @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                <button type="button" onclick="tandaSemua({{ $c->id }})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Semua Hadir
                </button>
                <a href="{{ route('kiosk.index') }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Kiosk Imbasan
                </a>
                <a href="{{ route('students.qr_cards', $c) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5V16M4 16.5V20m0 0h4M4 20v-4"/>
                    </svg>
                    Cetak Kad QR
                </a>
                @endhasanyrole
                @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA')
                <button type="button"
                        data-class-id="{{ $c->id }}"
                        data-class-name="{{ $c->display_name }}"
                        onclick="openKedatanganModal(this)"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Buku Kedatangan
                </button>
                @endhasanyrole
            </div>
        </div>

        {{-- Table --}}
        <form id="class-form-{{ $c->id }}" action="{{ route('attendances.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-5 py-3 w-12">No</th>
                            <th class="px-5 py-3">No. MyKid</th>
                            <th class="px-5 py-3">Nama Murid</th>
                            <th class="px-5 py-3">Status Kehadiran</th>
                            @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                            <th class="px-5 py-3 text-center w-20">Cuti</th>
                            @endhasanyrole
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($c->students as $i => $student)
                        @php
                            $attendance = $student->attendances->first();
                            $status = $attendance ? $attendance->status : null;
                        @endphp
                        <tr id="row-{{ $student->id }}" class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <td class="px-5 py-2.5 text-gray-400 text-xs">{{ $i + 1 }}</td>
                            <td class="px-5 py-2.5 font-mono text-xs text-gray-600 dark:text-gray-400">{{ $student->mykid }}</td>
                            <td class="px-5 py-2.5 font-medium text-gray-900 dark:text-white text-sm">{{ $student->name }}</td>
                            <td class="px-5 py-2.5">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach([
                                        ['Hadir',       'Hadir',      'green'],
                                        ['Lewat',       'Lewat',      'yellow'],
                                        ['Tidak Hadir', 'T.Hadir',    'red'],
                                        ['Cuti Sakit',  'Cuti Sakit', 'gray'],
                                    ] as [$val, $label, $color])
                                    <label class="cursor-pointer">
                                        <input type="radio"
                                               name="attendances[{{ $student->id }}]"
                                               value="{{ $val }}"
                                               {{ $status === $val ? 'checked' : '' }}
                                               class="peer sr-only">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border transition-colors
                                            peer-checked:bg-{{ $color }}-600 peer-checked:text-white peer-checked:border-{{ $color }}-600
                                            bg-white dark:bg-gray-800 text-{{ $color }}-700 dark:text-{{ $color }}-400 border-{{ $color }}-300 dark:border-{{ $color }}-700
                                            hover:bg-{{ $color }}-50 dark:hover:bg-{{ $color }}-900/20">
                                            {{ $label }}
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </td>
                            @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                            <td class="px-5 py-2.5 text-center">
                                <button type="button"
                                        data-student-id="{{ $student->id }}"
                                        data-student-name="{{ $student->name }}"
                                        onclick="openCutiModal(this)"
                                        class="p-1.5 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                        title="Daftar Cuti Berjadual">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </td>
                            @endhasanyrole
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">Tiada murid dalam kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($c->students->count() > 0)
            <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Simpan Kehadiran
                </button>
            </div>
            @endif
        </form>
    </div>

    @empty
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-5 text-sm text-yellow-700 dark:text-yellow-400">
        Anda belum ditugaskan sebagai Guru Kelas bagi mana-mana kelas.
    </div>
    @endforelse

</div>

{{-- ── Modal: Buku Kedatangan (Flowbite CRUD Modal) ── --}}
<div id="kedatanganModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Jana Buku Kedatangan (PDF Jawi)
                </h3>
                <button type="button" onclick="closeKedatanganModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <p id="kdClassName" class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-4"></p>
                <div class="grid gap-4 mb-4 grid-cols-1">
                    <div>
                        <label for="kdMonthYear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Bulan &amp; Tahun <span class="text-red-500">*</span>
                        </label>
                        <input type="month" id="kdMonthYear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <div>
                        <label for="kdTotalDays" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Jumlah Hari Persekolahan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="kdTotalDays" min="1" max="31" placeholder="Contoh: 20" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Masukkan bilangan hari sekolah aktif (tidak termasuk cuti).</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" onclick="closeKedatanganModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Batal
                    </button>
                    <button id="kdSubmitBtn" type="button" onclick="submitKedatanganPdf()" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Jana PDF (Jawi)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Modal: Cuti Berjadual ── --}}
<div id="cutiModal" tabindex="-1" aria-hidden="true"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Daftar Cuti Berjadual</h3>
            <button onclick="document.getElementById('cutiModal').classList.add('hidden')"
                    class="p-1.5 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <p id="cutiStudentName" class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-4"></p>
        <form id="cutiForm" action="{{ route('attendances.bulk_leave') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" id="cutiStudentId" name="student_id">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tarikh Mula <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="start_date" id="cutiStart" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tarikh Tamat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="end_date" id="cutiEnd" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="Tidak Hadir">Tidak Hadir</option>
                    <option value="Cuti Sakit">Cuti Sakit</option>
                </select>
            </div>
            <p class="text-xs text-gray-400">Sabtu &amp; Ahad akan diabaikan secara automatik.</p>
        </form>
        <div class="flex justify-end gap-2 mt-5">
            <button onclick="document.getElementById('cutiModal').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                Batal
            </button>
            <button type="submit" form="cutiForm"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Cuti
            </button>
        </div>
    </div>
</div>

<script>
let kdClassId = null;
const kdBaseUrl = '{{ url("attendances") }}';

function openKedatanganModal(btn) {
    kdClassId = btn.dataset.classId;
    document.getElementById('kdClassName').textContent = 'Kelas: ' + btn.dataset.className;
    const now = new Date();
    const mm  = String(now.getMonth() + 1).padStart(2, '0');
    document.getElementById('kdMonthYear').value  = now.getFullYear() + '-' + mm;
    document.getElementById('kdTotalDays').value   = '';
    const modal = document.getElementById('kedatanganModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeKedatanganModal() {
    const modal = document.getElementById('kedatanganModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function submitKedatanganPdf() {
    const monthYear = document.getElementById('kdMonthYear').value;
    const totalDays = document.getElementById('kdTotalDays').value;
    if (!monthYear || !totalDays || parseInt(totalDays) < 1) {
        alert('Sila lengkapkan semua maklumat yang diperlukan.');
        return;
    }
    const [year, month] = monthYear.split('-');
    const url = `${kdBaseUrl}/${kdClassId}/pdf?month=${parseInt(month)}&year=${year}&total_days=${totalDays}`;
    openPdfBlob(document.getElementById('kdSubmitBtn'), url);
}

function tandaSemua(classId) {
    document.getElementById('class-form-' + classId)
            .querySelectorAll('input[type="radio"][value="Hadir"]')
            .forEach(r => r.checked = true);
}

function openCutiModal(btn) {
    document.getElementById('cutiStudentId').value        = btn.dataset.studentId;
    document.getElementById('cutiStudentName').textContent = btn.dataset.studentName;
    const today = new Date().toISOString().slice(0, 10);
    document.getElementById('cutiStart').value = today;
    document.getElementById('cutiEnd').value   = today;
    document.getElementById('cutiModal').classList.remove('hidden');
}

// Close modals on backdrop click
document.getElementById('kedatanganModal').addEventListener('click', function(e) {
    if (e.target === this) closeKedatanganModal();
});

document.getElementById('cutiModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.add('hidden');
});
</script>
@endsection
