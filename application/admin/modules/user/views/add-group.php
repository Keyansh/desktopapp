<h3 class="title-hero clearfix">
    Add Profile Group
    <a href="user/userprofile" class="pull-right btn btn-primary">Manage Profile Groups</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Profile Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="profilename" type="text" id="profilename" size="40" class="form-control" value="<?= set_value('profilename'); ?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Status <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="is_active" id="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">De-Active</option>
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