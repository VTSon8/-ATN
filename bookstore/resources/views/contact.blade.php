@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="col-md-7 col-12">
                <div class="section-article contactpage" style="  padding-left: 20px;">
                    <form action="{{ route('send_the_contact') }}" id="contact" method="POST" accept-charset="UTF-8">
                        @csrf
                        <input name="FormType" type="hidden" value="contact">
                        <input name="utf8" type="hidden" value="true">
                        <h1 style="color: black">Liên hệ với chúng tôi</h1>

                        <div class="form-comment">
                            <div class="row" style="padding-left: 14px;">
                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="width: 200px;">
                                        <label for="name"><em> Họ tên</em><span class="required">*</span></label>
                                        <input id="name" name="name" type="text" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="width: 200px;">
                                        <label for="email"><em> Email</em><span class="required">*</span></label>
                                        <input id="email" name="email" class="form-control" type="email" value=""
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="width: 200px;">
                                        <label for="phone"><em> Số điện thoại</em><span
                                                class="required">*</span></label>
                                        <input type="number" id="phone" class="form-control" name="phone" required>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message"><em> Tiêu đề</em><span class="required">*</span></label>
                                <textarea id="message" name="title" class="form-control custom-control" rows="2"
                                          required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message"><em> Lời nhắn</em><span class="required">*</span></label>
                                <textarea id="message" name="content" class="form-control custom-control"
                                          rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn-update-order">Gửi nhận xét</button>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="f-contact" style="
			padding-left: 32px;
			">
                    <h1 style="color: black">Thông tin liên hệ</h1>
                    <ul class="list-unstyled">
                        <li class="clearfix">
                            <i class="fa fa-map-marker fa-1x" style="color:#0f9ed8; padding: 20px; "></i>
                            <span style="color: black">Số 7, Ngõ 92 Đường Nguyễn Khánh Toàn, <span
                                    style="margin-left: 54px">Cầu Giấy, Hà Nội</span></span>
                        </li>
                        <li class="clearfix">
                            <i class="fa fa-phone fa-1x" style="color:#0f9ed8;padding: 20px;  "></i>
                            <span style="color: black">08.335588 - 0981.33557</span>
                        </li>
                        <li class="clearfix">
                            <i class="fa fa-envelope fa-1x " style="color:#0f9ed8; padding: 20px; "></i>
                            <span style="color: black"><a
                                    href="mailto:sale.24hstore@gmail.com">sale.shopgrids@gmail.com</a></span>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-12 col-lg-12 col-xs-12 col-12">

                <div style="margin-top: 15px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8712206627188!2d105.79978411121135!3d21.037838180532923!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab3f0726ef0b%3A0x7d39c2d93f24152d!2zNyBOZy4gOTIgxJAuIE5ndXnhu4VuIEtow6FuaCBUb8OgbiwgUXVhbiBIb2EsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1694250677219!5m2!1svi!2s"
                        width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            toastr.options.timeOut = 10000;
            @if (session('status'))
            toastr.info('{{ session('status') }}', 'Thông báo');
            @endif

                @if ($errors->any())
                toastr.options.positionClass = 'custom-toast';
            toastr.warning('{{ $errors->first() }}');
            @endif
        });
    </script>
@endpush


