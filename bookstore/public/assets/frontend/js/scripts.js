document.addEventListener("DOMContentLoaded", (event) => {
    getCartModal()
});

var modalAddCompleteClose = document.getElementsByClassName("modalAddComplete-close")[0];

modalAddCompleteClose.onclick = function() {
    modalAddComplete.style.display = "none";
    modalAddComplete.classList.remove("active");
}

function Modal_udate_price_change(){
    var params = {
        type: 'POST',
        url: '/change-quantity',
        data: $('.modalAddComplete-body form').serialize(),
        async: false,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $.each(data.items,function(i,v){
                $('.modal-main-cart tbody tr[data-variant-id="'+v.cart_sku+'"] .product-money').html(v.into_money + "₫");
            });
            $('.modal-cart-sum h3 span:last-child').html(data.total_money + 'đ');
            $('.modal-cart-status .count, .count-holder .count').html(data.number);
            getCartModal()
        },
        error: function(XMLHttpRequest, textStatus) {
            Haravan.onError(XMLHttpRequest, textStatus);
        }
    };
    jQuery.ajax(params);
}

$(document).on('click', '.quantity-partent-modal .add2', function(e){
    e.preventDefault();
    var input = $(this).parent('.quantity-partent-modal').find('input');
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        input.val(currentVal + 1);
    } else {
        input.val(1);
    }
    Modal_udate_price_change();
});
$(document).on('click', ".quantity-partent-modal .sub2", function(e) {
    e.preventDefault();
    var input = $(this).parent('.quantity-partent-modal').find('input');
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal) && currentVal > 1) {
        input.val(currentVal - 1);
    } else {
        input.val(1);
    }
    Modal_udate_price_change();
});
// Modal Cart
function getCartModal(){
	var cart = null;
	jQuery('#cartform').hide();
	jQuery('#myCart #exampleModalLabel').text("Giỏ hàng");
    let itemHtml = ''
    let cartViewTotal = ''
	jQuery.getJSON('/cart-list', function(cart) {
        let count = cart?.number ?? 0
        $('#total-book').html(count);
		if(count !== 0) {
            cartViewTotal = `
            <table class="table-total">
                <tr>
                    <td class="text-left">TỔNG TIỀN:</td>
                    <td class="text-right" id="total-view-cart">${cart.total_money}₫</td>
                </tr>
                <tr>
                    <td>
                        <a href="/cart" class="linktocart btn btn-primary btn-sm text-uppercase">Xem giỏ hàng</a></td>
                    <td><a href="/checkout" class="linktocheckout btn btn-primary btn-sm text-uppercase">Thanh toán</a></td>
                </tr>
            </table>
            `

            jQuery.each(cart?.items,function(i,item){
            itemHtml += `
            <tr class="item_2 ">
                <td class="img">
                    <a href="${item?.url}">
                        <img src="${item?.image_url}" alt="${item?.name}"/>
                    </a>
                </td>
                <td>
                    <p class="pro-title">
                        <a class="pro-title-view" href="${item?.url}"
                           title="${item?.name}">${item?.name}</a>
                    </p>
                    <div class="mini-cart_quantity">
                        <div class="pro-quantity-view">
                            <span class="qty-value">${item?.qty}</span>
                        </div>
                        <div class="pro-price-view">${item?.price}₫</div>
                    </div>
                    <div class="remove_link remove-cart">
                        <a href='javascript:void(0);' onclick='deleteCart("${item?.cart_sku}")'>
                            <i class="fal fa-times"></i>
                        </a>
                    </div>
                </td>
            </tr>
            `})

            $('#cart-view').html(itemHtml);
            $('#cart-view-total').html(cartViewTotal);
			jQuery('#cartform').show();
			jQuery('.line-item:not(.original)').remove();
		}
		else{
			jQuery('#exampleModalLabel').html('Giỏ hàng của bạn đang trống. Mời bạn tiếp tục mua hàng.');
			jQuery('#cart-view').html('<tr class="item-cart_empty"><td><div class="svgico-mini-cart"> <svg width="81" height="70" viewBox="0 0 81 70"><g transform="translate(0 2)" stroke-width="4" stroke="#1e2d7d" fill="none" fill-rule="evenodd"><circle stroke-linecap="square" cx="34" cy="60" r="6"></circle><circle stroke-linecap="square" cx="67" cy="60" r="6"></circle><path d="M22.9360352 15h54.8070373l-4.3391876 30H30.3387146L19.6676025 0H.99560547"></path></g></svg></div> Hiện chưa có sản phẩm</td></tr>');
			jQuery('#cartform').hide();
			jQuery('#cart-view-total').hide();
		}
	});
}


