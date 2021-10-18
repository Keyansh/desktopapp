<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<section id="bredcrumbs">
    <div class=" container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <?php echo $breadcrumbs; ?>
                <li class="active"><a href="javascript:void(0)"><?= $product['name'] ?></a></li>
            </ul>
        </div>
    </div>
</section>


<section id="product-detail-section">
    <div class="container-fluid site-container">
        <div class="product-detail-section col-xs-12 padding-zero">
            <div class="product-inner-div col-xs-12 col-sm-6 padding-zero">
                <div class="owl-carousel owl-theme slider-images" id="product-detail-slider">

                    <?php
                    if ($multiImages) {
                        foreach ($multiImages as $item) {
                            if (file_exists($this->config->item('PRODUCT_PATH') . $item['img'])) {
                                // $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 97, 103, 'product-main-image');
                                $main_image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 453, 600, 'product-main-image');
                            } else {
                                // $image_url = resize(FCPATH . 'images/a1.jpg', 97, 103, 'product-main-image');
                                $main_image_url = resize(FCPATH . 'images/img-default.jpg', 453, 600, 'product-main-image');
                            }
                    ?>
                            <div class="item">
                                <a data-fancybox="gallery" href="<?= $main_image_url ?>">
                                    <img class="img-responsive product-img" src="<?= $main_image_url ?>" alt="<?= $item['imgalt'] ?>" data-imgid="<?= $item['sort_order']; ?>">
                                </a>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="item">
                            <a href="images/img-default.jpg" data-fancybox="gallery">
                                <img class="img-responsive product-img" src="images/img-default.jpg" alt="img">
                            </a>
                        </div>

                    <?php } ?>

                </div>

                <?php if (count($multiImages) > 1) { ?>
                    <div id="project-thumb-slider" class="owl-carousel owl-theme">
                        <?php if ($multiImages) { ?>
                            <?php foreach ($multiImages as $item) {
                                if (file_exists($this->config->item('PRODUCT_PATH') . $item['img'])) {
                                    // $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 97, 103, 'product-main-image');
                                    $main_image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 453, 600, 'product-main-image');
                                } else {
                                    // $image_url = resize(FCPATH . 'images/a1.jpg', 97, 103, 'product-main-image');
                                    $main_image_url = resize(FCPATH . 'images/img-default.jpg', 453, 600, 'product-main-image');
                                }
                            ?>
                                <div class="item ">
                                    <div class="product-thumb-div">
                                        <img class="img-responsive product-img" src="<?= $main_image_url ?>" alt="<?= $item['imgalt'] ?>" data-imgid="<?= $item['sort_order']; ?>">
                                    </div>
                                </div>
                            <?php }
                        } else {
                            ?>
                            <div class="item ">
                                <div class="product-thumb-div">
                                    <img src="images/img-default.jpg" alt="<?= $product['name'] ?>" class="img-responsive">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
            <div class="product-inner-text-div col-xs-12 col-sm-6 ">
                <div class="product-desc-div col-xs-12 padding-zero">
                    <h1 class="hardware-consort-heading product-heading"> <?= $product['cname'] ?> - <?= $product['name'] ?></h1>


                    <form name="cart_frm" method="post" action="" id="cart_frm">
                        <div class="attributesContainer col-xs-12 detail-page padding-zero">
                            <input type="hidden" name="pid" value="<?php echo $product['product_id'] ?>" />
                            <input type="hidden" name="cid" value="<?php echo $product['cid'] ?>" />
                            <input type="hidden" id="refresh" value="no">
                            <ul class="product-text-div col-xs-12 padding-zero">
                                <?php $getProductBulletPoints = getProductBulletPoints($product['product_id']);
                                foreach ($getProductBulletPoints as $bulletPoints) { ?>
                                    <li><?= $bulletPoints['bullet_points'] ?></li>
                                <?php } ?>
                                <li>
                                    <?php
                                    if (!empty($assigned_attrs)) {
                                    ?>
                                        <?php foreach ($assigned_attrs as $key => $attributes) {
                                            $OptionLable = OptionLable($key);
                                            if ($OptionLable['front_view'] == 'list') { ?>
                                                <ul class="product-listing-div list-inline">
                                                    <li class="product-attr-label"><?php echo $OptionLable['label']; ?></li>
                                                    <?php foreach ($attributes as $attribute) { ?>
                                                        <li>
                                                            <?php if ($attribute['option']) { ?>
                                                                <?php echo $attribute['option']; ?>
                                                            <?php } ?>
                                                            <?php if ($attribute['icon']) { ?>
                                                                <span>
                                                                    <img src="<?= $this->config->item('ATTRIBUTE_OPTION_ICON_URL') . $attribute['icon']; ?>" class="img-responsive" />
                                                                </span>
                                                            <?php } ?>

                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>

                                </li>
                                <li style="list-style: none;background: none;">
                                    <?php

                                    if (!empty($assigned_attrs)) {
                                    ?>
                                        <?php foreach ($assigned_attrs as $key => $attributes) {
                                            $OptionLable = OptionLable($key);
                                            if ($OptionLable['front_view'] == 'dropdown') { ?>

                                                <div class="product-listing-div ">
                                                    <p class="product-attr-label selectoption"><?php echo $OptionLable['label']; ?></p>
                                                    <select name="<?php echo str_replace(" ", "_", $OptionLable['label']); ?>" id="" class="form-control">
                                                        <?php foreach ($attributes as $attribute) { ?>
                                                            <option>
                                                                <?php if ($attribute['option']) { ?>
                                                                    <?php echo $attribute['option']; ?>
                                                                <?php } ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        <?php }
                                        } ?>
                                    <?php } ?>

                                </li>
                            </ul>
                        </div>


                        <div class="qut-select-log col-xs-12">

                            <div class="product_select " style="display: none !important;">
                                <button type="button" class="altera decrescimo btn-number nn-style-btn-min" data-field="quantity" data-type="minus">-</button>
                                <input id="txtAcrescimo" class="quantity1_unique input-number txtAcrescimo" name="quantity" value="1" min="1" max="50000" type="text" />
                                <button type="button" class="altera acrescimo btn-number nn-style-btn-plus" data-field="quantity" data-type="plus">+</button>
                            </div>
                            <?php if (isset($product['product_stock_status']) && $product['product_stock_status'] == 0) { ?>
                                <div class="div-btn-out"><a class="" href="javascript:void(0)">OUT OF STOCK</a></div>
                            <?php } elseif (isset($product['product_stock_status']) && $product['product_stock_status'] == 1) { ?>
                                <div class="div-btn-out"><a class="" href="javascript:void(0)">COMING SOON !</a></div>
                                <?php
                            } else {
                                if ($product['type'] == 'config') {
                                    if (!child_stock($product['product_id'])) {
                                ?>
                                        <div class="div-btn-out"><a class="" href="javascript:void(0)">SOLD OUT</a></div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="div-btn-out wishlist-btn-div" id="cart-submit"><a class=" wishlist-btn" href="javascript:void(0)">Add to Wishlist </div>
                                        <div class="div-btn-out"><a href="<?= base_url() . "cart/"; ?>" class="checkout-btn  wishlist-btn proceed-btn" style="display: none;">Proceed to Wishlist</a></div>

                                    <?php
                                    }
                                } else {
                                    if ($product['quantity'] == 0) {
                                    ?>
                                        <div class="div-btn-out"><a class="" href="javascript:void(0)">SOLD OUT</a></div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="div-btn-out" id="cart-submit"><a class=" wishlist-btn" href="javascript:void(0)">Add to Wishlist </a></div>
                                        <div class="div-btn-out"><a href="<?= base_url() . "cart/"; ?>" class="checkout-btn wishlist-btn proceed-btn wishlist-proceed" style="display: none;">Proceed to Wishlist</a></div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>

                    </form>
                    <!-- <?php //if ($product['line_drowing']) { 
                            ?>
                        <div class="dimension-main-img-div col-xs-12">
                            <img src="<?= $this->config->item('LINE_DROWING_URL') . $product['line_drowing'] ?>" alt="dimensions-alt" class="dimensions-img img-responsive">
                        </div>
                    <?php //} 
                    ?> -->
                    <div class="pdf-link-div col-xs-12 padding-zero">
                        <?php if ($product['certification']) { ?>
                            <div class="pdf-main-div col-xs-12 col-sm-6">
                                <a href="<?= $this->config->item('PDF_URL') . $product['certification'] ?>" target="blank" style="display: inherit;">
                                    <div class="pdf-inner-div">
                                        <img src="images/adobe.png" alt="adobe-alt" class="adobe-img">
                                    </div>
                                    <p class="download-text">Download Certification</p>
                                </a>
                            </div>
                        <?php } ?>
                        <?php if ($product['datasheet']) { ?>
                            <div class="pdf-main-div col-xs-12 col-sm-6">
                                <a href="<?= $this->config->item('PDF_URL') . $product['datasheet'] ?>" target="blank" style="display: inherit;">
                                    <div class="pdf-inner-div">
                                        <img src="images/adobe.png" alt="adobe-alt" class="adobe-img">
                                    </div>
                                    <p class="download-text">Download DataSheet</p>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function() {

        var sync1 = $("#product-detail-slider");
        var sync2 = $("#project-thumb-slider");
        var slidesPerPage = 4; //globaly define number of elements per page
        var syncedSecondary = true;

        sync1.owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: false,
            // autoplay: true,
            dots: false,
            loop: false,
            margin: 10,
            responsiveRefreshRate: 200,

        }).on('changed.owl.carousel', syncPosition);

        sync2
            .on('initialized.owl.carousel', function() {
                sync2.find(".owl-item").eq(0).addClass("current");
            })
            .owlCarousel({
                items: 4,
                dots: false,
                nav: false,
                smartSpeed: 200,
                slideSpeed: 500,
                slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                responsiveRefreshRate: 100
            }).on('changed.owl.carousel', syncPosition2);

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            var current = el.item.index;

            //if you disable loop you have to comment this block
            // var count = el.item.count - 1;
            // var current = Math.round(el.item.index - (el.item.count / 2) - .5);

            // if (current < 0) {
            //     current = count;
            // }
            // if (current > count) {
            //     current = 0;
            // }

            //end block

            sync2
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = sync2.find('.owl-item.active').length - 1;
            var start = sync2.find('.owl-item.active').first().index();
            var end = sync2.find('.owl-item.active').last().index();

            if (current > end) {
                sync2.data('owl.carousel').to(current, 100, true);
            }
            if (current < start) {
                sync2.data('owl.carousel').to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
                var number = el.item.index;
                sync1.data('owl.carousel').to(number, 100, true);
            }
        }

        sync2.on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).index();
            sync1.data('owl.carousel').to(number, 300, true);
        });
    });
</script>

<?php if ($product['is_like_active'] == 1) { ?>
    <?php
    $getProductAssigned = getProductAssigned($product['product_id']);
    if ($getProductAssigned) { ?>
        <section id="architectural-section">
            <div class="container-fluid site-container">
                <div class="architectural-section col-xs-12 padding-zero">
                    <p class="hardware-consort-heading ">You may also like</p>
                    <div id="you-may-like-product" class="owl-carousel owl-theme col-xs-12">
                        <?php foreach ($getProductAssigned as $item) { ?>
                            <div class="item">
                                <div class="hardware-product-div">
                                    <a href="<?= $item['uri'] ?>">
                                        <div class="hardware-inner-div">
                                            <?php
                                            $getproductMainImage = getproductMainImage($item['id']);
                                            ?>
                                            <?php

                                            if (file_exists($this->config->item('PRODUCT_PATH') . $getproductMainImage['img']) && $getproductMainImage['img']) {
                                                $image_url = resize($this->config->item('PRODUCT_PATH') . $getproductMainImage['img'], 314, 419, 'product-listing-img');
                                            } else {
                                                $image_url = resize(FCPATH . 'images/img-default.jpg', 314, 419, 'product-listing-img');
                                            }
                                            ?>
                                            <img src="<?php echo $image_url ?>" alt="banner-alt" class="img-responsive">
                                        </div>
                                        <p class="hardware-product-text"><?= $item['name'] ?></p>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#you-may-like-product').owlCarousel({
            loop: false,
            margin: 10,
            nav: false,
            dots: false,
            items: 4,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 4
                }
            }
        })
    });
