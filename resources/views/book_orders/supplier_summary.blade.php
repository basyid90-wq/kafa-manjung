@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
    $monthNames = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
        5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
    ];
@endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container text-start">
        <div class="row mt--0">
            @include('partials.sidebar')
            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">

                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">Rumusan Tempahan untuk Pembekal</h4>
                        </div>

                        {{-- Filter --}}
                        <form action="{{ route('book_orders.supplier_summary') }}" method="GET"
                              class="row g-3 mb--30">
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="rbt-form-group">
                                    <label class="form-label">Bulan</label>
                                    <select name="month" class="rbt-big-select">
                                        <option value="">-- Semua Bulan --</option>
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                                {{ $monthNames[$m] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="rbt-form-group">
                                    <label class="form-label">Tahun</label>
                                    <select name="year" class="rbt-big-select">
                                        <option value="">-- Semua Tahun --</option>
                                        @foreach(range(date('Y') - 2, date('Y')) as $y)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-12 d-flex align-items-end">
                                <button type="submit" class="rbt-btn btn-gradient w-100">Tapis</button>
                            </div>
                            <div class="col-lg-3 col-md-4 col-12 d-flex align-items-end">
                                @php
                                    $pdfUrl = route('book_orders.supplier_summary.pdf', array_filter(['month' => $month, 'year' => $year]));
                                @endphp
                                <button type="button" class="rbt-btn btn-border-gradient w-100"
                                        onclick="openPdfBlob(this, '{{ $pdfUrl }}')">
                                    <i class="feather-file-text me-1"></i> Cetak PDF
                                </button>
                            </div>
                        </form>

                        @if($month || $year)
                        <p class="mb--20 text-muted">
                            Menunjukkan data bagi:
                            <strong>{{ $month ? $monthNames[(int)$month] : 'Semua Bulan' }} {{ $year ?: '' }}</strong>
                        </p>
                        @else
                        <p class="mb--20 text-muted">Ringkasan kuantiti keseluruhan bagi semua tempahan yang telah diluluskan/selesai.</p>
                        @endif

                        <div class="rbt-dashboard-table table-responsive mt--20">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Buku</th>
                                        <th class="text-center">Kuantiti Keseluruhan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @forelse($summary as $i => $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $row->book->name }}</td>
                                        <td class="text-center"><strong>{{ $row->total_quantity }} unit</strong></td>
                                    </tr>
                                    @php $grandTotal += $row->total_quantity; @endphp
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">Tiada data untuk tempoh yang dipilih.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if($summary->isNotEmpty())
                                <tfoot>
                                    <tr style="border-top: 2px solid #eee;">
                                        <td colspan="2" class="text-end"><strong>Jumlah Keseluruhan Unit</strong></td>
                                        <td class="text-center"><strong>{{ $grandTotal }} unit</strong></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>

                        <div class="mt--30">
                            <a href="{{ route('book_orders.index') }}" class="rbt-btn btn-link">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