var closeModal = document.getElementById('modalAddComplete-close');
closeModal.addEventListener('click', function () {
    console.log('vad')
    $('#modalAddComplete').css('display','none');
})

function updateCartModal(){
	$.ajax({
		type: 'GET',
		url: '/cart-list',
		async : false,
		success: function(data) {
            console.log(data)
            setData(data);
		}
	})
}

function setData(cart) {
    let listBook = '';
    jQuery.each(cart?.items,function(i,item){
        listBook += `
        <tr class="" data-variant-id="${item?.cart_sku}">
            <td data-label="customer.order.product" class="product-img ">
                <a href="${item?.url}">
                    <img
                        src="${item?.image_url}"
                        alt="${item?.name}">
                </a>
            </td>
            <td class="product-title">
                <a href="${item?.url}">${item?.name}</a>
                Khuyến mãi:
                Giảm ${item?.promotion}%
            </td>
            <td data-label="cart.label.price" class="product-price">
                <span class="current-price">${item?.price}₫</span>
            </td>
            <td class="product-actions" data-label="cart.label.quantity">
                <div class="quantity-partent-modal">
                    <button type="button" id="sub2" class="sub2">-</button>
                    <input class="js-qty__num form-control" type="text" item-price="${item?.price}"
                           name="items[${item?.cart_sku}]" id="updates${item?.cart_sku}" data-id="" data-price="${item?.price}" value="${item?.qty}" min="0">
                    <button type="button" id="add2" class="add2">+</button>
                </div>

            </td>
            <td class="product-money" data-label="cart.label.total">${item?.into_money}₫</td>
        </tr>
        `
    })

    let data = `
    <div class="modal-cart-status">
                <h2>Giỏ hàng hiện có ${cart?.number} sản phẩm</h2>
            </div>
            <form action="/cart" method="post" novalidate="" class="cart table-wrap added-form" id="modal-cart">
                <div class="modal-main-cart">
                    <div class="modal-tbl-cart d-none d-md-block">
                        <table class="cart-table full table--responsive">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                                ${listBook}
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-checkout-actions">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-cart-status d-flex align-items-center justify-content-between">
                                    <div class="modal-cart-checkout">
                                        <div class="modal-cart-sum">
                                            <h3>Tổng: <span>${cart?.total_money}₫</span></h3>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="/cart" class="btnToCart btn btn-primary btn-sm mr-1">Giỏ hàng</a>
                                        <a href="/checkout" class="btnProceedCheckout btn btn-primary btn-sm">Thanh
                                            toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    `
    $('.modalAddComplete-body').html(data);
    $('#modalAddComplete').css('display','block');
    $('#modalAddComplete').addClass("active");
    setTimeout(function(){
        $('.modalAddComplete-content').addClass('show');
    }, 100)
}


$("#modal-cart").submit(function(){
    alert("Submitted");
});


// Delete variant in modalCart
function deleteCart(id){
	var params = {
		type: 'POST',
		url: '/remove-product',
		data: 'id=' + id,
		dataType: 'json',
		success: function(data) {
			getCartModal();
		},
		error: function(XMLHttpRequest, textStatus) {
            console.log('error')
		}
	};
	jQuery.ajax(params);
}
// Buynow
var buy_now = function(id) {
	var quantity = 1;
	var params = {
		type: 'POST',
		url: '/cart/add.js',
		data: 'quantity=' + quantity + '&id=' + id,
		dataType: 'json',
		success: function(line_item) {
			window.location = '/checkout';
		},
		error: function(XMLHttpRequest, textStatus) {
			Haravan.onError(XMLHttpRequest, textStatus);
		}
	};
	jQuery.ajax(params);
}

var add_to_cart = function(id) {
	var quantity = 1;
    if (jQuery('input[name="quantity"]').val() != undefined ) {
        quantity = parseInt(jQuery('input[name="quantity"]').val());
    }

	var params = {
		type: 'POST',
		url: `/add-to-cart/${id}`,
		data: 'quantity=' + quantity + '&id=' + id,
		dataType: 'json',
		success: function(line_item) {
			getCartModal();
			updateCartModal();
		},
		error: function(XMLHttpRequest, textStatus) {
			Haravan.onError(XMLHttpRequest, textStatus);
		}
	};
	jQuery.ajax(params);
}

