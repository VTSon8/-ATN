@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i>Danh sách nhà cung cấp</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.supplier.create') }}" role="button">
            <span class="glyphicon glyphicon-plus"></span> Thêm mới
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
                                            <th class="text-center" style="width:20px">ID</th>
                                            <th class="text-center">Tên nhà cung cấp</th>
                                            <th class="text-center">Tên người đại diện</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Số điện thoại</th>
                                            <th class="text-center">Địa chỉ</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($listSupplier as $value)
                                            <tr>
                                                <td class="text-center">{{data_get($value, 'id')}}</td>
                                                <td class="text-center">{{data_get($value, 'name')}}</td>
                                                <td class="text-center">{{data_get($value, 'representative_name')}}</td>
                                                <td class="text-center">{{data_get($value, 'email', '')}}</td>
                                                <td class="text-center">{{data_get($value, 'phone')}}</td>
                                                <td class="text-center">{{data_get($value, 'address')}}</td>
                                                <td class="text-center">
                                                    <a href="admin/supplier/status/">
                                                        @if(data_get($value, 'status') == 1)
                                                            <span
                                                                class="glyphicon glyphicon-ok-circle mauxanh18"></span>
                                                        @else
                                                            <span
                                                                class="glyphicon glyphicon-remove-circle maudo"></span>
                                                        @endif
                                                    </a>
                                                </td>
                                                @can('edit')
                                                    <td class="text-center">
                                                        <a class="btn btn-success btn-xs"
                                                           href="{{route('admin.supplier.show', ['id' => data_get($value, 'id')])}}"
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
                                                            action="{{ route('admin.supplier.delete', data_get($value, 'id')) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận xóa nhà cung cấp này ?')"
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

