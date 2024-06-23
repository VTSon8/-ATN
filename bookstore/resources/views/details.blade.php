@extends('layouts.app')

@section('content')
    <div id="product" class="productDetail-page">
        <div class="breadcrumb-shop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5  ">
                        <ol class="breadcrumb breadcrumb-arrows" itemscope itemtype="http://schema.org/BreadcrumbList">
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a href="/" target="_self" itemprop="item"><span itemprop="name">Trang chủ</span></a>
                                <meta itemprop="position" content="1"/>
                            </li>
                            <li class="active" itemprop="itemListElement" itemscope
                                itemtype="http://schema.org/ListItem">
                                <span itemprop="item"
                                      content="{{ route('product_of_list') . '/' . $product->category->slug }}">
                                    <span itemprop="name">{{ data_get($product, 'name', '') }}</span>
                                </span>
                                <meta itemprop="position" content="3"/>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-detail-wrapper py-5 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row product-detail-main mb-5">
                            <div class="col-12 col-lg-9">
                                <div class="row">
                                    <div class="col-12 col-lg-6 product-content-img">
                                        <div class="product-gallery">
                                            <div class="product-image-detail box__product-gallery scroll">
                                                <ul id="sliderproduct"
                                                    class="site-box-content slide_product clearfix hidden-lg hidden-md d-none">
                                                    <li class="product-gallery-item gallery-item">
                                                        <img class="product-image-feature"
                                                             src="{{ url('assets/upload/' . data_get($product, 'thumb')) }}"
                                                             alt=" Ngôn Ngữ Của Chúa ">
                                                    </li>
                                                </ul>
                                                <div class="text-center">
                                                    <img class="product-image-feature"
                                                         src="{{ url('assets/upload/' . data_get($product, 'thumb')) }}"
                                                         alt=" Ngôn Ngữ Của Chúa ">
                                                </div>
                                            </div>
                                            <div class="product-gallery__thumbs-container d-none">
                                                <div class="product-gallery__thumbs owl-carousel" data-nav="true"
                                                     data-loop="true" data-margin="15" data-sm-items="4"
                                                     data-xs-items="4" data-md-items="4" data-lg-items="5">

                                                    <div class="product-gallery__thumb active">
                                                        <a class="product-gallery__thumb-placeholder" href="javascript:"
                                                           data-image="{{ url('assets/upload/' . data_get($product, 'thumb')) }}"
                                                           data-zoom-image="{{ url('assets/upload/' . data_get($product, 'thumb')) }}">
                                                            <img alt=" Ngôn Ngữ Của Chúa "
                                                                 data-image="{{ url('assets/upload/' . data_get($product, 'thumb')) }}"
                                                                 src="//product.hstatic.net/200000845405/product/ngon_ngu_cua_chua_tai_ban_2018_1_2018_10_29_15_40_52_9e13e2a805e94166ae5c7e4a922439a6_compact.jpg">
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 product-content-desc" id="detail-product">
                                        <div class="product-title">
                                            <h1>{{ $product->name }}</h1>
                                            <span id="pro_sku"><strong>ISBN:</strong>{{ $product->sku }}</span>
                                        </div>
                                        <p class="product-type">
                                            {{ $product->category->name }}
                                        </p>
                                        <div class="product-price" id="price-preview">
                                            <span class="pro-price">{{ number_format($product->selling_price) }}₫</span>
                                            <del>{{ number_format($product->original_price) }}₫</del>
                                            <span class="pro-sale hide">-{{ $product->sale }}% </span>
                                        </div>
                                        <div class="selector-actions">
                                            <div class="quantity-area clearfix">
                                                <input type="button" value="-" onclick="minusQuantity()"
                                                       class="qty-btn">
                                                <input type="text" id="quantity" name="quantity" value="1" min="1"
                                                       class="quantity-selector">
                                                <input type="button" value="+" onclick="plusQuantity()"
                                                       class="qty-btn">
                                            </div>
                                            <div class="wrap-addcart">
                                                <button id="add-to-cart"
                                                        onclick="add_to_cart('{{$product->id}}');"
                                                        class="add-to-cartProduct btn btn-primary" style="width: 50%">
                                                    Thêm vào giỏ
                                                </button>
                                                <a id="buy-now" href="javascript:void(0)" onclick="buy_now('{{$product->id}}')"
                                                   class=" add-to-cartProduct btn btn-dark" style="width: 50%">
                                                    Mua ngay
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('component.breadcrumb-shop')
                        </div>
                    </div>
                    <div class="col-12 col-lg-9">
                        <div class="product-description">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                       href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">GIỚI
                                        THIỆU SÁCH</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                     aria-labelledby="nav-home-tab">
                                    <p><strong>{{ $product->name }}</strong></p>
                                    <p>{!! $product->detail !!}</p>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th>Mã hàng</th>
                                            <td>{{ $product->sku }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tên Nhà Cung Cấp</th>
                                            <td>
                                                <a href="{{ route('product_of_list') . '/' . $product->category->slug }}">{{ $product->category->name }}</a>
                                            </td>
                                        </tr>
                                        @if(data_get($product, 'author', ''))
                                            <tr>
                                                <th>Tác giả</th>
                                                <td>{{ data_get($product, 'author', '') }}</td>
                                            </tr>
                                        @endif
                                        @if(data_get($product, 'translator', ''))
                                            <tr>
                                                <th>Người Dịch</th>
                                                <td>{{ data_get($product, 'translator', '') }}</td>
                                            </tr>
                                        @endif
                                        @if(data_get($product, 'imprint', ''))
                                            <tr>
                                                <th>NXB</th>
                                                <td>{{ data_get($product, 'imprint', '') }}</td>
                                            </tr>
                                        @endif
                                        @if(data_get($product, 'publishing_year', ''))
                                            <tr>
                                                <th>Năm XB</th>
                                                <td>{{ data_get($product, 'publishing_year', '') }}</td>
                                            </tr>
                                        @endif
                                        @if(data_get($product, 'weight', ''))
                                            <tr>
                                                <th>Trọng lượng (gr)</th>
                                                <td>{{ data_get($product, 'weight', '') }}</td>
                                            </tr>
                                        @endif
                                        @if(data_get($product, 'size', ''))
                                            <tr>
                                                <th>Kích Thước Bao Bì</th>
                                                <td>{{ data_get($product, 'size', '') }}</td>
                                            </tr>
                                        @endif
                                        @if(data_get($product, 'number_of_pages', ''))
                                            <tr>
                                                <th>Số trang</th>
                                                <td>{{ data_get($product, 'number_of_pages', '') }}</td>
                                            </tr>
                                        @endif
                                        @if(data_get($product, 'form', ''))
                                            <tr>
                                                <th>Hình thức</th>
                                                <td>{{ data_get($product, 'form', '') }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><p>&nbsp;</p></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p>&nbsp;</p>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        @include('component.sidebar', ['promotionalProducts' => $promotionalProducts])
                    </div>
                    @include('component.product-related', ['similarProducts' => $similarProducts])
                </div>
            </div>
        </div>
    </div>
    <div id="divzoom">
        <div class="divzoom_main">
            <div class="product-thumb text-center">
                <img class="product-image-feature"
                     src="{{ url('assets/upload/' . data_get($product, 'thumb')) }}"
                     alt=" Ngôn Ngữ Của Chúa ">
            </div>
        </div>
        <div id="positionButtonDiv" class="hidden">
            <p>
			<span>
				<button type="button" class="buttonZoomIn"><i></i></button>
				<button type="button" class="buttonZoomOut"><i></i></button>
			</span>
            </p>
        </div>
        <button id="closedivZoom"><i></i></button>
    </div>
@endsection

@push('js')
    <script>
        var plusQuantity = function () {
            var self = $(this);
            if (jQuery('input[name="quantity"]').val() != undefined) {
                var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                if (!isNaN(currentVal)) {
                    jQuery('input[name="quantity"]').val(currentVal + 1);
                } else {
                    jQuery('input[name="quantity"]').val(1);
                }
            } else {
                console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
            }
        }
        var minusQuantity = function () {
            if (jQuery('input[name="quantity"]').val() != undefined) {
                var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                if (!isNaN(currentVal) && currentVal > 1) {
                    jQuery('input[name="quantity"]').val(currentVal - 1);
                }
            } else {
                console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
            }
        }

        var buy_now = function(id) {
            var params = {
                type: 'POST',
                url: `/add-to-cart/${id}`,
                data: 'quantity=' + 1 + '&id=' + id,
                dataType: 'json',
                success: function (line_item) {
                    updateCartModal();
                    window.location = '/checkout';
                },
                error: function (XMLHttpRequest, textStatus) {
                    Haravan.onError(XMLHttpRequest, textStatus);
                }
            }

            jQuery.ajax(params);
        }

    </script>
@endpush