// Update product in modalCart
jQuery(document).on("click","#update-cart-modal",function(event){
	event.preventDefault();
	if (jQuery('#cartform').serialize().length <= 5) return;
	jQuery(this).html('Đang cập nhật');
	var params = {
		type: 'POST',
		url: '/cart-list',
		data: jQuery('#cartform').serialize(),
		dataType: 'json',
		success: function(cart) {
			if ((typeof callback) === 'function') {
				callback(cart);
			} else {
				getCartModal();
			}
			jQuery('#update-cart-modal').html('Cập nhật');
		},
		error: function(XMLHttpRequest, textStatus) {
			Haravan.onError(XMLHttpRequest, textStatus);
		}
	};
	jQuery.ajax(params);
});

function initNav(action) {
	switch(action) {
		case 'close':
			$('#nav').removeClass('show');
			$('.nav-overlay').removeClass('show');
			break;
		case 'open':
			$('#nav').addClass('show');
			$('.nav-overlay').addClass('show');
			break;
	}
}

function initSearch(action) {
	switch(action) {
		case 'close':
			$('.main-search').removeClass('show');
			break;
		case 'open':
			$('.main-search').addClass('show');
			break;
	}
}

$('#nav ul li a i').on('click', function (e) {
	e.preventDefault();
	$(this).toggleClass('active').parent().next().slideToggle();
});

