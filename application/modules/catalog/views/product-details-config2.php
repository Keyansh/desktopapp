<script src="<?= base_url() ?>js/jsonQ.min.js"></script>

<style>

    .modal-header {

        background: #ff6c00;

    }

    #review-submit-btn {

        background: #ff6c00;

        border: none;

    }



    .modal-header .close {

        color: white;

    }

    .custom-input {

        padding: 0;

    }

    .custom-input input{

        width: auto !important;

        display: none;

    }

    .custom-input input:checked ~ span:before{

        opacity: 1;

    }

    .custom-input span::before {

        content: " ";

        /* content: "\f00c"; */

        font-family: FontAwesome;

        left: 50%;

        position: absolute;

        top: 6px;

        transform: translate(-50%);

        color: white;

        opacity: 0;

    }

    .custom-input span {

        position: relative;

        display: table;

    }

    input[type="radio"][disabled] + span {

        border-color: #e8e8e8;

        cursor: not-allowed;

        opacity: 0.35;

        filter: alpha(opacity=35); /* For IE8 and earlier */

    }

    .filter-head-ul .list-inline-item>span.erat {

        color: red;font-size: 12px;

        display: none;

    }

    .dis,.dis + span {

        border-color: #e8e8e8;

        opacity: 0.35;

        filter: alpha(opacity=35); /* For IE8 and earlier */

    }

    select option.dis {

        color: #aaa;

    }

    /*review css*/

    .user-reviews {

        border-bottom: 1px solid #d3d3d3;

        display: table;

        margin: 0 0 20px;

        padding: 15px;

        width: 100%;

    }

    .user-review:last-child{

        border-color: transparent;

    }

    .user-review .user-ul li.user-name {

        font-size: 18px;

        color: grey;

        display: block;

        text-transform: capitalize;

    }

    .stars_col li{

        padding: 0pc;     

    }

    .three-five {

        font-size: 15px;

        color: #A0A0A0;

        padding-left: 5px !important;

    }

    .border-none{

        border:none !important;

    }

    .font-size{

        font-size:20px

    }

    .font-weight{

        font-weight:bolder;

        font-size:20px;

        cursor: pointer;

    }

    /*review css*/

</style>

<script>

    var options = {

        caseSensitive: true,

        shouldSort: true,

        includeScore: true,

        includeMatches: true,

        threshold: 0.6,

        location: 0,

        distance: 100,

        maxPatternLength: 32,

        minMatchCharLength: 1,

        keys: ['attr_id', 'id', 'products']

    };

    //var fuse = new Fuse(<?php echo json_encode($childattributes); ?>, options);

    var arrCount = '<?php echo count($attributesIDs); ?>';

    var parentID = '<?php echo $product['product_id']; ?>';

    var childPrice = '<?php echo $childPrice['price']; ?>';

</script>



<section id="single_product_col">

    <div class="container-fluid null-padding">

        <div class="col-xs-12 product_main_div null-padding">

            <ul class="breadcrumb">

                <li><a href="<?= base_url(); ?>">Home</a></li>

                <li class="active"><a href="<?= base_url() . $product['uri']; ?>"><?= $product['name'] ?></a></li>

            </ul>

        </div>

        <div class="col-xs-12 product_inner_col">

            <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 product_left_div">

                <?php

                $addclass = "";

                if (count($multiImages) == 1) {

                    $addclass = "img-ul-display"

                    ?>



                <?php } ?>

                <div class="col-xs-12 col-md-4 col-lg-4 col-sm-4 text-center ng-height-jq <?= $addclass ?>">

                    <ul id="slideshow3_thumbs" class="desoslide-thumbs-vertical list-inline">

                        <?php

                        if ($multiImages) {

                            $image_url = base_url() . "images/a1.jpg";

                            foreach ($multiImages as $item) {

                                if (file_exists($this->config->item('PRODUCT_PATH') . $item['img'])) {

                                    $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 97, 103, 'product-main-image');

                                    $main_image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 513, 548, 'product-main-image');

                                } else {

                                    $image_url = resize(FCPATH . 'images/a1.jpg', 97, 103, 'product-main-image');

                                    $main_image_url = resize(FCPATH . 'images/a1.jpg', 513, 548, 'product-main-image');

                                }

                                ?>

                                <li>

                                    <a href="<?= $main_image_url ?>" data-fancybox="gallery">

                                        <img class="img-responsive" src="<?= $image_url ?>" data-imgid="<?= $item['sort_order']; ?>" alt="<?= $item['imgalt'] ?>">

                                    </a>

                                </li>

                                <?php

                            }

                        } else {

                            ?>

                            <li>

                                <a href="<?= base_url() ?>images/a1.jpg">

                                    <img class="img-responsive" src="<?= base_url() ?>images/a1.jpg" alt="city">

                                </a>

                            </li>

                            <?php

                        }

                        ?>

                    </ul>

                </div>

                <div class="main-div-over-img append-popup-img">

                    <div class="append-content">

                        <a onclick="main_image()" href="images/a1.jpg" data-fancybox="gallery" class="pro-detail-img sorce-image"></a>

                    </div>

                    <div id="slideshow3" class="col-xs-8 col-md-8 col-lg-8 col-sm-8 pro_right"></div>

                </div>



            </div>

            <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 product_right_div">

                <p class="product-sku"><?= $product['sku'] ?></p>

                <p class="product-name-detail"><?= $product['name'] ?> </p>

                <?php

                if ($avgrate) {

                    ?>

                    <ul class="list-inline stars_col instock">

                        <?php

                        if ($avgrate > 0) {

                            for ($i = 0; $i < $avgrate; $i++) {

                                ?>

                                <li><img alt="Consort hardware" src="<?= base_url() . 'images/star-on.png' ?>"></li>

                                <?php

                            }

                            for ($i = $avgrate; $i < 5; $i++) {

                                ?>

                                <li><img alt="Consort hardware" src="<?= base_url() . 'images/star-off.png' ?>"></li>

                                <?php

                            }

                            ?>

                            <li class="three-five">

                                <?php

                                echo $avgrate . '/5';

                                ?>

                            </li>

                            <?php

                        }

                        ?>

                    </ul>

                    <?php

                }

                ?>



                <?php

                if ((isLogged()) && (checkReviewedUser($this->session->userdata('CUSTOMER_ID'), $product['product_id']))) {

                    ?>

                    <p class="review-25"><a href="javascript:void(0)" class="1 log-in-review-already">You have already reviewed</a></p>

                    <?php

                } else if ((isLogged()) && (!checkReviewedUser($this->session->userdata('CUSTOMER_ID'), $product['product_id']))) {

                    ?>

                    <div id='reviewWrite' class="add-reviews">

                        <span id="write-your-review">

                            <a href="javascript:void(0)" class="review-25 log-in-review-already" data-toggle="modal" data-target="#review-model">Write the first review</a>

                        </span>

                    </div>

                    <?php

                } else {

                    ?>

                    <p class="red-tooltip log-in-review-already"  >

                        <a href="<?= base_url() ?>customer/login?ref=<?= $product['uri'] ?>" class="nn-style-log-log-riv">

                            login to add review

                        </a>

                    </p>

                    <?php

                }

                if ($product['description']) {

                    ?>

                    <p><a href="" class="link-product-dics log-in-review-already">Product description</a></p>

                    <?php

                }

                $pPrice = 0;

                if ($product['price'] > 0) {

                    $pPrice = $product['price'];

                } else {

                    $pPrice = $childPrice['price'];

                }

