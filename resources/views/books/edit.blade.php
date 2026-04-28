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
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Edit Maklumat Buku</h4>
                        </div>
                        
                        <form action="{{ route('books.update', $book) }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Buku</label>
                                    <input type="text" name="name" id="name" value="{{ $book->name }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="tahun_darjah">Tahun/Darjah (Opsional)</label>
                                    <input type="text" name="tahun_darjah" id="tahun_darjah" value="{{ $book->tahun_darjah }}" placeholder="Contoh: Tahun 1 / Tahap 1">
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="price">Harga (RM)</label>
                                    <input type="number" name="price" id="price" step="0.01" value="{{ $book->price }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="description">Catatan / Deskripsi (Opsional)</label>
                                    <textarea name="description" id="description" rows="3">{{ $book->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mt--20">
                                <div class="rbt-button-group justify-content-start">
                                    <button type="submit" class="rbt-btn btn-gradient">Kemaskini Buku</button>
                                    <a href="{{ route('books.index') }}" class="rbt-btn btn-border btn-sm">Batal</a>
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
