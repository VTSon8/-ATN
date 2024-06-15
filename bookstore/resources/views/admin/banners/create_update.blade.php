@extends("admin.layouts.app")

@php
    $isUpdate = isset($id) ? true : false;
    $routeSubmit = isset($id) ? route('admin.banners.update', $id) : route('admin.banners.store');
@endphp

@section('page-title')
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-picture"></i> {{ $isUpdate ? 'Sửa Banner' : 'Thêm Banner' }}</h1>
        <div class="breadcrumb">
            <button name="THEM_NEW" id="btn_slider" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-floppy-save"></span> Lưu[Thêm]
            </button>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.banners.index') }}" role="button">
                <span class="glyphicon glyphicon-remove"></span> Thoát
            </a>
        </div>
    </section>
@endsection

@section('content')
    <form action="{{ $routeSubmit }}" enctype="multipart/form-data" method="POST" accept-charset="utf-8"
          id="upload_slider">
        @csrf
        @if($isUpdate)
            @method('PUT')
        @endif
        <section class="content">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            @if(session()->has('msg'))
                                <div class="row">
                                    <div class="alert alert-error">
                                        {{ session()->get('msg') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-9">
                                <!--ND-->
                                <div class="form-group">
                                    <label>Tên sliders<span class="maudo">(*)</span></label>
                                    <input type="text" name="name" placeholder="Tên sliders" class="form-control"
                                           value="{{ isset($banner) ? data_get($banner, 'name') : '' }}">
                                    @error('name')
                                    <div class="error" id="password_error"></div>
                                    @enderror
                                </div>
                                <!--/.ND-->
                                <!--ND-->
                                <div class="form-group">
                                    <label>Mô tả<span class="maudo">(*)</span></label>
                                    <input type="text" name="description" placeholder="Mô tả sliders" class="form-control"
                                           value="{{ isset($banner) ? data_get($banner, 'description') : '' }}">
                                    @error('description')
                                    <div class="error" id="password_error"></div>
                                    @enderror
                                </div>
                                <!--/.ND-->
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hình ảnh <span class="maudo">(*)</span></label>
                                    <input type="file" name="thumb" id="banner-img"
                                           value="{{ isset($banner) ? data_get($banner, 'thumb') : '' }}"
                                           class="form-control"
                                           required
                                           onchange="document.getElementById('post-image').src = window.URL.createObjectURL(this.files[0])">
                                    <label for="banner-img">
                                        <img id="post-image" src="@if($isUpdate)
                                            {{ url('assets/upload/' . data_get($banner, 'thumb')) }}
                                            @else
                                            {{ asset('assets/images/icon-upload.png') }}
                                        @endif"/>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái </label>
                                    <select name="status" class="form-control">
                                        <option value="1"
                                                @if(isset($banner) && data_get($banner, 'status') == 1) selected @endif>
                                            Hoạt động
                                        </option>
                                        <option value="0"
                                                @if(isset($banner) && data_get($banner, 'status') == 0) selected @endif>
                                            Ngừng hoạt động
                                        </option>
                                        {{-- @if(isset($banner) && data_get($banner, 'status') == 1)
                                            <option value="1">Hoạt động</option>
                                        @else
                                            <option value="0">Ngừng hoạt động</option>
                                        @endif --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.row -->
        </section><!-- /.content -->
    </form>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '#btn_slider', function () {
                $('#upload_slider').submit();
            });
        });
    </script>
@endpush
