<h1 style="font-family: Roboto-Medium;font-size: 36px;text-align: center;">Redirecting to PayPal</h1>
<p align="center">&nbsp;</p>
<p align="center"><strong>You are being redirected to a PayPal's SSL secured payment page.</strong></p>
<p align="center">&nbsp;</p>
<p align="center"><img src="images/activityanimation.gif" alt="Redirecting" width="70" height="7" /></p>
<?php if(DWS_DEMO_MODE == 1){?>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="payment_form" id="payment_form">
<?php }else{?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="payment_form" id="payment_form">
  <?php }?>
    <input type="hidden" name="cmd" value="_xclick">
  <input type="hidden" name="business" value="<?=DWS_MERCHANT_EMAIL;?>">
  <input type="hidden" name="item_name" value="<?=$order['order_num'];?>">
  <input type="hidden" name="amount" value="<?=$order['order_total'];?>">
  <input type="hidden" name="currency_code" value="<?=DWS_CURRENCY_CODE;?>">
  <input type="hidden" name="custom" value="<?=$order['order_id'];?>">
  <input type="hidden" name="return" value="<?php echo base_url()."checkout/payment/success"; ?>">
  <input type="hidden" name="cancel_return" value="<?php echo base_url()."checkout/failed"; ?>">
  <input type="hidden" name="notify_url" value="<?php echo base_url()."checkout/payment/index"; ?>">
</form>
<p align="center"><img src="images/horizontal_solution_PPeCheck.png" width="166" height="42" /></p>