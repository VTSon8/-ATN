    <div class="sidebar-block sidebar-product mb-4">
        <div class="sidebar-title">
            <h3>Sản phẩm nổi bật</h3>
        </div>
        <div class="sidebar-content">
            @foreach($promotionalProducts as $book)
                <div class="product-item-mini">
                    <div class="product-img" style="border: none;">
                        <div class="product-sale" style="background: #f03737;"><span>-{{ data_get($book, 'sale', '') }}%</span></div>
                        <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}">
                            <img src="{{ url('assets/upload/' . data_get($book, 'thumb')) }}" alt="đá"/>
                        </a>
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">
                            <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                               title="Bản Đồ Thế Giới Cà Phê - Từ Hạt Đến Pha Chế - Khám Phá , Giải Thích Và Thưởng Thức Cà Phê">
                                {{ data_get($book, 'name') }}
                            </a>
                        </h3>
                        <div class="box-pro-prices">
                            <p class="pro-price highlight">
                                <span class="current-price">{{ number_format(data_get($book, 'selling_price')) }}₫</span>
                                <span class="pro-price-del">
					<del class="compare-price">
						{{ number_format(data_get($book, 'original_price')) }}₫
					</del>
				</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
