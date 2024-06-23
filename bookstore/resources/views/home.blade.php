@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-12 col-lg-9">
                @include('layouts.slider', ['banners' => $banners])
                <section class="home-tab-product mb-30">
                    <div class="inner">
                        <div class="htp-tabs-wrapper">
                            <div class="htp-tablinks">
                                <button class="htp-tablink active" data-id="htp-tab-1">Sách Mới Nổi Bật</button>
                            </div>
                            <div class="htp-tabcontents section-box-bg">
                                <div class="htp-tabcontent active" data-id="htp-tab-1">
                                    <div class="row">
                                        @if(!empty($featuredBooks))
                                            @foreach($featuredBooks as $book)
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <div class="product-item">
                                                        <div class="product-img " style="border: none;">
                                                            <div class="product-sale" style="background: #f03737;">
                                                                <span>-{{ data_get($book, 'sale', '') }}%</span></div>
                                                            <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}">
                                                                <img
                                                                    {{--                                                            class="lazy"--}}
                                                                    src="{{ url('assets/upload/' . data_get($book, 'thumb')) }}"
                                                                    alt=" Trống Đồng "/>
                                                            </a>
                                                            <div class="button-add d-none d-md-flex justify-center">
                                                                <button title="Thêm vào giỏ" class="action "
                                                                        onclick="add_to_cart('{{$book->id}}');"
                                                                        data-tooltip="Thêm vào giỏ"><i
                                                                        class="fal fa-cart-plus"></i></button>
{{--                                                                <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"--}}
{{--                                                                   data-tooltip="Chi tiết"><i--}}
{{--                                                                        class="fal fa-eye"></i></a>--}}
                                                            </div>
                                                        </div>
                                                        <div class="product-detail">
                                                            <h3 class="pro-name"><a
                                                                    href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                                                                    title="Trống Đồng">{{ data_get($book, 'name') }}</a>
                                                            </h3>
                                                            <p class="pro-price highlight">
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
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <section class="home-two-banner home-section-mg">
                    <div class="row">
                        <div class="col-12 col-md-3 ">
                            <div class="item banner-effect">
                                <a href="{{route('home')}}">
                                    <picture>
                                        <source media="(min-width: 768px)"
                                                srcset="//theme.hstatic.net/200000845405/1001223012/14/col2_htb_img_1.jpg?v=17">
                                        <source media="(max-width: 767px)"
                                                srcset="//theme.hstatic.net/200000845405/1001223012/14/col2_htb_img_1_large.jpg?v=17">
                                        <img loading="lazy"
                                             src="//theme.hstatic.net/200000845405/1001223012/14/col2_htb_img_1_small.jpg?v=17"
                                             alt=""/>
                                    </picture>
                                    <span class="hover hover1"></span>
                                    <span class="hover hover2"></span>
                                    <span class="hover hover3"></span>
                                    <span class="hover hover4"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 ">
                            <div class="item banner-effect">
                                <a href="{{route('home')}}">
                                    <picture>
                                        <source media="(min-width: 768px)"
                                                srcset="//theme.hstatic.net/200000845405/1001223012/14/col2_htb_img_2.jpg?v=17">
                                        <source media="(max-width: 767px)"
                                                srcset="//theme.hstatic.net/200000845405/1001223012/14/col2_htb_img_2_large.jpg?v=17">
                                        <img loading="lazy"
                                             src="//theme.hstatic.net/200000845405/1001223012/14/col2_htb_img_2_small.jpg?v=17"
                                             alt=""/>
                                    </picture>
                                    <span class="hover hover1"></span>
                                    <span class="hover hover2"></span>
                                    <span class="hover hover3"></span>
                                    <span class="hover hover4"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                @if(!empty($booksByCategory))
                    @foreach($booksByCategory as $category)
                        @if(!$category->products->isEmpty())
                        <section class="home-featured-product mb-30">
                            <div class="section-heading">
                                <h2 class="section-title">
                                    <span>{{ $category->name }}</span>
                                </h2>
                            </div>
                            <div class="section-box-bg">
                                <div class="owl-carousel owl-theme owl-nav-style-1 " data-auto-play="false" data-lg-items="4"
                                     data-md-items="4" data-sm-items="3" data-xs-items="2" data-dot="false" data-nav="true">
                                    @foreach($category->products as $book)
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-img " style="border: none;">
                                                <div class="product-sale" style="background: #f03737;"><span>-{{ data_get($book, 'sale', '') }}%</span></div>
                                                <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}">
                                                    <img
                                                        src="{{ url('assets/upload/' . data_get($book, 'thumb')) }}"
                                                        alt=" Ông Trăm Tuổi Trèo Qua Cửa Số Và Biến Mất (Tái Bản 2023) "/>
                                                </a>
                                                <div class="button-add d-none d-md-flex">
{{--                                                    <button type="button" class="btnQuickView quick-view"--}}
{{--                                                            data-handle="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"--}}
{{--                                                            data-tooltip="Xem nhanh"><i class="fal fa-search-plus"--}}
{{--                                                                                        aria-hidden="true"></i></button>--}}
                                                    <button title="Thêm vào giỏ" class="action "
                                                            onclick="add_to_cart('{{$book->id}}');" data-tooltip="Thêm vào giỏ"><i
                                                            class="fal fa-cart-plus"></i></button>
{{--                                                    <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"--}}
{{--                                                       data-tooltip="Chi tiết"><i class="fal fa-eye"></i></a>--}}
                                                </div>
                                            </div>
                                            <div class="product-detail">
                                                <h3 class="pro-name"><a
                                                        href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                                                        title="Ông Trăm Tuổi Trèo Qua Cửa Số Và Biến Mất (Tái Bản 2023)">
                                                        {{ data_get($book, 'name') }}</a></h3>
                                                <p class="pro-price highlight">
                                                    <span class="current-price">{{ number_format(data_get($book, 'selling_price')) }}₫</span>
                                                    <del
                                                        class="compare-price">{{ number_format(data_get($book, 'original_price')) }}₫
                                                    </del>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        @endif
                    @endforeach
                @endif
                <section class="home-brands mb-30">
                    <div class="section-heading">
                        <h2 class="section-title">
                            <span>NXB Trẻ</span>
                        </h2>
                    </div>
                    <div class="section-box-bg">
                        <div class="owl-brands-slider owl-carousel owl-theme owl-nav-style-1" data-lg-items="5"
                             data-md-items="4" data-sm-items="4" data-xs-items="2" data-dot="false" data-nav="true">
                            <div class="item grid__item">
                                <a href="/" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img1.png?v=17"
                                        alt="Logo hãng 1"/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="/" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img2.png?v=17"
                                        alt="Logo hãng 2"/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="/" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img3.png?v=17"
                                        alt="Logo hãng 3"/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="/" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img4.png?v=17"
                                        alt="Logo hãng 4"/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="/" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img5.png?v=17"
                                        alt="Logo hãng 5"/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="/" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img6.png?v=17"
                                        alt="Logo hãng 6"/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img7.png?v=17"
                                        alt=""/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img8.png?v=17"
                                        alt=""/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img9.png?v=17"
                                        alt=""/></a>
                            </div>
                            <div class="item grid__item">
                                <a href="" class="text-center"><img
                                        src="//theme.hstatic.net/200000845405/1001223012/14/brand_img10.png?v=17"
                                        alt=""/></a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-12 col-lg-3">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
@endsection
