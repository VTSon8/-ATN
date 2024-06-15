@extends("admin.layouts.app")

@php
    $isUpdate = isset($id) ? true : false;
    $routeSubmit = isset($id) ? route('admin.category.update', $id) : route('admin.category.store');
@endphp

@section('page-title')
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-picture"></i> {{$isUpdate ? 'Cập nhật lại sản phẩm' : 'Thêm danh mục mới'}}
        </h1>
        <div class="breadcrumb">
            <button id="btn_category" onclick="event.preventDefault();document.getElementById('category').submit();"
                    class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-floppy-save"></span> Lưu[{{$isUpdate ? 'Cập nhật' : 'Thêm'}}]
            </button>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.category.index') }}" role="button">
                <span class="glyphicon glyphicon-remove"></span> Thoát
            </a>
        </div>
    </section>
@endsection

@section('content')
    <form action="{{ $routeSubmit }}" enctype="multipart/form-data" method="POST" accept-charset="utf-8"
          id="category">
        @csrf
        @if($isUpdate)
            @method('PUT')
        @endif
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box" id="view">
                        <div class="box-body">
                            <div class="form-group">
                                <label>{{ __('common.category.category_name') }} <span class="maudo">(*)</span></label>
                                <input type="text" class="form-control" name="name" style="width:50%"
                                       value="{{isset($data) ? data_get($data, 'name') : ''}}"
                                       placeholder="Tên danh mục">
                                @error('name')
                                <div class="error">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('common.category.parent') }}</label>
                                <select name="parent_id" class="form-control" style="width:50%">
                                    <option value="">[--Chọn danh mục--]</option>
                                    @foreach($listCategory as $value)
                                        <option value="{{data_get($value, 'id')}}"
                                                @if(isset($data['id']) && ($data['parent_id']  == data_get($value, 'id') )) selected @endif>{{data_get($value, 'name')}}</option>
                                    @endforeach
                                </select>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label>{{ __('common.category.sort') }}</label>--}}
{{--                                <select name="orders" class="form-control" style="width:50%">--}}
{{--                                    <option value="">[--Chọn vị trí--]</option>--}}
{{--                                    <option value="0">Đứng đầu</option>--}}

{{--                                </select>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label>{{ __('common.category.status') }}</label>
                                <select name="status" class="form-control" style="width:50%">
                                    <option value="">[--Chọn trạng thái--]</option>
                                    <option
                                        value="{{ config('constants.CATEGORY_STATUS.PROGRESS') }}"
                                        @if(isset($data['id']) && ($data['status']  == 1 )) selected @endif>{{ __('common.category.progress') }}</option>
                                    <option
                                        value="{{ config('constants.CATEGORY_STATUS.STOP') }}"
                                        @if(isset($data['id']) && ($data['status']  == 0 )) selected @endif>{{ __('common.category.stop') }}</option>
                                </select>
                                @error('status')
                                <div class="error">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        </div>
                    </div><!-- /.box -->
                </div>
        </section>
        <!-- /.content -->
    </form>
@endsection

@push('js')

@endpush




