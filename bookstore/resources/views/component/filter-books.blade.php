<div class="sidebar-block block_content">
    <!-- ./filter brand -->
    <div class="group-filter" aria-expanded="false">
        <div class="layered_subtitle dropdown-filter"><span>Nhà Cung Cấp</span><span
                class="icon-control"><i class="fal fa-angle-up"></i></span></div>
        <div class="layered-content bl-filter filter-supplier">
            <ul class="check-box-list">
                @foreach($suppliers as $supplier)
                    <li>
                        <input type="checkbox" id="data-brand-p1" value="{{$supplier->id}}"
                               name="supplier-filter"
                               data-supplier="{{$supplier->id}}"/>
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
                           data-type="0"/>
                    <label for="data-type-p1">Bìa mềm</label>
                    <br>
                    <input type="checkbox" id="data-type-p1" value="1" name="type-filter"
                           data-type="1"/>
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
                    <input type="checkbox" id="p1" name="cc" data-price='{"field": "selling_price", "operator": "<=", "value": 500000}'/>
                    <label for="p1"><span>Dưới</span> 500,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p2" name="cc"
                           data-price='{"field": "selling_price", "operator": ">", "value": 500000, "second_value": 1000000}'/>
                    <label for="p2">500,000₫ - 1,000,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p3" name="cc"
                          data-price='{"field": "selling_price", "operator": ">", "value": 1000000, "second_value": 1500000}'/>
                    <label for="p3">1,000,000₫ - 1,500,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p4" name="cc"
                           data-price='{"field": "selling_price", "operator": ">", "value": 2000000, "second_value": 5000000}'/>
                    <label for="p4">2,000,000₫ - 5,000,000₫</label>
                </li>
                <li>
                    <input type="checkbox" id="p5" name="cc" data-price='{"field": "selling_price", "operator": ">", "value": 500000}'/>
                    <label for="p5"><span>Trên</span> 5,000,000₫</label>
                </li>
            </ul>
        </div>
    </div>

    <!-- ./filter size -->

    <div class="group-filter" aria-expanded="false">
        <div class="layered_subtitle dropdown-filter"><span>Tác giả</span><span
                class="icon-control"><i class="fal fa-angle-up"></i></span></div>
        <div class="layered-content filter-size filter-author">
            <ul class="check-box-list clearfix">
                @foreach($authors as $author)
                    <li>
                        <input type="checkbox" id="data-size-p1" value="{{$author}}" name="author-filter"
                               data-author="{{$author}}"/>
                        <label for="data-size-p1">{{$author}}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('js')
    <script>
        function toQueryString(obj) {
            return Object.keys(obj).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(obj[key])}`).join('&');
        }

        const VND = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        });

        jQuery(document).ready(function () {
            var slug =  {!! json_encode($slug ?? '') !!};

            jQuery('#sortControl').change(function () {
                Stringfilter();
            })

            jQuery('.check-box-list li > input').click(function () {
                $('.custom-loader').show();
                jQuery(this).parent().toggleClass('active');
                if ($(window).width() < 992) {
                    if ($('.overlay-filter').hasClass('active')) {
                        $('.overlay-filter').removeClass('active');
                        $('.wrap-filter').removeClass('active');
                    }
                }
                Stringfilter();
            })
            str = "";
            var Stringfilter = function () {
                var q = [], price = [], supplier = [], type = [], author = [], option = $('#sortControl').val(), total_page = 0, cur_page = 1;
                jQuery('.filter-price ul.check-box-list li.active').each(function () {
                    price.push(JSON.stringify(jQuery(this).find('input').data('price')));
                })

                jQuery('.filter-supplier ul.check-box-list li.active').each(function () {
                    supplier.push(jQuery(this).find('input').data('supplier'));
                })

                jQuery('.filter-type ul.check-box-list li.active').each(function () {
                    type.push(jQuery(this).find('input').data('type'));
                })

                jQuery('.filter-author ul.check-box-list li.active').each(function () {
                    author.push(jQuery(this).find('input').data('author'));
                })

                q = {'slug': slug, 'supplier': supplier, 'price': price, 'type': type, 'author': author, 'option': option};
                let str_url = toQueryString(q);
                console.log(str_url);

                jQuery.ajax({
                    url: `/filter?${str_url}&view=page`,
                    async: false,
                    success: function (data) {
                        console.log(data)
                        sortByData(data.items.books)
                        $('#pagination').html(data.items.pagination);
                    }
                })

        //         if (cur_page <= total_page) {
        //             jQuery('.pagi').show();
        //             jQuery.ajax({
        //                 url: `/filter?${str_url}&view=page`,
        //                 success: function (data) {
        //                     jQuery(".product-list.filter").html(data);
        //                     /*
        //             // fix lazyload
        //                 jQuery('.content-product-list img').imagesLoaded( function() {
        //                     jQuery(window).resize();
        //                 });
        // */
        //                     jQuery(".product-list.filter").removeClass('border');
        //                     jQuery(".alert-no-filter").hide();
        //                 }
        //             })
        //             jQuery.ajax({
        //                 url: `/filter?${str_url}&view=paginate`,
        //                 async: false,
        //                 success: function (data) {
        //                     //jQuery(".pagi-filter").html(data); // in phân trang
        //                     jQuery(".pagi").html(data); // in phân trang
        //                 }
        //             })
        //         } else {
        //             if (jQuery('.alert-no').length > 0) {
        //                 jQuery(".alert-no").html("<p>Không tìm thấy sản phẩm nào phù hợp!</p>");
        //             } else {
        //                 jQuery(".alert-no-filter").show().html("<p>Không tìm thấy sản phẩm nào phù hợp!</p>");
        //             }
        //             //jQuery(".product-list.filter").html("<div class='col-sm-12 col-xs-12 text-center no-product'><p>Không tìm thấy sản phẩm nào phù hợp!</p></div>");
        //             jQuery(".product-list.filter").html('');
        //             jQuery(".product-list.filter").addClass('border');
        //             jQuery('.pagi').hide();
        //         }
        //         jQuery('.pagi').on("click", "a", function () { // bắt sự kiện click các nút phân trang
        //             var link = jQuery(this).attr("data-link");
        //             if (link == 'm') {
        //                 link = cur_page - 1;
        //             }
        //             if (link == 'p') {
        //                 link = cur_page + 1;
        //             }
        //             link = parseInt(link);
        //             jQuery.ajax({
        //                 url: `/filter?${str_url}&view=filter&page=` + link,
        //                 success: function (data) {
        //                     jQuery(".product-list.filter").html(data);
        //                     cur_page = link;
        //                 }
        //             })
        //             //console.log("/search?q="+str+"&view=paginate&page="+link);
        //             jQuery.ajax({
        //                 url: `/filter?${str_url}&view=filter&page=` + link,
        //                 success: function (data) {
        //                     //jQuery(".pagi-filter").html(data); // in phân trang
        //                     jQuery(".pagi").html(data); // in phân trang
        //                 }
        //             })
        //         });

                var x = $('#collection-body').offset().top;
                smoothScroll(x - 10, 500);
            }
        })

        function sortByData(data) {
            let content = '';
            let books = data;
            if(books.total !== 0) {
                $.each(data.data, function (key, item) {
                    content +=
                        `<div class="col-md-4 col-6">
                        <div class="product-item">
                            <div class="product-img " style="border: none;">
                                <div class="product-sale" style="background: #f03737;"><span>-${item.sale}%</span>
                                </div>
                                <a href="/products/${item.slug}">
                                    <img
                                        src="/assets/upload/${item.thumb}"
                                        alt="${item.name}"/>
                                </a>
                                <div class="button-add d-none d-md-flex">
                                    <button title="Thêm vào giỏ" class="action "
                                            onclick="add_to_cart('${item.id}');"
                                            data-tooltip="Thêm vào giỏ"><i class="fal fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-detail">
                                <h3 class="pro-name"><a
                                        href="/products/${item.slug}"
                                        title="${item.name}">${item.name}</a></h3>
                                <p class="pro-price highlight">
                                    <span class="current-price">${VND.format(item.selling_price)}</span>
                                    <del class="compare-price">${VND.format(item.original_price)}</del>
                                </p>
                            </div>
                        </div>
                    </div>`;
                });
                $('#cate-books').html(content);
            }else {
                $('#cate-books').html("<p>Không tìm thấy sản phẩm nào phù hợp!</p>");
            }
        }
    </script>
@endpush


