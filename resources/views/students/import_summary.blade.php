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
                        <div class="section-title mb--30">
                            <h4 class="rbt-title-style-3">Ringkasan Import SIMPENI</h4>
                        </div>

                        <div class="row g-5 mb--40">
                            <!-- Statistik -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-primary-opacity p-4 text-center">
                                    <div class="inner">
                                        <div class="rbt-round-icon bg-primary-opacity mb--15 mx-auto">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <div class="content">
                                            <h3 class="counter"><span class="odometer">{{ $summary['total'] }}</span></h3>
                                            <span class="subtitle">Rekod Dibaca</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-success-opacity p-4 text-center">
                                    <div class="inner">
                                        <div class="rbt-round-icon bg-success-opacity mb--15 mx-auto">
                                            <i class="feather-check-circle"></i>
                                        </div>
                                        <div class="content">
                                            <h3 class="counter"><span class="odometer">{{ $summary['success'] }}</span></h3>
                                            <span class="subtitle">Berjaya Disusun</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-danger-opacity p-4 text-center">
                                    <div class="inner">
                                        <div class="rbt-round-icon bg-danger-opacity mb--15 mx-auto">
                                            <i class="feather-alert-triangle"></i>
                                        </div>
                                        <div class="content">
                                            <h3 class="counter"><span class="odometer">{{ $summary['failed_class'] }}</span></h3>
                                            <span class="subtitle">Tiada Kelas</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($summary['failed_class'] > 0)
                            <div class="alert alert-warning d-flex align-items-center justify-content-between mb--40">
                                <div>
                                    <i class="feather-alert-circle me-2"></i>
                                    Terdapat <strong>{{ $summary['failed_class'] }}</strong> murid yang tidak dapat dipadankan dengan kelas sedia ada.
                                </div>
                                <a href="{{ route('students.index', ['class_id' => 'none']) }}" class="rbt-btn btn-sm btn-gradient">Susun Murid Sekarang</a>
                            </div>
                        @endif

                        <div class="section-title mb--20">
                            <h5 class="rbt-title-style-2">Senarai Murid Diimport</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Murid</th>
                                        <th>MyKid</th>
                                        <th>Kelas Padanan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($summary['details'] as $i => $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $row['name'] }}</td>
                                        <td><small class="text-muted">{{ $row['mykid'] }}</small></td>
                                        <td>
                                            @if($row['class'])
                                                <span class="badge bg-success">{{ $row['class'] }}</span>
                                            @else
                                                <span class="badge bg-danger">TIADA PADANAN</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row['class'])
                                                <i class="feather-check-circle text-success" title="Berjaya dipadankan"></i>
                                            @else
                                                <i class="feather-help-circle text-warning" title="Perlu disusun secara manual"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--40 text-end">
                            <a href="{{ route('students.index') }}" class="rbt-btn btn-gradient">Kembali ke Senarai Murid</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
