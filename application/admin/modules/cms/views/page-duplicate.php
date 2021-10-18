<h3 class="title-hero clearfix">
    Duplicate - "<?= $page_details['title']; ?>"
    <div class="pull-right">
        <a href="cms/page" class="btn btn-info" style="background: #094e91;">
            Manage Pages
        </a>
        <a href="cms/page/edit/<?php echo $page_details['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Edit Page
        </a>
        <a href="cms/block/index/<?php echo $page_details['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Manage Blocks
        </a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="cms/page/duplicate/<?php echo $page_details['page_id']; ?>" method="post" enctype="multipart/form-data" name="regFrm" id="regFrm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Page Title <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="title" id="title" class="form-control" value="<?php echo set_value('title'); ?>" size="45">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Page URI <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <input name="page_uri" type="text" class="form-control" id="page_uri"  value="<?php echo set_value('page_uri'); ?>" size="45">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Parent Page<span class="error">*</span></label>
                            <div class="col-sm-10">
                                <?php echo form_dropdown('parent_id', $parent, set_value('parent_id'), ' class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 text-center">
                                <input name="v_image" type="hidden" id="v_image" value="1" />
                                <input type="submit" name="button" id="button" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>