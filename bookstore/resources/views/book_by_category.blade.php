@extends('layouts.app')

@section('content')

    <div class="main-content ">
        <div class="container">
            <div id="collection-body" class="py-5">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <div class="wrap-filter">
                            <div class="box_sidebar">
                                <div class="block left-module">
                                    <div class=" filter_xs">
                                        <div class="layered">
                                            @include('component.filter-books')
                                            @include('component.sidebar', ['promotionalProducts' => $promotionalProducts])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-12">
                        <div class=" banner-collection-header mb-30">
                            @php $image_url = '//theme.hstatic.net/200000845405/1001223012/14/collection_banner.jpg?v=17' @endphp
                            <img class="w-100" src="{{data_get($category, 'image_url', $image_url)}}"
                                 alt="{{data_get($category, 'name')}}"/>
                        </div>
                        <div class="wrap-collection-title">
                            <div class="heading-collection">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <h1 class="title">
                                            @if(empty($category))
                                                Tất cả sản phẩm
                                            @else
                                                {{$category->name}}
                                            @endif
                                        </h1>

                                        @if($books->isEmpty())
                                            <div class="alert-no-filter" style=""><p>Không tìm thấy sản phẩm nào phù hợp!</p></div>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-4 mb-sort">
                                        <div class="filter-mb">
                                            <button class="filter-mb-btn btn borderFilterMobile">
                                                <span>Bộ lọc</span>
                                                <span class="filter-icon">
													<i class="fa fa-filter"></i>
												</span>
                                            </button>
                                        </div>

