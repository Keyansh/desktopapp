<?php
$featured_categorys = featured_category();
if ($featured_categorys['category']) {
    ?>
    <div class="container-fluid">
        <div class="col-xs-12 clean-hyg-fac ">
            <div class="col-xs-12 col-sm-6 clean-hyg-fac-left">
                <div class="clean-hyg-fac-left-img-div">
                    <?php
                    if (file_exists($this->config->item('CATEGORY_PATH') . $featured_categorys["category"]['image']) && $featured_categorys["category"]['image']) {
                        $catg_img = resize($this->config->item('CATEGORY_PATH') . $featured_categorys['category']['image'], 600, 620, 'category-big-image');
                    } else {
                        $catg_img = resize(FCPATH . 'images/a1.jpg', 600, 620, 'category-big-image');
                    }
                    ?>
                    <a href="<?= $featured_categorys["category"]['uri'] ?>">
                        <img src="<?= $catg_img ?>" alt="<?= $featured_categorys["category"]['image_alt'] ?>" class="img-responsive">
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 clean-hyg-fac-right">
                <p class="site-heading">
                    <span class="text">
                        <?= $featured_categorys["category"]['name'] ?>
                    </span>
                    <span class="underline"></span>
                </p>
                <div class="col-xs-12 clean-hyg-fac-ryt-lower">
                    <?php
                    if ($featured_categorys['product']) {
                        foreach ($featured_categorys['product'] as $cat_pro) {
                            if (file_exists($this->config->item('PRODUCT_PATH') . $cat_pro['img']) && $cat_pro['img']) {
                                $pro_img = resize($this->config->item('PRODUCT_PATH') . $cat_pro['img'], 312, 333, 'product-big-image');
                            } else {
                                $pro_img = resize(FCPATH . 'images/a1.jpg', 312, 333, 'product-big-image');
                            }

                            $least_price = $cat_pro['price'];
                            if ($cat_pro['price'] == 0 || $cat_pro['price'] == 0.00) {
                                $least_price = get_least_child_price($cat_pro['product_id']);
                            }
                            if (!$least_price) {
                                $least_price = '0.00';
                            }
                            ?>
                            <div class="col-xs-12 col-sm-6 clean-hyg-fac-ryt-lwer-left">
                                <div class="clean-hyg-fac-ryt-img-top">
                                    <a href="<?= base_url() . $cat_pro['uri'] ?>">
                                        <img src="<?= $pro_img ?>" alt="<?= $cat_pro['imgalt'] ?>" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-xs-12 clean-hyg-fac-ryt-text">
                                    <p class="clean-hyg-fac-ryt-text-heading">
                                        <a href="<?= base_url() . $cat_pro['uri'] ?>">
                                            <?= $cat_pro['name'] ?>
                                        </a> 
                                    </p>
                                    <?php // if ($this->session->userdata('CUSTOMER_ID')) { ?>
                                    <p class="clean-hyg-fac-ryt-text-price">
                                        <a href="<?= base_url() . $cat_pro['uri'] ?>">
                                            <?php
                                            if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                                if ($cat_pro['is_offer_discount']) {
                                                    echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . $cat_pro['is_offer_discount'];
                                                    echo '<span class="pound-sim strip-price">' . DWS_CURRENCY_SYMBOL . $least_price . '</span><br>';
                                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($cat_pro['is_offer_discount'] + $cat_pro['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                } else {
                                                    echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . $least_price . '<br>';
                                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                }
                                            } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                                if ($cat_pro['is_offer_discount']) {
                                                    echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($cat_pro['is_offer_discount'] + $cat_pro['is_offer_discount'] * DWS_TAX / 100), 2);
                                                    echo '<span class="pound-sim strip-price">' . DWS_CURRENCY_SYMBOL . $least_price . '</span><br>';
                                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($cat_pro['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';
                                                } else {
                                                    echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . number_format(($least_price + $least_price * DWS_TAX / 100), 2) . '<br>';
                                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($least_price, 2) . ' ' . 'Excl. VAT)</span>';
                                                }
                                            } else {
                                                if ($cat_pro['is_offer_discount']) {
                                                    echo '<span class="pound-sim">' . DWS_CURRENCY_SYMBOL . '</span>' . $cat_pro['is_offer_discount'];
                                                    echo '<span class="pound-sim strip-price">' . DWS_CURRENCY_SYMBOL . $least_price . '</span><br>';
                                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($cat_pro['is_offer_discount'] + $cat_pro['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
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
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

