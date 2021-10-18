<div id="basket"><a href="catalog/cart">Basket</a></div>
<div id="login"> <?php if ($this->memberauth->checkAuth()) { ?>
        <a href="customer/logout">Logout</a>
    <?php } else { ?>
        <a href="customer/login">Login</a>
    <?php } ?></div>
<div id="contact"><a href="contact">Contact Us</a></div>
<div id="home"><a href="<?php echo base_url(); ?>">Home</a></div>