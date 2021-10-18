<?php //$this->load->view('headers/member_add');                          ?>
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
    <h2>Edit User</h2>
</div>

<div class="panel">
    <?php $this->load->view('inc-messages'); ?>
    <div class="panel-body">
        <div class="example-box-wrapper">
            <form action="user/edit/<?php echo $user['user_id']; ?>" class="form-horizontal bordered-row" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id']; ?>">
                <!--<input type="hidden" id="profile_id" name="profile_id" value="3">-->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Role</label>
                    <div class="col-sm-6">
                        <?php echo form_dropdown('role_id', $profilegroups, set_value('role_id', $user['role_id']), ' class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Firstname</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php echo set_value('firstname', $user['first_name']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php echo set_value('lastname', $user['last_name']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Company Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Company name" value="<?php echo set_value('companyname', $user['company_name']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo set_value('email', $user['email']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo set_value('username', $user['username']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="password" name="passwd" placeholder="Password" value="<?php echo $this->encrypt->decode($user['passwd']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Confirm Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="cpassword" name="passwd1" placeholder="Password" value="<?php echo $this->encrypt->decode($user['passwd']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <input class="btn btn-primary" value="Submit" type="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>