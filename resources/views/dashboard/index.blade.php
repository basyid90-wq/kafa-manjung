@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
@endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<style>
    .bg-primary-opacity { background: rgba(110, 65, 255, 0.1) !important; color: #6e41ff !important; }
    .bg-secondary-opacity { background: rgba(23, 162, 184, 0.1) !important; color: #17a2b8 !important; }
    .bg-pink-opacity { background: rgba(232, 62, 140, 0.1) !important; color: #e83e8c !important; }
    .bg-warning-opacity { background: rgba(255, 193, 7, 0.1) !important; color: #ffc107 !important; }
    .bg-info-opacity { background: rgba(0, 123, 255, 0.1) !important; color: #007bff !important; }
    .bg-success-opacity { background: rgba(40, 167, 69, 0.1) !important; color: #28a745 !important; }
    .bg-danger-opacity { background: rgba(220, 53, 69, 0.1) !important; color: #dc3545 !important; }
    
    .color-primary { color: #6e41ff !important; }
    .color-secondary { color: #17a2b8 !important; }
    .color-pink { color: #e83e8c !important; }
    .color-warning { color: #ffc107 !important; }
    .color-info { color: #007bff !important; }
    .color-success { color: #28a745 !important; }
    .color-danger { color: #dc3545 !important; }
</style>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Dashboard ({{ $role }})</h4>
                        </div>

                        @hasanyrole('Super Admin|Pentadbir')
                            @include('dashboard.admin')
                        @endhasanyrole

                        @role('Penyelia KAFA')
                            @include('dashboard.penyelia')
                        @endrole

                        @role('Guru Besar')
                            @include('dashboard.gurubesar')
                        @endrole

                        @role('Guru KAFA')
                            @include('dashboard.guru')
                        @endrole
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
