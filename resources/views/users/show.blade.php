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
                            <h4 class="rbt-title-style-3">Maklumat Pengguna</h4>
                            <a href="{{ route('users.index') }}" class="rbt-btn btn-sm btn-border-gradient">
                                <span class="btn-text">Kembali</span>
                            </a>
                        </div>

                        <div class="rbt-profile-row rbt-default-form row row--15">
                            <!-- Lajur Kiri: Maklumat Peribadi & Akses -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Maklumat Peribadi</h5>
                                
                                <div class="rbt-form-group">
                                    <label>Nama Penuh</label>
                                    <input type="text" value="{{ $user->name }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Alamat Emel</label>
                                    <input type="email" value="{{ $user->email }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Peranan / Capaian</label>
                                    <div class="mt--10">
                                        @foreach($user->roles as $role)
                                            <span class="rbt-badge-5 bg-primary-opacity">{{ $role->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Lajur Kanan: Maklumat Penugasan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Maklumat Penugasan</h5>

                                <div class="rbt-form-group">
                                    <label>Daerah</label>
                                    <input type="text" value="{{ $user->district->name ?? 'Tiada' }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Sekolah / KAFA</label>
                                    <input type="text" value="{{ $user->school->name ?? 'Tiada' }}" readonly>
                                </div>

                                <div class="rbt-form-group">
                                    <label>Tarikh Pendaftaran</label>
                                    <input type="text" value="{{ $user->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>

                            <!-- Butang Tindakan -->
                            <div class="col-12 mt--30">
                                <hr class="mb--30">
                                <div class="rbt-button-group justify-content-end">
                                    <a href="{{ route('users.edit', $user) }}" class="rbt-btn btn-gradient hover-icon-reverse">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Edit Pengguna</span>
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
