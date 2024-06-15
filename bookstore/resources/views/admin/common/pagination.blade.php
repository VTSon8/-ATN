@php
    $listUrl = $paginator->getUrlRange(1,$paginator->lastPage());
    $fisrtNumber = 1;
    $endNumber = $fisrtNumber - 1;
    $range = 4;
    $dot = $range + 1;
     // dd($paginator)
@endphp

@if($paginator->lastPage() !== 1)
    <ul class="pagination" style="margin: 0 !important;">
        <li class="hidden-xs">
            <a href="{{ $paginator->url(1) }}">
                Trang đầu
            </a>
        </li>
        <li>
            @if (!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}">
                    Trước
                </a>
            @endif
        </li>
        @foreach($listUrl as $keyUrl => $valUrl)
            @if($keyUrl <= $fisrtNumber || ($keyUrl >= $paginator->currentPage() - $range && $keyUrl <= $paginator->currentPage() + $range) || $keyUrl >= $paginator->lastPage() - $endNumber)
                @if($keyUrl == $paginator->currentPage())
                    <li class="active">
                        <a class="page" href="javascript:void(0)">{{ $keyUrl }}</a>
                    </li>
                @else
                    <li class="">
                        <a class="page" href="{{ $paginator->url($keyUrl) }}">{{ $keyUrl }}</a>
                    </li>
                @endif
            @elseif($keyUrl == $paginator->currentPage() - $dot || $keyUrl == $paginator->currentPage() + $dot)
                <span class="extend">...</span>
            @endif
        @endforeach

        <li>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">
                    Sau
                </a>
            @endif
        </li>
        <li class="hidden-xs">
            <a href="{{ $paginator->url($paginator->lastPage()) }}">
                Trang cuối
            </a>
        </li>
    </ul>
@endif
