@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i> Danh sách tài khoản cửa hàng</h1>
    <div class="breadcrumb">

        <a class='btn btn-primary btn-sm' href='{{ route('admin.accounts.create') }}' role='button'>
            <span class='fa fa-user-plus'></span> Thêm mới
        </a>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.accounts.recyclebin') }}" role="button">
            <span class="glyphicon glyphicon-trash"></span> Thùng rác ({{ $total_trash ? $total_trash : 0 }})
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
                                            <th>Hình ảnh</th>
                                            {{--                                                <th>Họ và tên</th>--}}
                                            {{--                                                <th>Email</th>--}}
                                            {{--                                                <th>Phone</th>--}}
                                            {{--                                                <th>Địa chỉ</th>--}}
                                            <th class=" text-center">Tên tài khoản</th>
                                            <th class=" text-center">Email</th>
                                            <th class=" text-center">Quyền</th>
                                            <th class=" text-center">Trạng thái</th>
                                            <th class=" text-center">Người tạo</th>
                                            {{--                                            <th class=" text-center">Người sửa</th>--}}
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($accounts as $account)
                                            <tr>
                                                <td class="text-center">{{ data_get($account, 'id') }}</td>
                                                <td style="width:100px">
                                                    <img
                                                        src="{{ $account->avatar ? url('assets/upload/' . data_get($account, 'avatar')) : asset('assets/images/admin/403ceb0ed6fdb72494bbd2ac39182b04.png') }}"
                                                        class="img-responsive">
                                                </td>
                                                <td class="text-center">{{ data_get($account, 'name') }}</td>
                                                <td class="text-center">{{ data_get($account, 'email') }}</td>
                                                <td class="text-center">
                                                    @foreach(config('constants.roles_name') as $index => $roleName)
                                                        @if($account->role_id == $index)
                                                            {{ $roleName }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    <a href="">
                                                        @if(data_get($account, 'status') == 1)
                                                            <span
                                                                class="glyphicon glyphicon-ok-circle mauxanh18"></span>
                                                        @else
                                                            <span
                                                                class="glyphicon glyphicon-remove-circle maudo"></span>
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    @if (!is_null($account->child))
                                                        {{ $account->child->name }}
                                                    @endif
                                                </td>
                                                @role('super-admin|admin')
                                                <td class="text-center">
                                                    <a class="btn btn-success btn-xs"
                                                       href='{{ route('admin.accounts.show', $account->id) }}'>
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                    </a>
                                                </td>
                                                @else
                                                    <td class="text-center" colspan="2">
                                                        <p class="fa fa-lock" style="color:red"> Không thể thao tác</p>
                                                    </td>
                                                    @endrole
                                                    @role('super-admin|admin')
                                                    <td class="text-center">
                                                        <form
                                                            action="{{ route('admin.accounts.delete', $account->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận xóa thông nhân viên này ?')"
                                                                    role="button">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                    @else
                                                        <td class="text-center" colspan="2">
                                                            <p class="fa fa-lock" style="color:red"> Không thể thao
                                                                tác</p>
                                                        </td>
                                                        @endrole
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <ul class="pagination">
                                            {{ $accounts->appends($_GET)->onEachSide(5)->links() }}
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

