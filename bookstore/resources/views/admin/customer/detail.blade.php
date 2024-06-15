@extends("admin.layouts.app")

@section('page-title')
    <h1>Chi tiết thông tin khách hàng</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.customer.index') }}" role="button">
            <span class="glyphicon glyphicon-remove"></span> Thoát
        </a>
    </div>
@endsection

@section('content')
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <!--ND-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và tên <span class="maudo">(*)</span></label>
                                <input type="text" name="fullname" value="{{ data_get($customer, 'name') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Điện thoại <span class="maudo">(*)</span></label>
                                <input type="text" name="phone" value="{{ data_get($customer, 'phone') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email <span class="maudo">(*)</span></label>
                                <input type="email" name="email" value="{{ data_get($customer, 'email') }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{--                            <div class="form-group">--}}
                            {{--                                <label>Giới tính</label>--}}
                            {{--                                <select name="gender" class="form-control" style="max-width:30%">--}}
                            {{--                                    <option value="1">Nam</option>--}}
                            {{--                                    <option value="0">Nữ</option>--}}
                            {{--                                </select>--}}
                            {{--                            </div>--}}
                            <div class="form-group">
                                <label>Ngày sinh <span class="maudo">(*)</span></label>
                                <input type="date" name="birthday"
                                       @if(!empty(data_get($customer, 'birthday')))
                                           value="{{ date('Y-m-d', strtotime(data_get($customer, 'birthday'))) }}"
                                       @endif
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ <span class="maudo">(*)</span></label>
                                <input type="text" name="address" value="{{ data_get($customer, 'address') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Trạng thái </label>
                                <select name="status" class="form-control" style="max-width:30%">
                                    <option value="1" {{ $customer->status == 1 ? 'selected' : '' }}>Đang hoạt động
                                    </option>
                                    <option value="0" {{ $customer->status == 0 ? 'selected' : '' }}>Ngưng hoạt động
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!--/.ND-->
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection


