<style>
    .head{
        font-size: 30.08px;
        padding: 4px 0px; 
    }
    .text{
        font-size: 20px;
        padding: 10px 0px 50px 0px;
    }
</style>
<div class="user-thank-view text-center">
    <img class="text-center" src="images/tick-wish.png" class="img-responsive"/>
    <h1 class="head">You Registered Successfully</h1>
    <p class="text ">Thankyou for registering.  You will be notified once your account gets approved by admin</p>
    <?php if ($this->cart->total_items() > 0) { ?>
        <a class="link-button" href="checkout/">Click here to Checkout</a>
    <?php } ?>
</div>
