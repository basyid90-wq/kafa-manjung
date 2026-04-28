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
                            <h4 class="rbt-title-style-3">Pengurusan Pesanan Pembekal</h4>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Sekolah</th>
                                        <th>Jumlah (RM)</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->school->name }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            <span class="rbt-badge-5 {{ $order->status_badge }}">{{ $order->status_label }}</span>
                                        </td>
                                        <td>
                                            <div class="rbt-button-group justify-content-start">
                                                @if($order->status == 'approved_by_admin')
                                                    <form action="{{ route('book_orders.process', $order) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="rbt-btn btn-xs btn-gradient">Sahkan Pesanan</button>
                                                    </form>
                                                @endif

                                                @if($order->status == 'processing_by_supplier')
                                                    <form action="{{ route('book_orders.deliver', $order) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="rbt-btn btn-xs btn-gradient">Selesai Dihantar</button>
                                                    </form>
                                                @endif
                                                
                                                <a href="{{ route('book_orders.show', $order) }}" class="rbt-btn btn-xs btn-border-gradient">Lihat Detail</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tiada pesanan aktif untuk diuruskan.</td>
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
