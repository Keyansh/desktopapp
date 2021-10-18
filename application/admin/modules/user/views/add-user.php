<?php //$this->load->view('headers/member_add');  ?>
<!-- Input switch -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/input-switch/inputswitch.css">-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/input-switch/inputswitch.js"></script>
<script type="text/javascript">
    /* Input switch */

    $(function () {
        "use strict";
        $('.input-switch').bootstrapSwitch();
    });
</script>

<div id="page-title">
    <h2>Add User</h2>
</div>

<div class="panel">
    <?php $this->load->view('inc-messages'); ?>
    <div class="panel-body">
        <div class="example-box-wrapper">
            <form action="user/add/" class="form-horizontal bordered-row" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                <input type="hidden" id="profile_id" name="profile_id" value="3">
<!--                <div class="form-group">
                    <label class="col-sm-3 control-label">Profile <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <?php //echo form_dropdown('profile_id', $profilegroups, set_value('profile_id'), ' class="form-control"'); ?>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Firstname <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php echo set_value('firstname'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php echo set_value('lastname'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Company Name <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Company name" value="<?php echo set_value('companyname'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Email <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Username <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Password <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="password" name="passwd" placeholder="Password" value="<?php echo set_value('passwd'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Confirm Password <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="cpassword" name="passwd1" placeholder="Password" value="<?php echo set_value('passwd1'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Address <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo set_value('address'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Address 2</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" value="<?php echo set_value('address2'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">City <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo set_value('city'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">County <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="county" name="county" placeholder="County" value="<?php echo set_value('county'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Country <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="country" name="country" placeholder="country" value="United kingdom">
                        <?php
//                        $countries = getCountries();
//                        $countries = array_column($countries, 'nicename');
//                        $countries = array_combine($countries, $countries);
//                        echo form_dropdown('country', $countries, '', ' class="form-control" ');
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label">Post code <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" value="<?php echo set_value('postcode'); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label">Phone <span class="error">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo set_value('phone'); ?>">
                    </div>
                </div>
                
<!--                <div class="form-group">
                    <label class="col-sm-3 control-label">Active</label>
                    <div class="col-sm-6">
                        <input type="checkbox" data-on-color="primary" name="active" class="input-switch" checked data-size="medium" data-on-text="Yes" data-off-text="No">
                    </div>
                </div> -->
                
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <input class="btn btn-primary" value="Submit" type="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
