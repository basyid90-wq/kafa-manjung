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
                            <h4 class="rbt-title-style-3">Edit Daerah</h4>
                        </div>

                        <form action="{{ route('districts.update', $district) }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Daerah</label>
                                    <input type="text" id="name" name="name" value="{{ $district->name }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="code">Kod Daerah (Pilihan)</label>
                                    <input type="text" id="code" name="code" value="{{ $district->code }}">
                                </div>
                            </div>

                            <div class="col-12 mt--30">
                                <div class="rbt-button-group justify-content-start">
                                    <button class="rbt-btn btn-gradient hover-icon-reverse" type="submit">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Kemaskini Daerah</span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                        </span>
                                    </button>
                                    <a href="{{ route('districts.index') }}" class="rbt-btn btn-border-gradient">Batal</a>
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
