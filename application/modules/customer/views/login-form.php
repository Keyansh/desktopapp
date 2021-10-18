<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Login</a></li>
            </ul>
        </div>
    </div>
</section>
<section id="login_registered_section">
    <div class="container-fluid site-container">
        <?php $this->load->view('inc-messages'); ?>
        <div class="col-xs-12 login_column null-padding">

            <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 login_inner_col LEFT">
                <?php
                if ($this->session->flashdata('loginerror')) {
                    echo $this->session->flashdata('loginerror');
                }
                ?>
                <h1 style="display: none;">login</h1>
                <p>Login</p>
                <p>Welcome back! Sign in to your account.</p>
                <form id="form1" name="form1" method="post" action="customer/login?ref=<?= $REF?>">
                    <div>
                        <input type="email" name="email" <?= set_value('email') ?> placeholder="email address *" required>
                    </div>
                    <div>
                        <input id="exampleInputEmail1" name="passwd" type="password" placeholder="password" required>
                        <a href='customer/forgotpass'><p class="psw">Forgot password?</p></a>
                    </div>
                    <div>
                        <input class="input-btn" type="submit" value="login">
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 login_inner_col RIGHT">
                <p>Register</p>
                <p>Create new account today to reap the benefits of a personalized 
                    shopping experience.</p>
                <form method="post" action="customer/register/save_email_session">
                    <div>
                        <input name="register_email" type="email" placeholder="Email address *" required>
                    </div>
                    <div>
                        <input class="input-btn" type="submit" value="Register">
                    </div>
                </form>
                <?php // if ($this->cart->total_items() > 0) { ?>
                <!--                    <a href="checkout/index/1">
                                        <input style="cursor: pointer;" class="input-btn text-center" value="Guest Checkout">
                                    </a>-->
                <?php // } ?>
            </div>
            <div class="login_column_inner">
                <i>or</i> 
            </div>
        </div>
    </div>
</section>

