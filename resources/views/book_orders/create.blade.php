@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
    $cartCount = count($cart);
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

                        <div class="section-title d-flex justify-content-between align-items-center mb--20 flex-wrap gap-2">
                            <h4 class="rbt-title-style-3">Katalog Buku KAFA</h4>
                            <a href="{{ route('book_orders.cart') }}"
                               class="rbt-btn btn-gradient position-relative"
                               style="padding:8px 16px; font-size:0.85em;">
                                <i class="feather-shopping-cart me-1"></i> Troli
                                <span id="cart-badge"
                                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                      style="font-size:0.7em; {{ $cartCount > 0 ? '' : 'display:none;' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>
                        </div>

                        {{-- Search --}}
                        <form action="{{ route('book_orders.create') }}" method="GET" class="d-flex gap-2 mb--20">
                            <input type="text" name="search" value="{{ $search }}"
                                   class="form-control" placeholder="Cari nama buku atau tahun darjah...">
                            <button type="submit" class="rbt-btn btn-border-gradient" style="white-space:nowrap;">
                                <i class="feather-search"></i>
                            </button>
                            @if($search)
                                <a href="{{ route('book_orders.create') }}" class="rbt-btn btn-border btn-sm" style="white-space:nowrap;">Reset</a>
                            @endif
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Buku</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Harga (RM)</th>
                                        <th class="text-center" style="width:130px;">Kuantiti</th>
                                        <th class="text-center" style="width:100px;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($books as $book)
                                    @php $inCart = isset($cart[$book->id]) ? $cart[$book->id] : 0; @endphp
                                    <tr id="book-row-{{ $book->id }}" class="{{ $inCart > 0 ? 'table-success' : '' }}">
                                        <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                                        <td>
                                            {{ $book->name }}
                                            @if($inCart > 0)
                                                <span class="rbt-badge-5 bg-success-opacity color-success ms-1" style="font-size:0.75em;">
                                                    Dalam troli: {{ $inCart }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $book->tahun_darjah ?? '-' }}</td>
                                        <td class="text-center">{{ number_format($book->price, 2) }}</td>
                                        <td class="text-center">
                                            <input type="number"
                                                   id="qty-{{ $book->id }}"
                                                   class="form-control text-center"
                                                   value="{{ $inCart }}"
                                                   min="0" max="999"
                                                   style="height:38px; padding:4px 8px;">
                                        </td>
                                        <td class="text-center">
                                            <button type="button"
                                                    class="rbt-btn btn-xs btn-gradient"
                                                    style="padding:6px 12px; font-size:0.8em;"
                                                    onclick="addToCart({{ $book->id }})">
                                                <i class="feather-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tiada buku dijumpai.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--20">
                            {{ $books->appends(request()->query())->links() }}
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt--20">
                            <a href="{{ route('book_orders.index') }}" class="rbt-btn btn-link">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                            <a href="{{ route('book_orders.cart') }}" class="rbt-btn btn-gradient">
                                <i class="feather-shopping-cart me-1"></i>
                                Semak Troli
                                @if($cartCount > 0)
                                    ({{ $cartCount }} jenis buku)
                                @endif
                            </a>
                        </div>

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

function addToCart(bookId) {
    const qty = parseInt(document.getElementById('qty-' + bookId).value) || 0;

    fetch(cartAddUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ book_id: bookId, quantity: qty }),
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) return;

        const badge = document.getElementById('cart-badge');
        if (data.total_items > 0) {
            badge.textContent = data.total_items;
            badge.style.display = '';
        } else {
            badge.style.display = 'none';
        }

        // Visual feedback on row
        const row = document.getElementById('book-row-' + bookId);
        if (qty > 0) {
            row.classList.add('table-success');
        } else {
            row.classList.remove('table-success');
        }

        // Show toast
        const msg = qty > 0
            ? `Ditambah ke troli (${qty} unit)`
            : 'Dikeluarkan dari troli';

        Swal.fire({
            toast: true, position: 'top-end',
            icon: qty > 0 ? 'success' : 'info',
            title: msg,
            showConfirmButton: false, timer: 1500,
        });
    })
    .catch(() => Swal.fire({ icon: 'error', title: 'Ralat sambungan' }));
}
</script>
@endpush
