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
                            <h4 class="rbt-title-style-3">Keputusan Peperiksaan Anak</h4>
                        </div>

                        <div class="row g-5">
                            @forelse($children as $child)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="rbt-card variation-01 rbt-hover">
                                        <div class="inner">
                                            <div class="content">
                                                <h5 class="title">{{ $child->name }}</h5>
                                                <ul class="rbt-meta">
                                                    <li><i class="feather-book"></i> Kelas: {{ $child->kafaClass->display_name }}</li>
                                                    <li><i class="feather-user"></i> MyKid: {{ $child->mykid }}</li>
                                                </ul>
                                                <div class="rbt-card-bottom mt--20">
                                                    <a class="rbt-btn btn-sm btn-gradient" href="{{ route('parent.results.show', $child) }}">Lihat Keputusan</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center">
                                    <p>Tiada maklumat anak ditemui dalam sistem.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
