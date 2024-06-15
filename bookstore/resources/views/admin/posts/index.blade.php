@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-text-background"></i> Danh sách bài viết</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.posts.create') }}" role="button">
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
                        <div class="box-body">
                            <div class="row" style='padding:0px; margin:0px;'>
                                <!--ND-->
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center" style="width:100px;">Hình</th>
                                            <th class="text-center">Tiêu đề bài viết</th>
                                            <th class="text-center">Mô tả</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($posts as $value)
                                            <tr>
                                                <td class="text-center">{{ data_get($value, 'id') }}</td>
                                                <td>
                                                    <img src="{{ url('assets/upload/' . data_get($value, 'img')) }}"
                                                         alt="" class="img-responsive">
                                                </td>
                                                <td>{{ data_get($value, 'title', '') }}</td>
                                                <td>{{ data_get($value, 'description', '') }}</td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('admin.posts.update_status', data_get($value, 'id')) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="hidden" name="status"
                                                               value="{{ data_get($value, 'status') }}">
                                                        <button type="submit" class="btn-status">
                                                            @if(data_get($value, 'status') == config('common.post_status.published'))
                                                                <span
                                                                    class="glyphicon glyphicon-ok-circle mauxanh18"></span>
                                                            @else
                                                                <span
                                                                    class="glyphicon glyphicon-remove-circle maudo"></span>
                                                            @endif
                                                        </button>
                                                    </form>

                                                </td>
                                                @can('edit')
                                                    <td class="text-center">
                                                        <a class="btn btn-success btn-xs"
                                                           href="{{ route('admin.posts.show', ['id' => data_get($value, 'id')]) }}"
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
                                                            action="{{ route('admin.posts.delete', data_get($value, 'id')) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận xóa bài này ?')"
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
        </div>
        <!-- /.row -->
    </section>
@endsection

