<?php
if (isset($products)) {
    $table_of_four = array();
    $table_of_odd = array();
    $odd_num = -1;
    foreach ($products as $key => $item) :
        $odd_num += 4;
        $table_of_odd[] = $odd_num;
        if ($key == 0) {
            $table_of_four[] = $key;
        } else {
            $table_of_four[] = ($key * 4);
        }

        if (file_exists($this->config->item('PRODUCT_PATH') . $item['img']) && $item['img']) {
            $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 234, 250, 'product-listing-img');
        } else {
            $image_url = resize(FCPATH . 'images/a1.jpg', 234, 250, 'product-listing-img');
        }

        if (in_array($key, $table_of_four)) {
            echo '<div class="col-xs-12 top-products null-padding">';
        }
        ?>
        <div class="col-xs-12 col-md-3 col-lg-3 col-sm-3 inner_products null-padding">
            <div class="product_img-col">
                <a href="<?= base_url() . $item['uri']; ?>">
                    <img  class="img-responsive" src="<?= $image_url ?>" alt="<?= $item['imgalt']; ?>">
                </a>
            </div>
            <div class="products-descr_col">

                <p class="product_heading-sku"><?= $item['sku']; ?></p>
                <p class="proheading-p" >
                    <a class="product_heading" href="<?= base_url() . $item['uri']; ?>">    
                        <?= $item['name']; ?>
                    </a></p>
                <?php
                $product_price = 0;
                if ($item['price'] > 0) {
                    $product_price = $item['price'];
                } else {
                    $product_price = get_least_child_price($item['product_id']);
                }
                ?>
                <?php // if ($this->session->userdata('CUSTOMER_ID')) { ?>
                <p class="product_price product-new-css">
                    <?php
                    if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                        if ($item['is_offer_discount']) {
                            echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($item['is_offer_discount'], 2);
                            echo '<span class="strip-price">' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '</span><br>';
                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['is_offer_discount'] + $item['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                        } else {
                            echo '<tree class="strip-price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '<br>';
                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($product_price + $product_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                        }
                    } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                        if ($item['is_offer_discount']) {
                            echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format(($item['is_offer_discount'] + $item['is_offer_discount'] * DWS_TAX / 100), 2);
                            echo '<span class="strip-price">' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '</span><br>';
                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($item['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';
                        } else {
                            echo '<tree class="strip-price"></tree>' . DWS_CURRENCY_SYMBOL . number_format(($product_price + $product_price * DWS_TAX / 100), 2) . '<br>';
                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . ' ' . 'Excl. VAT)</span>';
                        }
                    } else {
                        if ($item['is_offer_discount']) {
                            echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($item['is_offer_discount'], 2);
                            echo '<span class="strip-price">' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '</span><br>';
                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['is_offer_discount'] + $item['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                        } else {
                            echo '<tree class="strip-price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '<br>';
                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($product_price + $product_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                        }
                    }
                    ?>
                </p>
                <?php // } ?>

                <?php
                $avgrate = 0;
                $avgrate = review_rate($item['product_id']);
                if ($avgrate) {
                    ?>
                    <ul class="list-inline star_ul_icons">
                        <?php
                        if ($avgrate > 0) {
                            for ($i = 0; $i < $avgrate; $i++) {
                                ?>
                                <li><img class="star-icon" src="images/star-on.png" alt="star-on"></li>
                                <?php
                            }
                            for ($i = $avgrate; $i < 5; $i++) {
                                ?>
                                <li><img class="star-icon" src="images/star-off.png" alt="star-off"></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                <?php } ?>
                <ul class="list-inline product-list-page-btn-ul">
                    <?php
                    if ($item['type'] == 'config') {
                        if ($item['current_quantity'] <= 0) {
                            ?>
                            <li><a class="common_button product-list-page-btn" href="javascript:void(0)">Out of Stock !</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="<?= base_url() . $item['uri'] ?>" class="common_button product-list-page-btn addBtn">View</a></li>
                            <?php
                        }
                    } else {
                        if ($item['current_quantity'] <= 0) {
                            ?>
                            <li><a class="common_button product-list-page-btn" href="javascript:void(0)">Out of Stock !</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="<?= base_url() . $item['uri'] ?>" class="common_button product-list-page-btn addBtn">View</a></li>
                            <?php
                        }
                    }
                    ?>
                    <li><a data-fancybox="" href="<?= $image_url ?>"> <i class="fa fa-search" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
        <?php
        if (in_array($key, $table_of_odd)) {
            echo '</div>';
        }
    endforeach;
}
?>
