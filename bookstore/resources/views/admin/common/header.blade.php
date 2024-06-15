<header class="main-header">
    <a href="" class="logo">
        <span class="logo-lg">Quản trị hệ thống</span>
    </a>
    {{--    <a href="index3.html" class="brand-link active">--}}
    {{--        <img src="{{ asset('assets/images/logo.svg') }}" alt="ShopGrids" class="brand-image " style="opacity: .8">--}}
    {{--        <span class="brand-text font-weight-light">ShopGrids</span>--}}
    {{--    </a>--}}
    <nav class="navbar navbar-static-top" style="height: 52px">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav" style="height: 52px;  padding: 1px">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">
                         {{ data_get($noti, 'total_pending') + data_get($noti, 'total_delivering') }}
                      </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i>
                                        Đơn hàng chưa duyệt
                                        @if(isset($noti) && $noti->total_pending != 0)
                                            <span class="label label-success">
                                                {{ data_get($noti, 'total_pending') }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i>
                                        Đơn hàng đang giao
                                        @if(isset($noti) && $noti->total_delivering != 0)
                                            <span class="label label-warning">
                                            {{ data_get($noti, 'total_delivering') }}
                                        </span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="{{ route('admin.orders.index') }}">Xem</a></li>
                    </ul>
                </li>
                <li style="height: 52px">
                    <a target="_blank" href="{{ route('home') }}">
                        <span class="glyphicon glyphicon-home"></span>
                        <span>Website</span>
                    </a>
                </li>
                <li class="dropdown user user-menu" style="height: 52px; padding: 0px">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display: inline-block;">
                        <img src="{{ asset("assets/images/admin/403ceb0ed6fdb72494bbd2ac39182b04.png") }}"
                             class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ optional(auth()->user())->name ?? '' }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ asset("assets/images/admin/403ceb0ed6fdb72494bbd2ac39182b04.png") }}"
                                 class="img-circle" alt="User Image">
                            <p><small>{{ optional(auth()->user())->name ?? '' }}</small></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="" class="btn btn-default btn-flat">Chi tiết</a>
                            </div>
                            <div class="pull-right">
                                <a href="javascript:void(0);"
                                   onclick="event.preventDefault(); document.getElementById('form_logout').submit();"
                                   class="btn btn-default btn-flat">Thoát</a>
                                <form action="{{ route('admin.logout') }}" method="POST" id="form_logout">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

