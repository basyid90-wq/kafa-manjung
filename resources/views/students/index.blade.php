@extends('layout-fb.layout')

@section('title', 'Pengurusan Murid')

@section('content')

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pengurusan Murid</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                Jumlah: <strong class="text-gray-700 dark:text-gray-300">{{ $students->total() }}</strong> murid
                @if($filterTahun) · Tahun <strong>{{ $filterTahun }}</strong>@endif
                @if($search) · carian "<strong>{{ $search }}</strong>"@endif
            </p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <button type="button" id="btnBulkDelete" disabled
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Padam Terpilih
            </button>
            <button type="button" data-modal-target="importModal" data-modal-toggle="importModal"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                Import SIMPENI
            </button>
            <a href="{{ route('students.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Murid
            </a>
        </div>
    </div>

    {{-- ── Filter Panel ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-4">
        <form method="GET" id="filterForm" action="{{ route('students.index') }}">
            @if($filterTahun)
                <input type="hidden" name="tahun" value="{{ $filterTahun }}">
            @endif
            <div class="flex flex-wrap gap-3">

                {{-- Daerah --}}
                @if(in_array($authRole, ['Super Admin', 'Pentadbir']) && $districts->isNotEmpty())
                <div class="min-w-[140px]">
                    <select name="district_id" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Daerah</option>
                        @foreach($districts as $d)
                            <option value="{{ $d->id }}" {{ $filterDistrict == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Sekolah --}}
                @if(in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']) && $schools->isNotEmpty())
                <div class="min-w-[180px]">
                    <select name="school_id" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Sekolah</option>
                        @foreach($schools as $s)
                            <option value="{{ $s->id }}" {{ $filterSchool == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Kelas --}}
                <div class="min-w-[150px]">
                    <select name="class_id" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Kelas</option>
                        <option value="none" {{ request('class_id') === 'none' ? 'selected' : '' }}>— Tiada Kelas</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Search --}}
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}"
                               class="block w-full ps-10 p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Cari nama / MyKid...">
                    </div>
                </div>

                <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                    Cari
                </button>

                @if($search || $filterDistrict || $filterSchool || request('class_id') || request('show_archive') || $filterTahun)
                <a href="{{ route('students.index') }}"
                   class="px-3 py-2.5 text-sm text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 flex items-center" title="Reset penapis">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>

            {{-- Archive toggle --}}
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="show_archive" value="1"
                           id="showArchive" {{ request('show_archive') ? 'checked' : '' }}
                           onchange="this.form.submit()"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Papar Arkib (Berhenti / Pindah / Umur &gt; 13 Tahun)</span>
                </label>
            </div>
        </form>
    </div>

    {{-- ── Tab Tahun ── --}}
    @php
        $baseParams = array_filter([
            'district_id'  => $filterDistrict,
            'school_id'    => $filterSchool,
            'class_id'     => request('class_id'),
            'search'       => $search,
            'show_archive' => request('show_archive') ? '1' : null,
        ]);
    @endphp
    <div class="flex flex-wrap gap-2 mb-4">
        <a href="{{ route('students.index', $baseParams) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg border
               {{ !$filterTahun ? 'bg-blue-700 text-white border-blue-700' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600' }}">
            Semua
            <span class="inline-flex items-center justify-center px-1.5 h-5 text-xs rounded-full
                {{ !$filterTahun ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                {{ $tahunCounts['semua'] }}
            </span>
        </a>
        @for($t = 1; $t <= 6; $t++)
        <a href="{{ route('students.index', array_merge($baseParams, ['tahun' => $t])) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg border
               {{ $filterTahun == $t ? 'bg-blue-700 text-white border-blue-700' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600' }}">
            Tahun {{ $t }}
            <span class="inline-flex items-center justify-center px-1.5 h-5 text-xs rounded-full
                {{ $filterTahun == $t ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                {{ $tahunCounts[$t] }}
            </span>
        </a>
        @endfor
    </div>

    {{-- ── Table ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

        <form id="bulkDeleteForm" action="{{ route('students.bulk-delete') }}" method="POST">
            @csrf
            <input type="hidden" name="page" value="{{ $students->currentPage() }}">

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox" id="selectAll"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            </th>
                            <th class="px-4 py-3 w-8">No</th>
                            <th class="px-4 py-3">Nama</th>
                            @if(in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']))
                            <th class="px-4 py-3">Sekolah</th>
                            @endif
                            <th class="px-4 py-3">Jantina</th>
                            <th class="px-4 py-3">Umur</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3 text-center w-24">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($students as $student)
                        <tr id="row-{{ $student->id }}" class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                       class="student-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 text-gray-400">{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0
                                        {{ $student->gender === 'L' ? 'bg-blue-500' : 'bg-pink-500' }}">
                                        {{ strtoupper(mb_substr($student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $student->mykid }}</p>
                                    </div>
                                </div>
                            </td>
                            @if(in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']))
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $student->school->name ?? '—' }}
                                </span>
                            </td>
                            @endif
                            <td class="px-4 py-3">
                                @if($student->gender === 'L')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">Lelaki</span>
                                @elseif($student->gender === 'P')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400">Perempuan</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $student->standard_age ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300 text-sm">{{ $student->kafaClass?->display_name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('students.show', $student) }}" title="Lihat"
                                       class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('students.edit', array_merge(['student' => $student->id], request()->query())) }}" title="Edit"
                                       class="p-1.5 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" title="Padam"
                                            data-delete-url="{{ route('students.destroy', $student) }}"
                                            data-delete-name="{{ $student->name }}"
                                            onclick="confirmSingleDelete(this)"
                                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']) ? 8 : 7 }}"
                                class="px-4 py-10 text-center text-gray-400">
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                @if($search)
                                    Tiada murid sepadan dengan carian "<strong>{{ $search }}</strong>".
                                @else
                                    Tiada rekod murid ditemui.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Papar <strong class="text-gray-900 dark:text-white">{{ $students->firstItem() }}–{{ $students->lastItem() }}</strong>
                daripada <strong class="text-gray-900 dark:text-white">{{ $students->total() }}</strong> murid
            </p>
            {{ $students->links() }}
        </div>
    </div>

    {{-- Hidden form for single delete --}}
    <form id="singleDeleteForm" action="" method="POST" class="hidden">
        @csrf @method('DELETE')
        <input type="hidden" name="page" value="{{ $students->currentPage() }}">
    </form>

    {{-- ── Import Modal (Flowbite) ── --}}
    <div id="importModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-xl shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-600 rounded-t-xl">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Import Data SIMPENI (Excel)</h3>
                    <button type="button" data-modal-hide="importModal"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>
                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="p-4 space-y-4">
                        <div class="p-3 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
                            Fail mesti dalam format SIMPENI JAKIM. Lajur yang dikesan: <strong>Nama Pelajar, Kp Baru, Kelas, Tarikh Lahir, Jantina</strong>.
                        </div>
                        @if($importSchools->isNotEmpty())
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sekolah <span class="text-red-500">*</span></label>
                            <select name="school_id" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach($importSchools as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_upload">Fail Excel (.xls, .xlsx, .csv) <span class="text-red-500">*</span></label>
                            <input type="file" name="file" id="file_upload" required accept=".xls,.xlsx,.csv"
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                   aria-describedby="file_upload_help">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_upload_help">XLS, XLSX atau CSV (MAX. 10MB).</p>
                        </div>
                    </div>
                    <div class="flex gap-2 p-4 border-t border-gray-200 dark:border-gray-600">
                        <button type="button" data-modal-hide="importModal"
                                class="flex-1 py-2 px-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                        <button type="submit" id="btnImportSubmit"
                                class="flex-1 py-2 px-4 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                            Mula Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll      = document.getElementById('selectAll');
    const btnBulkDelete  = document.getElementById('btnBulkDelete');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');

    function updateBulkBtn() {
        const count = document.querySelectorAll('.student-checkbox:checked').length;
        btnBulkDelete.disabled = count === 0;
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = selectAll.checked);
            updateBulkBtn();
        });
    }

    document.querySelectorAll('.student-checkbox').forEach(cb => cb.addEventListener('change', updateBulkBtn));

    if (btnBulkDelete) {
        btnBulkDelete.addEventListener('click', function () {
            const count = document.querySelectorAll('.student-checkbox:checked').length;
            if (confirm(`Padam ${count} rekod murid secara kekal?`)) bulkDeleteForm.submit();
        });
    }

    // Reopen import modal if validation error
    @if($errors->has('file') || $errors->has('school_id'))
    const importModalEl = document.getElementById('importModal');
    if (importModalEl && typeof FlowbiteInstances !== 'undefined') {
        const modal = FlowbiteInstances.getInstance('Modal', 'importModal');
        if (modal) modal.show();
    }
    @endif

    document.getElementById('importForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('btnImportSubmit');
        if (btn) { btn.disabled = true; btn.textContent = 'Sedang Memproses...'; }
    });
});

function confirmSingleDelete(btn) {
    const url  = btn.dataset.deleteUrl;
    const name = btn.dataset.deleteName;
    if (confirm(`Padam rekod "${name}" secara kekal?`)) {
        const form = document.getElementById('singleDeleteForm');
        form.action = url;
        form.submit();
    }
}
</script>
@endpush
