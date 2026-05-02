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
                    <div class="content">

                        {{-- ── Header ── --}}
                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">Pengurusan Murid</h4>
                            <div class="d-flex gap-2">
                                <button type="button" id="btnBulkDelete" class="rbt-btn btn-sm btn-gradient btn-gradient-danger" disabled>
                                    <i class="feather-trash-2 me-1"></i>Padam Terpilih
                                </button>
                                <button type="button" class="rbt-btn btn-sm btn-border-gradient" data-bs-toggle="modal" data-bs-target="#importModal">
                                    <i class="feather-file-plus me-1"></i>Import SIMPENI
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

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- ── Filter Form: District + School + Search ── --}}
                        <form method="GET" id="filterForm" action="{{ route('students.index') }}" class="mb--10">
                            {{-- Preserve tahun tab state across form submits --}}
                            @if($filterTahun)
                                <input type="hidden" name="tahun" value="{{ $filterTahun }}">
                            @endif

                            <div class="row g-2 mb-2">
                                {{-- Daerah (SA & Pentadbir only) --}}
                                @if(in_array($authRole, ['Super Admin', 'Pentadbir']) && $districts->isNotEmpty())
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select name="district_id" class="form-select form-select-sm" style="height:40px;"
                                            onchange="this.form.submit()">
                                        <option value="">-- Semua Daerah --</option>
                                        @foreach($districts as $d)
                                            <option value="{{ $d->id }}" {{ $filterDistrict == $d->id ? 'selected' : '' }}>
                                                {{ $d->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                {{-- Sekolah (SA, Pentadbir, Penyelia KAFA) --}}
                                @if(in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']) && $schools->isNotEmpty())
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select name="school_id" class="form-select form-select-sm" style="height:40px;"
                                            onchange="this.form.submit()">
                                        <option value="">-- Semua Sekolah --</option>
                                        @foreach($schools as $s)
                                            <option value="{{ $s->id }}" {{ $filterSchool == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                {{-- Kelas --}}
                                @if($classes->isNotEmpty())
                                <div class="col-lg-2 col-md-4 col-12">
                                    <select name="class_id" class="form-select form-select-sm" style="height:40px;"
                                            onchange="this.form.submit()">
                                        <option value="">-- Semua Kelas --</option>
                                        <option value="none" {{ request('class_id') === 'none' ? 'selected' : '' }}>Tiada Kelas</option>
                                        @foreach($classes as $c)
                                            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                                                {{ $c->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                {{-- Search --}}
                                <div class="col-lg col-md col-12">
                                    <input type="text" name="search" value="{{ $search }}"
                                           class="form-control form-control-sm" style="height:40px;"
                                           placeholder="Cari nama / MyKid...">
                                </div>

                                {{-- Buttons --}}
                                <div class="col-auto">
                                    <button type="submit" class="rbt-btn btn-sm btn-gradient" style="height:40px;padding:0 16px;">
                                        <i class="feather-search"></i>
                                    </button>
                                </div>
                                @if($search || $filterDistrict || $filterSchool || request('class_id') || request('show_archive') || $filterTahun)
                                <div class="col-auto">
                                    <a href="{{ route('students.index') }}" class="rbt-btn btn-sm" style="height:40px;padding:0 12px;background:#f0f0f0;color:#555;">
                                        <i class="feather-x"></i>
                                    </a>
                                </div>
                                @endif
                            </div>

                            {{-- Archive toggle --}}
                            <div class="form-check form-switch mt-1 mb-1">
                                <input class="form-check-input" type="checkbox" name="show_archive" value="1"
                                       id="showArchive" {{ request('show_archive') ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                                <label class="form-check-label small text-muted" for="showArchive">
                                    Papar Arkib (Berhenti / Pindah / Umur &gt; 13 Tahun)
                                </label>
                            </div>
                        </form>

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
                        <div class="d-flex flex-wrap gap-2 mb--20">
                            <a href="{{ route('students.index', $baseParams) }}"
                               class="rbt-btn btn-xs {{ !$filterTahun ? 'btn-gradient' : 'btn-border' }}">
                                Semua&nbsp;<span class="badge bg-light text-dark" style="font-size:10px;">{{ $tahunCounts['semua'] }}</span>
                            </a>
                            @for($t = 1; $t <= 6; $t++)
                            <a href="{{ route('students.index', array_merge($baseParams, ['tahun' => $t])) }}"
                               class="rbt-btn btn-xs {{ $filterTahun == $t ? 'btn-gradient' : 'btn-border' }}">
                                Tahun {{ $t }}&nbsp;<span class="badge bg-light text-dark" style="font-size:10px;">{{ $tahunCounts[$t] }}</span>
                            </a>
                            @endfor
                        </div>

                        {{-- ── Bulk Delete Form (wraps table) ── --}}
                        <form id="bulkDeleteForm" action="{{ route('students.bulk-delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="page" value="{{ $students->currentPage() }}">

                            <div class="table-responsive">
                                <table class="rbt-table table table-borderless">
                                    <thead>
                                        <tr>
                                            <th style="width:40px; text-align:center; vertical-align:middle;">
                                                <input type="checkbox" id="selectAll" class="form-check-input"
                                                       style="width:18px;height:18px;cursor:pointer;display:inline-block !important;visibility:visible !important;opacity:1 !important;position:relative !important;appearance:auto !important;-webkit-appearance:checkbox !important;">
                                            </th>
                                            <th>No</th>
                                            <th>Nama</th>
                                            @if(in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']))
                                            <th>Sekolah</th>
                                            @endif
                                            <th>Jantina</th>
                                            <th>Umur</th>
                                            <th>Kelas</th>
                                            <th class="text-center" style="width:90px;">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($students as $student)
                                        <tr id="row-{{ $student->id }}">
                                            <td style="text-align:center;vertical-align:middle;">
                                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                       class="student-checkbox form-check-input"
                                                       style="width:18px;height:18px;cursor:pointer;display:inline-block !important;visibility:visible !important;opacity:1 !important;position:relative !important;appearance:auto !important;-webkit-appearance:checkbox !important;">
                                            </td>
                                            <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                                            <td>
                                                <strong style="font-size:13px;">{{ $student->name }}</strong><br>
                                                <small class="text-muted" style="font-size:11px;">{{ $student->mykid }}</small>
                                            </td>
                                            @if(in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']))
                                            <td>
                                                <span class="rbt-badge-5 bg-secondary-opacity" style="font-size:0.73em;">{{ $student->school->name ?? '—' }}</span>
                                            </td>
                                            @endif
                                            <td>{{ $student->gender == 'L' ? 'Lelaki' : ($student->gender == 'P' ? 'Perempuan' : '—') }}</td>
                                            <td>{{ $student->standard_age ?? '—' }}</td>
                                            <td>{{ $student->kafaClass?->display_name ?? '—' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a href="{{ route('students.show', $student) }}"
                                                       class="rbt-btn btn-xs btn-border-gradient"
                                                       style="height:32px;width:32px;padding:0;display:flex;align-items:center;justify-content:center;" title="Lihat">
                                                        <i class="feather-eye" style="font-size:13px;"></i>
                                                    </a>
                                                    <a href="{{ route('students.edit', array_merge(['student' => $student->id], request()->query())) }}"
                                                       class="rbt-btn btn-xs btn-border-gradient"
                                                       style="height:32px;width:32px;padding:0;display:flex;align-items:center;justify-content:center;" title="Edit">
                                                        <i class="feather-edit" style="font-size:13px;"></i>
                                                    </a>
                                                    <button type="button"
                                                            data-delete-url="{{ route('students.destroy', $student) }}"
                                                            data-delete-name="{{ $student->name }}"
                                                            onclick="confirmSingleDelete(this)"
                                                            class="rbt-btn btn-xs btn-border-gradient"
                                                            style="height:32px;width:32px;padding:0;display:flex;align-items:center;justify-content:center;" title="Padam">
                                                        <i class="feather-trash-2" style="font-size:13px;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="{{ in_array($authRole, ['Super Admin', 'Pentadbir', 'Penyelia KAFA']) ? 8 : 7 }}" class="text-center text-muted p-4">
                                                <i class="feather-users me-2"></i>
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

                        {{-- Hidden form for single delete --}}
                        <form id="singleDeleteForm" action="" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="page" value="{{ $students->currentPage() }}">
                        </form>

                        {{-- Pagination --}}
                        <div class="mt--20 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted">
                                Jumlah: {{ $students->total() }} murid
                                @if($filterTahun) · Tahun <strong>{{ $filterTahun }}</strong>@endif
                                @if($search) · carian "<strong>{{ $search }}</strong>"@endif
                            </small>
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
                        <i class="feather-upload me-1"></i>Mula Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
                if (result.isConfirmed) bulkDeleteForm.submit();
            });
        });
    }
});

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
