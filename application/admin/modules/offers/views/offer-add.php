<h3 class="title-hero clearfix">
    Add Offer
    <a href="offers" class="pull-right btn btn-primary">Manage Offers</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages');?>
        <form action="offers/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="alias" type="text" class="form-control" id="alias" value="<?php echo set_value('alias'); ?>" size="40">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Applicable from <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-prepend input-group">
                                    <span class="add-on input-group-addon">
                                        <i class="glyph-icon icon-calendar"></i>
                                    </span>
                                    <input name="start_on" type="text" class="bootstrap-datepicker form-control" value="<?php echo set_value('start_on'); ?>" data-date-format="yyyy-mm-dd">
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Applicable to <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-prepend input-group">
                                    <span class="add-on input-group-addon">
                                        <i class="glyph-icon icon-calendar"></i>
                                    </span>
                                    <input name="end_on" type="text" class="bootstrap-datepicker form-control" value="<?php echo set_value('end_on'); ?>" data-date-format="yyyy-mm-dd">
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Offer Banner </label>
                            <div class="col-sm-6">
                                <input type="file" name="banner" id="banner" class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Special Price</label>
                            <div class="col-sm-6">
                                <input name="price" type="text" class="form-control" id="price" value="<?php echo set_value('price'); ?>" size="40" placeholder="0.00">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="contents" style="width:99%" class="form-control" id="contents"><?php echo set_value('contents'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12" align="center">
                                <input name="image_v" type="hidden" id="image_v" value="1">
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
<script type="text/javascript">
    $(function () {
        "use strict";
        $('.bootstrap-datepicker').bsdatepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>