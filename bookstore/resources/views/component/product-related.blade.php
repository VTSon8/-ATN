<div class="col-12">
    <div class="list-productRelated clearfix">
        <div class="section-heading text-center">
            <h2 class="section-title">
                <span>Sản phẩm liên quan</span>
            </h2>
            <div class="line">
                <div class="circle">
                    <span class="line-left line-shape bg-primary"></span>
                    <span class="line-right line-shape bg-primary"></span>
                </div>
            </div>
        </div>

        <div class="content-product-list row">
            @foreach($similarProducts as $book)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-item">
                        <div class="product-img " style="border: none;">
                            <div class="product-sale" style="background: #f03737;"><span>-{{ data_get($book, 'sale', '') }}%</span>
                            </div>
                            <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}">
                                <img
                                    src="{{ url('assets/upload/' . data_get($book, 'thumb')) }}"
                                    alt=" 1000 Mindmap English words - 1000 từ vựng tiếng Anh bằng sơ đồ tư duy "/>
                            </a>
                            <div class="button-add d-none d-md-flex">
{{--                                <button type="button" class="btnQuickView quick-view"--}}
{{--                                        data-handle="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"--}}
{{--                                        data-tooltip="Xem nhanh"><i class="fal fa-search-plus"--}}
{{--                                                                    aria-hidden="true"></i></button>--}}
                                <button title="Thêm vào giỏ" class="action "
                                        onclick="add_to_cart('1120809907');"
                                        data-tooltip="Thêm vào giỏ"><i class="fal fa-cart-plus"></i>
                                </button>
{{--                                <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"--}}
{{--                                   data-tooltip="Chi tiết"><i class="fal fa-eye"></i></a>--}}
                            </div>
                        </div>
                        <div class="product-detail">
                            <h3 class="pro-name"><a
                                    href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                                    title="1000 Mindmap English words - 1000 từ vựng tiếng Anh bằng sơ đồ tư duy">{{ data_get($book, 'name') }}</a>
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
        </div>
    </div>
</div>
