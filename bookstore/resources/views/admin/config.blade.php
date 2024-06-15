@extends("admin.layouts.app")

@push('css')
    <style>
        .form-group {
            margin-bottom: 0 !important;
        }
    </style>
@endpush

@section('page-title')
    <h1><i class="glyphicon glyphicon-text-background"></i> Hệ Thống</h1>
    <div class="breadcrumb">
        <button type="submit" onclick="event.preventDefault();document.getElementById('config').submit();"
                class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-floppy-save"></span>
            Lưu
        </button>
    </div>
@endsection

@section('content')
    <form action="{{ route('admin.config.store') }}" enctype="multipart/form-data" method="POST" accept-charset="utf-8"
          id="config">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box" id="view">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Vị trí cửa hàng <span class="maudo">(*)</span></label>
                                    <input type="email" class="form-control" name="name" id="to"
                                           value="{{!empty($config->name) ? $config->name : ''}}" style="width:100%"
                                           placeholder="Điền vị trí cửa hàng ...">
                                </div>
                                <div class="form-group">
                                    <label> Kinh độ <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="longitude" id="long_to" readonly
                                           value="{{!empty($config->longitude) ? $config->longitude : ''}}"
                                           style="width:100%"
                                           placeholder="Kinh độ">
                                </div>
                                <div class="form-group">
                                    <label> Vĩ độ <span class="maudo">(*)</span></label>
                                    <input type="text" class="form-control" name="latitude" id="lat_to" readonly
                                           value="{{!empty($config->latitude) ? $config->latitude : ''}}"
                                           style="width:100%"
                                           placeholder="Vĩ độ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> Bảng giá vận chuyển theo khoảng cách (km)</label>
                                <div class="table-responsive">
                                    <fieldset>
                                        <table class="table table-bordered tb-detail-or" id="table-km">
                                            <thead>
                                            <tr class="">
                                                <th>Khoảng cách Km</th>
                                                <th>Giá vận chuyển</th>
                                                <th colspan="2">Thao tác</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $i = 0; @endphp
                                            @if(!empty($config->km_prices))
                                                @foreach($config->km_prices as $index => $value)
                                                    @php $i++; @endphp
                                                    <tr data-id="{{$i}}" id="price_ship-{{$i}}" style="height: 50px;"
                                                        class="review-sp">
                                                        <td>
                                                            <div style="width: 100%; height: 100%">
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input type="text" name="km_prices[{{$i}}][km]"
                                                                               class="form-control"
                                                                               value="{{$value['km']}}"
                                                                               placeholder="Nhập khoảng cách tính bằng km ...">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="km_prices[{{$i}}][price_ship]"
                                                                   class="form-control" value="{{$value['price_ship']}}"
                                                                   placeholder="Nhập giá vận chuyển ...">
                                                        </td>
                                                        <td><i class="fa fa-pencil" aria-hidden="true"></i></td>
                                                        <td><a href="javascript:void(0);"
                                                               onclick="removeForm({{$i}})"><i class="fa fa-trash"
                                                                                               aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr data-id="0" id="price_ship-0" style="height: 50px;" class="review-sp">
                                                <td>
                                                    <div style="width: 100%; height: 100%">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input type="text" name="km_prices[0][km]"
                                                                       class="form-control"
                                                                       placeholder="Nhập khoảng cách tính bằng km ...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="km_prices[0][price_ship]"
                                                           class="form-control"
                                                           placeholder="Nhập giá vận chuyển ...">
                                                </td>
                                                <td><i class="fa fa-pencil" aria-hidden="true"></i></td>
                                                <td><a href="javascript:void(0);" onclick="removeForm(0)"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div style="margin-left: 8px;">
                                            <a href="javascript:void(0);" onclick="addForm()"
                                               class="btn btn-sm btn-primary pull-left"><i
                                                    class="icon-plus icon-label"></i>{{ __('Thêm') }}</a>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
            </div>
        </section>
    </form>
@endsection

@push('js')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3GG7Qq1XgRMAcjPejT9spgnR4RZ9xzbU&libraries=places">
    </script>
    <script>
        $(document).ready(function () {
            toastr.options.timeOut = 10000;
            @if ($errors->any())
            toastr.warning('{{ $errors->first() }}');
            @endif
        });

        function addForm() {
            let lastRow = $('#table-km tbody tr').length;
            console.log(lastRow);
            const id = parseInt(lastRow);
            $('#table-km').append(
                `<tr data-id="${id}" id="price_ship-${id}" style="height: 50px;" class="review-sp">
                                    <td>
                                        <div style="width: 100%; height: 100%">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="text" name="km_prices[${id}][km]" class="form-control"
                                                           placeholder="Nhập khoảng cách tính bằng km ...">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="km_prices[${id}][price_ship]" class="form-control"
                                               placeholder="Nhập giá vận chuyển ...">
                                    </td>
                                    <td><i class="fa fa-pencil" aria-hidden="true"></i></td>
                                    <td><a href="javascript:void(0);" onclick="removeForm('${id}')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                </tr>`
            );
        }

        function removeForm(id) {
            $('#price_ship-' + id).remove();
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            var autocomplete_to, autocomplete_from;
            var to = 'to', from = 'from';

            //start for to google autocomplete with lat and long
            autocomplete_to = new google.maps.places.Autocomplete((document.getElementById(to)), {
                types: ['geocode'],
            })
            google.maps.event.addListener(autocomplete_to, 'place_changed', function () {

                var place = autocomplete_to.getPlace();
                jQuery("#lat_to").val(place.geometry.location.lat());
                jQuery("#long_to").val(place.geometry.location.lng());

            })
        });
    </script>
@endpush