function smoothScroll(a, b){
	$('body,html').animate({
		scrollTop : a
	}, b);
}
function boxAccount(type){
	$('.site_account .js-link').removeClass('is-selected');
	$(`.site_account .js-link[aria-controls="${type}"]`).addClass('is-selected');
	$('.site_account .site_account_panel_list .site_account_panel ').addClass('d-none');
	$('.site_account .site_account_panel_list .site_account_panel ').removeClass('is-selected');
	$(`.site_account .site_account_panel_list .site_account_panel#${type}`).removeClass('d-none');
	$(`.site_account .site_account_panel_list .site_account_panel#${type}`).addClass('is-selected');
	var newheight = $(`.site_account .site_account_panel_list .site_account_panel#${type}`).addClass('is-selected').height();
	if($('.site_account_panel').hasClass('is-selected')){
		$('.site_account_panel_list').css("height", newheight);
	}
};
/********************************************************
# OWL CAROUSEL
********************************************************/
function awe_owl() {
	$('.owl-carousel:not(.not-owl)').each( function(){
		var xs_item = $(this).attr('data-xs-items');
		var md_item = $(this).attr('data-md-items');
		var lg_item = $(this).attr('data-lg-items');
		var sm_item = $(this).attr('data-sm-items');
		var margin=$(this).attr('data-margin');
		var dot=$(this).attr('data-dot');
		var nav=$(this).attr('data-nav');
		var autoplay=$(this).attr('data-autoplay');
		var height=$(this).attr('data-height');
		var play=$(this).attr('data-play');
		var loop=$(this).attr('data-loop');
		if (typeof margin !== typeof undefined && margin !== false) {
		} else{
			margin = 30;
		}
		if (typeof xs_item !== typeof undefined && xs_item !== false) {
		} else{
			xs_item = 1;
		}
		if (typeof sm_item !== typeof undefined && sm_item !== false) {

		} else{
			sm_item = 3;
		}
		if (typeof md_item !== typeof undefined && md_item !== false) {
		} else{
			md_item = 3;
		}
		if (typeof lg_item !== typeof undefined && lg_item !== false) {
		} else{
			lg_item = 3;
		}
		if (typeof dot !== typeof undefined && dot !== false) {
			dot = true;
		} else{
			dot = false;
		}
		if (typeof nav !== typeof undefined && nav !== false) {
			nav = true;
		} else{
			nav = false;
		}
		if (typeof autoplay !== typeof undefined && autoplay !== false) {
			autoplay = true;
		} else{
			autoplay = false;
		}
		$(this).owlCarousel({
			loop:true,
			margin:Number(margin),
			responsiveClass:true,
			autoplay: autoplay,
			dots:dot,
			nav:nav,
			lazyLoad: true,
      autoplaySpeed: 1000,
			navText: ['<i class="fal fa-angle-left"></i>','<i class="fal fa-angle-right"></i>'],
			responsive:{
				0:{
					items:Number(xs_item),
				},
				600:{
					items:Number(sm_item),
				},
				1000:{
					items:Number(md_item),
				},
				1200:{
					items:Number(lg_item),
					nav:nav
				}
			}
		})
	})
};
awe_owl();
jQuery(document).ready(function(){
	// Get number item for cart header
	$.get('/cart-list').done(function(cart){
		$('.cart-menu .count').html(cart.item_count);
	});
	if (window.template.indexOf('index') > -1) {

		if ($('.list-slider-banner').length > 0) {
			var checkBanner =	$('.list-slider-banner .home-banner-pd').length;
			$('.list-slider-banner').owlCarousel({
				items: 1,
				loop: true,
				dots: false,
				nav: false,
				smartSpeed: 1000,
				responsive: {
					0: {
						items: 1,
						stagePadding: 30,
					},
					480: {
						items: 1,
						stagePadding: 50,
					},
					768: {
						items: 2,
						stagePadding: 60,
						nav: true
					},
					992: {
						items: 3,
						stagePadding: checkBanner > 3?90:0,
						loop: checkBanner > 3?true:false,
						nav:checkBanner > 3?true:false,
						mouseDrag:checkBanner > 3?true:false,
						touchDrag:checkBanner > 3?true:false
					},
					1200: {
						items: 3,
						stagePadding: checkBanner > 3?60:0,
						loop: checkBanner > 3?true:false,
						nav:checkBanner > 3?true:false,
						mouseDrag:checkBanner > 3?true:false,
						touchDrag:checkBanner > 3?true:false
					}
				}
			});
		}
	}
	//Click event to scroll to top
	jQuery(document).on("click", ".back-to-top", function(){
		jQuery(this).removeClass('show');
		jQuery('html, body').animate({
			scrollTop: 0
		}, 800);
	});

	jQuery(window).scroll(function() {
		/* scroll top */
		if (jQuery('.back-to-top').length > 0 && jQuery(window).scrollTop() > 500 ) {
			jQuery('.back-to-top').addClass('show');
		} else {
			jQuery('.back-to-top').removeClass('show');
		}
	});
	/* backto - product */
	if($('#backto-page').length > 0){
		$(document).on("click", "#backto-page", function(){
			window.history.back();
		});
	}
	$('a[data-spy=scroll]').click(function(){
		event.preventDefault() ;
		$('body').animate({scrollTop: ($($(this).attr('href')).offset().top - 20) + 'px'}, 500);
	})
	/* CLICK icon header */
	$('body').on('click', '.js-link', function(e){
		e.preventDefault();
		boxAccount($(this).attr('aria-controls'));
	});
	$('.site_account input').blur(function(){
		var tmpval = $(this).val();
		if(tmpval == '') {
			$(this).removeClass('is-filled');
		} else {
			$(this).addClass('is-filled');
		}
	});
	/*
	$('.header-action-toggle').click(function(e){
		e.preventDefault();
		if($(this).parents('.header-action_cart').hasClass('show-action')){
			$(this).parents('.header-action_cart').removeClass('show-action');
		}
		else{
			$('.header-action_cart').removeClass('show-action');
			$(this).parents('.header-action_cart').addClass('show-action');
		}
	});*/
	$('body').on('click', '#site-overlay', function(e){
		$('.header-action').removeClass('show-action');
	});

	// Dropdown Title
	jQuery('.title_block').click(function(){
		$(this).next().slideToggle('medium');
	});
	$(document).on("click",".dropdown-filter", function(){
		if ( $(this).parent().attr('aria-expanded') == 'false' ) {
			$(this).parent().attr('aria-expanded','true');
		} else {
			$(this).parent().attr('aria-expanded','false');
		}
	});
	// Mainmenu sidebar
	$(document).on("click", "span.icon-subnav", function(){
		if ($(this).parent().hasClass('active')) {
			$(this).parent().removeClass('active');
			$(this).siblings('ul').slideUp();
		} else {
			if( $(this).parent().hasClass("level0") || $(this).parent().hasClass("level1")){
				$(this).parent().siblings().find("ul").slideUp();
				$(this).parent().siblings().removeClass("active");
			}
			$(this).parent().addClass('active');
			$(this).siblings('ul').slideDown();
		}
	});
	// Menu sidebar
	$(document).on('click','.tree-menu .tree-menu-lv1',function(){
		$this = $(this).find('.tree-menu-sub');
		$('.tree-menu .has-child .tree-menu-sub').not($this).slideUp('fast');
		$(this).find('.tree-menu-sub').slideToggle('fast');
		$(this).toggleClass('menu-collapsed');
		$(this).toggleClass('menu-uncollapsed');
		var $this1 = $(this);
		$('.tree-menu .has-child').not($this1).removeClass('menu-uncollapsed');
	});
	/* footer */
	if (jQuery(window).width() < 768) {
		jQuery('.main-footer .footer-col .footer-title').on('click', function(){
			jQuery(this).toggleClass('active').parent().find('.footer-content').stop().slideToggle('medium');
		});
		// icon Footer
		$('a.btn-fter').click(function(e){
			if ( $(this).attr('aria-expanded') == 'false' ) {
				e.preventDefault();
				$(this).attr('aria-expanded','true');
				$('.main-footer').addClass('bg-active');
			} else {
				$(this).attr('aria-expanded','false');
				$('.main-footer').removeClass('bg-active');
			}
		});
	}
});

