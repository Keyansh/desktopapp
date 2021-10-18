<style>
    .shopping-cart-heading {
        padding: 0;
        margin-bottom: 35px;
        margin-top: 30px;
    }

    .shipping-method-area-outer {
        padding: 15px 30px;
    }

    .delivery-heading-desk-checkout {
        margin-bottom: 0px !important;
    }

    .container.about-c p {
        font-size: 15px;
        text-align: justify;
    }

    .input-field-delivery-checkout-inner {
        margin-bottom: 20px;
        padding: 0px 5px;
        margin-top: 0px;
    }

    #addcoupon {
        width: 100% !important;
    }

    #coupon-add-remove-btn {
        margin-bottom: 20px;
    }

    .input-field-delivery-checkout-inner.address-field {
        margin-bottom: 20px;
        padding: 0px;
        margin-top: 0px;
    }

    .input-field-delivery-checkout-inner.city-county {
        padding-left: 0px;
    }

    .input-field-names-checkout {
        color: #333;
        font-size: 15px;
        font-weight: normal;
    }

    .delivery-heading-desk-checkout-inner {
        font-size: 16px;
        color: #34abb3;
        text-transform: capitalize;
        margin-bottom: 20px;
    }

    /* .input-field-delivery-checkout-inner.cont-btn-inner {
        margin-top: 20px;
    } */
    .total-price-table-check-out {
        width: 100%;
        margin-top: 10px;
    }

    .input-field-delivery-checkout-inner input {
        width: 100%;
        padding: 0px 15px;
        height: 45px;
        font-size: 14px;
        /*color: white;*/
        transition: 0.3s;
        border: 1px solid #afafaf;
    }

    .input-field-delivery-checkout-inner textarea {
        border: 1px solid #afafaf;
        padding: 0px 15px;
    }

    .input-field-delivery-checkout-inner input:hover {
        color: black;
    }

    .CONTINUE-btn {
        width: 100%;
        padding: 13px 0;
        background: #c4016a;
        color: white;
        border: none;
        font-size: 18px;
        margin-top: 10px;
    }

    .input-field-delivery-checkout-inner.checkbox-delivery {
        padding: 0;
    }

    label.al-new-select {
        /* cursor: pointer; */
        margin: 0;
        margin-bottom: 15px;
        overflow: hidden;
        position: relative;
    }

    .input-field-delivery-checkout-inner input[type="checkbox"] {
        width: auto;
    }

    /* label.al-new-select input {
        position: absolute;
        top: -50px;
    } */
    label.al-new-select input:checked~.cstm-checkbox {
        border-color: #7F7B70;
    }

    .input-field-delivery-checkout-inner.checkbox-delivery .cstm-checkbox {
        border-radius: 0;
        top: 0;
    }

    .banner-desk-product-inner>ul {
        list-style-type: none;
        padding-left: 0;
    }

    .banner-desk-product-inner>ul li {
        display: inline-block;
        padding-top: 15px;
    }

    label.al-new-select .cstm-checkbox {
        border: 1px solid #dbd7cc;
        display: inline-block;
        margin: 0 4px 0 0;
        padding: 0px 5px;
    }

    .input-field-delivery-checkout-inner label {
        display: block;
    }

    .country-select {
        position: relative;
        display: inline-block;
    }

    .center-area-outer,
    .delivery-field,
    .input-field-delivery-checkout {
        padding-left: 0;
    }

    .cstm-checkbox {
        width: 22px;
    }

    .shipping-method-area {
        padding: 0;
    }

    label.al-new-select input:checked~.cstm-checkbox i {
        opacity: 1;
    }

    .Standard-Delivery-outer {
        font-size: 15px;
        color: #333333;
        font-weight: normal;
    }

    .Standard-Delivery-inner {
        display: block;
        margin-left: 33px;
        font-size: 15px;
        color: #7A7A7A;
        font-weight: 400;
    }

    .desk-chkout-stars {
        color: #34abb3;
        margin-left: 4px;
    }

    .delivery-sidebar-table-outer {
        background: #f0f0f0;
        padding: 15px 15px;
    }

    .side-bar-table-data {
        padding: 0px 10px;
    }

    .side-name {
        font-size: 14px;
        color: #404040;
    }

    .side-bar-table td {
        border-bottom: 1px solid #D3D5D4;
        padding: 0px;
    }

    .side-bar-table td img {
        width: 102px;
    }

    .td-bold {
        font-size: 17px;
    }

    .td-light {
        font-size: 17px;
        padding: 3px 0;
    }

    .table-check-out-td-one {
        text-align: left;
    }

    .table-check-out-td-two {
        text-align: right;
    }

    .al-new-select.new-label {
        width: 100%;
        margin-top: 5px;
    }

    .al-new-select.new-label p {
        margin-bottom: 20px;
        text-align: left;
        margin-top: 10px;
        font-size: 20px;
    }

    .paypal-img-chkout {
        float: right;
    }




    /* --------------radio btn css----------------------  */
    .rab-container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 18px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .rab-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        width: auto;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .rab-container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .rab-container input:checked~.checkmark {
        background-color: #c4016a;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .rab-container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .rab-container .checkmark:after {
        top: 8px;
        left: 8px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }


    .al-new-select.inputfiled-display {
        display: flex;
        align-items: center;
    }

    .al-new-select.inputfiled-display input {
        margin-right: 5px;
    }

    .country-inner-div div {
        width: 100%;
    }

    #shipping-address-div {
        display: none;
    }

    .total-price-table-check-out tr:last-child {
        border-top: 1px solid lightgray;
        border-bottom: 1px solid lightgray;
    }

    .total-price-table-check-out tr:last-child td {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        font-size: 18px;
    }
