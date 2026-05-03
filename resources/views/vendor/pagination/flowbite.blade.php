@if ($paginator->hasPages())
<nav aria-label="Pagination" class="flex items-center justify-between mt-4 flex-wrap gap-3">

    {{-- Info kiraan --}}
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Papar <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $paginator->firstItem() }}</span>
        –
        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $paginator->lastItem() }}</span>
        daripada
        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $paginator->total() }}</span>
        rekod
    </p>

    {{-- Butang halaman --}}
    <ul class="inline-flex -space-x-px text-sm">

        {{-- « Sebelumnya --}}
        @if ($paginator->onFirstPage())
        <li>
            <span class="flex items-center justify-center px-3 h-8 ms-0 text-gray-400 bg-white border border-gray-300 rounded-s-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600">
                <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </span>
        </li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
               class="flex items-center justify-center px-3 h-8 ms-0 text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </li>
        @endif

        {{-- Nombor halaman --}}
        @foreach ($elements as $element)

            {{-- "..." separator --}}
            @if (is_string($element))
            <li>
                <span class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                    {{ $element }}
                </span>
            </li>
            @endif

            {{-- Array of page links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li>
                        <span aria-current="page"
                              class="flex items-center justify-center px-3 h-8 text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 dark:border-gray-700 dark:bg-blue-900/40 dark:text-blue-400 font-semibold">
                            {{ $page }}
                        </span>
                    </li>
                    @else
                    <li>
                        <a href="{{ $url }}"
                           class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $page }}
                        </a>
                    </li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Seterusnya » --}}
        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
               class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </li>
        @else
        <li>
            <span class="flex items-center justify-center px-3 h-8 text-gray-400 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600">
                <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </li>
        @endif

    </ul>
</nav>
@endif
