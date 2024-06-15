<div class="sidebar-block block_content">
    <!-- ./filter brand -->
    <div class="group-filter" aria-expanded="false">
        <div class="layered_subtitle dropdown-filter"><span>Nhà Cung Cấp</span><span
                class="icon-control"><i class="fal fa-angle-up"></i></span></div>
        <div class="layered-content bl-filter filter-brand">
            <ul class="check-box-list">
                @foreach($suppliers as $supplier)
                    <li>
                        <input type="checkbox" id="data-brand-p1" value="{{$supplier->id}}"
                               name="brand-filter"
                               data-vendor="(vendor:product contains {{$supplier->name}})"/>
                        <label for="data-brand-p1">{{$supplier->name}}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="group-filter" aria-expanded="false">
        <div class="layered_subtitle dropdown-filter"><span>Loại sách</span><span
                class="icon-control"><i class="fal fa-angle-up"></i></span></div>
        <div class="layered-content bl-filter filter-type">
            <ul class="check-box-list">
                <li>
                    <input type="checkbox" id="data-type-p1" value="0" name="type-filter"
                           data-type="(product_type:product contains Bìa mềm)"/>
                    <label for="data-type-p1">Bìa mềm</label>
                    <br>
                    <input type="checkbox" id="data-type-p1" value="1" name="type-filter"
                           data-type="(product_type:product contains Bìa cứng)"/>
                    <label for="data-type-p1">Bìa cứng</label>
                </li>
            </ul>
        </div>
    </div>
    <!-- ./filter price -->
    <div class="group-filter" aria-expanded="false">
        <div class="layered_subtitle dropdown-filter"><span>Giá sản phẩm</span><span
                class="icon-control"><i class="fal fa-angle-up"></i></span></div>
        <div class="layered-content bl-filter filter-price">
            <ul class="check-box-list">
                <li>
                    <input type="checkbox" id="p1" name="cc" data-price="(price:product<=500000)"/>
                    <label for="p1"><span>Dưới</span> 500,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p2" name="cc"
                           data-price="((price:product>500000)&amp;&amp;(price:product<=1000000))"/>
                    <label for="p2">500,000₫ - 1,000,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p3" name="cc"
                           data-price="((price:product>1000000)&amp;&amp;(price:product<=1500000))"/>
                    <label for="p3">1,000,000₫ - 1,500,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p4" name="cc"
                           data-price="((price:product>2000000)&amp;&amp;(price:product<=5000000))"/>
                    <label for="p4">2,000,000₫ - 5,000,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p5" name="cc" data-price="(price:product>=5000000)"/>
                    <label for="p5"><span>Trên</span> 5,000,000₫</label>
                </li>
            </ul>
        </div>
    </div>

    <!-- ./filter color -->

    <!-- ./filter size -->

    <div class="group-filter" aria-expanded="false">
        <div class="layered_subtitle dropdown-filter"><span>Tác giả</span><span
                class="icon-control"><i class="fal fa-angle-up"></i></span></div>
        <div class="layered-content filter-size s-filter">
            <ul class="check-box-list clearfix">
                @foreach($authors as $author)
                    <li>
                        <input type="checkbox" id="data-size-p1" value="{{$author}}" name="size-filter"
                               data-size="(tag:product contains {{$author}})"/>
                        <label for="data-size-p1">{{$author}}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>



