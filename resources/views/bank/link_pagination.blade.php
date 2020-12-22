@if ($paginator->hasPages())

<style>
    .pagination {
        display: -ms-flexbox;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: .25rem
    }

    .page-link {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6
    }

    .page-link:hover {
        z-index: 2;
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6
    }

    .page-link:focus {
        z-index: 3;
        outline: 0;
        box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25)
    }

    .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: .25rem;
        border-bottom-left-radius: .25rem
    }

    .page-item:last-child .page-link {
        border-top-right-radius: .25rem;
        border-bottom-right-radius: .25rem
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6
    }

    .pagination-lg .page-link {
        padding: .75rem 1.5rem;
        font-size: 1.25rem;
        line-height: 1.5
    }

    .pagination-lg .page-item:first-child .page-link {
        border-top-left-radius: .3rem;
        border-bottom-left-radius: .3rem
    }

    .pagination-lg .page-item:last-child .page-link {
        border-top-right-radius: .3rem;
        border-bottom-right-radius: .3rem
    }

    .pagination-sm .page-link {
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5
    }

    .pagination-sm .page-item:first-child .page-link {
        border-top-left-radius: .2rem;
        border-bottom-left-radius: .2rem
    }

    .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: .25rem;
        border-bottom-left-radius: .25rem
    }

    .page-item:last-child .page-link {
        border-top-right-radius: .25rem;
        border-bottom-right-radius: .25rem
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6
    }

    .pagination-lg .page-link {
        padding: .75rem 1.5rem;
        font-size: 1.25rem;
        line-height: 1.5
    }

    .pagination-lg .page-item:first-child .page-link {
        border-top-left-radius: .3rem;
        border-bottom-left-radius: .3rem
    }

    .pagination-lg .page-item:last-child .page-link {
        border-top-right-radius: .3rem;
        border-bottom-right-radius: .3rem
    }

    .pagination-sm .page-link {
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5
    }

    .pagination-sm .page-item:first-child .page-link {
        border-top-left-radius: .2rem;
        border-bottom-left-radius: .2rem
    }

    .pagination-sm .page-item:last-child .page-link {
        border-top-right-radius: .2rem;
        border-bottom-right-radius: .2rem
    }

    .page-link {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6
    }

    .page-link:hover {
        z-index: 2;
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6
    }

    .page-link:focus {
        z-index: 3;
        outline: 0;
        box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25)
    }

    .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: .25rem;
        border-bottom-left-radius: .25rem
    }

    .page-item:last-child .page-link {
        border-top-right-radius: .25rem;
        border-bottom-right-radius: .25rem
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6
    }

    .pagination-lg .page-link {
        padding: .75rem 1.5rem;
        font-size: 1.25rem;
        line-height: 1.5
    }

    .pagination-lg .page-item:first-child .page-link {
        border-top-left-radius: .3rem;
        border-bottom-left-radius: .3rem
    }

    .pagination-lg .page-item:last-child .page-link {
        border-top-right-radius: .3rem;
        border-bottom-right-radius: .3rem
    }

    .pagination-sm .page-link {
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5
    }

    .pagination-sm .page-item:first-child .page-link {
        border-top-left-radius: .2rem;
        border-bottom-left-radius: .2rem
    }

    .pagination-sm .page-item:last-child .page-link {
        border-top-right-radius: .2rem;
        border-bottom-right-radius: .2rem
    }
</style>

<ul class="pagination" role="navigation">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
        <span class="page-link" aria-hidden="true">
            <span class="d-none d-md-block">&lsaquo;</span>
            <span class="d-block d-md-none">@lang('pagination.previous')</span>
        </span>
    </li>
    @else
    <li class="page-item">
        <button type="button" class="page-link" wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')">
            <span class="d-none d-md-block">&lsaquo;</span>
            <span class="d-block d-md-none">@lang('pagination.previous')</span>
        </button>
    </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <li class="page-item disabled d-none d-md-block" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="page-item active d-none d-md-block" aria-current="page"><span class="page-link">{{ $page }}</span></li>
    @else
    <li class="page-item d-none d-md-block"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <li class="page-item">
        <button type="button" class="page-link" wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')">
            <span class="d-block d-md-none">@lang('pagination.next')</span>
            <span class="d-none d-md-block">&rsaquo;</span>
        </button>
    </li>
    @else
    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
        <span class="page-link" aria-hidden="true">
            <span class="d-block d-md-none">@lang('pagination.next')</span>
            <span class="d-none d-md-block">&rsaquo;</span>
        </span>
    </li>
    @endif
</ul>
@endif