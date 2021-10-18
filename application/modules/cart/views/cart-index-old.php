<style>
    .txtAcrescimo{
        text-align: center;
        width: 35px;
        border-color: transparent;
        font-size: 17px;
        color: #818181;
    }
    #update{
        cursor: pointer;
    }
    .pro-img-tiny{
        height: 90px;
        width: 90px;
        max-width: 100%;
        max-height: 100%;
    }
</style>
<?php
$customer = array();
$customer = $this->memberauth->checkAuth();
$cartItems = $this->cart->contents();
$cartTotal = $this->session->userdata('cart_contents');
$you_save = getCurUserDiscountConfig();
?>
<script type="text/javascript">
    $(document).ready(function () {
        var carTotal = "<?php echo $cartTotal['cart_total']; ?>";
        var coupCode = "<?php echo $cartTotal['coupon_code']; ?>";
        if (carTotal == 0) {
            $.get('coupon/del_exist_coupon/' + coupCode, function (data) {
                if (data != '') {
                    location.reload();
                }
            }, 'JSON');
        }

        var x = parseFloat(<?php echo $cartTotal['cart_total'] ?>);
        var y = parseFloat('<?php echo $cartTotal['discounted_amount'] ?>');
        var z = x - y;
        var z = z.toFixed(2);

        $('#revised-grand-total-span').html(z);
    });
</script>

