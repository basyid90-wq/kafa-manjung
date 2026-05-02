@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Katalog Buku KAFA</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Senarai buku yang boleh ditempah oleh sekolah</p>
        </div>
        @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
        <a href="{{ route('books.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Buku Baru
        </a>
        @endhasanyrole
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Nama Buku</th>
                        <th class="px-5 py-3">Tahun/Darjah</th>
                        <th class="px-5 py-3 text-right">Harga (RM)</th>
                        @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                        @endhasanyrole
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($books as $book)
                    <tr id="row-{{ $book->id }}" class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $book->name }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            @if($book->tahun_darjah)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                {{ $book->tahun_darjah }}
                            </span>
                            @else
                            <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right font-mono text-gray-800 dark:text-gray-200 font-medium">
                            {{ number_format($book->price, 2) }}
                        </td>
                        @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('books.edit', $book) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST"
                                      onsubmit="return confirm('Padam buku {{ addslashes($book->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                            title="Padam">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endhasanyrole
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada buku dalam katalog.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($books->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $books->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
