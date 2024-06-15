<aside class="main-sidebar">

    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="{{ route('admin.index') }}">
                    <i class="fa fa-bar-chart"></i> <span>Thống kê</span>
                </a>
            </li>
            <li class="header">QUẢN LÝ CỬA HÀNG</li>
            <li class="treeview">
                <a href="{{ route('admin.posts.index') }}">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Bài viết</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('admin.products.index') }}">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> <span>Sản phẩm sách</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ route('admin.category.index') }}">
                    <i class="fa fa-list" aria-hidden="true"></i> <span>Danh mục sách</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('admin.supplier.index') }}">
                    <i class="fa fa-trademark" aria-hidden="true"></i> <span>Nhà cung cấp</span>
                </a>
            </li>
            <li class="header">QUẢN LÝ BÁN HÀNG</li>
            <li class="treeview">
                <a href="{{ route('admin.discount.index') }}">
                    <i class="fa fa-tags" aria-hidden="true"></i> <span>Mã giảm giá</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('admin.contact.index') }}">
                    <i class="fa fa-envelope"></i> <span>Liên hệ</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('admin.orders.index') }}">
                    <i class="fa fa-shopping-cart"></i> <span>Đơn hàng</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('admin.customer.index') }}">
                    <i class="fa fa-user"></i><span>Khách hàng</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('admin.banners.index') }}">
                    <i class="fa fa-television" aria-hidden="true"></i> <span>Giao diện</span>
                </a>
            </li>
            <li class="header">CÀI ĐẶT</li>
            <li class="treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i><span>Hệ thống</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active">
                        <a href="{{ route('admin.config.index') }}">
                            <i class="fa fa-cogs"></i> Vị trí & phí vận chuyển
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.accounts.index') }}">
                            <i class="fa fa-users"></i> Nhân viên
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logs_viewer') }}">
                            <img src="{{ asset('assets/images/bug-solid.svg') }}" alt="bug" style="width: 16px;height: 16px;"> Log-Viewer
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('form_logout').submit();"><i class="fa fa-sign-out text-red"></i> <span>Thoát</span></a></li>
            <form action="{{ route('admin.logout') }}" method="POST" id="form_logout">
                @csrf
            </form>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
