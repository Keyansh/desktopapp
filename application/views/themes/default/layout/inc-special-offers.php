<?php
$offer_products = offer_and_latest_and_new_products('offer');
if ($offer_products) {
    ?>
    <div class="container-fluid">
        <div class="col-xs-12 null-padding">
            <div class="col-xs-12 null-padding">
                <p class="offer_heading">SPECIAL OFFERS AND CLEARANCE</p>
            </div>
            <div class="col-xs-12 null-padding  offers-product-list">
                <?php
                foreach ($offer_products as $offer_product):
                    if (file_exists($this->config->item('PRODUCT_PATH') . $offer_product['img']) && $offer_product['img']) {
                        $offer_img = resize($this->config->item('PRODUCT_PATH') . $offer_product['img'], 248, 264, 'offer-products');
                    } else {
                        $offer_img = resize(FCPATH . 'images/a1.jpg', 248, 264, 'offer-products');
                    }

                    $price = $offer_product['price'];
                    if ($price == 0 || $price == 0.00) {
                        $price = get_least_child_price($offer_product['product_id']);
                    }
                    if (!$price) {
                        $price = '0.00';
                    }
                    ?>
                    <div class="col-xs-12 col-sm-6 offers-product-list-inner">
                        <div class="col-xs-12 offers-product-list-inner-inner">
                            <div class="img-div col-xs-12 null-padding">
                                <?php // if ($this->session->userdata('CUSTOMER_ID')) { ?>
                                <span class="offer-prise">
                                    save<br>
                                    <?= DWS_CURRENCY_SYMBOL . ($price - $offer_product['is_offer_discount']) ?>
                                </span>
                                <?php // } ?>
                                <a href="<?= base_url() . $offer_product['uri'] ?>">
                                    <img src="<?= $offer_img ?>" alt="<?= $offer_product['imgalt'] ?>" class="img-responsive">
                                </a>
                            </div>
                            <div class="col-xs-12 null-padding content-div">
                                <p class="offer-pro-sku">
                                    <?= $offer_product['sku'] ?>
                                </p>
                                <p class="offer-pro-title">
                                    <a href="<?= base_url() . $offer_product['uri'] ?>">
                                        <?= $offer_product['name'] ?>
                                    </a>
                                </p>
                                <?php // if ($this->session->userdata('CUSTOMER_ID')) { ?>
                                <div class="offer-pro-price">
                                    <ul class="list-inline">
                                        <?php if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') { ?>
                                            <li>Price - <?= DWS_CURRENCY_SYMBOL . $price ?></li> | 
                                            <li>Offer - <?= DWS_CURRENCY_SYMBOL . $offer_product['is_offer_discount'] ?></li>
                                            <li style="color:#999999" class="your_price"><?= '(' . DWS_CURRENCY_SYMBOL . number_format(($offer_product['is_offer_discount'] + $offer_product['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)' ?></li>
                                        <?php } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') { ?>
                                            <li>Price - <?= DWS_CURRENCY_SYMBOL . $price ?></li> | 
                                            <li>Offer - <?= DWS_CURRENCY_SYMBOL . number_format(($offer_product['is_offer_discount'] + $offer_product['is_offer_discount'] * DWS_TAX / 100), 2) ?></li>
                                            <li style="color:#999999" class="your_price"><?= '(' . DWS_CURRENCY_SYMBOL . number_format($offer_product['is_offer_discount'], 2) . ' ' . 'Excl. VAT)' ?></li>
                                        <?php } else { ?>
                                            <li>Price - <?= DWS_CURRENCY_SYMBOL . $price ?></li> | 
                                            <li>Offer - <?= DWS_CURRENCY_SYMBOL . $offer_product['is_offer_discount'] ?></li>
                                            <li style="color:#999999" class="your_price"><?= '(' . DWS_CURRENCY_SYMBOL . number_format(($offer_product['is_offer_discount'] + $offer_product['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)' ?></li>
                                            <?php } ?>
                                    </ul>
                                </div>
                                <?php // }  ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php } ?>