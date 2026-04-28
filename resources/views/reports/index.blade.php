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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Laporan & Analisis Murid</h4>
                            <a href="{{ route('reports.bulk.export') }}" class="rbt-btn btn-xs btn-border"><i class="feather-download"></i> Eksport Pukal (Excel)</a>
                        </div>
                        
                        <div class="rbt-search-with-category mb--30">
                            <form action="{{ route('reports.index') }}" method="GET" class="rbt-search-style-1">
                                <input type="text" name="search" placeholder="Cari Nama Murid atau MyKid..." value="{{ request('search') }}">
                                <button type="submit" class="search-btn"><i class="feather-search"></i></button>
                            </form>
                        </div>

                        <div class="rbt-dashboard-table table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>MyKid</th>
                                        <th>Kelas</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->mykid }}</td>
                                        <td>{{ $student->kafaClass->display_name }}</td>
                                        <td>
                                            <a href="{{ route('reports.show', $student) }}" class="rbt-btn btn-gradient btn-xs">Papar Analisis</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt--20">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
