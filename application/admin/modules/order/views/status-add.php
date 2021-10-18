<h3 class="title-hero clearfix">
    Add Status
    <a href="order/orderstatus" class="pull-right btn btn-primary"><i class="fa fa-bars" aria-hidden="true"></i> Manage Order status</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="order/add_status" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Label <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="label" type="text" class="form-control" id="label" value="<?php echo set_value('label'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Active</label>
                            <div class="col-sm-6">
                                <select name="is_active" class="form-control" >
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
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