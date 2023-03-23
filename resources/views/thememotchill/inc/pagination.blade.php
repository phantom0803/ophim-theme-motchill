@if ($paginator->hasPages())
    <ul>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        @else
            <li><a class="navigation prev" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                aria-label="@lang('pagination.previous')">« Trước</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span class="">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a href="javascript:void(0)" class="current">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="navigation next" href="{{ $paginator->nextPageUrl() }}" rel="next"
                aria-label="@lang('pagination.next')">Sau »</a></li>
        @else
        @endif
    </ul>
@endif