<!--my code-->
<section id="cart_section">
    <div class="container-fluid">

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="error_div alert alert-danger">
                <b>Error</b>:
                <ul>
                    <strong><?php echo $this->session->flashdata('error'); ?></strong>
                </ul>
            </div>
        <?php } ?>
        <?php
        $this->load->view('inc-messages');
        if ($this->cart->total_items() == 0) {
            echo '<p class="empty-basket">There are no items in your wish list.</p>';
        }
        $cartItems = $this->cart->contents();
        if ($cartItems) {
            ?>
            <div class="col-xs-12 main_cart_column">
                <div class="col-xs-12 col-md-8 col-sm-8 col-lg-8 cart_left-upper null-padding ">
                    <div class="col-xs-12 cart_left inner null-padding">
                        <ul class="list-inline">
                            <li> My Cart </li>
                        </ul>
                        <ul class="list-inline">
                            <!--                            <li><a href="#"> B13 2371 </a></li>
                                                        <li><a href="#"> CHANGE</a></li>-->
                        </ul>
                    </div>
                    <form id="cartFrm" name="cartFrm" method="post" action="cart/update">
                        <div class="col-xs-12 products_cart null-padding">
                            <?php
//                            e($this->cart->contents());
                            foreach ($this->cart->contents() as $item) :
                                if (is_array($item)) {
                                    $orientations = isset($item['orientations']) ? $item['orientations'] : '';
                                    $options = '';
                                    if ($this->cart->has_options($item['rowid'])) {
                                        $options = $this->cart->product_options($item['rowid']);
                                    }

                                    $mainImg = image_by_id($item['product_id']);
                                    if ($mainImg) {
                                        $img_url = resize($this->config->item('PRODUCT_PATH') . $mainImg['img'], 97, 103, 'product-cart-index');
                                    } elseif (file_exists($this->config->item('PRODUCT_PATH') . $item['img']) && $item['img']) {
                                        $img_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 97, 103, 'product-cart-index');
                                    } else {
                                        $img_url = resize(base_url() . 'images/a1.jpg', 97, 103, 'product-cart-index');
                                    }
                                    ?>
                                    <div class="col-xs-12 add_to_cart_col null-padding">
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 add_to_cart_left_col null-padding">
                                            <div class="col-xs-12 col-md-7 col-lg-7 col-sm-7 cart_inner_left null-padding">
                                                <div>
                                                    <img class="pro-img-tiny" src="<?= $img_url; ?>" alt="<?= $item['order_item_name'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-5 col-lg-5 col-sm-5 cart_inner_right null-padding">
                                                <p><?= $item['name'] ?></p>
                                                <span>
                                                    <?php
                                                    if (isset($item['order_item_options'])) {
                                                        if ($item['order_item_options']) {
                                                            ?>
                                                            <p>
                                                                <?php
                                                                $comma_flag = FALSE;
                                                                foreach ($item['order_item_options'] as $at) {
                                                                    ?>
                                                                    <span class="small-name">
                                                                        <?php
                                                                        if ($comma_flag) {
                                                                            echo ',&nbsp;&nbsp;';
                                                                        }
                                                                        echo $at['attribute_label'] . ' : ' . $at['value_label'];
                                                                        $comma_flag = TRUE;
                                                                        ?>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </p>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </span>
                                                <!--code-->
                                                <p></p>
                                                <p class="product_price">
                                                    <?php
//                                                    if ($this->session->userdata('CUSTOMER_ID')) {
                                                    if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                                        if ($item['tier_price']) {
                                                            echo '<tree cla ss="your_price">Price </tree>' . DWS_CURRENCY_SYMBOL . number_format($item['tier_price'], 2) . '</br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['tier_price'] + $item['tier_price'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        } else {
                                                            echo '<tree class="your_price">Price </tree>' . DWS_CURRENCY_SYMBOL . number_format($item['price'], 2) . '</br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['price'] + $item['price'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                                        if ($item['tier_price']) {
                                                            echo '<tree cla ss="your_price">Price </tree>' . DWS_CURRENCY_SYMBOL . number_format(($item['tier_price'] + $item['tier_price'] * DWS_TAX / 100), 2) . '</br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($item['tier_price'], 2) . ' ' . 'Excl. VAT)</span>';
                                                        } else {
                                                            echo '<tree class="your_price">Price </tree>' . DWS_CURRENCY_SYMBOL . number_format(($item['price'] + $item['price'] * DWS_TAX / 100), 2) . '</br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($item['price'], 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    } else {
                                                        if ($item['tier_price']) {
                                                            echo '<tree cla ss="your_price">Price </tree>' . DWS_CURRENCY_SYMBOL . number_format($item['tier_price'], 2) . '</br>';
                                                            if ($item['is_taxable']) {
                                                                echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['tier_price'] + $item['tier_price'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                            }
                                                        } else {
                                                            echo '<tree class="your_price">Price </tree>' . DWS_CURRENCY_SYMBOL . number_format($item['price'], 2) . '</br>';
                                                            if ($item['is_taxable']) {
                                                                echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['price'] + $item['price'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                            }
                                                        }
                                                    }
//                                                    }
                                                    ?>
                                                </p>
                                                <p class="incre_decre">
                                                    <input name="key[]" type="hidden" id="key" value="<?php echo $item['rowid']; ?>" size="10">
                                                    <input name="product_id[]" type="hidden" id="product_id" value="<?php echo $item['id']; ?>" size="10">
                                                    <input name="price[]" type="hidden" id="price" value="<?php echo $item['price']; ?>" size="10">
                                                    <?php
                                                    if (isset($item['parent_price'])) {
                                                        ?>
                                                        <input name="parent_price[]" type="hidden" id="price" value="<?php echo $item['parent_price']; ?>" size="10">
                                                        <?php
                                                    }
                                                    ?>
                                                    <button type="button" class="altera decrescimo left decrease-qty" data-dir="dwn" ></button>
                                                    <input style="background:transparent;" name="quantity[]" class="input-field-btn qty-input txtAcrescimo" type="text" value="<?= $item['qty'] ?>" />
                                                    <input name="name[]" type="hidden" value="<?= $item['name'] ?>" />
                                                    <input name="moq[]" class="moq" type="hidden" value="<?= $item['moq'] ?>" />
                                                    <button type="button" class="altera acrescimo right increase-qty" data-dir="up" ></button>
                                                </p>
                                                <ul class="list-inline cart-remove-btn">
                                                    <li data-row-id="<?= $item['rowid'].'-'.$item['id'] ?>" class="delete-item-btn" ><a class="delete-item-btn" href="javascript:void(0)">Remove</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4 col-sm-4 col-lg-4 add_to_cart_right_col null-padding">
                                        </div>
                                    </div>
                                    <?php
                                }
                            endforeach;
                            ?>
                        </div>
                        <div class="col-xs-12 shoping-cart_buttons null-padding">
                            <ul class="list-inline">
                                <li><a class="common_button" href="<?= base_url() ?>"><span></span>CONTINUE SHOPPING</a></li>
                                <li id="update"><a class="common_button">UPDATE</a></li>
                                <li onclick="return confirm('Are you sure to remove all items from your cart ?')" ><a class="common_button" href="<?= base_url() ?>cart/clearbasket">CLEAR CART</a></li>
                                <li><a class="common_button" href="<?= base_url() . 'checkout' ?>">PLACE ORDER</a></li>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-md-4 col-sm-4 col-lg-4 cart_right">
                    <div class="col-xs-12 cart_left right_inner null-padding">
                        <ul class="list-inline">
                            <li>cart total </li>
                        </ul>
                        <ul class="list-inline">
                            <?php
//                            if ($this->session->userdata('CUSTOMER_ID')) {
                            ?>
                            <li class="grand-total-price">
                                <a href="javascript:void(0)">
                                    <span id='grand-total-span'>
                                        <?php
                                        if ($variables['cart_total']) {
                                            echo DWS_CURRENCY_SYMBOL . $this->cart->format_number($variables['cart_total']);
                                        } else {
                                            echo DWS_CURRENCY_SYMBOL . number_format(0, 2);
                                        }
                                        ?>
                                    </span>
                                </a>
                            </li>
                            <?php // } ?>
                        </ul>
                    </div>
                    <div class="col-xs-12 inner_price-list null-padding">
                        <p>
                            Price (<?= $this->cart->total_items(); ?> items)
                            <?php // if ($this->session->userdata('CUSTOMER_ID')) { ?>
                            <span><?= DWS_CURRENCY_SYMBOL . number_format($variables['cart_total'], 2); ?></span>
                            <?php // } ?>
                        </p>
                        <p>
                            VAT
                            <?php // if ($this->session->userdata('CUSTOMER_ID')) { ?>
                            <span><?= DWS_CURRENCY_SYMBOL . number_format($variables['vat'], 2); ?></span>
                            <?php // } ?>
                        </p>

                        <p>
                            Shipping
                            <span><?= DWS_CURRENCY_SYMBOL . number_format($variables['shipping'], 2); ?></span>
                        </p>

                        <!--<p>Delivery Charges <span><?//= DWS_CURRENCY_SYMBOL . ' ' . number_format($extra_data['shipping'], 2); ?></span></p>-->
                        <p>
                            Amount Payable
                            <span>
                                <?php
                                if ($variables['order_total']) {
                                    echo DWS_CURRENCY_SYMBOL . $this->cart->format_number($variables['order_total']);
                                } else {
                                    echo DWS_CURRENCY_SYMBOL . number_format(0, 2);
                                }
                                ?>
                            </span>
                        </p>
                    </div>
                    <!-- <div class="col-xs-12 payment-col null-padding">
                        <ul class="list-inline paymeny-ul">
                            <li><img src="images/cart_symbol.png" alt="loading"></li>
                            <li>Safe and Secure Payments. Easy Returns.</br>
                                100% Authentic products
                            </li>
                        </ul>
                        <p><img src="images/cards_a.png" alt="loading"></p>
                    </div> -->
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<!--model-->
<?php $this->load->view('themes/' . THEME . '/layout/model'); ?>
<!--mode-->
<!--my code end-->

<script type="text/javascript">
    $(document).ready(function () {
        $('.delete-item-btn').click(function () {
            var rowid = $(this).attr('data-row-id');
            if (rowid) {
                if (confirm('Are you sure to remove this item from your cart ?')) {
                    $.get('cart/delete/' + rowid, function (data3) {
                        if (data3 != '') {                            
                            gtag('event', 'remove_from_cart', {
                                "items": data3.jsonItem
                            });
                            alert('Cart Item Deleted');
                            setTimeout(function(){
                                location.reload()    
                            }, 200);                             
                        }
                    });
                }
            }
        });

        $('.decrease-qty').click(function () {
            var x = $(this).parent().parent().find('.qty-input');
            var y = parseInt(x.val());
            if (y > 1) {
                y--;
            }
            x.val(y);
        });

        $('.increase-qty').click(function () {
            var x = $(this).parent().parent().find('.qty-input');
            x.val(parseInt(x.val()) + 1)
        });

        $('.qty-input').change(function () {
            if ($(this).val() < 1) {
                $(this).val(1);
            }
        });

        var cartTotal = "<?php echo $cartTotal['cart_total']; ?>";
        var coupCode = "<?php
if (isset($cartTotal['coupon_code'])) {
    echo $cartTotal['coupon_code'];
}
?>";

        if (coupCode) {
            if (cartTotal == 0) {
                $.get('coupon/del_exist_coupon/' + coupCode, function (data) {
                    if (data != '') {
                        location.reload();
                    }
                }, 'JSON');
            }
        }

        $("#apply-coupon-btn").on("click", function () {
            get_coupon_discount();
        });

        function get_coupon_discount() {
            var cpCode = $("#coupon-input").val();
            var list = '';
            if (cpCode != '') {
                $.get('coupon/check_coupon/' + cpCode, function (data) {
                    if (data != '') {
                        if (data.result == "Coupon Applied") {
                            location.reload();
                        } else {
                            alert(data.result);
                        }
                    }
                }, 'JSON');
            }
        }

        $('#remove-coupon').click(function () {
            remove_coupon();
        });

        function remove_coupon() {
            var coupon_code = $('#coupon-input').val();

            $.post('coupon/del_coupon',
                    {
                        coupon_code: coupon_code
                    },
                    function (data, status) {
                        if (status == 'success') {
                            location.reload();
                        }
                    });
        }
    });

    $(document).on("click", "#update", function () {
        $("#cartFrm").submit();
    });

    $('.wishlist-li-btn').click(function () {
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
                        product_id: current_element.attr('data-product-id'),
                        data_product_img: current_element.attr('data-product-img')
                    },
                    function (data, status) {
                        console.log(status);
                        if (data == 'added') {
                            $("#wishlistModal").modal("show");
                            $(".modal-title").html("Product Added To Your Wishlist ").css('color', 'green');
//                                current_element.attr('src', 'images/icon/heart-icon-range2.png');
                            current_element.html('<span style="color:#ff6c00;" ><i style="cursor:pointer;" class="fa fa-heart" aria-hidden="true"></i></span>');
                        } else {
                            $("#wishlistModal").modal("show");
                            $(".modal-title").html("Product Removed From Your Wishlist ").css('color', 'red');
//                                current_element.attr('src', 'images/icon/heart-icon-range.png');
                            current_element.html('<span><i style="cursor:pointer;" class="fa fa-heart-o" aria-hidden="true"></i></span>');
                        }
                    });
        } else {
            alert('Please sign-in first !');
        }
    });

</script>
