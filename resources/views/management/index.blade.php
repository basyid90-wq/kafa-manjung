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
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Pengurusan Utama</h4>
                            <p class="description">Pilih modul di bawah untuk meneruskan tugas anda.</p>
                        </div>

                        <!-- Developer Section -->
                        <div class="section-category mb-5">
                            <h4 class="mb-4 text-primary color-primary">Developer</h4>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                                @role('Super Admin|Pentadbir')
                                <!-- Pengguna -->
                                <div class="col">
                                    <a href="{{ route('users.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-primary-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto">
                                                    <i class="feather-users"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Pengguna</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Peranan -->
                                <div class="col">
                                    <a href="{{ route('roles.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-secondary-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-secondary-opacity mb--15 mx-auto">
                                                    <i class="feather-shield"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Peranan</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole
                            </div>
                        </div>

                        <!-- Pengurusan Pelajar Section -->
                        <div class="section-category mb-5">
                            <h4 class="mb-4 text-primary color-primary">Pengurusan Pelajar</h4>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                                @role('Super Admin|Pentadbir')
                                <!-- Murid -->
                                <div class="col">
                                    <a href="{{ route('students.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-violet-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-violet-opacity mb--15 mx-auto">
                                                    <i class="feather-user"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Murid</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Kelas -->
                                <div class="col">
                                    <a href="{{ route('kafa_classes.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-pink-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-pink-opacity mb--15 mx-auto">
                                                    <i class="feather-layers"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Kelas</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru KAFA')
                                <!-- Kehadiran -->
                                <div class="col">
                                    <a href="{{ route('attendances.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-success-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto">
                                                    <i class="feather-check-circle"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Kehadiran</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir')
                                <!-- Peperiksaan -->
                                <div class="col">
                                    <a href="{{ route('exams.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-coral-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-coral-opacity mb--15 mx-auto">
                                                    <i class="feather-calendar"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Peperiksaan</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru KAFA')
                                <!-- Kemasukan Markah -->
                                <div class="col">
                                    <a href="{{ route('exams.results.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-info-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto">
                                                    <i class="feather-edit"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Kemasukan Markah</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru Besar|Ibu Bapa')
                                <!-- Jadual Waktu -->
                                <div class="col">
                                    <a href="{{ route('timetable.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-primary-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto">
                                                    <i class="feather-clock"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Jadual Waktu</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                <!-- Aktiviti & Program -->
                                <div class="col">
                                    <a href="{{ route('activities.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-success-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto">
                                                    <i class="feather-image"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Aktiviti & Program</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru KAFA|Ibu Bapa')
                                <!-- Disiplin Murid -->
                                <div class="col">
                                    <a href="{{ route('disciplinary.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-danger-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-danger-opacity mb--15 mx-auto">
                                                    <i class="feather-alert-triangle"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Disiplin Murid</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru Besar')
                                <!-- Laporan & Analisis -->
                                <div class="col">
                                    <a href="{{ route('reports.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-primary-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto">
                                                    <i class="feather-bar-chart-2"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Laporan & Analisis</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole
                            </div>
                        </div>

                        <!-- Pengurusan Guru & Sekolah Section -->
                        <div class="section-category mb-5">
                            <h4 class="mb-4 text-primary color-primary">Pengurusan Guru & Sekolah</h4>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                                @role('Super Admin|Pentadbir|Guru Besar')
                                <!-- Hebahan -->
                                <div class="col">
                                    <a href="{{ route('announcements.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-info-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto">
                                                    <i class="feather-bell"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Hebahan</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru KAFA')
                                <!-- Rekod RPH -->
                                <div class="col">
                                    <a href="{{ route('rph.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-warning-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto">
                                                    <i class="feather-book"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Rekod RPH</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Bendahari Sekolah')
                                <!-- Akaun Sekolah -->
                                <div class="col">
                                    <a href="{{ route('financial.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-success-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto">
                                                    <i class="feather-dollar-sign"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Akaun Sekolah</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru Besar')
                                <!-- Tempahan Buku -->
                                <div class="col">
                                    <a href="{{ route('book_orders.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-warning-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-warning-opacity mb--15 mx-auto">
                                                    <i class="feather-book"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Tempahan Buku</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole
                            </div>
                        </div>

                        <!-- Admin KAFA Section -->
                        <div class="section-category mb-5">
                            <h4 class="mb-4 text-primary color-primary">Admin KAFA</h4>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                                @role('Super Admin|Pentadbir|Guru Besar')
                                <!-- Hebahan -->
                                <div class="col">
                                    <a href="{{ route('announcements.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-info-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-info-opacity mb--15 mx-auto">
                                                    <i class="feather-bell"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Hebahan</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir')
                                <!-- Katalog Buku -->
                                <div class="col">
                                    <a href="{{ route('books.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-primary-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto">
                                                    <i class="feather-book"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Katalog Buku</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole

                                @role('Super Admin|Pentadbir|Guru Besar')
                                <!-- Kelulusan RPH -->
                                <div class="col">
                                    <a href="{{ route('rph_approvals.index') }}" class="rbt-management-card">
                                        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-danger-opacity h-100">
                                            <div class="inner p-4 flex-column text-center">
                                                <div class="rbt-round-icon bg-danger-opacity mb--15 mx-auto">
                                                    <i class="feather-check-square"></i>
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb--0">Kelulusan RPH</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endrole
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rbt-management-card {
        display: block;
        height: 100%;
    }
    .rbt-management-card .inner {
        transition: 0.3s;
    }
    .rbt-management-card:hover .inner {
        transform: translateY(-5px);
    }
    .rbt-round-icon i {
        font-size: 28px !important;
    }
    .rbt-management-card .title {
        font-size: 14px !important;
        line-height: 1.4 !important;
        word-break: keep-all;
        hyphens: none;
    }
    .bg-info-opacity {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
    .bg-warning-opacity {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    .description {
        margin-bottom: 30px;
        color: var(--color-body);
    }
</style>
@endsection