/* Search ultimate destop -mobile*/
$('.ultimate-search').submit(function(e) {
	e.preventDefault();
	var q = $(this).find('input[name=q]').val();
	if(q.indexOf('script') > -1 || q.indexOf('>') > -1){
		alert('Từ khóa của bạn có chứa mã độc hại ! Vui lòng nhập lại key word khác');
		$(this).find('input[name=q]').val('');
	}else{
		var q_follow = 'product';
		var query = encodeURIComponent(q);
		if( !q ) {
			window.location = '/search?type='+ q_follow +'&q=';
			return;
		}
		else {
			window.location = '/search?type=' + q_follow +'&q=' + query;
			return;
		}
	}
});
var $input = $('.ultimate-search input[type="text"]');
$input.bind('keyup change paste propertychange', function() {
	var key = $(this).val(),
			$parent = $(this).parents('.wpo-wrapper-search'),
			$results = $(this).parents('.wpo-wrapper-search').find('.smart-search-wrapper');
	if(key.indexOf('script') > -1 || key.indexOf('>') > -1){
		alert('Từ khóa của bạn có chứa mã độc hại ! Vui lòng nhập lại key word khác');
		$(this).val('');
		$('.ultimate-search input[type="text"]').val('');
	}
	else{
		if(key.length > 0 ){
			$('.ultimate-search input[type="text"]').val($(this).val());
			$(this).attr('data-history', key);
			var q_follow = 'product',
					str = '';
			str = '/search?type=product&q='+ key + '&view=ultimate-product';
			$.ajax({
				url: str,
				type: 'GET',
				async: true,
				success: function(data){
					$results.find('.resultsContent').html(data);
				}
			})
			if(!$('.header-action_search').hasClass('show-action')){
				$('.header-action').removeClass('show-action');
			}
			$(".search-bar-mobile .ultimate-search").addClass("expanded");
			$results.fadeIn();
		}
		else{
			$('.ultimate-search input[type="text"]').val($(this).val());
			$(".search-bar-mobile .ultimate-search").removeClass("expanded");
			$results.fadeOut();
		}
	}
})
$('body').click(function(evt) {
	var target = evt.target;
	if (target.id !== 'ajaxSearchResults' && target.id !== 'inputSearchAuto') {
		$(".ajaxSearchResults").hide();
	}
	if (target.id !== 'ajaxSearchResults-3' && target.id !== 'inputSearchAuto-3') {
		$("#ajaxSearchResults-3").hide();
	}
	if (target.id !== 'ajaxSearchResults-mb' && target.id !== 'inputSearchAuto-mb') {
		$(".ajaxSearchResults").hide();
	}
});
$('body').on('click', '.ultimate-search input[type="text"]', function() {
	if ($(this).is(":focus")) {
		if ($(this).val() != '') {
			$(".ajaxSearchResults").show();
		}
	} else {

	}
})
$('body').on('click', '.ultimate-search .close-search', function(e){
	e.preventDefault();
	$(".ajaxSearchResults").hide();
	$(".ultimate-search").removeClass("expanded");
	$(".ultimate-search").find('input[name=q]').val('');
})
/*=======================================*/
jQuery(document).ready(function(){
	if ($('.addThis_listSharing').length > 0){
		$(window).scroll(function(){
			if(jQuery(window).scrollTop() > 100 ) {
				jQuery('.addThis_listSharing').addClass('is-show');
			} else {
				jQuery('.addThis_listSharing').removeClass('is-show');
			}
		});
		$('.content_popupform form.contact-form').submit(function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url:'/contact',
				data: $('.content_popupform form.contact-form').serialize(),
				success:function(data){
					$('.modal-contactform.fade.in').modal('hide');
					setTimeout(function(){
						$('.modal-succesform').modal('show');
						setTimeout(function(){
							$('.modal-succesform.fade.in').modal('hide');
						}, 5000);
					},300);
				},

			})
		});
		$(".modal-succesform").on('hidden.bs.modal', function() {
			location.reload();
		});
	}
	if ($('.layoutProduct_scroll').length > 0 && jQuery(window).width() < 768) {
		var curScrollTop = 0;
		$(window).scroll(function(){
			var scrollTop = $(window).scrollTop();
			if(scrollTop > curScrollTop  && scrollTop > 200 ) {
				$('.layoutProduct_scroll').removeClass('scroll-down').addClass('scroll-up');
			}
			else {
				if (scrollTop > 200 && scrollTop + $(window).height() + 150 < $(document).height()) {
					$('.layoutProduct_scroll').removeClass('scroll-up').addClass('scroll-down');
				}
			}
			if(scrollTop < curScrollTop  && scrollTop < 200 ) {
				$('.layoutProduct_scroll').removeClass('scroll-up').removeClass('scroll-down');
			}
			curScrollTop = scrollTop;
		});
	}
});

