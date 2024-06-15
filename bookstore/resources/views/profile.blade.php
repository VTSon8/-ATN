@extends('layouts.app')

@section('content')

<div class="layout-info-account">
    <div class="title-infor-account text-center">
        <h1>Tài khoản của bạn </h1>
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
                                <li class="current"><a href="{{route('profile')}}">Lịch sử đơn hàng</a></li>
{{--                                <li><a href="/account/addresses">Danh sách địa chỉ</a></li>--}}
                                <li class="last"><a href="{{route('logout')}}">Đăng xuất</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-9">
                <div class="row">
                    <div class="col-12" id="customer_sidebar">
                        <p class="title-detail">Thông tin tài khoản</p>
                        @auth
                        <h2 class="name_account">Tên tài khoản: {{auth()->user()->name}}</h2>
                        <p class="email ">Địa chỉ email: {{auth()->user()->email}}</p>
                        <div class="address ">
                            <p></p>
                            <p></p>
                            <p>Địa chỉ: {{auth()->user()->address ?? 'Việt Nam'}}</p>
                            <p></p>
                            @endauth
{{--                            <a id="view_address" href="/account/addresses">Xem địa chỉ</a>--}}

                        </div>
                    </div>
                    <div class="col-12 customer-table-wrap" id="customer_orders">
                        <div class="customer_order customer-table-bg">
                            <p>Bạn chưa đặt mua sản phẩm.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
