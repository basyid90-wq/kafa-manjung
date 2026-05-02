@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Buku Baru</h1>
        <a href="{{ route('books.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="space-y-4 mb-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="name" placeholder="Contoh: Buku Teks Jawi Tahun 1" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun/Darjah <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="tahun_darjah" placeholder="Contoh: Tahun 1 / Tahap 1"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga (RM) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" step="0.01" placeholder="0.00" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan / Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <textarea name="description" rows="3"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Simpan Buku
                </button>
                <a href="{{ route('books.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
