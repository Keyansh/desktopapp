<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".ship").click(function() {
            if ($(this).is(':checked')) {
                
                $('.selects').val($('#selects').val());
                $('#s_first_name').val("<?php echo $customer['first_name']; ?>");
                $('#s_last_name').val("<?php echo $customer['last_name']; ?>");
                $('#s_address1').val("<?php echo $customer['address1']; ?>");
                $('#s_address2').val("<?php echo $customer['address2']; ?>");
                $('#s_city').val("<?php echo $customer['city']; ?>");
                $('#s_county').val("<?php echo $customer['state']; ?>");
                $('#s_postcode').val("<?php echo $customer['zipcode']; ?>");
                $('#s_phone').val("<?php echo $customer['phone']; ?>");
            } else {
                $('.selects').val("");
                $('#s_first_name').val("");
                $('#s_last_name').val("");
                $('#s_address1').val("");
                $('#s_address2').val("");
                $('#s_city').val("");
                $('#s_county').val("");
                $('#s_postcode').val("");
                $('#s_phone').val("");
            }
        });
    });
</script>
<div class="row collapse">
    <div class="small-12 columns">
        <h1>Checkout</h1>
    </div>
</div>
<div class="row collapse">
    <div class="small-12 columns">
        <div id="ctx_menu" class="corner4"><a href="customer/dashboard">My Account</a> | <a href="customer/profile/edit/">Edit Account</a> | <a href="customer/order">My Orders</a> | <a href="customer/password/changepassword">Change Password</a> | <a href="customer/logout">Logout</a></div>
        <?php $this->load->view('inc-messages'); ?>
        <form id="cartFrm" name="cartFrm" method="post" action="cart/cart/update/1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_grid">
                <tr>
                    <th width="1%"></th>
                    <th width="59%">Item</th>
                    <th width="10%">Quantity</th>
                    <th width="10%">Price</th>
                    <th width="10%">Amount</th>
                    <th width="10%">Action</th>
                </tr>
                <?php
                foreach ($this->cart->contents() as $item) {
                    $options = '';
                    if ($this->cart->has_options($item['rowid'])) {
                        $options = $this->cart->product_options($item['rowid']);
                    }
                    ?>
                    <tr>
                    <!--  <td><img src="<?php // echo resize($this->config->item('MODEL_IMAGE_PATH') . $options['image'], 94, 74, 'product_images');      ?>"></td>-->
                        <td></td>
                        <td><?php echo $item['name']; ?>
                            <?php if ($options) { ?> (
                                <?php
                                foreach ($options as $key => $val) {
//                                    $key = $this->Cartmodel->GetOptions($key);
                                    ?>
                                    <?php if ($key != 'image') { ?>
                                        <span class="lg_text" style="color:#02A3C6;"><b><?php echo $key; ?>:</b> </span> <?php echo $val; ?>
                                        <?php
                                    }
                                }
                                ?> )
                            <?php } ?>
                        </td>
                        <td><input name="quantity[]" type="text" class="inputfield width_70" id="quantity" value="<?php echo $item['qty']; ?>" size="3"></td>
                        <td><?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $item['price']; ?></td>
                        <td><?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $this->cart->format_number($item['price'] * $item['qty']); ?></td>
                        <td><a href="cart/delete/<?php echo $item['rowid']; ?>" onclick="return confirm('Are you sure you want to remove this item?');">Delete </a></td>
                    <input name="key[]" type="hidden" id="key" value="<?php echo $item['rowid']; ?>" size="10">
                    <input name="product_id[]" type="hidden" id="product_id" value="<?php echo $item['id']; ?>" size="10">
                    </tr>
                <?php } ?>
            </table>
            <div style="float: right; margin: 10px 0px 10px;"><input type="image" src="images/btn-update-cart.png" width="130" height="32"></div>
        </form>
        <?php if ($this->cart->total_items() == 0) { ?>"
            <p align="center" style="padding-top:20px; padding-bottom:20px; color: #CC0000"><strong>Your shopping cart is currently empty!</strong></p>
            <?php
            return;
        }
        ?>
        <div class="clear"></div>
        <div class="hr_dotted"></div>
        <div class="row">
            <h3 style="font-size: 18px; font-weight: normal; margin-left: 565px; margin-bottom: -10px; color: #1061A7">  <input type="checkbox" class="ship"/> Shipping address is as billing address</h3>
        </div>
        <form id="checkoutfrm" name="checkoutfrm" method="post" action="checkout">
            <div class="row">
                <div class="column binder" style="width: 45%; float: left; margin-right: 40px"> 
                    <h3 style="font-size: 18px; font-weight: normal; padding: 5px; background: #F4F4F4; color: #1061A7">Billing Details</h3>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Title <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <div class="small-8 columns">
                                <?php echo form_dropdown('title', $title, set_value('title', $customer['title']), 'id="selects" class="select"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">First Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $customer['first_name']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Last Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $customer['last_name']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Email <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="email" id="email" placeholder="Email" value="<?php echo $customer['email']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 1 <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="address1" id="address1" placeholder="Address 1" value="<?php echo $customer['address1']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 2</label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield"  name="address2"  id="address2" placeholder="Address 2" value="<?php echo $customer['address2']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Town/City <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" id="city" name="city" placeholder="Town/City"  value="<?php echo $customer['city']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">County <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="county" id="county" placeholder="County/state"  value="<?php echo $customer['state']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Postal Code <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="postcode" id="postcode" placeholder="Postal Code"  value="<?php echo $customer['zipcode']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Phone <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="phone" id="phone" placeholder="Phone"  value="<?php echo $customer['phone']; ?>">
                        </div>
                    </div>
                </div>
                <div class="column binder" style="width: 45%; float: left; margin-right: 40px"> 
                    <h3 style="font-size: 18px; font-weight: normal; padding: 5px; background: #F4F4F4; color: #1061A7">Shipping Details</h3>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Title <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <div class="small-8 columns">
                                <?php echo form_dropdown('s_title', $title, set_value('s_title', $customer['s_title']), 'class="select selects"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">First Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="s_first_name" id="s_first_name" placeholder="First Name"  value="<?php echo $customer['s_first_name']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Last Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="s_last_name" id="s_last_name" placeholder="Last Name"  value="<?php echo $customer['s_last_name']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 1 <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield"  name="s_address1" id="s_address1" placeholder="Address 1 "  value="<?php echo $customer['s_address1']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 2</label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield"  name="s_address2" id="s_address2" placeholder="Address 2" value="<?php echo $customer['s_address2']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Town/City <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="s_city" id="s_city" placeholder="Town/City"  value="<?php echo $customer['s_city']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">County <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield"  name="s_county" id="s_county" placeholder="County/state"  value="<?php echo $customer['s_state']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Postal Code <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield"  name="s_postcode"  id="s_postcode" placeholder="Postal Code"  value="<?php echo $customer['s_zipcode']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Phone <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield" name="s_phone" id="s_phone" placeholder="Phone"  value="<?php echo $customer['s_phone']; ?>">
                        </div>
                    </div>
                </div>

            </div>

            <div class="clear"></div>
            <div class="row" style="margin-top: 50px">
                <div class="" style="width:146px; float: left; padding: 6px">
                    <label for="label" class="inline">Add Order Number<span class="error">*</span></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" class="inputfield" name="cus_order_num" id="s_phone" placeholder="Order Number"  value="">
                </div>
            </div>
             <div class="clear"></div>
            <div class="row">
                <div class="small-12 columns"><p align="right">Fields marked with<span class="error">*</span> are required.</p></div>
            </div>
            <div class="row">
                <!--<div class="small-12 columns"><input type="image"  value="Worldpay" name="worldpay" src="assets/themes/default/images/btn-checkout.png" width="139" height="32" align="right"></div>-->
                <div class="small-6 columns" style="float: right"><input type="submit" value="Checkout" name="paypal" src="assets/themes/default/images/btn-checkout.png" width="139" height="32" align="right" class="pp"></div>
            </div>
        </form>

        <div class="clear"></div>
        <div class="hr_dotted"></div>
        <div class="shipping_box">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td align="right" valign="top">
                            Sub Total<br>
                            Shipping Charges<br>
                            <span>Final Order Total</span>
                        </td>
                        <td align="right" valign="top">
                            <?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($cart_total); ?><br />
                            <?php echo DWS_CURRENCY_SYMBOL; ?><?php // echo DWS_SHIPPING; ?><br />
                            <span><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($order_total); ?></span><br />
                        </td>
                    </tr>
                </tbody>
            </table>
<!--            <table width="25%" cellpadding="0" cellspacing="0" border="2" align="right">
                <tr><td>Sub Total</td><td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($cart_total); ?></td></tr>
                <tr><td>Shipping Charges</td><td><?php echo DWS_CURRENCY_SYMBOL; ?><?php // echo DWS_SHIPPING; ?></td></tr>
                <tr><td>Final Order Total</td><td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($order_total); ?></td></tr>
            </table>-->
        </div>
    </div>
</div>

