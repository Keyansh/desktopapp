<style>
    .form-heads {
        font-size: 18px !important;
        /* font-family: "PT\ Root\ UI_Medium.otf" !important; */
        color: #ff6c00 !important;
        font-weight: bolder;
        border-bottom: none !important;
    }

    .form-heads.login-info {
        color: white;
        opacity: 0;
    }

    .top-25 {
        margin-top: 25px !important;
        background: #ff6c00;
    }

    .border-bottom-no {
        border-bottom: none !important;
    }

    /*code*/
    /* The container */
    .container-t-r {
        display: inline-block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin-left: 30px;
    }

    /* Hide the browser's default checkbox */
    .container-t-r input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark-r {
        position: absolute;
        top: 0;
        left: 0;
        height: 40px;
        width: 40px;
        background-color: white;
    }

    /* On mouse-over, add a grey background color */
    .container-t-r:hover input~.checkmark-r {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-t-r input:checked~.checkmark-r {
        background-color: #ff6c00;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark-r:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-t-r input:checked~.checkmark-r:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-t-r .checkmark-r:after {
        left: 13px;
        top: 9px;
        width: 10px;
        height: 17px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .container-t-r:first-child {
        margin-left: 0px;
    }

    .submit-btn {
        font-size: 17.08px;
        color: white !important;
        text-transform: capitalize;
        border-color: transparent;
        transition: 0.3s;
        width: 48%;
        float: right;
    }

    .top-heading {
        font-size: 26px;
        text-transform: capitalize;
        color: black;
    }

    .no-cursor {
        cursor: default;
    }

    .tier {
        font-weight: lighter;
        font-size: 15px;
        padding-left: 12px;
    }

    .tier-price {
        font-size: 15px;
        padding-left: 12px;
    }

    @media(max-width:767px) {
        .container-t-r {
            display: block;
            margin-left: 0;
        }

        .container-t-r .checkmark-r::after {
            left: 9px;
            top: 4px;
        }

        .checkmark-r {
            height: 30px;
            width: 30px;
        }

        .container-t-r>span>div {
            font-size: 12px ! important;
        }

        #confirm_register {
            margin-top: 10px !important;
            width: 100% ! important;
        }
    }

    /*code*/
</style>

<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Register</a></li>
            </ul>
        </div>
    </div>
</section>
<section id="login_registered_section">
    <div class="container-fluid site-container">
        <div class="col-xs-12 login_column null-padding">
            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 login_inner_col RIGHT login-main-col">
                <div style="text-align:center;padding-bottom: 20px;">
                    <h1 class="top-heading">Create an Account</h1>
                </div>
                <?php $this->load->view('inc-messages'); ?>
                <form id="form1" name="form1" method="post" action="customer/register">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tab-pane-inner-small-col tab-left-col">
                        <div class="login-form">
                            <div class="form-group">
                                <label for="name" class="contact-label">First Name*</label>
                                <input class="form-control" placeholder="First Name" name="first_name" type="text" value="<?= set_value('first_name'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="contact-label">Last Name*</label>
                                <input class="form-control" id="exampleInputEmail1" placeholder="Last Name" name="last_name" type="text" value="<?= set_value('last_name'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="contact-label">Email Address*</label>
                                <input class="form-control" id="exampleInputEmail1" placeholder="Email Address" name="email" type="email" value="<?= set_value('email', $this->session->userdata('REGISTER_EMAIL')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone" class="contact-label">Phone</label>
                                <input class="form-control" placeholder="Phone" name="phone" value="<?= set_value('phone') ?>" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tab-pane-inner-small-col tab-right-col">
                        <div class="login-form">

                            <div class="form-group">
                                <label class="contact-label">Company*</label>
                                <input class="form-control" id="exampleInputEmail1" placeholder="Company" value="<?= set_value('company_name') ?>" name="company_name" type="text">
                            </div>
                            <div class="form-group">
                                <label class="contact-label">Location*</label>
                                <input class="form-control" id="" placeholder="Location" value="<?= set_value('location') ?>" name="location" type="text">
                            </div>
                            <div class="form-group">
                                <label class="contact-label">Password*</label>
                                <input class="form-control" id="examplePassword" placeholder="Password" name="password" type="password">
                            </div>
                            <div class="form-group">
                                <label class="contact-label">Confirm Password*</label>
                                <input class="form-control" id="examplePasswordConfirm" placeholder="Confirm Password" name="confirm_password" type="password">
                            </div>



                            <div class="form-group">
                                <div class="g-recaptcha cap-width-100" data-sitekey="<?php echo DWS_RECAPTCHA_SITE_KEY; ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <input id="confirm_register" type="submit" class="btn btn-default contact-send-btn top-25 submit-btn" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
