@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-12 col-lg-9">
                <div class="layout-account">
                    <div class="row">
                        <div class="col-12 wrapbox-content-account ">
                            <h1 class="account-title text-center">Đăng ký</h1>
                            <div class="userbox">
                                <form accept-charset='UTF-8' action='{{route('register')}}' id='create_customer' method='POST'>
                                    @csrf
                                    <div id="form-last_name" class="clearfix large_form">
                                        <label for="name" class="label icon-field"><i
                                                class="icon-login icon-user "></i></label>
                                        <input required type="text" value="{{old('name')}}" name="name" placeholder="Tên đăng nhập"
                                               id="name" class="text" size="30"/>
                                        @error('name')
                                        <p style="color: red">
                                            {{$message}}
                                        </p>
                                        @enderror
                                    </div>
                                    <div id="form-email" class="clearfix large_form">
                                        <label for="email" class="label icon-field"><i
                                                class="icon-login icon-envelope "></i></label>
                                        <input required type="email" value="{{old('email')}}" placeholder="Email" name="email"
                                               id="email" class="text" size="30"/>
                                        @error('email')
                                        <p style="color: red">
                                            {{$message}}
                                        </p>
                                        @enderror
                                    </div>
                                    <div id="form-password" class="clearfix large_form large_form-mr10">
                                        <label for="password" class="label icon-field"><i
                                                class="icon-login icon-shield "></i></label>
                                        <input required type="password" value="{{old('password')}}" placeholder="Mật khẩu"
                                               name="password" id="password" class="password text" size="30"/>
                                        @error('password')
                                        <p style="color: red">
                                            {{$message}}
                                        </p>
                                        @enderror
                                    </div>
                                    <div id="form-password" class="clearfix large_form large_form-mr10">
                                        <label for="password" class="label icon-field"><i
                                                class="icon-login icon-shield "></i></label>
                                        <input required type="password" value="" placeholder="Nhập lại mật khẩu"
                                               name="password_confirmation" id="password_confirmation" class="password text" size="30"/>
                                        @error('password_confirmation')
                                        <p style="color: red">
                                            {{$message}}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="clearfix action_account_custommer">
                                        <div class="action_bottom button dark">
                                            <input class="btn btn-primary" type="submit" value="Đăng ký"/>
                                        </div>
                                    </div>
                                    <div class="clearfix req_pass">
                                        <a class="come-back" href="{{ route('home') }}"><i
                                                class="fa fa-long-arrow-left"></i> Quay lại trang chủ</a>
                                    </div>
                                </form>
                            </div>
                            <div class="wrapp-social">
                                <span class="orr">Hoặc đăng nhập với</span>
                                <div class="d-f-social">
                                    <button id="btn-google-login">Đăng nhập Google</button>
                                    <button id="btn-facebook-login">Đăng nhập Facebook</button>
                                </div>
                            </div>
                        </div><!-- #register -->
                        <!-- #customer-register -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
@endsection
