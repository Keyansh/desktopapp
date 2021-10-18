<h3 class="title-hero clearfix">
    Profile Group Config
    <a href="user/userprofile" class="pull-right btn btn-primary">Manage Profile Groups</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <input type="hidden" name="profile_id" value="<?= $profileid ?>" />
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">WEBSHOPPING<span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="configprofile[WEBSHOPPING]" id="is_active">
                                    <option value="">Select</option>
                                    <option value="1" <?php
                                    if (isset($data['WEBSHOPPING']) && $data['WEBSHOPPING'] == 1) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Yes</option>
                                    <option value="0" <?php
                                    if (isset($data['WEBSHOPPING']) && $data['WEBSHOPPING'] == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">ADMIN SHOPPING <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="configprofile[ADMINSHOPPING]" id="admin_shopping">
                                    <option value="">Select</option>
                                    <option value="1" <?php
                                    if (isset($data['ADMINSHOPPING']) && $data['ADMINSHOPPING'] == 1) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Yes</option>
                                    <option value="0" <?php
                                    if (isset($data['ADMINSHOPPING']) && $data['ADMINSHOPPING'] == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">CREDIT<span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="configprofile[CREDIT]" id="credit">
                                    <option value="">Select</option>
                                    <option value="1" <?php
                                    if (isset($data['CREDIT']) && $data['CREDIT'] == 1) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Yes</option>
                                    <option value="0" <?php
                                    if (isset($data['CREDIT']) && $data['CREDIT'] == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">MULTI LOGIN<span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="configprofile[MULTILOGIN]" id="multilogin">
                                    <option value="">Select</option>
                                    <option value="1" <?php
                                    if (isset($data['MULTILOGIN']) && $data['MULTILOGIN'] == 1) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Yes</option>
                                    <option value="0" <?php
                                    if (isset($data['MULTILOGIN']) && $data['MULTILOGIN'] == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">MULTIPLE DELIVERY ADDRESS<span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="configprofile[MULTIDELADDRESS]" id="deladdress">
                                    <option value="">Select</option>
                                    <option value="1" <?php
                                    if (isset($data['MULTIDELADDRESS']) && $data['MULTIDELADDRESS'] == 1) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Yes</option>
                                    <option value="0" <?php
                                    if (isset($data['MULTIDELADDRESS']) && $data['MULTIDELADDRESS'] == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">TIER PRICING<span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="configprofile[TIERPRICING]" id="tierpricing">
                                    <option value="">Select</option>
                                    <option value="1" <?php
                                    if (isset($data['TIERPRICING']) && $data['TIERPRICING'] == 1) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Yes</option>
                                    <option value="0" <?php
                                    if (isset($data['TIERPRICING']) && $data['TIERPRICING'] == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>