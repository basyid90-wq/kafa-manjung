@extends('layout.layout')

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
                        <div class="section-title d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="rbt-title-style-3">Butiran Tempahan #{{ $bookOrder->id }}</h4>
                            <div class="rbt-button-group flex-wrap gap-2">
                                @if($bookOrder->status === 'draft')
                                    @if(Auth::user()->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA']) || Auth::user()->school_id == $bookOrder->school_id)
                                    <a href="{{ route('book_orders.edit', $bookOrder) }}"
                                       class="rbt-btn btn-border-gradient btn-sm">
                                        <i class="feather-edit-2 me-1"></i> Edit Draf
                                    </a>
                                    <form action="{{ route('book_orders.submit', $bookOrder) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="rbt-btn btn-gradient btn-sm">Hantar Tempahan</button>
                                    </form>
                                    @endif
                                @endif

                                @if($bookOrder->status === 'submitted_by_school' && (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Pentadbir')))
                                    <form action="{{ route('book_orders.approve', $bookOrder) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rbt-btn btn-gradient btn-sm">Luluskan & Hantar ke Pembekal</button>
                                    </form>
                                @endif

                                @if(in_array($bookOrder->status, ['approved_by_admin', 'processing_by_supplier', 'delivered_to_school', 'completed']))
                                    <button onclick="window.print()" class="rbt-btn btn-border btn-sm">Cetak Invois/Rekod</button>
                                @endif

                                @if($bookOrder->status === 'delivered_to_school' && (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Pentadbir')))
                                    <form action="{{ route('book_orders.complete', $bookOrder) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="rbt-btn btn-gradient btn-sm">Tandakan Selesai</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="row g-5 mt--20">
                            <div class="col-lg-6">
                                <p><strong>Sekolah:</strong> {{ $bookOrder->school->name }}</p>
                                <p><strong>Tarikh:</strong> {{ \Carbon\Carbon::parse($bookOrder->order_date)->format('d F Y') }}</p>
                            </div>
                            <div class="col-lg-6">
                                <p><strong>Status:</strong> 
                                    <span class="rbt-badge-5 {{ $bookOrder->status_badge }}">{{ $bookOrder->status_label }}</span>
                                </p>
                                <p><strong>Jumlah Keseluruhan:</strong> RM{{ number_format($bookOrder->total_price, 2) }}</p>
                            </div>
                        </div>

                        <div class="rbt-dashboard-table table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Harga Seunit</th>
                                        <th>Kuantiti</th>
                                        <th>Jumlah (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookOrder->items as $item)
                                    @if($item->quantity > 0)
                                    <tr>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ number_format($item->price_at_order, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price_at_order * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="border-top: 2px solid #eee;">
                                        <td colspan="3" class="text-end"><strong>Jumlah Keseluruhan</strong></td>
                                        <td><strong>RM{{ number_format($bookOrder->total_price, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($bookOrder->notes)
                        <div class="mt--30">
                            <h6>Catatan Sekolah:</h6>
                            <div class="p-3 bg-light rounded">{{ $bookOrder->notes }}</div>
                        </div>
                        @endif

                        <div class="mt--30">
                            <a href="{{ Auth::user()->hasRole('Pembekal') ? route('book_orders.supplier_index') : route('book_orders.index') }}" class="rbt-btn btn-link">Kembali ke Senarai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .rbt-dashboard-area { padding: 0; }
        .partials-sidebar, .rbt-header, .rbt-footer, .rbt-button-group, .btn-link { display: none !important; }
        .col-lg-9 { width: 100% !important; margin: 0; }
        .rbt-shadow-box { box-shadow: none !important; border: none !important; }
    }
</style>
@endsection
