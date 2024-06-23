@extends('layouts.app')

@section('content')
<div class="layoutPage-cart" id="layout-cart">
    <div class="breadcrumb-shop">
        <div class="container">
            <div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5  ">
                    <ol class="breadcrumb breadcrumb-arrows" itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a href="/" target="_self" itemprop="item"><span itemprop="name">Trang chủ</span></a>
                            <meta itemprop="position" content="1" />
                        </li>

                        <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" >
                            <span itemprop="item" content="https://www.book.com/cart"><span itemprop="name">Giỏ hàng ({{$totalPrice ?? 0}})</span></span>
                            <meta itemprop="position" content="2" />
                        </li>

                    </ol>
                </div>	</div>
        </div>
    </div>
    @php
        $count = isset($carts) ? $carts->count() : 0;
    @endphp
    <div class="wrapper-cart-detail">
        <div class="container">
            <div class="heading-page">
                <div class="header-page">
                    <h1>Giỏ hàng của bạn</h1>
                    <p class="count-cart">Có <span>{{$count}} sản phẩm</span> trong giỏ hàng</p>
                </div>
            </div>
            <div class="row wrapbox-content-cart" >
                <div class="col-12 contentCart-detail">

                    <div class="cart-container">
                        <div class="cart-col-left">
                            <div class="main-content-cart">
                                <form action="/cart" method="post" id="cartformpage">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table-cart">
                                                <thead>
                                                <tr>
                                                    <th class="image">&nbsp;</th>
                                                    <th class="item">Tên sản phẩm</th>
                                                    <th class="item">Giá</th>
                                                    <th class="item">Số lượng</th>
                                                    <th class="item">Thành tiền</th>
                                                    <th class="remove">&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($count != 0)
                                                @foreach($carts as $index => $book)
                                                <tr class="line-item-container" data-variant-id="{{$index}}">
                                                    <td class="image">
                                                        <div class="product_image">
                                                            <a href="#">
                                                                <img src="{{ url('assets/upload/' . data_get($book, 'options.image')) }}" alt="{{ data_get($book, 'name') }}" />
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="item" width="420px">
                                                        <h3><a href="{{ route('product.details', ['slug' => data_get($book, 'options.slug')]) }}">{{ data_get($book, 'name') }}</a></h3>
                                                        <p class="variant"></p><p></p>
                                                    </td>
                                                    <td class="item">
                                                        @if(data_get($book, 'price') > 0)
                                                            <p><span class="price">{{ number_format(data_get($book, 'price')) }}₫</span>
                                                        @endif
                                                    </td>
                                                    <td class="qty">
                                                        <div class="qty quantity-partent qty-click clearfix">
                                                            <button type="button" class="qtyminus qty-btn">-</button>
                                                            <input type="text" size="4" name="items[{{$index}}]" min="1" id="updates_{{ $index }}" data-price="{{ data_get($book, 'price') }}" value="{{ data_get($book, 'qty') }}"  class="tc line-item-qty item-quantity bg-white" onchange="return onChangeSL('{{ $index }}')" />
                                                            <button type="button" class="qtyplus qty-btn">+</button>
                                                        </div>
                                                    </td>
                                                    <td class="item">
                                                        <p class="">
                                                            @if(data_get($book, 'price') > 0)
                                                                <span class="line-item-total price"><span class="d-md-none">Thành tiền: </span>{{ number_format(data_get($book, 'price') * data_get($book, 'qty')) }}₫</span>
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="remove">
                                                        <a href="{{route('remove_product_t', $index)}}" class="cart">
                                                            <img src="//theme.hstatic.net/200000845405/1001223012/14/ic_close.png?v=17"/></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-lg-7">
                                            <div class="sidebox-group">
                                                <h3>Ghi chú đơn hàng</h3>
                                                <div class="checkout-note clearfix">
                                                    <textarea id="note" name="note" rows="4"  placeholder="Ghi chú"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-5">
                                            <div class="sidebox-order">
                                                <div class="sidebox-order-inner">
                                                    <div class="sidebox-order_title">
                                                        <h3>Thông tin đơn hàng</h3>
                                                    </div>
                                                    <div class="sidebox-order_total">
                                                        <p>Tổng tiền:
                                                            <span class="total-price">{{ number_format($totalPrice) }}₫</span>
                                                        </p>
                                                    </div>
                                                    <div class="sidebox-order_text">
                                                        <p>Phí vận chuyển sẽ được tính ở trang thanh toán.<br>
                                                            Bạn cũng có thể nhập mã giảm giá ở trang thanh toán.</p>
                                                    </div>
                                                    <div class="sidebox-order_action">
                                                        <a class="btn btn-dark" href="{{route('checkout.index')}}">THANH TOÁN</a>
                                                        <p class="link-continue">
                                                            <a  href="/collections/all">
                                                                <i class="fa fa-reply"></i> Tiếp tục mua hàng
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End cart -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>

        function setDataCart(response) {
            let content = '';
            if (response.code === 200) {
                console.log('vao d');
                let totalAmount = 0;
                $.each(response.items, function (key, item) {
                    let totalPrice = parseInt(item.price) * parseInt(item.qty);
                    totalAmount += totalPrice;
                    $('.quantity-'+key).text(parseInt(item.qty)+'x');
                    console.log('.quantity-'+key);
                    content += `<tr class="item-${item.id}">
                                    <td class="img-product-cart">
                                        <a href="">
                                            <img
                                                src="{{url('assets/upload/')}}/${item.options.image}"
                                                alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="" class="pull-left">${item.name}</a>
                                    </td>
                                    <td>
                                        <span class="amount">
                                        ${formatCurrency(item.price)}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="quantity clearfix">
                                            <input name="quantity" id="${key}" class="form-control"
                                                   type="number" value="${item.qty}" min="1"
                                                   max="1000" onchange="onChangeSL('${key}')">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="amount">
                                            ${formatCurrency(totalPrice)}
                                        </span>
                                    </td>
                                    <td>
                                        <a class="remove" title="Xóa" onclick="onRemoveProduct('${key}')">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                            </tr>`;
                });

                $('tbody#fav-table').html(content);
                $('#total-amount').text(formatCurrency(totalAmount));
                $('.cart_header .cart_price p').text(formatCurrency(totalAmount));
                $('.cart-summary h5').text(formatCurrency(totalAmount));
            }
        }

        function onChangeSL(id) {
            console.log('onchan')
            // var sl = $('input[name="quantity"]').val();
            var sl = $('#'+id).val();
            var strurl = "{{ route('change_quantity') }}";
            $.ajax({
                url: strurl,
                type: 'POST',
                dataType: 'json',
                data: {id: id, qty: sl},
                // success: function (data) {
                //     document.location.reload(true);
                // }
            }).always(function (response) {
                if (response.code === 200) {
                    setDataCart(response);
                }
            });
        }
    </script>

    <script>
        $(document).on('change, keyup', '.qty-click input', function(e) {
            Update_price_change();
            if ($(this).val() == 0) {
                $(this).closest('.line-item-container').remove();
                location.reload();
            }
        });
        $(document).on('click', '.qty-click .qtyplus', function(e){
            e.preventDefault();
            var input = $(this).parent('.quantity-partent').find('input');
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                input.val(currentVal + 1);
            } else {
                input.val(1);
            }
            Update_price_change();
        });
        $(document).on('click', ".qty-click .qtyminus", function(e) {
            e.preventDefault();
            var input = $(this).parent('.quantity-partent').find('input');
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal) && currentVal > 1) {
                input.val(currentVal - 1);
            } else {
                input.val(1);
            }
            Update_price_change();
        });

        function Update_price_change(){
            var params = {
                type: 'POST',
                url: '/change-quantity',
                data: $('#cartformpage').serialize(),
                async: false,
                dataType: 'json',
                success: function(data) {
                    $.each(data.items,function(i,v){
                        $('.table-cart tbody tr[data-variant-id="'+v?.cart_sku+'"] .line-item-total').html('<span class="d-md-none">Thành tiền: </span>' + v?.into_money + 'đ');
                    });
                    $('.sidebox-order_total .total-price').html(data.total_money + 'đ');
                    $('.count-cart').html('Có ' + '<span>' + data.number + ' sản phẩm </span>' + 'trong giỏ hàng');
                    $('.icon-cart .count').html(data.item_count);

                },
                error: function(XMLHttpRequest, textStatus) {
                    Haravan.onError(XMLHttpRequest, textStatus);
                }
            };
            jQuery.ajax(params);
        }
    </script>
@endpush
