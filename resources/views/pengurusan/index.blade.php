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

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title mb--30">
                            <h4 class="rbt-title-style-3">Pengurusan Pentadbiran</h4>
                            <p class="description">Pusat kawalan modul sistem APKM.</p>
                        </div>

                        {{-- ══════════════════════════════════════════════════════ --}}
                        {{-- GURU KAFA VIEW --}}
                        {{-- ══════════════════════════════════════════════════════ --}}
                        @hasrole('Guru KAFA')

                        {{-- K1: Kelas, Murid --}}
                        <div class="section-title mt--40 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 1: DATA ASAS</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('kafa_classes.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-layers"></i></div>
                                    <h6 class="mb--0">Kelas</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('students.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-user"></i></div>
                                    <h6 class="mb--0">Murid</h6>
                                </a>
                            </div>
                        </div>

                        {{-- K2: Jadual Waktu, Rekod RPH, Kehadiran, Masukkan Markah, Disiplin Murid, Aktiviti & Program, Sijil Digital --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 2: AKADEMIK & PELAJAR</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('timetable.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-clock"></i></div>
                                    <h6 class="mb--0">Jadual Waktu</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('rph.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-book"></i></div>
                                    <h6 class="mb--0">Rekod RPH</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('attendances.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-check-circle"></i></div>
                                    <h6 class="mb--0">Kehadiran</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('exams.results.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-edit"></i></div>
                                    <h6 class="mb--0">Masukkan Markah</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('disciplinary.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-danger-opacity mb--15 mx-auto"><i class="feather-alert-triangle"></i></div>
                                    <h6 class="mb--0">Disiplin Murid</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('activities.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-image"></i></div>
                                    <h6 class="mb--0">Aktiviti & Program</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('certificates.templates.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-award"></i></div>
                                    <h6 class="mb--0">Sijil Digital</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('achievements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-file-text"></i></div>
                                    <h6 class="mb--0">
                                        @if(auth()->user()->hasAnyRole(['Penyelia KAFA', 'Pentadbir']))
                                            Analitik Pencapaian
                                        @else
                                            Rekod Pencapaian
                                        @endif
                                    </h6>
                                </a>
                            </div>
                        </div>

                        {{-- K3: Hebahan --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 3: LOGISTIK & KOMUNIKASI</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('announcements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-bell"></i></div>
                                    <h6 class="mb--0">Hebahan</h6>
                                </a>
                            </div>
                        </div>

                        @endhasrole

                        {{-- ══════════════════════════════════════════════════════ --}}
                        {{-- GURU BESAR VIEW --}}
                        {{-- ══════════════════════════════════════════════════════ --}}
                        @hasrole('Guru Besar')

                        {{-- K1: Pengguna, Sekolah, Kelas, Murid --}}
                        <div class="section-title mt--40 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 1: DATA ASAS</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('users.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto"><i class="feather-users"></i></div>
                                    <h6 class="mb--0">Pengguna</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('schools.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-home"></i></div>
                                    <h6 class="mb--0">Sekolah</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('kafa_classes.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-layers"></i></div>
                                    <h6 class="mb--0">Kelas</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('students.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-user"></i></div>
                                    <h6 class="mb--0">Murid</h6>
                                </a>
                            </div>
                        </div>

                        {{-- K2: Jadual Waktu, Rekod RPH, Kehadiran, Masukkan Markah, Disiplin Murid, Aktiviti & Program, Pindah Murid, Sijil Digital --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 2: AKADEMIK & PELAJAR</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('timetable.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-clock"></i></div>
                                    <h6 class="mb--0">Jadual Waktu</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('rph.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-book"></i></div>
                                    <h6 class="mb--0">Rekod RPH</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('attendances.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-check-circle"></i></div>
                                    <h6 class="mb--0">Kehadiran</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('exams.results.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-edit"></i></div>
                                    <h6 class="mb--0">Masukkan Markah</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('disciplinary.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-danger-opacity mb--15 mx-auto"><i class="feather-alert-triangle"></i></div>
                                    <h6 class="mb--0">Disiplin Murid</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('activities.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-image"></i></div>
                                    <h6 class="mb--0">Aktiviti & Program</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('student_transfers.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-shuffle"></i></div>
                                    <h6 class="mb--0">Pindah Murid</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('certificates.templates.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-award"></i></div>
                                    <h6 class="mb--0">Sijil Digital</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('achievements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-file-text"></i></div>
                                    <h6 class="mb--0">
                                        @if(auth()->user()->hasAnyRole(['Penyelia KAFA', 'Pentadbir']))
                                            Analitik Pencapaian
                                        @else
                                            Rekod Pencapaian
                                        @endif
                                    </h6>
                                </a>
                            </div>
                        </div>

                        {{-- K3: Tempahan Buku, Hebahan --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 3: LOGISTIK & KOMUNIKASI</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('book_orders.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-shopping-cart"></i></div>
                                    <h6 class="mb--0">Tempahan Buku</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('announcements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-bell"></i></div>
                                    <h6 class="mb--0">Hebahan</h6>
                                </a>
                            </div>
                        </div>

                        {{-- K4: Laporan & Analisis, Kewangan --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 4: PENTADBIRAN & LAPORAN</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-bar-chart-2"></i></div>
                                    <h6 class="mb--0">Laporan & Analisis</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('financial.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-dollar-sign"></i></div>
                                    <h6 class="mb--0">Kewangan</h6>
                                </a>
                            </div>
                        </div>

                        @endhasrole

                        {{-- ══════════════════════════════════════════════════════ --}}
                        {{-- PENYELIA KAFA VIEW --}}
                        {{-- ══════════════════════════════════════════════════════ --}}
                        @hasrole('Penyelia KAFA')

                        {{-- K1: Pengguna, Sekolah, Mata Pelajaran --}}
                        <div class="section-title mt--40 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 1: DATA ASAS</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('users.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto"><i class="feather-users"></i></div>
                                    <h6 class="mb--0">Pengguna</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('schools.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-home"></i></div>
                                    <h6 class="mb--0">Sekolah</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('subjects.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-book-open"></i></div>
                                    <h6 class="mb--0">Mata Pelajaran</h6>
                                </a>
                            </div>
                        </div>

                        {{-- K2: Kelulusan RPH, KPI RPH, Laporan Kehadiran, Prestasi Peperiksaan,
                                 Pindah Murid, Kewangan, Sijil Digital, Laporan & Analisis,
                                 Disiplin Murid, Aktiviti & Program (Jadual Waktu HIDDEN) --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 2: PENTADBIRAN & LAPORAN</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('rph_approvals.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto"><i class="feather-check-square"></i></div>
                                    <h6 class="mb--0">Kelulusan RPH</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.rph_kpi') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-trending-up"></i></div>
                                    <h6 class="mb--0">KPI RPH</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.attendance') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-calendar"></i></div>
                                    <h6 class="mb--0">Laporan Kehadiran</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.exams') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-trending-up"></i></div>
                                    <h6 class="mb--0">Prestasi Peperiksaan</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('student_transfers.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-shuffle"></i></div>
                                    <h6 class="mb--0">Pindah Murid</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('financial.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-dollar-sign"></i></div>
                                    <h6 class="mb--0">Kewangan</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('certificates.templates.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-award"></i></div>
                                    <h6 class="mb--0">Sijil Digital</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-bar-chart-2"></i></div>
                                    <h6 class="mb--0">Laporan & Analisis</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('disciplinary.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-danger-opacity mb--15 mx-auto"><i class="feather-alert-triangle"></i></div>
                                    <h6 class="mb--0">Disiplin Murid</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('activities.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-image"></i></div>
                                    <h6 class="mb--0">Aktiviti & Program</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('achievements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-file-text"></i></div>
                                    <h6 class="mb--0">
                                        @if(auth()->user()->hasAnyRole(['Penyelia KAFA', 'Pentadbir']))
                                            Analitik Pencapaian
                                        @else
                                            Rekod Pencapaian
                                        @endif
                                    </h6>
                                </a>
                            </div>
                        </div>

                        {{-- K3: Katalog Buku, Pesanan Pembekal, Hebahan --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 3: LOGISTIK & KOMUNIKASI</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('books.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-book-open"></i></div>
                                    <h6 class="mb--0">Katalog Buku</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('book_orders.supplier_index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto"><i class="feather-truck"></i></div>
                                    <h6 class="mb--0">Pesanan Pembekal</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('announcements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-bell"></i></div>
                                    <h6 class="mb--0">Hebahan</h6>
                                </a>
                            </div>
                        </div>

                        @endhasrole

                        {{-- ══════════════════════════════════════════════════════ --}}
                        {{-- SUPER ADMIN / PENTADBIR / PEMBEKAL / BENDAHARI VIEW --}}
                        {{-- ══════════════════════════════════════════════════════ --}}
                        @hasanyrole('Super Admin|Pentadbir|Pembekal|Bendahari Sekolah')

                        {{-- KATEGORI 1: DATA ASAS --}}
                        @hasanyrole('Super Admin|Pentadbir')
                        <div class="section-title mt--40 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 1: DATA ASAS</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('districts.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-map-pin"></i></div>
                                    <h6 class="mb--0">Daerah</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('subjects.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-book-open"></i></div>
                                    <h6 class="mb--0">Mata Pelajaran</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('schools.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-home"></i></div>
                                    <h6 class="mb--0">Sekolah</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('users.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto"><i class="feather-users"></i></div>
                                    <h6 class="mb--0">Pengguna</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('roles.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-shield"></i></div>
                                    <h6 class="mb--0">Peranan</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('kafa_classes.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-layers"></i></div>
                                    <h6 class="mb--0">Kelas</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('students.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-user"></i></div>
                                    <h6 class="mb--0">Murid</h6>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        {{-- KATEGORI 2: AKADEMIK & PELAJAR --}}
                        @hasanyrole('Super Admin|Pentadbir')
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 2: AKADEMIK & PELAJAR</h5><hr>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.attendance') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-calendar"></i></div>
                                    <h6 class="mb--0">Laporan Kehadiran</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.exams') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-trending-up"></i></div>
                                    <h6 class="mb--0">Prestasi Peperiksaan</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('rph_approvals.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto"><i class="feather-check-square"></i></div>
                                    <h6 class="mb--0">Kelulusan RPH</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('timetable.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-clock"></i></div>
                                    <h6 class="mb--0">Jadual Waktu</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('disciplinary.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-danger-opacity mb--15 mx-auto"><i class="feather-alert-triangle"></i></div>
                                    <h6 class="mb--0">Disiplin Murid</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('activities.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto"><i class="feather-image"></i></div>
                                    <h6 class="mb--0">Aktiviti & Program</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('student_transfers.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-shuffle"></i></div>
                                    <h6 class="mb--0">Pindah Murid</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('certificates.templates.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-award"></i></div>
                                    <h6 class="mb--0">Sijil Digital</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('achievements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-file-text"></i></div>
                                    <h6 class="mb--0">
                                        @if(auth()->user()->hasAnyRole(['Penyelia KAFA', 'Pentadbir']))
                                            Analitik Pencapaian
                                        @else
                                            Rekod Pencapaian
                                        @endif
                                    </h6>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        {{-- KATEGORI 3: LOGISTIK & KOMUNIKASI --}}
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 3: LOGISTIK & KOMUNIKASI</h5><hr>
                        </div>
                        <div class="row g-5">
                            @hasanyrole('Super Admin|Pentadbir')
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('books.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-book-open"></i></div>
                                    <h6 class="mb--0">Katalog Buku</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('book_orders.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-shopping-cart"></i></div>
                                    <h6 class="mb--0">Tempahan Buku</h6>
                                </a>
                            </div>
                            @endhasanyrole

                            @hasanyrole('Super Admin|Pentadbir|Pembekal')
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('book_orders.supplier_index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto"><i class="feather-truck"></i></div>
                                    <h6 class="mb--0">Pesanan Pembekal</h6>
                                </a>
                            </div>
                            @endhasanyrole

                            @hasanyrole('Super Admin|Pentadbir')
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('announcements.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto"><i class="feather-bell"></i></div>
                                    <h6 class="mb--0">Hebahan</h6>
                                </a>
                            </div>
                            @endhasanyrole
                        </div>

                        {{-- KATEGORI 4: PENTADBIRAN & LAPORAN --}}
                        @hasanyrole('Super Admin|Pentadbir|Bendahari Sekolah')
                        <div class="section-title mt--50 mb--20">
                            <h5 class="rbt-title-style-2">KATEGORI 4: PENTADBIRAN & LAPORAN</h5><hr>
                        </div>
                        <div class="row g-5">
                            @hasanyrole('Super Admin|Pentadbir|Bendahari Sekolah')
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('financial.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto"><i class="feather-dollar-sign"></i></div>
                                    <h6 class="mb--0">Kewangan</h6>
                                </a>
                            </div>
                            @endhasanyrole

                            @hasanyrole('Super Admin|Pentadbir')
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.index') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto"><i class="feather-bar-chart-2"></i></div>
                                    <h6 class="mb--0">Laporan & Analisis</h6>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <a href="{{ route('reports.rph_kpi') }}" class="rbt-card variation-01 rbt-hover-03 rbt-border-dashed text-center p-5 d-block h-100">
                                    <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto"><i class="feather-trending-up"></i></div>
                                    <h6 class="mb--0">KPI RPH</h6>
                                </a>
                            </div>
                            @endhasanyrole
                        </div>
                        @endhasanyrole

                        @endhasanyrole
                        {{-- end admin block --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rbt-round-icon {
        width: 70px;
        height: 70px;
        line-height: 75px;
        font-size: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .rbt-card.rbt-hover-03:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: var(--color-primary) !important;
    }
    .rbt-card.rbt-hover-03:hover h6 {
        color: var(--color-primary);
    }
    .bg-primary-opacity { background: rgba(110, 65, 255, 0.1); color: #6e41ff; }
    .bg-secondary-opacity { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .bg-pink-opacity { background: rgba(232, 62, 140, 0.1); color: #e83e8c; }
    .bg-warning-opacity { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .bg-info-opacity { background: rgba(0, 123, 255, 0.1); color: #007bff; }
    .bg-success-opacity { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .bg-danger-opacity { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
</style>

@endsection
