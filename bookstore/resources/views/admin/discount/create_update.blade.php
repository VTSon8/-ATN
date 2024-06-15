@extends("admin.layouts.app")

@php
    $isUpdate = isset($id) ? true : false;
    $route = isset($id) ? route('admin.discount.update', ['id' => $id]) : route('admin.discount.store');
@endphp

@section('page-title')
    <h1><i class="glyphicon glyphicon-cd"></i> Thêm mã giảm giá mới</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="javascript:void(0);"
           onclick="event.preventDefault();document.getElementById('coupon-form').submit();" role="button">
            <span class="glyphicon glyphicon-floppy-save"></span></span>{{ isset($id) ? 'Lưu[Thêm]' : 'Lưu[Cập nhật]' }}
        </a>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.discount.index') }}" role="button">
            <span class="glyphicon glyphicon-trash"></span> Thoát
        </a>
    </div>
@endsection

@section('content')
    <form action="{{ $route }}" method="POST" id="coupon-form">
        @csrf
        @if($isUpdate)
            @method('PUT')
        @endif
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box" id="view">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mã giảm giá</label>
                                    <input type="text" class="form-control" name="code" value="{{$isUpdate ? data_get($discount, 'code') : old('code')}}" style="width:100%"
                                           placeholder="Mã giảm giá">
                                    @error('code')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Số tiền giảm giá</label>
                                    <input type="number" class="form-control" name="discount" value="{{$isUpdate ? data_get($discount, 'discount') : old('discount')}}" style="width:100%"
                                           placeholder="Số tiền giảm giá">
                                    @error('discount')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Số lần giới hạn nhập</label>
                                    <input type="number" class="form-control" name="limit_number" value="{{$isUpdate ? data_get($discount, 'limit_number') : old('limit_number')}}" style="width:100%"
                                           placeholder="Số lần giới hạn nhập">
                                    @error('limit_number')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Số tiền đơn hàng tối thiểu được áp dụng</label>
                                    <input type="number" class="form-control" name="payment_limit" value="{{$isUpdate ? data_get($discount, 'payment_limit') : old('payment_limit')}}" style="width:100%"
                                           placeholder="Đơn hàng tối thiểu được áp dụng">
                                    @error('payment_limit')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if($isUpdate)
                                    <div class="form-group">
                                        <label>Số lần đã nhập</label>
                                        <input type="number" class="form-control" style="width:100%" value="{{data_get($discount, 'number_used')}}" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label>Số lần còn lại</label>
                                        <input type="text" class="form-control" style="width:100%" placeholder="Số lần giới hạn nhập" value="{{data_get($discount, 'limit_number') - data_get($discount, 'number_used')}}" disabled="">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày giới hạn nhập</label>
                                    <div class="form-group">
                                        <input type="date" name="expiration_date" value="{{$isUpdate ? data_get($discount, 'expiration_date') : old('expiration_date')}}" class="form-control" required>
                                    </div>
                                    @error('expiration_date')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Mô tả ngắn</label>
                                    <textarea name="description" class="form-control">{{$isUpdate ? data_get($discount, 'description') : old('description')}}</textarea>
                                    @error('description')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control" style="width:235px">
                                        <option value="1" {{ ($isUpdate && old('status', $discount->status) == 1) ? 'selected' : '' }}>Có hiệu lực</option>
                                        <option value="0" {{ ($isUpdate && old('status', $discount->status) == 0) ? 'selected' : '' }}>Không có hiệu lực</option>
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
    </form>
@endsection

