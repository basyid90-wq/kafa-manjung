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
                            <h4 class="rbt-title-style-3">Edit Sekolah</h4>
                        </div>

                        <form action="{{ route('schools.update', $school) }}" method="POST" enctype="multipart/form-data" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            @method('PUT')

                            <!-- Lajur Kiri: Profil Sekolah -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Profil Sekolah</h5>
                                
                                <div class="rbt-form-group">
                                    <label for="name">Nama Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $school->name) }}" placeholder="Contoh: KAFA Al-Hidayah" required>
                                </div>

                                <div class="rbt-form-group">
                                    <label for="code">Kod Sekolah / Kod KAFA <span class="text-danger">*</span></label>
                                    <input type="text" id="code" name="code" value="{{ old('code', $school->code) }}" placeholder="Cth: AYQ1007" required>
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
                                                <option value="{{ $district->id }}" {{ old('district_id', $school->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endrole

                                <div class="rbt-form-group">
                                    <label for="jenis_premis">Jenis Premis</label>
                                    <select id="jenis_premis" name="jenis_premis" class="rbt-big-select">
                                        <option value="">Sila Pilih</option>
                                        @php
                                            $premisOptions = [
                                                'Sekolah Rendah Agama Rakyat (SRAR)',
                                                'Menumpang Sekolah Kebangsaan (SK)',
                                                'Menyewa',
                                                'Wakaf',
                                                'Surau',
                                                'Masjid',
                                                'Balai Raya / Dewan Orang Ramai',
                                                'Bangunan Sendiri'
                                            ];
                                        @endphp
                                        @foreach($premisOptions as $option)
                                            <option value="{{ $option }}" {{ old('jenis_premis', $school->jenis_premis) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="rbt-form-group">
                                    <label for="logo">Logo Sekolah</label>
                                    @if($school->logo)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" style="height: 80px; border-radius: 8px;">
                                        </div>
                                    @endif
                                    <input type="file" id="logo" name="logo" class="form-control" style="height: 50px; line-height: 35px;" accept="image/*">
                                    <small class="text-muted">Biarkan kosong jika tidak mahu menukar logo.</small>
                                </div>
                            </div>

                            <!-- Lajur Kanan: Maklumat Pengurusan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5 class="mb--20">Maklumat Pengurusan</h5>

                                <div class="rbt-form-group">
                                    <label for="nama_guru_besar">Nama Guru Besar / Penyelaras</label>
                                    <input type="text" id="nama_guru_besar" name="nama_guru_besar" value="{{ old('nama_guru_besar', $school->nama_guru_besar) }}" placeholder="Nama penuh">
                                </div>

                                <div class="rbt-form-group">
                                    <label for="no_telefon">No. Telefon</label>
                                    <input type="text" id="no_telefon" name="no_telefon" value="{{ old('no_telefon', $school->no_telefon) }}" placeholder="Cth: 012-3456789">
                                </div>

                                <div class="rbt-form-group">
                                    <label for="alamat">Alamat Penuh Sekolah</label>
                                    <textarea id="alamat" name="alamat" rows="4">{{ old('alamat', $school->alamat) }}</textarea>
                                </div>

                                <div class="rbt-form-group">
                                    <label for="attendance_cutoff_time">
                                        Masa Tamat Kehadiran
                                        <small class="color-body" style="font-weight:400; font-size:0.8em;">(Selepas masa ini = Lewat)</small>
                                    </label>
                                    <input type="time"
                                           id="attendance_cutoff_time"
                                           name="attendance_cutoff_time"
                                           class="form-control"
                                           style="height:50px;"
                                           value="{{ old('attendance_cutoff_time', $school->attendance_cutoff_time ? substr($school->attendance_cutoff_time, 0, 5) : '') }}">
                                    <small class="color-body">Biarkan kosong jika tiada had masa. Contoh: 08:30</small>
                                </div>
                            </div>

                            <!-- Butang Tindakan -->
                            <div class="col-12 mt--30">
                                <hr class="mb--30">
                                <div class="rbt-button-group justify-content-end">
                                    <a href="{{ route('schools.index') }}" class="rbt-btn btn-border-gradient">Batal</a>
                                    <button class="rbt-btn btn-gradient hover-icon-reverse" type="submit">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Kemaskini Sekolah</span>
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
