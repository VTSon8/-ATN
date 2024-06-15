@extends("admin.layouts.app")

@section('page-title')
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-text-background"></i> Nhập hàng</h1>
        <div class="breadcrumb">
            <button class="btn btn-primary btn-sm"
                    onclick="event.preventDefault();document.getElementById('form-product').submit();">
                <span class="glyphicon glyphicon-floppy-save"></span> Lưu[Cập nhật]
            </button>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.products.index') }}" role="button">
                <span class="glyphicon glyphicon-remove"></span> Thoát
            </a>
        </div>
    </section>
@endsection

@section('content')
    <form action="{{ route('admin.products.update_quantity', $product->id) }}" enctype="multipart/form-data"
          method="POST" accept-charset="utf-8"
          id="form-product">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box" id="view">
                        <div class="box-body">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Tên sản phẩm </label>
                                    <input type="text" class="form-control" disabled style="width:100%"
                                           placeholder="Tên sản phẩm" value="{{ data_get($product, 'name') }}">
                                </div>
                                <div class="form-group">
                                    <label>Loại sách</label>
                                    <select class="form-control" style="width:300px" disabled>
                                        <option value="{{ data_get($product, 'category_id') }}"
                                                selected>{{ data_get($product, 'category.name') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tổng số lượng đã nhập</label>
                                    <input type="number" class="form-control" placeholder="Số lượng" min="0" max="10000"
                                           value="{{ data_get($product, 'number') }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Số lượng sản phẩm đã bán</label>
                                    <input type="number" class="form-control" placeholder="Số lượng" min="0" max="10000"
                                           value="{{ data_get($product, 'number_buy') }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Số lượng còn của cửa hàng</label>
                                    <input type="number" class="form-control" placeholder="Số lượng" min="0"
                                           max="10000"
                                           value="{{ data_get($product, 'number') - data_get($product, 'number_buy') }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nhập số lượng nhập thêm<span class="maudo">(*)</span></label>
                                    <input type="number" class="form-control" name="number"
                                           style="width:100%" placeholder="Số lượng" min="0" max="10000">
                                    @error('number')
                                    <div class="error" id="password_error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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



