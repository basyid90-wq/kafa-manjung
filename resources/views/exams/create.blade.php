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
                            <h4 class="rbt-title-style-3">Tambah Peperiksaan</h4>
                        </div>

                        <form action="{{ route('exams.store') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Peperiksaan</label>
                                    <input type="text" id="name" name="name" placeholder="Peperiksaan Pertengahan Tahun" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="year">Tahun</label>
                                    <input type="number" id="year" name="year" value="{{ date('Y') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="term">Penggal</label>
                                    <select id="term" name="term" class="form-select">
                                        <option value="pertengahan_tahun">Pertengahan Tahun</option>
                                        <option value="akhir_tahun">Akhir Tahun</option>
                                        <option value="lain">Lain-lain</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt--30">
                                <div class="rbt-button-group justify-content-start">
                                    <button class="rbt-btn btn-gradient hover-icon-reverse" type="submit">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Simpan Peperiksaan</span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                        </span>
                                    </button>
                                    <a href="{{ route('exams.index') }}" class="rbt-btn btn-border-gradient">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
