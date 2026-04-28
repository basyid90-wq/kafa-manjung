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

                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Semak Troli Tempahan</h4>
                            <a href="{{ route('book_orders.create') }}" class="rbt-btn btn-border-gradient btn-sm">
                                <i class="feather-plus me-1"></i> Tambah Buku Lagi
                            </a>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if(empty($cart))
                            <div class="alert alert-warning text-center py-5">
                                <i class="feather-shopping-cart" style="font-size:2em; display:block; margin-bottom:10px;"></i>
                                Troli anda kosong. <a href="{{ route('book_orders.create') }}">Pilih buku untuk ditempah.</a>
                            </div>
                        @else

                        <div class="table-responsive mb--20">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Buku</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Harga (RM)</th>
                                        <th class="text-center" style="width:120px;">Kuantiti</th>
                                        <th class="text-center">Subtotal (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($cart as $bookId => $qty)
                                    @if(isset($books[$bookId]))
                                    @php
                                        $book    = $books[$bookId];
                                        $subtotal = $book->price * $qty;
                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $book->name }}</td>
                                        <td class="text-center">{{ $book->tahun_darjah ?? '-' }}</td>
                                        <td class="text-center">{{ number_format($book->price, 2) }}</td>
                                        <td class="text-center">
                                            <input type="number"
                                                   id="cart-qty-{{ $bookId }}"
                                                   class="form-control text-center"
                                                   value="{{ $qty }}"
                                                   min="0" max="999"
                                                   style="height:38px; padding:4px 8px;"
                                                   onchange="updateCartItem({{ $bookId }}, this.value)">
                                        </td>
                                        <td class="text-center" id="subtotal-{{ $bookId }}">
                                            {{ number_format($subtotal, 2) }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="border-top:2px solid #eee;">
                                        <td colspan="5" class="text-end"><strong>Jumlah Keseluruhan (RM)</strong></td>
                                        <td class="text-center" id="grand-total">
                                            <strong>{{ number_format($totalPrice, 2) }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Create Order Form --}}
                        <form action="{{ route('book_orders.store') }}" method="POST" id="store-form">
                            @csrf
                            <div class="rbt-form-group mb--20">
                                <label for="notes">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3"
                                          placeholder="Tulis sebarang keterangan khas..."></textarea>
                            </div>
                        </form>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <form action="{{ route('book_orders.cart.clear') }}" method="POST"
                                  data-delete-form data-name="semua item dalam troli">
                                @csrf
                                <button type="submit" class="rbt-btn btn-border btn-sm">
                                    <i class="feather-trash-2 me-1"></i> Kosongkan Troli
                                </button>
                            </form>

                            <button type="submit" form="store-form" class="rbt-btn btn-gradient">
                                <i class="feather-file-text me-1"></i> Cipta Draf Tempahan
                            </button>
                        </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const cartAddUrl = '{{ route('book_orders.cart.add') }}';
const csrfToken  = '{{ csrf_token() }}';

const bookPrices = {
    @foreach($cart as $bookId => $qty)
    @if(isset($books[$bookId]))
    {{ $bookId }}: {{ $books[$bookId]->price }},
    @endif
    @endforeach
};

function updateCartItem(bookId, qty) {
    qty = Math.max(0, parseInt(qty) || 0);

    fetch(cartAddUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ book_id: bookId, quantity: qty }),
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) return;

        const price  = bookPrices[bookId] || 0;
        const sub    = document.getElementById('subtotal-' + bookId);
        if (sub) sub.textContent = (price * qty).toFixed(2);

        // Recalculate grand total from all subtotals
        let total = 0;
        Object.keys(bookPrices).forEach(id => {
            const qtyEl = document.getElementById('cart-qty-' + id);
            if (qtyEl) total += bookPrices[id] * (parseInt(qtyEl.value) || 0);
        });
        const grandEl = document.getElementById('grand-total');
        if (grandEl) grandEl.innerHTML = '<strong>' + total.toFixed(2) + '</strong>';

        if (qty === 0) {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'info',
                title: 'Item akan dikeluarkan dari troli selepas muat semula.',
                showConfirmButton: false, timer: 2000,
            });
        }
    });
}
</script>
@endpush
