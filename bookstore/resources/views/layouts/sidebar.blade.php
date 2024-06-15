<div class="sidebar">
    <div class="widget widget_menu d-none d-md-block">
        <h3 class="sidebar-title">Danh mục</h3>
        <div class="sidebar-menu">
            <ul>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <li class="has-child dropdown">
                            <a href="{{ route('product_of_list',data_get($category, 'slug')) }}" style="color: #000">
                                {{data_get($category, 'name')}}
                                @if(!empty(data_get($category, 'children')))
                                        <?php $sub_category = data_get($category, 'parent'); ?>
                                    @if(data_get($category, 'children')->isNotEmpty())
                                        <i class="fal fa-angle-right"></i>
                                    @endif
                                @endif
                            </a>
                            @if(data_get($category, 'children')->isNotEmpty()))
                                <ul>
                                    @foreach(data_get($category, 'children') as $sub)
                                        <li class="">
                                            <a href="{{ route('product_of_list',data_get($sub, 'slug')) }}"
                                               style="color: #000">{{data_get($sub, 'name')}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

    </div>
    <div class="widget widget_collection d-none d-md-block">
        <div class="widget-title">
            Sách Bán Chạy
        </div>
        <div class="widget_collection_list">
            @foreach($sellingBooks as $book)
            <div class="product-item-mini">
                <div class="product-img" style="border: none;">
                    @if(!empty(data_get($book, 'sale', 0)))
                    <div class="product-sale" style="background: #f03737;"><span>-{{ data_get($book, 'sale', 0) }}%</span></div>
                    @endif
                    <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}">
                        <img class="lazy"
                             src="{{ url('assets/upload/' . data_get($book, 'thumb')) }}"
                             data-srcset="{{ url('assets/upload/' . data_get($book, 'thumb')) }}"
                             alt=" {{ data_get($book, 'name') }} "/>
                    </a>
                </div>
                <div class="product-content">
                    <h3 class="product-title">
                        <a href="{{ route('product.details', ['slug' => data_get($book, 'slug')]) }}"
                           title="{{ data_get($book, 'name') }}">
                            {{ data_get($book, 'name') }}
                        </a>
                    </h3>
                    <div class="box-pro-prices">
                        <p class="pro-price highlight">
                            <span class="current-price">{{ number_format(data_get($book, 'selling_price')) }}₫</span>
                            <span class="pro-price-del">
                            <del class="compare-price">{{ number_format(data_get($book, 'original_price')) }}₫</del>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
