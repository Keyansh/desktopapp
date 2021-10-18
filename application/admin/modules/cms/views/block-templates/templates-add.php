<h3 class="title-hero clearfix">
    Add Block Template
    <a href="cms/block_template" class="pull-right btn btn-primary">Manage Block Template</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="cms/block_template/add/" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Template Name <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="template_name" id="template_name" class="form-control" size="40" value="<?php echo set_value('template_name'); ?>" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Template Alias</label>
                            <div class="col-sm-10">
                                <input type="text" name="template_alias" id="template_alias" class="form-control" size="40" value="<?php echo set_value('template_alias'); ?>" />
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Template <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <textarea name="template_contents" cols="0" rows="50" style="width:90%" class="form-control" id="template_contents"><?php echo set_value('template_contents'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12" align="center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input type="submit" name="button" class="btn btn-primary" id="button" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>