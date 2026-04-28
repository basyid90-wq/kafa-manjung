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
                            <div>
                                <h4 class="rbt-title-style-3">Slip Keputusan Peperiksaan</h4>
                                <p class="mb--0">Peperiksaan: <strong>{{ $exam->name }} ({{ $exam->year }})</strong></p>
                                <p class="mb--0">Nama Pelajar: <strong>{{ $student->name }}</strong></p>
                            </div>
                            <button onclick="window.print()" class="rbt-btn btn-sm btn-border-gradient d-print-none">Cetak Slip</button>
                        </div>

                        <div class="table-responsive mt--30">
                            <table class="rbt-table table table-bordered">
                                <thead class="bg-color-primary-opacity">
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th class="text-center">Markah</th>
                                        <th class="text-center">Gred</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalMarks = 0;
                                        $subjectCount = count($results);
                                    @endphp
                                    @foreach($results as $result)
                                    <tr>
                                        <td>{{ $result->subject->name }}</td>
                                        <td class="text-center">{{ $result->marks }}</td>
                                        <td class="text-center">
                                            <strong>{{ $result->grade }}</strong>
                                        </td>
                                    </tr>
                                    @php $totalMarks += $result->marks; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-color-secondary-opacity">
                                        <td><strong>Jumlah Keseluruhan</strong></td>
                                        <td class="text-center"><strong>{{ $totalMarks }}</strong></td>
                                        <td class="text-center"><strong>Purata: {{ $subjectCount > 0 ? round($totalMarks / $subjectCount, 2) : 0 }}%</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt--50">
                            <h6>Petunjuk Gred:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><strong>A:</strong> 80 - 100 (Cemerlang)</li>
                                        <li><strong>B:</strong> 60 - 79 (Baik)</li>
                                        <li><strong>C:</strong> 50 - 59 (Memuaskan)</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><strong>D:</strong> 40 - 49 (Mencapai Tahap Minimum)</li>
                                        <li><strong>E:</strong> 0 - 39 (Belum Mencapai Tahap Minimum)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .d-print-none, .rbt-default-sidebar, .header-area, .footer-area {
        display: none !important;
    }
    .col-lg-9 {
        width: 100% !important;
    }
}
</style>
@endsection
