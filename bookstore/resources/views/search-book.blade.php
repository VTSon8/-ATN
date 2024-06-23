@extends('layouts.app')

@section('content')

    <div class="searchPage py-5" id="layout-search">
        <div class="container">
            <div class="row pd-page">
                <div class="col-12">
                    <div class="heading-page">
                        <h1>Tìm kiếm</h1>
                        <p class="subtxt">Có <span>{{$totalBooks ?? 0}} sản phẩm</span> cho tìm kiếm</p>
                    </div>
                    <div class="wrapbox-content-page">
                        <div class="content-page" id="search">
                            <p class="subtext-result"> Kết quả tìm kiếm cho <strong>{{request('q', '')}}</strong>. </p>
                            <div class="results content-product-list section-box-bg">
                                <div class=" search-list-results row">
                                    @foreach($books as $book)
                                        <div class="col-md-3 col-sm-6 col-xs-6 col-6">
                                            <div class="product-item">
                                                @if($book->number === 0)
                                                    <div class="sold-out"><span>Hết hàng</span></div>
                                                @endif
                                                <div class="product-img " style="border: none;">
                                                    <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}">
                                                        <img
                                                            src="{{ url('assets/upload/' . data_get($book, 'thumb')) }}"
                                                            alt="{{ data_get($book, 'name') }}"/>
                                                    </a>
                                                    <div class="button-add d-none d-md-flex">
{{--                                                        <button type="button" class="btnQuickView quick-view"--}}
{{--                                                                data-handle="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"--}}
{{--                                                                data-tooltip="Xem nhanh"><i class="fal fa-search-plus"--}}
{{--                                                                                            aria-hidden="true"></i>--}}
{{--                                                        </button>--}}
                                                        <button title="Thêm vào giỏ" class="action "
                                                                onclick="add_to_cart('{{$book->id}}');"
                                                                data-tooltip="Thêm vào giỏ"><i
                                                                class="fal fa-cart-plus"></i></button>
{{--                                                        <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"--}}
{{--                                                           data-tooltip="Chi tiết"><i class="fal fa-eye"></i></a>--}}
                                                    </div>

                                                </div>
                                                <div class="product-detail">
                                                    <h3 class="pro-name"><a
                                                            href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                                                            title="{{ data_get($book, 'name') }}">{{ data_get($book, 'name') }}</a>
                                                    </h3>
                                                    <p class="pro-price ">
                                                        <span class="current-price">{{ number_format(data_get($book, 'selling_price')) }}₫</span>
                                                        <del
                                                            class="compare-price">{{ number_format(data_get($book, 'original_price')) }}
                                                            ₫
                                                        </del>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>    <!-- End results -->
                            {{ $books->appends($_GET)->onEachSide(5)->links('common.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
