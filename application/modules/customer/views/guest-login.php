<?php // echo '<pre>'; print_r($customer); exit;            ?>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".select option[value='<?php echo $title ?>']").attr('selected', 'selected');
        $(".ship").click(function () {
            var selec = $('.select').val();

            if ($(this).is(':checked')) {
                $(".select option[value='" + selec + "']").attr('selected', 'selected');
                $('#s_first_name').val($('#first_name').val());
                $('#s_last_name').val($('#last_name').val());
                $('#s_address1').val($('#address1').val());
                $('#s_address2').val($('#address2').val());
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
                $('#s_address2').val("");
                $('#s_city').val("");
                $('#s_county').val("");
                $('#s_postcode').val("");
                $('#s_phone').val("");
                $('#s_country').val("");
            }
            $(".shipping").trigger("change");
        });
    });

    function getShipping() {
    }


</script>

<script>
    $(document).ready(function () {
//        $('#demo2').on('change', function () {
//           $('#s_country option[value="' + $(this).val() + '"]').prop('selected', true);
//       })
        $('#demo2').click(function () {
            $.blockUI({css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }});

            setTimeout($.unblockUI, 2000);
        });
    });</script>
<div>
    <h1>Guest Login</h1>
</div>
<div class="row collapse">
    <div class="small-12 columns">
        <?php $this->load->view('inc-messages'); ?>
        <form id="cartFrm" name="cartFrm" method="post" action="cart/cart/update/1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_grid">
                <tr>
                    <th width="1%"></th>
                    <th width="59%">Item</th>
                    <th width="7%">Quantity</th>
                    <th width="7%">Price</th>
                    <th width="7%">Weight(gms)</th>
                    <th width="7%">Amount</th>
                    <th width="7%">Action</th>
                </tr>
                <?php
                foreach ($this->cart->contents() as $item) {
                    $options = '';
                    if ($this->cart->has_options($item['rowid'])) {
                        $options = $this->cart->product_options($item['rowid']);
                    }
                    ?>
                    <tr>
                            <!--<td><img src="<?php // echo resize($this->config->item('MODEL_IMAGE_PATH') . $options['image'], 94, 74, 'product_images');              ?>"></td>-->
                        <td></td>
                        <td><?php
                            $this->load->model('cart/cartmodel');
                            $alias = $this->cartmodel->getDetail($item['id']);
                            ?>
                            <a href="<?= base_url() ?>catalog/product/index/<?= $alias['product_alias']; ?>"><?= $item['name']; ?></a>
                            <?php if ($options) { ?> (
                                <?php
                                foreach ($options as $key => $val) {
                                    $key = $this->Cartmodel->GetOptions($key);
                                    ?>
                                    <?php if ($key != 'image') { ?>
                                        <span class="lg_text" style="color:#02A3C6;"><b><?php echo $key; ?>:</b> </span> <?php echo $val; ?>,
                                        <?php
                                    }
                                }
                                ?> )
                            <?php } ?>
                        </td>
                        <td><input name="quantity[]" type="text" class="inputfield width_70" id="quantity" value="<?php echo $item['qty']; ?>" size="3"></td>
                        <td><?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $item['price']; ?></td>
                        <td><?php echo isset($item['weight']) ? $item['weight'] * $item['qty'] : '0.00'; ?></td>
                        <td><?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $this->cart->format_number($item['price'] * $item['qty']); ?></td>
                        <td><a href="cart/delete/<?php echo $item['rowid']; ?>" onclick="return confirm('Are you sure you want to remove this item?');">Delete </a></td>
                    <input name="key[]" type="hidden" id="key" value="<?php echo $item['rowid']; ?>" size="10">
                    <input name="product_id[]" type="hidden" id="product_id" value="<?php echo $item['id']; ?>" size="10">
                    </tr>

                <?php } ?>
                <tr>
                    <td colspan="2">
                        <div style="margin-left:10px;">														
                            <?= $delivery_details['title']; ?>
                            <ul style="margin-left:20px;">
                                <?php foreach ($delivery_details['options'] as $index => $optItem) { ?>
                                    <li> <input <?= $delivery_index == $index ? 'checked' : '' ?>
                                            type="radio" 
                                            name="delivery" 
                                            value=<?= $index; ?> >&#160;&#160;&#160;&#160;<?= $optItem['text'] . ' - &pound;' . $optItem['val'] ?></li>
                                    <?php } ?>
                            </ul>
                        </div>
                    </td>					
                    <td colspan="6">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
                            <tr>
                                <th>Cart Total:</th>
                                <td width="24%"><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($cart_total); ?></td> 
                            </tr>
                            <?php if ($discount) { ?>
                                <tr>
                                    <td>Discount:</td>
                                    <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($discount); ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th>Total (Exclusive Vat):</th>
                                <td><strong><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($order_total); ?></strong></td>
                            </tr>
                            <tr>
                                <th>Total (Inclusive Vat <?php echo DWS_VAT . '%' ?>):</th>
                                <td><strong><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $vat_order_total; ?></strong></td>
                            </tr>
                        </table> 


                    </td>

                </tr>
            </table>

            <div style="float: right; margin: 10px 0px 10px;"><input class="" type="image" src="images/btn-update-cart.png"></div>
        </form>

        <form id="checkoutfrm" name="checkoutfrm" method="post" action="customer/login/guest">
            <div style="float: leftt; margin: 10px 0px 10px; width: 99.6%;">
                <textarea name="comment" placeholder="Write your comment here.." rows="5" style="width: 100%;"></textarea>
            </div>
            <div class="hr_dotted"></div>
            <div class="row">
                <h3 style="margin-bottom: 29px; margin-top: 45px; margin-left: 580px; font-size: 17px;">  <input type="checkbox" class="ship"/> Shipping address is as billing address</h3>
            </div>
            <div class="row detail_box">
                <div class="small-6 columns cart_left_side_section">
                    <h3>Billing Details</h3>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Title <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <div class="small-8 columns">
                                <?php echo form_dropdown('title', $title, set_value('title'), 'class="select textfield width_95"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">First Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" id="first_name" name="first_name" placeholder="First Name" value="<?= set_value('first_name'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Last Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="last_name" id="last_name" placeholder="Last Name" value="<?= set_value('last_name'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Email <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="email" id="email" placeholder="Email" value="<?= set_value('email'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 1 <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="address1" id="address1" placeholder="Address 1" value="<?= set_value('address1'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 2</label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95"  name="address2"  id="address2" placeholder="Address 2" value="<?= set_value('address2'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Town/City <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" id="city" name="city" placeholder="Town/City"  value="<?= set_value('city'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">County <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="county" id="county" placeholder="County/state"  value="<?= set_value('county'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Postal Code <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="postcode" id="postcode" placeholder="Postal Code"  value="<?= set_value('postcode'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Country <span class="error">*</span></label>
                        </div>                       
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="country" id="country" placeholder="country"  value="United kingdom">
                            <?php // echo form_dropdown('country', $countries, $customer['country'], " id='demo2' class='textfield width_95'");    ?>
                        </div>                                               
                    </div>

                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Phone <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="phone" id="phone" placeholder="Phone"  value="<?= set_value('phone'); ?>">
                        </div>
                    </div>
                </div>
                <div class="small-6 columns cart_right_side_section">
                    <h3>Shipping Details</h3>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Title <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <div class="small-8 columns">
                                <?php echo form_dropdown('s_title', $title, set_value('s_title'), 'class="select textfield width_95"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">First Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="s_first_name" id="s_first_name" placeholder="First Name"  value="<?= set_value('s_first_name'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Last Name <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="s_last_name" id="s_last_name" placeholder="Last Name"  value="<?= set_value('s_last_name'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 1 <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95"  name="s_address1" id="s_address1" placeholder="Address 1 "  value="<?= set_value('s_address1'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Address 2</label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95"  name="s_address2" id="s_address2" placeholder="Address 2" value="<?= set_value('s_address2'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Town/City <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="s_city" id="s_city" placeholder="Town/City"  value="<?= set_value('s_city'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">County <span class="error"> *</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95"  name="s_county" id="s_county" placeholder="County/state"  value="<?= set_value('s_county'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Postal Code <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield shipping textfield width_95"  name="s_postcode"  id="s_postcode" placeholder="Postal Code"  value="<?= set_value('s_postcode'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Country <span class="error">*</span></label>
                        </div>                       
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="s_country" id="s_country" placeholder="country"  value="United kingdom">
                            <?php // echo form_dropdown('s_country', $countries, set_value('s_country'), " id='s_country' class='textfield width_95 shipping'");    ?>
                        </div>                                               
                    </div>                    
                    <div class="row">
                        <div class="small-4 columns">
                            <label for="label" class="inline">Phone <span class="error">*</span></label>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" class="inputfield textfield width_95" name="s_phone" id="s_phone" placeholder="Phone"  value="<?= set_value('s_phone'); ?>">
                        </div>
                    </div>
                </div>

            </div>
            <div class="clear"></div>
            <div class="bottom_btn_pepal">
                <div class="row">
                    <div class="small-6 columns"> <p> </p></div>
                    <div class="small-6 columns text-left"><p>Fields marked with<span class="error">*</span> are required.</p></div>
                </div>
                <div class="commoncls p-b-c col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding mar-top-20">
                                                                    <p class="p1">Pay with paypal</p>
                                                                    <div class="p-b-c-inner col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">

                                                                        <div class=" col-xs-6 col-sm-9 col-md-9 col-lg-10">
                                                                            <div class="btn-group" data-toggle="buttons">
                                                                                <label class="btn btn-success ajaxpay paycls">
                                                                                    <input value="Paypal" name="paymenttype" type="radio" autocomplete="off">
                                                                                    <span class="glyphicon glyphicon-ok"></span>
                                                                                </label>
                                                                            </div>
                                                                            <img src="<?php echo base_url(); ?>images/pl.png" alt="" />
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cart-btns-col padding-zero">
                                                                        <ul class="list-inline cart-btns-ul">
                                                                            <li><button type="submit" class="btn btn-info check-btn sbtbutton">Order Now</button></li>

                                                                        </ul>
                                                                    </div>
                                                                </div>

            </div>
        </form>
        <div class="hr_dotted"></div>
    </div>
</div>