{{--                                        <div id="sort-by" class="hidden-xs">--}}
{{--                                            <label class="left hidden-xs" for="sort-select">Sắp xếp theo: </label>--}}
{{--                                            <form class="form-inline form-viewpro">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <select id="sortControl" class="form-control input-sm"--}}
{{--                                                            onchange="sortby()"--}}
{{--                                                            data-search="{{ isset($key_word) ? $key_word : '' }}">--}}
{{--                                                        <option value="number_buy-desc" selected>Bán chạy nhất</option>--}}
{{--                                                        <option value="name-asc">A → Z</option>--}}
{{--                                                        <option value="name-desc">Z → A</option>--}}
{{--                                                        <option value="selling_price-asc">Giá tăng dần</option>--}}
{{--                                                        <option value="selling_price-desc">Giá giảm dần</option>--}}
{{--                                                        <option value="created_at-desc">Hàng mới nhất</option>--}}
{{--                                                        <option value="created_at-asc">Hàng cũ nhất</option>--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}

                                        <div class="option browse-tags">
                                            <label class="lb-filter hide" for="sort-by">Sắp xếp theo:</label>
                                            <span class="custom-dropdown custom-dropdown--grey borderFilterMobile">
                                                <select id="sortControl" class="sort-by custom-dropdown__select form-control input-sm"
                                                        onchange="sortby()"
                                                        data-search="{{ isset($key_word) ? $key_word : '' }}">
                                                        <option value="number_buy-desc" selected>Bán chạy nhất</option>
                                                        <option value="name-asc">A → Z</option>
                                                        <option value="name-desc">Z → A</option>
                                                        <option value="selling_price-asc">Giá tăng dần</option>
                                                        <option value="selling_price-desc">Giá giảm dần</option>
                                                        <option value="created_at-desc">Hàng mới nhất</option>
                                                        <option value="created_at-asc">Hàng cũ nhất</option>
                                                    </select>
{{--												<select class="sort-by custom-dropdown__select">--}}
{{--													<option value="manual">Sản phẩm nổi bật</option>--}}
{{--													<option value="price-ascending"--}}
{{--                                                            data-filter="&sortby=(price:product=asc)">Giá: Tăng dần</option>--}}
{{--													<option value="price-descending"--}}
{{--                                                            data-filter="&sortby=(price:product=desc)">Giá: Giảm dần</option>--}}
{{--													<option value="title-ascending"--}}
{{--                                                            data-filter="&sortby=(title:product=asc)">Tên: A-Z</option>--}}
{{--													<option value="title-descending"--}}
{{--                                                            data-filter="&sortby=(price:product=desc)">Tên: Z-A</option>--}}
{{--													<option value="created-ascending"--}}
{{--                                                            data-filter="&sortby=(updated_at:product=desc)">Cũ nhất</option>--}}
{{--													<option value="created-descending"--}}
{{--                                                            data-filter="&sortby=(updated_at:product=asc)">Mới nhất</option>--}}
{{--													<option value="best-selling"--}}
{{--                                                            data-filter="&sortby=(sold_quantity:product=desc)">Bán chạy nhất</option>--}}
{{--													<option value="quantity-descending">Tồn kho: Giảm dần</option>--}}
{{--												</select>--}}
											</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" filter-here section-box-bg">
                            <div class="row content-product-list product-list filter clearfix">
                                @foreach($books as $book)
                                <div class="col-md-4 col-6">
                                    <div class="product-item">
                                        <div class="product-img " style="border: none;">
                                            <div class="product-sale" style="background: #f03737;"><span>-{{ data_get($book, 'sale', '') }}%</span>
                                            </div>
                                            <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}">
                                                <img
                                                    src="{{ url('assets/upload/' . data_get($book, 'thumb')) }}"
                                                    alt="S&#225;ch Đa Tương T&#225;c - Cơ Thể Của Ch&#250;ng Ta"/>
                                            </a>
                                            <div class="button-add d-none d-md-flex">
                                                <button type="button" class="btnQuickView quick-view"
                                                        data-handle="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                                                        data-tooltip="Xem nhanh">
                                                    <i class="fal fa-search-plus" aria-hidden="true"></i>
                                                </button>
                                                <button title="Thêm vào giỏ" class="action "
                                                        onclick="add_to_cart('{{$book->id}}');"
                                                        data-tooltip="Thêm vào giỏ"><i class="fal fa-cart-plus"></i>
                                                </button>
                                                <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                                                   data-tooltip="Chi tiết"><i class="fal fa-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <h3 class="pro-name"><a
                                                    href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                                                    title="{{ data_get($book, 'name') }}">{{ data_get($book, 'name') }}</a></h3>
                                            <p class="pro-price highlight">
                                                <span class="current-price">{{ number_format(data_get($book, 'selling_price')) }}₫</span>
                                                <del class="compare-price">{{ number_format(data_get($book, 'original_price')) }}₫</del>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if($books->isEmpty())
                                <div class=" filter-here section-box-bg">
                                    <div class="row content-product-list product-list filter clearfix border"></div>
                                    <div class="sortpagibar pagi clearfix text-center" style="display: none;">
                                        <div id="pagination" class="row">
                                        </div>
                                    </div>
                                </div>

                            @else
                                {{ $books->appends($_GET)->onEachSide(5)->links('common.pagination') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function sortByData(data) {
            console.log(data);
            let content = '';
            $.each(data, function (key, item) {
                let discount = '';
                if (item.sale) {
                    discount = `<div class="giam-percent">
                                    <span class="text-giam-percent">Giảm ${item.sale + '%' ?? ''}</span>
                                </div>`;
                }
                content +=
                    `<div class="col-md-3 col-lg-3 col-xs-6 col-6">
                    <div class="product-lt">
                        <div class="lt-product-group-image">
                            <a href="{{ url('/') }}/${item.slug}">
                                <img class="img-p"
                                     src="{{ url('assets/upload/') }}/${item.thumb}"
                                     alt="">
                            </a>
                        ${discount}
                        </div>
                        <div class="lt-product-group-info">
                            <a href="{{ url('/') }}/${item.slug}">
                                <h3>${item.name}</h3>
                            </a>
                            <div class="price-box">
                                <p class="old-price">
                                    <span
                                        class="price ${item.sale ?? 'not-sale'}">${VND.format(item.original_price)}</span>
                                </p>
                                <p class="special-price">
                                    <span class="price">${VND.format(item.selling_price)}</span>
                                </p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>`;
            });

            $('#show-product').html(content);
        }

        function sortby(page = null) {
            let option = $('#sortControl').val();
            let slug = $('#show-product').data('slug');
            let key_word = $('#sortControl').data('search');
            var strurl = `{{ route('show') }}`;
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                dataType: 'json',
                data: {slug: slug, sort: option, key_word: key_word, page: page},
                success: function (data) {
                }
            }).always(function (response) {
                if (response.code == 200) {
                    sortByData(response.items.product.data);
                    $('#pagination-container').html(response.items.pagination);
                }
            });
        }

        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            sortby(page);
        });
    </script>
@endpush
