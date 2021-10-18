<input type="hidden" name="subuserid" value="<?php echo $userdata['user_id']; ?>" />
<div class="example-box-wrapper">
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Firstname</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php echo $userdata['first_name']; ?>" >
            <span class="custerror"></span>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Lastname</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php echo $userdata['last_name']; ?>" >
            <span class="custerror"></span>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Designation</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="<?php echo $userdata['company_name']; ?>" >
            <span class="custerror"></span>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Email</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $userdata['email']; ?>" >
            <span class="custerror"></span>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Username</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $userdata['username']; ?>" >
            <span class="custerror"></span>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Password</label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password" value="<?php echo $this->encrypt->decode($userdata['passwd']); ?>" >
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Confirm Password</label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="passwd1" name="passwd1" placeholder="Password" value="<?php echo $this->encrypt->decode($userdata['passwd']); ?>">
            <span class="custerror"></span>
        </div>
    </div>
</div>