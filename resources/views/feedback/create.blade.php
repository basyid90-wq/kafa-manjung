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
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <div>
                                <h4 class="rbt-title-style-3">Laporkan Masalah</h4>
                                <p class="text-muted mb-0" style="font-size:13px;">Aduan anda akan disemak oleh pentadbir sistem.</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data"
                              class="rbt-profile-row rbt-default-form row row--15">
                            @csrf

                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <label for="module">Modul Bermasalah <span class="text-danger">*</span></label>
                                    <select name="module" id="module" class="rbt-big-select" required>
                                        <option value="">-- Pilih Modul --</option>
                                        @foreach($modules as $m)
                                            <option value="{{ $m }}" {{ old('module') === $m ? 'selected' : '' }}>{{ $m }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <label for="description">Penerangan Masalah <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="5"
                                              class="form-control" placeholder="Huraikan masalah yang dihadapi dengan jelas..."
                                              maxlength="2000" required>{{ old('description') }}</textarea>
                                    <small class="text-muted">Maksimum 2000 aksara</small>
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <label for="image">Tangkapan Skrin <span class="text-muted">(pilihan)</span></label>
                                    <input type="file" name="image" id="image"
                                           class="form-control" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Saiz maksimum: 4MB</small>

                                    {{-- Preview --}}
                                    <div id="imagePreview" style="display:none; margin-top:10px;">
                                        <img id="previewImg" src="#" alt="Preview"
                                             style="max-width:300px; max-height:200px; border-radius:8px; border:1px solid #ddd;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt--30">
                                <div class="rbt-button-group justify-content-start">
                                    <button type="submit" class="rbt-btn btn-gradient hover-icon-reverse">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Hantar Aduan</span>
                                            <span class="btn-icon"><i class="feather-send"></i></span>
                                            <span class="btn-icon"><i class="feather-send"></i></span>
                                        </span>
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="rbt-btn btn-border">Batal</a>
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
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('previewImg').src = ev.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
