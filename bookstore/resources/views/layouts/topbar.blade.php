<div class="container">
    <div class="topbar-wrap d-flex align-items-center justify-content-between">
        <div class="header-contact d-none d-lg-flex flex-grow-1">
            <div class="item d-flex align-items-center">
                <div class="icon">
                    <i class="fal fa-phone-volume"></i>
                </div>
                <div class="info">
                    <a href="tel:19006401">19006401</a>
                </div>
            </div>
            <div class="item d-flex align-items-center">
                <div class="icon">
                    <i class="fal fa-envelope"></i>
                </div>
                <div class="info">
                    <a href="mailto:hotro@book.com">hotro@book.com</a>
                </div>
            </div>
            <div class="item d-flex align-items-center">
                <div class="icon">
                    <i class="fal fa-map-marker-alt"></i>
                </div>
                <div class="info">
                    <a href="/">52/2 Thoại Ngọc Hầu, Phường Hòa Thạnh, Quận Tân Phú, Hồ Chí Minh</a>
                </div>
            </div>
        </div>
        <div class="header-account ml-5">
            @if(auth()->guard('customer')->check())
                <a class="mr-3 text-uppercase font-weight-bold" href="{{ route('profile') }}">Tài khoản</a>
                <a class="mr-3 text-uppercase font-weight-bold" href="{{ route('logout') }}">Đăng xuất</a>
            @else
            <a class="mr-3 text-uppercase font-weight-bold" href="{{ route('login') }}">Đăng nhập</a>
                <a class="mr-3 text-uppercase font-weight-bold" href="{{ route('register') }}">Đăng ký</a>
            @endif

        </div>

        @include('action_cart')
    </div>
</div>