</script>

<!-- <section id="product-detail-tab-section">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product-detail-tabs-main-col null-padding">

            <ul class="nav nav-pills product-tab-list">
                <?php if (isset($product['description']) && $product['description']) { ?>
                    <li>
                        <a data-toggle="pill" href="#tab_product_information">
                            <span>
                                <img src="images/prd-info.png" class="img-responsive black-icon" />
                                <img src="images/prd-info-white.png" class="img-responsive white-icon" />
                            </span>
                            Product <br />Information
                        </a>
                    </li>
                <?php } ?>
                <?php if (isset($product['delivery_information']) && $product['delivery_information']) { ?>
                    <li>
                        <a data-toggle="pill" href="#tab_delivery_information">
                            <span>
                                <img src="images/prd-delivery.png" class="img-responsive black-icon" />
                                <img src="images/prd-delivery-white.png" class="img-responsive white-icon" />
                            </span>
                            Delivery <br />Information
                        </a>
                    </li>
                <?php } ?>
                <?php if (isset($product['technical_specification']) && $product['technical_specification']) { ?>
                    <li>
                        <a data-toggle="pill" href="#tab_technical_specification">
                            <span>
                                <img src="images/prd-tech-black.png" class="img-responsive black-icon" />
                                <img src="images/prd-tech.png" class="img-responsive white-icon" />
                            </span>
                            Technical <br />Specification
                        </a>
                    </li>
                <?php } ?>
                <?php if (isset($product['packaging']) && $product['packaging']) { ?>
                    <li>
                        <a data-toggle="pill" href="#tab_packaging">
                            <span>
                                <img src="images/prd-packaging.png" class="img-responsive black-icon" />
                                <img src="images/prd-packaging-white.png" class="img-responsive white-icon" />
                            </span>
                            Packaging
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <div class="tab-content">
                <?php if (isset($product['description']) && $product['description']) { ?>
                    <div id="tab_product_information" class="tab-pane fade in active">
                        <?php echo $product['description']; ?>
                    </div>
                <?php } ?>
                <?php if (isset($product['delivery_information']) && $product['delivery_information']) { ?>
                    <div id="tab_delivery_information" class="tab-pane fade">
                        <?php echo $product['delivery_information']; ?>
                    </div>
                <?php } ?>
                <?php if (isset($product['technical_specification']) && $product['technical_specification']) { ?>
                    <div id="tab_technical_specification" class="tab-pane fade">
                        <?php echo $product['technical_specification']; ?>
                    </div>
                <?php } ?>
                <?php if (isset($product['packaging']) && $product['packaging']) { ?>
                    <div id="tab_packaging" class="tab-pane fade">
                        <?php echo $product['packaging']; ?>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</section> -->
<?php if ($product['is_like_active'] == 0) { ?>
    <section id="you-may-also-like-product">
        <?php $this->load->view('themes/' . THEME . '/layout/inc-you-may-like');
        ?>
    </section>
<?php } ?>
<!--my html end-->
<script type="text/javascript">
    $(document).ready(function(e) {
        var $input = $('#refresh');
        $input.val() == 'yes' ? location.reload(true) : $input.val('yes');
        setTimeout(function() {
            $('.product-tab-list li:first-child a').trigger('click');
        }, 1000);
    });
</script>

<script>
    //Get Tier Price
    $("#txtAcrescimo").on('change', function() {

        getTierPrice(this);
    });

    function getTierPrice(oj) {
        var qty = oj.value;
        var pid = '<?php echo $product['product_id'] ?>';
        var price = '<?php echo $product['price'] ?>';

        $.post('catalog/ajax/Product/tierPrice', {
            "pid": pid,
            "qty": qty,
            "price": price
        }, function(data2) {
            if (data2 != null) {
                $('.tier-price-effect').text(data2.tier_price);
                $('.tier-price-plus-vat').text(data2.tier_price_plus_vat);
                $('.tier-table > table > tbody > tr').removeClass('active');
                $('.tier-active-' + data2.tier_id).addClass('active');
            }
        }, 'JSON');
    }
</script>
<script type="text/javascript">
    var prodURl = "catalog/product/<?php echo $product['uri']; ?>";
    $("#cart_frm").on('submit', function(e) {

        e.preventDefault();
        var serializedData = $(this).serialize();
        $.post(prodURl, serializedData, function(data) {
            if (data.cartItem['options'] != '' && data.cartItem['settings'] != "") {

                $(".checkout-btn").css("display", "table");
                // $.notify(data.cartItem['options'], data.cartItem['settings']);
                if (data.cartCnt != '') {
                    $('.count-of-wishlist').html(data.cartCnt).change();
                    $('#total-cart-price').html(data.cart_total_price).change();
                }
                gtag('event', 'add_to_cart', {
                    "items": data.jsonItem
                });
            }

        }, 'JSON');
    });
    $(document).on('click', '#viewSiz', function() {
        $('#proDescription').removeClass('active in');
        $('.prod-description .nav-tabs>li').removeClass('active');
        $('#sizechart').addClass('active in');
        $('.prod-description .nav-tabs>li:nth-child(2)').addClass('active');
        $('html,body').animate({
                scrollTop: $("#sizechart").offset().top - 75
            },
            'slow');
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#product-enquiry-submit-btn').click(function() {
            var fname = ($('#expert-form #fname').val()).trim();
            var lname = ($('#expert-form #lname').val()).trim();
            var email = ($('#expert-form #email').val()).trim();
            var phone = ($('#expert-form #phone').val()).trim();
            var message = ($('#expert-form #message').val()).trim();
            var product_id = ($('#expert-form #product-id').val()).trim();

            if ((fname && message) && (email || phone)) {
                $.post('<?php echo base_url() ?>catalog/ajax/product/expert_enquiry', {
                        fname: fname,
                        lname: lname,
                        email: email,
                        phone: phone,
                        message: message,
                        product_id: product_id
                    },
                    function(data, status) {
                        if (data == 'done') {
                            $('#expert-form #reply').text('Your enquiry is successfully submitted.');
                            window.location.href = "contact-us/thank-you";
                        } else {
                            $('#expert-form #reply').text('Your enquiry could not be submitted. Please try later.');
                        }
                    });
            } else {
                alert('Please fill all mandatory fields !');
            }
        });

        $('#wishlist-li-btn').click(function() {
            var customer_id = '<?php
                                if ($customer && ($customer["user_is_active"] == 1)) {
                                    echo $customer["user_id"];
                                }
                                ?>';
            var current_element = $(this);

            if (customer_id) {
                $.post('wishlist/toggle', {
                        customer_id: customer_id,
                        product_id: current_element.attr('data-product-id')
                    },
                    function(data, status) {
                        //                            current_element = current_element.find('img');

                        if (data == 'added') {
                            $("#wishlistModal").modal("show");
                            $(".modal-title").html("Product Added To Your Wishlist ").css('color', 'green');
                            //                                current_element.attr('src', 'images/icon/heart-icon-range2.png');
                            current_element.html('<span style="color:#ff6c00;" ><i class="fa fa-heart fa-2x" aria-hidden="true"></i></span>');
                        } else {
                            $("#wishlistModal").modal("show");
                            $(".modal-title").html("Product Removed From Your Wishlist ").css('color', 'red');
                            //                                current_element.attr('src', 'images/icon/heart-icon-range.png');
                            current_element.html('<span><i class="fa fa-heart-o fa-2x" aria-hidden="true"></i></span>');
                        }
                    });
            } else {
                alert('Please sign-in first !');
            }
        });

        $('#social-ul-toggle').click(function() {
            $('#social-icons-li').toggleClass('social-active');
        });
    });
