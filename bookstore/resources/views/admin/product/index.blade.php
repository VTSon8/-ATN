@extends("admin.layouts.app")

@push('css')
    <link rel="stylesheet" href="{{ asset("assets/css/product.css") }}">
@endpush

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i>Danh sách sản phẩm</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.products.create') }}" role="button">
            <span class="glyphicon glyphicon-plus"></span> Thêm mới
        </a>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.products.recyclebin') }}" role="button">
            <span class="glyphicon glyphicon-trash"></span> Thùng rác({{ $total_trash ?? '' }})
        </a>
    </div>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <form method="get" accept-charset="utf-8">
            <div class="row">
                <div class="col-md-12 form-search">
                    <div class="product-search col-md-3">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm..."
                               class="form-control">
                    </div>
                    <button class="product-submit">Tìm kiếm</button>
                </div>
            </div>
        </form>

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
                                            <th class="text-center" style="width:20px">ID</th>
                                            <th>Hình</th>
                                            <th>Tên sản phẩm</th>
                                            <th class="text-center">Số lượng trong kho</th>
                                            <th class="text-center">Loại sách</th>
                                            <th class="text-center">Đánh giá</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Nhập hàng</th>
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($listProduct as $product)
                                            <tr style="height: 100px;">
                                                <td class="text-center">{{data_get($product, 'id')}}</td>
                                                <td style="width:100px">
                                                    <img
                                                        src="{{asset('assets/upload') . '/' . data_get($product, 'thumb')}}"
                                                        alt="" class="img-responsive">
                                                </td>
                                                <td style="font-size: 16px;width: 25%;">{{data_get($product, 'name')}}</td>
                                                <td class="text-center">{{data_get($product, 'number')}}</td>
                                                <td class="text-center">{{data_get($product, 'category.name')}}</td>
                                                <td class="text-center">{{data_get($product, 'avg_rate')}}
{{--                                                    <i class="fa-solid fa-star" style="color: #ffc107;"></i>--}}
                                                    <i class="fa fa-star" aria-hidden="true" style="color: #ffc107;"></i>
                                                </td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('admin.products.update_status', data_get($product, 'id')) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="hidden" name="status"
                                                               value="{{ data_get($product, 'status') }}">
                                                        <button type="submit" class="btn-status">
                                                            @if(data_get($product, 'status') == config('common.product_status.published'))
                                                                <span
                                                                    class="glyphicon glyphicon-ok-circle mauxanh18"></span>
                                                            @else
                                                                <span
                                                                    class="glyphicon glyphicon-remove-circle maudo"></span>
                                                            @endif
                                                        </button>
                                                    </form>
                                                </td>
                                                @can('import_goods')
                                                    <td class="text-center">
                                                        <a class="btn btn-info btn-xs"
                                                           href="{{ route('admin.products.import', data_get($product, 'id')) }}"
                                                           role="button">
                                                            <i class="fa fa-plus" aria-hidden="true"></i> Nhập hàng
                                                        </a>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <p class="fa fa-lock" style="color:red"> Không đủ quyền</p>
                                                    </td>
                                                @endcan
                                                @can('edit')
                                                    <td class="text-center">
                                                        <a class="btn btn-success btn-xs"
                                                           href="{{ route('admin.products.show', data_get($product, 'id')) }}"
                                                           role="button">
                                                            <span class="glyphicon glyphicon-edit"></span> Sửa
                                                        </a>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <p class="fa fa-lock" style="color:red"> Không đủ quyền</p>
                                                    </td>
                                                @endcan
                                                @can('soft_delete')
                                                    <td class="text-center">
                                                        <form
                                                            action="{{ route('admin.products.delete', data_get($product, 'id')) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận xóa sản phẩm này ?')"
                                                                    role="button">
                                                                <span class="glyphicon glyphicon-trash"></span> Xóa
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
                                            {{ $listProduct->appends($_GET)->onEachSide(5)->links() }}
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.ND -->
                            </div>
                        </div><!-- ./box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

