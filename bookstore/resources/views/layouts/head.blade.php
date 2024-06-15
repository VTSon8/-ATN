<head>
    <meta charset="utf-8"/>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/><![endif]-->
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0' name='viewport'/>
    <meta name="revisit-after" content="1 day"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="HandheldFriendly" content="true">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="//theme.hstatic.net/200000845405/1001223012/14/favicon.png?v=17" type="image/png"/>
    <title>
        Vinabook - Hiệu s&#225;ch online trực tuyến cho mọi người
    </title>
    <meta name="description"
          content="Hiệu sách online hiện đại và kho sách ebook online tiện lợi, Vinabook là nơi giúp bạn có những cuốn sách đúng với sở thích và cập nhật những đầu sách hay nhất"/>
    <meta name="keywords" content="Vinabook">
    <meta name="robots" content="index,follow,noodp">
    <meta http-equiv="default-style" content="on">
    <meta name="theme-color" content="#ec8000">

    <!--+++++++++++++++++++++++++ CSS ++++++++++++++++++++++++-->

    <link rel="preload" as="image" href="{{ asset('assets/frontend/images/home_slider_image_1.webp') }}"
          media="screen and (max-width: 768px)">
    <link rel="preload" as="image" href="{{ asset('assets/frontend/images/home_slider_image_2.webp') }}"
          media="screen and (max-width: 768px)">
    <link rel="preload" as="image" href="{{ asset('assets/frontend/images/home_slider_image_3.webp') }}"
          media="screen and (max-width: 768px)">
    <link rel="preload" as="image" href="{{ asset('assets/frontend/images/home_slider_image_4.webp') }}"
          media="screen and (min-width: 768px)">
    <link href='{{ asset('assets/frontend/css/plugin-min.css') }}' rel='stylesheet' type='text/css'
          media='all'/>
    <link href='{{ asset('assets/frontend/css/custom-styles.scss.css') }}' rel='stylesheet'
          type='text/css' media='all'/>
    @stack('css')
    <!--+++++++++++++++++++++++++ JS ++++++++++++++++++++++++-->
    <script src='{{ asset('assets/frontend/js/jquery.min.js') }}' type='text/javascript'></script>

    <!--+++++++++++++++++++++++++ JS ++++++++++++++++++++++++-->
    <script>
        var template = 'index';
        var formatMoney = '{{isset($amount) ? 1000 : 0}}₫';
        jQuery.themeAssets = {
            arrowDown: '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 8" style="enable-background:new 0 0 12 8; width: 12px; height: 8px;" xml:space="preserve"><polyline points="0,2 2,0 6,4 10,0 12,2 6,8 0,2 "/></svg>',
            arrowRight: '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31 10" style="enable-background:new 0 0 31 10; width: 31px; height: 10px;" xml:space="preserve"><polygon points="31,5 25,0 25,4 0,4 0,6 25,6 25,10 "/></svg>',
        };
        jQuery.themeCartSettings = 'overlay';
    </script>

    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Vinabook - Hiệu s&#225;ch online trực tuyến cho mọi người"/>
    <meta property="og:description"
          content="Hiệu sách online hiện đại và kho sách ebook online tiện lợi, Vinabook là nơi giúp bạn có những cuốn sách đúng với sở thích và cập nhật những đầu sách hay nhất"/>
    <meta property="og:site_name" content="Vinabook"/>


    <!-- SEO META DESCRIPTION -->
    <meta name="description"
          content="Hiệu sách online hiện đại và kho sách ebook online tiện lợi, Vinabook là nơi giúp bạn có những cuốn sách đúng với sở thích và cập nhật những đầu sách hay nhất"/>
    <!-- END SEO META DESCRIPTION -->
    <!-- SEO PAGI -->
    <!-- END SEO PAGI -->
{{--    <script defer src='{{ asset('assets/frontend/js/beacon.min.js') }}' hrv-beacon-t='200000845405'></script>--}}
    <style>.grecaptcha-badge {
            visibility: hidden;
        }</style>

    <script>
        window.file_url = "//file.hstatic.net/200000845405/file/";
        window.asset_url = "//theme.hstatic.net/200000845405/1001223012/14/?v=17";
        var check_variant = true;
        var check_variant_quickview = true;
    </script>

</head>
