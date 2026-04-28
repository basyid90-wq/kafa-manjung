@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
    $dateParts = explode('-', $date);
    $pdfYear  = (int) $dateParts[0];
    $pdfMonth = (int) $dateParts[1];
@endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">

                        <div class="section-title d-flex justify-content-between align-items-center mb--30 flex-wrap gap-2">
                            <h4 class="rbt-title-style-3">Kehadiran Murid</h4>
                            <form action="{{ route('attendances.index') }}" method="GET" class="d-flex align-items-center">
                                <label for="date" class="mb-0 me-3">Tarikh:</label>
                                <input type="date" name="date" id="date" value="{{ $date }}"
                                       class="form-control" onchange="this.form.submit()" style="max-width:200px;">
                            </form>
                        </div>

                        @forelse($classes as $c)

                            {{-- Per-class header: nama kelas + semua butang tindakan --}}
                            <div class="d-flex justify-content-between align-items-center mb--20 flex-wrap gap-2">
                                <h5 class="mb-0">Kelas: {{ $c->display_name }}</h5>
                                <div class="d-flex gap-2 flex-wrap align-items-center">

                                    {{-- Tanda Semua Hadir --}}
                                    @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                    <button type="button"
                                            class="btn btn-sm btn-success"
                                            onclick="tandaSemua({{ $c->id }})">
                                        <i class="feather-check-circle me-1"></i> Semua Hadir
                                    </button>
                                    @endhasanyrole

                                    @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                    <a href="{{ route('kiosk.index') }}" target="_blank"
                                       class="rbt-btn btn-border-gradient" style="padding:8px 14px; font-size:0.82em;">
                                        <i class="feather-camera me-1"></i> Kiosk Imbasan
                                    </a>
                                    @endhasanyrole

                                    @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                    <a href="{{ route('students.qr_cards', $c) }}" target="_blank"
                                       class="rbt-btn btn-border-gradient" style="padding:8px 14px; font-size:0.82em;">
                                        <i class="feather-grid me-1"></i> Cetak Kad QR
                                    </a>
                                    @endhasanyrole

                                    @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA')
                                    <button type="button"
                                            class="rbt-btn btn-gradient"
                                            style="padding:8px 14px; font-size:0.82em;"
                                            data-class-id="{{ $c->id }}"
                                            data-class-name="{{ $c->display_name }}"
                                            onclick="openKedatanganModal(this)">
                                        <i class="feather-book-open me-1"></i> Buku Kedatangan
                                    </button>
                                    @endhasanyrole

                                </div>
                            </div>

                            <form id="class-form-{{ $c->id }}"
                                  action="{{ route('attendances.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="date" value="{{ $date }}">

                                <div class="table-responsive mb--30">
                                    <table class="rbt-table table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No. MyKid</th>
                                                <th>Nama Murid</th>
                                                <th>Status Kehadiran</th>
                                                @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                                <th class="text-center">Cuti</th>
                                                @endhasanyrole
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($c->students as $i => $student)
                                                @php
                                                    $attendance = $student->attendances->first();
                                                    $status = $attendance ? $attendance->status : null;
                                                @endphp
                                                <tr id="row-{{ $student->id }}">
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $student->mykid }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>
                                                        {{-- Quick Radio Buttons --}}
                                                        <div class="btn-group" role="group"
                                                             aria-label="Status kehadiran {{ $student->name }}">

                                                            <input type="radio"
                                                                   class="btn-check"
                                                                   name="attendances[{{ $student->id }}]"
                                                                   id="H_{{ $student->id }}"
                                                                   value="Hadir"
                                                                   {{ $status === 'Hadir' ? 'checked' : '' }}>
                                                            <label class="btn btn-outline-success btn-sm"
                                                                   for="H_{{ $student->id }}">Hadir</label>

                                                            <input type="radio"
                                                                   class="btn-check"
                                                                   name="attendances[{{ $student->id }}]"
                                                                   id="L_{{ $student->id }}"
                                                                   value="Lewat"
                                                                   {{ $status === 'Lewat' ? 'checked' : '' }}>
                                                            <label class="btn btn-outline-warning btn-sm"
                                                                   for="L_{{ $student->id }}">Lewat</label>

                                                            <input type="radio"
                                                                   class="btn-check"
                                                                   name="attendances[{{ $student->id }}]"
                                                                   id="TH_{{ $student->id }}"
                                                                   value="Tidak Hadir"
                                                                   {{ $status === 'Tidak Hadir' ? 'checked' : '' }}>
                                                            <label class="btn btn-outline-danger btn-sm"
                                                                   for="TH_{{ $student->id }}">T.Hadir</label>

                                                            <input type="radio"
                                                                   class="btn-check"
                                                                   name="attendances[{{ $student->id }}]"
                                                                   id="CS_{{ $student->id }}"
                                                                   value="Cuti Sakit"
                                                                   {{ $status === 'Cuti Sakit' ? 'checked' : '' }}>
                                                            <label class="btn btn-outline-secondary btn-sm"
                                                                   for="CS_{{ $student->id }}">Cuti Sakit</label>

                                                        </div>
                                                    </td>
                                                    @hasanyrole('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                                    <td class="text-center">
                                                        <button type="button"
                                                                class="btn btn-sm btn-light border"
                                                                title="Daftar Cuti Berjadual"
                                                                data-student-id="{{ $student->id }}"
                                                                data-student-name="{{ $student->name }}"
                                                                onclick="openCutiModal(this)">
                                                            <i class="feather-calendar" style="font-size:0.9em;"></i>
                                                        </button>
                                                    </td>
                                                    @endhasanyrole
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tiada murid dalam kelas ini.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if($c->students->count() > 0)
                                    <div class="rbt-form-group d-flex justify-content-end mb--40">
                                        <button type="submit" class="rbt-btn btn-md btn-gradient">Simpan Kehadiran</button>
                                    </div>
                                @endif
                            </form>

                        @empty
                            <div class="alert alert-warning">Anda belum ditugaskan sebagai Guru Kelas bagi mana-mana kelas.</div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ── Modal: Jana Buku Kedatangan ── --}}
