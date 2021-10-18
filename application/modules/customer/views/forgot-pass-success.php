<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Success</a></li>
            </ul>
        </div>
    </div>
</section>
<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="user-thank-view error">
            <img src="images/tick-wish.png" class="img-responsive" />
            <h1 class="head">Email Sent Successfully</h1>
            <p class="text">Please make a note of your password and keep it safe. You can use it to log into the site on your next visit. </p>
            <?php if ($this->cart->total_items() > 0) { ?>
                <a class="link-button" href="checkout/">Click here to Checkout</a>
            <?php } ?>
        </div>
    </div>
</section>