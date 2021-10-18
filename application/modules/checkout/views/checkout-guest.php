<script type="text/javascript">
    $(document).ready(function () {
        $(".ship").on('click', function () {
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
            } else {
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

        $('#PayByPhone').on('click', function () {
            $("#pay_by_phone").val(1);
        });
    });

</script>

<script>
    $(document).ready(function () {
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


<section id="cart-section">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cart-main-col">
            <h2>Checkout</h2>
            <?php
            if ($this->cart->total_items() == 0) {
                echo '<p>There are no items in your wish list.</p>';
                return;
            }
            ?>
            <form id="cartFrm" name="cartFrm" method="post" action="cart/update">
                <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-zero">

                    <table class="cart-table" width="100%">
                        <tbody>
                            <tr>
                                <th>Product Name</th>
                                <th>Unit Price </th>
                                <th>Quantity </th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                            <?php
                            foreach ($this->cart->contents() as $item) {
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
                                    <td>
                                        <ul class="list-inline cart-table-ul">
                                            <li>
                                                <div class="td-img-col">
                                                    <img src="<?= $subcatimg; ?>" class="img-responsive" style="width: 50px">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="td-text-col">
                                                    <?php
                                                    $this->load->model('cart/cartmodel');
                                                    $alias = $this->cartmodel->getDetail($item['id']);
                                                    ?>
                                                    <a class="cart-product-name" href="<?= base_url() . $alias['uri']; ?>"><?= $item['name']; ?></a>
                                                    <?php if ($options) {
                                                        ?> (
                                                        <?php foreach ($options as $key => $val) {
                                                            ?>
                                                            <?php if ($key) { ?>

                                                                <span class="lg_text"><b><?php echo $key; ?>:</b> </span> <?php echo $val; ?>
                                                                <?php
                                                            }
                                                        }
                                                        ?> )
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $this->cart->format_number($item['price']); ?>
                                    </td>
                                    <td>
                                        <div class="input-group spinner">
                                            <input name="quantity[]" type="number" class="qtn_textfield iqty form-control" id="quantity" value="<?php echo $item['qty']; ?>" size="3">
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $this->cart->format_number($item['price'] * $item['qty']); ?>
                                    </td>
                                    <td>
                                        <a href="cart/delete/<?php echo $item['rowid']; ?>" class="btn btn-info" onclick="return confirm('Are you sure you want to remove this item?');"><img src="images/cart-close.png"></a>
                                        <input name="key[]" type="hidden" id="key" value="<?php echo $item['rowid']; ?>" size="10">
                                        <input name="product_id[]" type="hidden" id="product_id" value="<?php echo $item['id']; ?>" size="10">
                                        <input name="price[]" type="hidden" id="price" value="<?php echo $item['price']; ?>" size="10">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-zero continue-cart-col">
                    <ul class="list-inline continue-cart-ul">
                        <li><a href="<?= base_url(); ?>"><button type="button" class="btn btn-primary">Continue Shopping</button></a></li>
                        <li><a href='cart/clearbasket'><button type="button" class="btn btn-primary">Clear Shopping Cart</button></a></li>
                        <li><input type="submit" class="btn btn-primary" value="Update Shopping Cart"></li>
                    </ul>
                </div>
            </form>

        </div>
    </div>
</section>
<?php if ($this->cart->total_items() == 0) { ?>
    <p align="center" style="padding-top:20px; padding-bottom:20px; color: #CC0000"><strong>Your shopping cart is currently empty!</strong></p>
    <?php
    return;
}
?>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cart-main-col padding-0">
        <?php $this->load->view('inc-messages'); ?>
        <form id="checkoutfrm" name="checkoutfrm" method="post" action="checkout/index/1" class="final-checkout-form">
            <div class="col-lg-6 col-sm-6 col-xs-12 padding-0">
                <div class="detail_box">
                    <h3 class="shipbill">Billing Details</h3>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">First Name <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $customer['first_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Last Name <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $customer['last_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Email <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $customer['email']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Address 1 <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" name="address1" id="address1" placeholder="Address 1" value="<?php echo $customer['uadd_address_01']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Address 2</label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control"  name="address2"  id="address2" placeholder="Address 2" value="<?php echo $customer['uadd_address_02']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Town/City <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" id="city" name="city" placeholder="Town/City"  value="<?php echo $customer['uadd_city']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">County <span class="error"> *</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" name="county" id="county" placeholder="County"  value="<?php echo $customer['uadd_county']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Postal Code <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" name="postcode" id="postcode" placeholder="Postal Code"  value="<?php echo $customer['uadd_post_code']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Country <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" name="country" id="country" placeholder="country"  value="United kingdom">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Phone <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input onkeyup="checkval(this)" type="text" class="form-control" name="phone" id="phone" placeholder="Phone"  value="<?php echo $customer['uadd_phone']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12 padding-0">
                <div class="small-6 columns cart_right_side_section">
                    <h3 class="shipbill">
                        Shipping Details
                        <label class="pull-right">
                            <input type="checkbox" class="ship"/> same as billing address
                        </label>
                    </h3>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">First Name <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control" name="s_first_name" id="s_first_name" placeholder="First Name"  value="<?php echo $customer['first_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Last Name <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control" name="s_last_name" id="s_last_name" placeholder="Last Name"  value="<?php echo $customer['last_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Address 1 <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control"  name="s_address1" id="s_address1" placeholder="Address 1 "  value="<?php echo $customer['uadd_address_01']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Address 2</label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control"  name="s_address2" id="s_address2" placeholder="Address 2" value="<?php echo $customer['uadd_address_02']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Town/City <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control" name="s_city" id="s_city" placeholder="Town/City"  value="<?php echo $customer['uadd_city']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">County <span class="error"> *</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control"  name="s_county" id="s_county" placeholder="County"  value="<?php echo $customer['uadd_county']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Postal Code <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="inputfield shipping form-control"  name="s_postcode"  id="s_postcode" placeholder="Postal Code"  value="<?php echo $customer['uadd_post_code']; ?>">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Country <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control" name="s_country" id="s_country" placeholder="country"  value="United kingdom">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label for="label" class="col-lg-3 col-sm-4">Phone <span class="error">*</span></label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="text" class="form-control" name="s_phone" id="s_phone" placeholder="Phone"  value="<?php echo $customer['uadd_phone']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="form-group clearfix">
                    <div class="small-8 columns text-center">
                        <p>Fields marked with<span class="error">*</span> are required.</p>
                        <input type="submit"  class="btn btn-primary" value="Paypal">
                    </div>
                </div>
            </div>
            <input type="hidden" name="pay_by_phone" id="pay_by_phone" value="0"/>
            <input id="screen-size" type="hidden" name="screen_size" value="">
        </form>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 total-table-col checkoutpahe">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="table-head-td">Subtotal</td>
                        <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($extra_data['subtotal']); ?></td>
                    </tr>
                    <tr>
                        <td class="table-head-td">Shipping</td>
                        <td><?php
                            echo DWS_CURRENCY_SYMBOL . ' ' . number_format($extra_data['shipping'], 2);
                            ?></td>
                    </tr>
                    <tr>
                        <td class="table-head-td">Vat</td>
                        <td><?php
                            echo DWS_CURRENCY_SYMBOL . ' ' . number_format($extra_data['tax'], 2);
                            ?></td>
                    </tr>
                    <?php
                    $discount = isset($extra_data['discounted_amount']) ? $extra_data['discounted_amount'] : 0;
                    if($discount) {
                    ?>
                    <tr>
                        <td class="table-head-td">Discount</td>
                        <td><?php
                            echo DWS_CURRENCY_SYMBOL . ' ' . number_format($discount, 2);
                            ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="table-head-td">Grand Total </td>
                        <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($extra_data['cart_total'] - $discount); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var screen_size = $(window).width() + '/' + $(window).height();
        $('#screen-size').val(screen_size);

        $('input[type=radio]').on('change', function () {
            $(this).closest("form").submit();
        });
    });

    function checkval(elm){
        var ship = $('.ship').is(':checked');
        if(ship) {
            var id = $(elm).attr('id')
                    sid = 's_'+id,
                        val = $(elm).val()
                ;
            $('#'+sid).val(val);
        }
    }
</script>
