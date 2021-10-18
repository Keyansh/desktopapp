<?php if($stwo) { ?>
    <h1 class="thankyou_order">Thankyou for your order. You will be receiving a call back shortly.</h1>
<?php } else { ?>
    <h1>Thankyou for your Order</h1>
<?php } ?>
<?php if(!$stwo) { ?>
    <div id="ctx_menu" class="corner4">
        <a href="customer/dashboard">My Account</a> | 
        <a href="customer/order">My Orders</a> | 
        <a href="customer/logout">Logout</a></div>
    <div style="padding-top:10px;"></div>
<?php } ?>
