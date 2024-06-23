@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-12 col-lg-9">
                <section>
                    <div class="container">
                        <div class="col-md-7 col-12">
                            <div class="section-article contactpage" style="  padding-left: 20px;">
                                <form action="{{ route('send_the_contact') }}" id="contact" method="POST" accept-charset="UTF-8">
                                    @csrf
                                    <h1 style="color: black">Liên hệ với chúng tôi</h1>
                                    <div class="form-comment">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="width: 200px;">
                                                    <label for="name"><em> Họ tên</em><span class="required">*</span></label>
                                                    <input id="name" name="name" type="text" value="" class="form-control" required>
                                                </div>
                                                @error('name')
                                                <span style="color: red">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <div class="form-group" style="width: 200px;">
                                                    <label for="email"><em> Email</em><span class="required">*</span></label>
                                                    <input id="email" name="email" class="form-control" type="email" value=""
                                                           required>
                                                </div>
                                                @error('email')
                                                <span style="color: red">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <div class="form-group" style="width: 200px;">
                                                    <label for="phone"><em> Số điện thoại</em><span
                                                            class="required">*</span></label>
                                                    <input type="number" id="phone" class="form-control" name="phone" required>
                                                </div>
                                                @error('phone')
                                                <span style="color: red">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="message"><em> Tiêu đề</em><span class="required">*</span></label>
                                            <textarea id="message" name="title" class="form-control custom-control" rows="2"
                                                      required></textarea>
                                            @error('title')
                                            <span style="color: red">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="message"><em> Lời nhắn</em><span class="required">*</span></label>
                                            <textarea id="message" name="content" class="form-control custom-control"
                                                      rows="5"></textarea>
                                            @error('content')
                                            <span style="color: red">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn-update-order" style="padding: 12px 24px;border: 1px solid #ccc;outline: none">Gửi nhận xét</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
            <div class="col-12 col-lg-3">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
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


