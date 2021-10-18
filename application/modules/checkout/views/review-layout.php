<table class="side-bar-table side-bar-table-check" id="review-table">
    <?php
    if ($cart_contents) {
        $url = $this->config->item('PRODUCT_URL');
        foreach ($cart_contents as $item) {
            // e($item);
    ?>
            <tr>
                <?php
                if (isset($item['img'])) {
                ?>
                    <td width="30%">
                        <?php
                        if (file_exists($this->config->item('PRODUCT_PATH') . $item['img']) && $item['img']) {
                            $img_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 97, 103, 'product-checkout');
                        } else {
                            $img_url = resize(base_url() . 'images/a1.jpg', 97, 103, 'product-checkout');
                        }
                        ?>
                        <img src="<?= $img_url; ?>" class="img-responsive">
                    </td>
                    <td width="70%">
                        <div class="side-bar-table-data">
                            <a class="side-name" href="javascript:void(0)"><?php echo $item['name'] ?></a>
                            <?php
                            if (isset($item['product_sku'])) {
                            ?>
                                <p class="side-description" style="color: grey;"><?php echo $item['product_sku'] ?></p>
                            <?php
                            }
                            ?>

                            <ul class="list-unstyled side-product-items-list">
                                <li>QTY: <?= $item['qty'] ?></li>
                                <li>PRICE: &pound;<?= $item['subtotal'] ?></li>
                                <?php if(isset($item['discount']) && $item['discount'] > 0): ?>
                                <li>
                                    Discount: <?php echo DWS_CURRENCY_SYMBOL . $item['discount'] ?>
                                </li>
                                <?php endif; ?>
                                <?php if(isset($item['vat']) && $item['vat'] > 0): ?>
                                <li>
                                    VAT: <?php echo DWS_CURRENCY_SYMBOL . $item['vat'] ?>
                                </li>
                                <?php endif; ?>
                            </ul>

                            <?php
                            if (isset($item['order_item_options']) && $item['order_item_options']) {
                                $comma_flag = FALSE;
                                foreach ($item['order_item_options'] as $atr) {
                                    if ($comma_flag) {
                                        echo ', &nbsp;';
                                    }
                            ?>
                                    <span><?php echo $atr['attribute_label'] . ' : ' . $atr['value_label'] ?> </span>
                            <?php
                                    $comma_flag = TRUE;
                                }
                            }
                            ?>
                            <p class="side-price">
                                <?php
                                if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                    echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($item['price'] * $item['qty'], 2) . '<br>';
                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['price'] * $item['qty'] + $item['price'] * $item['qty'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                    echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format(($item['price'] * $item['qty'] + $item['price'] * $item['qty'] * DWS_TAX / 100), 2) . '<br>';
                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($item['price'] * $item['qty'], 2) . ' ' . 'Excl. VAT)</span>';
                                } else {
                                    echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($item['price'] * $item['qty'], 2) . '<br>';
                                    echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['price'] * $item['qty'] + $item['price'] * $item['qty'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                }
                                ?>
                            </p>
                        </div>
                    </td>
                <?php
                } else {
                ?>
                    <td width="100%" colspan="2">
                        <div class="side-bar-table-data" style="padding: 0;">
                            <a class="side-name" href="#"><?php echo $item['name'] ?></a>
                            <?php
                            if (isset($item['product_sku'])) {
                            ?>
                                <p class="side-description"><?php echo $item['product_sku'] ?></p>
                            <?php
                            }
                            ?>
                            <?php
                            if (isset($item['order_item_options']) && $item['order_item_options']) {
                                $comma_flag = FALSE;
                                foreach ($item['order_item_options'] as $atr) {
                                    if ($comma_flag) {
                                        echo ', &nbsp;';
                                    }
                            ?>
                                    <span><?php echo $atr['attribute_label'] . ' : ' . $atr['value_label'] ?> </span>
                            <?php
                                    $comma_flag = TRUE;
                                }
                            }
                            ?>
                            <p class="side-price">£<?php echo number_format($item['price'] * $item['qty'], 2) ?></p>
                        </div>
                    </td>
            </tr>
<?php
                }
            }
        }
?>
</table>