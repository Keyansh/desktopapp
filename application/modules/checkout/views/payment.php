<!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>-->
<script type="text/javascript">
    $(document).ready(function () {
//        $(".select option[value='<?php // echo $customer['title']                 ?>']").attr('selected', 'selected');
        $(".ship").on('click', function () {
            var selec = $('.select').val();

            if ($(this).is(':checked')) {
                $(".select option[value='" + selec + "']").attr('selected', 'selected');
                $('#s_first_name').val($('#first_name').val());
                $('#s_last_name').val($('#last_name').val());
                $('#s_address1').val($('#address1').val());
//                $('#s_address2').val($('#address2').val());
                $('#s_city').val($('#city').val());
                $('#s_county').val($('#county').val());
                $('#s_postcode').val($('#postcode').val());
                $('#s_phone').val($('#phone').val());
                $('#s_country').val($('#country').val());
//                $('#s_country option[value="' + $('#demo2').val() + '"]').prop('selected', true);
            } else {

                //   $('.select').val("");
                $('#s_first_name').val("");
                $('#s_last_name').val("");
                $('#s_address1').val("");
//                $('#s_address2').val("");
                $('#s_city').val("");
                $('#s_county').val("");
                $('#s_postcode').val("");
                $('#s_phone').val("");
                $('#s_country').val("");
            }
            $(".shipping").trigger("change");
        });

        $('#PayByPhone').on('click', function () {
            $("#pay_by_phone").val(1);
        });
    });

</script>


<section id="process-steps">
    <div class="container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 process-steps-main-col">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 process-steps-inner-col">

                <ul class="nav nav-tabs process-tabs nav-justified">
                    <li>
                        <a href="checkout">
                            <div class="tab-head">
                                <img src="images/tab1.png" class="img-responsive"/>
                            </div>
                            Cart
                        </a>
                    </li>
                    <li>
                        <a href="checkout/login">
                            <div class="tab-head">
                                <img src="images/tab2.png" class="img-responsive"/>
                            </div>
                            Login
                        </a>
                    </li>
                    <li class="active">
                        <a data-toggle="tab" href="#payment">
                            <div class="tab-head">
                                <img src="images/tab3.png" class="img-responsive"/>
                            </div>
                            Payment
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="tab-head">
                                <img src="images/tab4.png" class="img-responsive"/>
                            </div>
                            Confirm
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="payment" class="tab-pane fade in active">

                        <!--This inner must be in every process step-->
                        <div class="process-tabs-inner">
                            <div class="payment-area-col">
                                <p class="form-group-header">Order Summery</p>
                                <p class="total-price"><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($extra_data['cart_total'] + $extra_data['shipping'] - $discount); ?></p>

                                <div class="centered-fixed">

                                    <table width="100%" class="total-price-table">
                                        <!--Bought Items Table Row-->
                                        <tr>
                                            <td class="parent-td">
                                                <!--Bought Items Table-->
                                                <table width="100%" class="total-price-inner-table items-table">
                                                    <?php
                                                    $cartItems = $this->cart->contents();