document.addEventListener("DOMContentLoaded", function() {
	let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
	let active = false;

	const lazyLoad = function() {
		if (active === false) {
			active = true;

			setTimeout(function() {
				lazyImages.forEach(function(lazyImage) {
					if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
						lazyImage.src = lazyImage.dataset.src;
						lazyImage.srcset = lazyImage.dataset.srcset;
						lazyImage.classList.remove("lazy");

						lazyImages = lazyImages.filter(function(image) {
							return image !== lazyImage;
						});

						if (lazyImages.length === 0) {
							document.removeEventListener("scroll", lazyLoad);
							window.removeEventListener("resize", lazyLoad);
							window.removeEventListener("orientationchange", lazyLoad);
						}
					}
				});

				active = false;
			}, 200);
		}
	};

	document.addEventListener("scroll", lazyLoad);
	window.addEventListener("resize", lazyLoad);
	window.addEventListener("orientationchange", lazyLoad);
});


function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function checkCookie() {
	var user = getCookie("username");
	if (user != "") {
		alert("Welcome again " + user);
	} else {
		user = prompt("Please enter your name:", "");
		if (user != "" && user != null) {
			setCookie("username", user, 365);
		}
	}
}

/* variant click */

function convertToSlug(str) {

	str= str.toLowerCase();
	str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
	str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
	str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
	str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
	str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
	str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
	str= str.replace(/đ/g,"d");
	str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
	str= str.replace(/-+-/g,"-");
	str= str.replace(/^\-+|\-+$/g,"");
	return str;
}

