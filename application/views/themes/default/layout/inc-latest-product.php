<?php
$latest_products = offer_and_latest_and_new_products('latest');
if ($latest_products) {
    ?>
    <div class="container-fluid">
        <div class="col-xs-12 latest_section null-padding">
            <p class="site-heading">
                <span class="text"> Latest Products </span>
                <span class="underline"></span>
            </p>
            <div class="col-xs-12 inner-pro-home-sec">
                <div class="owl-carousel owl-theme" id="latest-pro-sli">
                    <?php
                    $i = 4;
                    foreach ($latest_products as $arrival) {
                        if (file_exists($this->config->item('PRODUCT_PATH') . $arrival['img']) && $arrival['img']) {
                            $arrival_img = resize($this->config->item('PRODUCT_PATH') . $arrival['img'], 195, 207, 'new-products');
                        } else {
                            $arrival_img = resize(FCPATH . 'images/a1.jpg', 195, 207, 'new-products');
                        }

                        $least_price = $arrival['price'];
                        if ($least_price == 0 || $least_price == 0.00) {
                            $least_price = get_least_child_price($arrival['product_id']);
                        }
                        if (!$least_price) {
                            $least_price = '0.00';
                        }
                        ?>                    
                        <?php if ($i % 4 == 0): ?>
                            <div class="item">
                            <?php endif; ?>
                            <div class="col-xs-12 col-sm-6 inner-pro-home-sec-inner">
                                <div class="col-xs-12 inner-pro-list">
                                    <div class="col-xs-4 inner-pro-left">
                                        <a href="<?= base_url() . $arrival['uri'] ?>">
                                            <img src="<?= $arrival_img ?>" alt="<?= $arrival['imgalt'] ?>" class="img-responsive">
                                        </a>
                                    </div>
                                    <div class="col-xs-8 inn-pro-right">
                                        <p class="lat-pro-tit-home">
                                            <a href="<?= base_url() . $arrival['uri'] ?>">
                                                <?= $arrival['name'] ?>
                                            </a>
                                        </p>
                                        <p class="lat-pro-tit-text">
                                            <?= word_limiter(strip_tags($arrival['brief_description']), 35) ?>
                                        </p>
                                        <?php // if ($this->session->userdata('CUSTOMER_ID')) { ?>
                                        <p class="lat-pro-price">
                                            <a href="<?= base_url() . $arrival['uri'] ?>">
                                                <?php
                                                if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                                    if ($arrival['is_offer_discount']) {
                                                        echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . $arrival['is_offer_discount'];
                                                        echo '<span class="pound-sim strip-price">' . DWS_CURRENCY_SYMBOL . $least_price . '</span><br>';
                                                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($arrival['is_offer_discount'] + $arrival['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                    } else {
                                                        echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . $least_price . '<br>';
                                                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                    }
                                                } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                                    if ($arrival['is_offer_discount']) {
                                                        echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($arrival['is_offer_discount'] + $arrival['is_offer_discount'] * DWS_TAX / 100), 2);
                                                        echo '<span class="pound-sim strip-price">' . DWS_CURRENCY_SYMBOL . $least_price . '</span><br>';
                                                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($arrival['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';
                                                    } else {
                                                        echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . '<br>';
                                                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($least_price, 2) . ' ' . 'Excl. VAT)</span>';
                                                    }
                                                } else {
                                                    if ($arrival['is_offer_discount']) {
                                                        echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . $arrival['is_offer_discount'];
                                                        echo '<span class="pound-sim strip-price">' . DWS_CURRENCY_SYMBOL . $least_price . '</span><br>';
                                                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($arrival['is_offer_discount'] + $arrival['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                    } else {
                                                        echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . $least_price . '<br>';
                                                        echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                    }
                                                }
                                                ?>
                                            </a>
                                        </p>
                                        <?php // } ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                            if ($i % 4 == 0):
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
