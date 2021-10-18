<?php
$latest_products = offer_and_latest_and_new_products('latest');
$new_arrival = offer_and_latest_and_new_products('new');
$featured_products = offer_and_latest_and_new_products('featured');
?>
<div class="container-fluid">
    <div class="col-xs-12 homeproducts common-padding">
        <ul class="nav nav-pills" style="display: none;">
            <?php
            if ($featured_products) {
                ?>
                <li class="active">
                    <a data-toggle="pill" href="#featured-prods">Featured Products</a>
                </li>
            <?php }if ($latest_products) { ?>
                <li class="<?= (!$featured_products) ? 'active' : '' ?>">
                    <a data-toggle="pill" href="#latest-prods">Latest Products</a>
                </li>
            <?php } if ($new_arrival) { ?>
                <li class="<?= (!$latest_products) ? 'active' : '' ?>" >
                    <a data-toggle="pill" href="#new-prods">New Products</a>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php
            if ($featured_products) {
                ?>
                <div id="featured-prods" class="tab-pane fade in active">

                    <div class="col-xs-12 null-padding">
                        <p class="offer_heading">Featured Products</p>
                    </div>

                    <div class="products-main clear-parent">
                        <div class="col-xs-12 feature-pro-main-div-home">
                            <div class="" id="featureJK">
                                <?php
                                foreach ($featured_products as $featured):
                                    if (file_exists($this->config->item('PRODUCT_PATH') . $featured['img']) && $featured['img']) {
                                        $featured_img = resize($this->config->item('PRODUCT_PATH') . $featured['img'], 248, 264, 'featured-products');
                                    } else {
                                        $featured_img = resize(FCPATH . 'images/a1.jpg', 248, 264, 'featured-products');
                                    }
                                    $least_price = $featured['price'];
                                    if ($least_price == 0 || $least_price == 0.00) {
                                        $least_price = get_least_child_price($featured['product_id']);
                                    }
                                    if (!$least_price) {
                                        $least_price = '0.00';
                                    }
                                    ?>
                                    <div class="item">
                                        <div class="col-xs-12  feature-pro-main-div-home-inner">
                                            <div class="feature-pro-main-div-home-img">
                                                <a href="<?= base_url() . $featured['uri'] ?>">
                                                    <img class="img-responsive" src="<?= $featured_img ?>" alt="<?= $featured['imgalt'] ?>">
                                                </a>  
                                            </div>
                                            <div class="feature-pro-main-div-home-content">
                                                <a href="<?= base_url() . $featured['uri'] ?>">
                                                    <p><?= $featured['name'] ?></p>   
                                                </a>
                                                <?php
//                                                if ($this->session->userdata('CUSTOMER_ID')) {
                                                echo "<p class='product_price'>";
                                                if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                                    if ($featured['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($featured['is_offer_discount'], 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $least_price . "</span><br>";
                                                        if( $featured['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($featured['is_offer_discount'] + $featured['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($least_price, 2) . '<br>';
                                                        if( $featured['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    }
                                                } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                                    if ($featured['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($featured['is_offer_discount'] + $featured['is_offer_discount'] * DWS_TAX / 100), 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $least_price . "</span><br>";
                                                        if( $featured['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($featured['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . '<br>';
                                                        if( $featured['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($least_price, 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    }
                                                } else {
                                                    if ($featured['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($featured['is_offer_discount'], 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $least_price . "</span><br>";
                                                        if( $featured['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($featured['is_offer_discount'] + $featured['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($least_price, 2) . '<br>';
                                                        if( $featured['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    }
                                                }
                                                echo "</p>";
//                                                }
                                                ?>
                                                
                                                <ul class="list-inline product-list-page-btn-ul">
                                                    <?php if(isset($featured['product_stock_status']) && $featured['product_stock_status'] == 0) { ?>
                                                        <li><a class="common_button product-list-page-btn" href="javascript:void(0)">Out of Stock !</a></li>
                                                    <?php } elseif(isset($featured['product_stock_status']) && $featured['product_stock_status'] == 1) { ?>
                                                        <li><a class="common_button product-list-page-btn" href="javascript:void(0)">Coming Soon !</a></li>
                                                    <?php } ?>   
                                                </ul>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            if ($latest_products) {
                ?>
                <div id="latest-prods" class="tab-pane fade" style="display: none;">
                    <div class="products-main clear-parent">
                        <div class="col-xs-12 feature-pro-main-div-home">
                            <div class="owl-carousel owl-theme" id="recent-product">
                                <?php
                                foreach ($latest_products as $latest):
                                    if (file_exists($this->config->item('PRODUCT_PATH') . $latest['img']) && $latest['img']) {
                                        $latest_img = resize($this->config->item('PRODUCT_PATH') . $latest['img'], 248, 264, 'latest-products');
                                    } else {
                                        $latest_img = resize(FCPATH . 'images/a1.jpg', 248, 264, 'latest-products');
                                    }
                                    $latest_price = $latest['price'];
                                    if ($latest_price == 0) {
                                        $latest_price = get_least_child_price($latest['product_id']);
                                    }
                                    if (!$latest_price) {
                                        $latest_price = '0.00';
                                    }
                                    ?>
                                    <div class="item">
                                        <div class="col-xs-12  feature-pro-main-div-home-inner">
                                            <div class="feature-pro-main-div-home-img">
                                                <a href="<?= base_url() . $latest['uri'] ?>">
                                                    <img class="img-responsive" src="<?= $latest_img ?>" alt="<?= $latest['imgalt'] ?>">
                                                </a>  
                                            </div>
                                            <div class="feature-pro-main-div-home-content">
                                                <a href="<?= base_url() . $latest['uri'] ?>">
                                                    <p><?= $latest['name'] ?></p>   
                                                </a>
                                                <?php
//                                                if ($this->session->userdata('CUSTOMER_ID')) {
                                                echo "<p class='product_price'>";
                                                if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                                    if ($latest['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($latest['is_offer_discount'], 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $latest_price . "</span><br>";
                                                        if( $latest['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($latest['is_offer_discount'] + $latest['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($latest_price, 2) . '<br>';
                                                        if( $latest['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($latest_price + $latest_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    }
                                                } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                                    if ($latest['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($latest['is_offer_discount'] + $latest['is_offer_discount'] * DWS_TAX / 100), 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $latest_price . "</span><br>";
                                                        if( $latest['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($latest['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($latest_price + $latest_price * DWS_TAX / 100), 2) . '<br>';
                                                        if( $latest['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($latest_price, 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    }
                                                } else {
                                                    if ($latest['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($latest['is_offer_discount'], 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $latest_price . "</span><br>";
                                                        if( $latest['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($latest['is_offer_discount'] + $latest['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($latest_price, 2) . '<br>';
                                                        if( $latest['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($latest_price + $latest_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    }
                                                }
                                                echo "</p>";
//                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            if ($new_arrival) {
                ?>
                <div id="new-prods" class="tab-pane fade" style="display: none;">
                    <div class="products-main clear-parent">
                        <div class="col-xs-12 feature-pro-main-div-home">
                            <div class="owl-carousel owl-theme" id="new-pro">
                                <?php
                                foreach ($new_arrival as $arrival):
                                    if (file_exists($this->config->item('PRODUCT_PATH') . $arrival['img']) && $arrival['img']) {
                                        $arrival_img = resize($this->config->item('PRODUCT_PATH') . $arrival['img'], 248, 264, 'new-products');
                                    } else {
                                        $arrival_img = resize(FCPATH . 'images/a1.jpg', 248, 264, 'new-products');
                                    }

                                    $arrival_price = $arrival['price'];
                                    if ($arrival_price == 0) {
                                        $arrival_price = get_least_child_price($arrival['product_id']);
                                    }
                                    if (!$arrival_price) {
                                        $arrival_price = '0.00';
                                    }
                                    ?>
                                    <div class="item">
                                        <div class="col-xs-12  feature-pro-main-div-home-inner">
                                            <div class="feature-pro-main-div-home-img">
                                                <a href="<?= base_url() . $arrival['uri'] ?>">
                                                    <img class="img-responsive" src="<?= $arrival_img ?>" alt="<?= $arrival['imgalt'] ?>">
                                                </a>  
                                            </div>
                                            <div class="feature-pro-main-div-home-content">
                                                <a href="<?= base_url() . $arrival['uri'] ?>">
                                                    <p><?= $arrival['name'] ?></p>   
                                                </a>
                                                <?php
//                                                if ($this->session->userdata('CUSTOMER_ID')) {
                                                echo "<p class='product_price'>";
                                                if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                                    if ($arrival['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($arrival['is_offer_discount'], 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $arrival_price . "</span><br>";
                                                        if( $arrival['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($arrival['is_offer_discount'] + $arrival['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($arrival_price, 2) . '<br>';
                                                        if( $arrival['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($arrival_price + $arrival_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    }
                                                } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                                    if ($arrival['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($arrival['is_offer_discount'] + $arrival['is_offer_discount'] * DWS_TAX / 100), 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $arrival_price . "</span><br>";
                                                        if( $arrival['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($arrival['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($arrival_price + $arrival_price * DWS_TAX / 100), 2) . '<br>';
                                                        if( $arrival['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($arrival_price, 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    }
                                                } else {
                                                    if ($arrival['is_offer_discount']) {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($arrival['is_offer_discount'], 2);
                                                        echo "<span class='your_price strip-price'>" . DWS_CURRENCY_SYMBOL . $arrival_price . "</span><br>";
                                                        if( $arrival['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($arrival['is_offer_discount'] + $arrival['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } else {
                                                        echo '<tree class="your_price"> </tree>' . ' <span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format($arrival_price, 2) . '<br>';
                                                        if( $arrival['is_taxable'] == 1) {
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($arrival_price + $arrival_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    }
                                                }
                                                echo "</p>";
//                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
