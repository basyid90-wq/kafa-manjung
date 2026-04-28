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
                            <h4 class="rbt-title-style-3">Edit Aktiviti: {{ $activity->name }}</h4>
                        </div>
                        
                        <form action="{{ route('activities.update', $activity) }}" method="POST" enctype="multipart/form-data" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Aktiviti / Program</label>
                                    <input type="text" name="name" id="name" value="{{ $activity->name }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="tahap">Peringkat Aktiviti</label>
                                    <select name="tahap" id="tahap" class="form-select" style="height:50px;" required>
                                        @foreach($tahapOptions as $value => $label)
                                            <option value="{{ $value }}" {{ $activity->tahap == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="date">Tarikh Aktiviti</label>
                                    <input type="date" name="date" id="date" value="{{ $activity->date }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="description">Deskripsi Ringkas</label>
                                    <textarea name="description" id="description" rows="3">{{ $activity->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="photo">Tukar Gambar Dokumentasi (Opsional)</label>
                                    @if($activity->photo_path)
                                        <div class="mb--10">
                                            <img src="{{ asset('storage/' . $activity->photo_path) }}" alt="Current Photo" style="width: 150px; border-radius: 8px;">
                                        </div>
                                    @endif
                                    <input type="file" name="photo" id="photo" class="form-control" style="padding: 10px;">
                                </div>
                            </div>
                            <div class="col-12 mt--20">
                                <div class="rbt-button-group justify-content-start">
                                    <button type="submit" class="rbt-btn btn-gradient">Kemaskini Aktiviti</button>
                                    <a href="{{ route('activities.index') }}" class="rbt-btn btn-border btn-sm">Batal</a>
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
