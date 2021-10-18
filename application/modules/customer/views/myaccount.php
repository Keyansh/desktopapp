<style>
    
</style>
<section id="single_product_col">
    <div class="container-fluid site-container null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">My account</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="bg-light-gray" id="portfolio">
    <div class="container-fluid site-container">
        <div class="middle-container dashboard col-xs-12 col-sm-12 col-lg-12" id="middle-content-section">
            <!--    <div class="row">-->
            <?php $this->load->view('navigation'); ?>
            <div class="col-xs-12 col-sm-9 col-lg-9 dash-inn-right">
                <form action="customer/myaccount" class="form-horizontal form-font" method="post" name="accountinfo" id="accountinfo" autocomplete="off">
                    <div class="account-info-right-sidebar">
                        <div class="account-info-right-form">
                            <div class="col-lg-12 account-form-info">
                                <h1 class="right-top-heading"><i class="fa fa-file-text-o" aria-hidden="true"></i> Account info </h1>
                                <div class="right-why-account-info-section">
                                    <?php if (count($success) > 0) { ?>
                                        <span class="success-msz">Updated Successfully</span>
                                    <?php } ?>
                                    <?php $this->load->view('inc-messages'); ?>
                                </div>
                            </div>
                            <div class="account-form-edit">
                                <div class="col-xs-12 col-sm-6 col-lg-6 col-input-xs js null-padding">
                                    <h3 class="account-top-form-heading">Your details: </h3>
                                    <div class="form-group row">
                                        <!-- <label for="my_email" class="col-sm-12 form-control-label">Email Address:<span class="redstar">*</span> </label> -->
                                        <div class="col-sm-12 account_input">
                                            <input class="form-control" id="my_email" name="email" placeholder="Email Address*" value="<?php echo set_value('email', $customer['email']); ?>" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <!-- <label for="my_first_name" class="col-sm-12 form-control-label">First Name:<span class="redstar">*</span></label> -->
                                        <div class="col-sm-12 account_input">
                                            <input class="form-control" id="my_first_name" name="first_name" placeholder="First Name*" value="<?php echo set_value('first_name', $customer['first_name']); ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <!-- <label for="my_last_name" class="col-sm-12 form-control-label">Last Name:<span class="redstar">*</span></label> -->
                                        <div class="col-sm-12 account_input">
                                            <input class="form-control" id="my_last_name" placeholder="Last Name*"  name="last_name" value="<?php echo set_value('last_name', $customer['last_name']); ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <!-- <label for="my_phone" class="col-sm-12 form-control-label">Phone number:<span class="redstar">*</span></label> -->
                                        <div class="col-sm-12 account_input">
                                            <input class="form-control" id="my_phone" placeholder="Phone number*"  name="phone" value="<?php echo set_value('phone', $customer['phone']); ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-6 col-input-xs jk null-padding">
                                    <h3 class="account-top-form-heading">Delivery address: </h3>
                                    <div class="form-group row">
                                        <!-- <label for="my_address1" class="col-sm-12 form-control-label">Address:<span class="redstar">*</span></label> -->
                                        <div class="col-sm-12 account_input">
                                            <input class="form-control" id="my_address1" placeholder="Address*"  name="address1" value="<?php echo set_value('address1', $customer['uadd_address_01']); ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <!-- <label for="my_address2" class="col-sm-3 form-control-label">Address2:</label> -->
                                        <div class="col-sm-12 account_input">
                                            <input class="form-control" id="my_address2" placeholder="Address2*"  name="address2" value="<?php echo set_value('address2', $customer['uadd_address_02']); ?>" type="text">
                                        </div>
                                    </div>
                                    <?php /* <div class="form-group row">
                                      <label for="inputid5" class="col-sm-3 form-control-label"> County</label>
                                      <div class="col-sm-12">
                                      <input class="form-control" id="state" name="state" value="<?php echo set_value('state',$customer['uadd_county']); ?>" type="text">
                                      </div>
                                      </div> */ ?>

                                    <div class="form-group row" id="account-form-multi-field">
                                        <!-- <label class="col-lg-12 form-control-label"> City/ Postcode:<span class="redstar">*</span></label> -->
                                        <div class="col-sm-6 am-input-left account_input">
                                            <input class="form-control" id="my_city" placeholder="City"  name="city" value="<?php echo set_value('city', $customer['uadd_city']); ?>" type="text">
                                        </div>
                                        <div class="col-sm-6 am-input-right account_input">
                                            <input class="form-control" id="my_zip" name="zipcode" placeholder="Postcode*" value="<?php echo set_value('zipcode', $customer['uadd_post_code']); ?>">
                                        </div>
                                        <div class="col-sm-12 am-input-left account_input">
                                            <div class="col-xs-am-12 am-sub-btn">
                                                <input style="background:#ff6c00;" type="submit" placeholder=""  name="myaccount" class="btn btn-lg reset-btn one-half-width-btn" value="Update" width="71" height="32" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-xs-12 col-sm-12 col-lg-12 form-group-outer null-padding">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-sm-12 col-lg-12 am-sub-btn">
                                            <input style="background:#ff6c00;" type="submit" placeholder=""  name="myaccount" class="btn btn-lg reset-btn one-half-width-btn" value="Update" width="71" height="32" />
                                        </div>
                                    </div>
                                </div> -->
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