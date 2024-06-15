<div class="modal" id="productQuickView">
    <div class="modal-content">
        <span id="close" class="close">&times;</span>
        <form class="row" id="form-quick-view">
            <div class="col-12 col-md-6">
                <div class="image-zoom">
                    <img id="p-product-image-feature" class="p-product-image-feature" src="" alt="">
                    <div id="p-sliderproduct" class="flexslider">
                        <ul class="slides"></ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h4 class="p-title modal-title" id="">Tên sản phẩm</h4>
                <p class="product-more-info">
                    <span class="product-sku">
                    Mã sản phẩm: <span id="ProductSku">01923123</span>
                    </span>
                </p>
                <div class="form-input product-price-wrapper">
                    <div class="product-price">
                        <span class="p-price "></span>
                        <del></del>
                    </div>
                    <em id="PriceSaving"></em>
                </div>
                <div class="p-option-wrapper">
                    <select name="id" class="" id="p-select-quickview"></select>
                </div>
                <div id="swatch-quick-view" class="select-swatch">

                </div>
                <div class="form-input">
                    <label>Số lượng</label>
                    <div class="quantity-area clearfix">
                        <input type="button" value="-" onclick="minusQuantity2()" class="qty-btn">
                        <input type="text" id="quantity_qv" name="quantity_qv" value="1" class="quantity-selector">
                        <input type="button" value="+" onclick="plusQuantity2()" class="qty-btn">
                    </div>
                </div>

                <div class="form-input" style="width: 100%">
                    <button type="submit" class="btn btn-addcart" id="AddToCardQuickView">Thêm vào giỏ</button>
                    <button disabled class="btn btn-soldout">Hết hàng</button>
                    <div class="qv-readmore">
                        <span> hoặc </span><a class="read-more p-url" href="" role="button">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="loading">
        <div></div>
    </div>
</div>
