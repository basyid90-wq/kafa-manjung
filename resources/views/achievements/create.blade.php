@extends('layout.layout')

@php $bodyClass = ''; $footer = 'true'; @endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <style>
                    .rbt-dashboard-content, .content { overflow: visible !important; }
                    .grade-radio-group .btn-check:checked + .btn-outline-secondary { background:#6c757d;color:#fff; }
                    .grade-radio-group .btn-check:checked + .btn-outline-success  { background:#28a745;color:#fff; }
                    .grade-radio-group .btn-check:checked + .btn-outline-primary  { background:#007bff;color:#fff; }
                    .grade-radio-group .btn-check:checked + .btn-outline-warning  { background:#ffc107;color:#212529; }
                    .grade-radio-group .btn-check:checked + .btn-outline-danger   { background:#dc3545;color:#fff; }
                    .amali-radio-group .btn-check:checked + .btn-outline-success  { background:#28a745;color:#fff; }
                    .amali-radio-group .btn-check:checked + .btn-outline-danger   { background:#dc3545;color:#fff; }
                    .amali-radio-group .btn-check:checked + .btn-outline-secondary { background:#6c757d;color:#fff; }
                </style>
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">Tambah Rekod Pencapaian Murid</h4>
                            <a href="{{ route('achievements.index') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                        @if($errors->any())
                        <div class="alert alert-danger mb--20">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Step 1: Pilih Kelas --}}
                        <form method="GET" action="{{ route('achievements.create') }}" class="row g-3 mb--30">
                            <div class="col-md-5">
                                <div class="rbt-form-group">
                                    <label>Pilih Kelas</label>
                                    <select name="kafa_class_id" class="rbt-big-select" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($classes as $kelas)
                                            <option value="{{ $kelas->id }}" {{ request('kafa_class_id') == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="rbt-btn btn-gradient btn-sm">Muat Murid</button>
                            </div>
                        </form>

                        @if($selectedClass)
                        {{-- Auto-scroll ke senarai murid apabila kelas dipilih --}}
                        @if(!empty($scrollToStudents))
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var el = document.getElementById('student-records-section');
                                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            });
                        </script>
                        @endif

                        <div id="student-records-section">
                        <div class="alert alert-success mb--20 d-flex align-items-center gap-2">
                            <i class="feather-check-circle"></i>
                            <span>Kelas <strong>{{ $selectedClass->name }}</strong> dipilih — {{ $selectedClass->students->count() }} murid dipaparkan di bawah.</span>
                        </div>

                        @php
                            $hasFinalRecords = isset($existingRecords) && $existingRecords->where('status', 'final')->count() > 0;
                            $isGuruKafa = auth()->user()->hasRole('Guru KAFA');
                        @endphp

                        @if($hasFinalRecords && $isGuruKafa)
                        <div class="alert alert-warning d-flex align-items-start gap-2 mb--20">
                            <i class="feather-lock mt-1"></i>
                            <div>
                                <strong>Sebahagian rekod telah difinalkan.</strong> Rekod bertanda <span class="badge bg-success" style="font-size:10px;"><i class="feather-lock" style="font-size:9px;"></i> Final</span> tidak boleh diubah oleh Guru KAFA. Hubungi Guru Besar untuk membuka semula.
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('achievements.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kafa_class_id" value="{{ $selectedClass->id }}">
                            <input type="hidden" name="page" value="{{ $page ?? 1 }}">

                            <div class="row g-3 mb--20">
                                <div class="col-md-3">
                                    <div class="rbt-form-group">
                                        <label>Tahun Akademik</label>
                                        <input type="number" name="academic_year" class="form-control"
                                            value="{{ old('academic_year', $achievement->academic_year ?? date('Y')) }}"
                                            min="2020" max="2099" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="rbt-form-group">
                                        <label>Peperiksaan Pertengahan Tahun</label>
                                        <select name="midyear_exam_id" class="rbt-big-select">
                                            <option value="">-- Tiada --</option>
                                            @foreach($exams->where('term', 'pertengahan_tahun') as $exam)
                                                <option value="{{ $exam->id }}"
                                                    {{ old('midyear_exam_id', $achievement->midyear_exam_id ?? '') == $exam->id ? 'selected' : '' }}>
                                                    {{ $exam->name }} ({{ $exam->year }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="rbt-form-group">
                                        <label>Peperiksaan Akhir Tahun</label>
                                        <select name="endyear_exam_id" class="rbt-big-select">
                                            <option value="">-- Tiada --</option>
                                            @foreach($exams->where('term', 'akhir_tahun') as $exam)
                                                <option value="{{ $exam->id }}"
                                                    {{ old('endyear_exam_id', $achievement->endyear_exam_id ?? '') == $exam->id ? 'selected' : '' }}>
                                                    {{ $exam->name }} ({{ $exam->year }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="student-records-list">
                                @foreach($selectedClass->students->sortBy('name') as $i => $student)
                                @php
                                    $existing = isset($existingRecords) ? ($existingRecords[$student->id] ?? null) : null;
                                    $isLocked  = $existing && $existing->status === 'final' && $isGuruKafa;
                                    $preKelakuan   = old("kelakuan.{$student->id}",   $existing->kelakuan   ?? '');
                                    $preKebersihan = old("kebersihan.{$student->id}", $existing->kebersihan ?? '');
                                    $preAmaliSolat = old("amali_solat.{$student->id}", $existing->amali_solat ?? '');
                                    $prePhciMid    = old("phci_midyear.{$student->id}", $existing->phci_midyear ?? '');
                                    $prePhciEnd    = old("phci_endyear.{$student->id}", $existing->phci_endyear ?? '');
                                    $preComments   = old("teacher_comments.{$student->id}", $existing->teacher_comments ?? '');

                                    // Load existing exam marks for preview
                                    $midTotal = 0;
                                    $endTotal = 0;
                                    if ($existing && $existing->midyear_exam_id) {
                                        $midTotal = \App\Models\ExamResult::where('student_id', $student->id)
                                            ->where('exam_id', $existing->midyear_exam_id)
                                            ->where('is_absent', false)->sum('marks');
                                    }
                                    if ($existing && $existing->endyear_exam_id) {
                                        $endTotal = \App\Models\ExamResult::where('student_id', $student->id)
                                            ->where('exam_id', $existing->endyear_exam_id)
                                            ->where('is_absent', false)->sum('marks');
                                    }
                                @endphp

                                <div class="rbt-shadow-box mb--20 p-4 bg-color-white" style="border:1px solid {{ $isLocked ? '#28a745' : '#e6e6e6' }};border-radius:8px;">
                                    <div class="d-flex justify-content-between align-items-start mb--15">
                                        <h5 class="mb-0" style="font-size:15px;">
                                            <span class="rbt-badge-5 bg-color-primary color-white me-2">{{ $i + 1 }}</span>
                                            {{ $student->name }}
                                            @if($existing)
                                                @if($existing->status === 'final')
                                                    <span class="badge bg-success ms-2" style="font-size:10px;"><i class="feather-lock" style="font-size:9px;"></i> Final</span>
                                                @else
                                                    <span class="badge bg-warning text-dark ms-2" style="font-size:10px;">Draf</span>
                                                @endif
                                            @endif
                                        </h5>
                                        {{-- Markah Peperiksaan Preview --}}
                                        @if($existing && ($midTotal > 0 || $endTotal > 0))
                                        <div style="font-size:11px;">
                                            @if($existing->midyear_exam_id)
                                                <span class="badge bg-light text-dark border me-1">PT: {{ $midTotal }}</span>
                                            @endif
                                            @if($existing->endyear_exam_id)
                                                <span class="badge bg-light text-dark border me-1">AT: {{ $endTotal }}</span>
                                            @endif
                                            <span class="badge bg-primary">Jumlah: {{ $midTotal + $endTotal }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    @if($isLocked)
                                    <div class="alert alert-success py-2 mb--15" style="font-size:12px;">
                                        <i class="feather-lock me-1"></i> Rekod ini telah difinalkan — tidak boleh diubah.
                                    </div>
                                    @endif

                                    <div class="row g-3 align-items-start {{ $isLocked ? 'opacity-50' : '' }}">
                                        <div class="col-6 col-md-2">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">PHCI (PT)</label>
                                            <input type="number" name="phci_midyear[{{ $student->id }}]"
                                                class="form-control form-control-sm" min="0" max="100" placeholder="0–100"
                                                value="{{ $prePhciMid }}" {{ $isLocked ? 'disabled' : '' }}>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">PHCI (AT)</label>
                                            <input type="number" name="phci_endyear[{{ $student->id }}]"
                                                class="form-control form-control-sm" min="0" max="100" placeholder="0–100"
                                                value="{{ $prePhciEnd }}" {{ $isLocked ? 'disabled' : '' }}>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">Amali Solat</label>
                                            <div class="btn-group amali-radio-group d-flex" role="group">
                                                <input type="radio" class="btn-check" name="amali_solat[{{ $student->id }}]" id="am_{{ $student->id }}_x" value="" {{ $preAmaliSolat === '' ? 'checked' : '' }} autocomplete="off" {{ $isLocked ? 'disabled' : '' }}>
                                                <label class="btn btn-outline-secondary btn-sm flex-fill" for="am_{{ $student->id }}_x">—</label>

                                                <input type="radio" class="btn-check" name="amali_solat[{{ $student->id }}]" id="am_{{ $student->id }}_L" value="Lulus" {{ $preAmaliSolat === 'Lulus' ? 'checked' : '' }} autocomplete="off" {{ $isLocked ? 'disabled' : '' }}>
                                                <label class="btn btn-outline-success btn-sm flex-fill" for="am_{{ $student->id }}_L">L</label>

                                                <input type="radio" class="btn-check" name="amali_solat[{{ $student->id }}]" id="am_{{ $student->id }}_TL" value="Tidak Lulus" {{ $preAmaliSolat === 'Tidak Lulus' ? 'checked' : '' }} autocomplete="off" {{ $isLocked ? 'disabled' : '' }}>
                                                <label class="btn btn-outline-danger btn-sm flex-fill" for="am_{{ $student->id }}_TL">TL</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">Kelakuan</label>
                                            <div class="btn-group grade-radio-group d-flex" role="group">
                                                <input type="radio" class="btn-check" name="kelakuan[{{ $student->id }}]" id="kel_{{ $student->id }}_x" value="" {{ $preKelakuan === '' ? 'checked' : '' }} autocomplete="off" {{ $isLocked ? 'disabled' : '' }}>
                                                <label class="btn btn-outline-secondary btn-sm flex-fill" for="kel_{{ $student->id }}_x">-</label>

                                                @foreach(['A','B','C','D'] as $grade)
                                                <input type="radio" class="btn-check" name="kelakuan[{{ $student->id }}]" id="kel_{{ $student->id }}_{{ $grade }}" value="{{ $grade }}" {{ $preKelakuan === $grade ? 'checked' : '' }} autocomplete="off" {{ $isLocked ? 'disabled' : '' }}>
                                                <label class="btn btn-outline-{{ ['A'=>'success','B'=>'primary','C'=>'warning','D'=>'danger'][$grade] }} btn-sm flex-fill" for="kel_{{ $student->id }}_{{ $grade }}">{{ $grade }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">Kebersihan</label>
                                            <div class="btn-group grade-radio-group d-flex" role="group">
                                                <input type="radio" class="btn-check" name="kebersihan[{{ $student->id }}]" id="keb_{{ $student->id }}_x" value="" {{ $preKebersihan === '' ? 'checked' : '' }} autocomplete="off" {{ $isLocked ? 'disabled' : '' }}>
                                                <label class="btn btn-outline-secondary btn-sm flex-fill" for="keb_{{ $student->id }}_x">-</label>

                                                @foreach(['A','B','C','D'] as $grade)
                                                <input type="radio" class="btn-check" name="kebersihan[{{ $student->id }}]" id="keb_{{ $student->id }}_{{ $grade }}" value="{{ $grade }}" {{ $preKebersihan === $grade ? 'checked' : '' }} autocomplete="off" {{ $isLocked ? 'disabled' : '' }}>
                                                <label class="btn btn-outline-{{ ['A'=>'success','B'=>'primary','C'=>'warning','D'=>'danger'][$grade] }} btn-sm flex-fill" for="keb_{{ $student->id }}_{{ $grade }}">{{ $grade }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">Ulasan Guru</label>
                                            <textarea name="teacher_comments[{{ $student->id }}]" class="form-control form-control-sm" rows="2"
                                                placeholder="Ulasan ringkas prestasi murid..." {{ $isLocked ? 'disabled' : '' }}>{{ $preComments }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="row mt--20">
                                <div class="col-md-3">
                                    <div class="rbt-form-group">
                                        <label>Status</label>
                                        <select name="status" class="rbt-big-select">
                                            @php $currentStatus = old('status', $achievement->status ?? 'draft'); @endphp
                                            <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Draf</option>
                                            @hasanyrole('Guru Besar|Super Admin')
                                            <option value="final" {{ $currentStatus === 'final' ? 'selected' : '' }}>Final</option>
                                            @endhasanyrole
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt--20 d-flex gap-3">
                                <button type="submit" class="rbt-btn btn-gradient hover-icon-reverse">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Simpan Rekod</span>
                                        <span class="btn-icon"><i class="feather-save"></i></span>
                                        <span class="btn-icon"><i class="feather-save"></i></span>
                                    </span>
                                </button>
                                <a href="{{ route('achievements.index') }}" class="rbt-btn btn-border">Kembali</a>
                            </div>
                        </form>
                        </div>{{-- end #student-records-section --}}
                        @else
                        <div class="alert alert-info">Pilih kelas di atas untuk memaparkan senarai murid.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
