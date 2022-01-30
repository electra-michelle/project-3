@if ($paginator->hasPages())
    <div class="pager text-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="next-btn"> <i class="flaticon-left-arrow"></i></a>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                       <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="prev-btn"> <i class="flaticon-next"></i></a>
        @endif

    </div>
@endif
