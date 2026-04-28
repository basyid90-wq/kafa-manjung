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
                            <h4 class="rbt-title-style-3">Tempahan Buku KAFA</h4>
                            @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                            <a href="{{ route('book_orders.supplier_summary') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-bar-chart-2 me-1"></i> Ringkasan Pembekal
                            </a>
                            @endhasanyrole

                            @hasanyrole('Guru Besar|Penyelia KAFA')
                            <a href="{{ route('book_orders.create') }}" class="rbt-btn btn-gradient btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Buat Tempahan Baru</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                            @endhasanyrole

                            @hasrole('Pembekal')
                            <a href="{{ route('book_orders.supplier_index') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-list me-1"></i> Senarai Tempahan Pembekal
                            </a>
                            @endrole
                        </div>

                        <div class="rbt-dashboard-table table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @hasanyrole('Super Admin|Pentadbir|Pembekal|Penyelia KAFA')
                                        <th>Sekolah</th>
                                        @endhasanyrole
                                        <th>Tarikh</th>
                                        <th>Jumlah (RM)</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                                        @hasanyrole('Super Admin|Pentadbir|Pembekal|Penyelia KAFA')
                                        <td>{{ $order->school->name ?? '-' }}</td>
                                        @endhasanyrole
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            <span class="rbt-badge-5 {{ $order->status_badge }}">{{ $order->status_label }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('book_orders.show', $order) }}"
                                                   class="rbt-btn btn-xs btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   style="width:35px;height:35px;" title="Lihat Butiran">
                                                    <i class="feather-eye" style="font-size:14px;"></i>
                                                </a>

                                                @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                                                <form action="{{ route('book_orders.destroy', $order) }}" method="POST"
                                                      data-delete-form data-name="Tempahan #{{ $order->id }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger p-0 d-flex align-items-center justify-content-center"
                                                            style="width:35px;height:35px;" title="Padam">
                                                        <i class="feather-trash-2" style="font-size:14px;"></i>
                                                    </button>
                                                </form>
                                                @else
                                                    @if($order->status == 'draft')
                                                    <form action="{{ route('book_orders.destroy', $order) }}" method="POST"
                                                          data-delete-form data-name="Draf Tempahan #{{ $order->id }}">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                                class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger p-0 d-flex align-items-center justify-content-center"
                                                                style="width:35px;height:35px;" title="Padam Draf">
                                                            <i class="feather-trash-2" style="font-size:14px;"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                @endhasanyrole
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tiada rekod tempahan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt--20">
                            <div class="col-lg-12">
                                {{ $orders->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
