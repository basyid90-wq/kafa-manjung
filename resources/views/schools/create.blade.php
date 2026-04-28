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
                            <h4 class="rbt-title-style-3">Tambah Sekolah</h4>
                        </div>

                        <form action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            
                            <!-- Lajur Kiri: Profil Sekolah -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Profil Sekolah</h5>
                                
                                <div class="rbt-form-group">
                                    <label for="name">Nama Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: KAFA Al-Hidayah" required>
                                </div>

                                <div class="rbt-form-group">
                                    <label for="code">Kod Sekolah / Kod KAFA <span class="text-danger">*</span></label>
                                    <input type="text" id="code" name="code" value="{{ old('code') }}" placeholder="Cth: AYQ1007" required>
                                </div>

                                @role('Penyelia KAFA')
                                    <div class="rbt-form-group">
                                        <label>Daerah</label>
                                        <input type="text" value="{{ auth()->user()->district->name }}" disabled>
                                        <input type="hidden" name="district_id" value="{{ auth()->user()->district_id }}">
                                    </div>
                                @else
                                    <div class="rbt-form-group">
                                        <label for="district_id">Daerah <span class="text-danger">*</span></label>
                                        <select id="district_id" name="district_id" class="rbt-big-select" required>
                                            <option value="">-- Pilih Daerah --</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endrole

                                <div class="rbt-form-group">
                                    <label for="jenis_premis">Jenis Premis</label>
                                    <select id="jenis_premis" name="jenis_premis" class="rbt-big-select">
                                        <option value="">Sila Pilih</option>
                                        <option value="Sekolah Rendah Agama Rakyat (SRAR)" {{ old('jenis_premis') == 'Sekolah Rendah Agama Rakyat (SRAR)' ? 'selected' : '' }}>Sekolah Rendah Agama Rakyat (SRAR)</option>
                                        <option value="Menumpang Sekolah Kebangsaan (SK)" {{ old('jenis_premis') == 'Menumpang Sekolah Kebangsaan (SK)' ? 'selected' : '' }}>Menumpang Sekolah Kebangsaan (SK)</option>
                                        <option value="Menyewa" {{ old('jenis_premis') == 'Menyewa' ? 'selected' : '' }}>Menyewa</option>
                                        <option value="Wakaf" {{ old('jenis_premis') == 'Wakaf' ? 'selected' : '' }}>Wakaf</option>
                                        <option value="Surau" {{ old('jenis_premis') == 'Surau' ? 'selected' : '' }}>Surau</option>
                                        <option value="Masjid" {{ old('jenis_premis') == 'Masjid' ? 'selected' : '' }}>Masjid</option>
                                        <option value="Balai Raya / Dewan Orang Ramai" {{ old('jenis_premis') == 'Balai Raya / Dewan Orang Ramai' ? 'selected' : '' }}>Balai Raya / Dewan Orang Ramai</option>
                                        <option value="Bangunan Sendiri" {{ old('jenis_premis') == 'Bangunan Sendiri' ? 'selected' : '' }}>Bangunan Sendiri</option>
                                    </select>
                                </div>

                                <div class="rbt-form-group">
                                    <label for="logo">Logo Sekolah</label>
                                    <input type="file" id="logo" name="logo" class="form-control" style="height: 50px; line-height: 35px;" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimum 2MB.</small>
                                </div>
                            </div>

                            <!-- Lajur Kanan: Maklumat Pengurusan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Maklumat Pengurusan</h5>

                                <div class="rbt-form-group">
                                    <label for="nama_guru_besar">Nama Guru Besar / Penyelaras</label>
                                    <input type="text" id="nama_guru_besar" name="nama_guru_besar" value="{{ old('nama_guru_besar') }}" placeholder="Nama penuh">
                                </div>

                                <div class="rbt-form-group">
                                    <label for="no_telefon">No. Telefon</label>
                                    <input type="text" id="no_telefon" name="no_telefon" value="{{ old('no_telefon') }}" placeholder="Cth: 012-3456789">
                                </div>

                                <div class="rbt-form-group">
                                    <label for="alamat">Alamat Penuh Sekolah</label>
                                    <textarea id="alamat" name="alamat" rows="4">{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <!-- Butang Tindakan -->
                            <div class="col-12 mt--30">
                                <hr class="mb--30">
                                <div class="rbt-button-group justify-content-end">
                                    <a href="{{ route('schools.index') }}" class="rbt-btn btn-border-gradient">Batal</a>
                                    <button class="rbt-btn btn-gradient hover-icon-reverse" type="submit">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Simpan Sekolah</span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                        </span>
                                    </button>
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
