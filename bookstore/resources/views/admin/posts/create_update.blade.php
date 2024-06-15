@extends("admin.layouts.app")

@php
    $isUpdate = isset($id) ? true : false;
    $routeSubmit = isset($id) ? route('admin.posts.update', $id) : route('admin.posts.store');
@endphp

@section('page-title')
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-text-background"></i> Thêm bài viết mới</h1>
        <div class="breadcrumb">
            <button type="submit" id="btn_news" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-floppy-save"></span>
                {{ $isUpdate ? 'Lưu[Cập nhật]' : 'Lưu[Thêm]' }}
            </button>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.posts.index') }}" role="button">
                <span class="glyphicon glyphicon-remove do_nos"></span> Thoát
            </a>
        </div>
    </section>
@endsection

@section('content')
    <form action="{{ $routeSubmit }}" enctype="multipart/form-data" method="POST" accept-charset="utf-8"
          id="upload_news">
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
                                    <label>Tiêu đề bài viết</label>
                                    <input type="text" class="form-control" name="title"
                                           value="@if($isUpdate) {{ $post->title }} @endif" style="width:100%"
                                           placeholder="Tên bài viết">
                                    @error('title')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Mô tả ngắn</label>
                                    <textarea name="description" class="form-control">@if($isUpdate)
                                            {{ $post->description }}
                                        @endif</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Chi tiết bài viết</label>
                                    <textarea name="content" id="content" class="form-control" cols="20" rows="20">@if($isUpdate)
                                            {{ $post->content }}
                                        @endif</textarea>
                                    <script>CKEDITOR.replace('content', { height: 350,
                                            });</script>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hình đại diện</label>
                                    <input type="file" name="img" id="post-img" style="width: 100%"
                                           required
                                           onchange="document.getElementById('post-image').src = window.URL.createObjectURL(this.files[0])">
                                    <label for="post-img">
                                        <img id="post-image" src="@if($isUpdate)
                                            {{ url('assets/upload/' . data_get($post, 'img')) }}
                                            @else
                                            {{ asset('assets/images/icon-upload.png') }}
                                        @endif"/>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control" style="width:235px">
                                            <option value="1" {{ $isUpdate && $post->status == 1 ? 'selected' : ''}} selected>Đăng</option>
                                            <option value="0" {{ $isUpdate && $post->status == 0 ? 'selected' : ''}}>Chưa đăng</option>
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

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '#btn_news', function () {
                $('#upload_news').submit();
            });

            // imgInp.onchange = evt => {
            //     const [file] = imgInp.files
            //     if (file) {
            //         blah.src = URL.createObjectURL(file)
            //     }
            // }
        });
    </script>
@endpush
