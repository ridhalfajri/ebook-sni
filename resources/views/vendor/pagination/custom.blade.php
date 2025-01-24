@if ($paginator->hasPages())
    <div class="pagination__wrapper">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li><span class="prev" title="previous page">&#10094;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" class="prev" title="previous page">&#10094;</a></li>
            @endif
            
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
            @endforeach

                {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" class="next" title="next page">&#10095;</a></li>

            @else
                <li><span class="next" title="next page">&#10095;</span></li>
            @endif
        </ul>
    </div>
@endif
