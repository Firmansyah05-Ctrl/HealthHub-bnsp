@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col items-center space-y-4">
        <!-- Mobile Pagination -->
        <div class="flex justify-between w-full sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-6 py-3 text-sm font-semibold text-gray-400 bg-gray-50 border-2 border-gray-200 cursor-default rounded-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 border-2 border-transparent rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-4 focus:ring-teal-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 border-2 border-transparent rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-4 focus:ring-teal-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                    Selanjutnya
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="relative inline-flex items-center px-6 py-3 text-sm font-semibold text-gray-400 bg-gray-50 border-2 border-gray-200 cursor-default rounded-xl">
                    Selanjutnya
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </div>

        <!-- Desktop Pagination -->
        <div class="hidden sm:flex sm:flex-col sm:items-center sm:space-y-4">
            <!-- Info Text -->
            <div class="flex items-center bg-gradient-to-r from-teal-50 to-cyan-50 px-6 py-3 rounded-2xl border border-teal-100">
                <svg class="w-5 h-5 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-teal-700 font-medium">
                    Showing
                    @if ($paginator->firstItem())
                        <span class="font-bold text-teal-800">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-bold text-teal-800">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-bold text-teal-800">{{ $paginator->count() }}</span>
                    @endif
                    of
                    <span class="font-bold text-teal-800">{{ $paginator->total() }}</span>
                    products
                </p>
            </div>

            <!-- Page Navigation -->
            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Halaman Sebelumnya">
                        <span class="relative inline-flex items-center px-4 py-3 text-sm font-semibold text-gray-400 bg-gray-50 border-2 border-gray-200 cursor-default rounded-xl" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 border-2 border-transparent rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-4 focus:ring-teal-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5" aria-label="Halaman Sebelumnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-4 py-3 text-sm font-semibold text-gray-500 bg-white border-2 border-gray-200 cursor-default rounded-xl shadow-sm">
                                {{ $element }}
                            </span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center px-5 py-3 text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-cyan-600 border-2 border-transparent cursor-default rounded-xl shadow-lg ring-4 ring-teal-300 ring-opacity-50 transform scale-110">
                                        {{ $page }}
                                    </span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-5 py-3 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:text-teal-600 hover:bg-teal-50 hover:border-teal-300 focus:outline-none focus:ring-4 focus:ring-teal-300 active:bg-teal-100 active:text-teal-700 transition-all duration-300 shadow-sm hover:shadow-lg transform hover:-translate-y-0.5" aria-label="Ke halaman {{ $page }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 border-2 border-transparent rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-4 focus:ring-teal-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5" aria-label="Halaman Selanjutnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Halaman Selanjutnya">
                        <span class="relative inline-flex items-center px-4 py-3 text-sm font-semibold text-gray-400 bg-gray-50 border-2 border-gray-200 cursor-default rounded-xl" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif