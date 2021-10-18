<!--<style>
    .nn-style-check-out-page {
        text-align: center !important;
        font-size: 30px;
        margin-bottom: 35px;
        text-transform: uppercase;
        font-family:"PT\ Root\ UI_Medium.otf";
    }
    .content {
        font-size: 17px;
        font-weight: bold;
    }
    /* .forget {
        font-size: 12px !important;
    } */
    .forget a{ 
        padding: 0 !important;
        color: #929091 !important;
        margin-bottom: 5px;
        font-size: 16px;
    }
    .nn-style-f-l-e-x {
        display: flex;
        flex-wrap: wrap;
    }
   .nn-style-cart-mid-div {
        position: relative;
    }
    .nn-style-cart-main-in {
        position: absolute;
        width: 2px;
        height: 100%;
        background: #e6e6e6;
        left: 50%;
        transform: translateX(-50%);
    }
    .nn-style-or-in-din-main {
        border-radius: 100%;
        width: 50px;
        height: 50px;
        padding: 5px;
        background: #e6e6e6;
        color: black;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50% , -50%);
    text-transform: capitalize;
     font-size: 20px;
     color: black;
     font-style: italic;
}
    .margin-0.input-p.nn-style-guest {
        padding: 5px 0px;
    }
    .login input{
        border-radius:0;
        height: 38px;
    }
    @media(min-width:0px) and (max-width:767px) {
        /* .nn-style-check-out-page {
            font-size: 24px;
        }
        .delivery-main .main-text {
            font-size: 17px;

        }
        .content {
            font-size: 12px;

        }
        .tab-col1 .input-col {
            margin: 10px 0 0 0;
        }
        .col-xs-2.nn-style-cart-mid-div {
            display: none;
        }
        .guest-log-right {
            padding: 0;
        } */
    }
    @media(min-width:768px) and (max-width:991px) {
        /* .content {
            font-size: 13px !important;

        }
        .nn-style-check-out-page {

            font-size: 26px !important;
            margin-bottom: 20px;

        } */
    }
    @media(min-width:992px) and (max-width:1199px) {
        /* .content {
            font-size: 15px !important;
            font-weight: bold;
        }
        .nn-style-check-out-page {

            font-size: 26px !important;
            margin-bottom: 20px;

        } */
    }
    /*my css start*/
    .container.about-c p {
        font-size: 15px;
        font-family: "PT\ Root\ UI_Medium.otf";
        text-align: justify;
    }
    .delivery-main .main-text {
        font-size: 22px;
        color: #34abb3;
        font-family: "PT\ Root\ UI_Medium.otf";
        padding: 10px 0px;
        text-transform: uppercase;
    }
    .tab-col1 .input-col .btn {
        margin: 20px 0 0 0;
        color: #fff;
        font-size: 18px;
        text-transform: uppercase;
        font-family: "PT\ Root\ UI_Medium.otf";
        width: 100%;
    }
    .tab-col1 .btn.btn-primary {
        color: black;
        font-size: 18px;
        text-transform: uppercase;
        font-family: "PT\ Root\ UI_Medium.otf";
        border: solid 1px #34abb3;
        text-shadow: none;
        background: #34abb3;
        border-radius: 0px;
        box-shadow: none;
        margin: 0 0 6px 0;
        width: 100%;
    }
    .delivery-main {
        padding: 50px 50px;
    }
    .col-lg-5.border-right {
        padding-left: 0;
    }
    input {
        width: auto;
    }
    /*my css finish*/
</style>-->
<section id="single_product_col">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Checkout</a></li>
            </ul>
        </div>
    </div>
</section>
<section id="login_registered_section">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 login_column null-padding">
            <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 login_inner_col LEFT">
                <?php
                if ($this->session->flashdata('loginerror')) {
                    echo $this->session->flashdata('loginerror');
                }
                ?>
                <p>Login</p>
                <p>Welcome back! Sign in to your account.</p>
                <form id="form1" name="form1" method="post" action="customer/login">
                    <div>
                        <input type="email" name="email" value="<?= set_value('email') ?>" placeholder="email address *" required>
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
<!--<div class="container checkout-cont">
    <div class=" col-xs-12 col-lg-12 delivery-main">
        <div class="border-bottom">
        </div>
        <p class="pe"><a href="cart">&lt; Back to shopping cart</a></p>
        <div class=" col-xs-12 col-lg-12 tab-col1">
            <p class="nn-style-check-out-page"> Checkout</p>
            <div class="nn-style-f-l-e-x">
                <div class=" col-xs-12 col-sm-5 col-lg-5 border-right">
                    <p class="main-text">Checkout as a Guest or Register </p>
                    <p class="content">Register with us for future convenience:</p>
                    <div class="rado">
                        <form name="checkout-as-form" action="#">
                            <p class="margin-0 input-p nn-style-guest">
                                <input id="test1" name="checkout-as" checked="" type="radio" value="guest">
                                <label for="test1">   Checkout as Guest</label>
                            </p>
                            <p class="margin-0 input-p nn-style-guest">
                                <input id="test2" name="checkout-as" type="radio" value="register">
                                <label for="test2">Register</label>
                            </p>
                        </form>
                    </div>
                    <div class="input-col">
                         <p class="content">Register and save time!</p> 
                        <p class="content">Register with us for future convenience:</p>
                        <p class="content">Fast and easy check out</p>
                        <p class="content">Easy access to your order history and status</p> 
                        <button id="checkout-as-continue-btn" class="continue btn btn-primary">Continue</button>
                    </div>
                </div>
                <div class="col-xs-2 nn-style-cart-mid-div">
                    <div class="nn-style-cart-main-in"></div>
                    <div class="nn-style-or-in-din-main">or</div>

                </div>
                <div class=" col-xs-12 col-sm-5 col-lg-5 guest-log-right">
                    <div class="form-size">
                        <p class="main-text">Login</p>
                         <p class="content">Already registered?</p>
                        <p class="content">Please log in below:</p> 
                        <div class="login">
                            <form action="customer/login" method="post">
                                <div class="form-group">
                                     <label for="exampleInputEmail1">Email Address<span class="star"> *</span></label> 
                                    <input name="email" class="form-control" id="exampleInputEmail1" placeholder="Email Address *" type="email" required="required">
                                </div>
                                <div class="form-group">
                                     <label for="exampleInputPassword1">Password <span class="star">*</span></label> 
                                    <input name="passwd" class="form-control" id="exampleInputPassword1" placeholder="Password *" type="password" required="required">
                                </div>
<?php
//if ($this->session->flashdata('checkout-login-error') == TRUE) {
?>
                                                    <p style="color:red">Invalid email or password !</p>
<?php
//}
?>
                                <input type="submit" class="form-btn btn btn-primary" value="login">
                                <p class="forget"><a href="customer/forgotpass">Forgot your password?</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

<!--<script type="text/javascript">
    $(document).ready(function () {
        $('#checkout-as-continue-btn').click(function () {
            var x = $('input[name=checkout-as]:checked').val();
            if (x == 'guest') {
                window.location.href = "checkout/index/guest";
            } else if (x == 'register') {
                if (typeof (Storage) != 'undefined') {
                    localStorage.setItem('gotocheckout', 'true');
                }
                window.location.href = "customer/register";
            }
        });
    });
</script>-->