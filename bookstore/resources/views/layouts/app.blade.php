<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.head')

@push('css')
    <style>
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto !important;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 780px;
            transform: translatey(-30px);
            transition: all .5s;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            right: 0;
            top: 0;
            width: 40px;
            text-align: center;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
@endpush

<body id="hogwarts-theme" class="index" style="background: #f9f5ee">

<nav id="menu-mobile" class="hidden">
    @include('menu-mobile')
</nav>

<div class="main-body ">
    <div class="topbar">
        @include('layouts.topbar')
    </div>

    <header id="header">
        @include('layouts.header')
    </header>

    <h1 class="hidden entry-title">book</h1>

    @yield('content')

    <footer class="footer">
        @include('layouts.footer')
    </footer>

    <div id="site-overlay" class="site-overlay"></div>
</div>

<div class="overlay-filter"></div>

@include('modal.product_quick_view')

<div id="modalAddComplete">
    <div class="modalAddComplete-content show">
        <span id="modalAddComplete-close" class="modalAddComplete-close"><i class="fa fa-times" aria-hidden="true"></i></span>
        <div class="modalAddComplete-body">
        </div>
    </div>
</div>

<button type="button" id="modalAddCompleteBtn" style="display: none;"></button>

@include('layouts.social-network')

<script src="{{ asset('assets/frontend/js/plugins.js') }}" defer></script>
<script src="{{ asset('assets/frontend/js/scripts.js') }}" defer></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    setTimeout(function () {
        animation_check();
    }, 100);

    function animation_check() {
        var scrollTop = $(window).scrollTop() - 300;
        $('.animation-tran').each(function () {
            if ($(this).offset().top < scrollTop + $(window).height()) {
                $(this).addClass('active');
            }
        })
    }

    $(window).scroll(function () {
        animation_check();
    })

    function tab_custom(link, content) {
        $(link).on('click', function () {
            var id = $(this).data('id');
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $(content + '[data-id=' + id + ']').siblings().removeClass('active');
            $(content + '[data-id=' + id + ']').addClass('active');
        });
    }

    if ($('.htp-tablink').length) {
        tab_custom('.htp-tablink', '.htp-tabcontent');
    }

</script>
<script>
    $(function () {
        $('nav#menu-mobile').mmenu({
            offCanvas: {
                position: "right"
            }
        });
    });
    $(document).ready(function () {
        flagg = true;
        if (flagg) {
            $('.header-action_menu a').click(function (e) {
                e.preventDefault();
                $('#menu-mobile').removeClass('hidden');
                flagg = false;
            })
        }

        var offset = 220;
        var duration = 500;
        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('#back-to-top').fadeIn(duration);
            } else {
                jQuery('#back-to-top').fadeOut(duration);
            }
        });

        jQuery('#back-to-top').click(function (event) {
            event.preventDefault();
            jQuery('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        });
    });
</script>
<!-- popup loaded -->
<script>
    $(document).ready(function () {
        if ($(window).width() < 768) {
            $('.title-block-mb').click(function () {
                $(this).toggleClass('active');
                $(this).next().stop().slideToggle();
            });
        }
        var date = new Date();
        var minutes = 60;
        date.setTime(date.getTime() + (minutes * 60 * 1000));

        if (getCookie('popupNewLetterStatus') != 'closed') {
            $('#popup-btn').trigger('click');
            setCookie('popupNewLetterStatus', 'closed', date);
        }
        ;
    })

    // Get the modal
    var modalAddComplete = document.getElementById('modalAddComplete');

    // Get the button that opens the modal
    var modalAddCompleteBtn = document.getElementById("modalAddCompleteBtn");

    // When the user clicks the button, open the modal
    modalAddCompleteBtn.onclick = function () {
        modalAddComplete.style.display = "block";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modalAddComplete) {
            modalAddComplete.style.display = "none";
        }
    }
</script>
@stack('js')
</body>
</html>
