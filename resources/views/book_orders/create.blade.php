@extends('layout-fb.layout')

@section('content')
@php $cartCount = count($cart); @endphp
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Katalog Buku KAFA</h1>
        <a href="{{ route('book_orders.cart') }}"
           class="relative inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Troli
            @if($cartCount > 0)
            <span id="cart-badge" class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $cartCount }}</span>
            @else
            <span id="cart-badge" class="hidden inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full"></span>
            @endif
        </a>
    </div>

    {{-- Search --}}
    <form action="{{ route('book_orders.create') }}" method="GET" class="flex gap-2 mb-5">
        <input type="text" name="search" value="{{ $search }}"
               placeholder="Cari nama buku atau tahun darjah..."
               class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
        @if($search)
        <a href="{{ route('book_orders.create') }}"
           class="inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            Reset
        </a>
        @endif
    </form>

    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-4 py-3 mb-4 text-sm text-green-700 dark:text-green-400">
        {{ session('success') }}
    </div>
    @endif

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
                        <th class="px-4 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($books as $book)
                    @php $inCart = $cart[$book->id] ?? 0; @endphp
                    <tr id="book-row-{{ $book->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors {{ $inCart > 0 ? 'bg-green-50 dark:bg-green-900/10' : '' }}">
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">
                            {{ $book->name }}
                            @if($inCart > 0)
                            <span class="ml-1 px-1.5 py-0.5 text-xs bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">Troli: {{ $inCart }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center text-gray-600 dark:text-gray-300">{{ $book->tahun_darjah ?? '-' }}</td>
                        <td class="px-4 py-2.5 text-center font-mono text-gray-700 dark:text-gray-300">{{ number_format($book->price, 2) }}</td>
                        <td class="px-4 py-2.5 text-center">
                            <input type="number" id="qty-{{ $book->id }}"
                                   value="{{ $inCart }}" min="0" max="999"
                                   class="w-20 text-center px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <button type="button" onclick="addToCart({{ $book->id }})"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Tiada buku dijumpai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-4">{{ $books->appends(request()->query())->links() }}</div>

    <div class="flex items-center justify-between">
        <a href="{{ route('book_orders.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <a href="{{ route('book_orders.cart') }}"
           class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Semak Troli
            @if($cartCount > 0)
            ({{ $cartCount }} jenis buku)
            @endif
        </a>
    </div>
</div>

<script>
const cartAddUrl = '{{ route('book_orders.cart.add') }}';
const csrfToken  = '{{ csrf_token() }}';

function addToCart(bookId) {
    const qty = parseInt(document.getElementById('qty-' + bookId).value) || 0;

    fetch(cartAddUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ book_id: bookId, quantity: qty }),
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) return;

        const badge = document.getElementById('cart-badge');
        if (data.total_items > 0) {
            badge.textContent = data.total_items;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }

        const row = document.getElementById('book-row-' + bookId);
        if (qty > 0) {
            row.classList.add('bg-green-50', 'dark:bg-green-900/10');
        } else {
            row.classList.remove('bg-green-50', 'dark:bg-green-900/10');
        }

        Swal.fire({
            toast: true, position: 'top-end',
            icon: qty > 0 ? 'success' : 'info',
            title: qty > 0 ? `Ditambah ke troli (${qty} unit)` : 'Dikeluarkan dari troli',
            showConfirmButton: false, timer: 1500,
        });
    })
    .catch(() => Swal.fire({ icon: 'error', title: 'Ralat sambungan' }));
}
</script>
@endsection