</style>
<link rel="stylesheet" href="css/countrySelect.css">
<script src="js/countrySelect.min.js"></script>

<div class="container-fluid banner-desk-product">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 banner-desk-product-inner">
        <ul>
            <li><i class="fa fa-chevron-left" aria-hidden="true"></i></li>
            <li><a href="cart">Back to Shopping cart</a></li>
        </ul>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 shopping-cart-heading">
        <p>Proceed to Checkout</p>
        <!-- <p class="shopping-cart-heading-two">Please enter your details below to complete your purchase....</p> -->
    </div>
</div>

<form action="checkout" id="paymentFrm" method="post">
    <section id="center-area">
        <div class="container-fluid center-area">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 center-area-outer">
                <div class="col-xs-12 col-sm-8 delivery-field">
                    <!--                    --><?php //if (validation_errors()) { 
                                                ?>
                    <!--                        <ul class="ul-li-cart">-->
                    <!--                            --><?php //echo validation_errors(); 
                                                        ?>
                    <!--                        </ul>-->
                    <!--                    --><?php //} 
                                                ?>

                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oops!</strong>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif ?>
                    <div class="border-rigt">
                        <?php if ($variables['shipping'] != 0) { ?>
                            <div class="delivery-heading-desk-checkout">
                                <p class="delivery-heading-desk-checkout-inner"><span> 1. </span> Shipping</p>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                    <label class="al-new-select new-label">
                                        <p>Select Shipping Type</p>

                                        <label class="rab-container ">2Days Postage
                                            <input type="radio" value="2days_postage" <?= $variables['shipping_type'] == '2days_postage' ? 'checked' : '' ?> class="shipping-type" name="shipping_type"> <?php echo DWS_CURRENCY_SYMBOL . $variables['shippingArr']['2days_postage'] ?>
                                            <span class="checkmark"></span>
                                        </label>
                                        <?php
                                        if ($variables['shippingArr']['next_day_delivery'] != 0) { ?>
                                            <label class="rab-container "> Next Day Delivery
                                                <input type="radio" value="next_day_delivery" <?= $variables['shipping_type'] == 'next_day_delivery' ? 'checked' : '' ?> class="shipping-type" name="shipping_type"> <?php echo DWS_CURRENCY_SYMBOL . $variables['shippingArr']['next_day_delivery'] ?>
                                                <span class="checkmark"></span>
                                            </label>
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="delivery-heading-desk-checkout">
                            <p class="delivery-heading-desk-checkout-inner"><span> <?= $variables['shipping'] != 0 ? '2.' : '1.'; ?> </span> Delivery Address</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                <label class="input-field-names-checkout">First Name<span class="desk-chkout-stars">*</span></label>
                                <input type="text" name="fname" value="<?php echo $customer['first_name'] ? set_value('fname', $customer['first_name']) : ''; ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                <label class="input-field-names-checkout">Last Name<span class="desk-chkout-stars">*</span></label>
                                <input type="text" name="lname" value="<?php echo set_value('lname', $customer['last_name']); ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                <label class="input-field-names-checkout">Email<span class="desk-chkout-stars">*</span></label>
                                <input type="text" name="email" value="<?php echo set_value('email', $customer['email']); ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                <label class="input-field-names-checkout">Phone Number<span class="desk-chkout-stars">*</span></label>
                                <input type="text" name="phone" value="<?php echo set_value('phone', $customer['phone'] ? $customer['phone'] : ''); ?>">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout-inner address-field">
                                <label class="input-field-names-checkout">Address<span class="desk-chkout-stars">*</span></label>
                                <textarea name="address" rows="5" style="width:100%"><?php echo set_value('address', $customer['uadd_address_01']); ?></textarea>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner city-county">
                                <label class="input-field-names-checkout">City<span class="desk-chkout-stars">*</span></label>
                                <input type="text" name="city" value="<?php echo set_value('city', $customer['uadd_city']); ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner postcode-country">
                                <label class="input-field-names-checkout">Postcode<span class="desk-chkout-stars">*</span></label>
                                <input type="text" name="postcode" value="<?php echo set_value('postcode', $customer['uadd_post_code']); ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner city-county">
                                <label class="input-field-names-checkout">County<span class="desk-chkout-stars">*</span></label>
                                <input type="text" name="county" value="<?php echo set_value('county', $customer['uadd_county'] ? $customer['uadd_county'] : ''); ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner postcode-country country-inner-div">
                                <label class="input-field-names-checkout">Country<span class="desk-chkout-stars">*</span></label>
                                <!--                                <input type="text" id="country">-->
                                <input type="text" id="country_code" name="country" value="<?php echo set_value('country'); ?>" />
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout-inner checkbox-delivery">
                                <label class="al-new-select inputfiled-display">
                                    <input id="shipping-address-btn" name="ship_to_same_address" type="checkbox" checked="checked">
                                    <!-- <span class="cstm-checkbox"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                    <span class="name">Billing Address same as Delivery Address</span>
                                </label>
                            </div>
                        </div>

                        <div id="shipping-address-div">
                            <div class="delivery-heading-desk-checkout">
                                <p class="delivery-heading-desk-checkout-inner">Billing address</p>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                    <label class="input-field-names-checkout">First Name<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" name="shipping_fname" value="<?php echo set_value('shipping_fname', $customer['ship_fname']); ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                    <label class="input-field-names-checkout">Last Name<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" name="shipping_lname" value="<?php echo set_value('shipping_lname', $customer['ship_lname']); ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                    <label class="input-field-names-checkout">Email<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" name="shipping_email" value="<?= set_value('shipping_email') ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner">
                                    <label class="input-field-names-checkout">Phone Number<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" name="shipping_phone" value="<?php echo set_value('shipping_phone', $customer['ship_phone']); ?>">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout-inner address-field">
                                    <label class="input-field-names-checkout">Address<span class="desk-chkout-stars">*</span></label>
                                    <textarea name="shipping_address" rows="5" style="width:100%"><?php echo set_value('shipping_address'); ?></textarea>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner city-county">
                                    <label class="input-field-names-checkout">City<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" name="shipping_city" value="<?php echo set_value('shipping_city'); ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner postcode-country">
                                    <label class="input-field-names-checkout">Postcode<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" name="shipping_postcode" value="<?php echo set_value('shipping_postcode'); ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner city-county country-inner-div">
                                    <label class="input-field-names-checkout">County<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" name="shipping_county" value="<?php echo set_value('shipping_county'); ?>">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 input-field-delivery-checkout-inner postcode-country">
                                    <label class="input-field-names-checkout">Country<span class="desk-chkout-stars">*</span></label>
                                    <input type="text" id="shippingcountry">
                                    <input type="hidden" id="shippingcountry_code" name="shipping_country" value="<?php echo set_value('shipping_country'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 delivery-sidebar-table">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 delivery-sidebar-table-outer">
                        <div class="delivery-heading-desk-checkout">
                            <p class="delivery-heading-desk-checkout-inner twwo"><span> <?= $variables['shipping'] != 0 ? '3.' : '2.'; ?> </span>Review Your Order</p>
                        </div>

                        <?php $this->load->view('review-layout'); ?>

                        <table class="total-price-table-check-out">
                            <?php
                            $readonly = "";
                            $extra_data = $this->cart->extraData();
                            $coupon_code = $this->session->userdata('discount_coupon');
                            $discount_price = $this->session->userdata('discount_price');
                            if ($coupon_code) {
                                // $readonly = "disabled='true'";
                            }
                            ?>
                            <tr>
                                <td class="table-check-out-td-one td-light">Coupon</td>
                                <td class="table-check-out-td-two td-light coupon-input">
                                    <div class="input-field-delivery-checkout-inner">
                                        <input name="coupon" id="addcoupon" <?php echo $readonly ?> value="<?php echo $coupon_code ?>" />
                                    </div>
                                </td>
                                <td class="table-check-out-td-two td-light">
                                    <?php if ($coupon_code) : ?>
                                        <button id="coupon-add-remove-btn" type="button" class="btn btn-default contact-send-btn top-25 remove-coupon-btn">
                                            Remove
                                        </button>
                                    <?php else : ?>
                                        <button id="coupon-add-remove-btn" type="button" class="btn btn-default contact-send-btn top-25 submit-coupon-btn coupon-btn">
                                            Submit
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-check-out-td-one td-light">Subtotal</td>
                                <td class="table-check-out-td-two td-light"><?php echo DWS_CURRENCY_SYMBOL ?>
                                    <span id="subtotal"><?php echo number_format($variables['cart_total'], 2) ?></span>
                                </td>
                            </tr>
                            <?php
                            $display = isset($extra_data['total_discounted_amount']) && $extra_data['total_discounted_amount'] > 0 ? "" : "none";
                            $total_discounted_amount  = isset($extra_data['total_discounted_amount']) && $extra_data['total_discounted_amount'] > 0 ? $extra_data['total_discounted_amount'] : 0;
                            ?>
                            <tr id="discount-tr" style="display: <?php echo $display ?>;">
                                <td class="table-check-out-td-one td-light">Discount</td>
                                <td class="table-check-out-td-two td-light"><?php echo DWS_CURRENCY_SYMBOL ?><span id="total_discounted_amount"><?php echo number_format($total_discounted_amount, 2) ?></span></td>
                            </tr>
                            <tr>
                                <td class="table-check-out-td-one td-light">VAT</td>
                                <td class="table-check-out-td-two td-light"><?php echo DWS_CURRENCY_SYMBOL ?> <span id="total_tax"> <?php echo number_format($variables['vat'], 2) ?></td>
                            </tr>
                            <tr>
                                <td class="table-check-out-td-one td-light">Shipping <span id="shipping_label"><?= $variables['shipping_label']; ?></span></td>
                                <td class="table-check-out-td-two td-light"><?php echo DWS_CURRENCY_SYMBOL ?> <span id="shipping_amount"><?php echo number_format($variables['shipping'], 2) ?></span></td>
                            </tr>
                            <tr>
                                <td class="table-check-out-td-one td-bold" style="padding: 0px;">Grand Total</td>
                                <?php
                                ?>
                                <td class="table-check-out-td-two td-bold" style="padding: 0px;">
                                    <?php echo DWS_CURRENCY_SYMBOL ?>
                                    <span id="grand-total">
                                        <?php echo number_format($variables['order_total'], 2) ?>
                                    </span>
                                </td>
                            </tr>

                        </table>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout-border-inner paypal">
                            <label class="al-new-select new-label">
                                <p>Checkout With Stripe</p>
                                <div class=""><img src="images/logo-stripe.png" class="img-responsive" alt="stripe" /></div>
                                <!--                                <label class="rab-container ">PayPal <span class="paypal-img-chkout"> <img style="max-width: 95px;" src="images/paypal-logo.png"> </span>-->
                                <!--                                    <input type="radio" value="paypal" id="paypalPay" name="payment_method">-->
                                <!--                                    <span class="checkmark"></span>-->
                                <!--                                </label>-->

                                <label class="rab-container hide">Stripe <span class="paypal-img-chkout"> </span>
                                    <input type="radio" value="stripe" checked="checked" id="stripPay" name="payment_method">
                                    <span class="checkmark"></span>
                                </label>
                            </label>
                        </div>

                        <?php /* ?><div class="stripe " >
                            <div class="card">
                                <div class="card-header  text-white">Card Information</div>
                                <div class="card-body bg-light">

                                    <div id="payment-errors"></div>
<!--                                    <form method="post" id="paymentFrm" enctype="multipart/form-data" action="--><?php //echo base_url(); ?><!--Welcome/check">-->
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name on card" value="<?php echo set_value('name'); ?>" required>
                                        </div>

<!--                                        <div class="form-group">-->
<!--                                            <input type="email" name="email" class="form-control" placeholder="email@you.com" value="--><?php //echo set_value('email'); ?><!--" required />-->
<!--                                        </div>-->

                                        <div class="form-group">
                                            <input type="number" name="card_num" id="card_num" class="form-control" placeholder="Card Number" autocomplete="off" value="<?php echo set_value('card_num'); ?>" required>
                                        </div>


                                        <div class="row">

                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" value="<?php echo set_value('exp_month'); ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input type="text" name="exp_year" class="form-control" maxlength="4" id="card-expiry-year" placeholder="YYYY" required="" value="<?php echo set_value('exp_year'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="text" name="cvc" id="card-cvc" maxlength="3" class="form-control" autocomplete="off" placeholder="CVC" value="<?php echo set_value('cvc'); ?>" required>
                                                </div>
                                            </div>
                                        </div>



                                    <div class="form-group text-right">
                                        <button class="btn btn-secondary" type="reset">Reset</button>
                                        <!--                            <button type="submit" id="payBtn" class="btn btn-success">Submit Payment</button>-->
                                    </div>

<!--                                    </form>-->

                                </div>
                            </div> <?php */ ?>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input-field-delivery-checkout-inner cont-btn-inner">
                        <input type="submit" id="payBtn" class="CONTINUE-btn" value="PLACE ORDER">
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <div class="">
        <input id="screen-size" type="hidden" name="screen_size" value="">
    </div>

</form>

<script type="text/javascript">
    var currentCouponCode = '<?php echo $this->session->userdata('discount_coupon') ?>';
    var lastEnteredEmailId = false;
    $(document).ready(function() {
        var emailId = $('input[name="email"]').val();
        if (emailId != "" && currentCouponCode != "") {
            addCouponClick(true);
        }
    });
    $(document).focusout('input[name="email"]', function() {
        var emailId = $('input[name="email"]').val();
        if (emailId != "" && currentCouponCode != "" && lastEnteredEmailId != emailId) {
            lastEnteredEmailId = emailId;
            addCouponClick(true);
        }
    });

    function updateCartPricing(data, html) {
        $('#subtotal').html(data.subtotal);
        if (data.discount != '' && data.discount != '0') {
            $('#discount-tr').css('display', '');
            $('#total_discounted_amount').html(data.discount)

            $('#coupon-add-remove-btn').html('Remove');
            $('#coupon-add-remove-btn').removeClass('submit-coupon-btn');
            $('#coupon-add-remove-btn').removeClass('coupon-btn');
            $('#coupon-add-remove-btn').addClass('remove-coupon-btn');
        } else {
            $('#discount-tr').css('display', 'none');

            $('#coupon-add-remove-btn').html('Submit');
            $('#coupon-add-remove-btn').addClass('submit-coupon-btn');
            $('#coupon-add-remove-btn').addClass('coupon-btn');
            $('#coupon-add-remove-btn').removeClass('remove-coupon-btn');
        }
        $('#total_tax').html(data.tax);
        $('#shipping_label').html(data.shipping_label);
        $('#shipping-amount').html(data.shipping_amount);
        $('#grand-total').html(data.grand_total);
        if (html != undefined) {
            $('#review-table').html(html);
        }
    }


    function removeCouponClick(verify) {
        $('#payBtn').prop('disabled', true);
        $.post("cart/coupon_delete", {}, function(data) {
            currentCouponCode = "";
            $('#payBtn').prop('disabled', false);
            if (verify == true) {
                if(data.status == false) {
                    alert(data.message);
                }
            } else {
                alert(data.message);
            }
            if (data.status == true) {
                updateCartPricing(data.data, data.html);
            }
        }, 'JSON');
    }

    $(document).on('click', ".remove-coupon-btn", removeCouponClick);

    function addCouponClick(verify) {
        var coupon = $("#addcoupon").val();
        var emailId = $('input[name="email"]').val();
        if (emailId == "") {
            alert('Please enter the email id first.');
            return false;
        }
        if (coupon == '')
            return false;
        $('#payBtn').prop('disabled', true);
        $.post("cart/coupon", {
            coupon,
            emailId
        }, function(data) {
            currentCouponCode = coupon;
            $('#payBtn').prop('disabled', false);
            if (verify == true) {
                if (data.status == false) {
                    alert(data.message);
                    removeCouponClick(true);
                }
            } else {
                alert(data.message);
            }
            if (data.status == true) {
                updateCartPricing(data.data, data.html);
            }
        }, 'JSON');

    }

    $(document).on('click', ".coupon-btn", addCouponClick);

    $(".shipping-type").on('click', function() {
        var shipping_type = $(this).val();
        $.post("checkout/shipping", {
            shipping_type: shipping_type
        }, function(data) {
            if (data == 1) {
                location.reload();
            }
        }, 'JSON');
    });

    $(document).ready(function() {
        var screen_size = $(window).width() + '/' + $(window).height();
        $('#screen-size').val(screen_size);

        $("#country").countrySelect({
            defaultCountry: 'gb'
        });
        $("#shippingcountry").countrySelect({
            defaultCountry: 'gb'
        });

        $('#shipping-address-div').hide();

        $('#shipping-address-btn').click(function() {
            $('#shipping-address-div').toggle();
        });

        $('#express-delivery-tr').hide();

        $('#standard-shipping-input').change(function() {
            $('#express-delivery-tr').hide();
            var grand_total = parseFloat('<?php echo $extra_data['subtotal'] + $extra_data['tax'] + $extra_data['shipping'] - $extra_data['discount'] ?>');
            grand_total = grand_total.toFixed(2);
            $('#grand-total').html(grand_total);

            var discounted_amount = 0;
            discounted_amount = parseFloat('<?php
                                            if (isset($extra_data["discounted_amount"])) {
                                                echo $extra_data['discounted_amount'];
                                            }
                                            ?>');
            var final_total = grand_total - discounted_amount;
            final_total = final_total.toFixed(2);
            $('#final-total').html(final_total);
        });

        $('#express-shipping-input').change(function() {
            $('#express-delivery-tr').show();
            var grand_total = parseFloat('<?php echo $extra_data['subtotal'] + $extra_data['tax'] + $extra_data['shipping'] - $extra_data['discount'] ?>');
            var express_delivery = parseFloat('<?php echo DWS_EXPRESS_DELIVERY ?>');
            grand_total += express_delivery;
            grand_total = grand_total.toFixed(2);

            $('#grand-total').html(grand_total);
            var discounted_amount = 0;
            discounted_amount = parseFloat('<?php
                                            if (isset($extra_data["discounted_amount"])) {
                                                echo $extra_data['discounted_amount'];
                                            }
                                            ?>');
            var final_total = grand_total - discounted_amount;
            final_total = final_total.toFixed(2);
            $('#final-total').html(final_total);
        });
    });

    gtag('event', 'begin_checkout', {
        "items": <?php echo $json_item; ?>,
        "coupon": ""
    });
</script>
<?php /* ?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    //set your publishable key
    Stripe.setPublishableKey('<?php echo DWS_STRIPE_PUBLISHABLE_KEY; ?>');
    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {
        if (response.error) {
            //enable the submit button
            $('#payBtn').removeAttr("disabled");
            //display the errors on the form
            // $('#payment-errors').attr('hidden', 'false');
            $('#payment-errors').addClass('alert alert-danger');
            $("#payment-errors").html(response.error.message);
        } else {
            var form$ = $("#paymentFrm");
            //get token id
            var token = response['id'];
            //insert the token into the form
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            //submit form to the server
            form$.get(0).submit();
        }
    }
    // $('#stripPay').on('click', function () {
    //     $('.stripe').show();
    // });
    //
    //
    // $('#paypalPay').on('click', function () {
    //     $('.stripe').hide();
    // });
    $(document).ready(function() {
        //on form submit
        $("#paymentFrm").submit(function(event) {
            //disable the submit button to prevent repeated clicks
            $('#payBtn').attr("disabled", "disabled");

            //create single-use token to charge the user
            Stripe.createToken({
                number: $('#card_num').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;
        });
    });
</script>

<?php */ ?>