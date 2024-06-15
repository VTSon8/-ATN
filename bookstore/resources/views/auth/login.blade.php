@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-12 col-lg-9">
                <div class="layout-account">
                    <div class="row">
                        <div class="col-12 wrapbox-content-account">
                            <div id="customer-login">
                                <div id="login" class="userbox">
                                    <div class="accounttype">
                                        <h1 class="text-center account-title">Đăng nhập</h1>
                                    </div>
                                    <form accept-charset='UTF-8' action='{{ route('login') }}' id='customer_login'
                                          method='post'>
                                        @csrf
                                        <div class="clearfix large_form">
                                            <label for="customer_email" class="icon-field"><i
                                                    class="icon-login icon-envelope "></i></label>
                                            <input required type="email" value="" name="email"
                                                   id="customer_email" placeholder="Email" class="text"/>
                                        </div>
                                        <div class="clearfix large_form  large_form-mr10">
                                            <label for="customer_password" class="icon-field"><i
                                                    class="icon-login icon-shield"></i></label>
                                            <input required type="password" value="" name="password"
                                                   id="customer_password" placeholder="Mật khẩu" class="text"
                                                   size="16"/>
                                        </div>
                                        @if($errors->any())
                                            <p style="color: red">
                                                Tên đăng nhập hoặc mật khẩu không chính xác.
                                            </p>
                                        @endif
                                        <div class="clearfix action_account_custommer text-center">
                                            <div class="action_bottom button dark">
                                                <input class="btn btn-primary btn-signin" type="submit"
                                                       value="Đăng nhập"/>
                                            </div>
                                            <div class="req_pass">
                                                <a href="#" onclick="showRecoverPasswordForm();return false;">Quên mật
                                                    khẩu?</a><br>
                                                hoặc <a href="{{ route('register') }}" title="Đăng ký">Đăng ký</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="recover-password" style="display:none;" class="userbox">
                                    <div class="accounttype"><h2>Phục hồi mật khẩu</h2></div>
                                    <form accept-charset='UTF-8' action='/account/recover' method='post'>
                                        <input name='form_type' type='hidden' value='recover_customer_password'>
                                        <input name='utf8' type='hidden' value='✓'>


                                        <div class="clearfix large_form large_form-mr10">
                                            <label for="email" class="icon-field"><i
                                                    class="icon-login icon-envelope "></i></label>
                                            <input type="email" value="" size="30" name="email" placeholder="Email"
                                                   id="recover-email" class="text"/>
                                        </div>
                                        <div class="clearfix large_form sitebox-recaptcha">
                                            This site is protected by reCAPTCHA and the Google
                                            <a href="https://policies.google.com/privacy" target="_blank"
                                               rel="noreferrer">Privacy Policy</a>
                                            and <a href="https://policies.google.com/terms" target="_blank"
                                                   rel="noreferrer">Terms of Service</a> apply.
                                        </div>
                                        <div class="clearfix action_account_custommer">
                                            <div class="action_bottom button dark">
                                                <input class="btn btn-primary" type="submit" value="Gửi"/>
                                            </div>
                                            <div class="req_pass">
                                                <a href="#" onclick="hideRecoverPasswordForm();return false;">Hủy</a>
                                            </div>
                                        </div>

                                        <input id='75f71233e6124c308d6d64cc155ffb15' name='g-recaptcha-response'
                                               type='hidden'>
                                        <script
                                            src='https://www.google.com/recaptcha/api.js?render=6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-'></script>
                                        <script>grecaptcha.ready(function () {
                                                grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {action: 'submit'}).then(function (token) {
                                                    document.getElementById('75f71233e6124c308d6d64cc155ffb15').value = token;
                                                });
                                            });</script>
                                    </form>
                                </div>

                                <div class="wrapp-social">
                                    <span class="orr">Hoặc đăng nhập với</span>
                                    <div class="d-f-social">
                                        <button id="btn-google-login">Đăng nhập Google</button>
                                        <button id="btn-facebook-login">Đăng nhập Facebook</button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>


    {{--<div class="container">--}}
    {{--    <div class="row justify-content-center">--}}
    {{--        <div class="col-md-8">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-header">{{ __('Login') }}</div>--}}

    {{--                <div class="card-body">--}}
    {{--                    <form method="POST" action="{{ route('login') }}">--}}
    {{--                        @csrf--}}

    {{--                        <div class="row mb-3">--}}
    {{--                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}

    {{--                            <div class="col-md-6">--}}
    {{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

    {{--                                @error('email')--}}
    {{--                                    <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $message }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                @enderror--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                        <div class="row mb-3">--}}
    {{--                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

    {{--                            <div class="col-md-6">--}}
    {{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

    {{--                                @error('password')--}}
    {{--                                    <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $message }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                @enderror--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                        <div class="row mb-3">--}}
    {{--                            <div class="col-md-6 offset-md-4">--}}
    {{--                                <div class="form-check">--}}
    {{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

    {{--                                    <label class="form-check-label" for="remember">--}}
    {{--                                        {{ __('Remember Me') }}--}}
    {{--                                    </label>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                        <div class="row mb-0">--}}
    {{--                            <div class="col-md-8 offset-md-4">--}}
    {{--                                <button type="submit" class="btn btn-primary">--}}
    {{--                                    {{ __('Login') }}--}}
    {{--                                </button>--}}

    {{--                                @if (Route::has('password.request'))--}}
    {{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
    {{--                                        {{ __('Forgot Your Password?') }}--}}
    {{--                                    </a>--}}
    {{--                                @endif--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </form>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}
@endsection
