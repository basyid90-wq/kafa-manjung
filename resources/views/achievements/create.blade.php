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
                    /* Pastikan nice-select dropdown kelas buka ke bawah & nampak */
                    .rbt-dashboard-content, .content { overflow: visible !important; }
                    /* Radio group gred */
                    .grade-radio-group .btn-check:checked + .btn-outline-secondary { background:#6c757d;color:#fff; }
                    .grade-radio-group .btn-check:checked + .btn-outline-success  { background:#28a745;color:#fff; }
                    .grade-radio-group .btn-check:checked + .btn-outline-primary  { background:#007bff;color:#fff; }
                    .grade-radio-group .btn-check:checked + .btn-outline-warning  { background:#ffc107;color:#212529; }
                    .grade-radio-group .btn-check:checked + .btn-outline-danger   { background:#dc3545;color:#fff; }
                </style>
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">Tambah Rekod Pencapaian Murid</h4>
                            <a href="{{ route('achievements.index') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

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
                        <form action="{{ route('achievements.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kafa_class_id" value="{{ $selectedClass->id }}">

                            <div class="row g-3 mb--20">
                                <div class="col-md-3">
                                    <div class="rbt-form-group">
                                        <label>Tahun Akademik</label>
                                        <input type="number" name="academic_year" class="form-control" value="{{ date('Y') }}" min="2020" max="2099" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="rbt-form-group">
                                        <label>Peperiksaan Pertengahan Tahun</label>
                                        <select name="midyear_exam_id" class="rbt-big-select">
                                            <option value="">-- Tiada --</option>
                                            @foreach($exams->where('term', 'pertengahan_tahun') as $exam)
                                                <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->year }})</option>
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
                                                <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->year }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="student-records-list">
                                @foreach($selectedClass->students->sortBy('name') as $i => $student)
                                <div class="rbt-shadow-box mb--20 p-4 bg-color-white" style="border:1px solid #e6e6e6;border-radius:8px;">
                                    <h5 class="mb--15" style="font-size:15px;">
                                        <span class="rbt-badge-5 bg-color-primary color-white me-2">{{ $i + 1 }}</span>
                                        {{ $student->name }}
                                    </h5>

                                    <div class="row g-3 align-items-start">
                                        <div class="col-6 col-md-2">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">PHCI (PT)</label>
                                            <input type="number" name="phci_midyear[{{ $student->id }}]"
                                                class="form-control form-control-sm" min="0" max="100" placeholder="0–100">
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">PHCI (AT)</label>
                                            <input type="number" name="phci_endyear[{{ $student->id }}]"
                                                class="form-control form-control-sm" min="0" max="100" placeholder="0–100">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">Kelakuan</label>
                                            <div class="btn-group grade-radio-group d-flex" role="group">
                                                <input type="radio" class="btn-check" name="kelakuan[{{ $student->id }}]" id="kel_{{ $student->id }}_x" value="" checked autocomplete="off">
                                                <label class="btn btn-outline-secondary btn-sm flex-fill" for="kel_{{ $student->id }}_x">-</label>

                                                <input type="radio" class="btn-check" name="kelakuan[{{ $student->id }}]" id="kel_{{ $student->id }}_A" value="A" autocomplete="off">
                                                <label class="btn btn-outline-success btn-sm flex-fill" for="kel_{{ $student->id }}_A">A</label>

                                                <input type="radio" class="btn-check" name="kelakuan[{{ $student->id }}]" id="kel_{{ $student->id }}_B" value="B" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-sm flex-fill" for="kel_{{ $student->id }}_B">B</label>

                                                <input type="radio" class="btn-check" name="kelakuan[{{ $student->id }}]" id="kel_{{ $student->id }}_C" value="C" autocomplete="off">
                                                <label class="btn btn-outline-warning btn-sm flex-fill" for="kel_{{ $student->id }}_C">C</label>

                                                <input type="radio" class="btn-check" name="kelakuan[{{ $student->id }}]" id="kel_{{ $student->id }}_D" value="D" autocomplete="off">
                                                <label class="btn btn-outline-danger btn-sm flex-fill" for="kel_{{ $student->id }}_D">D</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">Kebersihan</label>
                                            <div class="btn-group grade-radio-group d-flex" role="group">
                                                <input type="radio" class="btn-check" name="kebersihan[{{ $student->id }}]" id="keb_{{ $student->id }}_x" value="" checked autocomplete="off">
                                                <label class="btn btn-outline-secondary btn-sm flex-fill" for="keb_{{ $student->id }}_x">-</label>

                                                <input type="radio" class="btn-check" name="kebersihan[{{ $student->id }}]" id="keb_{{ $student->id }}_A" value="A" autocomplete="off">
                                                <label class="btn btn-outline-success btn-sm flex-fill" for="keb_{{ $student->id }}_A">A</label>

                                                <input type="radio" class="btn-check" name="kebersihan[{{ $student->id }}]" id="keb_{{ $student->id }}_B" value="B" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-sm flex-fill" for="keb_{{ $student->id }}_B">B</label>

                                                <input type="radio" class="btn-check" name="kebersihan[{{ $student->id }}]" id="keb_{{ $student->id }}_C" value="C" autocomplete="off">
                                                <label class="btn btn-outline-warning btn-sm flex-fill" for="keb_{{ $student->id }}_C">C</label>

                                                <input type="radio" class="btn-check" name="kebersihan[{{ $student->id }}]" id="keb_{{ $student->id }}_D" value="D" autocomplete="off">
                                                <label class="btn btn-outline-danger btn-sm flex-fill" for="keb_{{ $student->id }}_D">D</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;">Ulasan Guru</label>
                                            <textarea name="teacher_comments[{{ $student->id }}]" class="form-control form-control-sm" rows="2"
                                                placeholder="Ulasan ringkas prestasi murid..."></textarea>
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
                                            <option value="draft">Draf</option>
                                            <option value="final">Final</option>
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
