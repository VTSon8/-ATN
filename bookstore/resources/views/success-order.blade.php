@extends('layouts.index')

@section('content')
    <section id="checkout-cart">
        <div class="container">
            <div class="col-md-12">
                <div class="wrapper overflow-hidden">
                    <div class="checkout-content">
                        <div class="tks-header">
                            <h3 class="fa fa-check-circle" style="font-size: 30px;font-weight: 700;"> Thông tin đơn hàng
                                đã được gửi đến
                                {{ data_get($orderNew, 'name') }} . Qúy khách hãy đăng nhập gmail để kiểm tra thông tin
                                đơn
                                hàng.
                            </h3>
                        </div>
                        <div class="tks-content" style="min-height: 1px;
                    overflow: hidden;">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-login-checkout" style="margin-bottom: 20px">
                                <table class="table tks-tabele-info-cus">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Thông tin thanh toán nhận hàng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Khách hàng :</td>
                                        <td>{{ data_get($orderNew, 'name') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại :</td>
                                        <td>{{ data_get($orderNew, 'phone') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ thanh toán :</td>
                                        <td> {{ data_get($orderNew, 'address') . ', ' . data_get($orderNew, 'ward.prefix', '') . ' ' . data_get($orderNew, 'ward.name') . ', ' . data_get($orderNew, 'district.prefix', '') . ' ' . data_get($orderNew, 'district.name') . ', ' . data_get($orderNew, 'province.name') }}</p></td>
                                    </tr>
                                    <tr>
                                        <td>Hình thức thành toán :</td>
                                        <td>{{ data_get($orderNew, 'payment_type') == 1 ? 'Thanh toán trực tuyến' : 'Thanh toán khi nhận hàng' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 products-detail">
                                <div class="no-margin-table" style="width: 95%; float: right;">
                                    <table class="table" style="color: #333;">
                                        <thead>
                                        <tr>
                                            <th colspan="3" style="font-weight: 600;">Thông tin đơn hàng</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr style="background: #fafafa; color: #333;"
                                            class="text-transform font-weight-600">
                                            <td>Sản phẩm</td>
                                            <td class="text-center">Số lượng</td>
                                            <td class="text-center">Giá</td>
                                            <td class="text-center">Tổng</td>
                                        </tr>
                                        @php
                                            $total_price = 0;
                                        @endphp
                                        @foreach($orderProductNew as $product)
                                            <tr>
                                                <td>{{ data_get($product, 'product.name') }}</td>
                                                <td class="text-center">{{ data_get($product, 'quantity') }}</td>
                                                <td class="text-center">
                                                    {{ number_format(data_get($product, 'product.selling_price')) }}
                                                </td>
                                                @php
                                                    $total_price += data_get($product, 'price');
                                                @endphp
                                                <td>{{ number_format(data_get($product, 'price')) }}
                                                    VNĐ
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="background: #fafafa">
                                            <td colspan="3">Tổng cộng :</td>
                                            <td class="text-center">
                                                {{ number_format($total_price) }} VNĐ
                                            </td>
                                        </tr>
                                        <tr style="background: #fafafa">
                                            <td colspan="3">Phí vẫn chuyển</td>
                                            <td class="text-center">{{ number_format(data_get($orderNew, 'price_ship')) }}
                                                VND
                                            </td>
                                        </tr>
                                        @if(data_get($orderNew, 'discount'))
                                            <td colspan="3">Voucher:</td>
                                            <td class="text-center">
                                                -{{ number_format(data_get($orderNew, 'discount')) }} VNĐ
                                            </td>
                                        @endif
                                        <tr style="background: #fafafa">
                                            <td colspan="3" class="font-weight-600">Thành tiền<br/><span
                                                    style="font-style: italic;">(Tổng số tiền thanh toán)</span></td>
                                            <td class="text-center"
                                                style="font-weight: 600; font-size: 17px;color: red;">{{ number_format(data_get($orderNew, 'price')) }}
                                                VND
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="btn-tks clearfix">
                            <button type="button" onclick="window.location.href='{{ route('home') }}'"
                                    class="btn-next-checkout pull-left">Tiếp tục mua hàng
                            </button>
                            <button type="button" onclick="window.print()" class="btn-update-order pull-left">In
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




