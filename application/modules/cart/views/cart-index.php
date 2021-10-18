<style>
    .txtAcrescimo {
        text-align: center;
        width: 35px;
        border-color: transparent;
        font-size: 17px;
        color: #818181
    }

    #update {
        cursor: pointer
    }

    .pro-img-tiny {
        /* height: auto;
        width: 100%;
        max-width: 100%;
        max-height: 100% */
        margin: auto;
        display: table;
    }

    #find-location {
        display: none
    }
</style>
<?php
$cartItems = $this->cart->contents();
$cartTotal = $this->session->userdata('cart_contents');
?>
<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Wish list</a></li>
            </ul>
        </div>
    </div>
</section>
<section id="cart_section">
    <div class="container-fluid site-container">
        <?php
        if ($this->cart->total_items() == 0) {
            echo '<div class="cart-outer col-xs-12"><p class="empty-basket">There are no items in your wish list.</p></div>';
        }
        $cartItems = $this->cart->contents();
        if ($cartItems) {
        ?>
            <div class="col-xs-12 main_cart_column null-padding">
                <div class="col-xs-12 col-sm-7 cart_left-upper null-padding ">

                    <form id="cartFrm" name="cartFrm" method="post" action="cart/update">
                        <div class="col-xs-12 products_cart null-padding">
                            <div class="col-xs-12 add_to_cart_col null-padding table-responsive">
                                <table class="common-cart-col-table">
                                    <?php
                                    foreach ($this->cart->contents() as $item) {
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
                                            <tr>
                                                <td>
                                                    <div>
                                                        <img class="pro-img-tiny" src="<?= $img_url; ?>" alt="<?= $item['order_item_name'] ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-xs-12 cart_inner_right null-padding">
                                                        <div class="product-inner-details-div">
                                                            <p><?= $item['name'] ?></p>
                                                            <p class="cart-sku">sku <?= $item['product_sku'] ?></p>
                                                            <span>
                                                                <?php
                                                                $order_item_options = json_decode($item['order_item_options']);
                                                                if (isset($order_item_options)) {
                                                                    if ($order_item_options) {
                                                                ?>
                                                                        <?php
                                                                        foreach ($order_item_options as $key => $value) {

                                                                        ?>
                                                                            <span class="small-name">
                                                                                <?php
                                                                                echo str_replace("_", " ", $key) . ' : ' . $value;
                                                                                ?>
                                                                            </span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                        <div class="cart_inner_right-div remove_qty">
                                                            <ul class="list-inline cart-remove-btn" style="position : static;">
                                                                <li data-row-id="<?= $item['rowid'] . '-' . $item['id'] ?>" class="delete-item-btn">
                                                                    <a class="delete-item-btn" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- <span>
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
                                                        </span> -->


                                                    </div>
                                                </td>
                                                <!-- <td class="cart_inner_right cart_quantity">
                                                    <p class="incre_decre" style="padding-right: 10px; display: none;">
                                                        <input name="key[]" type="hidden" id="key" value="<?php echo $item['rowid']; ?>" size="10">
                                                        <input name="product_id[]" type="hidden" id="product_id" value="<?php echo $item['id']; ?>" size="10">
                                                        <input name="price[]" type="hidden" id="price" value="<?php echo $item['price']; ?>" size="10">
                                                        <button type="button" class="altera decrescimo left decrease-qty" data-dir="dwn"></button>
                                                        <input style="background:transparent;" name="quantity[]" class="input-field-btn qty-input txtAcrescimo" type="text" value="<?= $item['qty'] ?>" />
                                                        <input name="name[]" type="hidden" value="<?= $item['name'] ?>" />
                                                        <input name="moq[]" class="moq" type="hidden" value="<?= $item['moq'] ?>" />
                                                        <button type="button" class="altera acrescimo right increase-qty" data-dir="up"></button>
                                                    </p>
                                                </td> -->
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>

                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-5 cart_right">
                    <div class="col-xs-12 common-heading-col">
                        <p class="arrow-heading">Your Enquiry</p>
                    </div>
                    <form id="product_enquiryForm" action="" method="post">
                        <div class="col-xs-12 cart_left right_inner null-padding">
                            <div class="alert alert-danger" id="enquiryAlert" style="display: none;"></div>

                            <div class="form-group">
                                <label>Your Name *</label>
                                <input type="text" class="form-control" name="enquiry_name" />
                            </div>
                            <div class="form-group">
                                <label>Your Email *</label>
                                <input type="email" class="form-control" name="enquiry_email" />
                            </div>
                            <div class="form-group">
                                <label>Phone *</label>
                                <input type="email" class="form-control" name="phone" />
                            </div>
                            <div class="form-group">
                                <label>Your Message/Query *</label>
                                <textarea class="form-control" rows="2" name="enquiry_message"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha cap-width-100" data-sitekey="<?= DWS_RECAPTCHA_SITE_KEY ?>"></div>
                            </div>
                            <div class="form-group">
                                <input id="submit_cart_enquiry" type="submit" class="btn btn-primary" value="Submit enquiry" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.blockui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.delete-item-btn').click(function() {
            var rowid = $(this).attr('data-row-id');
            if (rowid) {
                if (confirm('Are you sure to remove this item from your wish list ?')) {
                    $.get('cart/delete/' + rowid, function(data3) {
                        if (data3 != '') {
                            gtag('event', 'remove_from_cart', {
                                "items": data3.jsonItem
                            });
                            alert('wish list Item Deleted');
                            setTimeout(function() {
                                location.reload()
                            }, 200);
                        }
                    });
                }
            }
        });

        $('.decrease-qty').click(function() {
            var x = $(this).parent().parent().find('.qty-input');
            var y = parseInt(x.val());
            if (y > 1) {
                y--;
            }
            x.val(y);
        });

        $('.increase-qty').click(function() {
            var x = $(this).parent().parent().find('.qty-input');
            x.val(parseInt(x.val()) + 1)
        });

        $('.qty-input').change(function() {
            if ($(this).val() < 1) {
                $(this).val(1);
            }
        });
    });

    $(document).on("click", "#update", function() {
        $("#cartFrm").submit();
    });

    $('#submit_cart_enquiry').click(function(e) {
        e.preventDefault();
        $('body').block({
            message: 'Processing...'
        });
        var enquiryForm = $('#product_enquiryForm').serialize();
        $.ajax({
            url: "<?php echo base_url('cart/saveEnquiry'); ?>",
            type: 'POST',
            data: enquiryForm,
            success: function(result) {
                var res = JSON.parse(result);
                if (res.success) {
                    $('#enquiryAlert').hide();
                    window.location = res.redirect_url;
                } else {
                    $('#enquiryAlert').html(res.message);
                    $('#enquiryAlert').show();
                }
                $('body').unblock();
            }
        });
    });
</script>