<div class="modal fade" id="kedatanganModal" tabindex="-1" aria-labelledby="kedatanganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kedatanganModalLabel">
                    <i class="feather-book-open me-2"></i> Jana Buku Kedatangan (PDF Jawi)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p id="kdClassName" class="fw-bold mb--20" style="font-size:0.95em; color:var(--color-primary);"></p>
                <div class="rbt-form-group">
                    <label for="kdMonthYear">Bulan &amp; Tahun <span class="text-danger">*</span></label>
                    <input type="month" id="kdMonthYear" class="form-control" style="height:50px;" required>
                </div>
                <div class="rbt-form-group mt--20">
                    <label for="kdTotalDays">Jumlah Hari Persekolahan Bulan Ini <span class="text-danger">*</span></label>
                    <input type="number" id="kdTotalDays" class="form-control"
                           style="height:50px;" min="1" max="31" placeholder="Contoh: 20" required>
                    <small class="color-body">Masukkan bilangan hari sekolah aktif (tidak termasuk cuti).</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="rbt-btn btn-border-gradient" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="kdSubmitBtn" class="rbt-btn btn-gradient" onclick="submitKedatanganPdf()">
                    <i class="feather-file-text me-1"></i> Jana PDF (Jawi)
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Modal: Cuti Berjadual ── --}}
<div class="modal fade" id="cutiModal" tabindex="-1" aria-labelledby="cutiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cutiModalLabel">
                    <i class="feather-calendar me-2"></i> Daftar Cuti Berjadual
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p id="cutiStudentName" class="fw-bold mb--20" style="color:var(--color-primary);"></p>
                <form id="cutiForm" action="{{ route('attendances.bulk_leave') }}" method="POST">
                    @csrf
                    <input type="hidden" id="cutiStudentId" name="student_id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="rbt-form-group">
                                <label>Tarikh Mula <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="cutiStart"
                                       class="form-control" style="height:50px;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="rbt-form-group">
                                <label>Tarikh Tamat <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="cutiEnd"
                                       class="form-control" style="height:50px;" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="rbt-form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="rbt-big-select" required>
                                    <option value="Tidak Hadir">Tidak Hadir</option>
                                    <option value="Cuti Sakit">Cuti Sakit</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">
                        <i class="feather-info" style="font-size:0.85em;"></i>
                        Sabtu &amp; Ahad akan diabaikan secara automatik.
                    </small>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="rbt-btn btn-border-gradient" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="cutiForm" class="rbt-btn btn-gradient">
                    <i class="feather-save me-1"></i> Simpan Cuti
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
/* ── Jana Buku Kedatangan PDF ── */
let kdClassId = null;
const kdBaseUrl = '{{ url("attendances") }}';

function openKedatanganModal(btn) {
    kdClassId = btn.dataset.classId;
    document.getElementById('kdClassName').textContent = 'Kelas: ' + btn.dataset.className;
    const now = new Date();
    const mm  = String(now.getMonth() + 1).padStart(2, '0');
    document.getElementById('kdMonthYear').value = now.getFullYear() + '-' + mm;
    document.getElementById('kdTotalDays').value  = '';
    new bootstrap.Modal(document.getElementById('kedatanganModal')).show();
}

function submitKedatanganPdf() {
    const monthYear = document.getElementById('kdMonthYear').value;
    const totalDays = document.getElementById('kdTotalDays').value;
    if (!monthYear) {
        Swal.fire({ icon: 'warning', title: 'Bulan diperlukan', text: 'Sila pilih bulan dan tahun.' });
        return;
    }
    if (!totalDays || parseInt(totalDays) < 1) {
        Swal.fire({ icon: 'warning', title: 'Hari persekolahan diperlukan', text: 'Sila masukkan jumlah hari persekolahan (minimum 1).' });
        return;
    }
    const [year, month] = monthYear.split('-');
    const url = `${kdBaseUrl}/${kdClassId}/pdf?month=${parseInt(month)}&year=${year}&total_days=${totalDays}`;
    openPdfBlob(document.getElementById('kdSubmitBtn'), url);
}

/* ── Tanda Semua Hadir ── */
function tandaSemua(classId) {
    var form = document.getElementById('class-form-' + classId);
    if (!form) return;
    form.querySelectorAll('input[type="radio"][value="Hadir"]').forEach(function (r) {
        r.checked = true;
    });
}

/* ── Cuti Berjadual Modal ── */
function openCutiModal(btn) {
    document.getElementById('cutiStudentId').value       = btn.dataset.studentId;
    document.getElementById('cutiStudentName').textContent = btn.dataset.studentName;

    // Default: tarikh semasa
    var today = new Date().toISOString().slice(0, 10);
    document.getElementById('cutiStart').value = today;
    document.getElementById('cutiEnd').value   = today;

    new bootstrap.Modal(document.getElementById('cutiModal')).show();
}
</script>
@endpush
