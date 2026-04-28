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
                            <h4 class="rbt-title-style-3">Edit Draf Tempahan #{{ $bookOrder->id }}</h4>
                            <a href="{{ route('book_orders.show', $bookOrder) }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left me-1"></i> Batal
                            </a>
                        </div>

                        <div class="alert alert-info mb--20">
                            <i class="feather-info me-1"></i>
                            Masukkan <strong>0</strong> untuk mengabaikan sesebuah buku.
                        </div>

                        <form action="{{ route('book_orders.update', $bookOrder) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="table-responsive mb--20">
                                <table class="rbt-table table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Buku</th>
                                            <th class="text-center">Tahun</th>
                                            <th class="text-center">Harga (RM)</th>
                                            <th class="text-center" style="width:130px;">Kuantiti</th>
                                            <th class="text-center">Subtotal (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit-table-body">
                                        @foreach($books as $book)
                                        @php $qty = $existingQty[$book->id]->quantity ?? 0; @endphp
                                        <tr id="edit-row-{{ $book->id }}" class="{{ $qty > 0 ? 'table-success' : '' }}"
                                            data-price="{{ $book->price }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $book->name }}</td>
                                            <td class="text-center">{{ $book->tahun_darjah ?? '-' }}</td>
                                            <td class="text-center">{{ number_format($book->price, 2) }}</td>
                                            <td class="text-center">
                                                <input type="number"
                                                       name="items[{{ $book->id }}]"
                                                       value="{{ $qty }}"
                                                       min="0" max="999"
                                                       class="form-control text-center edit-qty"
                                                       style="height:38px; padding:4px 8px;">
                                            </td>
                                            <td class="text-center edit-subtotal">
                                                {{ number_format($book->price * $qty, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="border-top:2px solid #eee;">
                                            <td colspan="5" class="text-end"><strong>Jumlah Keseluruhan (RM)</strong></td>
                                            <td class="text-center"><strong id="edit-total">
                                                {{ number_format($bookOrder->total_price, 2) }}
                                            </strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="rbt-form-group mb--20">
                                <label for="notes">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3">{{ $bookOrder->notes }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('book_orders.show', $bookOrder) }}" class="rbt-btn btn-border btn-sm">Batal</a>
                                <button type="submit" class="rbt-btn btn-gradient">
                                    <i class="feather-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('edit-table-body').addEventListener('input', function(e) {
    if (!e.target.classList.contains('edit-qty')) return;

    const row     = e.target.closest('tr');
    const price   = parseFloat(row.dataset.price) || 0;
    const qty     = parseInt(e.target.value) || 0;
    const subCell = row.querySelector('.edit-subtotal');

    subCell.textContent = (price * qty).toFixed(2);

    if (qty > 0) {
        row.classList.add('table-success');
    } else {
        row.classList.remove('table-success');
    }

    let total = 0;
    document.querySelectorAll('#edit-table-body tr').forEach(r => {
        const p = parseFloat(r.dataset.price) || 0;
        const q = parseInt(r.querySelector('.edit-qty')?.value) || 0;
        total += p * q;
    });
    document.getElementById('edit-total').textContent = total.toFixed(2);
});
</script>
@endpush
