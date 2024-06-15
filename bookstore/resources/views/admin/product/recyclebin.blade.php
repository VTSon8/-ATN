@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-picture"></i> Thùng rác sản phẩm</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.products.index') }}" role="button">
            <span class="glyphicon glyphicon-remove do_nos"></span> Thoát
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
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Hình</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Người đăng</th>
                                            <th class="text-center">Khôi phục</th>
                                            <th class="text-center">Xóa VV</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($recyclebin as $index => $product)
                                            <tr>
                                                <td class="text-center">{{ $index }}</td>
                                                <td style="width:100px">
                                                    <img src="{{asset('assets/upload') . '/' . data_get($product, 'thumb')}}"
                                                         alt="" class="img-responsive">
                                                </td>
                                                <td>{{ data_get($product, 'name') }}</td>
                                                <td>{{ data_get($product, 'account.name') }}</td>

                                                <td class="text-center">
                                                    <form action="{{ route('admin.products.restore', data_get($product, 'id')) }}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button class="btn btn-success btn-xs">
                                                            <span class="glyphicon glyphicon-edit"></span> Khôi phục
                                                        </button>
                                                    </form>
                                                </td>
                                                <form action="{{ route('admin.products.forever_delete', data_get($product, 'id')) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    @can('forever_delete')
                                                        <td class="text-center">
                                                            <button class="btn btn-danger btn-xs" onclick="return confirm('Xác nhận xóa sản phẩm này ?')">
                                                                <span class="glyphicon glyphicon-trash"></span>Xóa VV
                                                            </button>
                                                        </td>
                                                    @else
                                                        <td class="text-center">
                                                            <p class="fa fa-lock" style="color:red"> Không đủ quyền</p>
                                                        </td>
                                                    @endcan
                                                </form>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <ul class="pagination">
                                            {{ $recyclebin->appends($_GET)->onEachSide(5)->links() }}
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
        </div>
        <!-- /.row -->
    </section>
@endsection


