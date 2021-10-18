<style>
    .button-color{
        background:#ff6c00;
    }
</style>
<section id="single_product_col">
    <div class="container-fluid site-container null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Change Password</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="bg-light-gray form-font" id="portfolio">
    <div class="container-fluid site-container">
        <div class="middle-container dashboard col-xs-12 col-sm-12 col-lg-12" id="middle-content-section">
            <!--    <div class="row">-->
            <?php // e($customer);?>
            <?php $this->load->view('navigation'); ?>
            <div class="col-xs-12 col-sm-9 col-lg-9 dash-inn-right">
                <form action="" method="post" name="accountinfo" id="" class="form-horizontal change-psw_form" autocomplete="off">
                    <div class="account-info-right-sidebar">
                        <div class="account-info-right-form">
                            <div class="col-lg-12 account-form-info">
                                <h1 class="right-top-heading"><i class="fa fa-key" aria-hidden="true"></i> Change Password </h1>
                                <div class="right-why-account-info-section">
                                    <?php if (count($success) > 0) { ?>
                                        <span class="success-msz">Updated Successfully</span>
                                    <?php } ?>
                                    <?php $this->load->view('inc-messages'); ?>
                                </div>
                            </div>
                            <div class="account-form-edit">
                                <div class="col-xs-12 col-sm-12 col-lg-12 col-input-xs cp">
                                    <div class="form-group row">
                                        <!-- <label for="inputid1" class="col-sm-12 form-control-label">Current Password:<span class="redstar">*</span> </label> -->
                                        <div class="col-sm-12 null-padding">
                                            <input class="form-control" id="inputid1" name="password" value="" type="password" placeholder="Current Password*">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <!-- <label for="cho_newpassword" class="col-sm-12 form-control-label">New Password:<span class="redstar">*</span></label> -->
                                        <div class="col-sm-12 null-padding">
                                            <input class="form-control" id="cho_newpassword" name="newpassword" value="" type="password" placeholder="new password*">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <!-- <label for="cho_confirmpassword" class="col-sm-12 form-control-label">Confirm New Password:<span class="redstar">*</span></label> -->
                                        <div class="col-sm-12 null-padding">
                                            <input class="form-control" id="cho_confirmpassword" name="confirmpassword" value="" type="password" placeholder="Confirm New Password*">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-xs-12 col-sm-12 col-lg-12 form-group-outer">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-sm-12 col-lg-12 am-sub-btn null-padding">
                                            <input type="submit" name="myaccount" class="btn btn-lg reset-btn one-half-width-btn button-color" value="Submit" width="71" height="32" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <!-- add content here -->
            <!--</div>-->
        </div>
    </div>
</section>