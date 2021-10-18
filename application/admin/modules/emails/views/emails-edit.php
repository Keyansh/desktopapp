<h3 class="title-hero clearfix">
    Edit Template "<?= $template['template_name']; ?>"
    <a href="emails" class="pull-right btn btn-primary">Manage Email Templates</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="emails/edit/<?= $template['id'] ?>" method="post" enctype="multipart/form-data" name="addform" id="addform">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Template Name <span class="error">*</span></label>
                            <div class="col-sm-5">
                                <input name="template_name" type="text" class="form-control" id="template_name" value="<?php echo set_value('template_name', $template['template_name']); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Template Alias </label>
                            <div class="col-sm-5">
                                <input name="template_alias" type="text" class="form-control" id="template_alias" value="<?php echo set_value('template_alias', $template['template_alias']); ?>" size="40" />
                                (Will be auto-generated if left blank)
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Body Contents <span class="error">*</span></label>
                            <div class="col-sm-10" style="display: table;">
                                <textarea name="contents" cols="37" rows="5" style="width:99%" class="form-control"id="contents"><?php echo set_value('contents', $template['body_content']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-6" style="text-align: center;">
                                Fields marked with <span class="error">*</span> are required.
                                <p style="padding-top: 10px;"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>