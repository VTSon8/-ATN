@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i>Danh sách liên hệ khách hàng</h1>
    <div class="breadcrumb">

    </div>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" id="view">
                    <div class="box-body">
                        <div class="row" style='padding:0px; margin:0px;'>
                            <!--ND-->
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width:20px">ID</th>
                                        <th class="text-center">Tên</th>
                                        <th class="text-center">Ngày gửi</th>
                                        <th class="text-center">Địa chỉ mail</th>
                                        <th class="text-center">Tiêu đề</th>
                                        <th class="text-center" style="width:90px">Trạng thái</th>

                                        <th class="text-center" colspan="2">Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contact as $index => $value)
                                        <tr>
                                            <td class="text-center">{{ data_get($value, 'id') }}</td>
                                            <td class="text-center">{{ data_get($value, 'name') }}</td>
                                            <td class="text-center">{{ data_get($value, 'created_at') }}</td>
                                            <td class="text-center">{{ data_get($value, 'email') }}</td>
                                            <td class="text-center">{{ data_get($value, 'title') }}</td>
                                            <td class="text-center">
                                                <a href="admin/contact/status/">
                                                    @if(data_get($value, 'status') == config('common.contact_status.published'))
                                                        <span class="fa fa-eye-slash maudo" data-toggle="tooltip"
                                                              data-placement="top" title="Chưa xem"></span>
                                                    @else
                                                        <span class="fa fa-eye mauxanh18" data-toggle="tooltip"
                                                              data-placement="top" title="Đã xem"></span>
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-info btn-xs"
                                                   href="{{ route('admin.contact.show', data_get($value, 'id')) }}"
                                                   role="button">
                                                    <span class="glyphicon glyphicon-trash"></span> Xem
                                                </a>
                                            </td>
                                            @can('soft_delete')
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('admin.contact.delete', data_get($value, 'id')) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-xs"
                                                                onclick="return confirm('Xác nhận xóa liên hệ này ?')"
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
                                        {{ $contact->appends($_GET)->onEachSide(5)->links() }}
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