//                if ($this->session->userdata('CUSTOMER_ID')) {

                if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {

                    if ($product['is_offer_discount']) {

                        echo "<p data-actual-price='{$product['is_offer_discount']}' class='product_price detail-page-product-price'>";

                        echo DWS_CURRENCY_SYMBOL . '<price>' . number_format($product['is_offer_discount'], 2) . '</price>';

                      

                        echo DWS_CURRENCY_SYMBOL . '<span class="price-span strip-price">' . number_format($pPrice, 2) . '</span><br>';

                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($product['is_offer_discount'] + $product['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';

                        echo "</p>";

                    } else {

                        echo "<p data-actual-price='$pPrice' class='product_price detail-page-product-price'>";

                        // hidden price

                        echo "<input class='price-span-hidden' type='hidden' value='". number_format($pPrice, 2) ."'>";

                        echo "<input class='your-price-hidden' type='hidden' value='".'('. DWS_CURRENCY_SYMBOL . number_format(($pPrice + $pPrice * DWS_TAX / 100), 2) . ' '  .'Inc. VAT)'."'>";

                        // hidden price

                        echo DWS_CURRENCY_SYMBOL . '<price class="price-span">' . number_format($pPrice, 2) . '</price><br>';

                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($pPrice + $pPrice * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';

                        echo "</p>";

                    }

                } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {

                    if ($product['is_offer_discount']) {

                        $var = number_format(($product['is_offer_discount'] + $product['is_offer_discount'] * DWS_TAX / 100), 2);

                        echo "<p data-actual-price='$var' class='product_price detail-page-product-price'>";

                        echo DWS_CURRENCY_SYMBOL . '<price>' . $var . '</price>';

                        echo DWS_CURRENCY_SYMBOL . '<span class="price-span strip-price">' . number_format($pPrice, 2) . '</span><br>';

                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($product['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';

                        echo "</p>";

                    } else {

                        $var1 = number_format(($pPrice + $pPrice * DWS_TAX / 100), 2);

                        echo "<p data-actual-price='$var1' class='product_price detail-page-product-price'>";

                         // hidden price

                         echo "<input class='price-span-hidden' type='hidden' value='". $var1 ."'>";

                         echo "<input class='your-price-hidden' type='hidden' value='".'('. DWS_CURRENCY_SYMBOL . number_format($pPrice, 2) . ' '  .'Excl. VAT)'."'>";

                         // hidden price

                        echo DWS_CURRENCY_SYMBOL . '<price class="price-span">' . $var1 . '</price><br>';

                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($pPrice, 2) . ' ' . 'Excl. VAT)</span>';

                        echo "</p>";

                    }

                } else {

                    if ($product['is_offer_discount']) {

                        echo "<p data-actual-price='{$product['is_offer_discount']}' class='product_price detail-page-product-price'>";

                        echo DWS_CURRENCY_SYMBOL . '<price>' . number_format($product['is_offer_discount'], 2) . '</price>';

                        echo DWS_CURRENCY_SYMBOL . '<span class="price-span strip-price">' . number_format($pPrice, 2) . '</span><br>';

                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($product['is_offer_discount'] + $product['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';

                        echo "</p>";

                    } else {

                        echo "<p data-actual-price='$pPrice' class='product_price detail-page-product-price'>";

                        // hidden price

                        echo "<input class='price-span-hidden' type='hidden' value='". number_format($pPrice, 2) ."'>";

                        echo "<input class='your-price-hidden' type='hidden' value='".'('. DWS_CURRENCY_SYMBOL . number_format(($pPrice + $pPrice * DWS_TAX / 100), 2) . ' '  .'Inc. VAT)'."'>";

                        // hidden price

                        echo DWS_CURRENCY_SYMBOL . '<price class="price-span">' . number_format($pPrice, 2) . '</price><br>';

                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($pPrice + $pPrice * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';

                        echo "</p>";

                    }

                }

//                }

                ?>

                <!--code form cart-->

                <form name="cart_frm" method="post" action="" id="cart_frm">

                    <ul class="list-inline quantity_ul">

                        <div class="attributesContainer">

                            <input type="hidden" name="ptype" value="config">

                            <input type="hidden" name="pid" value="<?php echo $product['product_id']; ?>">

                            <?php

                            $counter = 0;

                            if (count($childattributes) >= 1) {

                                foreach ($childattributes as $keyAt => $attrValArr) {

                                    ?>

                                    <div class="product-filters attribute rp8si-info-div product-<?php echo lcfirst($attrValArr['label']); ?>-selection">

                                        <ul class="list-inline filter-head-ul">

                                            <li class="list-inline-item">

                                                <span><?php echo!empty($attrCustomNames[$keyAt]) ? $attrCustomNames[$keyAt] : $attrValArr['label']; ?></span>

                                                <span class="erat error-<?php echo $keyAt; ?>">Please select <?php echo $attrValArr['label']; ?></span>

                                            </li>

                                            <li class="prod-detail list-inline-item">

                                                <?php

                                                $options = $attrValArr['options'];

                                                if ($attrValArr['type'] == "dropdown") {

                                                    ?>

                                                    <select name="attributes[<?php echo $keyAt; ?>]" data-attrid="<?php echo $keyAt; ?>" class="abc atroptions">

                                                        <option value="">Select option</option>

                                                        <?php

                                                        if (count($options) > 0) {

                                                            foreach ($options as $opt) {

                                                                ?>

                                                                <option data-attop-id="<?php echo $opt['id']; ?>" data-name="<?php echo lcfirst($opt['value']); ?>-selection" class="atroptions atr-<?php echo $opt['id']; ?> <?php echo lcfirst($opt['value']); ?> abcradion" value="<?php echo $opt['value'] ?>" id="atopt-<?php echo $opt['id']; ?>">

                                                                    <?php echo $opt['value']; ?>

                                                                </option>

                                                                <?php

                                                            }

                                                        }

                                                        ?>

                                                    </select>

                                                <?php } else {

                                                    ?>

                                                    <span class="attr-<?php echo $attrValArr['attr_id']; ?>" data-blank-string="Select <?php echo $attrValArr['label']; ?>" data-attr-id="<?php echo $attrValArr['attr_id']; ?>"

                                                          data-attr-type="Attribute">

                                                              <?php

                                                              if (count($options) > 0) {

                                                                  foreach ($options as $opt) {

                                                                      ?>

                                                                <label class="radio-inline custom-input">

                                                                    <input type="radio" name="attributes[<?php echo $keyAt; ?>]" data-attrid="<?php echo $keyAt; ?>" data-attop-id="<?php echo $opt['id']; ?>" data-name="<?php echo lcfirst($opt['value']); ?>-selection" class="atroptions atr-<?php echo $opt['id']; ?> <?php echo lcfirst($opt['value']); ?> abcradion" value="<?php echo $opt['value'] ?>" id="atopt-<?php echo $opt['id']; ?>">

                                                                    <?php

                                                                    $Icon_Img = $this->config->item('ATTRIBUTE_OPTION_ICON_PATH') . $opt['icon'];

                                                                    $title = $opt['value'];

                                                                    if ($opt['icon'] && file_exists($Icon_Img)) {

                                                                        $iMAge = $this->config->item('ATTRIBUTE_OPTION_ICON_URL') . $opt['icon'];

                                                                    } else {

                                                                        $iMAge = base_url() . "images/default-icon.jpg";

                                                                    }

                                                                    ?>

                                                                    <span title="<?php echo $title; ?>" data-toggle="tooltip" data-placement="top"><img src="<?= $iMAge; ?>" class="img-responsive"></span>

                                                                </label>

                                                                <?php

                                                            }

                                                        }

                                                        ?>

                                                    </span>

                                                <?php } ?>

                                            </li>

                                        </ul>

                                    </div>

                                    <?php

                                }

                            }

                            ?>

                        </div>

                    </ul>

                    <?php

                    if ($this->session->userdata('CUSTOMER_ID')) {

                        $group_id = user_group_id($this->session->userdata('CUSTOMER_ID'));

                        $group_by_prices = group_by_prices($product['product_id'], $group_id);

                        if ($group_by_prices) {

                            $user_assigned_category = display_group_prices_acc_to_category($this->session->userdata('CUSTOMER_ID'), $product['product_id']);

                            if ($user_assigned_category == 1) {

                                ?>

                                <ul class="list-inline quantity_ul">

                                    <li>Group Prices</li>

                                    <?php foreach ($group_by_prices as $g_prices) { ?>

                                        <li class="border-none">

                                            <?php

                                            if ($g_prices['qty_from'] && $g_prices['qty_to']) {

                                                echo $g_prices['qty_from'] . ' ' . '-' . ' ' . $g_prices['qty_to'] . '</br>';

                                            } else {

                                                echo $g_prices['qty_from'] . '+' . '</br>';

                                            }

                                            if (preg_match("/[a-z]/i", $g_prices['qty_range_val'])) {

                                                echo "<span  tier_model_attr='{$g_prices['qty_from']}' onclick='tier_model(this)' class='font-weight'>" . $g_prices['qty_range_val'] . "</span>";

                                            } else {

                                                echo "<span class='font-size'>" . DWS_CURRENCY_SYMBOL . number_format($g_prices['qty_range_val'], 2) . "</span>";

                                            }

                                            ?>

                                        </li>

                                    <?php } ?>

                                </ul>

                                <?php

                            } elseif ($user_assigned_category == 0) {

//                               no group price

                                ?>

                            <?php } else {

                                ?>

                                <ul class="list-inline quantity_ul">

                                    <li>Group Prices</li>

                                    <?php foreach ($group_by_prices as $g_prices) { ?>

                                        <li class="border-none">

                                            <?php

                                            if ($g_prices['qty_from'] && $g_prices['qty_to']) {

                                                echo $g_prices['qty_from'] . ' ' . '-' . ' ' . $g_prices['qty_to'] . '</br>';

                                            } else {

                                                echo $g_prices['qty_from'] . '+' . '</br>';

                                            }

                                            if (preg_match("/[a-z]/i", $g_prices['qty_range_val'])) {

                                                echo "<span  tier_model_attr='{$g_prices['qty_from']}' onclick='tier_model(this)' class='font-weight'>" . $g_prices['qty_range_val'] . "</span>";

                                            } else {

                                                echo "<span class='font-size'>" . DWS_CURRENCY_SYMBOL . number_format($g_prices['qty_range_val'], 2) . "</span>";

                                            }

                                            ?>

                                        </li>

                                    <?php } ?>

                                </ul>

                                <?php

                            }

                        }

                    }

                    ?>
                        <?php if ($product['quantity_per_pack']) { ?>

                        <ul class="list-inline quantity_ul">

                            <li><?= $product['quantity_per_pack'] ?> Pieces Per Pack</li>

                        </ul>

                        <?php } ?>
                    <!--code end cart form-->

                    <div class="qut-select-log " style="margin-bottom:5px">

                        <div class="product_select div-btn-out">

                            <button type="button" class="altera decrescimo btn-number nn-style-btn-min" data-field="quantity" data-type="minus" >-</button>

                            <input class="quantity1_unique input-number" name="quantity" value="1" min="1" max="100" type="text" id="txtAcrescimo"/>

                            <button type="button" class="altera acrescimo btn-number nn-style-btn-plus" data-field="quantity" data-type="plus" >+</button>

                        </div>

                        <?php

                        if ($product['type'] == 'config') {

                            if (!child_stock($product['product_id'])) {

                                ?>

                                <div class="div-btn-out"><a class="common_button" href="javascript:void(0)">OUT OF STOCK</a></div>

                                <?php

                            } else {

                                ?>

                                <div class="div-btn-out"><a class="common_button" id="cart-submit" href="javascript:void(0)">ADD TO CART</a></div>

                                <div class="div-btn-out" style="border:none;"><a id="add_to_procced" href="<?= base_url() . "checkout/"; ?>" class="checkout-btn common_button" style="display: none;">Proceed to Checkout</a></div>
                                
                                <div class="div-btn-out conti-shop-details">
                                    <a href="<?= base_url(); ?>" class="checkout-btn common_button" style="display: none;">Continue Shopping</a>
                                </div>

                                <?php

                            }

                        } else {

                            if ($product['quantity'] == 0) {

                                ?>

                                <div class="div-btn-out" ><a class="common_button" href="javascript:void(0)">OUT OF STOCK</a></div>

                                <?php

                            } else {

                                ?>

                                <div class="div-btn-out"><a class="common_button" id="cart-submit" href="javascript:void(0)">ADD TO CART</a></div>

                                <div class="div-btn-out" style="border:none;"><a id="add_to_procced" href="<?= base_url() . "checkout/"; ?>" class="checkout-btn common_button" style="display: none;">Proceed to Checkout</a></div>
                                
                                <div class="div-btn-out conti-shop-details">
                                    <a href="<?= base_url(); ?>" class="checkout-btn common_button" style="display: none;">Continue Shopping</a>
                                </div>

                                <?php

                            }

                        }

                        ?>

<!--<div class="div-btn-out"><a class="common_button" href="customer/login?ref=<?= $product['uri'] ?>">Please Login to see prices</a></div>-->

                    </div>

                    

                    <?php if ( $product['mini_guide'] || $product['info_sheet'] || $product['safty_data_sheet'] ) { ?>

                    <div class="col-xs-12 pdf-section ">

                        <ul class="list-inline">

                            <?php if($product['mini_guide']) {?>

                        <li>

                            <a target="_blank" href="<?= $this->config->item('PDF_URL') .$product['mini_guide'] ?>">mini guide</a>

                        </li>

                            <?php } if($product['info_sheet']){?>

                        <li>

                            <a target="_blank" href="<?= $this->config->item('PDF_URL') .$product['info_sheet'] ?>">info sheet</a>

                        </li>

                        <?php }  if($product['safty_data_sheet']){?>

                        <li>

                            <a target="_blank" href="<?= $this->config->item('PDF_URL') .$product['safty_data_sheet'] ?>">safety data sheet</a>

                        </li>

                        <?php } ?>

                        </ul>

                    </div>

                    <?php } ?>



                </form>

            </div>

            <?php

            $addclass = "";

            if (count($multiImages) == 1) {

                $addclass = "social-icon-display"

                ?>



            <?php } ?>

            <div class="social-icon col-xs-12 <?= $addclass ?>">

                <ul class="list-inline">

                    <li>Share</li>

                    <li><img src="<?= base_url() ?>images/share-icon-img.png" alt="share"></li>

                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=&t=" title="Share on Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                    <li><a href="https://twitter.com/intent/tweet?" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=%20Check%20up%20this%20awesome%20content' + encodeURIComponent(document.title) + ':%20 ' + encodeURIComponent(document.URL)); return false;"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                    <li><a href="http://pinterest.com/pin/create/button/?url=&description=" target="_blank" title="Pin it" onclick="window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(document.URL) + '&description=' + encodeURIComponent(document.title)); return false;"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>

                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=&title=&summary=&source=" target="_blank" title="Share on LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' + encodeURIComponent(document.title)); return false;"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                </ul>

            </div>

        </div>

    </div>

</section>



<section id="product_description">

    <div class="container-fluid">

        <div class="col-xs-12 product_descr_col">

            <?php

            if ($product['brief_description'] || $product['description']) {

                $desc_exists = 1;

            } else {

                $desc_exists = 0;

            }

            if ($reviews && $desc_exists == 1) {

                ?>

                <ul class="nav nav-pills">

                    <li id="dic-el" class="common_heading active "><a data-toggle="pill" href="#home">product description </a></li>

                    <li class="common_heading "><a data-toggle="pill" href="#menu1"> reviews (<?= count($reviews) ?>) </a></li>

                </ul>

                <div class="tab-content">

                    <div id="home" class="tab-pane fade in active ">

                        <div class="des-content">

                            <?= $product['brief_description']; ?>

                        </div>

                        <div class="des-content">

                            <?= $product['description']; ?>

                        </div>

                    </div>

                    <div id="menu1" class="tab-pane fade">

                        <button style="float:right;" type="button" class="common_button modal-review-btn" data-toggle="modal" data-target="#review-model">Write a Review</button>

                        <div class="all-reviews-col">

                            <?php

                            if (isset($reviews)) {

                                if ($reviews) {

                                    $border = " ";

                                    if (count($reviews) == 1) {

                                        $border = 'border-remove';

                                    }

                                    foreach ($reviews as $item) {

                                        ?>

                                        <div class="user-reviews <?= $border ?>">

                                            <div class="single-review">

                                                <div class="user-review">

                                                    <ul class="list-inline user-ul">

                                                        <li class="user-name"><?php echo $item['name']; ?></li>

                                                        <li>

                                                            <ul class="list-inline stars_col">

                                                                <?php

                                                                if (isset($item['rate'])) {

                                                                    $temp = 5 - $item['rate'];

                                                                    for ($i = 0; $i < $item['rate']; ++$i) {

                                                                        ?>

                                                                        <li><img alt="Consort hardware" src="<?= base_url() . 'images/star-on.png' ?>"></li>

                                                                        <?php

                                                                    }

                                                                    while ($temp--) {

                                                                        ?>

                                                                        <li><img alt="Consort hardware" src="<?= base_url() . 'images/star-off.png' ?>"></li>

                                                                        <?php

                                                                    }

                                                                }

                                                                ?>

                                                            </ul>

                                                        </li>

                                                    </ul>

                                                    <p class="user-comment"><?php echo $item['review']; ?></p>

                                                </div>

                                            </div>

                                        </div>

                                        <?php

                                    }

                                } else {

                                    ?>

                                    <p>No review.</p>

                                    <?php

                                }

                            }

                            ?>

                        </div>

                    </div>

                </div>

            <?php } else { ?>

                <ul class="nav nav-pills">

                    <?php if ($product['brief_description'] || $product['description']) { ?>

                        <li id="dic-el" class="common_heading active "><a data-toggle="pill" href="#home">product description </a></li>

                    <?php } if ($reviews) { ?>

                        <li class="common_heading active "><a data-toggle="pill" href="#menu1"> reviews (<?= count($reviews) ?>) </a></li>

                    <?php } ?>

                </ul>

                <div <?= ($product['brief_description'] || $product['description'])?"":"style='border:none;'" ?> class="tab-content">

                    <?php if ($product['brief_description'] || $product['description']) { ?>

                        <div id="home" class="tab-pane fade in active ">

                            <div class="des-content">

                                <?= $product['brief_description']; ?>

                            </div>

                            <div class="des-content">

                                <?= $product['description']; ?>

                            </div>

                        </div>

                    <?php } if ($reviews) { ?>

                        <div id="menu1" class="tab-pane fade in active">

                            <button style="float:right;" type="button" class="common_button modal-review-btn" data-toggle="modal" data-target="#review-model">Write a Review</button>

                            <div class="all-reviews-col">

                                <?php

                                if (isset($reviews)) {

                                    $border = " ";

                                    if (count($reviews) == 1) {

                                        $border = 'border-remove';

                                    }

                                    if ($reviews) {

                                        foreach ($reviews as $item) {

                                            ?>

                                            <div class="user-reviews <?= $border ?>">

                                                <div class="single-review">

                                                    <div class="user-review">

                                                        <ul class="list-inline user-ul">

                                                            <li class="user-name"><?php echo $item['name']; ?></li>

                                                            <li>

                                                                <ul class="list-inline stars_col">

                                                                    <?php

                                                                    if (isset($item['rate'])) {

                                                                        $temp = 5 - $item['rate'];

                                                                        for ($i = 0; $i < $item['rate']; ++$i) {

                                                                            ?>

                                                                            <li><img alt="Consort hardware" src="<?= base_url() . 'images/star-on.png' ?>"></li>

                                                                            <?php

                                                                        }

                                                                        while ($temp--) {

                                                                            ?>

                                                                            <li><img alt="Consort hardware" src="<?= base_url() . 'images/star-off.png' ?>"></li>

                                                                            <?php

                                                                        }

                                                                    }

                                                                    ?>

                                                                </ul>

                                                            </li>

                                                        </ul>

                                                        <p class="user-comment"><?php echo $item['review']; ?></p>

                                                    </div>

                                                </div>

                                            </div>

                                            <?php

                                        }

                                    } else {

                                        ?>

                                        <p>No review.</p>

                                        <?php

                                    }

                                }

                                ?>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        </div>

    </div>

</section>



<section id="top_rated_products" class="top-product-con-lay-out">

    <?php $this->load->view('themes/' . THEME . '/layout/inc-top-rated-products'); ?>

</section>

<?php $this->load->view('themes/' . THEME . '/layout/inc-brand'); ?>

<?php $this->load->view('themes/' . THEME . '/layout/model'); ?>



<!--my code end-->

<script type="text/javascript">

    var TAX = '<?= DWS_TAX  ?>';

    var priceObj = {};

 

    var configData = <?php echo json_encode($childattributes); ?>;

    var configProducts = JSON.parse('<?php echo json_encode($productsChild); ?>');

    //var disabledArray = [];

    var countAttr = <?php echo count($childattributes); ?>;

    var mainAtrID = <?php echo isset($mainAttrID) ? $mainAttrID : 0; ?>;

    var finalCommon = [];

    function inArray(needle, haystack) {

        var length = haystack.length;

        for (var i = 0; i < length; i++) {

            if (haystack[i] == needle)

                return true;

        }

        return false;

    }



    function eliminate(pr, vid) {

        var commonProducts = [];

        var commonProductsFilter = [];

        finalCommon = [];

        //var disabledArray = [];

        var selectedArray = [];

        var selectedValues = [];

        // selectedArray.push(pr);

        $('select[name="attributes[' + pr + ']"] option').removeClass('dis');

        $('input[name="attributes[' + pr + ']"]').removeClass('dis');

        if (parseInt(countAttr) > 2) {

            jQuery("input[name^='attributes']:checked").each(function () {

                var va = $(this).data('attop-id');

                var par = $(this).data('attrid');

                var prodList = returnProducts(va);

                if (commonProducts.length > 0) {

                    commonProducts = jsonQ.intersection(commonProducts, prodList);

                } else {

                    commonProducts = prodList;

                }

                $(".error-" + par).hide();

                selectedValues.push(va);

                selectedArray.push(par);

            });

            jQuery("select[name^='attributes']").each(function () {

                if ($(this).val() != '') {

                    var va = $(this).find(':selected').data('attop-id');

                    var par = $(this).data('attrid');

                    var prodList = returnProducts(va);

                    if (commonProducts.length > 0) {

                        commonProducts = jsonQ.intersection(commonProducts, prodList);

                    } else {

                        commonProducts = prodList;

                    }

                    $(".error-" + par).hide();

                    //alert(par+" "+va);

                    selectedValues.push(va);

                    selectedArray.push(par);

                }

                //console.log(selectedValues);

            });

        } else if (parseInt(countAttr) == 2) {

            selectedArray.push(pr);

            var prodList = returnProducts(vid);

            commonProducts = prodList;

            jQuery("input[name^='attributes']:checked").each(function () {

                var va = $(this).data('attop-id');

                var par = $(this).data('attrid');

                var prodList = returnProducts(va);

                if (commonProductsFilter.length > 0) {

                    commonProductsFilter = jsonQ.intersection(commonProductsFilter, prodList);

                } else {

                    commonProductsFilter = prodList;

                }

                $(".error-" + par).hide();

                selectedValues.push(va);



            });

            jQuery("select[name^='attributes']").each(function () {

                if ($(this).val() != '') {

                    var va = $(this).find(':selected').data('attop-id');

                    var par = $(this).data('attrid');

                    var prodList = returnProducts(va);

                    if (commonProductsFilter.length > 0) {

                        commonProductsFilter = jsonQ.intersection(commonProductsFilter, prodList);

                    } else {

                        commonProductsFilter = prodList;

                    }

                    $(".error-" + par).hide();

                    selectedValues.push(va);

                }

            });

        } else {

            var prodList = returnProducts(vid);

            commonProducts = prodList;

            selectedValues.push(vid);

            selectedArray.push(pr);

        }

     if(commonProducts != null){
        if (commonProducts.length > 0) {

            if (selectedArray.length == countAttr) {

                //selectedArray = [];

                //selectedArray.push(pr);

            }

            disableAtts(commonProducts, selectedArray);

            if (parseInt(countAttr) > 2) {

                disableNotAvailAtts(pr, vid, selectedArray);

            }

            if (parseInt(countAttr) == 2) {

                finalCommon = commonProductsFilter;

            } else {

                finalCommon = commonProducts;

            }

        }
     }else{
        oldprice();
     }

        resetForMainAtts(selectedValues, vid);

        var price = 0;

        if (finalCommon.length == 1) {

            price = findPriceByProdID(pr, vid, finalCommon);

        } else {

            price = findPrice(pr, vid);

        }

        // code

         var include_vat =   (price * TAX / 100);

         var inc_vat = (parseFloat(price) + parseFloat(include_vat));



         <?php  if($group_by_prices) { ?>

         var current_qty = $('.input-number').val();

         var obj = '<?= json_encode($group_by_prices); ?>';

         var GROUP_PRICE = JSON.parse(obj);



         var highest = Number.NEGATIVE_INFINITY;

         var tmp;

         for (var i=GROUP_PRICE.length-1; i>=0; i--) {

              tmp = GROUP_PRICE[i].qty_to;

              if (tmp > highest) highest = tmp;

         }



            var status_enable = true;

            $.each(GROUP_PRICE, function( key, value ) {

              if(parseFloat(value.qty_from) <= current_qty && parseFloat(value.qty_to) >= current_qty){

                status_enable = false; 

              }else if(parseFloat(highest) < current_qty){

                console.log(highest);

                status_enable = false; 

              }



            });

            <?php  }else{  ?>

                var status_enable = true;

            <?php  } ?>

           

         if(status_enable){            

            <?php 

            if(empty($product['is_offer_discount'])) {

            if($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {

            ?>

                jQuery('.price-span').text(inc_vat.toFixed(2));

                jQuery('.your_price').text('(£'+price+' Excl. VAT)');

                priceObj['price'] = inc_vat.toFixed(2);

                priceObj['vat_price'] = '(£'+price+' Excl. VAT)';

            <?php } elseif($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') { ?>

                jQuery('.price-span').text(price);

                jQuery('.your_price').text('(£'+inc_vat.toFixed(2)+' Inc. VAT)');

                priceObj['price'] = price;

                priceObj['vat_price'] = '(£'+inc_vat.toFixed(2)+' Inc. VAT)';

            <?php  }else{  ?>

                jQuery('.price-span').text(price);

                jQuery('.your_price').text('(£'+inc_vat.toFixed(2)+' Inc. VAT)');

                priceObj['price'] = price;

                priceObj['vat_price'] = '(£'+inc_vat.toFixed(2)+' Inc. VAT)';

            <?php

              }

             }

            ?>

         }

      

        // code

    }



    function resetForMainAtts(selectedValues, currentVal) {

        var prodList = returnProducts(currentVal);

        var diff = prodList;

        for (var atP in selectedValues) {

            if (selectedValues[atP] != currentVal) {

                var thisProducts = returnProducts(selectedValues[atP]);

                var diff = jsonQ.intersection(thisProducts, diff);

                if (diff == null || diff.length == 0) {

                    var prID = returnParent(selectedValues[atP]);

                    $('input[name="attributes[' + prID + ']"]').prop('checked', false).removeClass('dis');

                    $('select[name="attributes[' + prID + ']"]').prop('selectedIndex', 0);

                    $('select[name="attributes[' + prID + ']"] option').removeClass('dis');

                    /*var index = selectedArray.indexOf(prID);

                     if (index > -1) {

                     selectedArray.splice(index, 1);

                     }*/

                    //$(".error-"+prID).show();

                }

            }

        }

    }





    function disableNotAvailAtts(parent, current, selectedArray) {

        var prodList = returnProducts(current);

        for (var atP in configData) {

            if (configData[atP]['attr_id'] != parent && inArray(configData[atP]['attr_id'], selectedArray)) {

                for (var at in configData[atP]['options']) {

                    var thisProducts = configData[atP]['options'][at]['products'];

                    var commonProducts = jsonQ.intersection(thisProducts, prodList);

                    jQuery('#atopt-' + configData[atP]['options'][at]['id']).removeClass('dis');

                    //alert(configData[atP]['options'][at]['id']);

                    if (commonProducts.length == 0) {

                        jQuery('#atopt-' + configData[atP]['options'][at]['id']).addClass('dis');

                    }

                }

            }

        }

    }



    function disableAtts(commonProductsAll, attrSetArray) {

        for (var atP in configData) {

            if (!inArray(configData[atP]['attr_id'], attrSetArray)) {



                //alert(attrSetArray +" "+configData[atP]['attr_id']);

                //alert('input[name="attributes['+configData[atP]['attr_id']+']"]');

                //$('input[name="attributes['+configData[atP]['attr_id']+']"]').attr('checked', false);

                for (var at in configData[atP]['options']) {

                    //console.log(configData[atP]['options'][at]['id']);

                    //console.log(commonProductsAll);

                    var thisProducts = configData[atP]['options'][at]['products'];

                    //console.log(thisProducts);

                    var commonProducts = jsonQ.intersection(thisProducts, commonProductsAll);

                    //console.log(commonProducts);

                    //console.log("#########");

                    //alert(configData[atP]['options'][at]['id']);

                    jQuery('#atopt-' + configData[atP]['options'][at]['id']).removeClass('dis');

                    //alert(configData[atP]['options'][at]['id']);

                    if (commonProducts.length == 0) {

                        jQuery('#atopt-' + configData[atP]['options'][at]['id']).addClass('dis');

                    }

                }

            }

        }

    }

    function returnProducts(id) {

        for (var atP in configData) {

            for (var at in configData[atP]['options']) {

                if (configData[atP]['options'][at]['id'] == id) {

                    return configData[atP]['options'][at]['products'];

                }

            }

        }

        return null;

    }



    function returnParent(id) {

        for (var atP in configData) {

            for (var at in configData[atP]['options']) {

                if (configData[atP]['options'][at]['id'] == id) {

                    return configData[atP]['attr_id'];

                }

            }

        }

        return null;

    }



    $(document).ready(function (e) {

        $(".atroptions").change(function () {

            var par = $(this).data('attrid');

            var tTyp = $(this).get(0).tagName;

            if (tTyp == "INPUT") {

                var va = $(this).data('attop-id');

            } else if (tTyp == "SELECT") {

                var va = $(this).find(":selected").data('attop-id');

            }

            eliminate(par, va);

        });



        $('.detail-tabs-mobile .panel-title a').click(function () {

            $(this).find('i').toggleClass('active');

        });



        if ($(window).width() < 768) {

            $('.product-tabs-outer.web-tabs').remove();

        }

        if ($(window).width() >= 768) {

            $('.detail-tabs-mobile').remove();

        }



    });

<?php /* OLD way of doing

  function eliminate() {

  var commonProducts = [];

  var disabledArray = [];

  jQuery("input[name^='attributes']:checked").each(function () {

  var va = $(this).data('attop-id');

  var par = $(this).data('attrid');

  $(".error-"+par).hide();

  disableAtts(par, va);

  });

  jQuery("select[name^='attributes']").each(function () {

  var va = $(this).find(':selected').data('attop-id');

  if($(this).val() != "") {

  var par = $(this).data('attrid');

  $(".error-"+par).hide();

  disableAtts(par, va);

  }

  });

  }

  function disableAtts(parent, current) {

  var prodList = returnProducts(current);

  for(var atP in configData) {

  if(configData[atP]['attr_id'] != parent) {

  for(var at in configData[atP]['options']) {

  var thisProducts = configData[atP]['options'][at]['products'];

  var commonProducts = jsonQ.intersection(thisProducts, prodList);

  console.log(prodList+"=cpro"+thisProducts+"=diff"+commonProducts+"=pid"+parent + "=aid" + configData[atP]['attr_id']+"=opid"+configData[atP]['options'][at]['id']);

  //if(!jQuery.inArray( configData[atP]['options'][at]['id'], disabledArray )) {

  //    jQuery('#atopt-'+configData[atP]['options'][at]['id']).attr('disabled',false);

  //}

  if(commonProducts.length == 0) {

  jQuery('#atopt-'+configData[atP]['options'][at]['id']).attr('disabled', true);

  }

  }

  }

  }

  } */ ?>

    $("#cart_frm").on('submit', function (e) {

        e.preventDefault();

        var serializedData = $(this).serialize();

        var uncheckedCount = 0;

        var attrVal = [];

        jQuery("input[name^='attributes']").each(function () {

            var pid = $(this).data('attrid');

            if (jQuery("input[name='attributes[" + pid + "]']:checked").length == 0) {

                $(".error-" + pid).show();

                uncheckedCount++;

            } else {

                $(".error-" + pid).hide();

                attrVal.push({

                    att_id: $(this).attr("data-attop-id"),

                    value: $(this).val()

                });

            }

        });

        jQuery("select[name^='attributes']").each(function () {

            var pid = $(this).data('attrid');

            if (jQuery("select[name='attributes[" + pid + "]']").val() == '') {

                $(".error-" + pid).css({"display": "block", "max-width": "100px"});

                uncheckedCount++;

            } else {

                attrVal.push({

                    att_id: $(this).find(':selected').attr("data-attop-id"),

                    value: $(this).val()

                });

            }

        });

        if (uncheckedCount > 0) {

            return;

        }

        if (finalCommon.length != 1) {

            return;

        }

        var uri = configProducts[finalCommon[0]].uri;

        /*$(".abc").each(function () {

         if ($(this).find(":selected").attr("data-attrid") != undefined) {

         attrVal.push({

         att_id: $(this).find(":selected").attr("data-attrid"),

         value: $(this).find(":selected").val()

         });

         }

         });

         

         $("input[name='atrributeCheck']:checked").each(function () {

         if ($(this).attr("data-attrid") != undefined) {

         attrVal.push({

         att_id: $(this).attr("data-attrid"),

         value: $(this).val()

         });

         }

         });*/



        //price-span

        var accessories = [];

        $('.accessory').each(function (index, element) {

            if ($(element).is(':checked')) {

                accessories.push($(element).val())

            }

        });

        var qty = $(".quantity1_unique").val();

        var prodURl2 = "catalog/product/" + uri

        var serializedData = $(this).serialize();

        $.post(prodURl2, serializedData, function (data) {

            if (data.notifyHTML != '') {

                $.notify(data.notifyHTML, {"delay": 3000});

                if (data.cartCnt) {

                    $('#cart-basket').html(data.cartCnt).change();

                    $('#total-cart-price').html(data.cart_total_price).change();

                }

                gtag('event', 'add_to_cart', {

				  "items": data.jsonItem

				});

                $(".checkout-btn").css("display", "table");

                $('.erat').hide();

            }

            resetSelection();

        }, 'JSON');

    });



    function findPrice(atPr, attrID) {

        for (var atP in configData[atPr]['options'][attrID]['pPrice']) {

            return configData[atPr]['options'][attrID]['pPrice'][atP];

        }

        return 0;

    }



    function findPriceByProdID(atPr, attrID, prodID) {

        return configData[atPr]['options'][attrID]['pPrice'][prodID];

    }



    function resetSelection() {

        var attrVal = [];

        /*$(".attributes").each(function () {

         $(this).parents('label.filter-label').removeClass('radio-btn-active');

         $(this).parents('label.filter-label').removeClass('check-disabled');

         $(this).attr('checked', false);

         });*/

        document.getElementById("cart_frm").reset();

        var oldPrice = $('.price').attr('old-price');

        if (oldPrice) {

            $('.price').html('&pound;' + oldPrice);

        }

        // function call
        oldprice();
        // function call

        for (var prID in configData) {

            $('input[name="attributes[' + prID + ']"]').prop('checked', false).attr('disabled', false);

            $('select[name="attributes[' + prID + ']"]').prop('selectedIndex', 0);

            $('select[name="attributes[' + prID + ']"] option').attr('disabled', false);

        }

        finalCommon = [];

        $('.quantity1_unique').val(1);

    }



    $(document).on('click', '#viewSiz', function () {

        $('#proDescription').removeClass('active in');

        $('.prod-description .nav-tabs>li').removeClass('active');

        $('#sizechart').addClass('active in');

        $('.prod-description .nav-tabs>li:nth-child(2)').addClass('active');

        $('html,body').animate({

            scrollTop: $("#sizechart").offset().top - 75},

                'slow');

    });



    $(document).ready(function () {

        $('#product-enquiry-submit-btn').click(function () {

            var fname = ($('#expert-form #fname').val()).trim();

            var lname = ($('#expert-form #lname').val()).trim();

            var email = ($('#expert-form #email').val()).trim();

            var phone = ($('#expert-form #phone').val()).trim();

            var message = ($('#expert-form #message').val()).trim();

            var product_id = ($('#expert-form #product-id').val()).trim();

            if ((fname && message) && (email || phone)) {

                $.post('<?php echo base_url() ?>catalog/ajax/product/expert_enquiry',

                        {

                            fname: fname,

                            lname: lname,

                            email: email,

                            phone: phone,

                            message: message,

                            product_id: product_id

                        },

                        function (data, status) {

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



        $('#wishlist-li-btn').click(function () {

            var customer_id = '<?php

if ($customer && ($customer["user_is_active"] == 1)) {

    echo $customer["user_id"];

}

?>';

            var current_element = $(this);

            if (customer_id) {

                $.post('wishlist/toggle',

                        {

                            customer_id: customer_id,

                            product_id: current_element.attr('data-product-id')

                        },

                        function (data, status) {

//                            current_element = current_element.find('img');

                            if (data == 'added') {

                                $("#wishlistModal").modal("show");

                                $(".modal-title").html("Product Added To Your Wishlist").css('color', 'green');

//                                current_element.attr('src', 'images/icon/heart-icon-range2.png');

                                current_element.html('<i style="color:#ff6c00;" class="fa fa-heart fa-2x" aria-hidden="true"></i>');

                            } else {

                                $("#wishlistModal").modal("show");

                                $(".modal-title").html("Product Removed From Your Wishlist").css('color', 'red');

//                                current_element.attr('src', 'images/icon/heart-icon-range.png');

                                current_element.html('<i class="fa fa-heart-o fa-2x" aria-hidden="true"></i>');

                            }

                        });

            } else {

                alert('Please sign-in first!');

            }

        });

        $('#social-ul-toggle').click(function () {

            $('#social-icons-li').toggleClass('social-active');

        });

    });



    $(document).ready(function () {

//        $('#social-icons-li').hide();

        setTimeout(function () {

            $('.abc').each(function () {

                var x = $(this).find('option');

                var counter = 0;

                $(x).each(function () {

                    if ($(this).css('display') == 'block') {

                        counter++;

                    }

                });

                if (counter < 2) {

                    $(this).css('cursor', 'not-allowed');

                }

            });

        }, 100);

    });

</script>

<script>

    $('.btn-number').click(function (e) {

        e.preventDefault();

        fieldName = $(this).attr('data-field');

        type = $(this).attr('data-type');

        var input = $("input[name='" + fieldName + "']");

        var currentVal = parseInt(input.val());

        // code

           <?php if($group_by_prices) {  ?>

            

             var current_qty = $('.input-number').val();

              if(type == 'plus'){

                 current_qty++;

              }else{

                 current_qty--;

              }

             var obj = '<?= json_encode($group_by_prices); ?>';

             var GROUP_PRICE = JSON.parse(obj);

                //  get min from value
                var min_arr = [];
                  $.each( GROUP_PRICE, function( key, value ) {
                    min_arr.push(value.qty_from);
                  });
                var lowest = Math.min.apply(Math, min_arr);  // returns 1
                console.log(lowest);
                //   get min from value

               $.each( GROUP_PRICE, function( key, value ) {

                    console.log(current_qty);

                   var include_vat =   (value.qty_range_val * TAX / 100);

                   var inc_vat = (parseFloat(value.qty_range_val) + parseFloat(include_vat));

                   var group_price =  parseFloat(value.qty_range_val);

                  if(parseFloat(value.qty_from) <= current_qty && parseFloat(value.qty_to) >= current_qty){

                    // imp

                    <?php 

                     if(empty($product['is_offer_discount'])) {

                      if($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {

                    ?>

                      jQuery('.price-span').text(inc_vat.toFixed(2));

                      jQuery('.your_price').text('(£'+group_price.toFixed(2)+' Excl. VAT)');

                    <?php } elseif($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') { ?>

                     jQuery('.price-span').text(group_price.toFixed(2));

                     jQuery('.your_price').text('(£'+inc_vat.toFixed(2)+' Inc. VAT)');

                    <?php  }else{  ?>

                     jQuery('.price-span').text(group_price.toFixed(2));

                     jQuery('.your_price').text('(£'+inc_vat.toFixed(2)+' Inc. VAT)');

                    <?php

                     }

                    }

                    ?>

                    // imp

                   }else if(parseFloat(lowest) > current_qty ){              
                      if(jQuery.isEmptyObject(priceObj)){
                         oldprice();
                      }else{
                         jQuery('.price-span').text(priceObj.price);
                         jQuery('.your_price').text(priceObj.vat_price);
                      }

                   }else{



                   }

             });

             

           <?php   } ?>

        // code

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



    $('.input-number').focusin(function () {

        $(this).data('oldValue', $(this).val());

    });

    $('.input-number').change(function () {



    });

    $(".input-number").keydown(function (e) {

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



    $(document).on("click", "#cart-submit", function () {

        $("#cart_frm").submit();

    });





    $(".link-product-dics.log-in-review-already").click(function (event) {

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

function oldprice(){
    jQuery('.price-span').text($('.price-span-hidden').val());
    jQuery('.your_price').text($('.your-price-hidden').val());
}

</script>