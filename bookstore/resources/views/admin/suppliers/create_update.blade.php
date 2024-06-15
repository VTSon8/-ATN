@extends("admin.layouts.app")

@php
    $isUpdate = isset($id) ? true : false;
    $routeSubmit = isset($id) ? route('admin.supplier.update', $id) : route('admin.supplier.store');
@endphp

@section('page-title')
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-picture"></i> {{$isUpdate ? 'Cập nhật nhà cung cấp' : 'Thêm nhà cung cấp' }}
        </h1>
        <div class="breadcrumb">
            <button class="btn btn-primary btn-sm"
                    onclick="event.preventDefault(); document.getElementById('form-supplier').submit();">
                <span class="glyphicon glyphicon-floppy-save"></span> Lưu[Thêm]
            </button>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.supplier.index') }}" role="button">
                <span class="glyphicon glyphicon-remove"></span> Thoát
            </a>
        </div>
    </section>
@endsection

@section('content')
    <form action="{{ $routeSubmit }}" enctype="multipart/form-data" method="POST" accept-charset="utf-8"
          id="form-supplier">
        @csrf
        @if($isUpdate)
            @method('PUT')
        @endif
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box" id="view">
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tên nhà cung cấp <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{isset($data) ? data_get($data, 'name') : ''}}"
                                           placeholder="Tên nhà cung cấp">
                                    @error('name')
                                    <div class="error" style="color: red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tên người đại diện <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="representative_name"
                                           value="{{isset($data) ? data_get($data, 'representative_name') : ''}}"
                                           placeholder="Tên người đại diện">
                                    @error('representative_name')
                                    <div class="error" style="color: red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email"
                                           value="{{isset($data) ? data_get($data, 'email') : ''}}"
                                           placeholder="Từ khóa">
                                    @error('email')
                                    <div class="error" style="color: red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Số điện thoại <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="phone"
                                           value="{{isset($data) ? data_get($data, 'phone') : ''}}"
                                           placeholder="Số điện thoại">
                                    @error('phone')
                                    <div class="error" style="color: red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="address"
                                           value="{{isset($data) ? data_get($data, 'address') : ''}}"
                                           placeholder="Địa chỉ">
                                    @error('address')
                                    <div class="error" style="color: red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option
                                            value="1" {{isset($data) && data_get($data, 'status') == 1 ? 'selected' : ''}}>
                                            Đang hoạt động
                                        </option>
                                        <option
                                            value="0" {{isset($data) && data_get($data, 'status') == 0 ? 'selected' : ''}}>
                                            Ngừng hoạt động
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </form>
@endsection





