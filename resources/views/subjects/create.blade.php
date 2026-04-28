@extends('layout.layout')

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
                            <h4 class="rbt-title-style-3">Tambah Mata Pelajaran Baharu</h4>
                        </div>

                        <form action="{{ route('subjects.store') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf

                            <div class="col-lg-8">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Mata Pelajaran</label>
                                    <input type="text" id="name" name="name" placeholder="cth: Al-Quran" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="rbt-form-group">
                                    <label for="code">Kod Subjek</label>
                                    <input type="text" id="code" name="code" placeholder="cth: ALQ" required>
                                </div>
                            </div>

                            @role('Super Admin|Pentadbir|Penyelia KAFA')
                            <div class="col-lg-8">
                                <div class="rbt-form-group">
                                    <label for="school_id">Sekolah (Pilihan: Kosongkan untuk Global)</label>
                                    <select id="school_id" name="school_id" class="rbt-big-select">
                                        <option value="">-- Subjek Global --</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole

                            <div class="col-lg-4">
                                <div class="rbt-form-group">
                                    <label for="form_slot">Slot Borang Pencapaian</label>
                                    <select id="form_slot" name="form_slot" class="rbt-big-select">
                                        <option value="">-- Tiada --</option>
                                        <option value="tilawah_tahfiz">Tilawah & Tahfiz Al-Quran</option>
                                        <option value="lughati">Lughati (Lughatul Quran)</option>
                                        <option value="ibadah">Ibadah</option>
                                        <option value="akidah">Akidah</option>
                                        <option value="sirah">Sirah & Tamadun Islam</option>
                                        <option value="adab">Adab & Akhlak</option>
                                        <option value="jawi_khat">Jawi & Khat</option>
                                        <option value="bahasa_arab">Bahasa Arab</option>
                                        <option value="amali_solat">Amali Solat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <button class="rbt-btn btn-gradient" type="submit">Simpan Rekod</button>
                                    <a class="rbt-btn btn-border" href="{{ route('subjects.index') }}">Batal</a>
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
