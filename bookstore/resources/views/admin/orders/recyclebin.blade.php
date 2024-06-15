@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-list-alt"></i> Đơn đang lưu</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.orders.index') }}" role="button">
            <span class="glyphicon glyphicon-remove do_nos"></span> Thoát
        </a>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" id="view">
                    <div class="box-header with-border">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row" style='padding:0px; margin:0px;'>
                                <!--ND-->
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" style="font-size: 0.9em;">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width:20px">Mã đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Điện thoại</th>
                                            <th>Tổng tiền</th>
                                            <th>Ngày tạo đơn</th>
                                            <th>Hình thức thanh toán</th>
                                            <th style="text-align: center;">Trang thái đơn hàng</th>
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="text-center">{{ data_get($order, 'code') }}</td>
                                                <td>{{ data_get($order, 'name') }}</td>
                                                <td>{{ data_get($order, 'phone') }}</td>
                                                <td>{{ number_format(data_get($order, 'price')) }} ₫
                                                </td>
                                                <td>{{ number_format(data_get($order, 'price')) }} ₫
                                                </td>
                                                <td>{{ date('m-d-Y H:i', strtotime(data_get($order, 'created_at'))) }}</td>
                                                <td style="text-align: center;">
                                                    @switch(intval(data_get($order, 'status')))
                                                        @case(0)
                                                            Chờ xác nhận
                                                            @break
                                                        @case(3)
                                                            Đã giao và thanh toán
                                                            @break
                                                        @case(4)
                                                            Khách hàng đã hủy
                                                            @break
                                                        @case(5)
                                                            Nhân viên đã hủy
                                                            @break
                                                        @default
                                                    @endswitch
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-info btn-xs"
                                                       href="{{ route('admin.orders.display', $order->id) }}"
                                                       role="button">
                                                        <span class="glyphicon glyphicon-eye-open"></span> Xem
                                                    </a>
                                                    <form action="{{ route('admin.orders.restore', $order->id) }}"
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-success btn-xs">
                                                            <span class="glyphicon glyphicon-edit"></span>Khôi phục
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <ul class="pagination">
                                            {{ $orders->appends($_GET)->onEachSide(5)->links() }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.ND -->
                        </div>
                    </div><!-- ./box-body -->
                </div><!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection


