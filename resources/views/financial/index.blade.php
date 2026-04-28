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
                            @role('Penyelia KAFA')
                            <h4 class="rbt-title-style-3">Semakan Kewangan Daerah</h4>
                            @else
                            <h4 class="rbt-title-style-3">Pengurusan Kewangan</h4>
                            @endrole
                            @hasanyrole('Super Admin|Pentadbir|Bendahari Sekolah')
                            <div class="rbt-button-group">
                                <a href="{{ route('financial.create') }}" class="rbt-btn btn-sm btn-gradient">Tambah Rekod</a>
                            </div>
                            @endhasanyrole
                        </div>

                        <!-- Balance Summary Card -->
                        <div class="row g-5 mb--30">
                            <div class="col-12">
                                <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed {{ $balance >= 0 ? 'bg-primary-opacity' : 'bg-danger-opacity' }}">
                                    <div class="inner">
                                        <div class="rbt-round-icon {{ $balance >= 0 ? 'bg-primary-opacity' : 'bg-danger-opacity' }}">
                                            <i class="feather-credit-card"></i>
                                        </div>
                                        <div class="content">
                                            <h3 class="counter without-icon {{ $balance >= 0 ? 'color-primary' : 'color-danger' }}">RM {{ number_format($balance, 2) }}</h3>
                                            @role('Penyelia KAFA')
                                            <span class="rbt-title-style-2 d-block">Jumlah Baki Keseluruhan Daerah</span>
                                            @else
                                            <span class="rbt-title-style-2 d-block">Baki Semasa Akaun Sekolah</span>
                                            @endrole
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Tarikh</th>
                                        @role('Penyelia KAFA')
                                        <th>Sekolah</th>
                                        @endrole
                                        <th>Kategori</th>
                                        <th>Jenis</th>
                                        <th>Jumlah (RM)</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $record)
                                    <tr>
                                        <td>{{ $record->transaction_date }}</td>
                                        @role('Penyelia KAFA')
                                        <td>{{ $record->school->name ?? '-' }}</td>
                                        @endrole
                                        <td>{{ $record->category->name }}</td>
                                        <td>
                                            <span class="badge {{ $record->transaction_type == 'in' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $record->transaction_type == 'in' ? 'Masuk' : 'Keluar' }}
                                            </span>
                                        </td>
                                        <td><strong>{{ number_format($record->amount, 2) }}</strong></td>
                                        <td>{{ $record->status }}</td>
                                        <td>
                                            <a href="{{ route('financial.export', $record) }}" class="rbt-btn btn-xs btn-border-gradient" target="_blank">PDF</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->hasRole('Penyelia KAFA') ? 7 : 6 }}" class="text-center">Tiada rekod transaksi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--20">
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
