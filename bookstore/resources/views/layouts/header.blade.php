<div class="container">
    <div class="d-flex align-items-center justify-content-between">
        <div class="header-logo">
            <div class="header-logo wrap-logo" itemscope="" itemtype="http://schema.org/Organization">
                <a href="{{route('home')}}" itemprop="url" aria-label="Vinabook">
                    <img itemprop="logo" src="{{asset('assets/images/logo.png')}}"
                         alt="Vinabook" class="img-responsive logoimg"/>
                </a>
            </div>

        </div>
        <div class="header-search">
            <div class="main-search d-flex align-items-center justify-content-center">
                <a class="close-search" href="javascript:void(0);" onclick="initSearch('close')">
                    <img src="//theme.hstatic.net/200000845405/1001223012/14/icon-close.png?v=17" alt="close"/>
                </a>
                <div class="search-box wpo-wrapper-search">
                    <form action="{{route('search')}}" class="searchform-product ultimate-search" method="GET">
                        @csrf
                        <div class="wpo-search-inner">
                            <input type="hidden" name="type" value="product"/>
                            <input required id="inputSearchAuto-3" class="input-search" name="q" maxlength="40"
                                   autocomplete="off" type="text" size="20" placeholder="Tìm kiếm sản phẩm..."
                                   aria-label="input search">
                            <span class="close-search"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24"><path
                                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg></span>
                        </div>
                        <button type="submit" class="btn-search " id="btnSearchAuto-3" aria-label="Tìm kiếm">Tìm
                            kiếm
                        </button>
                    </form>
                    <div class="smart-search-wrapper ajaxSearchResults" id="ajaxSearchResults-3"
                         style="display: none">
                        <div class="resultsContent"></div>
                    </div>
                    <div class="searchform-backdrop"></div>
                </div>
            </div>
        </div>
        <div class="header-support d-none d-md-flex align-items-center">
            <div class="header-support__icon">
                <img src="//theme.hstatic.net/200000845405/1001223012/14/phone-call.png?v=17" alt="phone"/>
            </div>
            <div class="header-support__detail">
                <p>Tư vấn bán hàng</p>
                <span>19006401</span>
            </div>
        </div>
        <div class="header-upper-icon d-lg-none">
            <div class="header-wrap-icon d-flex justify-content-end">
                <div class="header-search ml-5 d-md-none">
                    <a href="javascript:void(0);" onclick="initSearch('open')"><i
                            class="fal fa-search fz-20"></i></a>
                </div>
                <div class="header-action_menu ml-5 d-lg-none">
                    <a class="close-nav" href="#menu-mobile" id="site-menu-handle"><i
                            class="fal fa-bars fz-20"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
