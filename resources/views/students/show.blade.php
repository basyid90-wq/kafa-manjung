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
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Profil Murid</h4>
                            <div class="d-flex gap-2">
                                @role('Guru Besar')
                                <a href="{{ route('student_transfers.create', ['student_id' => $student->id]) }}" class="rbt-btn btn-sm btn-outline-primary">
                                    <i class="feather-shuffle"></i> Mohon Pindah
                                </a>
                                @endrole
                                <a href="{{ route('students.edit', $student) }}" class="rbt-btn btn-sm btn-gradient">
                                    <i class="feather-edit"></i> Kemaskini
                                </a>
                                <a href="{{ route('students.index') }}" class="rbt-btn btn-sm btn-border">
                                    <i class="feather-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <!-- Profile Header -->
                        <div class="rbt-profile-header mb--40 p-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center">
                                    <div class="position-relative d-inline-block">
                                        <img class="rounded-circle border border-4 border-white shadow-sm" 
                                             src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('assets/images/team/team-01.jpg') }}" 
                                             alt="{{ $student->name }}"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                        <span class="position-absolute bottom-0 end-0 badge rounded-pill {{ $student->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }} p-2">
                                            {{ $student->status ?? 'Aktif' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9 mt-3 mt-md-0">
                                    <h3 class="mb-1 text-primary">{{ $student->name }}</h3>
                                    <p class="text-muted mb-2"><i class="feather-credit-card me-2"></i><strong>MyKid:</strong> {{ $student->mykid }}</p>
                                    <div class="d-flex flex-wrap gap-3">
                                        <span class="badge bg-white text-dark shadow-sm p-2 px-3 border"><i class="feather-user me-2"></i>{{ $student->gender == 'L' ? 'Lelaki' : 'Perempuan' }}</span>
                                        <span class="badge bg-white text-dark shadow-sm p-2 px-3 border"><i class="feather-calendar me-2"></i>{{ $student->standard_age }} Tahun</span>
                                        <span class="badge bg-white text-dark shadow-sm p-2 px-3 border"><i class="feather-book-open me-2"></i>{{ $student->kafaClass->tahun ?? '-' }} {{ $student->kafaClass->display_name ?? 'Tiada Kelas' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Sections -->
                        <div class="row g-4">
                            <!-- Section 1: Maklumat Peribadi -->
                            <div class="col-12">
                                <div class="rbt-dashboard-table table-responsive mobile-table-750 p-4 border rounded-3 bg-light bg-opacity-10">
                                    <h5 class="mb-4 border-bottom pb-2">1. Maklumat Peribadi</h5>
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col"><strong>Tarikh Lahir:</strong></div>
                                        <div class="col">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d/m/Y') : '-' }}</div>
                                        
                                        <div class="col"><strong>Tempat Lahir:</strong></div>
                                        <div class="col">{{ $student->birth_place ?? '-' }}</div>
                                        
                                        <div class="col"><strong>Bangsa & Warganegara:</strong></div>
                                        <div class="col">{{ $student->race ?? '-' }} / {{ $student->citizenship ?? '-' }}</div>
                                        
                                        <div class="col"><strong>Status OKU:</strong></div>
                                        <div class="col">{{ $student->oku_status ?? 'Tiada' }}</div>
                                        
                                        <div class="col"><strong>Alamat Kediaman:</strong></div>
                                        <div class="col">{{ $student->address ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Akademik -->
                            <div class="col-md-6">
                                <div class="h-100 p-4 border rounded-3 bg-light bg-opacity-10">
                                    <h5 class="mb-4 border-bottom pb-2">2. Akademik (KAFA)</h5>
                                    <div class="row g-3">
                                        <div class="col-5 text-muted">No. Pendaftaran:</div>
                                        <div class="col-7"><strong>{{ $student->registration_no ?? '-' }}</strong></div>
                                        
                                        <div class="col-5 text-muted">Sesi Persekolahan:</div>
                                        <div class="col-7">{{ $student->session_year ?? '-' }}</div>
                                        
                                        <div class="col-5 text-muted">Tarikh Kemasukan:</div>
                                        <div class="col-7">{{ $student->entry_date ?? '-' }}</div>
                                        
                                        <div class="col-5 text-muted">Sekolah Asal:</div>
                                        <div class="col-7">{{ $student->origin_school ?? '-' }}</div>
                                        
                                        <div class="col-5 text-muted">No. UPKK:</div>
                                        <div class="col-7">{{ $student->upkk_number ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Kesihatan -->
                            <div class="col-md-6">
                                <div class="h-100 p-4 border rounded-3 bg-light bg-opacity-10 shadow-sm border-danger border-opacity-25" style="border-left: 5px solid #ff4136 !important;">
                                    <h5 class="mb-4 border-bottom pb-2 text-danger">3. Maklumat Kesihatan</h5>
                                    <div class="row g-3">
                                        <div class="col-5 text-muted">Penyakit Kronik:</div>
                                        <div class="col-7">{{ $student->chronic_disease ?? 'Tiada' }}</div>
                                        
                                        <div class="col-5 text-muted">Alahan:</div>
                                        <div class="col-7">{{ $student->allergies ?? 'Tiada' }}</div>
                                        
                                        <div class="col-5 text-muted">Hubungan Kecemasan:</div>
                                        <div class="col-7"><strong>{{ $student->emergency_contact ?? '-' }}</strong></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Ibu Bapa / Penjaga -->
                            <div class="col-12">
                                <div class="p-4 border rounded-3 bg-light bg-opacity-10 shadow-sm">
                                    <h5 class="mb-4 border-bottom pb-2">4. Maklumat Ibu Bapa / Penjaga</h5>
                                    <div class="row g-4">
                                        <!-- Bapa -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded border shadow-sm h-100">
                                                <h6 class="text-primary mb-3"><i class="feather-user me-2"></i>Bapa / Penjaga 1</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr><td class="text-muted" style="width: 35%;">Nama:</td><td><strong>{{ $student->father_name ?? '-' }}</strong></td></tr>
                                                    <tr><td class="text-muted">No. IC:</td><td>{{ $student->father_ic ?? '-' }}</td></tr>
                                                    <tr><td class="text-muted">No. Telefon:</td><td>{{ $student->father_phone ?? '-' }}</td></tr>
                                                    <tr><td class="text-muted">Pekerjaan:</td><td>{{ $student->father_job ?? '-' }}</td></tr>
                                                    <tr><td class="text-muted">Pendapatan:</td><td>RM {{ number_format($student->father_income ?? 0, 2) }}</td></tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Ibu -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white rounded border shadow-sm h-100">
                                                <h6 class="text-primary mb-3"><i class="feather-user me-2"></i>Ibu / Penjaga 2</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr><td class="text-muted" style="width: 35%;">Nama:</td><td><strong>{{ $student->mother_name ?? '-' }}</strong></td></tr>
                                                    <tr><td class="text-muted">No. IC:</td><td>{{ $student->mother_ic ?? '-' }}</td></tr>
                                                    <tr><td class="text-muted">No. Telefon:</td><td>{{ $student->mother_phone ?? '-' }}</td></tr>
                                                    <tr><td class="text-muted">Pekerjaan:</td><td>{{ $student->mother_job ?? '-' }}</td></tr>
                                                    <tr><td class="text-muted">Pendapatan:</td><td>RM {{ number_format($student->mother_income ?? 0, 2) }}</td></tr>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 mt-3">
                                            <div class="p-3 bg-primary-opacity rounded">
                                                <div class="row">
                                                    <div class="col-md-6"><strong>Tanggungan:</strong> {{ $student->dependents_count ?? 0 }} Orang</div>
                                                    <div class="col-md-6"><strong>Status Hubungan:</strong> {{ $student->parents_relationship_status ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
