<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.head')

<body id="hogwarts-theme" class="index" style="background: #f9f5ee">

<div class="nav-overlay" onclick="initNav('close')"></div>

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

    <h1 class="hidden entry-title">Vinabook</h1>

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

{{--<script src='{{ asset('assets/frontend/js/api.jquery.js') }}' type='text/javascript'></script>--}}
{{--<script src='{{ asset('assets/frontend/js/option_selection.js') }}' type='text/javascript'></script>--}}
<script src="{{ asset('assets/frontend/js/plugins.js') }}" defer></script>
<script src="{{ asset('assets/frontend/js/scripts.js') }}" defer></script>
<script>
    const VND = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function formatCurrency(amount) {
        const formatted = VND.format(amount);
        const formattedWithoutD = formatted.replace(/đ|₫/g, 'đ').replace(/\./g, ',');
        return formattedWithoutD;
    }
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
//setTimeout(function(){
        animation_check();
//}, 500);
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
</script>
<!-- quick view -->
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
<script>
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
<script>
    $('#AddToCardQuickView').on('click', function (e) {
        e.preventDefault();
        console.log(jQuery('#form-quick-view').serialize());
        console.log('vao')
        updateCart();
        updateCartModal();
        jQuery.ajax({
            type: 'POST',
            url: '/cart/add.js',
            async: false,
            data: {quantity: $('#quantity_qv').val(), id: $('#p-select-quickview').val()},
            dataType: 'json',
            success: function () {
                $(".close").trigger('click');
                updateCart();
                updateCartModal();
            },
            error: function (XMLHttpRequest, textStatus) {
                Haravan.onError(XMLHttpRequest, textStatus);
            }
        });
    });
    var callBack = function (variant, selector) {
        if (variant) {
            modal = $('#productQuickView');
            $('.p-price').html(Haravan.formatMoney(variant.price, "{{isset($amount) ? 1000 : 0}}₫"));
            if (variant.sku) {
                $('#ProductSku').html(variant.sku);
                $('.product-sku').show();
            } else {
                $('.product-sku').hide();
            }
            if (variant.compare_at_price - variant.price > 0) {
                $('#PriceSaving').html('(Bạn đã tích kiệm được ' + Haravan.formatMoney(variant.compare_at_price - variant.price, "{{isset($amount) ? 1000 : 0}}₫") + ')')
            } else {
                $('#PriceSaving').html('')
            }
            if (variant.compare_at_price > 0)
                modal.find('del').html(Haravan.formatMoney(variant.compare_at_price, "{{isset($amount) ? 1000 : 0}}₫"));
            else
                modal.find('del').html('');
            if (variant.available) {
                modal.find('.btn-addcart').css('display', 'block');
                modal.find('.btn-soldout').css('display', 'none');
                if (variant.featured_image) {
                    var newImg = variant.featured_image,
                        el = $('.p-product-image-feature')[0];
                    Haravan.Image.switchImage(newImg, el, timber.switchImage);
                }
                check_variant_quickview = true;
            } else {
                modal.find('.btn-addcart').css('display', 'none');
                modal.find('.btn-soldout').css('display', 'block');

            }
        } else {
            modal.find('.btn-addcart').css('display', 'none');
            modal.find('.btn-soldout').css('display', 'block');
            check_variant_quickview = false;

        }
    }
    var p_select_data = $('.p-option-wrapper').html();
    var p_zoom = $('.image-zoom').html();
    var quickViewProduct = function (purl) {

        if ($(window).width() < 680) {
            window.location = purl;
            return false;
        }
        modal = $('#productQuickView');
        $.ajax({
            url: purl + '.js',
            async: false,
            success: function (product) {
                $.each(product.options, function (i, v) {
                    product.options[i] = v.name;
                })
                modal.find('.p-title').html(product.title);
                modal.find('.p-option-wrapper').html(p_select_data);
                modal.find('#swatch-quick-view').html('');
                $('.image-zoom').html(p_zoom);
                modal.find('.p-url').attr('href', product.url);

                $.each(product.variants, function (i, v) {
                    modal.find('select#p-select-quickview').append("<option value='" + v.id + "'>" + v.title + ' - ' + v.price + "</option>");
                })
                if (product.variants.length == 1 && product.variants[0].title.indexOf('Default') != -1)
                    $('.p-option-wrapper').hide();
                else
                    $('.p-option-wrapper').show();
                if (product.variants.length == 1 && product.variants[0].title.indexOf('Default') != -1) {
                    callBack(product.variants[0], null);
                } else {
                    new Haravan.OptionSelectors("p-select-quickview", {product: product, onVariantSelected: callBack});
                    if (product.options.length == 1 && product.options[0].indexOf('Tiêu đề') == -1)
                        modal.find('.selector-wrapper:eq(0)').prepend('<label>' + product.options[0] + '</label>');
                    $('.p-option-wrapper select:not(#p-select-quickview)').each(function () {
                        $(this).wrap('<span class="custom-dropdown custom-dropdown--white"></span>');
                        $(this).addClass("custom-dropdown__select custom-dropdown__select--white");
                    });
                    var filePath = window.file_url.substring(0, window.file_url.lastIndexOf('?'));
                    var assetUrl = window.asset_url.substring(0, window.asset_url.lastIndexOf('?'));

                    product.options.forEach(function (item) {

                    })
                    var variantSwatch = '';
                    for (var j = 0; j < product.options.length; j++) {
                        var option_index = j;
                        var op_index_plus = option_index + 1;
                        var swatch = product.options[option_index];
                        variantSwatch += '<div id="variant-swatch-' + option_index + '-quickview" class="swatch swatch-quick-view clearfix" data-option="option' + op_index_plus + '" data-option-index="' + option_index + '">';
                        variantSwatch += '<div class="header"> ' + product.options[j] + ' </div><div class="select-swap">';
                        var is_color = false;
                        if (product.options[j] == "Màu sắc" || product.options[j] == "Màu") {
                            is_color = true;
                        }
                        var values = '';
                        for (var i = 0; i < product.variants.length; i++) {
                            var value = convertToSlug(product.variants[i].options[option_index]); //value handle :(
                            var _value = product.variants[i].options[option_index];

                            if (values.indexOf(value) < 0) {
                                values += ',';
                                values += ',' + value;
                                values = values.split(',');
                                if (is_color) {
                                    variantSwatch += '<div data-value="' + _value + '" class="n-sd swatch-element color ' + value;

                                } else {
                                    variantSwatch += '<div data-value="' + _value + '" class="n-sd swatch-element ' + value;
                                }

                                if (option_index == 2) {
                                    variantSwatch += 'variant-3">';
                                } else {
                                    variantSwatch += '">';
                                }

                                variantSwatch += '<input class="variant-' + option_index + ' input-quickview" id="qv-swatch-' + option_index + '-' + value + '" type="radio" name="option' + op_index_plus + '" value="' + _value + '"';
                                if (j == 0) {
                                    variantSwatch += ' checked/>';
                                } else {
                                    variantSwatch += ' />';
                                }

                                if (is_color) {
                                    var img_url = '';
                                    if (product.variants[i].featured_image != null) {
                                        img_url = Haravan.resizeImage(product.variants[i].featured_image.src, 'thumb');
                                    }
                                    if (img_url !== '') {
                                        if (img_url.indexOf('noDefaultImage6') < 0) {
                                            variantSwatch += '<label class="' + value + ' has-thumb" for="qv-swatch-' + option_index + '-' + value + '" style="background: url(' + img_url + ') top left no-repeat" >';
                                        }
                                    } else {
                                        variantSwatch += '<label class="' + value + ' no-thumb" for="qv-swatch-' + option_index + '-' + value + '">';
                                    }
                                    variantSwatch += ' <span>' + _value + '</span><img class="crossed-out" src="' + assetUrl + 'soldout.png" /><img class="img-check" src="' + assetUrl + 'select-pro.png" /></label>';

                                } else {
                                    variantSwatch += '<label for="qv-swatch-' + option_index + '-' + value + '">' + _value + '<img class="crossed-out" src="' + assetUrl + 'soldout.png" /><img class="img-check" src="' + assetUrl + 'select-pro.png" /></label>';
                                }
                                variantSwatch += '</div>';
                            }
                        }

                        variantSwatch += '</div>';
                        variantSwatch += '</div>';
                    }

                    modal.find('#swatch-quick-view').html(variantSwatch);

                    callBack(product.variants[0], null);
                    callFirstVariantQuickView();
                }
                if (product.images.length == 0) {
                    modal.find('.p-product-image-feature').attr('src', '{{ asset('assets/frontend/css/plugin-min.css') }}noDefaultImage6_large.gif');
                } else {
                    $('#p-sliderproduct').remove();
                    $('.image-zoom').append("<div id='p-sliderproduct'>");
                    $('#p-sliderproduct').append("<ul class='owl-carousel inline-list'>");
                    $.each(product.images, function (i, v) {
                        elem = $('<li class="item">').append('<a href="#" data-image="" data-zoom-image=""><img /></a>');
                        elem.find('a').attr('data-image', Haravan.resizeImage(v, 'medium'));
                        elem.find('a').attr('data-zoom-image', Haravan.resizeImage(v, 'large'));
                        elem.find('img').attr('data-image', Haravan.resizeImage(v, 'medium'));
                        elem.find('img').attr('data-zoom-image', Haravan.resizeImage(v, 'large'));
                        elem.find('img').attr('src', Haravan.resizeImage(v, 'medium'));
                        modal.find('.owl-carousel').append(elem);
                    });
                    var owl = $('#p-sliderproduct .owl-carousel');
                    owl.owlCarousel({
                        items: 3,
                        navigation: true,
                        navigationText: ['<i class="fal fa-angle-right"></i>', '<i class="fal fa-angle-left"></i>']
                    });
                    $('#p-sliderproduct .owl-carousel .owl-item').first().children('.item').addClass('active');
                    modal.find('.p-product-image-feature').attr('src', Haravan.resizeImage(product.featured_image, 'large'));
                    $(".modal-footer .btn-readmore").attr('href', purl);
                }
            }
        });

        return false;
    }
    $('#productQuickView').on('click', '.item img', function (event) {
        event.preventDefault();
        modal = $('#quick-view-modal');
        modal.find('.p-product-image-feature').attr('src', $(this).attr('data-zoom-image'));
        modal.find('.item').removeClass('active');
        $(this).parents('li').addClass('active');
        return false;
    });
    $(function () {
        $('#close').click(function () {
            $('#productQuickView .modal-content').css('opacity', '0');
            $('#productQuickView .modal-content').css('transform', 'translateY(-30px)');
            $('#productQuickView').css('background-color', 'rgba(0,0,0,0)');
            setTimeout(function () {
                $('#productQuickView').hide();
            }, 500);
            document.getElementById("form-quick-view").reset();
        })
        window.onclick = function (event) {
            if (event.target == document.getElementById('productQuickView')) {
                $('#productQuickView .modal-content').css('opacity', '0');
                $('#productQuickView .modal-content').css('transform', 'translateY(-30px)');
                $('#productQuickView').css('background-color', 'rgba(0,0,0,0)');
                setTimeout(function () {
                    $('#productQuickView').hide();
                }, 500);
                document.getElementById("form-quick-view").reset();
            }
        }
    })
    $(document).on("click", ".quick-view", function (event) {
        event.preventDefault();

        if (!quickViewProduct($(this).attr('data-handle'))) {
            if ($(window).width() > 680) {
                $('#productQuickView .modal-content').css('opacity', '0');
                $('#productQuickView').show();
                $('#productQuickView').css('background-color', 'rgba(0,0,0,0.4)');
                $('#loading').show();

                var images = $("#productQuickView img");
                var loadedImgNum = 0;

                images.on('load', function () {
                    loadedImgNum += 1;
                    if (loadedImgNum == images.length) {
                        var topPQZ = ($('#productQuickView').height() - $('.modal-content').height()) / 2;
                        $('#loading').hide();
                        $('#productQuickView .modal-content').css('opacity', '1');
                        $('#productQuickView .modal-content').css('transform', 'translateY(0)');
                        $('#productQuickView .modal-content').css('margin-top', topPQZ - 50);
                    }
                });
            }
            $('#p-sliderproduct a').on('click', function (evt) {
                evt.preventDefault();
                var newImage = $(this).data('zoom-image');
                $('.p-product-image-feature').attr('src', newImage);
            });
        }
    });

    function callFirstVariantQuickView() {
        var _chage = '';
        $('#productQuickView .swatch-element[data-value="' + $('.selector-wrapper .single-option-selector').eq(0).val() + '"]').find('input').click();
        $('#productQuickView .swatch-element[data-value="' + $('.selector-wrapper .single-option-selector').eq(1).val() + '"]').find('input').click();
        if (swatch_size == 2) {
            var _avi_op1 = '';
            var _avi_op2 = '';
            var _count = $('#variant-swatch-1-quickview .swatch-element').size();
            $('#variant-swatch-0-quickview .swatch-element').each(function (ind, value) {
                var _key = $(this).data('value');
                var _unavi = 0;
                $('#productQuickView .single-option-selector').eq(0).val(_key).change();
                $('#variant-swatch-1-quickview .swatch-element').each(function (i, v) {
                    var _val = $(this).data('value');
                    $('#productQuickView .single-option-selector').eq(1).val(_val).change();
                    if (check_variant_quickview == true) {
                        if (_avi_op1 == '') {
                            _avi_op1 = _key;
                        }
                        if (_avi_op2 == '') {
                            _avi_op2 = _val;
                        }
                    } else {
                        _unavi += 1;
                    }
                })
                if (_unavi == _count) {
                    $('#variant-swatch-0-quickview .swatch-element[data-value = "' + _key + '"]').addClass('soldout');
                    $('#variant-swatch-0-quickview .swatch-element[data-value = "' + _key + '"]').find('input').attr('disabled', 'disabled');
                }
            })
            $('#variant-swatch-1-quickview .swatch-element[data-value = "' + _avi_op2 + '"] input').click();
            $('#variant-swatch-0-quickview .swatch-element[data-value = "' + _avi_op1 + '"] input').click();
        } else if (swatch_size == 3) {
            var _avi_op1 = '';
            var _avi_op2 = '';
            var _avi_op3 = '';
            var _size_op2 = $('#variant-swatch-1-quickview .swatch-element').size();
            var _size_op3 = $('#variant-swatch-2-quickview .swatch-element').size();

            $('#variant-swatch-0-quickview .swatch-element').each(function (ind, value) {
                var _key_va1 = $(this).data('value');
                var _count_unavi = 0;
                $('#productQuickView .single-option-selector').eq(0).val(_key_va1).change();
                $('#variant-swatch-1-quickview .swatch-element').each(function (i, v) {
                    var _key_va2 = $(this).data('value');
                    var _unavi_2 = 0;
                    $('#productQuickView .single-option-selector').eq(1).val(_key_va2).change();
                    $('#variant-swatch-2-quickview .swatch-element').each(function (j, z) {
                        var _key_va3 = $(this).data('value');
                        $('#productQuickView .single-option-selector').eq(2).val(_key_va3).change();
                        if (check_variant_quickview == true) {
                            if (_avi_op1 == '') {
                                _avi_op1 = _key_va1;
                            }
                            if (_avi_op2 == '') {
                                _avi_op2 = _key_va2;
                            }
                            if (_avi_op3 == '') {
                                _avi_op3 = _key_va3;
                            }
                        } else {
                            _unavi_2 += 1;
                        }
                    })
                    if (_unavi_2 == _size_op3) {
                        _count_unavi += 1;
                    }
                })
                if (_size_op2 == _count_unavi) {
                    $('#variant-swatch-0-quickview .swatch-element[data-value = "' + _key_va1 + '"]').addClass('soldout');
                    $('#variant-swatch-0-quickview .swatch-element[data-value = "' + _key_va1 + '"]').find('input').attr('disabled', 'disabled');
                }
            })
            $('#variant-swatch-0-quickview .swatch-element[data-value = "' + _avi_op1 + '"] input').click();
        }
        var img_ = $('#variant-swatch-0-quickview .swatch-element[data-value = "' + _avi_op1 + '"] input').data('img-src');
    }
</script>
@stack('js')
</body>
</html>
