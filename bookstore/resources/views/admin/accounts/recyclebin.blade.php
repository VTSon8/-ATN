@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i> Thùng rác tài khoản</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.accounts.index') }}" role="button">
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
                            <div class="row" style="padding:0px; margin:0px;">
                                <!--ND-->
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Họ và tên</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th class="text-center">Khôi phục</th>
                                            <th class="text-center">Xóa VV</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($accounts as $account)
                                            <tr>
                                                <td class="text-center">{{ data_get($account, 'id') }}</td>
                                                <td>
                                                    <p>{{ data_get($account, 'name') }}</p>
                                                </td>
                                                <td>{{ data_get($account, 'email') }}</td>
                                                <td>{{ data_get($account, 'phone') }}</td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('admin.accounts.restore', data_get($account, 'id')) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-success btn-xs" role="button">
                                                            <span class="glyphicon glyphicon-edit"></span>Khôi phục
                                                        </button>
                                                    </form>
                                                </td>
                                                @role('super-admin')
                                                    <form
                                                        action="{{ route('admin.accounts.forever_delete', data_get($account, 'id')) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <td class="text-center">
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận xóa thành viên này ?')"
                                                                    role="button">
                                                                <span class="glyphicon glyphicon-trash"></span>Xóa VV
                                                            </button>
                                                        </td>
                                                    </form>
                                                @else
                                                    <td class="text-center">
                                                        <p class="fa fa-lock" style="color:red"> Không đủ quyền</p>
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


