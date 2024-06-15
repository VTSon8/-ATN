<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hệ thống Books Store</title>
    <style>
        .info {
            color: #0f0f0f;
            font-size: 16px;
            font-weight: 700;
        }

        .new-account {
            font-size: 16px;
        }

        .logo-email {
            display: flex;
            justify-items: center;
            align-content: center;
            max-height: 100px;
        }
    </style>
</head>
<body>
<section class="new-account">
    <div class="logo-email"><img src="{{asset('assets/images/logo.svg')}}" alt="" style="width: 300px;"></div>
    <h1>Xác nhận tài khoản khách hàng đã được khởi tạo</h1>
    <div>
        <p><span class="info">{{ __('common.name') }}</span>: {{ data_get($data, 'name', '') }}</p>
        <p><span class="info">{{ __('common.email') }}</span>: {{ data_get($data, 'email', '') }}</p>
    </div>
    <p>Bạn đã trở thành thành viên mới của cửa hàng ShopGrids, Cửa hàng tặng bạn 1 mã giảm giá
        <span>{{ data_get($coupon, 'code', '') }}</span> giảm {{ number_format(data_get($coupon, 'discount')) }} đ
    </p>
    <p>Mã này có giá trị tới ngày {{ date('d-m-Y H:i:s', strtotime(data_get($coupon, 'expiration_date', ''))) }}</p>
    <p>Hãy sử dụng tài khoản để mua hàng để tích lũy nhận thêm nhiều ưu đãi !</p>
    <br>
    <p>Trân trọng,</p>
    <p>ShopGrids</p>
</section>
</body>
</html>

