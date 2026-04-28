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
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <div>
                                <h4 class="rbt-title-style-3 mb--0">Butiran Daerah: {{ $district->name }}</h4>
                                <p class="description mt--5">Senarai sekolah di bawah seliaan daerah ini.</p>
                            </div>
                            <a href="{{ url()->previous() }}" class="rbt-btn btn-sm btn-border">
                                <span class="btn-text">Kembali</span>
                            </a>
                        </div>

                        <div class="row g-5 mb--30">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-primary-opacity">
                                    <div class="inner">
                                        <div class="rbt-round-icon bg-primary-opacity">
                                            <i class="feather-home"></i>
                                        </div>
                                        <div class="content">
                                            <h3 class="counter without-icon color-primary"><span class="odometer" data-count="{{ $district->schools->count() }}">{{ $district->schools->count() }}</span></h3>
                                            <span class="rbt-title-style-2 d-block">Jumlah Sekolah</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-secondary-opacity">
                                    <div class="inner">
                                        <div class="rbt-round-icon bg-secondary-opacity">
                                            <i class="feather-users"></i>
                                        </div>
                                        <div class="content">
                                            <h3 class="counter without-icon color-secondary"><span class="odometer" data-count="{{ $district->schools->sum('students_count') }}">{{ $district->schools->sum('students_count') }}</span></h3>
                                            <span class="rbt-title-style-2 d-block">Jumlah Murid</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rbt-dashboard-table table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Nama Sekolah</th>
                                        <th>Kod Sekolah</th>
                                        <th>Jumlah Murid</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($district->schools as $school)
                                    <tr>
                                        <th>{{ $school->name }}</th>
                                        <td>{{ $school->code }}</td>
                                        <td>{{ $school->students_count }} Murid</td>
                                        <td>
                                            <a href="{{ route('schools.show', $school->id) }}" class="rbt-btn-link text-primary"><i class="feather-eye"></i> Lihat</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">Tiada sekolah dijumpai dalam daerah ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
