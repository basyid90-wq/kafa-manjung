@extends('layout.layout')

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container text-start">
        <div class="row mt--0">
            @include('partials.sidebar')
            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Cipta Hebahan Baru</h4>
                        </div>

                        <form action="{{ route('announcements.store') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="title">Tajuk Hebahan</label>
                                    <input type="text" name="title" id="title" placeholder="Tajuk pengumuman..." value="{{ old('title') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="category">Kategori</label>
                                    <select name="category" id="category" class="rbt-big-select">
                                        <option value="Mesyuarat">Mesyuarat</option>
                                        <option value="Taklimat">Taklimat</option>
                                        <option value="Kursus">Kursus</option>
                                        <option value="Pekeliling">Pekeliling</option>
                                        <option value="Lain-lain">Lain-lain</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Target Role --}}
                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="target_role">Sasaran Role</label>
                                    <select name="target_role" id="target_role" class="rbt-big-select" required>
                                        @role('Super Admin')
                                        <option value="Semua">Semua Pengguna</option>
                                        <option value="Pentadbir">Pentadbir</option>
                                        <option value="Penyelia KAFA">Penyelia KAFA</option>
                                        <option value="Guru Besar">Guru Besar</option>
                                        <option value="Guru KAFA">Guru KAFA</option>
                                        <option value="Pembekal">Pembekal</option>
                                        @endrole

                                        @role('Pentadbir')
                                        <option value="Penyelia KAFA">Penyelia KAFA</option>
                                        <option value="Guru Besar">Guru Besar</option>
                                        <option value="Guru KAFA">Guru KAFA</option>
                                        <option value="Pembekal">Pembekal</option>
                                        @endrole

                                        @role('Penyelia KAFA')
                                        <option value="Guru Besar">Guru Besar</option>
                                        <option value="Guru KAFA">Guru KAFA</option>
                                        <option value="Pembekal">Pembekal</option>
                                        @endrole

                                        @role('Guru Besar')
                                        <option value="Guru KAFA">Guru KAFA</option>
                                        @endrole

                                        @role('Pembekal')
                                        <option value="Penyelia KAFA">Penyelia KAFA</option>
                                        <option value="Guru Besar">Guru Besar</option>
                                        <option value="Guru KAFA">Guru KAFA</option>
                                        @endrole
                                    </select>
                                </div>
                            </div>

                            {{-- Target Scope --}}
                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="target_scope">Skop Sasaran</label>
                                    <select name="target_scope" id="target_scope" class="rbt-big-select" required>
                                        <option value="all">Semua</option>
                                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA']))
                                        <option value="district">Daerah Tertentu</option>
                                        @endif
                                        <option value="school">Sekolah Tertentu</option>
                                    </select>
                                </div>
                            </div>

                            {{-- District Selection (conditional) --}}
                            @if(auth()->user()->hasAnyRole(['Super Admin', 'Pentadbir']))
                            <div class="col-lg-12 col-12" id="district_selection" style="display:none;">
                                <div class="rbt-form-group">
                                    <label for="district_ids">Pilih Daerah</label>
                                    <select name="district_ids[]" id="district_ids" class="rbt-big-select" multiple>
                                        @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Tekan Ctrl untuk pilih lebih dari satu</small>
                                </div>
                            </div>
                            @endif

                            {{-- School Selection (conditional) --}}
                            <div class="col-lg-12 col-12" id="school_selection" style="display:none;">
                                <div class="rbt-form-group">
                                    <label for="school_ids">Pilih Sekolah</label>
                                    <select name="school_ids[]" id="school_ids" class="rbt-big-select" multiple>
                                        @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }} @if($school->district) ({{ $school->district->name }}) @endif</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Tekan Ctrl untuk pilih lebih dari satu</small>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="content_field">Isi Kandungan</label>
                                    <textarea name="content" id="content_field" rows="10" placeholder="Tuliskan maklumat hebahan di sini..." required>{{ old('content') }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="rbt-button-group justify-content-start">
                                    <button type="submit" class="rbt-btn btn-gradient">Terbitkan Hebahan</button>
                                    <a href="{{ route('announcements.index') }}" class="rbt-btn btn-border btn-sm">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetScope = document.getElementById('target_scope');
    const districtSelection = document.getElementById('district_selection');
    const schoolSelection = document.getElementById('school_selection');

    targetScope.addEventListener('change', function() {
        if (this.value === 'district') {
            if (districtSelection) districtSelection.style.display = 'block';
            schoolSelection.style.display = 'none';
        } else if (this.value === 'school') {
            if (districtSelection) districtSelection.style.display = 'none';
            schoolSelection.style.display = 'block';
        } else {
            if (districtSelection) districtSelection.style.display = 'none';
            schoolSelection.style.display = 'none';
        }
    });
});
</script>
@endsection
