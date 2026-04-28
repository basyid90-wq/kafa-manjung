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
                            <h4 class="rbt-title-style-3">Profil Analisis Murid</h4>
                            <div class="rbt-button-group">
                                <a href="{{ route('reports.export.pdf', $student) }}" class="rbt-btn btn-xs btn-gradient"><i class="feather-file-text"></i> PDF</a>
                                <a href="{{ route('reports.export.excel', $student) }}" class="rbt-btn btn-xs btn-border"><i class="feather-grid"></i> Excel</a>
                            </div>
                        </div>

                        <div class="student-info-section mb--40 p-4" style="background: #f9f9f9; border-radius: 10px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb--5"><strong>Nama:</strong> {{ $student->name }}</p>
                                    <p class="mb--5"><strong>MyKid:</strong> {{ $student->mykid }}</p>
                                    <p class="mb--5"><strong>Jantina:</strong> {{ $student->gender }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb--5"><strong>Sekolah:</strong> {{ $student->school->name }}</p>
                                    <p class="mb--5"><strong>Kelas:</strong> {{ $student->kafaClass->display_name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Spacing and Row for Stats -->
                        <div class="row g-5 mb--40 text-center">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="p-4 shadow-sm" style="border-radius: 8px; border: 1px solid #eee;">
                                    <h6 class="mb--0">Kehadiran</h6>
                                    <h2 class="mb--0 color-primary">{{ $data['attendance']['percentage'] }}%</h2>
                                    <p class="small text-muted">{{ $data['attendance']['present_days'] }}/{{ $data['attendance']['total_days'] }} Hari</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="p-4 shadow-sm" style="border-radius: 8px; border: 1px solid #eee;">
                                    <h6 class="mb--0">Kesalahan Disiplin</h6>
                                    <h2 class="mb--0 color-danger">{{ $data['disciplinary_records']->count() }}</h2>
                                    <p class="small text-muted">Kes Rekod</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="p-4 shadow-sm" style="border-radius: 8px; border: 1px solid #eee;">
                                    <h6 class="mb--0">Penyertaan Aktiviti</h6>
                                    <h2 class="mb--0 color-success">{{ $data['activities']->count() }}</h2>
                                    <p class="small text-muted">Program</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Tables -->
                        <div class="report-details">
                            <h5 class="mb--20">Keputusan Peperiksaan</h5>
                            <div class="table-responsive mb--40">
                                <table class="table table-bordered small">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Peperiksaan</th>
                                            <th>Subjek</th>
                                            <th>Markah</th>
                                            <th>Gred</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['exam_results'] as $res)
                                        <tr>
                                            <td>{{ $res->exam->name }}</td>
                                            <td>{{ $res->subject->name }}</td>
                                            <td>{{ $res->score }}</td>
                                            <td>
                                                @php
                                                    $grade = 'G';
                                                    if($res->score >= 80) $grade = 'A';
                                                    elseif($res->score >= 60) $grade = 'B';
                                                    elseif($res->score >= 40) $grade = 'C';
                                                    elseif($res->score >= 30) $grade = 'D';
                                                @endphp
                                                <strong>{{ $grade }}</strong>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="mb--20">Kronologi Disiplin</h5>
                            <div class="table-responsive mb--40">
                                <table class="table table-bordered small">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tarikh</th>
                                            <th>Butiran Kesalahan</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['disciplinary_records'] as $dis)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($dis->date)->format('d/m/Y') }}</td>
                                            <td>{{ $dis->offense_details }}</td>
                                            <td>{{ $dis->action_taken }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="rbt-button-group justify-content-start mt--40">
                            <a href="{{ route('reports.index') }}" class="rbt-btn btn-border btn-sm">Kembali ke Senarai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
