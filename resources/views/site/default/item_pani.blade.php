{{--cấu trúc phân trang--}}
@if ($page_link->hasPages())
    <ul class="pagination pagination">
        {{-- Previous Page Link --}}
        @if ($page_link->onFirstPage())
            <li class="disabled"><span>«</span></li>
        @else
            <li><a href="{{ $page_link->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        @if($page_link->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $page_link->url(1) }}">1</a></li>
        @endif
        @if($page_link->currentPage() > 4)
            <li><span class="ques">...</span></li>
        @endif
        @foreach(range(1, $page_link->lastPage()) as $i)
            @if($i >= $page_link->currentPage() - 1 && $i <= $page_link->currentPage() + 1)
                @if ($i == $page_link->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $page_link->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($page_link->currentPage() < $page_link->lastPage() - 1)
            <li><span class="ques">...</span></li>
        @endif
        @if($page_link->currentPage() < $page_link->lastPage() - 1)
            <li class="hidden-xs"><a href="{{ $page_link->url($page_link->lastPage()) }}">{{ $page_link->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($page_link->hasMorePages())
            <li><a href="{{ $page_link->nextPageUrl() }}" rel="next">»</a></li>
        @else
            <li class="disabled"><span>»</span></li>
        @endif
    </ul>
@endif