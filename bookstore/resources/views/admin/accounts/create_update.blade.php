@extends("admin.layouts.app")

@php
    $isUpdate = isset($id) ? true : false;
    $routeSubmit = isset($id) ? route('admin.accounts.update', $id) : route('admin.accounts.store');
@endphp

@section('page-title')
    <h1><i class="fa fa-user-plus"></i> {{ $isUpdate ? 'Sửa thông tin nhân viên' : 'Thêm thành viên' }}</h1>
    <div class="breadcrumb">
        <button type="submit" onclick="event.preventDefault();document.getElementById('account').submit();"
                class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-floppy-save"></span>
            Lưu[Thêm]
        </button>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.accounts.index') }}" role="button">
            <span class="glyphicon glyphicon-remove do_nos"></span> Thoát
        </a>
    </div>
@endsection

@section('content')
    <form action="{{ $routeSubmit }}" enctype="multipart/form-data" method="POST" accept-charset="utf-8" id="account">
        @csrf
        @if($isUpdate)
            @method('PUT')
        @endif
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box" id="view">
                        <div class="box-body">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Họ và tên <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name', isset($account) ? data_get($account, 'name', '') : '') }}">
                                    @error('name')
                                    <div class="error"><p>{{$message}}</p></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email <span class="maudo">(*)</span></label>
                                    <input type="email" class="form-control" name="email"
                                           value="{{ old('email', isset($account) ? data_get($account, 'email', '') : '') }}">
                                    @error('email')
                                    <div class="error"><p>{{$message}}</p></div>
                                    @enderror
                                </div>
                                {{--                                <div class="form-group">--}}
                                {{--                                    <label>Tên đăng nhập <span class="maudo">(*)</span></label>--}}
                                {{--                                    <input type="text" class="form-control" name="username">--}}
                                {{--                                     @error('name')--}}
                                {{--                                    <div class="error" id="password_error" style="color: red;"></div>--}}
                                {{--                                    @enderror--}}
                                {{--                                </div>--}}
                                @if(!$isUpdate)
                                    <div class="form-group">
                                        <label>Mật khẩu <span class="maudo">(*)</span></label>
                                        <input type="password" class="form-control" name="password"
                                               value="{{ old('password',isset($account) ? data_get($account, 'password', '') : '') }}"
                                               >
                                        @error('password')
                                        <div class="error"><p>{{$message}}</p></div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Số điện thoại <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="phone"
                                           value="{{ old('phone',isset($account) ? data_get($account, 'phone', '') : '') }}">
                                    @error('phone')
                                    <div class="error"><p>{{$message}}</p></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="address"
                                           value="{{ old('address', isset($account) ? data_get($account, 'address', '') : '') }}">
                                    @error('address')
                                    <div class="error"><p>{{$message}}</p></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quyền<span class="maudo">(*)</span></label>
                                    <select name="role_id" class="form-control">
                                        <option value="">[--Chọn danh mục--]</option>
                                        @foreach(config('constants.roles_name') as $index => $role)
                                            <option
                                                value="{{ $index }}" {{ $index == old('role_id', isset($account) ? data_get($account, 'role_id', '') : '') ? 'selected' : '' }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <input type="file" id="avatar" name="avatar" onchange="document.getElementById('post-image').src = window.URL.createObjectURL(this.files[0])">
                                    <label for="avatar">
                                        <img id="post-image" src="@if($isUpdate && !empty($account->avatar))
                                            {{ url('assets/upload/' . data_get($account, 'avatar')) }}
                                            @else
                                            {{ asset('assets/images/icon-upload.png') }}
                                        @endif"/>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                        @foreach(config('constants.account_status') as $index => $status)
                                            <option
                                                value="{{ $index }}" {{ $index == old('status', isset($account) ? data_get($account, 'status', '') : '') ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="error" id="password_error" style="color: red;"></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </form>
@endsection

