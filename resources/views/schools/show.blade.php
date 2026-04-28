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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Maklumat Sekolah</h4>
                            <a href="{{ route('schools.index') }}" class="rbt-btn btn-sm btn-border-gradient">
                                <span class="btn-text">Kembali</span>
                            </a>
                        </div>

                        <div class="rbt-profile-row rbt-default-form row row--15">
                            <!-- Lajur Kiri: Profil Sekolah -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Profil Sekolah</h5>
                                
                                <div class="rbt-form-group">
                                    <label>Nama Sekolah</label>
                                    <input type="text" value="{{ $school->name }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Kod Sekolah / Kod KAFA</label>
                                    <input type="text" value="{{ $school->code }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Daerah</label>
                                    <input type="text" value="{{ $school->district->name }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Jenis Premis</label>
                                    <input type="text" value="{{ $school->jenis_premis ?? '-' }}" readonly>
                                </div>
                            </div>

                            <!-- Lajur Kanan: Maklumat Pengurusan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Maklumat Pengurusan</h5>

                                <div class="rbt-form-group">
                                    <label>Nama Guru Besar / Penyelaras</label>
                                    <input type="text" value="{{ $school->nama_guru_besar ?? '-' }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>No. Telefon</label>
                                    <input type="text" value="{{ $school->no_telefon ?? '-' }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Alamat Penuh Sekolah</label>
                                    <textarea rows="4" readonly>{{ $school->alamat ?? '-' }}</textarea>
                                </div>
                            </div>

                            <!-- Butang Tindakan -->
                            <div class="col-12 mt--30">
                                <hr class="mb--30">
                                <div class="rbt-button-group justify-content-end">
                                    <a href="{{ route('schools.edit', $school) }}" class="rbt-btn btn-gradient hover-icon-reverse">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Edit Sekolah</span>
                                            <span class="btn-icon"><i class="feather-edit"></i></span>
                                            <span class="btn-icon"><i class="feather-edit"></i></span>
                                        </span>
                                    </a>
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
