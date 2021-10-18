<h1 style="font-family: Roboto-Medium;font-size: 36px;text-align: center;">Redirecting to PayPal</h1>
<p align="center">&nbsp;</p>
<p align="center" style="font-family: Roboto-Light"><strong>You are being redirected to a PayPal's SSL secured payment page.</strong></p>
<p align="center">&nbsp;</p>
<p align="center"><img src="images/paypal-logo.png" alt="Redirecting" width="200" /></p>
<!--<p align="center"><img src="images/activityanimation.gif" alt="Redirecting" width="70" height="7" /></p>-->
<?php if (DWS_DEMO_MODE == 1) { ?>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="payment_form" id="payment_form">
    <?php } else { ?>
        <!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="payment_form" id="payment_form">-->
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="payment_form" id="payment_form">
        <?php } ?>
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="<?= DWS_PAYPAL; ?>">
        <input type="hidden" name="item_name" value="<?= $order['order_num']; ?>">
        <input type="hidden" name="amount" value="<?= $order['order_total']; ?>">
        <input type="hidden" name="currency_code" value="<?= DWS_CURRENCY_CODE; ?>">
        <input type="hidden" name="custom" value="<?= $order['order_id']; ?>">
        <input type="hidden" name="return" value="<?php echo base_url() . "checkout/payment/success/" . $order['order_num']; ?>">
        <input type="hidden" name="cancel_return" value="<?php echo base_url() . "checkout/failed"; ?>">
        <input type="hidden" name="notify_url" value="<?php echo base_url() . "checkout/payment/index"; ?>">
    </form>
    <!--<p align="center"><i class="fa fa-paypal"></i></p>-->
    <script>
        jQuery(document).ready(function () {
//            $(window).load(function () {
                $('#payment_form').submit();
//            });
        });
    </script>