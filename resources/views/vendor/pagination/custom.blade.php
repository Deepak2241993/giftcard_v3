@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            {{-- <li class="disabled"><i class="fa-regular fa-angle-left"></i></li> --}}
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-regular fa-angle-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="current">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}"><span>{{ $page }}</span></a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" rel="prev"><i class="fa-regular fa-angle-right"></i></a></li>
       
        @else
       {{-- <i class="disabled fa-regular fa-angle-right"></i> --}}
        @endif
    </ul>
@endif
