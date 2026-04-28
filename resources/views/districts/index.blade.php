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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Pengurusan Daerah</h4>
                            <a href="{{ route('districts.create') }}" class="rbt-btn btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Tambah Daerah</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Nama Daerah</th>
                                        <th>Kod</th>
                                        <th>Bil. Sekolah</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($districts as $district)
                                    <tr>
                                        <td>{{ $district->name }}</td>
                                        <td>{{ $district->code ?? '-' }}</td>
                                        <td>{{ $district->schools->count() }}</td>
                                        <td>
                                            <a href="{{ route('districts.edit', $district) }}" class="rbt-btn btn-sm btn-border-gradient">Edit</a>
                                            <form action="{{ route('districts.destroy', $district) }}" method="POST" style="display:inline" onsubmit="return confirm('Adakah anda pasti? Semua sekolah di bawah daerah ini akan turut dipadam.');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rbt-btn btn-sm btn-border-gradient btn-gradient-danger">Padam</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
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
