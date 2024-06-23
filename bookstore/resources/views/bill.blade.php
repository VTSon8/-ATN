@extends('layouts.app')

@section('content')
    <div class="layout-info-account">
        <div class="title-infor-account text-center">
            <h1>Đơn hàng </h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3 sidebar-account">
                    <div class="AccountSidebar">
                        <h3 class="AccountTitle titleSidebar">Tài khoản</h3>
                        <div class="AccountContent">
                            <div class="AccountList">
                                <ul class="list-unstyled">
                                    <li class="current"><a href="{{route('profile')}}">Thông tin tài khoản</a></li>
                                    <li class="current"><a href="{{route('bill')}}">Lịch sử đơn hàng</a></li>
                                    {{--                                <li><a href="/account/addresses">Danh sách địa chỉ</a></li>--}}
                                    <li class="last"><a href="{{route('logout')}}">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-9">
                    <div class="row">
                        <div class="card">
                            <h2 class="card-header">Lịch sử đơn hàng</h2>
                            <div class="card-body">
                                <div class="my-account">
                                    <div class="general__title">
                                        <h2><span>Danh sách đơn hàng chưa duyệt</span></h2>
                                    </div>
                                    <table style="padding-right: 10px; width: 100%;">
                                        <thead style="border: 1px solid silver;">
                                        <tr>
                                            <th class="text-left" style="width: 15%; padding:5px 10px">Đơn hàng</th>
                                            <th style="width: 15%; padding:5px 10px">Ngày</th>
                                            <th style="width: 20%;text-align: center; padding:5px 10px">
                                                Giá trị đơn hàng
                                            </th>
                                            <th style="width: 20%; text-align: center;">Trạng thái đơn hàng</th>
                                            <th style="text-align: center;" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody style="border: 1px solid silver;">
                                        @foreach($orderPending as $order)
                                            <tr style="border-bottom: 1px solid silver;">
                                                <td style="padding:5px 10px;">#{{ data_get($order, 'code') }}</td>
                                                <td style="padding:5px 10px;">{{ data_get($order, 'created_at') }}</td>
                                                <td style="text-align: center; padding:5px 10px;">
                                                    <span class="price-2">{{ number_format(data_get($order, 'amount')) }} VNĐ</span>
                                                </td>
                                                <td style="padding:5px 10px; text-align: center;">
                                                    {{ data_get($order, 'order_status') }}
                                                </td>
{{--                                                <td>--}}
{{--                                                    <span> <a style="color: #0f9ed8;"--}}
{{--                                                              href="{{ route('order.detail', ['id' => data_get($order, 'id')]) }}">Xem chi tiết</a></span>--}}
{{--                                                </td>--}}
                                                <td style="text-align: center">
                                                    <form action="{{ route('order.cancel', data_get($order, 'id')) }}"
                                                          method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button
                                                            style="border: none;outline: none;background-color: #fff;color: red;"
                                                            onclick="return confirm('Xác nhận hủy đơn hàng này ?')">Hủy
                                                            đơn
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <div class="general__title">
                                        <h2><span>Danh sách đơn hàng</span></h2>
                                    </div>
                                    <div class="table-order">
                                        <table style="padding-right: 10px; width: 100%;">
                                            <thead style="border: 1px solid silver;">
                                            <tr>
                                                <th class="text-left" style="width: 15%; padding:5px 10px">Đơn hàng
                                                </th>
                                                <th style="width: 15%; padding:5px 10px">Ngày</th>
                                                <th style="width: 20%;text-align: center; padding:5px 10px">
                                                    Giá trị đơn hàng
                                                </th>
                                                <th style="width: 20%; text-align: center;">Trạng thái đơn hàng</th>
                                                <th style="text-align: center;" colspan="2">Thao tác</th>
                                            </tr>
                                            </thead>
                                            <tbody style="border: 1px solid silver;">
                                            @foreach($orderProcess as $order)
                                                <tr style="border-bottom: 1px solid silver;">
                                                    <td style="padding:5px 10px;">#{{ data_get($order, 'code') }}</td>
                                                    <td style="padding:5px 10px;">{{ data_get($order, 'created_at') }}</td>
                                                    <td style="text-align: center; padding:5px 10px;">
                                            <span
                                                class="price-2">{{ number_format(data_get($order, 'amount')) }} VNĐ</span>
                                                    </td>
                                                    <td style="padding:5px 10px; text-align: center;">
                                                        {{ data_get($order, 'order_status') }}
                                                    </td>
                                                    {{--                                        <td>--}}
                                                    {{--                                                            <span> <a style="color: #0f9ed8;"--}}
                                                    {{--                                                                      href="{{ route('order.detail', ['id' => data_get($order, 'id')]) }}">Xem chi tiết</a></span>--}}
                                                    {{--                                        </td>--}}
                                                    {{--                                        @if(data_get($order, 'status') == 3)--}}
                                                    {{--                                            <td>--}}
                                                    {{--                                                            <span> <a style="color: #0f9ed8;"--}}
                                                    {{--                                                                      href="{{ route('profile.reviews', ['id' => data_get($order, 'id')]) }}">Đánh giá</a></span>--}}
                                                    {{--                                            </td>--}}
                                                    {{--                                        @endif--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


