@php
    $listUrl = $paginator->getUrlRange(1, $paginator->lastPage());
    $firstNumber = 1;
    $endNumber = $firstNumber - 1;
    $range = 4;
    $dot = $range + 1;
@endphp

@if($paginator->lastPage() !== 1)
    <div class="row pagination-theme clearfix text-center">
        <div id="pagination" class="clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{-- Trang đầu và Trước --}}
                @if (!$paginator->onFirstPage())
                    <a class="page-node" href="{{ $paginator->previousPageUrl() }}">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31 10" style="enable-background:new 0 0 31 10; width: 31px; height: 10px;" xml:space="preserve">
                            <polygon points="0,5 6,0 6,4 31,4 31,6 6,6 6,10 "></polygon>
                        </svg>
                    </a>
                @endif

                {{-- Các trang --}}
                @foreach($listUrl as $keyUrl => $valUrl)
                    @if($keyUrl <= $firstNumber || ($keyUrl >= $paginator->currentPage() - $range && $keyUrl <= $paginator->currentPage() + $range) || $keyUrl >= $paginator->lastPage() - $endNumber)
                        @if($keyUrl == $paginator->currentPage())
                            <span class="page-node current">{{ $keyUrl }}</span>
                        @else
                            <a class="page-node" href="{{ $paginator->url($keyUrl) }}">{{ $keyUrl }}</a>
                        @endif
                    @elseif($keyUrl == $paginator->currentPage() - $dot || $keyUrl == $paginator->currentPage() + $dot)
                        <span class="page-node">...</span>
                    @endif
                @endforeach

                {{-- Sau và Trang cuối --}}
                @if ($paginator->hasMorePages())
                    <a class="page-node" href="{{ $paginator->nextPageUrl() }}">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31 10" style="enable-background:new 0 0 31 10; width: 31px; height: 10px;" xml:space="preserve">
                            <polygon points="31,5 25,0 25,4 0,4 0,6 25,6 25,10 "></polygon>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