var swatch_size = 0;
jQuery(document).ready(function(){

	jQuery('#productQuickView').on('click','input.input-quickview', function(e) {
		e.preventDefault();
		console.log('quickviewXXX');
		swatch_size = parseInt($('#productQuickView .select-swatch').children().length);
		var $this = $(this);
		var _available = '';
		$this.parent().siblings().find('label').removeClass('sd');
		$this.next().addClass('sd');
		var name = $this.attr('name');
		var value = $this.val();
		$('#productQuickView select[data-option='+name+']').val(value).trigger('change');
		if($(this).data('img-src')){
			var img_ = $(this).data('img-src');
			$('#productQuickView .product-single__thumbnail[href="'+img_+'"]').trigger('click');
		}
		if(swatch_size == 2){
			if(name.indexOf('1') != -1){
				$('#variant-swatch-1-quickview .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-2-quickview .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-1-quickview .swatch-element label').removeClass('sd');
				$('#variant-swatch-1-quickview .swatch-element').removeClass('soldout');
				$('#productQuickView .selector-wrapper .single-option-selector').eq(1).find('option').each(function(){
					var _tam = $(this).val();
					$(this).parent().val(_tam).trigger('change');
					if(check_variant_quickview){
						if(_available == '' ){
							_available = _tam;
						}
					}else{
						$('#variant-swatch-1-quickview .swatch-element[data-value="'+_tam+'"]').addClass('soldout');
						$('#variant-swatch-1-quickview .swatch-element[data-value="'+_tam+'"]').find('input').prop('disabled', true);
					}
				})
				$('#productQuickView .selector-wrapper .single-option-selector').eq(1).val(_available).trigger('change');
				$('#variant-swatch-1-quickview .swatch-element[data-value="'+_available+'"] label').addClass('sd');
			}
		}else if (swatch_size == 3){
			var _count_op2 = $('#variant-swatch-1-quickview .swatch-element').length;
			var _count_op3 = $('#variant-swatch-2-quickview .swatch-element').length;
			if(name.indexOf('1') != -1){
				$('#variant-swatch-1-quickview .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-2-quickview .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-1-quickview .swatch-element label').removeClass('sd');
				$('#variant-swatch-1-quickview .swatch-element').removeClass('soldout');
				$('#variant-swatch-2-quickview .swatch-element label').removeClass('sd');
				$('#variant-swatch-2-quickview .swatch-element').removeClass('soldout');
				var _avi_op1 = '';
				var _avi_op2 = '';
				$('#variant-swatch-1-quickview .swatch-element').each(function(ind,value){
					var _key = $(this).data('value');
					var _unavi = 0;
					$('#productQuickView .single-option-selector').eq(1).val(_key).change();
					$('#variant-swatch-2-quickview .swatch-element label').removeClass('sd');
					$('#variant-swatch-2-quickview .swatch-element').removeClass('soldout');
					$('#variant-swatch-2-quickview .swatch-element').find('input').prop('disabled', false);
					$('#variant-swatch-2-quickview .swatch-element').each(function(i,v){
						var _val = $(this).data('value');
						$('#productQuickView .single-option-selector').eq(2).val(_val).change();
						if(check_variant == true){
							if(_avi_op1 == ''){
								_avi_op1 = _key;
							}
							if(_avi_op2 == ''){
								_avi_op2 = _val;
							}
							//console.log(_avi_op1 + ' -- ' + _avi_op2)
						}else{
							_unavi += 1;
						}
					})
					if(_unavi == _count_op3){
						$('#variant-swatch-1-quickview .swatch-element[data-value = "'+_key+'"]').addClass('soldout');
						setTimeout(function(){
							$('#variant-swatch-1-quickview .swatch-element[data-value = "'+_key+'"] input').attr('disabled','disabled');
						})
					}
				})
				$('#variant-swatch-1-quickview .swatch-element[data-value="'+_avi_op1+'"] input').click();
			}
			else if(name.indexOf('2') != -1){
				$('#variant-swatch-2-quickview .swatch-element label').removeClass('sd');
				$('#variant-swatch-2-quickview .swatch-element').removeClass('soldout');
				$('#productQuickView .selector-wrapper .single-option-selector').eq(2).find('option').each(function(){
					var _tam = $(this).val();
					$(this).parent().val(_tam).trigger('change');
					if(check_variant_quickview){
						if(_available == '' ){
							_available = _tam;
						}
					}else{
						$('#variant-swatch-2-quickview .swatch-element[data-value="'+_tam+'"]').addClass('soldout');
						$('#variant-swatch-2-quickview .swatch-element[data-value="'+_tam+'"]').find('input').prop('disabled', true);
					}
				})
				$('#productQuickView .selector-wrapper .single-option-selector').eq(2).val(_available).trigger('change');
				$('#variant-swatch-2-quickview .swatch-element[data-value="'+_available+'"] label').addClass('sd');
			}
		}else{

		}
	})

	jQuery('#PageContainer').on('click','.input-product', function(e) {
		swatch_size = parseInt($('#product-select-watch').children().length);
		console.log('productX');
		var $this = $(this);
		var _available = '';
		$this.parent().siblings().find('label').removeClass('sd');
		$this.next().addClass('sd');
		var name = $this.attr('name');
		var value = $this.val();
		$('select[data-option='+name+']').val(value).trigger('change');
		if($(this).data('img-src')){
			var img_ = $(this).data('img-src');
			$('.product-single__thumbnail[href="'+img_+'"]').trigger('click');
		}
		if(swatch_size == 2){
			if(name.indexOf('1') != -1){
				$('#variant-swatch-1 .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-2 .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-1 .swatch-element label').removeClass('sd');
				$('#variant-swatch-1 .swatch-element').removeClass('soldout');
				$('.selector-wrapper .single-option-selector').eq(1).find('option').each(function(){
					var _tam = $(this).val();
					$(this).parent().val(_tam).trigger('change');
					if(check_variant){
						if(_available == '' ){
							_available = _tam;
						}
					}else{
						$('#variant-swatch-1 .swatch-element[data-value="'+_tam+'"]').addClass('soldout');
						$('#variant-swatch-1 .swatch-element[data-value="'+_tam+'"]').find('input').prop('disabled', true);
					}
				})
				$('.selector-wrapper .single-option-selector').eq(1).val(_available).trigger('change');
				$('#variant-swatch-1 .swatch-element[data-value="'+_available+'"] label').addClass('sd');
			}
		}else if (swatch_size == 3){
			var _count_op2 = $('#variant-swatch-1 .swatch-element').length;
			var _count_op3 = $('#variant-swatch-2 .swatch-element').length;
			if(name.indexOf('1') != -1){
				$('#variant-swatch-1 .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-2 .swatch-element').find('input').prop('disabled', false);
				$('#variant-swatch-1 .swatch-element label').removeClass('sd');
				$('#variant-swatch-1 .swatch-element').removeClass('soldout');
				$('#variant-swatch-2 .swatch-element label').removeClass('sd');
				$('#variant-swatch-2 .swatch-element').removeClass('soldout');
				var _avi_op1 = '';
				var _avi_op2 = '';
				$('#variant-swatch-1 .swatch-element').each(function(ind,value){
					var _key = $(this).data('value');
					var _unavi = 0;
					$('.single-option-selector').eq(1).val(_key).change();
					$('#variant-swatch-2 .swatch-element label').removeClass('sd');
					$('#variant-swatch-2 .swatch-element').removeClass('soldout');
					$('#variant-swatch-2 .swatch-element').find('input').prop('disabled', false);
					$('#variant-swatch-2 .swatch-element').each(function(i,v){
						var _val = $(this).data('value');
						$('.single-option-selector').eq(2).val(_val).change();
						if(check_variant == true){
							if(_avi_op1 == ''){
								_avi_op1 = _key;
							}
							if(_avi_op2 == ''){
								_avi_op2 = _val;
							}
							//console.log(_avi_op1 + ' -- ' + _avi_op2)
						}else{
							_unavi += 1;
						}
					})
					if(_unavi == _count_op3){
						$('#variant-swatch-1 .swatch-element[data-value = "'+_key+'"]').addClass('soldout');
						setTimeout(function(){
							$('#variant-swatch-1 .swatch-element[data-value = "'+_key+'"] input').attr('disabled','disabled');
						})
					}
				})
				$('#variant-swatch-1 .swatch-element[data-value="'+_avi_op1+'"] input').click();
			}
			else if(name.indexOf('2') != -1){
				$('#variant-swatch-2 .swatch-element label').removeClass('sd');
				$('#variant-swatch-2 .swatch-element').removeClass('soldout');
				$('.selector-wrapper .single-option-selector').eq(2).find('option').each(function(){
					var _tam = $(this).val();
					$(this).parent().val(_tam).trigger('change');
					if(check_variant){
						if(_available == '' ){
							_available = _tam;
						}
					}else{
						$('#variant-swatch-2 .swatch-element[data-value="'+_tam+'"]').addClass('soldout');
						$('#variant-swatch-2 .swatch-element[data-value="'+_tam+'"]').find('input').prop('disabled', true);
					}
				})
				$('.selector-wrapper .single-option-selector').eq(2).val(_available).trigger('change');
				$('#variant-swatch-2 .swatch-element[data-value="'+_available+'"] label').addClass('sd');
			}
		}else{
			if(name.indexOf('1') != -1){

				$('#variant-swatch-0 .swatch-element').find('input').prop('disabled', false);

				$('#variant-swatch-0 .swatch-element label').removeClass('sd');

				$('#variant-swatch-0 .swatch-element').removeClass('soldout');

				$('.selector-wrapper .single-option-selector').eq(0).find('option').each(function(){

					var _tam = $(this).val();

					$(this).parent().val(_tam).trigger('change');

					if(check_variant){
						_available = _tam;
					} else{
						$('#variant-swatch-0 .swatch-element[data-value="'+_tam+'"]').addClass('soldout');
						$('#variant-swatch-0 .swatch-element[data-value="'+_tam+'"]').find('input').prop('disabled', true);
					}

				})

				$('.selector-wrapper .single-option-selector').eq(0).val(value).trigger('change');
				$('#variant-swatch-0 .swatch-element[data-value="'+ value +'"] label').addClass('sd');

			}
		}
	})
})