</script>

<style>
    .form-right-area ul li {
        display: inline-block;
    }
</style>

<script>
    $('.btn-number').click(function(e) {
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {
                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    //                    $(this).attr('disabled', true);
                }
            } else if (type == 'plus') {
                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }
            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
    });
    // $('.input-number').change(function () {

    //     minValue = parseInt($(this).attr('min'));
    //     maxValue = parseInt($(this).attr('max'));
    //     valueCurrent = parseInt($(this).val());

    //     name = $(this).attr('name');
    //     if (valueCurrent >= minValue) {
    //         $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    //     } else {
    //         alert('Sorry, the minimum value was reached');
    //         $(this).val($(this).data('oldValue'));
    //     }
    //     if (valueCurrent <= maxValue) {
    //         $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    //     } else {
    //         alert('Sorry, the maximum value was reached');
    //         $(this).val($(this).data('oldValue'));
    //     }
    // });
    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $(document).on("click", "#cart-submit", function() {
        console.log($('#txtAcrescimo').val());
        var moq = parseInt('<?php echo $product['moq'] ?>');
        if ($('#txtAcrescimo').val() < moq) {
            $('#add-to-cart-errors').show();
        } else {
            $('#add-to-cart-errors').hide();
            $("#cart_frm").submit();
        }

    });
    $(".link-product-dics.log-in-review-already").click(function(event) {
        event.preventDefault();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#dic-el").offset().top
        }, 1000);
    });
</script>
<script type="text/javascript" src="js/tier_model.js"></script>
<script>
    gtag('event', 'view_item', {
        "items": [<?php echo $jsonItem; ?>]
    });
</script>

<script>
    $(document).ready(function() {
        $('.product-video-thumb').click(function() {
            var prodVideoSrc = $(this).find('iframe').attr('src');
            $('#prodVideoModal').find('iframe').attr('src', prodVideoSrc);
            $('#prodVideoModal').modal('show');
        });
        $("#prodVideoModal").on("hidden.bs.modal", function() {
            $("#prodVideoModal").find('iframe').attr('src', '');
        });
    });
    $('[data-fancybox="gallery"]').fancybox({
        loop: true,
    });
</script>