@extends('layout.layout')

@php $bodyClass = ''; $footer = 'true'; @endphp

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
                            <h4 class="rbt-title-style-3">Tambah Templat Sijil</h4>
                        </div>

                        <form method="POST" action="{{ route('certificates.templates.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">Nama Templat <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" placeholder="cth: Sijil Penyertaan Sukaneka 2025">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Peringkat <span class="text-danger">*</span></label>
                                    <select name="level" id="selectLevel" class="form-select selectpicker" data-style="btn-default" style="height:50px;">
                                        <option value="sekolah" {{ old('level','sekolah')==='sekolah' ? 'selected':'' }}>Sekolah</option>
                                        <option value="daerah"  {{ old('level')==='daerah'  ? 'selected':'' }}>Daerah</option>
                                    </select>
                                </div>
                                @endhasanyrole

                                @if($districts->isNotEmpty())
                                <div class="col-md-6" id="wrapDistrict">
                                    <label class="form-label fw-bold">Daerah</label>
                                    <select name="district_id" class="form-select selectpicker" data-style="btn-default" data-live-search="true" style="height:50px;">
                                        <option value="">-- Pilih Daerah --</option>
                                        @foreach($districts as $d)
                                        <option value="{{ $d->id }}" {{ old('district_id')==$d->id ? 'selected':'' }}>{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if($schools->isNotEmpty())
                                <div class="col-md-6" id="wrapSchool">
                                    <label class="form-label fw-bold">Sekolah</label>
                                    <select name="school_id" class="form-select selectpicker" data-style="btn-default" data-live-search="true" style="height:50px;">
                                        <option value="">-- Pilih Sekolah --</option>
                                        @foreach($schools as $s)
                                        <option value="{{ $s->id }}" {{ old('school_id')==$s->id ? 'selected':'' }}>{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Susun Atur Teks <span class="text-danger">*</span></label>
                                    <select name="layout_style" class="form-select selectpicker" data-style="btn-default" style="height:50px;">
                                        @foreach(['center'=>'Tengah','bottom'=>'Bawah','left'=>'Kiri','right'=>'Kanan'] as $val => $label)
                                        <option value="{{ $val }}" {{ old('layout_style','center')===$val ? 'selected':'' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="include_signature" id="chkSig" value="1"
                                               {{ old('include_signature') ? 'checked':'' }} onchange="toggleSig(this)">
                                        <label class="form-check-label" for="chkSig">Sertakan Tandatangan</label>
                                    </div>
                                </div>

                                <div class="col-md-6" id="wrapSig" style="{{ old('include_signature') ? '' : 'display:none' }}">
                                    <label class="form-label fw-bold">Imej Tandatangan (PNG)</label>
                                    <input type="file" name="signature" class="form-control @error('signature') is-invalid @enderror" accept=".png,.jpg,.jpeg">
                                    @error('signature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Imej Latar Belakang (JPEG/PNG, maks 5MB)</label>
                                    <input type="file" name="background" class="form-control @error('background') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                                    <small class="text-muted">Dimensi optimum: 2480 × 1754 px (A4 Landskap)</small>
                                    @error('background')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex gap-3 mt--30">
                                <button type="submit" class="rbt-btn btn-gradient btn-sm">Simpan Templat</button>
                                <a href="{{ route('certificates.templates.index') }}" class="rbt-btn btn-border-gradient btn-sm">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleSig(cb) {
    document.getElementById('wrapSig').style.display = cb.checked ? '' : 'none';
}
document.addEventListener('DOMContentLoaded', function () {
    var sel = document.getElementById('selectLevel');
    var wrapSchool = document.getElementById('wrapSchool');
    if (sel && wrapSchool) {
        sel.addEventListener('change', function () {
            wrapSchool.style.display = this.value === 'sekolah' ? '' : 'none';
        });
        // initial state
        wrapSchool.style.display = sel.value === 'sekolah' ? '' : 'none';
    }
});
</script>
@endpush
@endsection
