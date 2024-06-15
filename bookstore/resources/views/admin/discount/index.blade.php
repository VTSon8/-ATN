@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i>Danh sách mã giảm giá</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.discount.create') }}" role="button">
            <span class="glyphicon glyphicon-plus"></span> Thêm mới
        </a>
        {{--        <a class="btn btn-primary btn-sm" href="{{ route('admin.discount.recyclebin') }}" role="button">--}}
        {{--            <span class="glyphicon glyphicon-trash"></span> Thùng rác({{ $total_trash ?? '' }})--}}
        {{--        </a>--}}
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
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Mã giảm giá</th>
                                            <th class="text-center">Số tiền giảm</th>
                                            <th class="text-center"
                                            >Số tiền đơn hàng áp dụng tối thiểu
                                            </th>
                                            <th class="text-center">Số lần giới hạn nhập</th>
                                            <th class="text-center">Hạn nhập</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($discounts as $discount)
                                            <tr>
                                                <td class="text-center">{{data_get($discount, 'id')}}</td>
                                                <td class="text-center">{{data_get($discount, 'code')}}</td>
                                                <td class="text-center">{{number_format(data_get($discount, 'discount'))}} đ</td>
                                                <td class="text-center">{{number_format(data_get($discount, 'payment_limit'))}} đ</td>
                                                <td class="text-center">
                                                    {{data_get($discount, 'limit_number')}}
                                                </td>
                                                <td class="text-center">{{data_get($discount, 'expiration_date')}}</td>
                                                <td class="text-center">
                                                    <a href="admin/discount/status/">
                                                        @if(data_get($discount, 'status') == config('common.discount_status.published'))
                                                            <span
                                                                class="glyphicon glyphicon-ok-circle mauxanh18"></span>
                                                        @else
                                                            <span
                                                                class="glyphicon glyphicon-remove-circle maudo"></span>
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    @can('edit')
                                                        <a class="btn btn-success btn-xs"
                                                           href="{{route('admin.discount.show', ['id' => $discount->id])}}"
                                                           role="button">
                                                            <span class="glyphicon glyphicon-edit"></span> Sửa
                                                        </a>
                                                    @else
                                                        <p class="fa fa-lock" style="color:red"> Không đủ quyền</p>
                                                    @endcan
                                                </td>
                                                @can('forever_delete')
                                                    <td class="text-center">
                                                        <a class="btn btn-danger btn-xs" href="javascript:void(0);"
                                                           onclick="event.preventDefault();
                                                            if (confirm('Xác nhận xóa nha cung c này ?')) {
                                                                document.getElementById('delete-discount').submit();
                                                            }"
                                                           role="button">
                                                            <span class="glyphicon glyphicon-trash"></span> Xóa
                                                        </a>
                                                        <form
                                                            action="{{route('admin.discount.delete', ['id' => data_get($discount, 'id')])}}"
                                                            method="POST" id="delete-discount">
                                                            @csrf
                                                        </form>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <p class="fa fa-lock" style="color:red"> Không đủ quyền</p>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <ul class="pagination">
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