//                            e($cartItems);
                                                    foreach ($this->cart->contents() as $item) {
                                                        if (is_array($item)) {
                                                            $orientations = isset($item['orientations']) ? $item['orientations'] : '';
                                                            if (!empty($item['img'])) {
                                                                $subcatimg = $this->config->item('PRODUCT_URL') . $item['img'];
                                                            } else {
                                                                $subcatimg = 'images/no-image.jpg';
                                                            }
                                                            $options = '';
                                                            if ($this->cart->has_options($item['rowid'])) {
                                                                $options = $this->cart->product_options($item['rowid']);
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?= $item['name']; ?></td>
                                                                <td><?php echo $item['qty']; ?></td>
                                                                <td><?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $this->cart->format_number($item['price'] * $item['qty']) ? $this->cart->format_number($item['price'] * $item['qty']) : 0; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </table>
                                            </td>
                                        </tr>
                                        <!--Bought Items Price/Tax Row-->
                                        <tr>
                                            <td class="parent-td">
                                                <!--Bought Items Price/Tax Table-->
                                                <table width="100%" class="total-price-inner-table items-price-table">
                                                    <tr>
                                                        <td>Bag Total</td>
                                                        <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($extra_data['subtotal'], 2); ?></td>
                                                    </tr>
                                                    <?php
                                                    $discount = isset($extra_data['discounted_amount']) ? $extra_data['discounted_amount'] : 0;
                                                    if ($discount) {
                                                        ?>
                                                        <tr>
                                                            <td>Bag Discount</td>
                                                            <td>&pound; <?= number_format($discount, 2) ?></td>
                                                        </tr>
                                                    <?php } ?>                                                    
                                                    <tr>
                                                        <td>Estimated Tax</td>
                                                        <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($extra_data['tax'], 2); ?></td>
                                                    </tr>
                                                    <?php if (isset($extra_data['shipping'])) { ?>
                                                        <tr>
                                                            <td>Delivery Charges</td>
                                                            <td><?= '&pound;&nbsp;' . number_format($extra_data['shipping'], 2); ?></td>
                                                        </tr>
                                                    <?php } ?>   
                                                </table>
                                            </td>
                                        </tr>
                                        <!--Bought Items Price/Tax Row-->
                                        <tr>
                                            <td>
                                                <table width="100%" class="total-price-inner-table grand-total">
                                                    <tr>
                                                        <td>Order Total</td>
                                                        <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($extra_data['cart_total'] + $extra_data['shipping'] - $discount); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <?php
                                $this->load->view('inc-messages');
                                if ($this->cart->total_items() == 0) {
                                    echo '<p>There are no items in your wish list.</p>';
                                    return;
                                }
                                ?>
                                <div class="col-lg-12 col-sm-12 col-xs-12">
                                    <form id="checkoutfrm" name="checkoutfrm" method="post" action="checkout/paymentreview" class="final-checkout-form">
                                        <div class="checkout-form-col col-lg-6 col-sm-6 col-xs-12 form-group-col">
                                            <ul class="list-inline checkout-page-ul">
                                                <li><p class="form-group-header">Billing details</p></li>
                                            </ul>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name *" value="<?php echo set_value('first_name', $customer['first_name']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name *" value="<?php echo set_value('last_name', $customer['last_name']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Contact Number *"  value="<?php echo set_value('phone', $customer['phone']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="address1" id="address1" placeholder="Address *" value="<?php echo set_value('address1', $customer['uadd_address_01']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="city" name="city" placeholder="Town/City *"  value="<?php echo set_value('city', $customer['uadd_city']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postal Code *"  value="<?php echo set_value('postcode', $customer['uadd_post_code']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="county" id="county" placeholder="County *"  value="<?php echo set_value('county', $customer['uadd_county']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="country" id="country" placeholder="country"  value="United kingdom" required>
                                            </div>

                                        </div>
                                        <div class="checkout-form-col col-lg-6 col-sm-6 col-xs-12 form-group-col">
                                            <ul class="list-inline checkout-page-ul">
                                                <li><p class="form-group-header">Shipping Address</p></li>
                                                <li>
                                                    <label class="al-new-select">
                                                        <input type="checkbox" class="ship"/>
                                                        <span class="cstm-checkbox"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                        <span class="name">same as billing address</span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="s_first_name" id="s_first_name" placeholder="First Name *"  value="<?php echo set_value('s_first_name'); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="s_last_name" id="s_last_name" placeholder="Last Name *"  value="<?php echo set_value('s_last_name'); ?>" required>
                                            </div>                        
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="s_phone" id="s_phone" placeholder="Contact Number *"  value="<?php echo set_value('s_phone'); ?>" required>
                                            </div>   
                                            <div class="form-group">
                                                <input type="text" class="form-control"  name="s_address1" id="s_address1" placeholder="Address *"  value="<?php echo set_value('s_address1'); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="s_city" id="s_city" placeholder="Town/City *"  value="<?php echo set_value('s_city'); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="inputfield shipping form-control"  name="s_postcode"  id="s_postcode" placeholder="Postal Code *"  value="<?php echo set_value('s_postcode'); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control"  name="s_county" id="s_county" placeholder="County *"  value="<?php echo set_value('s_county'); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="s_country" id="s_country" placeholder="Country *"  value="United kingdom" required>
                                            </div>

                                            <!--<button type="button" class="btn btn-info checkout-update-btn">Update</button>-->


                                        </div>
                                        <div class="pay-via">
                                            <p>Pay via</p>
                                            <input type="image" src="images/paypal.png" class="img-responsive" style="margin: auto"/>
                                        </div>
                                    </form>
                                </div>

                            </div>





                        </div>

                    </div>                    

                </div>

            </div>

        </div>
    </div>
</section>