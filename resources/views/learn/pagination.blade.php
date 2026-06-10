@if ($paginator->hasPages())
<nav>
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span disabled aria-disabled="true">
            <i class="fa-solid fa-chevron-left"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span disabled aria-disabled="true">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    @else
        <span disabled aria-disabled="true">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
    @endif
</nav>
@endif
