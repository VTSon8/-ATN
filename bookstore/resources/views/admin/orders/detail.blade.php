@extends("admin.layouts.app")

@push('css')
    <style>
        @media print {
            .print-order, .main-footer {
                display: none;
            }
        }

    </style>
@endpush

@section('page-title')
    <h1><i class="glyphicon glyphicon-shopping-cart"></i> Chi tiết đơn hàng</h1>
    <div class="breadcrumb">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.orders.index') }}" role="button">
            <span class="glyphicon glyphicon-remove do_nos"></span> Thoát
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
                        <div id="view">
                            <h1 class="text-center" style="color: red;">CHI TIẾT ĐƠN HÀNG</h1>
                            <h4>Tên khách hàng: <b>{{ data_get($order, 'name') }}</b></h4>
                            <h4>Điện thoại: {{ data_get($order, 'phone') }}</h4>
                            <h4>Thời gian đặt
                                hàng: {{ date('d-m-Y H:i:m', strtotime(data_get($order, 'created_at'))) }}</h4>
                            <h4>Địa
                                chỉ: {{ data_get($order, 'address') . ', ' . data_get($order, 'ward.prefix', '') . ' ' . data_get($order, 'ward.name') . ', ' . data_get($order, 'district.prefix', '') . ' ' . data_get($order, 'district.name') . ', ' . data_get($order, 'province.name') }}
                            </h4>
                            <h4>Mã đơn hàng: <b>{{ data_get($order, 'code') }}</b></h4>
                            <br/>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th>Tên sản phẩm</th>
                                        <th class="text-center" style="width:100px">Số lượng</th>
                                        <th style="width:120px">Giá bán</th>
                                        <th class="text-right" style="width:120px">Thành tiền</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total_price = 0;
                                    @endphp
                                    @foreach(data_get($order, 'products') as $index => $product)
                                        <tr>
                                            <td class="text-center">{{ $index }}</td>
                                            <td>{{ data_get($product, 'name') }}</td>
                                            <td class="text-center">{{ data_get($product, 'quantity') }}</td>
                                            <td>{{ number_format(data_get($product, 'selling_price')) }} ₫</td>
                                            @php
                                                $total_price += data_get($product, 'price');
                                            @endphp
                                            <td class="text-right">
                                                {{ number_format(data_get($product, 'price')) }} ₫
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" style="border: none;"></td>
                                        <td colspan="1" class="text-left"
                                            style="border: none;">Tổng cộng:
                                        </td>
                                        <td colspan="1" class="text-right"
                                            style="border: none;"> {{ number_format($total_price) }}₫
                                        </td>
                                    </tr>
                                    @if(data_get($order, 'discount'))
                                        <tr>
                                            <td colspan="3" style="border: none;"></td>
                                            <td colspan="1" class="text-left"
                                                style="border: none; font-size: 1.1em;">Voucher:
                                            </td>
                                            <td colspan="1" class="text-right"
                                                style="border: none; font-size: 1.1em;">
                                                -{{ number_format(data_get($order, 'discount')) }} ₫
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" style="border: none;"></td>
                                        <td colspan="1" class="text-left"
                                            style="border: none;">Phí vận chuyển:
                                        </td>
                                        <td colspan="1" class="text-right"
                                            style="border: none;">
                                            {{ number_format(data_get($order, 'price_ship')) }} ₫
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-right"
                                            style="border: none; color: red; font-size: 1.3em;">Thành
                                            tiền: {{ number_format(data_get($order, 'price')) }}₫
                                        </td>
                                    </tr>
                                    <tr class="print-order">
                                        <td class="text-right" colspan="6">
                                            <a class="btn btn-primary btn-md" role="button"
                                               onclick="window.print()">
                                                <span class="glyphicon glyphicon-print"></span> In đơn hàng
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/.ND-->
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection


