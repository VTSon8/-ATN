@extends("admin.layouts.app")

@php
    $isUpdate = isset($id) ? true : false;
    $routeSubmit = isset($id) ? route('admin.products.update', $id) : route('admin.products.store');
@endphp

@section('page-title')
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-picture"></i> Thêm sản phẩm mới</h1>
        <div class="breadcrumb">
            <button class="btn btn-primary btn-sm"
                    onclick="event.preventDefault();document.getElementById('form-product').submit();">
                <span class="glyphicon glyphicon-floppy-save"></span> Lưu[Thêm]
            </button>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.products.index') }}" role="button">
                <span class="glyphicon glyphicon-remove"></span> Thoát
            </a>
        </div>
    </section>
@endsection

@section('content')
    <form action="{{ $routeSubmit }}" enctype="multipart/form-data" method="POST" accept-charset="utf-8"
          id="form-product">
        @csrf
        @if($isUpdate)
            @method('PUT')
        @endif
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box" id="view">
                        <div class="box-body">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Tên sản phẩm <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ $isUpdate ? data_get($data, 'name') : old('name') }}" required
                                           style="width:100%"
                                           placeholder="Tên sản phẩm...">
                                    @error('name')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6" style="padding-left: 0px;">
                                            <div class="form-group">
                                                <label>Loại sách<span class="maudo">(*)</span></label>
                                                <select name="category_id" class="form-control">
                                                    <option value="">[--Chọn loại sách--]</option>
                                                    @foreach($listCategory as $category)
                                                        <option
                                                            value="{{data_get($category, 'id')}}"
                                                            @if($isUpdate && ($category->id == $data->category_id)) selected @endif>{{data_get($category, 'name')}}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label>Nhà cung cấp <span class="maudo">(*)</span></label>
                                                <select name="supplier_id" class="form-control">
                                                    <option value="">[--Chọn nhà cung cấp--]</option>
                                                    @foreach($listSupplier as $supplier)
                                                        <option
                                                            value="{{data_get($supplier, 'id')}}"
                                                            @if($isUpdate && ($supplier->id == $data->supplier_id)) selected @endif>{{data_get($supplier, 'name')}}</option>
                                                    @endforeach
                                                </select>
                                                @error('supplier_id')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả ngắn <span class="maudo">(*)</span></label>
                                    <textarea name="description" class="form-control"
                                              required>{{ $isUpdate ? data_get($data, 'description') : old('description') }}</textarea>
                                    @error('description')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Chi tiết sản phẩm <span class="maudo">(*)</span></label>
                                    <textarea name="detail" id="detail"
                                              class="form-control">{{ $isUpdate ? data_get($data, 'detail') : old('detail') }}</textarea>
                                    <script>CKEDITOR.replace('detail');</script>
                                    @error('detail')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tác giả</label>
                                                <input type="text" class="form-control" name="author"
                                                       value="{{ $isUpdate ? data_get($data, 'author') : old('author', '') }}" required
                                                       style="width:100%">
                                                @error('author')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ngôn ngữ</label>
                                                <input type="text" class="form-control" name="lang"
                                                       value="{{ $isUpdate ? data_get($data, 'lang') : old('lang', '') }}" required
                                                       style="width:100%">
                                                @error('lang')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Người dịch</label>
                                                <input type="text" class="form-control" name="translator"
                                                       value="{{ $isUpdate ? data_get($data, 'translator') : old('translator', '') }}" required
                                                       style="width:100%">
                                                @error('translator')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tên nhà xuất bản</label>
                                                <input type="text" class="form-control" name="imprint"
                                                       value="{{ $isUpdate ? data_get($data, 'imprint') : old('imprint', '') }}" required
                                                       style="width:100%">
                                                @error('imprint')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Năm xuất bản</label>
                                                <input type="text" class="form-control" name="publishing_year"
                                                       value="{{ $isUpdate ? data_get($data, 'publishing_year') : old('publishing_year', '') }}" required
                                                       style="width:100%">
                                                @error('publishing_year')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Trọng lượng</label>
                                                <input type="number" class="form-control" name="weight"
                                                       value="{{ $isUpdate ? data_get($data, 'weight') : old('weight', '') }}"
                                                       style="width:100%">
                                                @error('weight')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Kích Thước Bao Bì</label>
                                                <input type="text" class="form-control" name="size"
                                                       value="{{ $isUpdate ? data_get($data, 'size') : old('size', '') }}"
                                                       style="width:100%">
                                                @error('size')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số trang</label>
                                                <input type="number" class="form-control" name="number_of_pages"
                                                       value="{{ $isUpdate ? data_get($data, 'number_of_pages') : old('number_of_pages', '') }}" required
                                                       style="width:100%">
                                                @error('number_of_pages')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hình thức</label>
                                                <select name="form" class="form-control">
                                                    <option value="0">Bìa mềm</option>
                                                    <option value="1">Bìa cứng</option>
                                                </select>
                                                @error('number_of_pages')
                                                <div class="error">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="images-section" class="images-section">
                                    @if($isUpdate)
                                        @php
                                            $images = explode('#', data_get($data, 'source_url'));
                                        @endphp
                                        @if($data->images->isNotEmpty())
                                            @foreach(data_get($data, 'images', []) as $image)
                                                <img src="{{ url('assets/upload/' . data_get($image, 'name')) }}"
                                                     alt="thumb">
                                            @endforeach
                                        @else
                                        @empty($images)
                                            @foreach ($images as $image)
                                                <img src="{{ url('assets/upload/' . $image) }}" alt="thumb">
                                            @endforeach
                                        @endempty
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Giá gốc <span class="maudo">(*)</span></label>
                                    <input name="original_price" class="form-control" type="number" id="original_price"
                                           value="{{ $isUpdate ? data_get($data, 'original_price') : old('original_price', '') }}" min="0"
                                           step="1" max="1000000000">
                                    @error('original_price')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Khuyến mãi (%)</label>
                                    <input name="sale" class="form-control" type="number"
                                           value="{{ $isUpdate ? data_get($data, 'sale') : old('sale', '') }}">
                                    @error('sale')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Giá bán <span class="maudo">(*)</span></label>
                                    <input name="selling_price" class="form-control" type="number"
                                           value="{{ $isUpdate ? data_get($data, 'selling_price') : old('selling_price', '') }}" min="0"
                                           step="1" max="1000000000">
                                    @error('selling_price')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    @if($isUpdate)
                                        <label>Số lượng tồn kho</label>
                                        <input class="form-control" type="number"
                                               value="{{ $isUpdate ? data_get($data, 'number') : old('number', '') }}" min="1"
                                               step="1"
                                               max="1000" disabled>
                                    @else
                                        <label>Số lượng <span class="maudo">(*)</span></label>
                                        <input name="number" class="form-control" type="number" value="1" min="1"
                                               step="1"
                                               max="1000">
                                        @error('number')
                                        <div class="error">{{$message}}</div>
                                        @enderror
                                    @endif
                                </div>
                                @if($isUpdate)
                                    <div class="form-group">
                                        <label>Số lượng đã bán</label>
                                        <input class="form-control" type="number"
                                               value="{{ data_get($data,'number_buy') }}" disabled>
                                    </div>
                                @endif
                                {{--                                @if(!$isUpdate)--}}
                                <div class="form-group">
                                    <label>Hình đại diện <span class="maudo">(*)</span></label>
                                    <input type="file" id="thumb" name="thumb" required
                                           onchange="document.getElementById('post-image').src = window.URL.createObjectURL(this.files[0])"
                                           style="width: 100%">
                                    @error('thumb')
                                    <div class="error">{{$message}}</div>
                                    @enderror

                                    <label for="thumb">
                                        <img id="post-image" src="@if($isUpdate)
                                            {{ url('assets/upload/' . data_get($data, 'thumb')) }}
                                            @else
                                            {{ asset('assets/images/icon-upload.png') }}
                                        @endif"/>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>Hình ảnh sản phẩm </label>
                                    <input type="file" id="images" name="images[]" multiple onchange="loadFiles(this)"
                                           accept="image/*" required>
                                    @error('images')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái <span class="maudo">(*)</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">Kinh doanh</option>
                                        <option value="0">Chưa Kinh doanh</option>
                                    </select>
                                    @error('status')
                                    <div class="error">{{$message}}</div>
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
        <!-- /.content -->
    </form>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '#btn_slider', function () {
                $('#upload_slider').submit();
            });
        });

        function loadFiles(event) {
            let imagesSection = document.getElementById("images-section");
            imagesSection.innerHTML = '';
            for (let i = 0; i < event.files.length; i++) {
                let image = new Image();
                image.src = URL.createObjectURL(event.files[i]);

                imagesSection.innerHTML +=
                    "<img src=\"" + image.src + "\">"
                //console.log(event.files[i]);
            }
        };
    </script>
@endpush



