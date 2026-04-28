@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
@endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9" id="student-list-section">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Pengurusan Murid</h4>
                            <div class="d-flex gap-2">
                                <button type="button" id="btnBulkDelete" class="rbt-btn btn-sm btn-gradient btn-gradient-danger" disabled>
                                    <i class="feather-trash-2 me-1"></i> Padam Terpilih
                                </button>
                                <button type="button" class="rbt-btn btn-sm btn-border-gradient" data-bs-toggle="modal" data-bs-target="#importModal">
                                    <i class="feather-file-plus me-1"></i> Import SIMPENI
                                </button>
                                <a href="{{ route('students.create') }}" class="rbt-btn btn-sm hover-icon-reverse">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Tambah Murid</span>
                                        <span class="btn-icon"><i class="feather-plus"></i></span>
                                        <span class="btn-icon"><i class="feather-plus"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <!-- Search & Filter Bar -->
                        <div class="rbt-search-filter mb--30">
                            <form action="{{ route('students.index') }}" method="GET" class="row g-3">
                                <div class="col-lg-5 col-md-6 col-12">
                                    <div class="rbt-form-group">
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / MyKid...">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="rbt-form-group">
                                        <select name="class_id" class="rbt-big-select">
                                            <option value="">-- Semua Kelas --</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->display_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-12 d-flex gap-2">
                                    <button type="submit" class="rbt-btn btn-sm btn-gradient w-100">Cari/Tapis</button>
                                    <a href="{{ route('students.index') }}" class="rbt-btn btn-sm btn-border w-100 text-center">Reset</a>
                                </div>
                                <div class="col-12 mt--10">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="show_archive" value="1" id="showArchive" {{ request('show_archive') ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label" for="showArchive" style="font-size: 14px; cursor: pointer;">Papar Arkib (Berhenti/Pindah/Umur > 13 Tahun)</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Bulk delete form wraps the table ONLY — no nested forms inside --}}
                        <form id="bulkDeleteForm" action="{{ route('students.bulk-delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="page" value="{{ $students->currentPage() }}">

                            <div class="table-responsive">
                                <table class="rbt-table table table-borderless">
                                    <thead>
                                        <tr>
                                            <th style="width:50px; text-align:center; vertical-align:middle;">
                                                <input type="checkbox" id="selectAll" class="form-check-input"
                                                       style="width:20px; height:20px; cursor:pointer; display:inline-block !important; visibility:visible !important; opacity:1 !important; position:relative !important; appearance:auto !important; -webkit-appearance:checkbox !important;">
                                            </th>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jantina</th>
                                            <th>Umur</th>
                                            <th>Kelas</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($students as $student)
                                        <tr id="row-{{ $student->id }}">
                                            <td style="text-align:center; vertical-align:middle;">
                                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                       class="student-checkbox form-check-input"
                                                       style="width:20px; height:20px; cursor:pointer; display:inline-block !important; visibility:visible !important; opacity:1 !important; position:relative !important; appearance:auto !important; -webkit-appearance:checkbox !important;">
                                            </td>
                                            <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                                            <td>{{ $student->name }}<br><small class="text-muted">{{ $student->mykid }}</small></td>
                                            <td>{{ $student->gender == 'L' ? 'Lelaki' : 'Perempuan' }}</td>
                                            <td>{{ $student->standard_age }} Tahun</td>
                                            <td>{{ $student->kafaClass?->name ?? '—' }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ Route::has('students.show') ? route('students.show', $student) : '#' }}"
                                                       class="rbt-btn btn-sm btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                       style="width:35px; height:35px; color:#007bff;" title="Lihat">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="{{ route('students.edit', array_merge(['student' => $student->id], request()->query())) }}"
                                                       class="rbt-btn btn-sm btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                       style="width:35px; height:35px; color:#28a745;" title="Edit">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    {{-- Butang padam individu — tiada form nested; guna JS --}}
                                                    <button type="button"
                                                            data-delete-url="{{ route('students.destroy', $student) }}"
                                                            data-delete-name="{{ $student->name }}"
                                                            onclick="confirmSingleDelete(this)"
                                                            class="rbt-btn btn-sm btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                            style="width:35px; height:35px; color:#dc3545;" title="Padam">
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tiada rekod murid ditemui.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        {{-- Borang tunggal tersembunyi untuk padam individu (di luar bulk form) --}}
                        <form id="singleDeleteForm" action="" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="page" value="{{ $students->currentPage() }}">
                        </form>

                        <!-- Pagination -->
                        <div class="row mt--30">
                            <div class="col-lg-12">
                                {{ $students->links() }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Import Modal --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data SIMPENI (Excel)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info" style="font-size:0.88em;">
                        <i class="feather-info me-2"></i>
                        Fail mesti dalam format SIMPENI JAKIM. Lajur yang dikesan secara automatik:
                        <strong>Nama Pelajar, Kp Baru, Kelas, Tarikh Lahir, Jantina</strong> dan lain-lain.
                    </div>

                    @if($importSchools->isNotEmpty())
                    <div class="rbt-form-group">
                        <label for="import_school_id">Sekolah <span class="text-danger">*</span></label>
                        <select name="school_id" id="import_school_id" class="rbt-big-select" required>
                            <option value="">-- Pilih Sekolah --</option>
                            @foreach($importSchools as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="rbt-form-group">
                        <label for="import_file">Pilih Fail Excel (.xls, .xlsx, .csv) <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="import_file" class="form-control"
                               style="height:50px; line-height:35px;" accept=".xls,.xlsx,.csv" required>
                    </div>
                    <p class="small text-muted mt-2">
                        Sistem akan padankan kelas secara automatik berdasarkan nama kelas dalam Excel dengan kelas dalam sistem.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="rbt-btn btn-border-gradient" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnImportSubmit" class="rbt-btn btn-gradient">
                        <i class="feather-upload me-1"></i> Mula Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Re-open import modal if there was a validation error from the import form
@if($errors->has('file') || $errors->has('school_id'))
document.addEventListener('DOMContentLoaded', function () {
    var importModal = new bootstrap.Modal(document.getElementById('importModal'));
    importModal.show();
    @foreach($errors->all() as $error)
    Swal.fire({ icon: 'error', title: 'Ralat Import', text: '{{ $error }}', confirmButtonText: 'OK' });
    @endforeach
});
@endif

document.addEventListener('DOMContentLoaded', function () {
    const selectAll      = document.getElementById('selectAll');
    const checkboxes     = document.querySelectorAll('.student-checkbox');
    const btnBulkDelete  = document.getElementById('btnBulkDelete');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');

    function toggleBulkDeleteButton() {
        const count = document.querySelectorAll('.student-checkbox:checked').length;
        btnBulkDelete.disabled = count === 0;
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            toggleBulkDeleteButton();
        });
    }

    checkboxes.forEach(cb => cb.addEventListener('change', toggleBulkDeleteButton));

    if (btnBulkDelete) {
        btnBulkDelete.addEventListener('click', function () {
            const count = document.querySelectorAll('.student-checkbox:checked').length;
            Swal.fire({
                title: 'Padam Rekod Terpilih?',
                text: `Anda akan memadam ${count} rekod murid secara kekal. Tindakan ini tidak boleh dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Padam Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkDeleteForm.submit();
                }
            });
        });
    }
});

// Import form: show loading state on submit
const importForm = document.getElementById('importForm');
if (importForm) {
    importForm.addEventListener('submit', function () {
        const btn = document.getElementById('btnImportSubmit');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="feather-loader me-1"></i> Sedang Memproses...';
        }
    });
}

function confirmSingleDelete(btn) {
    const url  = btn.dataset.deleteUrl;
    const name = btn.dataset.deleteName;
    Swal.fire({
        title: 'Padam Murid?',
        text: `Rekod "${name}" akan dipadam secara kekal. Tindakan ini tidak boleh dikembalikan!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Padam!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('singleDeleteForm');
            form.action = url;
            form.submit();
        }
    });
}
</script>
@endpush
