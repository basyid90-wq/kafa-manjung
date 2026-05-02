@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Semak Troli Tempahan</h1>
        <a href="{{ route('book_orders.create') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Buku Lagi
        </a>
    </div>

    @if(session('error'))
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg px-4 py-3 mb-4 text-sm text-red-700 dark:text-red-400">
        {{ session('error') }}
    </div>
    @endif

    @if(empty($cart))
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Troli anda kosong.
            <a href="{{ route('book_orders.create') }}" class="text-blue-600 dark:text-blue-400 font-medium">Pilih buku untuk ditempah.</a>
        </p>
    </div>
    @else

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-4">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Buku</th>
                        <th class="px-4 py-3 text-center">Tahun</th>
                        <th class="px-4 py-3 text-center">Harga (RM)</th>
                        <th class="px-4 py-3 text-center w-32">Kuantiti</th>
                        <th class="px-4 py-3 text-center">Subtotal (RM)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @php $i = 1; @endphp
                    @foreach($cart as $bookId => $qty)
                    @if(isset($books[$bookId]))
                    @php $book = $books[$bookId]; $subtotal = $book->price * $qty; @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i++ }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $book->name }}</td>
                        <td class="px-4 py-2.5 text-center text-gray-600 dark:text-gray-300">{{ $book->tahun_darjah ?? '-' }}</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">{{ number_format($book->price, 2) }}</td>
                        <td class="px-4 py-2.5 text-center">
                            <input type="number" id="cart-qty-{{ $bookId }}"
                                   value="{{ $qty }}" min="0" max="999"
                                   class="w-20 text-center px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                   onchange="updateCartItem({{ $bookId }}, this.value)">
                        </td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300" id="subtotal-{{ $bookId }}">
                            {{ number_format($subtotal, 2) }}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-200 dark:border-gray-600">
                        <td colspan="5" class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">Jumlah Keseluruhan (RM)</td>
                        <td class="px-4 py-3 text-center font-bold text-gray-900 dark:text-white" id="grand-total">
                            {{ number_format($totalPrice, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Notes & submit --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-4">
        <form action="{{ route('book_orders.store') }}" method="POST" id="store-form">
            @csrf
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span></label>
            <textarea name="notes" rows="3"
                      placeholder="Tulis sebarang keterangan khas..."
                      class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
        </form>
    </div>

    <div class="flex items-center justify-between flex-wrap gap-3">
        <form action="{{ route('book_orders.cart.clear') }}" method="POST"
              data-delete-form data-name="semua item dalam troli">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg hover:bg-red-100 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Kosongkan Troli
            </button>
        </form>

        <button type="submit" form="store-form"
                class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Cipta Draf Tempahan
        </button>
    </div>

    @endif
</div>

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

        const price = bookPrices[bookId] || 0;
        const sub = document.getElementById('subtotal-' + bookId);
        if (sub) sub.textContent = (price * qty).toFixed(2);

        let total = 0;
        Object.keys(bookPrices).forEach(id => {
            const qtyEl = document.getElementById('cart-qty-' + id);
            if (qtyEl) total += bookPrices[id] * (parseInt(qtyEl.value) || 0);
        });
        const grandEl = document.getElementById('grand-total');
        if (grandEl) grandEl.textContent = total.toFixed(2);

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
@endsection
