<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Books Store')</title>
    <link rel="icon" type="image/x-icon" href="{{  asset("assets/images/iconu.png") }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta property="fb:app_id" content="659513967881060">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("assets/css/fontawesome.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/font-awesome470.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset("assets/css/ionicons.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("assets/css/AdminLTE.css") }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset("assets/css/_all-skins.min.css") }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset("assets/css/toastr.min.css") }}">
    @stack('css')

    <script src="{{ asset("assets/js/loader.js") }}"></script>
    <script src="{{ asset("assets/ckeditor/ckeditor.js") }}"></script>
    <style>
        .content-header h1, th, label {
            color: #333;
        }

        label {
            font-weight: 600 !important;
        }

        .maudo {
            color: red
        }

        .mauxanh18 {
            color: green;
        }

        .table-hover>tbody>tr:hover {
            background-color: #f5f5f5 !important;
        }

        .btn-status {
            border: none;
            outline: none;
            background-color: #fff;
        }

        .table-hover>tbody>tr:hover .btn-status {
            background-color: #f5f5f5 !important;
        }

        #post-image {
            margin-top: 12px;
            min-width: 130px;
            max-width: 310px;
            height: 130px;
            object-fit: cover;
            /*object-fit: contain;*/
        }

        #images-section img {
            margin-top: 12px;
            margin-right: 4px;
            min-width: 100px;
            max-width: 130px;
            height: 130px;
            object-fit: contain;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @if(empty($disableHeaderAndFooter))
        @include('admin.common.header')
    @endif

    @if(empty($disableHeaderAndMenu))
        @include('admin.common.menu')
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            @yield('page-title')
        </section>
        <!-- content -->
        @yield('content')
    </div>

    @if(empty($disableHeaderAndFooter))
        @include('admin.common.footer')
    @endif

</div>
<!-- jQuery 2.2.3 -->
{{-- <script src="{{ asset("assets/js/jquery-2.2.3.min.js") }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.js"
        integrity="sha512-xTUUixz5iuBWnqBiM+zHpfoyU6gDpElnKG/QcA1SxLvy/jtfXEBjMKvKASxQdp/empqfJFWczQ2S9cotlKXT7g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset("assets/js/bootstrap.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("assets/js/app.min.js") }}"></script>
<script src="{{ asset("assets/js/toastr.min.js") }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@stack('js')
</body>
</html>
