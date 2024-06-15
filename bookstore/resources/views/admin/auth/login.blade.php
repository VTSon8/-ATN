<html lang="">
<head>
    <base href=""></base>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản trị hệ thống</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
<div class="container khung">
    <div class="title">
        <h2 class="text-center" style="color:#337ab7">Books Store</h2>
    </div>
    <hr>
    <div class="myform">
        <form method="POST" action="{{ route('admin.login') }}" role="form">
            @csrf
            <div class="row form-row">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="email" name="email" class="form-control" placeholder="Tên tài khoản">

                </div>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="row form-row">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">

                </div>
                @error('password')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="row form-row" style="width:100%; margin-top: 15px;">
                <button type="submit" class="form-control btn btn-primary btn-login">Đăng nhập</button>
            </div>
{{--            @if(session()->has('message'))--}}
{{--                <div class="row">--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <span>{{ session()->get('message') }}</span>--}}
{{--                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
        </form>
    </div>
    <hr>
</div>

{{--@include('admin.common.footer')--}}
<!-- jQuery -->
<script src="{{ asset('assets/js/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>

</body>
</html>