$(function() {
	$('nav#menu-mobile').mmenu({
		offCanvas: {
			position  : "right"
		}
	});
});
$(document).ready(function(){
	flagg = true;
	if(flagg){
		$('.header-action_menu a').click(function(e){
			e.preventDefault();
			$('#menu-mobile').removeClass('hidden');
			flagg = false;
		})
	}

	var offset = 220;
	var duration = 500;
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > offset) {
			jQuery('#back-to-top').fadeIn(duration);
		} else {
			jQuery('#back-to-top').fadeOut(duration);
		}
	});

	jQuery('#back-to-top').click(function(event) {
		event.preventDefault();
		jQuery('html, body').animate({
			scrollTop: 0
		}, duration);
		return false;
	});
});

setTimeout(function(){
	animation_check();
}, 100);
function animation_check(){
	var scrollTop = $(window).scrollTop() - 300;
	$('.animation-tran').each(function(){
		if($(this).offset().top < scrollTop + $(window).height()){
			$(this).addClass('active');
		}
	})
}
$(window).scroll(function(){
	//setTimeout(function(){
	animation_check();
	//}, 500);
})

function tab_custom(link, content) {
	$(link).on('click', function () {
		var id = $(this).data('id');
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		$(content + '[data-id='+id+']').siblings().removeClass('active');
		$(content + '[data-id='+id+']').addClass('active');
	});
}

if ($('.htp-tablink').length) {
	tab_custom('.htp-tablink', '.htp-tabcontent');
}

$(window).scroll(function () {
	if ($(this).scrollTop() > 100) {
		$('#header').addClass('fixed');
	} else {
		$('#header').removeClass('fixed');
	}
	if ($(this).scrollTop() > 120) {
		$('#header').addClass('fixed2');
	} else {
		$('#header').removeClass('fixed2');
	}
});
