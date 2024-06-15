@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i>Danh sách đơn hàng</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.orders.recyclebin') }}" role="button">
            <span class="glyphicon glyphicon-trash"></span> Đơn hàng đã lưu({{ $total_trash ?? '' }})
        </a>
    </div>
@endsection

@section('content')
    <!-- Main content -->
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
{{--                                            <th class="text-center">Khách hàng</th>--}}
{{--                                            <th class="text-center">Điện thoại</th>--}}
                                            <th class="text-center">Tổng tiền</th>
                                            <th class="text-center">Ngày đặt hàng</th>
                                            <th class="text-center">Trạng thái đơn hàng</th>
                                            <th class="text-center">Hình thức thanh toán</th>
                                            <th class="text-center">Trạng thái thanh toán</th>
                                            <th class="text-center" colspan="2">Xử lý đơn</th>
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="text-center">{{ data_get($order, 'code') }}</td>
{{--                                                <td class="text-center">{{ data_get($order, 'name') }}</td>--}}
{{--                                                <td class="text-center">{{ data_get($order, 'phone') }}</td>--}}
                                                <td class="text-center">{{ number_format(data_get($order, 'price')) }} ₫</td>
                                                <td class="text-center">{{ date('m-d-Y H:i', strtotime(data_get($order, 'created_at'))) }}</td>
                                                <td style="text-align: center;">
                                                    @switch(intval(data_get($order, 'status')))
                                                        @case(0)
                                                            Chờ xác nhận
                                                            @break
                                                        @case(1)
                                                            Chờ lấy hàng
                                                            @break
                                                        @case(2)
                                                            Đang giao
                                                            @break
                                                        @case(3)
                                                            Đã giao
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
                                                <td class="text-center">{{ data_get($order, 'payment_type') == 0 ? 'Khi nhận hàng' : 'VNPAY' }}</td>
                                                <td class="text-center">{{ data_get($order, 'payment_status') == 0 ? 'Chưa thanh toán' : 'Đã thanh toán' }}</td>
                                                <td style="text-align: center;">
                                                    @if(data_get($order, 'status') == 0)
                                                        <form style="display: inline;"
                                                              action="{{ route('admin.orders.update_status', $order->id)}}"
                                                              method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="1">
                                                            <button class="btn btn-default btn-xs"
                                                                    onclick="return confirm('Xác nhận gói hàng và chuẩn bị đơn hàng ?')"
                                                                    role="button">
                                                                <i class="fa fa-check-square-o"></i> Duyệt đơn đặt hàng
                                                            </button>
                                                        </form>
                                                    @endif
                                                        @if(data_get($order, 'status') == 1)
                                                            <form style="display: inline;"
                                                                  action="{{ route('admin.orders.update_status', $order->id)}}"
                                                                  method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="2">
                                                                <button class="btn btn-default btn-xs"
                                                                        onclick="return confirm('Xác nhận gói hàng và chuẩn bị đơn hàng ?')"
                                                                        role="button">
                                                                    <i class="fa fa-check-square-o"></i> Xác nhận giao hàng
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if(data_get($order, 'status') == 2)
                                                            <form style="display: inline;"
                                                                  action="{{ route('admin.orders.update_status', $order->id)}}"
                                                                  method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="3">
                                                                <button class="btn btn-success btn-xs"
                                                                        onclick="return confirm('Xác nhận đơn hàng đã giao và thanh toán thành công ?')"
                                                                        role="button">
                                                                    <i class="fa  fa-thumbs-o-up"></i> Xác nhận đã giao
                                                                </button>
                                                            </form>
                                                @endif

                                                <td class="text-center">
                                                    @if(data_get($order, 'status') == 0)
                                                        <form style="display: inline;"
                                                              action="{{ route('admin.orders.update_status', $order->id)}}"
                                                              method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="5">
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận hủy đơn hàng này ?')"
                                                                    role="button">
                                                                <i class="fa fa-save"></i> Hủy đơn
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                                </td>
                                                <td class="text-center">
                                                    <!-- /Xem -->
                                                    <a class="btn btn-info btn-xs" href="{{ route('admin.orders.show', $order->id) }}"
                                                       role="button">
                                                        <span class="glyphicon glyphicon-eye-open"></span> Xem
                                                    </a>
                                                    <!-- /Xóa -->
                                                    <form style="display: inline;"
                                                          action="{{ route('admin.orders.delete', $order->id) }}"
                                                          method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn bg-olive btn-xs"
                                                           onclick="return confirm('Xác nhận lưu đơn hàng này ?')"
                                                           role="button">
                                                            <i class="fa fa-save"></i> Lưu đơn
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <ul class="pagination">
                                        {{ $orders->appends($_GET)->onEachSide(5)->links() }}
                                    </ul>
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

