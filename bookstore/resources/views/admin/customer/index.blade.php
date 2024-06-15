@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i>Danh sách khách hàng</h1>
    <div class="breadcrumb">

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
                                            <th class="text-center">Tên khách hàng</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Ngày sinh</th>
                                            <th class="text-center">Điện thoại</th>
                                            <th class="text-center" colspan="3">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customers as $customer)
                                            <tr>
                                                <td class="text-center">{{ data_get($customer, 'id') }}</td>
                                                <td class="text-center">{{ data_get($customer, 'name') }}</td>
                                                <td class="text-center">{{ data_get($customer, 'email') }}</td>
                                                <td class="text-center">
                                                    @if(!empty(data_get($customer, 'birthday')))
                                                        {{ date('m/d/Y', strtotime(data_get($customer, 'birthday'))) }}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ data_get($customer, 'phone') }}</td>
                                                <td class="text-center">
                                                    <a class="btn btn-info btn-xs"
                                                       href="{{ route('admin.customer.show', $customer->id) }}"
                                                       role="button">
{{--                                                        <span class="glyphicon glyphicon-show"></span>--}}
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('admin.customer.lock', $customer->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-danger btn-xs"
                                                                onclick="return confirm('Xác nhận khóa tài khoản này ?')"
                                                                role="button">
                                                            @if($customer->status == 0)
                                                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                                            @else
                                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                                            @endif
                                                        </button>
                                                    </form>
                                                </td>
                                                @can('soft_delete')
                                                    <td class="text-center">
                                                        <form
                                                            action="{{ route('admin.customer.delete', $customer->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận xóa thông tin khách hàng này ?')"
                                                                    role="button">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </button>
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
                                            {{ $customers->appends($_GET)->onEachSide(5)->links() }}
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

