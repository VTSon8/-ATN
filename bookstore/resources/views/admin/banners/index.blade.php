@extends("admin.layouts.app")

@section('page-title')
    <h1><i class="glyphicon glyphicon-picture"></i> Quản lý slide</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.banners.create') }}" role="button">
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
                            <div class="row">
                                <!--ND-->
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Hình</th>
                                            <th>Tên slide</th>
                                            <th>Mô tả</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center" colspan="2">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($banners as $banner)
                                            <tr class="item-{{ data_get($banner, 'id') }}">
                                                <td class="text-center">{{ data_get($banner, 'id') }}</td>
                                                <td style="width:180px">
                                                    <img
                                                        src="{{ asset('assets/upload') . '/' . data_get($banner, 'thumb') }}"
                                                        class="img-responsive">
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.banners.show', ['id' => data_get($banner, 'id')]) }}">{{ data_get($banner, 'name') }}</a>
                                                </td>
                                                <td>{{ data_get($banner, 'description') }}</td>
                                                <td class="text-center">
                                                    @if(data_get($banner, 'status') == 1)
                                                        <span class="glyphicon glyphicon-ok-circle mauxanh18"></span>
                                                    @else
                                                        <span class="glyphicon glyphicon-remove-circle maudo"></span>
                                                    @endif
                                                </td>
                                                @can('edit')
                                                    <td class="text-center">
                                                        <a class="btn btn-success btn-xs"
                                                           href="{{ route('admin.banners.show', ['id' => data_get($banner, 'id')]) }}"
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
                                                            action="{{ route('admin.banners.delete', data_get($banner, 'id')) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Xác nhận xóa slider này ?')">
                                                                <span class="glyphicon glyphicon-trash"></span> Xóa
                                                            </button>
                                                            {{--                                                    <a class="btn btn-danger btn-xs soft_delete"--}}
                                                            {{--                                                       href="javascript:void(0)"--}}
                                                            {{--                                                       data-id="{{  data_get($banner, 'id') }}"--}}
                                                            {{--                                                       data-url="{{ route('admin.banners.delete', ['id' => data_get($banner, 'id')]) }}"--}}
                                                            {{--                                                       role="button">--}}
                                                            {{--                                                        <span class="glyphicon glyphicon-trash"></span>Xóa--}}
                                                            {{--                                                    </a>--}}
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
                                        {{ $banners->appends($_GET)->onEachSide(5)->links() }}
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

@push('js')
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
        }

        $(document).ready(function () {
            $(document).on('click', '.soft_delete', function () {
                const clickedObject = $(this);
                comfirm(clickedObject);
            })
        })

        function comfirm(clickedObject) {
            swal({
                title: "Xác nhận xóa slider này?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        callAjax(clickedObject);
                    } else {
                        return false;
                    }
                });
        }

        function callAjax(clickedObject) {
            let url = clickedObject.data('url');
            let id = clickedObject.data('id');
            if (url) {
                $.ajax({
                    method: "DELETE",
                    url: url,
                    data: {id: id}
                }).always(function (response) {
                    if (response.code == 200) {
                        $('.table-bordered .item-' + id).empty();
                        toastr["success"]("Xóa thành công", "Thông báo");
                    }
                })
                    .fail(function () {
                        swal("Có lỗi xảy ra vui lòng thao tác lại!", {
                            icon: "error",
                        });
                    });
            }
        }
    </script>
@endpush
