@if ($paginator->hasPages())
<nav role="navigation" aria-label="分页导航">
    <ul class="pagination-list">
        {{-- 上一页 --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
        @endif

        {{-- 页码 --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 下一页 --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
            </li>
        @endif
    </ul>
</nav>

<style>
    .pagination-list {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-card);
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .page-item .page-link:hover {
        background: var(--blue-50);
        border-color: var(--blue-400);
        color: var(--blue-600);
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
        border-color: var(--blue-500);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }
    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: var(--bg-card);
        color: var(--text-muted);
    }
</style>
@endif
