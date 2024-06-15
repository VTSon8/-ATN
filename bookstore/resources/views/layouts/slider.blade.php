<div id="home-slider" class="mb-30">
    <div class="owl-carousel owl-theme owl-nav-style-3 dark" data-autoplayspeed="5000"
         data-autoplay="true" data-lg-items="1" data-md-items="1" data-sm-items="1" data-xs-items="1"
         data-dot="true" data-nav="true">
        @foreach($banners as $banner)
        <div class="item">
            <div class="image">
                <a href="{{route('home')}}">
                    <picture>
                        <source media="(min-width: 768px)"
                                srcset="{{ url('assets/upload/' . data_get($banner, 'thumb')) }}">
                        <source media="(max-width: 767px)"
                                srcset="{{ url('assets/upload/' . data_get($banner, 'thumb')) }}">
                        <img loading="lazy"
                             src="{{ url('assets/upload/' . data_get($banner, 'thumb')) }}"
                             alt="">
                    </picture>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<section class="home-two-banner home-section-mg">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="item banner-effect">
                <a href="{{route('home')}}">
                    <picture>
                        <source media="(min-width: 768px)"
                                srcset="//theme.hstatic.net/200000845405/1001223012/14/htb_img_1.jpg?v=17">
                        <source media="(max-width: 767px)"
                                srcset="//theme.hstatic.net/200000845405/1001223012/14/htb_img_1_large.jpg?v=17">
                        <img loading="lazy"
                             src="//theme.hstatic.net/200000845405/1001223012/14/htb_img_1_small.jpg?v=17"
                             alt="Người đàn bà trong tôi"/>
                    </picture>
                    <span class="hover hover1"></span>
                    <span class="hover hover2"></span>
                    <span class="hover hover3"></span>
                    <span class="hover hover4"></span>
                </a>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="item banner-effect">
                <a href="{{route('home')}}">
                    <picture>
                        <source media="(min-width: 768px)"
                                srcset="//theme.hstatic.net/200000845405/1001223012/14/htb_img_2.jpg?v=17">
                        <source media="(max-width: 767px)"
                                srcset="//theme.hstatic.net/200000845405/1001223012/14/htb_img_2_large.jpg?v=17">
                        <img loading="lazy"
                             src="//theme.hstatic.net/200000845405/1001223012/14/htb_img_2_small.jpg?v=17"
                             alt=""/>
                    </picture>
                    <span class="hover hover1"></span>
                    <span class="hover hover2"></span>
                    <span class="hover hover3"></span>
                    <span class="hover hover4"></span>
                </a>
            </div>
        </div>
    </div>
</section>
