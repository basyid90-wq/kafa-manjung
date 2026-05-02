@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Draf Tempahan #{{ $bookOrder->id }}</h1>
        <a href="{{ route('book_orders.show', $bookOrder) }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Batal
        </a>
    </div>

    <div class="flex items-center gap-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg px-4 py-3 mb-4 text-sm text-blue-700 dark:text-blue-400">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Masukkan <strong class="mx-1">0</strong> untuk mengabaikan sesebuah buku.
    </div>

    <form action="{{ route('book_orders.update', $bookOrder) }}" method="POST">
        @csrf
        @method('PUT')

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
                    <tbody id="edit-table-body" class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($books as $book)
                        @php $qty = $existingQty[$book->id]->quantity ?? 0; @endphp
                        <tr id="edit-row-{{ $book->id }}"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors {{ $qty > 0 ? 'bg-green-50 dark:bg-green-900/10' : '' }}"
                            data-price="{{ $book->price }}">
                            <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $book->name }}</td>
                            <td class="px-4 py-2.5 text-center text-gray-600 dark:text-gray-300">{{ $book->tahun_darjah ?? '-' }}</td>
                            <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">{{ number_format($book->price, 2) }}</td>
                            <td class="px-4 py-2.5 text-center">
                                <input type="number" name="items[{{ $book->id }}]"
                                       value="{{ $qty }}" min="0" max="999"
                                       class="edit-qty w-20 text-center px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300 edit-subtotal">
                                {{ number_format($book->price * $qty, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-200 dark:border-gray-600">
                            <td colspan="5" class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">Jumlah Keseluruhan (RM)</td>
                            <td class="px-4 py-3 text-center font-bold text-gray-900 dark:text-white" id="edit-total">
                                {{ number_format($bookOrder->total_price, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span></label>
            <textarea name="notes" rows="3"
                      class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ $bookOrder->notes }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('book_orders.show', $bookOrder) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('edit-table-body').addEventListener('input', function(e) {
    if (!e.target.classList.contains('edit-qty')) return;

    const row     = e.target.closest('tr');
    const price   = parseFloat(row.dataset.price) || 0;
    const qty     = parseInt(e.target.value) || 0;
    const subCell = row.querySelector('.edit-subtotal');

    subCell.textContent = (price * qty).toFixed(2);

    if (qty > 0) {
        row.classList.add('bg-green-50', 'dark:bg-green-900/10');
    } else {
        row.classList.remove('bg-green-50', 'dark:bg-green-900/10');
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
@endsection
