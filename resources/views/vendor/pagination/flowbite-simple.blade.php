@if ($paginator->hasPages())
<nav aria-label="Pagination" class="flex items-center justify-between mt-4 flex-wrap gap-3">

    <p class="text-sm text-gray-500 dark:text-gray-400">
        Halaman <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $paginator->currentPage() }}</span>
    </p>

    <ul class="inline-flex -space-x-px text-sm">

        @if ($paginator->onFirstPage())
        <li>
            <span class="flex items-center justify-center px-4 h-8 text-gray-400 bg-white border border-gray-300 rounded-s-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600">
                <svg class="w-3.5 h-3.5 me-1 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Sebelumnya
            </span>
        </li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
               class="flex items-center justify-center px-4 h-8 text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-3.5 h-3.5 me-1 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Sebelumnya
            </a>
        </li>
        @endif

        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
               class="flex items-center justify-center px-4 h-8 text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                Seterusnya
                <svg class="w-3.5 h-3.5 ms-1 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </li>
        @else
        <li>
            <span class="flex items-center justify-center px-4 h-8 text-gray-400 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600">
                Seterusnya
                <svg class="w-3.5 h-3.5 ms-1 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </li>
        @endif

    </ul>
</nav>
@endif
